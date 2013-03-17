<?php

Phar::mapPhar('predictionio.phar');

require_once 'phar://predictionio.phar/vendor/symfony/class-loader/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$classLoader = new Symfony\Component\ClassLoader\UniversalClassLoader();
$classLoader->registerNamespaces(array('PredictionIO' => 'phar://predictionio.phar/src',
                                       'Symfony\\Component\\EventDispatcher' => 'phar://predictionio.phar/vendor/symfony/event-dispatcher',
                                       'Guzzle' => 'phar://predictionio.phar/vendor/guzzle/guzzle/src'));
$classLoader->register();

__HALT_COMPILER();