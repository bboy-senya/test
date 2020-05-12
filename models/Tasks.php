<?php

	/**
	 * Класс Tasks - модель для работы с задачами
	 */

class Tasks {

    // Количество отображаемых задач по умолчанию
    const SHOW_BY_DEFAULT = 3;

	/**
     * Возвращает массив всех задач
     */
    public static function getTasks($page = 1)
	{
        $limit = Tasks::SHOW_BY_DEFAULT;

        // Смещение (для запроса)
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

		// Соединение с БД
		$db = Db::getConnection();
        
        $sql = "SELECT tasks.text, tasks.id_user, tasks.id, tasks.status, users.name as users_name, users.email as users_email FROM tasks 
                INNER JOIN users ON tasks.id_user = users.id LIMIT :limit OFFSET :offset";

        $result = $db->prepare($sql);
        $result->bindParam(':limit', $limit, PDO::PARAM_INT);
        $result->bindParam(':offset', $offset, PDO::PARAM_INT);
        $result->execute();
        $tasksList = array();
        // Получение и возврат результатов
        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $tasksList[$i]['id'] = $row['id'];
            $tasksList[$i]['id_user'] = $row['id_user'];
            $tasksList[$i]['name'] = $row['users_name'];
            $tasksList[$i]['email'] = $row['users_email'];
            $tasksList[$i]['text'] = $row['text'];
            $tasksList[$i]['status'] = $row['status'];
            $i++;
        }
  
        return $tasksList;
    }

     /**
     * Изменяет текст задачи по ID
     */
    public static function updateTaskById($id, $text, $status)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = "UPDATE tasks SET text = :text, status = :status WHERE id = :id";

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        $result->bindParam(':text', $text, PDO::PARAM_STR);

        // Указываем, что хотим получить данные в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }
    
    /**
     * Возвращаем количество задач
     */
    public static function getTotalTasks()
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT count(id) AS count FROM tasks';

        // Используется подготовленный запрос
        $result = $db->prepare($sql);

        // Выполнение коменды
        $result->execute();

        // Возвращаем значение count - количество
        $row = $result->fetch();
        return $row['count'];
    }

    /**
     * Добавление задачи новым пользователем 
     * @param string $name <p>Имя</p>
     * @param string $email <p>E-mail</p>
     * @param string $task <p>Текст задачи</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function addTaskNewUser($name, $email, $task)
    {

        // Соединение с БД
        $db = Db::getConnection();

        try {  
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
            $db->beginTransaction();

            $sql = 'INSERT INTO users (name, email) VALUES (:name, :email)';
            $result = $db->prepare($sql);
            $result->bindParam(':name', $name, PDO::PARAM_STR);
            $result->bindParam(':email', $email, PDO::PARAM_STR);
            $result->execute();

            $user_id = $db->lastInsertId();

            $sql = 'INSERT INTO tasks (text, id_user) VALUES (:text, :id)';
            $result = $db->prepare($sql);
            $result->bindParam(':text', $task, PDO::PARAM_STR);
            $result->bindParam(':id', $user_id, PDO::PARAM_INT);
            $result->execute();

            $db->commit();

            return true;
            
          } catch (Exception $e) {
            $db->rollBack();
            echo "Ошибка: " . $e->getMessage();
            exit;
          }
    }

    /**
     * Добавление задачи существующим пользователем 
     * @param string $task <p>Текст задачи</p>
     * @param string $user_id <p>ID пользователя из базы</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function addTaskOldUser($task, $user_id)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = 'INSERT INTO tasks (text, id_user) VALUES (:text, :id)';
        $result = $db->prepare($sql);
        $result->bindParam(':text', $task, PDO::PARAM_STR);
        $result->bindParam(':id', $user_id, PDO::PARAM_INT);
        $result->execute();

        return true;
    }
}