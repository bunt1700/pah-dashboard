<?php

	namespace App\Http\Controllers;

	use App\Product;
	use Illuminate\Http\Response;

	class ProductListController extends Controller
	{
		public function index(): Response
		{
			$this->title = 'Productbeheer';
			$products = $this->paginate(Product::query());

			return $this->render('productlist', ['products' => $products]);
		}
	}