<?php

/**
 * Абстрактный класс AdminBase содержит общую логику для контроллеров, которые 
 * используются в панели администратора
 */
abstract class AdminBase
{

    /**
     * Метод, который проверяет пользователя на то, является ли он администратором
     * @return boolean
     */

    public static function checkAdmin()
    {
        // Проверяем авторизирован ли пользователь. Если нет, он будет переадресован
        $userId = User::checkLogged();

        if ($userId == false) {
            header("Location: /login");
        }

        // Получаем информацию о текущем пользователе
        $user = User::getUserById($userId);

        // Если роль текущего пользователя "administrator", пускаем его в админпанель
        if ($user['role'] == 'administrator') {
            return true;
        }

        // Иначе завершаем работу с сообщением об закрытом доступе
        die('Access denied');
    }

}