// api/index.php
<?php

// Include Laravel's autoload file
require __DIR__.'/../vendor/autoload.php';

// Load Laravel application
$app = require_once __DIR__.'/../bootstrap/app.php';

// Run Laravel application
$app->run();