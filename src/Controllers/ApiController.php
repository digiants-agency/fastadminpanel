<?php 

namespace Digiants\FastAdminPanel\Controllers;

use App\User;
use DB;
use Schema;
use Validator;

class ApiController extends \App\Http\Controllers\Controller {

    public function db_select () {

        $table = $this->get_val('table', 'error');
        $offset = $this->get_val('offset', 0);
        $limit = $this->get_val('limit', 100);
        $order = $this->get_val('order', 'id');
        $fields = $this->get_val('fields', '*');
        $where = $this->get_val('where', '');
        $language = $this->get_val('language', '');
        $relationships = $this->get_val('relationships', '');   // many

        $values = DB::table($table)
        ->selectRaw($fields)
        ->when($where != '', function($q) use ($where){
            $q->whereRaw($where);
        })
        ->when($language != '', function($q) use ($language){
            $q->where('language', $language);
        })
        ->offset($offset)
        ->limit($limit)
        ->orderBy(DB::raw($order))
        ->get();

        if ($relationships == '') {

            return $values;

        } else {

            $rels = json_decode($relationships);

            foreach ($rels as $rel) {

                $rel_id = $rel[0];
                $rel_table = $rel[1];
                $rel_connected_table = $rel[2];
    
                $vals = DB::table($rel_table)
                ->select('id_' . $rel_connected_table.' as id')
                ->where('id_'.$table, $rel_id)
                ->get();

                $field = [];

                foreach ($vals as $v) {
                    $field[] = [$rel_connected_table => $v->id];
                }

                $val_title = '$'.$rel_table;

                $values->map(function ($item) use ($val_title, $field) {

                    $item->$val_title = $field;
                    return $item;
                });
            }

            return $values;
        }
    }

    private function get_val ($title, $default = '') {
        
        $r = request();
        $val = $r->get($title);

        if (!empty($val))
            return $val;
        return $default;
    }

    public function db_create_table () {

        $r = request();

        Schema::create($r->get('table_name'), function ($table) use ($r) {
            $table->bigIncrements('id');
            $table->string('language')->nullable();
            $table->integer('language_id')->nullable();
            
            foreach (json_decode($r->get('fields')) as $field) {
                $this->add_field($table, $field);
            }

            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            if ($r->get('is_soft_delete') == 1)
                $table->timestamp('deleted_at')->nullable();
        });

        DB::table('menu')->insert([
            'title'             => $r->get('title'),
            'table_name'        => $r->get('table_name'),
            'fields'            => $r->get('fields'),
            'is_dev'            => $r->get('is_dev'),
            'multilanguage'     => $r->get('multilanguage'),
            'is_soft_delete'    => $r->get('is_soft_delete'),
            'sort'              => $r->get('sort'),
        ]);

        return 'Success';
    }

    private function add_field(&$table, $field) {

        if ($field->type == 'text') {

            $table->string($field->db_title);

        } else if ($field->type == 'email') {

            $table->string($field->db_title);
            
        } else if ($field->type == 'textarea') {

            $table->text($field->db_title);
            
        } else if ($field->type == 'ckeditor') {

            $table->text($field->db_title);
            
        } else if ($field->type == 'checkbox') {

            $table->integer($field->db_title);
            
        } else if ($field->type == 'color') {

            $table->string($field->db_title);
            
        } else if ($field->type == 'date') {

            $table->date($field->db_title);
            
        } else if ($field->type == 'datetime') {

            $table->dateTime($field->db_title);
            
        } else if ($field->type == 'file') {

            $table->string($field->db_title);
            
        } else if ($field->type == 'photo') {

            $table->string($field->db_title);
            
        } else if ($field->type == 'gallery') {

            $table->text($field->db_title);
            
        } else if ($field->type == 'password') {

            $table->string($field->db_title);
            
        } else if ($field->type == 'money') {

            $table->decimal($field->db_title, 15, 2);
            
        } else if ($field->type == 'number') {

            $table->integer($field->db_title);
            
        } else if ($field->type == 'enum') {
            
        } else if ($field->type == 'repeat') {
            
        } else if ($field->type == 'relationship') {

            if ($field->relationship_count == 'single') {

                $table->integer('id_'.$field->relationship_table_name);

            } else if ($field->relationship_count == 'many') {

                $r = request();

                Schema::create($r->get('table_name').'_'.$field->relationship_table_name, function ($table) use ($r, $field) {
                    $table->bigIncrements('id');
                    
                    $table->integer('id_'.$r->get('table_name'));
                    $table->integer('id_'.$field->relationship_table_name);
                });
            }
            // $field->relationship_view_field
        }
    }

