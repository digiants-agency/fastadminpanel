<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Exports\Export;
use App\FastAdminPanel\Imports\Import;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;

class ExchangeController extends Controller
{
	public function export($table)
	{
		$this->authorize('something', [$table, 'admin_read']);

		return Excel::download(new Export($table), "export_".$table.date('YmdHis').".xlsx");
	}

	public function import(Request $request, $table)
	{
		$this->authorize('something', [$table, 'admin_edit']);

		$file = $request->file('xlsx');

		Excel::import(new Import($table), $file);

		return Response::json();
	}
}