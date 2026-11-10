<?php

declare(strict_types=1);

/** Безопасный вывод текста в HTML. */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Ограничивает длину строки с учётом UTF-8, если доступно расширение mbstring. */
function text_length(string $value): int
{
    return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
}

function text_limit(string $value, int $limit): string
{
    if (function_exists('mb_substr')) {
        return mb_substr($value, 0, $limit, 'UTF-8');
    }
    return substr($value, 0, $limit);
}

/** Проверяет вхождение запроса без учёта регистра, когда это возможно. */
function text_contains(string $text, string $query): bool
{
    if ($query === '') {
        return true;
    }

    if (function_exists('mb_stripos')) {
        return mb_stripos($text, $query, 0, 'UTF-8') !== false;
    }

    return stripos($text, $query) !== false;
}

/** Ищет блюдо по названию, описанию и списку ингредиентов. */
function find_recipes_by_ingredient(array $recipes, string $query): array
{
    $query = trim($query);
    if ($query === '') {
        return $recipes;
    }

    $result = [];
    foreach ($recipes as $id => $recipe) {
        $searchableText = $recipe['name'] . ' ' . $recipe['description'] . ' '
            . $recipe['category'] . ' ' . implode(' ', $recipe['ingredients']);

        if (text_contains($searchableText, $query)) {
            $result[$id] = $recipe;
        }
    }

    return $result;
}

/** Возвращает адрес страницы конкретного рецепта. Существующие страницы сохранены. */
function recipe_url(array $recipe): string
{
    $pages = [
        'pasta' => 'recipe-pasta.php',
        'syrniki' => 'recipe-syrniki.php',
        'soup' => 'recipe-soup.php',
    ];

    if (isset($pages[$recipe['id']])) {
        return $pages[$recipe['id']];
    }

    return 'recipe.php?id=' . rawurlencode($recipe['id']);
}

/** Считает русское окончание слова «рецепт» для результата поиска. */
function recipe_count_label(int $count): string
{
    $lastTwo = $count % 100;
    $last = $count % 10;

    if ($lastTwo >= 11 && $lastTwo <= 14) {
        return $count . ' рецептов';
    }
    if ($last === 1) {
        return $count . ' рецепт';
    }
    if ($last >= 2 && $last <= 4) {
        return $count . ' рецепта';
    }
    return $count . ' рецептов';
}
