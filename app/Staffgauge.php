<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staffgauge extends Model
{
    protected $table ="staffgauge";

    protected $primaryKey = 'id';

    protected $fillable = ['addressgauge','amphoe','district','province','latitudegauge','longitudegauge'];
}
