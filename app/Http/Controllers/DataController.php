<?php

	namespace App\Http\Controllers;

	use App\Category;
	use App\Subcategory;
	use App\Productgroup;
	use Illuminate\Http\JsonResponse;

	class DataController extends Controller
	{
		public function categories(): JsonResponse
		{
			return new JsonResponse(Category::all());
		}

		public function subcategories(Category $category): JsonResponse
		{
			return new JsonResponse($category->subcategories);
		}

		public function productgroups(Subcategory $subcategory): JsonResponse
		{
			return new JsonResponse($subcategory->productgroups);
		}

		public function products(Productgroup $productgroup): JsonResponse
		{
			return new JsonResponse($productgroup->products);
		}
	}