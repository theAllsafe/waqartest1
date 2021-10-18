<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatList extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function recieveruser(){
       return $this->hasOne(Users::class,'id','reciever_id');
    }

    public function user(){
       return $this->hasOne(Users::class,'id','sender_id');
    }
}
