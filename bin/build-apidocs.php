<?php
/**
 * Use the projects.yml and build apidocs for all projects+versions
 *
 * Apigen (www.apigen.org) is required.
 */

require_once __DIR__ . "/../vendor/.composer/autoload.php";

if (!isset($argv[1])) {
    echo "missing argument\n";
    exit(1);
}

$output = realpath($argv[1]);
if (!is_dir($output)) {
    echo "First argument has to be a directory.\n";
    exit(1);
}

$data = \Symfony\Component\Yaml\Yaml::parse(file_get_contents(__DIR__ . "/../pages/source/projects.yml"));

foreach ($data as $project => $projectDetails) {
    foreach ($projectDetails['versions'] as $version => $versionData) {

        if (isset($versionData['browse_source_link']) && count($versionData['releases']) && isset($versionData['source_path'])) {
            $checkout = end(array_keys($versionData['releases']));
            $url = $versionData['browse_source_link'];
            $path = "source/$project";
            if (is_dir($path)) {
                $updateSourceCmd = sprintf("cd %s && git pull && git checkout %s", $path, $checkout);
            } else {
                $updateSourceCmd = sprintf("git clone %s.git %s && cd %s && git checkout %s", $url, $path, $path, $checkout);
            }

            chdir(__DIR__ . "/../");
            echo "Executing $updateSourceCmd\n";
            shell_exec($updateSourceCmd);

            $directory = $output . "/" . $versionData['source_path'];
            if (!file_exists($directory)) {
                echo "Creating directory: $directory\n";
                mkdir($directory);
            }

            chdir(__DIR__ . "/../");
            $apiDocs = sprintf('apigen -s %s -d %s/%s --main "%s" --title "%s"', $path.'/lib/Doctrine', $output, $versionData['source_path'], $projectDetails['slug'], $projectDetails['title'] );
            echo "Generating API Docs: $apiDocs\n";
            shell_exec($apiDocs);
        }
    }
}

