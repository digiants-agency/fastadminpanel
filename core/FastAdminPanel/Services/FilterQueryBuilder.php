<?php

namespace App\FastAdminPanel\Services;

use Illuminate\Database\Eloquent\Builder;

class FilterQueryBuilder
{
    protected $request;
    
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function buildQuery($query)
    {
        $filters = $this->request->query('filters');

        $filters = $this->parseFilters($filters);

        foreach($filters as $filter) {
          $query = $this->addFiltersToQuery($query, $filter);
        }

        return $query;
    }

    private function getOperator($filter)
    {
        $operatorsPattern = '/=|!=|\(\)|>=|<=|~|>|</';
        
        $operator = [];
        preg_match($operatorsPattern, $filter, $operator);
        
        if (count($operator) == 1) {
        
            return $operator[0];
        }
    }

    private function getFilterValue($filter, $operator)
    {
        $result = explode($operator, $filter);

        if(count($result) == 2) {
            return $result[1];
        }
    }

    private function getFilterRelations($filter, $operator)
    {
        $result = explode($operator, $filter);

        if(count($result) == 2) {
            return $result[0];
        }
    }

    private function createRelationTree(string $relationKeys, $operator, $value)
    {
        $relations = explode('.', $relationKeys);
        $lastKey = array_key_last($relations);
        
        $field = $relations[$lastKey];
        
        unset($relations[$lastKey]);

        $result = [];

        if (count($relations) > 0 ) {
            
            $result[$relations[count($relations)-1]] = [
                'field' => $field,
                'operator' => $operator,
                'value' => $value
            ];

            for ($i=count($relations)-2; $i>-1; $i--) {
                $result[$relations[$i]] = $result;
                unset($result[$relations[$i+1]]);
            }

        } else {
            $result = [
                'field' => $field,
                'operator' => $operator,
                'value' => $value
            ];
        }

        return $result;
    }

    private function parseFilters($filters)
    {
        if(empty($filters)) {
            return [];
        }

        $result = [];

        foreach ($filters as $filter) {
            
            if (empty($filter)) {
                continue;
            }

            $operator = $this->getOperator($filter);
            $value = $this->getFilterValue($filter, $operator);
            $keys = $this->getFilterRelations($filter, $operator);
            $relationTree = $this->createRelationTree($keys, $operator, $value);

            array_push($result, $relationTree);
        }

        return $result;
    }

    private function addFiltersToQuery($query, $filters)
    {
        if(count($filters) === 3) {

            switch($filters['operator']) {
                
                case '()':

                    return $query->whereIn($filters['field'], explode(',', $filters['value']));

                case '~':
                    
                    return $query->where($filters['field'], 'LIKE', '%' . $filters['value'] . '%');

                default:

                    return $query->where($filters['field'], $filters['operator'], $filters['value']);
          }
        }

        $relation = array_key_first($filters);

        return $query->whereHas($relation, function(Builder $query) use($relation, $filters) {
            $this->addFiltersToQuery($query, $filters[$relation]);
        });
    }
}