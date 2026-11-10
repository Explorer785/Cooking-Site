# «Готовь вкусно!» — лабораторная работа № 3 (MySQL)

## Что реализовано

Проект продолжает сайт из лабораторных № 1 и № 2. Сохранены главная страница, каталог, страница «О проекте», страницы пасты, сырников и куриного супа, а также дополнительные карточки рецептов. Существующие три фотографии оставлены на месте; новые изображения не добавлялись.

Главное изменение лабораторной № 3 — гостевая книга. Теперь PHP сохраняет сообщения не в JSON-файл, а в таблицу `guestbook_entries` базы данных MySQL. Для подключения используется PDO, а для добавления сообщения — подготовленный SQL-запрос.

## Требования

- XAMPP для Windows;
- PHP с включёнными расширениями `PDO` и `pdo_mysql`;
- MySQL или MariaDB из состава XAMPP;
- браузер.

Если PHP сообщает `could not find driver`, проверьте в XAMPP файл `php.ini`: расширение `pdo_mysql` должно быть включено (строка `extension=pdo_mysql` не должна начинаться с `;`). После изменения перезапустите Apache и встроенный сервер PHP.

## Шаг 1. Запуск MySQL

1. Откройте XAMPP Control Panel.
2. Нажмите **Start** напротив Apache.
3. Нажмите **Start** напротив MySQL.

## Шаг 2. Создание базы данных

1. Откройте `http://localhost/phpmyadmin`.
2. Перейдите на вкладку **Импорт**.
3. Выберите файл `database/gotov_vkusno.sql` из папки проекта.
4. Нажмите **Импорт**.

Скрипт создаст базу `gotov_vkusno` и таблицу `guestbook_entries`.

Также можно открыть вкладку SQL в phpMyAdmin и выполнить содержимое файла `database/gotov_vkusno.sql`.

## Шаг 3. Настройка подключения

Откройте `config/database.php`.

Для стандартной установки XAMPP обычно подходят настройки:

- host: `127.0.0.1`;
- port: `3306`;
- database: `gotov_vkusno`;
- username: `root`;
- password: пустая строка.

Если у пользователя MySQL задан пароль или другое имя, измените значения в этом файле.

## Шаг 4. Запуск сайта

Откройте PowerShell в папке `lab3-mysql` и выполните:

```powershell
C:\xampp\php\php.exe -S localhost:8000 -t public
```

Откройте `http://localhost:8000`.

Если XAMPP установлен не в `C:\xampp`, укажите фактический путь к `php.exe`.

## Проверка лабораторной

1. Перейдите в гостевую книгу.
2. Введите имя и сообщение, отправьте форму.
3. Убедитесь, что запись появилась на странице.
4. Откройте phpMyAdmin, базу `gotov_vkusno`, таблицу `guestbook_entries` и проверьте наличие новой записи.
5. Обновите страницу гостевой книги: сообщение должно остаться.

## Структура

```text
lab3-mysql/
├── config/database.php
├── database/gotov_vkusno.sql
├── public/
│   ├── index.php
│   ├── catalog.php
│   ├── about.php
│   ├── guestbook.php
│   ├── recipe-pasta.php
│   ├── recipe-syrniki.php
│   ├── recipe-soup.php
│   ├── recipe.php
│   ├── assets/style.css
│   ├── images/
│   └── includes/
└── src/
    ├── database.php
    ├── functions.php
    ├── guestbook_repository.php
    └── recipes.php
```
