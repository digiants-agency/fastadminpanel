<?php

namespace App\FastAdminPanel\Services\Crud\Entity;

use App\FastAdminPanel\Contracts\CrudEntity\Index;
use App\FastAdminPanel\Facades\Lang;
use App\FastAdminPanel\Services\Crud\TableService;
use Illuminate\Support\Facades\DB;

class IndexService implements Index
{
    public function __construct(
        protected TableService $tableService,
    ) {}

    public function get($crud, $data, $select = null)
    {
        $query = DB::table($crud->table)
            ->when(mb_strlen($data['search']) > 1, function ($q) use ($crud, $data, $select) {

                if ($select) {

                    collect($select)->each(
                        fn ($f) => $q->orWhere(explode(' ', $f)[0], 'LIKE', '%'.$data['search'].'%')
                    );

                } else {

                    $crud->fields->each(
                        fn ($f) => $f->isSearchable()
                            ? $q->orWhere($f->db_title, 'LIKE', '%'.$data['search'].'%')
                            : null
                    );
                }
            });

        if (! $select) {

            $select = $crud->fields->filter(fn ($f) => $f->show_in_list != 'no')
                ->map(fn ($f) => $f->db_title ? $f->db_title : "id_{$f->relationship_table_name}");
        }

        $query->select('id', 'id_product_filters', ...$select);

        $count = $query->count();

        $filters = DB::table('product_filters_'.Lang::get())
            ->select('id', 'title')
            ->get();

        $instances = $query->orderBy($data['order'], $data['sort_order'])
            ->offset($data['offset'])
            ->limit($data['per_page'])
            ->get()
            ->map(function ($i) use ($filters) {
                $i->is_marked = false;
                $i->title = $filters->where('id', $i->id_product_filters)->first()->title.': '.$i->title;

                return $i;
            });

        $relationFields = $crud->fields->filter(
            fn ($f) => $f->type == 'relationship' && $f->relationship_count == 'single' && $f->show_in_list != 'no'
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

            $instances->each(
                fn (&$i) => $i->$relTitle = $relationsById[$i->$relTitle]->title ?? '-'
            );
        }

        return [$instances, $count];
    }
}
