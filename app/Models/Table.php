<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status'
    ];
     public function rows()
    {
        return $this->hasMany(TableRow::class, 'table_id');
    }
}
