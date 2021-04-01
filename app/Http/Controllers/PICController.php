<?php

namespace App\Http\Controllers;

use App\Repositories\OrganizationRepo;
use App\Repositories\PICRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PICController extends Controller
{
    protected $pic;
    protected $organization;
    public function __construct(PICRepo $pic, OrganizationRepo $organization)
    {
        $this->pic          = $pic;
        $this->organization = $organization;
    }

    public function create($org_id)
    {
        $organization = $this->organization->findById($org_id);
        if(!$organization) return redirect()->route('org.index')->with('error','Organization Not Found');

        return view('pic.create',compact('organization'));
    }

    public function store($org_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname'  => 'required',
            'phone'     => 'required|numeric:digits_between,6,16',
            'email'     => 'required|email|unique:organizations,email',
            'avatar'    => 'required|image|mimes:png,jpg,jpeg'
        ]);

        if($validator->fails()){
            return back()->withInput($request->all())->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->pic->create($org_id, $request);
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }

        return redirect()->route('org.detail', $org_id)->with('success','PIC Created Successfully');
    }

    public function detail($org_id, $id)
    {
        $pic = $this->pic->findById($org_id, $id);
        if(!$pic) return redirect()->route('org.detail',$org_id)->with('error','PIC Not Found');

        return view('pic.detail', compact('pic'));
    }

    public function update($org_id, $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname'  => 'required',
            'phone'     => 'required|numeric:digits_between,6,16',
            'email'     => 'required|email|unique:organizations,email',
            'avatar'    => 'nullable|image|mimes:png,jpg,jpeg'
        ]);

        if($validator->fails()){
            return back()->withInput($request->all())->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->pic->update($org_id, $id, $request);
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }

        return redirect()->route('org.detail', $org_id)->with('success','PIC Updated Successfully');
    }

    public function delete($org_id, $id)
    {
        try {
            $this->pic->delete($org_id, $id);
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }

        return redirect()->route('org.detail', $org_id)->with('success','PIC Deleted Successfully');
    }

}
