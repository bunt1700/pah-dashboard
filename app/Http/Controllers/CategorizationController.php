<?php

	namespace App\Http\Controllers;

	use App\Category;
	use App\Subcategory;
	use App\Productgroup;
	use Illuminate\Http\Request;

	class CategorizationController extends Controller
	{
		/** @var Productgroup|null */
		protected $productgroup = null;

		/** @var Subcategory|null */
		protected $subcategory = null;

		public function __construct(Request $request) {
			$this->title[] = 'Categorieën';

			if($request->isMethod('POST')) {
				$this->productgroup = Productgroup::get($request->request->get('selected-productgroups'));
				$this->subcategory = $this->productgroup->subcategory;
			}

			$this->data['activeSubcategory'] = $this->subcategory;
			$this->data['activeProductgroup'] = $this->productgroup;
		}

		public function index()
		{
			$data = [
				'categories' => Category::all(),
			];

			return $this->render('categories', $data);
		}

		public function edit(Category $category)
		{
			$this->title[] = $category->name;

			$data = [
				'categories' => Category::all(),
				'subcategories' => $category->subcategories,
				'activeCategory' => $category,
			];

			if($this->subcategory) {
				$data['productgroups'] = $this->subcategory->productgroups;
			}

			return $this->render('edit-category', $data);
		}

		public function save(Category $category, Request $request)
		{
			$parameters = $request->request;

			if($target = $parameters->get('combined-productgroups')) {
			    $log = fopen(dirname(__DIR__, 3) . '/storage/logs/migrations.log', 'a');

			    if(is_resource($log)) {
                    $productgroup = Productgroup::get($target);

                    if ($productgroup instanceof Productgroup) {
                        $before = count($productgroup->products);
                        $products = count($this->productgroup->products);

                        foreach ($this->productgroup->products as $product) {
                            $product->setAttribute('productgroup_id', $productgroup->id);
                            $product->save();
                        }

                        fputcsv(
                            $log,
                            [
                                time(),
                                date('c'),
                                $this->productgroup->id,
                                $this->productgroup->name,
                                $products,
                                $productgroup->id,
                                $productgroup->name,
                                $before,
                            ]
                        );

                        $this->productgroup->delete();
                        $this->productgroup = $productgroup;
                    }
                }
			} else if($target = $parameters->get('new-subcategories')) {
				$subcategory = Subcategory::get($target);

				if($subcategory instanceof Subcategory) {
					$this->productgroup->setAttribute('subcategory_id', $subcategory->id);
					$this->productgroup->save();
				}
			}

			return redirect(route('categorization.form', [$category]));
		}
	}