<?php
/**
 * Use the projects.yml and build apidocs for all projects+versions
 *
 * Apigen (www.apigen.org) is required.
 */

require_once __DIR__ . "/../vendor/autoload.php";

if (!isset($argv[1])) {
    echo "missing argument.\n" .
        "You need to pass a folder to generate the api in.\n";
    exit(1);
}

$output = realpath($argv[1]);
if (!is_dir($output)) {
    echo "First argument has to be a directory.\n";
    exit(1);
}

if (!file_exists(__DIR__ . '/../github-token.json')) {
    echo "Missing github-token.json!";
    exit(1);
}

$tokenData = json_decode(file_get_contents(__DIR__ . '/../github-token.json'), true);
$token     = $tokenData['token'];

if (!is_string($token)) {
    echo "Invalid github-token.json provided";
    exit(1);
}

$data = \Symfony\Component\Yaml\Yaml::parse(file_get_contents(__DIR__ . "/../site/projects.yml"));

foreach ($data as $project => $projectDetails) {
    if ( ! isset($projectDetails['browse_source_link'])) {
        continue;
    }

    $url = $projectDetails['browse_source_link'];
    $ch  = curl_init("https://api.github.com/repos/doctrine/" . $projectDetails['repository'] . "/tags");

    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: token $token"));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);

    curl_close($ch);

    $tagData = json_decode($response, true);

    if ( ! $tagData) {
        continue;
    }

    // Fix versions starting with "v", such as "v1.2.5"
    foreach ($tagData as $key => $tag) {
        $tagData[$key]['name'] = str_replace('v', '', $tag['name']);
    }

    usort($tagData, function($a, $b) {
        return version_compare($a['name'], $b['name']);
    });

    foreach ($projectDetails['versions'] as $version => $versionData) {

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
        $directory = $output . "/$project/$version";
        $lastCommitFile = $directory . '/.gitcommit';
        $path = "source/$project";

        if (!file_exists($directory)) {
            echo "Creating directory: $directory\n";
            mkdir($directory, 0777, true);
        }

        $lastCommit = (file_exists($lastCommitFile))
            ? trim(file_get_contents($lastCommitFile))
            : null;

        $currentCommitCmd = sprintf("cd %s && git log -1 --oneline", $path);

        if (is_dir($path)) {
            $updateSourceCmd = sprintf("cd %s && git checkout master && git fetch && git checkout %s", $path, $checkout);
        } else {
            $updateSourceCmd = sprintf("git clone %s.git %s && cd %s && git checkout %s", $url, $path, $path, $checkout);
        }

        chdir(__DIR__ . "/../");
        echo "Executing $updateSourceCmd\n";
        shell_exec($updateSourceCmd);

        $currentCommit = trim(current(explode(" ", shell_exec($currentCommitCmd))));

        if ($currentCommit === $lastCommit) {
            echo "API Docs for $project @ $checkout is already up to date.\n";
            continue;
        }

        chdir(__DIR__ . "/../");
        $apiDocs = sprintf(
            './vendor/bin/apigen -s %s -d %s/%s --title "%s"',
            $path . '/lib/Doctrine',
            $output,
            "$project/$version",
            $projectDetails['title']
        );
        echo "Generating API Docs: $apiDocs\n";
        shell_exec($apiDocs);

        file_put_contents($lastCommitFile, $currentCommit);
    }
}

