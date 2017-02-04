<?php
foreach (['/../vendor/autoload.php', '/../../../autoload.php'] as $file) {
    $path = realpath(__DIR__ . $file);

    if (!empty($path)) {
        /** @noinspection PhpIncludeInspection */
        require_once $path;
        break;
    }
}
