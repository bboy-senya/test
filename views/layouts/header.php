<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="/template/css/bootstrap.min.css" >
	<title>TestTask</title>
</head>
<body class="d-flex flex-column h-100">
	<header>
	<!-- Fixed navbar -->
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
			<a href="/" class="navbar-brand">Тестовое задание</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a href="/" class="nav-link">Главная</a>
					</li>

					<?php if(User::isGuest()) :?>

						<li class="nav-item">
							<a href="/login" class="nav-link">Автроизация</a>
						</li>

					<?php else: ?>
						<?php if(!preg_match("~^/cabinet~", $_SERVER['REQUEST_URI'])): ?>
							<li class="nav-item">
								<a href="/cabinet" class="nav-link">Панель администратора</a>
							</li>
						<?php endif;?>
						<li class="nav-item">
							<a href="/logout" class="nav-link">Выход</a>
						</li>
					<?php endif;?>
				</ul>
			</div>
		</nav>
	</header>
