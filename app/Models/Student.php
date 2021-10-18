<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table='tbl_student';
    protected $fillable = [
        'sid',
        'current_status',
        'school_id',
        'category_id',
        'session',
        'class_id',
        'section_id',
        'enrollment_number',
        'created_at',
        'updated_at'
    ];

}
