<?php
namespace App\Repositories;

use App\Models\AccountManager;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class ManagerRepo
{
    public function getAll()
    {
        return AccountManager::get();
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
           $user = User::create([
                'name'      => strip_tags($request->fullname),
                'email'     => strip_tags($request->email),
                'password'  => Hash::make($request->password,[]),
                'user_type' => MANAGER
            ]);

        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }

        try {

            $manager = AccountManager::create([
                'user_id'   => $user->id,
                'fullname'  => strip_tags($request->fullname)
            ]);

        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();
        return $manager;
    }

    public function findById($id)
    {
        $manager = AccountManager::find($id);

        return $manager;
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $manager = AccountManager::find($id);
            $manager->fullname          = strip_tags($request->fullname);
            $manager->user->email       = strip_tags($request->email);
            $manager->user->password    = ($request->password) ? Hash::make($request->password) : $manager->user->password;
            $manager->push(); 
        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();
        return $manager;
    }
}