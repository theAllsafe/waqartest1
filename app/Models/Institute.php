<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table='tbl_institute';
    protected $fillable = [
        'institute_id',
        'telephone_number',
        'fax_number',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip',
        'country',
        'created_at',
        'updated_at'
    ];

}
