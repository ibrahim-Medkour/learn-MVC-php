<?php
declare(strict_types=1);

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../Model/classes/Genre.php';

class GenreService extends BaseService
{
    private ?Genre $genre;

    public function __construct(?Genre $genre = null)
    {
        $this->genre = $genre;
    }

    /**
     * @return array{id: int, nom: string}
     */
    public function addGenre(string $nom): array
    {
        $nom = $this->validateRequiredText($nom, 'nom');

        if (preg_match_all('/./us', $nom) > 100) {
            throw new InvalidArgumentException('Le nom ne peut pas dépasser 100 caractères.');
        }

        $genre = $this->getGenre();
        $genre->setNom($nom);
        $id = $genre->addGenre($genre->getNom());

        return ['id' => $id, 'nom' => $genre->getNom()];
    }

    /**
     * @return array<int, array{id: int, nom: string}>
     */
    public function getAllGenres(): array
    {
        return $this->getGenre()->getAllGenres();
    }

    private function getGenre(): Genre
    {
        if ($this->genre === null) {
            $this->genre = new Genre();
        }

        return $this->genre;
    }
}