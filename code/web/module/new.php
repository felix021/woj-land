#!/usr/bin/php
<?php

define ("ROOT", dirname(__FILE__));

if ($argc < 4)
{
    die("usage: ./new.php PATH mod|tpl name\n");
}

$path = ROOT . "/" . $argv[1];
$name = $argv[3];
$src  = "";
$dest = "";
if (substr($argv[2], 0, 3) == 'mod')
{
    $src    = ROOT . "/hello/get.php";
    $dest   = $path . "/" . $name . ".php";
}
else if (substr($argv[2], 0, 3) == 'tpl')
{
    $src    = ROOT . "/hello/hello.tpl.php";
    $dest   = $path . "/" . $name . ".tpl.php";
}
else
{
    die("unknown method: " . $argv[2]);
}

if (!file_exists($path) || !is_dir($path))
{
    mkdir($path, 0755, true);
}
if (!is_dir($path))
{
    die("$path is not a directory");
}

echo "copy: $src => $dest\n";
if (copy($src, $dest))
{
    echo "ok.\n";
}
else
{
    echo "copy failed\n";
}
?>
