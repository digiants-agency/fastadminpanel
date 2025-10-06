<?php

namespace App\FastAdminPanel\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class ExistsOrZero implements ValidationRule
{
    protected $tableName;

    protected $tableColumn;

    public function __construct($tableName, $tableColumn = 'id')
    {
        $this->tableName = $tableName;
        $this->tableColumn = $tableColumn;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value != 0) {

            $result = DB::table($this->tableName)
                ->where($this->tableColumn, $value)
                ->first();

            if (empty($result)) {

                $fail('The :attribute must exist or be zero.');
            }
        }
    }
}
