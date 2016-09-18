<?php
// 注册类加载器
($loader = new \Norma\Loader())->register();
$loader->addNamespace('App\Plugin', APP_PATH . 'Lib/Plugin');
$loader->addNamespace('App\Controller', APP_PATH . 'Controller');

define('APP_TYPE', 'pux');