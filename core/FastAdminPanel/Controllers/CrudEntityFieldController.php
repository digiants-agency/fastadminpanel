<?php

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Services\Crud\Entity\FieldService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CrudEntityFieldController extends Controller
{
    public function __construct(
        protected FieldService $fieldService,
    ) {}

    // TODO: add validation
    public function update(Request $request, $table, $entity_id, $field_id)
    {
        $this->authorize('something', [$table, 'admin_edit']);

        $data = $request->all();

        $this->fieldService->update($data, $table, $entity_id, $field_id);

        return Response::json();
    }
}
