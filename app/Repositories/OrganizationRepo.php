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
                'name'              => strip_tags($request->fullname),
                'email'             => strip_tags($request->email),
                'website'           => strip_tags($request->website),
                'logo'              => $logo_name,
                'phone'             => strip_tags($request->phone),
                'created_by'        => auth()->user()->id
            ]);
        } catch (QueryException $e) {
            throw $e;
        }

        return $org;
    }

    public function update($id, $request)
    {
        $manager = auth()->user()->manager;
        
        if(!$manager) throw new \Exception('Unauthorized');

        $logo_name = null;
        $logo      = $request->file('logo');
        if($logo) : 
            try {
                
                $logo_name  = Str::random(16).'.'.$logo->extension();
                $logo->storeAs('public/organizations', $logo_name);

            } catch (\Exception $e) {
                throw $e;
            }
        endif;

        $org = Organization::find($id);

        try {
            
            $org->name     = strip_tags($request->fullname);
            $org->email    = strip_tags($request->email);
            $org->website  = strip_tags($request->website);
            $org->logo     = $logo_name ?? $org->logo; 
            $org->phone    = strip_tags($request->phone);
            $org->save();

        } catch (QueryException $e) {
            throw $e;
        }

        return $org;
    }

    public function addManager($id, $manager_id)
    {
        try {

            $org = Organization::find($id);
            $org->account_manager_id = $manager_id;
            $org->save();

        } catch (QueryException $e) {
            throw $e;
        }

        return $org;
    }
}