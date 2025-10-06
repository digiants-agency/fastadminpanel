<?php

namespace App\FastAdminPanel\Services\Crud\Entity;

use App\FastAdminPanel\Contracts\CrudEntity\Index;
use App\FastAdminPanel\Services\Crud\TableService;
use Illuminate\Support\Facades\DB;

class IndexService implements Index
{
    public function __construct(
        protected TableService $tableService,
    ) {}

    public function get($crud, $data)
    {
        $select = $crud->fields->filter(fn ($f) => $f->show_in_list != 'no')
            ->map(fn ($f) => $f->db_title ? $f->db_title : "id_{$f->relationship_table_name}");

        $query = DB::table($crud->table)
            ->select('id', ...$select)
            ->when(strlen($data['search']) > 1, function ($q) use ($crud, $data) {
                $crud->fields->each(fn ($f) => $f->isSearchable()
                        ? $q->orWhere($f->db_title, 'LIKE', '%'.$data['search'].'%')
                        : null
                );
            });

        $count = $query->count();

        $instances = $query->orderBy($data['order'], $data['sort_order'])
            ->offset($data['offset'])
            ->limit($data['per_page'])
            ->get()
            ->map(function ($i) {
                $i->is_marked = false;

                return $i;
            });

        $relationFields = $crud->fields->filter(fn ($f) => $f->type == 'relationship' && $f->relationship_count == 'single' && $f->show_in_list != 'no'
        );

        foreach ($relationFields as $field) {

            $table = $this->tableService->getTable($field->relationship_table_name);

            $instanceIds = $instances->pluck("id_{$field->relationship_table_name}");

            $relationsById = DB::table($table)
                ->select('id', "{$field->relationship_view_field} AS title")
                ->whereIn('id', $instanceIds)
                ->get()
                ->keyBy('id');

            $relTitle = "id_{$field->relationship_table_name}";

            $instances->each(fn (&$i) => $i->$relTitle = $relationsById[$i->$relTitle]->title ?? '-'
            );
        }

        return [$instances, $count];
    }
}
