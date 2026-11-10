<?php
$activePage = $activePage ?? '';
$pageTitle = $pageTitle ?? 'Готовь вкусно!';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Подборка домашних рецептов и поиск блюд по ингредиентам.">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="site-header">
    <div class="wrap nav">
        <a class="brand" href="index.php">Готовь вкусно!</a>
        <nav class="nav-links">
            <a href="index.php" class="<?= $activePage === 'home' ? 'active' : '' ?>">Главная</a>
            <a href="catalog.php" class="<?= $activePage === 'catalog' ? 'active' : '' ?>">Рецепты</a>
            <a href="about.php" class="<?= $activePage === 'about' ? 'active' : '' ?>">О проекте</a>
            <a href="guestbook.php" class="<?= $activePage === 'guestbook' ? 'active' : '' ?>">Гостевая книга</a>
        </nav>
        <a class="nav-cta" href="catalog.php">Найти идею <span aria-hidden="true">↗</span></a>
    </div>
</header>
