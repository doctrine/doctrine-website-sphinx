<?php

if (!isset($_SERVER['HTTP_X_HUB_SIGNATURE'])) {
    header("HTTP/1.1 403 Unauthorized");
    exit(0);
}

$payload = json_decode((string)file_get_contents("php://input"), true);
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];

if (!isset($payload['ref'])) {
    header("HTTP/1.1 400 Bad Request");
    exit(0);
}

if ($payload['ref'] != 'refs/changes/master') {
    header("HTTP/1.1 204 Empty");
    exit(0);
}

touch("/var/www/doctrine-website-sphinx/regenerate");

echo json_encode(array('ok' => true));
