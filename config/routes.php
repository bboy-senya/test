<?php

return array(
	// Админпанель
	'cabinet/page-([0-9]+)' => 'cabinet/index/$1',
	'cabinet' => 'cabinet/index',
	'logout' => 'admin/logout',
    'login' => 'admin/login',
	// Главная страница
	'page-([0-9]+)' => 'site/index/$1',
    'index.php' => 'site/index', // actionIndex в SiteController
	'' => 'site/index', // indexView & SiteController
);