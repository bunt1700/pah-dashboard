<?php

	namespace App\Http\Controllers;

	use App\Category;
	use App\Subcategory;
	use App\Productgroup;
	use Illuminate\Http\JsonResponse;

	class DataController
	{
		public function categories()
		{
			return new JsonResponse(Category::all());
		}

		public function subcategories(Category $category)
		{
			return new JsonResponse($category->subcategories);
		}

		public function productgroups(Subcategory $subcategory)
		{
			return new JsonResponse($subcategory->productgroups);
		}

		public function products(Productgroup $productgroup)
		{
			return new JsonResponse($productgroup->products);
		}
	}