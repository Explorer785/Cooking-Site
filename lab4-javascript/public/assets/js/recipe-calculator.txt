'use strict';

// Калькулятор пересчёта ингредиентов для выбранного количества порций.
// Базовое количество порций для каждого рецепта указано в HTML-атрибуте.

document.addEventListener('DOMContentLoaded', function () {
    const calculator = document.querySelector('[data-servings-calculator]');

    // На страницах без рецепта калькулятор не нужен.
    if (!calculator) {
        return;
    }

    const baseServings = Number.parseInt(calculator.dataset.baseServings, 10) || 2;
    const minServings = Number.parseInt(calculator.dataset.minServings, 10) || 1;
    const maxServings = Number.parseInt(calculator.dataset.maxServings, 10) || 12;
    const servingsOutput = calculator.querySelector('[data-servings-value]');
    const decreaseButton = calculator.querySelector('[data-servings-step="-1"]');
    const increaseButton = calculator.querySelector('[data-servings-step="1"]');
    const resetButton = calculator.querySelector('[data-servings-reset]');
    const ingredients = document.querySelectorAll('[data-scalable-ingredient]');

    let currentServings = baseServings;

    // Форматирует число с запятой в качестве десятичного разделителя.
    function formatAmount(value) {
        const roundedValue = Math.round(value * 100) / 100;
        return new Intl.NumberFormat('ru-RU', {
            maximumFractionDigits: 2
        }).format(roundedValue);
    }

    // Пересчитывает каждый ингредиент относительно базового количества порций.
    function updateIngredients() {
        const multiplier = currentServings / baseServings;

        ingredients.forEach(function (item) {
            const baseAmount = Number(item.dataset.baseAmount);
            const amountElement = item.querySelector('[data-ingredient-amount]');

            if (!amountElement || !Number.isFinite(baseAmount)) {
                return;
            }

            amountElement.textContent = formatAmount(baseAmount * multiplier);
        });

        servingsOutput.textContent = String(currentServings);
        decreaseButton.disabled = currentServings <= minServings;
        increaseButton.disabled = currentServings >= maxServings;
    }

    decreaseButton.addEventListener('click', function () {
        if (currentServings > minServings) {
            currentServings -= 1;
            updateIngredients();
        }
    });

    increaseButton.addEventListener('click', function () {
        if (currentServings < maxServings) {
            currentServings += 1;
            updateIngredients();
        }
    });

    resetButton.addEventListener('click', function () {
        currentServings = baseServings;
        updateIngredients();
    });

    updateIngredients();
});
