<?php

namespace App\Http\Controllers;

use App\Repositories\ManagerRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller
{
    protected $manager;
    public function __construct(ManagerRepo $manager)
    {
        $this->manager = $manager;
    }
    public function index()
    {
        $managers = $this->manager->getAll();
        return view('manager.index',compact('managers'));
    }

    public function create()
    {
        return view('manager.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|max:50',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return back()->withInput($request->all())->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->manager->create($request);
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }

        return redirect()->route('manager.index')->with('success','Account Manager Created Successfully');
    }

    public function detail($id)
    {
        $manager = $this->manager->findById($id);
        if(!$manager) return redirect()->route('manager.index')->with('error','Account Manager Not Found');

        return view('manager.detail', compact('manager'));
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|max:50',
            'email'    => 'required|email',
            'password' => 'nullable'
        ]);

        if($validator->fails()){
            return back()->withInput($request->all())->with('error','Validation Failed');
        }

        try {

            $this->manager->update($id, $request);

        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }

        return redirect()->route('manager.index')->with('success','Account Manager Updated Successfully');
    }
}
