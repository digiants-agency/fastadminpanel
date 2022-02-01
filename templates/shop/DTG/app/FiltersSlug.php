<?php

namespace App;

class FiltersSlug {

    public $filters;

    public function __construct($slug = ''){
        
        $filters = collect();
        
        if (empty($slug))
            return [];

        $slug_parts = explode('/', $slug);

        foreach ($slug_parts as $slug_part){
            
			$slug_part = explode('--', $slug_part);

            if (!isset($filters[$slug_part[0]])){
                $filters->put($slug_part[0], collect());
            }

            if (!isset($slug_part[1]))
                abort(404);
            
            $filters[$slug_part[0]]->push($slug_part[1]);    

		}

        $this->filters = $filters;

    }

    public function is_checked($filter_slug, $filter_field_slug){
        
        if (!isset($this->filters[$filter_slug]))
            return false;


        return $this->filters[$filter_slug]->contains($filter_field_slug);
    }

}