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

                <?php $baseServings = (int)($recipe['base_servings'] ?? 2); ?>
                <section class="servings-calculator"
                         data-servings-calculator
                         data-base-servings="<?= $baseServings ?>"
                         data-min-servings="1"
                         data-max-servings="12"
                         aria-label="Калькулятор количества порций">
                    <div class="servings-calculator-text">
                        <strong>Калькулятор порций</strong>
                        <span>Измените количество порций — ингредиенты пересчитаются автоматически.</span>
                    </div>
                    <div class="servings-controls">
                        <button class="servings-button" type="button" data-servings-step="-1" aria-label="Уменьшить количество порций">−</button>
                        <output class="servings-value" data-servings-value aria-live="polite"><?= $baseServings ?></output>
                        <button class="servings-button" type="button" data-servings-step="1" aria-label="Увеличить количество порций">+</button>
                        <span class="servings-label">порц.</span>
                        <button class="servings-reset" type="button" data-servings-reset>Сбросить</button>
                    </div>
                </section>

                <h2>Ингредиенты</h2>
                <ul class="ingredient-list" data-ingredient-list>
                    <?php if (!empty($recipe['ingredients_data'])): ?>
                        <?php foreach ($recipe['ingredients_data'] as $ingredient): ?>
                            <li
                                <?php if ($ingredient['amount'] !== null): ?>
                                    data-scalable-ingredient
                                    data-base-amount="<?= e((string)$ingredient['amount']) ?>"
                                <?php endif; ?>
                            >
                                <?php if ($ingredient['amount'] !== null): ?>
                                    <span data-ingredient-amount><?= e(format_ingredient_amount((float)$ingredient['amount'])) ?></span>
                                    <?= e($ingredient['unit']) ?> — <?= e($ingredient['name']) ?>
                                <?php else: ?>
                                    <?= e($ingredient['name']) ?> — <?= e($ingredient['unit']) ?>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php foreach ($recipe['quantities'] as $quantity): ?>
                            <li><?= e($quantity) ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
