<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'locations';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['address', 'latitude', 'longitude','typegroup','lineid','staffgaugeid','user_id'];

    public function staffgauge(){
        return $this->belongsTo('App\Staffgauge', 'staffgaugeid');
    }

    public function ocr(){
        return $this->belongsTo('App\Ocr', 'lineid');
    }

    public function profile(){
        return $this->belongsTo('App\Profile', 'lineid');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
