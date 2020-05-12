<?php include ROOT.'/views/layouts/header.php'; ?>

	<!-- Begin page content -->
	<main role="main" class="flex-shrink-0">
		<div class="container" style="padding-top: 80px;">

            <?php if(isset($errors) && is_array($errors)): ?>
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li>- <?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php foreach($tasksList as $taskItem): ?>
                <div class="list-group-item list-group-item-action flex-column align-items-start">
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $taskItem['id']; ?>">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-2"><?php echo $taskItem['name']; ?></h5>
                            <div class="form-group">
                                <label style="color: green;" for="new_stat">Новая</label>
                                <input id="new_stat" type="radio" name="status" value="0" <?php if($taskItem['status'] == 0) echo "checked" ?> >
                                <label style="color: red;" for="performed">Выполнено</label>
                                <input id="performed" type="radio" name="status" value='1' <?php if($taskItem['status'] == 1) echo "checked" ?> >
                            </div>
                        </div>
                        <h6 class="mb-2"><?php echo $taskItem['email']; ?></h6>
                        <div class="form-group">
                            <input class="form-control" type="text" name="task" class="mb-1" value="<?php echo $taskItem['text']; ?>">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary pull-right">Сохранить изменения</button>
                    </form>
                </div>
            <?php endforeach; ?>

            <?php echo $pagination->get(); ?>

		</div>
	</main>

<?php include ROOT.'/views/layouts/footer.php'; ?>