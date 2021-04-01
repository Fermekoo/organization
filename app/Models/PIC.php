<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PIC extends Model
{
    use SoftDeletes;

    protected $table    = 'organization_pic';
    protected $fillable = ['organization_id','name','email','avatar'];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
