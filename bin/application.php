<?php
use Symfony\Bundle\FrameworkBundle\Console\Application;
use ZeroConfig\Preacher\AppKernel;

require_once __DIR__ . '/autoload.php';

return new Application(
    new AppKernel('prod', getcwd() === dirname(__DIR__))
);
