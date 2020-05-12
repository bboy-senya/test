<?php include ROOT.'/views/layouts/header.php'; ?>

	<!-- Begin page content -->
	<main role="main" class="flex-shrink-0">
		<div class="container" style="padding-top: 80px;">
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <?php if(isset($errors) && is_array($errors)): ?>
                        <ul>
                            <?php foreach($errors as $error): ?>
                                <li>- <?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <form action="" method="post">
                        <div class="form-group">
                            <label for="login">Логин</label>
                            <input type="text" name="login" class="form-control" id="login" placeholder="Введите логин" value="<?php echo $login; ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Введите пароль" value="">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Войти</button>
                    </form>
                </div>
            </div>
            
		</div>
	</main>

<?php include ROOT.'/views/layouts/footer.php'; ?>