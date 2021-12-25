<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/database.php";
require_once __DIR__ . "/../helpers/helpers.php";
require_once __DIR__ . "/../models/Color.php";
require_once __DIR__ . "/../controllers/ColorController.php";

$dbConnection = (new Database())->getConnection();
