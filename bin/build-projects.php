<?php
/**
 * Fetches the projects.yml from the main directory and builds
 * a projects.yml with populated information for the pages/source
 * directory
 */

require_once __DIR__ . "/../vendor/.composer/autoload.php";

$file = __DIR__ . "/../projects.yml";
$data = \Symfony\Component\Yaml\Yaml::parse($file);


