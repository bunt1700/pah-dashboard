<?php

	namespace App\Http\Controllers;

	use App\Category;
    use App\Model;
    use App\Product;
    use App\Subcategory;
	use App\Productgroup;
	use Illuminate\Http\Request;
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
                        $this->productgroup = $this->merge($this->productgroup, $productgroup);
                    }
                }
			} else if($target = $parameters->get('new-subcategories')) {
				$subcategory = Subcategory::get($target);

				if($subcategory instanceof Subcategory) {
				    $this->productgroup = $this->move($this->productgroup, $subcategory);
				}
			}

			return redirect(route('categorization.form', [$category]));
		}

        protected function move(Productgroup $target, Subcategory $destination): Productgroup
        {
            $target->setAttribute('subcategory_id', $destination->id);
            $target->save();

            $this->log($target, $destination);

            return $target;
        }

		protected function merge(Productgroup $target, Productgroup $destination): Productgroup
        {
            foreach ($target->products as $product) {
                $product->setAttribute('productgroup_id', $destination->id);
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
            if($this->logfile === null) {
                fclose($this->logfile);
            }
        }
	}