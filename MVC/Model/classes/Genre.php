<?php
declare(strict_types=1);

require_once __DIR__ . '/../Dao/GenreDAO.php';

class Genre extends GenreDAO
{
    private ?int $id;
    private string $nom;

    public function __construct(?int $id = null, string $nom = '', ?PDO $pdo = null)
    {
        parent::__construct($pdo);
        $this->id = $id;
        $this->nom = $nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }
}