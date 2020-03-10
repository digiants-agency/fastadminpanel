<?php

namespace Digiants\FastAdminPanel\Helpers;
 
use Illuminate\Support\Facades\DB;
use Config;
use App\Translates;
use App;
use Lang;
use View;
 
class Translater {
    
    private static $cache = [];

    public static function tr($title, $value, $group, $controller = '') {

        if ($controller == '') {
            $action = app('request')->route()->getAction();
            $controller = class_basename($action['controller']);
        }

        if (App::environment('local') && isset($_GET['save_translates']) && $_GET['save_translates'] == 'true') {

            $translate = DB::table('translates')
            ->select('id')
            ->where('slug', $controller)
            ->where('language', Lang::get())
            ->first();
            
            if ($translate == null) {
                
                $database = Config::get('database.connections.mysql.database');
                $next_id = DB::select(DB::raw("SELECT `AUTO_INCREMENT`
                FROM  INFORMATION_SCHEMA.TABLES
                WHERE TABLE_SCHEMA = '$database'
                AND   TABLE_NAME   = 'translates'"))[0]->AUTO_INCREMENT;

                foreach (Lang::get_langs() as $l) {
                    DB::table('translates')->insert([
                        'title'         => $controller,
                        'slug'          => $controller,
                        'language'      => $l->tag,
                        'language_id'   => $next_id,
                        'phrases'       => json_encode([
                            $group => [
                                $title => $value,
                            ],
                        ], JSON_UNESCAPED_UNICODE),
                    ]);
                }

            } else {

                foreach (Lang::get_langs() as $l) {
                    $tr = DB::table('translates')->where('slug', $controller)->where('language', $l->tag)->first();
                    $phrases = json_decode($tr->phrases, true);
                    if (!isset($phrases[$group][$title])) {
                        $phrases[$group][$title] = $value;
                        DB::table('translates')
                        ->where('slug', $controller)
                        ->where('language', $l->tag)
                        ->update([
                            'phrases'   => json_encode($phrases, JSON_UNESCAPED_UNICODE),
                        ]);
                    }
                }
            }

        } else {

            if (!isset($cache[$controller])) {

                $translate = DB::table('translates')
                ->where('slug', $controller)
                ->where('language', Lang::get())
                ->first();
                
                $phrases = json_decode($translate->phrases, true);
                
                $cache[$controller] = $phrases;
            }
            
            return Translater::prepare_content($cache[$controller][$group][$title]);
        }

        return 'Saved';
    }

    private static function prepare_content ($content) {
        return str_replace('
', '<br>', str_replace(']', '</span>', str_replace('[', '<span>', $content)));
    }
}