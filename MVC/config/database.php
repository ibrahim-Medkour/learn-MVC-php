<?php
declare(strict_types=1);

function getPDOConnection(): PDO
{
    static $connection = null;

    if ($connection instanceof PDO) {
        return $connection;
    }

    // Informations de connexion
    $host = '127.0.0.1';
    $database = 'gestion_films';
    $username = 'root';
    $password = "009139B";
    $charset = 'utf8mb4';

    // Data Source Name
    $dsn = "mysql:host={$host};dbname={$database};charset={$charset}";

    // Connexion PDO
    $connection = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $connection;
}