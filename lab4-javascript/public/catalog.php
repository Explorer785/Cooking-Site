<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/src/functions.php';
$recipes = require dirname(__DIR__) . '/src/recipes.php';
$ingredient = trim((string)($_GET['ingredient'] ?? ''));
$ingredient = text_limit($ingredient, 80);
$matches = find_recipes_by_ingredient($recipes, $ingredient);
$activePage = 'catalog';
$pageTitle = 'Рецепты — Готовь вкусно!';
require __DIR__ . '/includes/header.php';
?>
<main class="wrap">
    <section class="page-hero">
        <div class="eyebrow">Каталог</div>
        <h1>Рецепты на каждый день</h1>
        <p>
            Завтраки, обеды и ужины из доступных продуктов.
            Введите ингредиент, чтобы найти подходящие блюда,
            или выберите карточку для просмотра полного рецепта.
        </p>
    </section>

    <form class="search-box" action="catalog.php" method="get" style="margin:10px 0 25px;">
        <input
            type="search"
            name="ingredient"
            value="<?= e($ingredient) ?>"
            maxlength="80"
            aria-label="Поиск по ингредиенту"
            placeholder="Например, яйца, томаты, курица..."
        >
        <button class="btn" type="submit">Найти рецепты</button>
    </form>

    <p class="search-note" style="margin-bottom:20px;">
        Примеры поиска:
        <a class="text-link" href="catalog.php?ingredient=яйца">яйца</a>,
        <a class="text-link" href="catalog.php?ingredient=томаты">томаты</a>,
        <a class="text-link" href="catalog.php?ingredient=курица">курица</a>,
        <a class="text-link" href="catalog.php?ingredient=творог">творог</a>.
    </p>

    <div class="section-head">
        <div>
            <div class="eyebrow"><?= $ingredient === '' ? 'Каталог блюд' : 'Результаты поиска' ?></div>
            <h2 class="search-query">
                <?php if ($ingredient === ''): ?>
                    Что приготовить сегодня?
                <?php else: ?>
                    По запросу «<?= e($ingredient) ?>»
                <?php endif; ?>
            </h2>
            <p class="search-summary"><?= e(recipe_count_label(count($matches))) ?> в каталоге.</p>
        </div>
        <?php if ($ingredient !== ''): ?>
            <a class="text-link" href="catalog.php">Показать все рецепты</a>
        <?php endif; ?>
    </div>

    <?php if ($matches): ?>
        <div class="recipe-grid" id="recipes">
            <?php foreach ($matches as $recipe): ?>
                <?php $anchorId = $recipe['anchor']; require __DIR__ . '/includes/recipe-card.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <h3>По такому ингредиенту ничего не найдено</h3>
            <p class="muted">
                Попробуйте другое слово: «яйца», «томаты», «курица» или «творог».
            </p>
            <a class="btn" href="catalog.php">Показать все рецепты</a>
        </div>
    <?php endif; ?>

    <section style="padding:45px 0 70px;">
        <div class="note-box">
            Поиск выполняется на PHP по названию блюда, описанию и списку ингредиентов.
            Для блюд, у которых фотография ещё не добавлена, предусмотрено пустое место.
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
