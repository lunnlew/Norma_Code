<?php
$mux = new \Pux\Mux;
$mux->any('/product', ['App\Controller\Product', 'listAction']);
$mux->get('/product/:id', ['App\Controller\Product', 'itemAction'], [
	'require' => ['id' => '\d+'],
	'default' => ['id' => '1'],
]);
$mux->post('/product/:id', ['App\Controller\Product', 'updateAction'], [
	'require' => ['id' => '\d+'],
	'default' => ['id' => '1'],
]);
$mux->delete('/product/:id', ['App\Controller\Product', 'deleteAction'], [
	'require' => ['id' => '\d+'],
	'default' => ['id' => '1'],
]);
return $mux;