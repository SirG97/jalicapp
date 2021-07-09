<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $customers = Customer::all();
        return view('customers', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('customer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'marital_status' => 'required',
            'dob' => 'required',
            'phone' => 'numeric',
            'occupation' => 'string',
            'sex' => 'string',
            'email' => 'required|unique:customers',
            'image' => 'mimes:jpeg,png,jpg',
            'address' => 'required',
            'saving_period' => 'required',
            'amount' => 'required',
            'purpose' => 'string',
            'account_number' => 'numeric',
            'account_name' => 'string',
            'bank' => 'string',
            'kin_name' => 'string',
            'kin_address' => 'string',
            'kin_relationship' => 'string',
            'kin_phone' => 'string',
            'kin_image' => 'string',
            'branch' => 'string',
            'unit_manager' => 'string',
            'unit_manager_phone' => 'numeric',
            'office' => 'string',
            'user_id' => 'string',
        ]);

        Customer::create([
            'customer_id' => $this->generateCustomerID(),
            'name' => $request->name,
            'title' => $request->title,
            'marital_status' => $request->marital_status,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'occupation' => $request->occupation,
            'sex' => $request->sex,
            'email' => $request->email,
//            'image' => 'mimes:jpeg,png,jpg',
            'address' => $request->address,
            'saving_period' => $request->saving_period,
            'amount' => $request->amount,
            'purpose' => $request->purpose,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'bank' => $request->bank,
            'kin_name' => $request->kin_name,
            'kin_address' => $request->kin_address,
            'kin_relationship' => $request->kin_relationship,
            'kin_phone' => $request->kin_phone,
            'kin_image' => $request->kin_image,
            'branch' => $request->branch,
            'unit_manager' => $request->unit_manager,
            'unit_manager_phone' => $request->unit_manager_phone,
            'office' => $request->office,
            'user_id' => auth()->user()->id,
        ]);

        return back()->with('success', 'Customer information stored successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }


    public function generateCustomerID(){
        $n =  substr(str_shuffle("0123456789"), 0, 4);
        $check = Customer::where('customer_id', $n)->first();
        if($check === null){
            return $n;
        }
        $this->generateCustomerID();
    }

    public function verify($id){
        $customer_id = $id;
        $customer = Customer::where('customer_id', $customer_id)->first();
        if($customer !== null){
            return response()->json(['status'=> 'success','data' => $customer]);
        }else{
            return response()->json(['error' => 'No result found']);

        }
    }

    public  function message(){
        return view('message');
    }

    public function send_sms(Request $request){
//        if(Session::get('priviledge') !== 'Admin'){
//            Redirect::to('/unauthorized');
//        }else {
        $request->validate([
            'number' => 'required',
            'message' => 'required',
        ]);
        // Let's send our message
        $email = "sirgittarus@gmail.com";
        $password = "rrwcscrz1";
        $message = $request->message;
        $sender_name = "HoH Savings";
        $recipients = $request->number;
        $forcednd = 1;

        $data = array(
            "email" => $email,
            "password" => $password,
            "message" => $message,
            "sender_name" => $sender_name,
            "recipients" => $recipients,
            "forcednd" => $forcednd);
        $data_string = json_encode($data);

        $ch = curl_init('https://app.multitexter.com/v2/app/sms');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_string)));
        $result = curl_exec($ch);
        $res = json_decode($result);
        if ($res->status === 1) {
            return back()->with('success', 'Message sent successfully. Cost is '. $res->units . ' unit(s). Balance is '. $res->balance . ' unit(s)');

        }

        if ($res->status === -7) {
            return back()->with('success', 'You do not have sufficient unit');

        } else {
            return back()->with('error', 'Message not sent');
        }

    }

    public function get_number($id){
        $term = $id;

        $searchresult = Customer::where('name', 'LIKE', "%{$term}%")
            ->orWhere('customer_id', 'LIKE', "%{$term}%")
            ->orWhere('email', 'LIKE', "%{$term}%")
            ->orWhere('phone', 'LIKE', "%{$term}%")->get();
        if($term === ''){
            return response()->json(['status'=> 'error', 'data' => 'No result found']);

        }elseif(count($searchresult) > 0){
            return response()->json(['status' => 'success', 'data' => $searchresult]);

        }else{
            return response()->json(['status' => 'error', 'data' => 'No result found']);

        }
    }
}
