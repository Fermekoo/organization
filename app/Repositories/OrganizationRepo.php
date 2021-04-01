<?php 
namespace App\Repositories;

use App\Models\Organization;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class OrganizationRepo
{
    public function getAll()
    {
        $organizations = Organization::get();

        return $organizations;
    }

    public function findById($id)
    {
        $organization = Organization::find($id);

        return $organization;
    }

    public function create($request)
    {
        try {
            $logo       = $request->file('logo');
            $logo_name  = Str::random(16).'.'.$logo->extension();
            $logo->storeAs('public/organizations', $logo_name);

        } catch (\Exception $e) {
            throw $e;
        }

        try {
           $org = Organization::create([
               'account_manager_id' => $request->managerId,
                'name'              => strip_tags($request->fullname),
                'email'             => strip_tags($request->email),
                'website'           => strip_tags($request->website),
                'logo'              => $logo_name,
                'phone'             => strip_tags($request->phone)
            ]);
        } catch (QueryException $e) {
            throw $e;
        }

        return $org;
    }
}