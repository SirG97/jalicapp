<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contributions = Contribution::where('status', 'approved')->get();

        return view('contributions', ['contributions' => $contributions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('contribute');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate([
            'customer_id' => 'required|numeric',
            'name' => 'required',
            'collected_by' => 'required',
            'posted_by' => 'nullable',
            'amount' => 'string',
            'request_type' => 'string',
            'savings_type' => 'required',
            'collected_on' => 'required',
            'description' => '',
        ]);

            $is_registered_customer = Customer::where('customer_id', '=', $request->customer_id)->first();

            //get his last contribution and see if it is null, a debit or a credit
            $last_contribution = Contribution::where('customer_id', $request->customer_id)->latest('id')->first();
            if($last_contribution == null){
                // It means he is a first timer
                if($request->request_type === 'credit'){
                    if($request->savings_type === 'savings' or $request->savings_type === 'property'){
                        $amount = (int)$request->amount;
                        $available_balance = $amount - ($amount * 0.033);
                        $gain = $amount * 0.033;
                        Contribution::create([
                            'contribution_id' => $this->generateInvoiceNo(),
                            'customer_id' => $request->customer_id,
                            'amount' => $amount,
                            'balance' => $available_balance,
                            'gain' => $gain,
                            'loan' => 0,
                            'request_type' => $request->request_type,
                            'savings_type' => $request->savings_type,
                            'collected_by' => $request->collected_by,
                            'posted_by' => $request->posted_by,
                            'collected_on' => $request->collected_on,
                            'description' => $request->description,
                            'status' => 'pending'
                        ]);

                        return back()->with(['success' => 'Account credited successfully']);
                    }elseif($request->savings_type === 'loan'){
                        return back()->with(['status' => 'You have no loan to payback']);
                    }else{
                        return back()->with(['error' => 'This request is not understood']);
                    }
                }elseif($request->request_type === 'debit'){
                    if($request->savings_type === 'savings' or $request->savings_type === 'property'){
                        if($last_contribution->balance >= $request->amount){
                            $remaining_balance = $last_contribution->balance - (int)$request->amount;
                            Contribution::create([
                                'contribution_id' => $this->generateInvoiceNo(),
                                'customer_id' => $request->customer_id,
                                'amount' => $request->amount,
                                'balance' => $remaining_balance,
                                'gain' => 0,
                                'loan' => 0,
                                'request_type' => $request->request_type,
                                'savings_type' => $request->savings_type,
                                'collected_by' => $request->collected_by,
                                'posted_by' => $request->posted_by,
                                'collected_on' => $request->collected_on,
                                'description' => $request->description,
                                'status' => 'pending'
                            ]);
                            return back()->with(['success' => 'Savings debit successful']);

                        }else{
                            return back()->with(['error' => 'Available balance is less than them amount you want to withdraw']);

                        }
                    }elseif($request->savings_type === 'loan'){
                        $loan = (int)$request->amount;
                        Contribution::create([
                            'contribution_id' => $this->generateInvoiceNo(),
                            'customer_id' => $request->customer_id,
                            'amount' => $request->amount,
                            'balance' => 0,
                            'gain' => 0,
                            'loan' => $loan,
                            'request_type' => $request->request_type,
                            'savings_type' => $request->savings_type,
                            'collected_by' => $request->collected_by,
                            'posted_by' => $request->posted_by,
                            'collected_on' => $request->collected_on,
                            'description' => $request->description,
                            'status' => 'pending'
                        ]);
                        return back()->with(['success'=> 'Loan debit successful']);

                    }else{
                        //bad request
                        return back()->with(['error'=> 'Request not understood']);
                    }
                }else{
                    //Something is wrong with the request
                    return back()->with(['error'=> 'There is an error with this request']);
                }

            }else{
                /*
                 * When he is no long a first timer
                 */
                if($request->request_type === 'credit'){
                    if($request->savings_type === 'savings' or $request->savings_type === 'property'){
                        $amount = (int)$request->amount;
                        $available_balance = (int)$last_contribution->balance + ($amount - ($amount * 0.033));
                        $gain = $amount * 0.033;
                        Contribution::create([
                            'contribution_id' => $this->generateInvoiceNo(),
                            'customer_id' => $request->customer_id,
                            'amount' => $amount,
                            'balance' => $available_balance,
                            'gain' => $gain,
                            'loan' => 0,
                            'request_type' => $request->request_type,
                            'savings_type' => $request->savings_type,
                            'collected_by' => $request->collected_by,
                            'posted_by' => $request->posted_by,
                            'collected_on' => $request->collected_on,
                            'description' => $request->description,
                            'status' => 'pending'
                        ]);

                        return back()->with(['success' => 'Account credited successfully']);

                    }elseif($request->savings_type === 'loan'){
                        if((int)$last_contribution->loan > 0 and (int)$request->amount <= (int)$last_contribution->loan){
                            $loan_balance = $last_contribution->loan - $request->amount;
                            Contribution::create([
                                'contribution_id' => $this->generateInvoiceNo(),
                                'customer_id' => $request->customer_id,
                                'amount' => $request->amount,
                                'balance' => $last_contribution->balance,
                                'gain' => 0,
                                'loan' => $loan_balance,
                                'request_type' => $request->request_type,
                                'savings_type' => $request->savings_type,
                                'collected_by' => $request->collected_by,
                                'posted_by' => $request->posted_by,
                                'collected_on' => $request->collected_on,
                                'description' => $request->description,
                                'status' => 'pending'
                            ]);

                            return back()->with(['success' => 'Loan credited successfully']);

                        }else{
                            return back()->with('error', 'The amount you want to pay back is bigger than the loan');

                        }

                    }else{
                        //bad request
                        return back()->with('error', 'This request is not understood');
                    }
                }elseif($request->request_type === 'debit'){
                    if($request->savings_type === 'savings' or $request->savings_type === 'property'){
                        if($last_contribution->balance >= $request->amount){
                            $remaining_balance = $last_contribution->balance - (int)$request->amount;
                            Contribution::create([
                                'contribution_id' => $this->generateInvoiceNo(),
                                'customer_id' => $request->customer_id,
                                'amount' => $request->amount,
                                'balance' => $remaining_balance,
                                'gain' => 0,
                                'loan' => 0,
                                'request_type' => $request->request_type,
                                'savings_type' => $request->savings_type,
                                'collected_by' => $request->collected_by,
                                'posted_by' => $request->posted_by,
                                'collected_on' => $request->collected_on,
                                'description' => $request->description,
                                'status' => 'pending'
                            ]);
                            return back()->with(['success' => 'Savings debit successful']);

                        }else{
                            return back()->with('error', 'Available balance is less than them amount you want to withdraw');
                        }
                    }elseif($request->savings_type === 'loan'){
                        $loan = (int)$last_contribution->loan + (int)$request->amount;
                        Contribution::create([
                            'contribution_id' => $this->generateInvoiceNo(),
                            'customer_id' => $request->customer_id,
                            'amount' => $request->amount,
                            'balance' => $last_contribution->balance,
                            'gain' => 0,
                            'loan' => $loan,
                            'request_type' => $request->request_type,
                            'savings_type' => $request->savings_type,
                            'collected_by' => $request->collected_by,
                            'posted_by' => $request->posted_by,
                            'collected_on' => $request->collected_on,
                            'description' => $request->description,
                            'status' => 'pending'
                        ]);
                        return back()->with(['success' => 'Loan debit successful']);

                    }else{
                        //bad request
                        return back()->with('error', 'This request is not understood');
                    }
                }else{
                    return back()->with('error', 'This request is not understood');
                }
            }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contribution  $contribution
     * @return \Illuminate\Http\Response
     */
    public function show(Contribution $contribution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contribution  $contribution
     * @return \Illuminate\Http\Response
     */
    public function edit(Contribution $contribution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contribution  $contribution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contribution $contribution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contribution  $contribution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contribution $contribution)
    {
        //
    }

    public function generateInvoiceNo(){
        $n =  substr(str_shuffle("0123456789"), 0, 9);
        $check = Contribution::where('contribution_id', $n)->first();
        if($check === null){
            return $n;
        }
        $this->generateInvoiceNo();
    }

    public function unapproved(){
        $contributions = Contribution::where('status','!=', 'approved')->get();

        return view('unapproved', ['contributions' => $contributions]);
    }

    public function approve(Request $request){

        $request->validate([
            'contribution_id' => 'required|numeric',
        ]);
        // if(Session::get('priviledge') !== 'Admin'){
        //     Redirect::to('/unauthorized');


        $details = [
            'status' => 'approved',
            'approved_by' => Auth::user()->id
        ];

        Contribution::where('contribution_id', $request->contribution_id)->update($details);
        return redirect('/contributions')->with(['success' => 'Contribution approved successfully']);

    }

    public function send_sms(Request $request){
//        if(Session::get('priviledge') !== 'Admin'){
//            Redirect::to('/unauthorized');
//        }else {
//            if (Request::has('post')) {
//                $request = Request::get('post');
//                if (CSRFToken::verifyCSRFToken($request->token)) {
//                    //Validation Rules
//                    $rules = [
//                        'customer_id' => ['required' => true],
//                        'number' => ['required' => true, 'mixed' => true],
//                        'message' => ['required' => true],
//                    ];
//                    //Run Validation and return errors
//                    $validation = new Validation();
//                    $validation->validate($_POST, $rules);
//                    if ($validation->hasError()) {
//                        $errors = $validation->getErrorMessages();
//                        return view('user.message', ['errors' => $errors]);
//                    }

                    //                $is_registered_customer = Customer::where('customer_id', '=', $request->customer_id)->first();
                    //                if($is_registered_customer == null){
                    //                    Session::add('error', 'This customer details not found');
                    //                    Redirect::to('/message');
                    //                    exit();
                    //                }


                    // Let's send our message
                    $email = "sirgittarus@gmail.com";
                    $password = "rrwcscrz1";
                    $message = $request->message;
                    $sender_name = "Jon Jalic";
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
                        return back()->with('success', 'Message sent successfully');

                    } else {
                       return back()->with('error', 'Message not sent');
                    }
//                }
//            }
//        }
    }

    public function get_number($terms){
        $term = urldecode($terms['terms']);

        $searchresult = Customer::where('name', 'LIKE', "%{$term}%")
            ->orWhere('customer_id', 'LIKE', "%{$term}%")
            ->orWhere('email', 'LIKE', "%{$term}%")
            ->orWhere('phone', 'LIKE', "%{$term}%")->get();
        if($term === ''){
            return response()->json(['error' => 'No result found']);

        }elseif(count($searchresult) > 0){
            echo json_encode(['success' => $searchresult]);
            exit();
        }else{
            http_response_code(404);
            echo json_encode(['error' => 'No result found']);
            exit();
        }
    }
}
