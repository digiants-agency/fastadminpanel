<?php

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Models\Crud;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class DashboardController
{
	public function index()
	{
		$statistics = Crud::get()
		->where('is_statistics', 1)
		->map(function ($crud) {

			$count = DB::table($crud->table)->count();

			$entities = DB::table($crud->table)
			->select(DB::raw('DATE(created_at) as d'), DB::raw('COUNT(*) as count'))
			->where('created_at', '>=', now()->subDays(7))
			->groupBy('d')
			->get()
			->pluck('count', 'd');

			$dates = collect([]);

			for ($i = 6; $i >= 0; $i--) {

				$date = date('Y-m-d', strtotime($i . ' days ago'));
				$dates[] = [
					'date'	=> $date,
					'count' => $entities[$date] ?? 0,
				];
			}

			return [
				'table'	=> $crud->table_name,
				'title'	=> $crud->title,
				'dates'	=> $dates,
				'count'	=> $count,
			];
		})
		->values();

		return Response::json($statistics);
	}
}