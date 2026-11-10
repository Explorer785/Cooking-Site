

CREATE DATABASE IF NOT EXISTS gotov_vkusno
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE gotov_vkusno;

CREATE TABLE IF NOT EXISTS guestbook_entries (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(60) NOT NULL,
    message VARCHAR(1000) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_guestbook_created_at (created_at)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

