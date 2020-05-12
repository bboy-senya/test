<?php

/**
 * Контроллер AdminController
 * Страница входа в панель администратора
 */
class AdminController
{

    /**
     * Action для страницы "Вход на сайт"
     */
    public function actionLogin()
    {
        // Проверяем авторизирован ли пользователь. Если нет, он будет переадресован
        $userId = User::checkLogged();

        if ($userId) {
            header("Location: /cabinet");
        }

        // Переменные для формы
        $login = false;
        $password = false;
        
        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена 
            // Получаем данные из формы
            $login = $_POST['login'];
            $password = $_POST['password'];

            // Флаг ошибок
            $errors = false;

            // Валидация полей
            if (!User::checkLogin($login)) {
                $errors[] = 'Неправильный логин';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 3-х символов';
            }

            // Проверяем существует ли пользователь
            $userId = User::checkUserData($login, $password);  

            if ($userId == false) {
                // Если данные неправильные - показываем ошибку
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {
                // Если данные правильные, запоминаем пользователя (сессия)
                User::auth($userId);

                // Перенаправляем пользователя в закрытую часть - кабинет 
                header("Location: /cabinet");
            }
        }

        // Подключаем вид
        require_once(ROOT . '/views/site/login.php');
        return true;
    }

    /**
     * Удаляем данные о пользователе из сессии
     */
    public function actionLogout()
    {
        
        // Удаляем информацию о пользователе из сессии
        unset($_SESSION["user"]);
        
        // Перенаправляем пользователя на главную страницу
        header("Location: /");
    }

}