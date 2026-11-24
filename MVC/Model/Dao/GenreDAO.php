<?php
declare(strict_types=1);

require_once __DIR__ . '/BaseDAO.php';

class GenreDAO extends BaseDAO
{
    public function addGenre(string $nom): int
    {
        $statement = $this->pdo->prepare('INSERT INTO genres (nom) VALUES (:nom)');
        $statement->execute(['nom' => $nom]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * @return array<int, array{id: int, nom: string}>
     */
    public function getAllGenres(): array
    {
        $statement = $this->pdo->query('SELECT id, nom FROM genres ORDER BY id ASC');

        return array_map(
            static fn(array $genre): array => [
                'id' => (int) $genre['id'],
                'nom' => (string) $genre['nom'],
            ],
            $statement->fetchAll()
        );
    }
}