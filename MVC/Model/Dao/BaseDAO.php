<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

class BaseDAO
{
    protected PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? getPDOConnection();
    }
}