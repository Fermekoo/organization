<?php 
namespace App\Repositories;

use App\Models\Organization;
use App\Models\PIC;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class PICRepo
{
    public function getByOrganization($org_id)
    {
        $pic = PIC::where('organization_id',$org_id)->get();

        return $pic;
    }

    public function findById($org_id, $id)
    {
        $pic = PIC::where('organization_id',$org_id)->find($id);

        return $pic;
    }

    public function create($org_id, $request)
    {
        $org = Organization::find($org_id);
        if(!$org || !auth()->user()->manager || auth()->user()->manager->id != $org->account_manager_id) throw new \Exception('Unauthorized');

        try {
            $avatar       = $request->file('avatar');
            $avatar_name  = Str::random(16).'.'.$avatar->extension();
            $avatar->storeAs('public/avatars', $avatar_name);

        } catch (\Exception $e) {
            throw $e;
        }

        try {
            $create = PIC::create([
                'organization_id' => $org_id,
                'name'            => strip_tags($request->fullname),
                'email'           => strip_tags($request->email),
                'phone'           => strip_tags($request->phone),
                'avatar'          => $avatar_name
            ]);
        } catch (QueryException $e) {
            throw $e;
        }

        return $create;
    }

    public function update($org_id, $id, $request)
    {
        $org = Organization::find($org_id);
        if(!$org || !auth()->user()->manager || auth()->user()->manager->id != $org->account_manager_id) throw new \Exception('Unauthorized');

        $avatar_name = null;
        $avatar       = $request->file('avatar');
        if($avatar) : 
            try {
                $avatar_name  = Str::random(16).'.'.$avatar->extension();
                $avatar->storeAs('public/avatars', $avatar_name);
    
            } catch (\Exception $e) {
                throw $e;
            }
        endif;

        $pic = PIC::where('organization_id',$org_id)->find($id);

        try {
           
            $pic->name   = strip_tags($request->fullname);
            $pic->email  = strip_tags($request->email);
            $pic->phone  = strip_tags($request->phone);
            $pic->avatar = $avatar_name ?? $pic->avatar;
            $pic->save();

        } catch (QueryException $e) {
            throw $e;
        }

        return $pic;
    }

    public function delete($org_id, $id)
    {
        $org = Organization::find($org_id);
        if(!$org || !auth()->user()->manager || auth()->user()->manager->id != $org->account_manager_id) return false;

        return PIC::where(['organization_id' => $org_id, 'id' => $id])->delete();
    }
}