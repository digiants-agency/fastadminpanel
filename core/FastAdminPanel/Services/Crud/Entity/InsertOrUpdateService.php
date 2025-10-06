<?php

namespace App\FastAdminPanel\Services\Crud\Entity;

use App\FastAdminPanel\Contracts\CrudEntity\InsertOrUpdate;
use App\FastAdminPanel\Models\Crud;
use App\FastAdminPanel\Services\Crud\TableService;
use Illuminate\Support\Facades\DB;

class InsertOrUpdateService implements InsertOrUpdate
{
    public function __construct(
        protected TableService $tableService,
    ) {}

    public function save($input)
    {
        $this->setDynamicFields($input);
    }

    // TODO: refactor
    protected function setDynamicFields($input, $parent_table = false, $parent_id = false)
    {
        $crud = Crud::findOrFail($input['table']);

        $fields = collect($input['fields'])->map(fn ($f) => (object) $f);

        $update = [];
        $update_multilanguage = [];

        foreach ($fields as $field) {

            if ($field->type == 'relationship') {

                if ($field->relationship_count == 'single') {

                    if ($crud->multilanguage == 1 && $field->lang == 0) {

                        $update_multilanguage['id_'.$field->relationship_table_name] = $field->value;
                    }

                    $update['id_'.$field->relationship_table_name] = $field->value;
                } // other rels are below

            } elseif ($field->type == 'gallery') {

                if ($crud->multilanguage == 1 && $field->lang == 0) {

                    $update_multilanguage[$field->db_title] = json_encode($field->value, JSON_UNESCAPED_UNICODE);
                }

                $update[$field->db_title] = json_encode($field->value, JSON_UNESCAPED_UNICODE);

            } elseif ($field->type == 'password') {

                if ($input['id'] == 0) {

                    if (empty($field->value)) {

                        $update[$field->db_title] = '';

                    } else {

                        $update[$field->db_title] = bcrypt($field->value);
                    }

                } else {

                    if (! empty($field->value)) {

                        if ($crud->multilanguage == 1 && $field->lang == 0) {

                            $update_multilanguage[$field->db_title] = bcrypt($field->value);
                        }

                        $update[$field->db_title] = bcrypt($field->value);
                    }
                }

            } else {

                if ($crud->multilanguage == 1 && $field->lang == 0) {

                    $update_multilanguage[$field->db_title] = $field->value ?? '';
                }

                $update[$field->db_title] = $field->value ?? '';
            }
        }

        if (! empty($update)) {

            if ($input['id'] == 0) {

                $tables = $this->tableService->getTables($input['table']);

                foreach ($tables as $table) {

                    $update['id'] = DB::table($table)->insertGetId($update);
                    $input['id'] = $update['id'];

                    if ($parent_table) {
                        DB::table($table)
                            ->where('id', $input['id'])
                            ->update([
                                "id_$parent_table" => $parent_id,
                            ]);
                    }
                }

            } else {

                $table_main = $this->tableService->getTable(
                    $input['table'],
                );

                DB::table($table_main)
                    ->where('id', $input['id'])
                    ->update($update);

                if ($crud->multilanguage == 1 && ! empty($update_multilanguage)) {

                    foreach ($this->tableService->getTables($input['table']) as $table) {

                        if ($table_main == $table) {
                            continue;
                        }

                        DB::table($table)
                            ->where('id', $input['id'])
                            ->update($update_multilanguage);
                    }
                }
            }
        }

        // editable and many relations START
        foreach ($fields as $field) {

            if ($field->type == 'relationship') {

                if ($field->relationship_count == 'many') {

                    $table_relationship = $input['table'].'_'.$field->relationship_table_name;
                    $col_first = 'id_'.$input['table'];
                    $col_last = 'id_'.$field->relationship_table_name;

                    if ($col_first == $col_last) {
                        $col_last = $col_last.'_other';
                    }

                    DB::table($table_relationship)
                        ->where($col_first, $input['id'])
                        ->delete();

                    $many_insert = [];

                    foreach ($field->value as $id) {
                        $many_insert[] = [
                            $col_first => $input['id'],
                            $col_last => $id,
                        ];
                    }

                    DB::table($table_relationship)
                        ->insert($many_insert);

                } elseif ($field->relationship_count == 'editable') {

                    $editable_ids = DB::table($this->tableService->getTable(
                        $field->relationship_table_name,
                    ))
                        ->select('id')
                        ->where('id_'.$input['table'], $input['id'])
                        ->get()
                        ->pluck('id');

                    $current_ids = array_column($field->value, 'id');
                    $diff_ids = array_diff($editable_ids->all(), $current_ids);

                    $tables = $this->tableService->getTables(
                        $field->relationship_table_name,
                    );

                    foreach ($tables as $table) {

                        DB::table($table)
                            ->whereIn('id', $diff_ids)
                            ->delete();
                    }

                    foreach ($field->value as $group) {

                        $groupFields = collect($group['fields'])
                            ->map(function ($f) use ($input) {

                                if ($f['type'] == 'relationship' && $f['relationship_count'] == 'single' && $f['relationship_table_name'] == $input['table']) {

                                    $field_title = 'id_'.$input['table'];
                                    $f[$field_title] = $input['id'];
                                }

                                return $f;
                            });

                        $this->setDynamicFields([
                            'fields' => $groupFields,
                            'table' => $field->relationship_table_name,
                            'id' => $group['id'],
                        ], $input['table'], $input['id']);
                    }
                }
            }
        }
        // editable and many relations END
    }
}
