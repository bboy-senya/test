<?php

class SiteController
{
	public function actionIndex($page = 1)
	{

		$tasksList = array();
		$tasksList = Tasks::getTasks($page);

		// Общее количетсво задач (необходимо для постраничной навигации)
		$total = Tasks::getTotalTasks();
		
		// Создаем объект Pagination - постраничная навигация
		$pagination = new Pagination($total, $page, Tasks::SHOW_BY_DEFAULT, 'page-');

		// Переменные для формы
        $name = '';
        $email = '';
		$task = '';
		
		$result = false;

		// Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена 
            // Получаем данные из формы
            $name = $_POST['name'];
            $email = $_POST['email'];
			$task = htmlspecialchars($_POST['task']);

			$errors = false;
			
			// Валидация полей
            if (!User::checkName($name)) {
                $errors[] = 'Имя не долно быть короче 2-х символов !';
            }

            if (!User::checkEmail($email)) {
                $errors[] = 'Не валидный email !';
            }

            if (!User::checkTask($task)) {
                $errors[] = 'Поле задачи не должно быть пустым !';
            }
			
			if ($errors == false) {

				$existUserId = false;

				$existUserId = User::checkEmailExists($email);

				if (!empty($existUserId)) {
					$result = Tasks::addTaskOldUser($task, $existUserId);
				}else{
					$result = Tasks::addTaskNewUser($name, $email, $task);
				}

			}

		}

		require_once(ROOT.'/views/site/index.php');

		return true;
	}
}