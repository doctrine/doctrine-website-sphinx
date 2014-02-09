<?php

$dir = __DIR__ . '/../pages/source/blog';
$posts = scandir($dir);
$tinkerDir = realpath(__DIR__ . '/../site/');
$redirects = array();
$files = array();

foreach ($posts as $post) {
    if (strpos($post, ".") === 0) {
        continue;
    }

    $lines = file($dir . '/' . $post);

    $date = null;
    $author = null;
    $title = null;
    $content = null;
    $categories = "none";
    $tags = "none";

    foreach ($lines as $pos => $line) {
        if (strpos($line, ':date:') === 0) {
            $date = trim(str_replace(':date:', '', $line));
        }

        if (strpos($line, ':author:') === 0) {
            $author = strip_tags(trim(str_replace(':author:', '', $line)));
        }

        if ($title === null && strpos($line, '===') === 0) {
            $title = trim($lines[$pos+1]);
            $content = array_slice($lines, $pos+3);
            break;
        }
    }

    if (stripos($title, 'release')) {
        $categories = "Release";
    }

    foreach ($content as $pos => $line) {
        if (trim($line) === '[php]' && trim($content[$pos-2]) === "::") {
            $content[$pos-2] = ".. code-block:: php\n";
            $content[$pos] = "    <?php\n";
        }

        if (strpos($line, '>`_,')) {
            $content[$pos] = str_replace('>`_,', '>`_ ,', $line);
        }

        if (trim($line) === '.. code-block::') {
            $content[$pos] = "::\n";
        }

        if (strpos($line, '===') === 0) {
            $content[$pos] = str_replace('=', '-', $line);
        }

        // bugfix for errors in Doctrine Behavioral extensions post
        if (trim($line) === '-') {
            unset($content[$pos]);
        }

        if (trim($line) === '</h3>') {
            unset($content[$pos]);
        }
    }

    if ($post === "phpcr-odm-qbv2.rst") {
        $title = "PHPCR ODM QueryBuilder v2";
    }

    $timestamp = strtotime($date);

    if (!$timestamp) {
        continue;
    }

    $newContent = $title . "\n" . str_repeat("=", strlen($title)) . "\n" . implode('', $content);
    $newContent .= <<<POST

.. author:: $author
.. categories:: $categories
.. tags:: $tags
.. comments::

POST;

    $fileName = sprintf('%s/%s', date('Y/m/d', $timestamp), $post);
    @mkdir(dirname($fileName), 0775, true);
    file_put_contents($tinkerDir . "/" . $fileName, $newContent);
    $files[] = $fileName;

    $redirects['/blog/' . str_replace('.rst', '.html', $post)] = '/' . $fileName;
}

rsort($files, SORT_NATURAL);

$master = <<<DATA
Sitemap
=======

.. toctree::
   :maxdepth: 1


DATA;

$master .= '   ' .str_replace('.rst', '', implode("\n   ", $files)) . "\n";

file_put_contents($tinkerDir . '/master.rst', $master);

$htaccess = "";

foreach ($redirects as $original => $newUrl) {
    $htaccess .= "redirect 301 $original $newUrl\n";
}

file_put_contents($tinkerDir . '/.htaccess', $htaccess);

