<?php

declare(strict_types=1);

/** Возвращает последние 300 сообщений гостевой книги. */
function get_guestbook_entries(PDO $pdo): array
{
    $sql = "
        SELECT
            id,
            name,
            message,
            DATE_FORMAT(created_at, '%d.%m.%Y %H:%i') AS created_at
        FROM guestbook_entries
        ORDER BY created_at DESC, id DESC
        LIMIT 300
    ";

    $statement = $pdo->query($sql);
    return $statement->fetchAll();
}

/** Сохраняет новое сообщение с помощью подготовленного SQL-запроса. */
function add_guestbook_entry(PDO $pdo, string $name, string $message): void
{
    $sql = 'INSERT INTO guestbook_entries (name, message) VALUES (:name, :message)';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':name' => $name,
        ':message' => $message,
    ]);
}
