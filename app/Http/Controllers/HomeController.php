<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_customers = Customer::all()->count();

        // Total completed
        $t_contribution = Contribution::where([
            ['request_type', '=' , 'credit'],
            ['status', '=' , 'approved'],
        ])->get();
        $total_contribution = number_format($t_contribution->sum('amount'));
//
        $t_revenue = Contribution::where([
            ['request_type', '=' , 'credit'],
            ['status', '=' , 'approved'],
        ])->get();
        $total_revenue = number_format($t_revenue->sum('gain'));

        $total_staff = User::all()->count();

        $contributions = Contribution::where('status', 'approved')->orderBy('id','desc')->limit(10)->get();
        return view('home', ['total_customers' => $total_customers,
            'total_contribution' => $total_contribution,
            'total_revenue' => $total_revenue,
            'total_staff' => $total_staff,
            'contributions' => $contributions]);
    }

    public function getSingleStaff(){}
    public function getStaff(){
        $staff = User::all();
        return view('staffs', ['staffs' => $staff]);
    }
    public function newStaffForm(){

        return view('staff_form');
    }
    public function storeStaff(Request $request){
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'numeric',
            'branch' => 'string',
            'unit_manager' => 'string',
            'password' => 'required',
            'priviledge' => 'required',
            'address' => 'required',
            'job_title' => 'required',
            'job_description' => 'string',
        ]);

        User::create([
            'firstname' => $request->first_name,
            'lastname' => $request->last_name,
            'name' => $request->first_name . " " . $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'branch' => $request->branch,
            'unit_manager' => $request->unit_manager,
            'password' => password_hash($request->password, PASSWORD_BCRYPT),
            'admin_right' => $request->priviledge,
            'address' => $request->address,
            'job_title' => $request->job_title,
            'job_description' => $request->job_description,
        ]);

        return back()->with('success', 'New staff added successfully');

    }

    public function editStaff(){}

    public function deleteStaff(){}


}
