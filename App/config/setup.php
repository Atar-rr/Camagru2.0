<?php

require_once __DIR__ . '/database.php';

$db = new PDO('mysql:host=mysql', $DB_USER, $DB_PASSWORD);
$sql = file_get_contents('database.sql');
$query = $db->exec($sql);
