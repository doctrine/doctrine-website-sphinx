<?php
/**
 * Use the projects.yml and build apidocs for all projects+versions
 *
 * Apigen (www.apigen.org) is required.
 */

require_once __DIR__ . "/../vendor/autoload.php";

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
    $tagData = json_decode(file_get_contents("https://api.github.com/repos/doctrine/" . $projectDetails['repository'] . "/tags"), true);
    if ( ! $tagData) {
        continue;
    }

    usort($tagData, function($a, $b) {
        return version_compare($a['name'], $b['name']);
    });

    foreach ($projectDetails['versions'] as $version => $versionData) {
        if ( ! isset($versionData['browse_source_link'])) {
            continue;
        }

        $lastTag = array_reduce(
            array_filter($tagData, function($tag) use($version) {
                return strpos($tag['name'], $version) === 0;
            }),
            function ($highestVersion, $testVersion) {
                return version_compare($highestVersion['name'], $testVersion['name']) > 0
                    ? $highestVersion
                    : $testVersion;
            }
        );
        $checkout = $lastTag['name'];

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

        $directory = $output . "/$project/$version";
        if (!file_exists($directory)) {
            echo "Creating directory: $directory\n";
            mkdir($directory, 0777, true);
        }

        chdir(__DIR__ . "/../");
        $apiDocs = sprintf('apigen -s %s -d %s/%s --title "%s"', $path.'/lib/Doctrine', $output, "$project/$version", $projectDetails['title'] );
        echo "Generating API Docs: $apiDocs\n";
        shell_exec($apiDocs);
    }
}

