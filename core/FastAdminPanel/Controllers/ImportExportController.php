<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Exports\Export;
use App\FastAdminPanel\Imports\Import;
use App\FastAdminPanel\Responses\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends \App\Http\Controllers\Controller
{
    public function export ($table)
	{	
        return Excel::download(new Export($table), "export_".$table.date('YmdHis').".xlsx");
	}

    public function import (Request $r, $table)
    {
        $file = $r->file('xlsx');

        Excel::import(new Import($table), $file);

        return JsonResponse::response();
    }
}