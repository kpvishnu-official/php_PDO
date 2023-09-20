<?php

require_once "vendor/autoload.php";

$databasePath = __DIR__ . "/banck.sqlite";
$pdo = new PDO("sqlite:" . $databasePath);

$statement = $pdo->query("SELECT * FROM students");
$studentsList = $statement->fetchAll();

var_dump($studentsList);
