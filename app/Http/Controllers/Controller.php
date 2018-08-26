<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var Request */
    protected $request;

    /** @var string */
    protected $title = '';

    /** @var array */
    protected $data = [];

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	// Abstraction because we want the title to be set on all pages
	protected function render(string $template, array $parameters = [], int $status = 200): Response
	{
		$this->data['title'] = 'Product aan Huis dashboard' . rtrim(' | ' . $this->title, '| ');
		return response()->view($template, array_merge($this->data, $parameters), $status);
	}

	// Universal abstraction for pagination, to use Laravel's native implementation with "/{slug}/{pageNo}"
	protected function paginate(Builder $query, int $page = 1): LengthAwarePaginator
	{
		return $query->paginate($this->request->query('aantal', 20), ['*'], 'pagina', $page);
	}
}
