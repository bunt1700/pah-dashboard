<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var string[] */
    protected $title = [];

    /** @var array */
    protected $data = [];

	// Abstraction because we want the title to be set on all pages
	protected function render(string $template, array $parameters = [], int $status = 200): Response
	{
		$title = array_map('trim', $this->title);
		$title = array_filter($title);

		array_unshift($title, 'Product aan Huis dashboard');
		$this->data['title'] = implode(' | ', $title);

		return response()->view($template, array_merge($this->data, $parameters), $status);
	}

	// Universal abstraction for pagination, to use Laravel's native implementation with "/{slug}/{pageNo}"
	protected function paginate(Builder $query, int $page = 1, int $items = 20): LengthAwarePaginator
	{
		return $query->paginate($items, ['*'], 'pagina', $page);
	}
}
