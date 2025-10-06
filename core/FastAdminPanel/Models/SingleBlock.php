<?php

namespace App\FastAdminPanel\Models;

use Illuminate\Database\Eloquent\Model;

class SingleBlock extends Model
{
    public $timestamps = false;

    protected $table = 'single_blocks';

    protected $fillable = [
        'title',
        'slug',
        'sort',
        'single_page_id',
    ];

    public function fields()
    {
        return $this->hasMany(SingleField::class, 'single_block_id');
    }
}
