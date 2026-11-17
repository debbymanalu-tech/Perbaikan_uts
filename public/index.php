<?php
declare(strict_types=1);

session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require dirname(__DIR__) . '/app/Core/Database.php';
require dirname(__DIR__) . '/app/Models/Product.php';
require dirname(__DIR__) . '/app/Controllers/ProductController.php';

$controller = new ProductController();
$action = (string) ($_GET['action'] ?? 'index');
$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

if (in_array($action, ['store', 'update', 'delete'], true) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Metode permintaan tidak diizinkan.');
}

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'show':
        $id === false || $id === null ? $controller->index() : $controller->show($id);
        break;
    case 'edit':
        $id === false || $id === null ? $controller->index() : $controller->edit($id);
        break;
    case 'update':
        $id === false || $id === null ? $controller->index() : $controller->update($id);
        break;
    case 'delete':
        $id === false || $id === null ? $controller->index() : $controller->destroy($id);
        break;
    default:
        http_response_code(404);
        $controller->show(-1);
}
