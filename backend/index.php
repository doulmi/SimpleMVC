<?php

define('APP_PATH', __DIR__ . '/');

define('APP_DEBUG', true);

require(APP_PATH . 'core/App.php');

$config = require(APP_PATH . 'config/config.php');

(new Core\App($config))->run();
