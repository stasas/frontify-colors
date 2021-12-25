<?php
require_once __DIR__ . "/../inc/bootstrap.php";

use Controllers\ColorController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// All api endpoints start with /api/colors, everything should result in a 404 Not Found.
if ($uri[1] !== 'api' || $uri[2] !== 'colors') {
    http_response_code(404);
    echo json_encode([
        'error' => 'Not found.'
    ]);
    exit();
}

// Color id is optional and must be a number.
$colorId = null;
if (isset($uri[3])) {
    $colorId = (int) $uri[3];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

$controller = new ColorController($dbConnection, $requestMethod, $colorId);
$controller->handleRequest();
