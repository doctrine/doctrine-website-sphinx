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

foreach ($projects as $projectName => $projectData) {
    echo "Starting Project " . $projectName . "\n";
    $tagData = json_decode(file_get_contents("https://api.github.com/repos/doctrine/" . $projectData['repository'] . "/tags"), true);

    if ( ! $tagData) {
        continue;
    }

    usort($tagData, function($a, $b) {
        return version_compare($a['name'], $b['name']);
    });

    foreach ($projectData['versions'] as $version => $versionData) {
        echo "Starting Branch " . $version . "\n";
        $projectData['versions'][$version]['releases'] = array();
        foreach ($tagData as $tag) {
            if (strpos($tag['name'], $version) === 0) {
                echo "Preparing " . $tag['name'] . "\n";

                $release = array(
                    'package_name'         => sprintf($projectData['file'], $projectData['package'], $tag['name']),
                    'git_checkout_command' => '$ git clone git://github.com/doctrine/' . $projectData['repository'] . '.git ' . $projectData['slug'] . '<br>$ cd ' . $projectData['slug'] . '<br>$ git checkout ' . $tag['name'],
                    'pear_install_command' => '$ pear channel-discover pear.doctrine-project.org<br>pear install doctrine/' . $projectData['package'].'-' . $tag['name'],
                    'composer'             => !isset($versionData['composer']) || $version['composer']
                );

                $projects[$projectName]['versions'][$version]['releases'][$tag['name']] = $release;
            }
        }
    }
}

file_put_contents(__DIR__ . "/../pages/source/projects.yml", Yaml::dump($projects, 8, 2));

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

