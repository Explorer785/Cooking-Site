<?php
/** Ожидает переменные $recipe и необязательную $anchorId. */
$anchorId = $anchorId ?? ($recipe['anchor'] ?? '');
$imageClass = $recipe['image'] === '' ? ' is-empty' : '';
?>
<a class="recipe-card" href="<?= e(recipe_url($recipe)) ?>"<?= $anchorId !== '' ? ' id="' . e($anchorId) . '"' : '' ?>>
    <div class="recipe-visual <?= e($recipe['style']) ?><?= $imageClass ?>">
        <?php if ($recipe['image'] !== ''): ?>
            <img class="food-image" src="<?= e($recipe['image']) ?>" alt="<?= e($recipe['name']) ?>">
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="meta">
            <span><?= e($recipe['time']) ?></span>
            <span><?= e($recipe['difficulty']) ?></span>
        </div>
        <h3><?= e($recipe['name']) ?></h3>
        <p><?= e($recipe['description']) ?></p>
        <div class="pills">
            <span class="pill"><?= e($recipe['category']) ?></span>
            <?php foreach (array_slice($recipe['ingredients'], 0, 2) as $ingredientLabel): ?>
                <span class="pill"><?= e($ingredientLabel) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</a>
