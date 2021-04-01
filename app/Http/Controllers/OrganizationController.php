<?php

namespace App\Http\Controllers;

use App\Repositories\ManagerRepo;
use App\Repositories\OrganizationRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    protected $organization;
    protected $manager;
    public function __construct(OrganizationRepo $organization, ManagerRepo $manager)
    {
        $this->organization = $organization;
        $this->manager      = $manager;
    }

    public function index()
    {
        $organizations = $this->organization->getAll();

        return view('organization.index',compact('organizations'));
    }

    public function create()
    {   
        $managers = $this->manager->getAll();
        return view('organization.create', compact('managers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'managerId' => 'required|exists:account_managers,id',
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
}
