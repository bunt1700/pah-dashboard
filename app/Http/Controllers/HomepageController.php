<?php

	namespace App\Http\Controllers;

	class HomepageController extends Controller
	{
		public function index()
		{
			return $this->render('index');
		}
	}