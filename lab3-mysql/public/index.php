<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/src/functions.php';
$recipes = require dirname(__DIR__) . '/src/recipes.php';
$activePage = 'home';
$pageTitle = 'Готовь вкусно! — рецепты на каждый день';
require __DIR__ . '/includes/header.php';
?>
<main>
    <!-- Главный экран сохраняет композицию первой лабораторной. -->
    <section class="wrap hero">
        <div>
            <div class="eyebrow">Вдохновение на вашей кухне</div>
            <h1>Вкусные идеи<br>из того, что <em>есть.</em></h1>
            <p class="hero-copy">
                Подборка понятных домашних рецептов — от быстрого завтрака
                до уютного ужина. Выбирайте блюдо, изучайте ингредиенты
                и готовьте в своём ритме.
            </p>
            <form class="search-box" action="catalog.php" method="get">
                <input
                    type="search"
                    name="ingredient"
                    aria-label="Ингредиент"
                    placeholder="Например, яйца, томаты, курица..."
                    maxlength="80"
                >
                <button class="btn" type="submit">Искать рецепты</button>
            </form>
            <p class="search-note">
                Попробуйте:
                <a class="text-link" href="catalog.php?ingredient=яйца">яйца</a>,
                <a class="text-link" href="catalog.php?ingredient=томаты">томаты</a>,
                <a class="text-link" href="catalog.php?ingredient=курица">курица</a>.
            </p>
        </div>
    </section>

    <section class="wrap section">
        <div class="section-head">
            <div>
                <div class="eyebrow">Выбор редакции</div>
                <h2>Что приготовить сегодня?</h2>
                <p class="muted">Небольшая коллекция проверенных идей на каждый день.</p>
            </div>
            <a class="text-link" href="catalog.php">Все рецепты</a>
        </div>

        <div class="recipe-grid">
            <?php foreach (['pasta', 'syrniki', 'soup'] as $recipeId): ?>
                <?php $recipe = $recipes[$recipeId]; require __DIR__ . '/includes/recipe-card.php'; ?>
            <?php endforeach; ?>
        </div>

        <div class="section-head" style="margin-top:55px">
            <div>
                <div class="eyebrow">По настроению</div>
                <h2>Что ищем сегодня?</h2>
            </div>
        </div>
        <div class="category-row">
            <a class="category" href="catalog.php#breakfast">Завтраки</a>
            <a class="category" href="catalog.php#lunch">Обеды</a>
            <a class="category" href="catalog.php#dinner">Ужины</a>
            <a class="category" href="catalog.php#dessert">Десерты</a>
        </div>
    </section>

    <section class="wrap">
        <div class="banner">
            <div>
                <h2>Готовка — это маленькое приключение.</h2>
                <p>Начните с простого рецепта и добавьте свой вкус.</p>
            </div>
            <a class="btn" href="catalog.php">Выбрать рецепт</a>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
