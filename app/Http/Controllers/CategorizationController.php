<?php

	namespace App\Http\Controllers;

	use App\Category;
    use App\Model;
    use App\Product;
    use App\Subcategory;
	use App\Productgroup;
	use Illuminate\Http\Request;
    use Illuminate\Support\Arr;
    use RuntimeException;

    class CategorizationController extends Controller
	{
		/** @var Productgroup|null */
		protected $productgroup = null;

		/** @var Subcategory|null */
		protected $subcategory = null;

		/** @var resource|null */
		protected $logfile = null;

		public function __construct(Request $request) {
			$this->title[] = 'Categorieën';

            $this->data['activeSubcategory'] = &$this->subcategory;
            $this->data['activeProductgroup'] = &$this->productgroup;

			if($request->isMethod('POST')) {
			    $data = $request->request;

                if($this->productgroup = Productgroup::get($data->get('selected-productgroup'))) {
                    $this->subcategory = $this->productgroup->subcategory;
                } else {
                    $this->subcategory = Subcategory::get($data->get('selected-subcategory'));
                }
			}
		}

		public function index()
		{
			return $this->render('categories', ['categories' => Category::all()]);
		}

		public function edit(Category $category, Request $request)
		{
			$this->title[] = $category->name;
			$parameters = $request->request;

            if($name = trim($parameters->get('new-subcategory'))) {
                $this->subcategory = Subcategory::query()
                    ->where('category_id', $category->id)
                    ->where('name', $name)
                    ->first();

                if(!$this->subcategory) {
                    $subcategory = new Subcategory();

                    $subcategory->name = $name;
                    $subcategory->slug = str_slug($name);
                    $subcategory->category()->associate($category);

                    if ($category->subcategories()->save($subcategory)) {
                        $this->subcategory = $subcategory;
                    }
                }
            }

            if($name = trim($parameters->get('new-productgroup'))) {
                $this->productgroup = Productgroup::query()
                    ->where('subcategory_id', $this->subcategory->id)
                    ->where('name', $name)
                    ->first();

                if(!$this->productgroup) {
                    $productgroup = new Productgroup();

                    $productgroup->name = $name;
                    $productgroup->slug = str_slug($name);
                    $productgroup->subcategory()->associate($this->subcategory);

                    if($this->subcategory->productgroups()->save($productgroup)) {
                        $this->subcategory = null;
                        $this->productgroup = null;
                    }
                }
            }

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

			if($target = $parameters->get('target-productgroup')) {
                $productgroup = Productgroup::get($target);

                if ($productgroup instanceof Productgroup) {
                    $this->productgroup = $this->merge($this->productgroup, $productgroup);
                }
			} else if($target = $parameters->get('target-subcategory')) {
				$subcategory = Subcategory::get($target);

				if($subcategory instanceof Subcategory) {
				    $this->productgroup = $this->move($this->productgroup, $subcategory);
				}
			}

			return redirect(route('categorization.form', [$category]));
		}

        protected function move(Productgroup $target, Subcategory $destination): Productgroup
        {
            $target->subcategory()->associate($destination);
            $target->save();

            $this->log($target, $destination);

            return $target;
        }

		protected function merge(Productgroup $target, Productgroup $destination): Productgroup
        {
            foreach ($target->products as $product) {
                $product->productgroup()->associate($destination);
                $product->save();

                $this->log($product, $destination);
            }

            $target->delete();

            return $destination;
        }

		protected function log(Model $target, Model $destination): void
        {
            if($this->logfile === null) {
                $this->logfile = @fopen(storage_path('logs/categorization.log'), 'a');
            }
            if(!is_resource($this->logfile)) {
                throw new RuntimeException('Unable to open Migration log');
            }

            $source = $target->productgroup ?? $target->subcategory;

            $entry = [
                date('c'),
                get_class($target),
                $target->id,
                $target->name,
                get_class($source),
                $source->id,
                $source->name,
                get_class($destination),
                $destination->id,
                $destination->name,
            ];

            fputcsv($this->logfile, $entry);
        }

        public function __destruct()
        {
            if($this->logfile !== null) {
                fclose($this->logfile);
            }
        }
	}