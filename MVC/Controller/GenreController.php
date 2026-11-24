<?php
declare(strict_types=1);

ini_set('display_errors', '0');
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../Service/GenreService.php';

function sendJsonResponse(int $statusCode, array $response): never
{
    http_response_code($statusCode);
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

try {
    $service = new GenreService();
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $action = $_GET['action'] ?? '';

    if ($method === 'GET' && $action === 'list') {
        sendJsonResponse(200, [
            'success' => true,
            'message' => 'Genres récupérés avec succès',
            'data' => $service->getAllGenres(),
        ]);
    }

    if ($method === 'POST' && $action === 'create') {
        $payload = json_decode(file_get_contents('php://input'), true);

        if (!is_array($payload) || !isset($payload['nom']) || !is_string($payload['nom'])) {
            sendJsonResponse(400, [
                'success' => false,
                'message' => 'Veuillez fournir un nom de genre valide.',
            ]);
        }

        $genre = $service->addGenre($payload['nom']);
        sendJsonResponse(201, [
            'success' => true,
            'message' => 'Genre ajouté avec succès',
            'data' => $genre,
        ]);
    }

    if (!in_array($method, ['GET', 'POST'], true)) {
        header('Allow: GET, POST');
        sendJsonResponse(405, [
            'success' => false,
            'message' => 'Méthode HTTP non autorisée.',
        ]);
    }

    sendJsonResponse(400, [
        'success' => false,
        'message' => 'Action invalide.',
    ]);
} catch (InvalidArgumentException $exception) {
    sendJsonResponse(400, [
        'success' => false,
        'message' => $exception->getMessage(),
    ]);
} catch (Throwable $exception) {
    error_log((string) $exception);
    sendJsonResponse(500, [
        'success' => false,
        'message' => 'Une erreur est survenue. Veuillez réessayer plus tard.',
    ]);
}