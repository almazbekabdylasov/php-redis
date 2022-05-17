<?php

use App\Services\Database;
use Predis\Client;
require __DIR__ . '/vendor/autoload.php';
Database::start(new Client());
require __DIR__ . '/router/routes.php';




