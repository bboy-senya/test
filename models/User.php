  
<?php

/**
 * Класс User - модель для работы с пользователями
 */
class User
{

    /**
     * Проверяет имя: не меньше, чем 2 символа
     * @param string $name <p>Имя</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkName($name)
    {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }


    /**
     * Проверяет email
     * @param string $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    
    /**
     * Проверяет текст задачи
     * @param string $text <p>текст задачи</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkTask($text)
    {
        if ($text != '') {
            return true;
        }
        return false;
    }


    /**
     * Проверяет login
     * @param string $login <p>Логин</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkLogin($login)
    {
        if (filter_var($login, FILTER_SANITIZE_STRING)) {
            return true;
        }
        return false;
    }


    /**
     * Проверяет пароль: не меньше, чем 3 символов
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkPassword($password)
    {
        if (strlen($password) >= 3) {
            return true;
        }
        return false;
    }


    /**
     * Проверяет есть ли пользователь с таким email
     * @param type $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkEmailExists($email)
    {
        // Соединение с БД        
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT * FROM users WHERE email = :email';

        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result == true) {
            $row = $result->fetch();
            return $row['id'];
        }
            
        return false;
    }


    /**
     * Проверяем существует ли пользователь с заданными $login и $password и есть ли у него права administrator
     * @param string $login <p>Логин</p>
     * @param string $password <p>Пароль</p>
     * @return mixed : integer user id or false
     */
    public static function checkUserData($login, $password)
    {
        // Соединение с БД
        $db = Db::getConnection();

        $role = 'administrator';

        // Текст запроса к БД
        $sql = 'SELECT * FROM users WHERE login = :login AND password = :password AND role = :role';

        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->bindParam(':role', $role, PDO::PARAM_STR);
        $result->execute();

        // Обращаемся к записи
        $user = $result->fetch();

        if ($user) {
            // Если запись существует, возвращаем id пользователя
            return $user['id'];
        }
        
        return false;
        
    }


    /**
     * Запоминаем пользователя
     * @param integer $userId <p>id пользователя</p>
     */
    public static function auth($userId)
    {

        // Записываем идентификатор пользователя в сессию
        $_SESSION['user'] = $userId;
    }


    /**
     * Возвращает идентификатор пользователя, если он авторизирован.<br/>
     * Иначе перенаправляет на страницу входа
     * @return string <p>Идентификатор пользователя</p>
     */
    public static function checkLogged()
    {

        // Если сессия есть, вернем идентификатор пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        return false;
        
    }

    

    /**
     * Возвращает пользователя с указанным id
     * @param integer $id <p>id пользователя</p>
     * @return array <p>Массив с информацией о пользователе</p>
     */
    public static function getUserById($id)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT * FROM users WHERE id = :id';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        // Указываем, что хотим получить данные в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }


    /**
     * Проверяет является ли пользователь гостем
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }
}