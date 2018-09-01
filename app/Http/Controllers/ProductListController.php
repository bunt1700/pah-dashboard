<?php

	namespace App\Http\Controllers;

	use App\Category;
	use App\Product;
	use App\Productgroup;
	use Illuminate\Http\Request;
	use Illuminate\Http\Response;

	class ProductListController extends Controller
	{
		public function __construct() {
			parent::__construct('Producten');
		}

		public function index(Request $request): Response
		{
			$data = [
				'search' => null,
				'products' => [],
				'selected' => [],
			];

			if($request->isMethod('POST')) {
				$parameters = $request->request;
				$search = trim($parameters->get('filter-productname'));

				if($search && $parameters->get('filter-submit') === 'search') {
					$data['search'] = $search;
					$data['products'] = Product::query()->where('name', 'like', '%'.$search.'%')->get();
				} else if($ID = $parameters->get('filter-productgroups')) {
					$productgroup = Productgroup::get($ID);

					if($productgroup instanceof Productgroup) {
						$data['activeProductgroup'] = $productgroup;
						$data['activeSubcategory'] = $productgroup->subcategory;
						$data['activeCategory'] = $data['activeSubcategory']->category;

						$data['categories'] = Category::all();
						$data['subcategories'] = $data['activeCategory']->subcategories;
						$data['productgroups'] = $data['activeSubcategory']->productgroups;
						$data['products']    = $productgroup->products;
					}
				}
			}

			return $this->render('productlist', $data);
		}
	}