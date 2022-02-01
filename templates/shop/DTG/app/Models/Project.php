<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Project extends MultilanguageModel
{
    protected $table = 'projects';
    
    public function __construct(){
        parent::__construct();
    }

    protected static function booted(){

        static::addGlobalScope('is_show', function (Builder $builder) {
            $builder->where('is_show', '=' , 1);
        });
    }

    public function get_projects($page = 1, $pagesize = 6){

        $projects = $this::orderBy('sort', 'DESC')
        ->skip(($page - 1) * $pagesize)
		->limit($pagesize)
        ->get();

        return $projects;
    }

    public function get_project($slug){
        
        $project = $this::where('slug', $slug)
        ->first();

		$project->gallery = json_decode($project->gallery);

        return $project;
    }

    public function get_main_page_projects(){

        $main_page_projects = $this::where('is_main', 1)
        ->orderBy('sort', 'DESC')
        ->get();
        
        return $main_page_projects;
    }

}
