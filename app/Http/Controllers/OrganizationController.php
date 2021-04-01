<?php

namespace App\Http\Controllers;

use App\Repositories\ManagerRepo;
use App\Repositories\OrganizationRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    protected $organization;
    public function __construct(OrganizationRepo $organization)
    {
        $this->organization = $organization;
    }

    public function index()
    {
        $organizations = $this->organization->getAll();

        return view('organization.index',compact('organizations'));
    }

    public function create()
    {   
        return view('organization.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname'  => 'required',
            'phone'     => 'required|numeric:digits_between,6,16',
            'email'     => 'required|email|unique:organizations,email',
            'website'   => 'required|url',
            'logo'      => 'required|image|mimes:png,jpg,jpeg'
        ]);

        if($validator->fails()){
            return back()->withInput($request->all())->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->organization->create($request);
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }

        return redirect()->route('org.index')->with('success','Organization Created Successfully');

    }

    public function detail($id)
    {
        $organization = $this->organization->findById($id);
        if(!$organization) return redirect()->route('org.index')->with('error','Organization Not Found');
        
        return view('organization.detail',compact('organization'));
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname'  => 'required',
            'phone'     => 'required|numeric:digits_between,6,16',
            'email'     => 'required|email|unique:organizations,email,'.$id,
            'website'   => 'required|url',
            'logo'      => 'nullable|image|mimes:png,jpg,jpeg'
        ]);

        if($validator->fails()){
            return back()->withInput($request->all())->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->organization->update($id, $request);
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }

        return redirect()->route('org.index')->with('success','Organization updated Successfully');
    }

    public function addManager($id)
    {   
        $organization = $this->organization->findById($id);

        if(!$organization) return redirect()->route('org.index')->with('error','Organization Not Found');

        $manager_repo = new ManagerRepo;

        $managers = $manager_repo->getAll();

        return view('organization.add-manager',compact('organization','managers'));
    }

    public function assignManager($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'managerId'  => 'required|exists:account_managers,id'
        ]);

        if($validator->fails()){
            return back()->withInput($request->all())->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->organization->addManager($id, $request->managerId);
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }

        return redirect()->route('org.index')->with('success','Organization Added Successfully');
    }

    public function delete($id)
    {
        try {
            $this->organization->delete($id);
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }

        return redirect()->route('org.index')->with('success','Organization Deleted Successfully');
    }
}
