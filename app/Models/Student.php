<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'id_number',
        'section',
        'year_level',
        'address',
        'student_image',
    ];

    public function scans()
    {
        return $this->hasMany(Scan::class);
    }
    public function getImageUrl()
    {
        return $this->student_image ? Storage::url('students/' . $this->student_image) : null;
    }
    
}
