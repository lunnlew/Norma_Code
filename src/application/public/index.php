<?php

define('APP_PATH', dirname(dirname(__FILE__)) . '/');


define('FRAME_PATH', dirname(dirname(__DIR__)).'/Norma/');

require_once(FRAME_PATH.'bootstrap/autoload.php');

Norma\App::execute('web');