    public function db_remove_table () {

        $r = request();

        Schema::dropIfExists($r->get('table_name'));

        DB::table('menu')->where('id', $r->get('id'))->delete();

        return 'Success';
    }

    // TODO: refactor
    public function db_update_table () {

        $r = request();

        $fields_new = json_decode($r->get('fields'));

        $fields_curr = json_decode(DB::table('menu')
        ->select('fields')
        ->where('id', $r->get('id'))
        ->first()
        ->fields);
        
        //                      \_(0_0)_/
        $this->remove_fields($r->get('table_name'), json_decode($r->get('to_remove')), $fields_curr);
        $this->rename_fields($r->get('table_name'), $fields_new, $fields_curr);
        $this->add_fields($r->get('table_name'), $fields_new, $fields_curr);
        
        DB::table('menu')->
        where('table_name', $r->get('table_name'))->
        update([
            'title'             => $r->get('title'),
            'fields'            => $r->get('fields'),
            'is_dev'            => $r->get('is_dev'),
            'is_soft_delete'    => $r->get('is_soft_delete'),
            'sort'              => $r->get('sort'),
        ]);

        return 'Success';
    }

    private function remove_fields ($table_name, $array_ids_remove, $fields_curr) {
        
        foreach ($array_ids_remove as $id) {
            foreach ($fields_curr as $field) {
                if ($field->id == $id) {
                    Schema::table($table_name, function($table) use ($field) {
                        if ($field->type == 'relationship' && $field->relationship_count == 'single'){

                            $table->dropColumn('id_'.$field->relationship_table_name);

                        } else if ($field->type == 'relationship' && $field->relationship_count == 'many'){

                            $r = request();
                            Schema::dropIfExists($r->get('table_name').'_'.$field->relationship_table_name);

                        } else {

                            $table->dropColumn($field->db_title);
                        }
                    });
                    continue;
                }
            }
        }
    }

    private function rename_fields ($table_name, $fields_new, $fields_curr) {

        foreach ($fields_new as $new) {
            foreach ($fields_curr as $curr) {
                
                if ($new->type == 'relationship' || $curr->type == 'relationship')
                    continue;

                if ($new->id == $curr->id && $new->db_title != $curr->db_title) {
                    Schema::table($table_name, function($table) use ($new, $curr) {
                        $table->renameColumn($curr->db_title, $new->db_title);
                    });
                    continue;
                }
            }
        }
    }

    private function add_fields ($table_name, $fields_new, $fields_curr) {

        foreach ($fields_new as $new) {

            $is_new = true;

            foreach ($fields_curr as $curr) {
                if ($new->id == $curr->id) {

                    $is_new = false;
                    continue;
                }
            }

            if ($is_new) {
                Schema::table($table_name, function($table) use ($new) {
                    $this->add_field($table, $new);
                });
            }
        }
    }

    public function db_insert_or_update_row () {

        $r = request();

        $fields = (array)json_decode($r->get('fields'));
        unset($fields['id']);
        unset($fields['created_at']);
        unset($fields['updated_at']);

        $id = $r->get('id');
        $lang = $r->get('language');

        $relationship_many = $this->db_rm_relationship_many($fields);

        if ($id == 0) {
            $row = DB::table($r->get('table_name'))->insert($fields);

            $new_id = DB::getPdo()->lastInsertId();

            $this->db_add_languages($new_id, $r->get('table_name'), $fields);

            $this->db_add_relationship_many($new_id, $relationship_many);

        } else {
            $row = DB::table($r->get('table_name'))
            ->where('id', $id)
            ->update($fields);

            $this->db_update_languages($id, $r->get('table_name'));

            $this->db_add_relationship_many($id, $relationship_many);
        }

        return 'Success';
    }

    private function db_add_languages ($id, $table_name, $fields) {

        $langs = DB::table('languages')->get();
        $i = 0;
        
        foreach ($langs as $l) {

            if ($i == 0) {

                DB::table($table_name)
                ->where('id', $id)
                ->update([
                    'language' => $l->tag,
                    'language_id' => $id,
                ]);

            } else {

                $fields['language'] = $l->tag;
                $fields['language_id'] = $id;
                DB::table($table_name)->insert($fields);
            }

            $i++;
        }
    }

