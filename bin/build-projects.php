<?php
/**
 * Fetches the projects.yml from the main directory and builds
 * a projects.yml with populated information for the pages/source
 * directory
 */

use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . "/../vendor/autoload.php";

$file        = __DIR__ . "/../projects.yml";
$projects    = Yaml::parse($file);

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

foreach ($projects as $projectName => $projectData) {
    $ch  = curl_init("https://api.github.com/repos/doctrine/" . $projectData['repository'] . "/tags");

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
        $tagData[$key] = str_replace('v', $tag['name']);
    }

    usort($tagData, function($a, $b) {
        return version_compare($a['name'], $b['name']);
    });

    foreach ($projectData['versions'] as $version => $versionData) {
        // default 'downloadable' to true
        if ( !isset($projects[$projectName]['versions'][$version]['downloadable'])) {
            $projects[$projectName]['versions'][$version]['downloadable'] = true;
        }

        $projects[$projectName]['versions'][$version]['releases'] = array();
        foreach ($tagData as $tag) {
            if (strpos($tag['name'], $version) === 0) {
                $release = array(
                    'package_name'         => sprintf($projectData['file'], $projectData['package'], $tag['name']),
                    'git_checkout_command' => '$ git clone git://github.com/doctrine/' . $projectData['repository'] . '.git ' . $projectData['slug'] . '<br>$ cd ' . $projectData['slug'] . '<br>$ git checkout ' . $tag['name'],
                    'pear_install_command' => '$ pear channel-discover pear.doctrine-project.org<br>pear install doctrine/' . $projectData['package'].'-' . $tag['name'],
                    'composer'             => !isset($versionData['composer']) || (isset($version['composer']) && $version['composer']),
                );

                $projects[$projectName]['versions'][$version]['releases'][$tag['name']] = $release;
            }
        }
    }
}

file_put_contents(__DIR__ . "/../pages/source/projects.yml", Yaml::dump($projects, 8, 2));

/**
 * Given a package and tag name "tests" how the build file is called
 * using HEAD requests.
 *
 * Not necessary at the moment
 */
function get_package_name($package, $tag)
{
    $downloadDir = "http://www.doctrine-project.org/downloads/";
    $fileNames = array(
        $package . "-" . $tag . "-full.tar.gz",
        $package . "-" . strtolower($tag) . "-full.tar.gz",
        $package . "-" . $tag . ".tgz"
    );

    $packageName = null;
    $ch = curl_init();
    foreach ($fileNames as $fileName) {
        curl_setopt($ch, CURLOPT_URL, $downloadDir . "/" . $fileName);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD');
        curl_exec($ch);

        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code == 200) {
            $packageName = $fileName;
            break;
        }
    }
}

