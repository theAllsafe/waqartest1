<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table='tbl_school_like';
    protected $fillable = [
        'school_id',
        'user_id',
        'is_like',
        'created_at',
        'updated_at'
    ];

}