    private function db_update_languages ($id, $table_name) {

        $langs = DB::table('languages')->get();
        $field_properties = json_decode(DB::table('menu')
        ->select('fields')
        ->where('table_name', $table_name)
        ->first()
        ->fields);

        $row = DB::table($table_name)
        ->where('id', $id)
        ->first();

        $update = [];

        foreach ($langs as $l) {
            foreach ($field_properties as $properties) {
                if ($properties->lang == 0) {
                    $title = $properties->db_title;
                    $update[$properties->db_title] = $row->$title;
                }
            }
        }

        DB::table($table_name)
        ->where('language_id', $row->language_id)
        ->where('id', '!=', $row->id)
        ->update($update);
    }

    private function db_add_relationship_many ($id_first, $relationship_many) {

        $id_first = DB::table(request()->get('table_name'))
        ->select('language_id')
        ->where('id', $id_first)
        ->first()
        ->language_id;

        $col_first = 'id_' . request()->get('table_name');

        foreach ($relationship_many as $rel) {

            foreach ($rel as $table_name_many => $elm) {
                
                DB::table($table_name_many)
                ->where($col_first, $id_first)
                ->delete();

                $data = [];

                foreach ($elm as $obj) {
                    
                    $table_name_last = key((array)$obj);

                    $id_last = $obj->$table_name_last;
                    $col_last = 'id_' . $table_name_last;

                    $data[] = [
                        $col_last => $id_last,
                        $col_first => $id_first,
                    ];
                }
                DB::table($table_name_many)->insert($data);
            }
        }
    }

    private function db_rm_relationship_many (&$fields) {

        $data = [];

        foreach ($fields as $table_name => &$f) {
            if ($table_name[0] == '$') {

                $data[] = [substr($table_name, 1) => $f];
                unset($fields[$table_name]);
            }
        }

        return $data;
    }

    private function db_remove_relationship_many ($id, $language_id, $table_name) {

        $langs = DB::table('languages')->get();
        $field_properties = json_decode(DB::table('menu')
        ->select('fields')
        ->where('table_name', $table_name)
        ->first()
        ->fields);

        foreach ($field_properties as $properties) {
            if ($properties->type == 'relationship' && $properties->relationship_count == 'many') {
                
                DB::table($table_name . '_' . $properties->relationship_table_name)
                ->where('id_' . $table_name, $language_id)
                ->delete();
            }
        }
    }

    public function db_remove_row () {

        $r = request();

        $id = $r->get('id');

        $lang = $r->get('language');

        if ($lang != '') {

            $language_id = DB::table($r->get('table_name'))
            ->select('language_id')
            ->where('id', $id)
            ->where('language', $lang)
            ->first()
            ->language_id;

            DB::table($r->get('table_name'))
            ->where('language_id', $language_id)
            ->delete();

            $this->db_remove_relationship_many($id, $language_id, $r->get('table_name'));

        } else {

            DB::table($r->get('table_name'))
            ->where('id', $id)
            ->delete();
        }
        

        return 'Success';
    }

    public function db_remove_rows () {

        $r = request();

        $ids = json_decode($r->get('ids'));
        
        $lang = $r->get('language');

        if ($lang != '') {
            foreach ($ids as $id) {
                
                $language_id = DB::table($r->get('table_name'))
                ->select('language_id')
                ->where('id', $id)
                ->where('language', $lang)
                ->first()
                ->language_id;

                DB::table($r->get('table_name'))
                ->where('language_id', $language_id)
                ->delete();

                $this->db_remove_relationship_many($id, $language_id, $r->get('table_name'));
            }
        } else {

            DB::table($r->get('table_name'))
            ->whereIn('id', $ids)
            ->delete();
        }

        return 'Success';
    }

    public function db_relationship () {

        $r = request();

        // $table_name = $r->get('table_name');
        $field = json_decode($r->get('field'));
        $lang = $r->get('language');

        return DB::table($field->relationship_table_name)
        ->select('language_id as id', $field->relationship_view_field.' as title')
        ->where('language', $lang)
        ->get();
    }
    
    public function upload_image () {

        $data = request()->all();
        
        $validator = Validator::make($data, [
            'upload'      => 'image|max:10000'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        };

        $upload_path = "photos/1/";

        $img = request()->file('upload');

        if ($img != null) {
            $img_name = $img->getClientOriginalName();
            $img->move($upload_path, $img_name);

            return response()->json('{"url":"' . $upload_path . '/' . $img_name . '"}');
        }

        return response()->json('{"error":"Error, file not found"}');
    }

    public function update_languages () {

    }
}