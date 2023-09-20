<?php

$databasePath = __DIR__ . "/banck.sqlite";

try {
    $pdo = new PDO("sqlite:" . $databasePath);
    echo "DB connected";

    $pdo->exec("CREATE TABLE students (id INTEGER PRIMARY KEY, name TEXT, birth_date TEXT   )");
} catch (\Throwable $th) {
    echo "Error connection on database" . $th;
}