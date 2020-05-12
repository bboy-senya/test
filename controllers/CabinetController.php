<?php

/**
 * Контроллер CabinetController
 * Кабинет администратора
 */
class CabinetController extends AdminBase
{

    /**
     * Action для страницы "Кабинет"
     */
    public function actionIndex($page = 1)
    {

        // Проверка доступа
        self::checkAdmin();

        $tasksList = array();
        $tasksList = Tasks::getTasks($page);
        
        // Общее количетсво задач (необходимо для постраничной навигации)
		$total = Tasks::getTotalTasks();
		
		// Создаем объект Pagination - постраничная навигация
        $pagination = new Pagination($total, $page, Tasks::SHOW_BY_DEFAULT, 'page-');
        
        $text = '';
        $status = '';

        // Флаг результата
        $result = false;

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы редактирования
            $text = $_POST['task'];
            $status = $_POST['status'];
            $id = $_POST['id'];

            // Флаг ошибок
            $errors = false;

            if (!User::checkTask($text)) {
                $errors[] = 'Поле задачи не должно быть пустым !';
            }

            if ($errors == false) {
                // Если ошибок нет, сохраняет изменения задачи
                $result = Tasks::updateTaskById($id, $text, $status);

                $referer = $_SERVER['HTTP_REFERER'];

                header("Location: $referer");

            }
        }

        // Подключаем вид
        require_once(ROOT . '/views/cabinet/index.php');
        return true;
    }

}