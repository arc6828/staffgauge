<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table ="profiles";

    protected $primaryKey = 'id';

    protected $fillable = ['role','user_id','photo'];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function ocr(){
        return $this->hasMany('App\Ocr', 'user_id');
    }

}
