<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Response;

	class HomepageController extends Controller
	{
		public function index()
		{
			return $this->render('index');
		}
	}