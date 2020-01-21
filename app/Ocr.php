<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ocr extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ocrs';

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
    protected $fillable = ['title', 'content', 'photo','user_id','json_line','lineid','numbers','staffgaugeid','locationid'];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function profile(){
        return $this->belongsTo('App\Profile', 'user_id');
    }

    public function location(){
        return $this->hasOne('App\Location', 'lineid');
    }

    public function staffgauge(){
        return $this->hasOne('App\Staffgauge', 'lineid');
    }
    
}
