<?php

declare(strict_types=1);
session_start();

require_once dirname(__DIR__) . '/src/functions.php';
require_once dirname(__DIR__) . '/src/database.php';
require_once dirname(__DIR__) . '/src/guestbook_repository.php';

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';
$name = '';
$message = '';
$databaseError = '';
$entries = [];
$pdo = null;

try {
    $pdo = get_database_connection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim((string)($_POST['name'] ?? ''));
        $message = trim((string)($_POST['message'] ?? ''));
        $token = (string)($_POST['csrf_token'] ?? '');

        if (!hash_equals($_SESSION['csrf_token'], $token)) {
            $error = 'Не удалось проверить отправку формы. Обновите страницу и попробуйте ещё раз.';
        } elseif ($name === '' || $message === '') {
            $error = 'Пожалуйста, заполните оба поля.';
        } elseif (text_length($name) > 60) {
            $error = 'Имя должно содержать не более 60 символов.';
        } elseif (text_length($message) > 1000) {
            $error = 'Сообщение должно содержать не более 1000 символов.';
        } else {
            add_guestbook_entry($pdo, $name, $message);
            header('Location: guestbook.php?sent=1');
            exit;
        }
    }

    $entries = get_guestbook_entries($pdo);
} catch (PDOException $exception) {
    // Подробности записываются в журнал сервера, а не показываются посетителю.
    error_log('Guestbook MySQL error: ' . $exception->getMessage());
    $databaseError = 'Не удалось подключиться к базе данных. Проверьте, запущен ли MySQL, '
        . 'импортирован ли файл database/gotov_vkusno.sql и правильно ли заполнен config/database.php.';
}

$activePage = 'guestbook';
$pageTitle = 'Гостевая книга — Готовь вкусно!';
require __DIR__ . '/includes/header.php';
?>
<main class="wrap">
    <section class="page-hero">
        <div class="eyebrow">Обратная связь</div>
        <h1>Гостевая книга</h1>
        <p>
            Напишите, что вам понравилось, или предложите блюдо для каталога.
            Сообщения сохраняются в базе данных MySQL.
        </p>
    </section>

    <?php if (isset($_GET['sent'])): ?>
        <div class="form-message success" role="status">Спасибо! Ваш отзыв сохранён в базе данных.</div>
    <?php endif; ?>

    <?php if ($databaseError !== ''): ?>
        <div class="form-message error" role="alert"><?= e($databaseError) ?></div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="form-message error" role="alert"><?= e($error) ?></div>
    <?php endif; ?>

    <section class="guestbook-grid">
        <div class="about-panel" style="margin:0;">
            <h2 class="content-title">Оставить сообщение</h2>
            <form action="guestbook.php" method="post">
                <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">

                <div class="form-field">
                    <label for="name">Ваше имя</label>
                    <input
                        class="form-control"
                        id="name"
                        name="name"
                        type="text"
                        maxlength="60"
                        required
                        value="<?= e($name) ?>"
                        placeholder="Как к вам обращаться?"
                    >
                </div>

                <div class="form-field">
                    <label for="message">Сообщение</label>
                    <textarea
                        class="form-control"
                        id="message"
                        name="message"
                        maxlength="1000"
                        required
                        placeholder="Напишите отзыв или предложите новый рецепт…"
                    ><?= e($message) ?></textarea>
                </div>

                <p class="search-note">Имя — до 60 символов, сообщение — до 1000 символов.</p>
                <button class="btn" type="submit" <?= $databaseError !== '' ? 'disabled' : '' ?>>
                    Отправить сообщение
                </button>
            </form>
        </div>

        <div>
            <div class="section-head" style="margin-bottom:18px;">
                <div>
                    <div class="eyebrow">Отзывы посетителей</div>
                    <h2 style="font-size:32px;">Сообщения</h2>
                    <p class="muted">Всего: <?= count($entries) ?></p>
                </div>
            </div>

            <?php if ($databaseError !== ''): ?>
                <div class="empty-state">
                    <h3>База данных пока недоступна</h3>
                    <p class="muted">После настройки MySQL здесь появятся сообщения посетителей.</p>
                </div>
            <?php elseif (!$entries): ?>
                <div class="empty-state">
                    <h3>Пока сообщений нет</h3>
                    <p class="muted">Оставьте первый отзыв о сайте.</p>
                </div>
            <?php else: ?>
                <?php foreach ($entries as $entry): ?>
                    <article class="guestbook-entry">
                        <div class="guestbook-entry-header">
                            <strong><?= e((string)$entry['name']) ?></strong>
                            <span class="guestbook-entry-date"><?= e((string)$entry['created_at']) ?></span>
                        </div>
                        <p class="guestbook-entry-message"><?= e((string)$entry['message']) ?></p>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
