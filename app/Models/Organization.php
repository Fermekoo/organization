<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    protected $table    = 'organizations';
    protected $fillable = ['account_manager_id','name','email','phone','website','logo'];

    public function manager()
    {
        return $this->belongsTo(AccountManager::class, 'account_manager_id');
    }

    public function pic()
    {
        return $this->hasMany(PIC::class, 'organization_id');
    }
}
