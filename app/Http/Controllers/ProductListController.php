<?php

	namespace App\Http\Controllers;

	use App\Category;
	use App\Product;
	use App\Subcategory;
	use Illuminate\Http\JsonResponse;
	use Illuminate\Http\Response;

	class ProductListController extends Controller
	{
		public function index(): Response
		{
			$this->title = 'Productbeheer';

			$data = [
				'categories' => Category::all(),
				'products' => $this->paginate(Product::query()),
			];

			return $this->render('productlist', $data);
		}
	}