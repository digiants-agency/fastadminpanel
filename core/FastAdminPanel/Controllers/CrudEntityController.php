<?php

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Contracts\CrudEntity\Copy;
use App\FastAdminPanel\Contracts\CrudEntity\Destroy;
use App\FastAdminPanel\Contracts\CrudEntity\Index;
use App\FastAdminPanel\Contracts\CrudEntity\InsertOrUpdate;
use App\FastAdminPanel\Contracts\CrudEntity\Show;
use App\FastAdminPanel\Models\Crud;
use App\FastAdminPanel\Requests\Crud\Entity\IndexRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CrudEntityController extends Controller
{
    public function index(IndexRequest $request, Index $indexService, $table)
    {
        $this->authorize('something', [$table, 'admin_read']);

        $crud = Crud::findOrFail($table);

        $data = $request->validated();

        [$instances, $count] = $indexService->get($crud, $data, $data['fields']);

        return Response::json([
            'instances' => $instances,
            'count' => $count,
        ]);
    }

    public function show(Show $showService, $table, $entity_id)
    {
        $this->authorize('something', [$table, 'admin_read']);

        $entity = $showService->get($table, $entity_id);

        return Response::json([
            'entity' => $entity,
        ]);
    }

    // TODO: validation
    public function insertOrUpdate(Request $request, InsertOrUpdate $insertOrUpdate)
    {
        $input = $request->all();

        $this->authorize('something', [$input['table'], 'admin_edit']);

        $insertOrUpdate->save($input);

        return Response::json();
    }

    public function copy(Copy $copyService, $table, $entity_id)
    {
        $this->authorize('something', [$table, 'admin_edit']);

        $crud = Crud::findOrFail($table);

        $copyService->copy($crud, $entity_id);

        return Response::json();
    }

    public function destroy(Destroy $destroyService, $table, $entity_id)
    {
        $this->authorize('something', [$table, 'admin_edit']);

        $crud = Crud::findOrFail($table);

        $destroyService->destroy($crud, [$entity_id]);

        return Response::json();
    }

    // TODO: validation
    public function bulkDestroy(Request $request, Destroy $destroyService, $table)
    {
        $this->authorize('something', [$table, 'admin_edit']);

        $crud = Crud::findOrFail($table);

        $ids = $request->get('ids');

        $destroyService->destroy($crud, $ids);

        return Response::json();
    }
}
