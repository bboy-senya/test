<?php include ROOT.'/views/layouts/header.php'; ?>

	<!-- Begin page content -->
	<main role="main" class="flex-shrink-0">
		<div class="container" style="padding-top: 80px;">
			<div class="row">
				<div class="col-md-8">

					<?php foreach($tasksList as $taskItem): ?>
						<div class="list-group-item list-group-item-action flex-column align-items-start">
							<div class="d-flex w-100 justify-content-between">
								<h5 class="mb-1"><?php echo $taskItem['name']; ?></h5>
								<?php if($taskItem['status']): ?>
									<small style="color: red;">Выполнено</small>
								<?php else: ?>
									<small style="color: green;">Новая</small>
								<?php endif;?>
							</div>
							<h6 class="mb-1"><?php echo $taskItem['email']; ?></h6>
							<p class="mb-1"><?php echo $taskItem['text']; ?></p>
						</div>
					<?php endforeach; ?>

					<?php echo $pagination->get(); ?>

				</div>
				<div class="col-md-4">

					<?php if($result): ?>
						<p>Задача добавлена на сайт!</p>
					<?php endif; ?>

					<?php if(isset($errors) && is_array($errors)): ?>
						<ul>
							<?php foreach($errors as $error): ?>
								<li>- <?php echo $error; ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				
					<form id="home_form" action="" method="post" novalidate>
						<div class="form-group">
							<label for="name">Имя</label>
							<input type="text" name="name" class="form-control" id="name" placeholder="Введите ваше имя" value="<?php if(!$result) echo $name; ?>">
						</div>
						<div class="form-group">
							<label for="email">Email адрес</label>
							<input type="email" name="email" class="form-control" id="email" placeholder="Введите ваш email" value="<?php if(!$result) echo $email; ?>">
						</div>
						<div class="form-group">
							<label for="task">Текст задачи</label>
							<textarea class="form-control" name="task" id="task" cols="30" rows="4" placeholder="Введите текст задачи"><?php if(!$result) echo $task; ?></textarea>
						</div>
						<button id="submit" type="submit" name="submit" class="btn btn-primary">Добавить</button>
					</form>
					
				</div>
			</div>
		</div>
	</main>

<?php include ROOT.'/views/layouts/footer.php'; ?>