<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableRow extends Model
{
    protected $fillable = [
        'table_id',
        'category',
        'part_no',
        'brand_name',
        'unit',
        'po_number',
        'vsl',
        'bl_num',
        'etd',
        'revised_etd',
        'eta',
        'revised_eta',
        'cleared_date',
        'container_no',
        'no_of_cantainer',
        'location',
        'clearing_agent',
        'cusdec_ref',
        'reason_for_kpi_failure',
    ];

    protected $casts = [
        'etd' => 'date',
        'revised_etd' => 'date',
        'eta' => 'date',
        'revised_eta' => 'date',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
