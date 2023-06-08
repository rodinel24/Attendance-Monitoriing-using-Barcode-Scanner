<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScannedBarcode extends Model
{
    protected $fillable = [
        'barcode',
        'date',
        'time',
        'first_name',
        'last_name',
        'middle_name',
        'section',
        'year_level',
    ];
}
