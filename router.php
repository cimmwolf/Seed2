<?php

$matches = [];
if (preg_match('#^/(.*?)@(\d+|-)x(\d+|-)\.(gif|jpe?g|png)$#', $_SERVER['REQUEST_URI'], $matches)) {
    if (($newW = $matches[2]) == '-')
        $newW = -1;
    if (($newH = $matches[3]) == '-')
        $newH = -1;

    $filePath = __DIR__ . '/web/' . $matches[1] . '.' . $matches[4];

    if ($newW > 0 && $newH > 0) {
        $size = getimagesize($filePath);
        if ($size[0] / $size[1] * $newH > $newW) {
            $newH = $newW / $size[0] * $size[1];
        } elseif ($size[1] / $size[0] * $newW > $newH) {
            $newW = $newH / $size[1] * $size[0];
        }
    }

    switch ($matches[4]) {
        case 'gif':
            header('Content-Type: image/gif');
            break;
        case 'jpg':
            header('Content-Type: image/jpeg');
            break;
        case 'jpeg':
            header('Content-Type: image/jpeg');
            break;
        case 'png':
            header('Content-Type: image/png');
            $image = imagecreatefrompng($filePath);
            $image = imagescale($image, $newW, $newH);
            imagealphablending($image, true);
            imagesavealpha($image, true);
            imagepng($image);
            break;
    }

    if (!isset($image)) {
        $image = imagecreatefromjpeg($filePath);
        $image = imagescale($image, $newW, $newH);
        imagejpeg($image);
    }
    imagedestroy($image);
} else {
    if (!file_exists(__DIR__ . '/web' . $_SERVER['REQUEST_URI'])) {
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/web/index.php';
        buildSiteMap();
        require __DIR__ . '/web/index.php';
    } else {
        return false;
    }
}

function recursiveRemoveDirectory($directory)
{
    foreach (glob("{$directory}/*") as $file) {
        if (is_dir($file))
            recursiveRemoveDirectory($file);
        else
            unlink($file);
    }
    rmdir($directory);
}

function buildSiteMap()
{
    $path = __DIR__ . '/runtime/sitemap';
    $sitemapFile = __DIR__ . '/web/sitemap.xml';
    if (file_exists($sitemapFile) AND !file_exists($path)) {
        if (is_dir($path))
            recursiveRemoveDirectory($path);

        $sitemap = new SimpleXMLElement($sitemapFile, 0, true);
        foreach ($sitemap as $url) {
            $dir = $path . parse_url($url->loc, PHP_URL_PATH);
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
        }
    }
}