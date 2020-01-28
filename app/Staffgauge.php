<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staffgauge extends Model
{
    protected $table ="staffgauge";

    protected $primaryKey = 'id';

    protected $fillable = ['addressgauge','amphoe','district','province','latitudegauge','longitudegauge'];

    public function location(){
        return $this->hasMany('App\Location', 'staffgaugeid');
    }

    public function ocr(){
        return $this->hasMany('App\Ocr', 'staffgaugeid');
    }

    public function profile(){
        return $this->belongsTo('App\Profile', 'lineid');
    }
}
