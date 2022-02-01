<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Blog extends MultilanguageModel
{
    protected $table = 'blog';
    
    public function __construct(){
        parent::__construct();
    }

    protected static function booted(){

        static::addGlobalScope('is_show', function (Builder $builder) {
            $builder->where('is_show', '=' , 1);
        });
    }

    protected function related () {
		return $this->belongsToMany(Blog::class, 'blog_blog', 'id_blog', 'id_blog_other');
	}

    public function get_blog($page = 1, $pagesize = 9){

        $articles = $this::orderBy('sort', 'DESC')
        ->skip(($page - 1) * $pagesize)
		->limit($pagesize)
        ->get();

        return $articles;
    }

    public function get_article($slug){
        return $this::where('slug', $slug)
        ->first();
    }

    public function get_read_more($id){
        
        $hash = crc32(url()->current());
        srand($hash);

        $read_more = $this::find($id)
        ->related()
        ->get();
        
        if (sizeof($read_more) == 0){

            $read_more = $this::get()
            ->shuffle()
            ->slice(0, 3);
        }

        return $read_more;
    }

    public function get_main_page_blog(){

        $main_page_blog = $this::where('is_main', 1)
        ->orderBy('sort', 'DESC')
        ->get();
        
        return $main_page_blog;
    }

}
