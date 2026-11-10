<?php
declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/src/functions.php';
$recipes = $recipes ?? require dirname(__DIR__, 2) . '/src/recipes.php';
$recipeId = $recipeId ?? trim((string)($_GET['id'] ?? ''));
$recipe = $recipes[$recipeId] ?? null;
if ($recipe === null) {
    http_response_code(404);
}
$activePage = 'catalog';
$pageTitle = $recipe ? $recipe['name'] . ' — Готовь вкусно!' : 'Рецепт не найден — Готовь вкусно!';
require __DIR__ . '/header.php';
?>
<main class="wrap">
    <?php if ($recipe === null): ?>
        <section class="page-hero">
            <div class="eyebrow">Ошибка 404</div>
            <h1>Рецепт не найден</h1>
            <p>Такого рецепта нет в каталоге. Вернитесь к списку блюд и выберите другой.</p>
            <a class="btn" href="catalog.php">Вернуться к рецептам</a>
        </section>
    <?php else: ?>
        <section class="page-hero">
            <div class="eyebrow">Рецепт · <?= e($recipe['difficulty']) ?></div>
            <h1><?= e($recipe['name']) ?></h1>
            <p><?= e($recipe['description']) ?></p>
        </section>

        <section class="recipe-detail">
            <div class="detail-art recipe-visual <?= e($recipe['style']) ?><?= $recipe['image'] === '' ? ' is-empty' : '' ?>">
                <?php if ($recipe['image'] !== ''): ?>
                    <img class="food-image" src="<?= e($recipe['image']) ?>" alt="<?= e($recipe['name']) ?>">
                <?php endif; ?>
            </div>

            <div class="detail-copy">
                <div class="detail-stats">
                    <span class="stat"><strong><?= e($recipe['time']) ?></strong></span>
                    <span class="stat"><strong><?= e($recipe['difficulty']) ?></strong></span>
                    <span class="stat"><?= e($recipe['category']) ?></span>
                </div>

                <h2>Ингредиенты</h2>
                <ul class="ingredient-list">
                    <?php foreach ($recipe['quantities'] as $quantity): ?>
                        <li><?= e($quantity) ?></li>
                    <?php endforeach; ?>
                </ul>

                <h2>Как приготовить</h2>
                <ol class="steps">
                    <?php foreach ($recipe['steps'] as $step): ?>
                        <li><?= e($step) ?></li>
                    <?php endforeach; ?>
                </ol>

                <p><a class="btn" href="catalog.php">← Вернуться к рецептам</a></p>
            </div>
        </section>
    <?php endif; ?>
</main>
<?php require __DIR__ . '/footer.php'; ?>
