<?php

require_once __DIR__ . '/database.php';

$db = new PDO('mysql:host=mysql', $DB_USER, $DB_PASSWORD);
$sql = file_get_contents('database.sql');
$query = $db->exec($sql);

//создание админа
$password = password_hash('admin', PASSWORD_ARGON2ID);
$sql = "INSERT INTO user (login, password, email,  active_status)
			VALUES (?, ?, ?, ?)";
$sth = $db->prepare(
    "INSERT INTO user (login, password, email, active_status) VALUES (?, ?, ?, ?)"
);

$sth->execute(['admin', $password, 'admin@admin.ru', 1]);