<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountManager extends Model
{
    use SoftDeletes;

    protected $table    = 'account_managers';
    protected $fillable = ['user_id','fullname'];

    public function organizations()
    {
        return $this->hasMany(Organization::class, 'account_manager_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
