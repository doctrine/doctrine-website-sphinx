<?php

// web/app.php
use Symfony\Component\HttpFoundation\Request;

$loader = require __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../app/JiraDummyKernel.php';

$app = new JiraDummyKernel('prod', false);
$app->loadClassCache();

$app->handle(Request::createFromGlobals())->send();
