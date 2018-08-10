<?php 
error_reporting(E_ALL);
$pdo = new PDO("mysql:host=localhost;dbname=db;charset=utf8", "root", "");
if (!$pdo)
    {
        die('Невозможно подключиться');
    }