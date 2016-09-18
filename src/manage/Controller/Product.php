<?php

namespace App\Controller;
/**
 *
 */
class Product {
	public function listAction() {
		return 'product list';
	}
	public function itemAction($id) {
		return "product $id";
	}
}