<?php

if (!isset($_SERVER['HTTP_X_HUB_SIGNATURE'])) {
    header("HTTP/1.1 403 Unauthorized");
    exit(0);
}

$body = (string)file_get_contents("php://input");
$payload = json_decode($body, true);
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];

list($algo, $hash) = explode('=', $signature, 2);

$payloadHash = hash_hmac($algo, $body, $_SERVER['GITHUB_SECRET']);

if ($hash !== $payloadHash) {
    header("HTTP/1.1 403 Unauthorized");
    exit(0);
}

if (!isset($payload['ref'])) {
    header("HTTP/1.1 400 Bad Request");
    exit(0);
}

if ($payload['ref'] != 'refs/heads/master') {
    header("HTTP/1.1 204 Empty");
    exit(0);
}

$ret = touch("/var/www/doctrine-website-sphinx/notify/regenerate");
chmod("/var/www/doctrine-website-sphinx/notify/regenerate", 0660);

echo json_encode(array('regenerate' => $ret));
