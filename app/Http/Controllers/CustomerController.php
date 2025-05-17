<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackRequest;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('customers.index');
    }

    public function getCustomers()
    {
        $customers = Customer::withCount('feedbacks')
            // ->select(['id', 'name', 'email', 'is_mail_sent', 'total_mail_sent', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['data' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $customer = Customer::create($request->all());

        return response()->json([
            'message' => 'Customer created successfully',
            'customer' => $customer
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $customer->update($request->all());

        return response()->json([
            'message' => 'Customer updated successfully',
            'customer' => $customer
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(['message' => 'Customer deleted successfully']);
    }

    public function sendFeedbackMail(Customer $customer)
    {
        try {
            // Generate unique feedback token
            $token = md5($customer->email . time());
            
            // Store token in session or database if needed
            
            // Send email
            Mail::to($customer->email)->queue(new FeedbackRequest($customer, $token));
            
            // Update customer record
            $customer->update([
                'is_mail_sent' => true,
                'total_mail_sent' => $customer->total_mail_sent + 1
            ]);

            return response()->json([
                'message' => 'Feedback request email sent successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to send feedback request email',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
