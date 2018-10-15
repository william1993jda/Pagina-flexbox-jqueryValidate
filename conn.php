<?php

$nome     = "atitude-0005\sqlexpress";
$password = "Ekm223165";

try {
    $conn = new PDO('mysql:host=localhost;dbname=pessoa', $nome, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}