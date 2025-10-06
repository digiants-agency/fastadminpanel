<?php

namespace App\FastAdminPanel\Services\Crud\Entity;

use App\FastAdminPanel\Models\Crud;
use App\FastAdminPanel\Services\Crud\TableService;
use Illuminate\Support\Facades\DB;

class FieldService
{
    public function __construct(
        protected TableService $tableService,
    ) {}

    public function update($data, $table, $entity_id, $field_id)
    {
        $crud = Crud::findOrFail($table);

        $field = $crud->fields->first(fn ($f) => $f->id == $field_id);

        if ($field->isCommon()) {

            $tables = $this->tableService->getTables($table);

        } else {

            $tables = [$this->tableService->getTable($table)];
        }

        foreach ($tables as $table) {

            DB::table($table)
                ->where('id', $entity_id)
                ->update([
                    $field->db_title => $data['value'],
                ]);
        }
    }
}
