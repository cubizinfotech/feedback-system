<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\CustomerFeedbackNotification;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('feedbacks.index');
    }

    public function getFeedbacks()
    {
        $feedbacks = Feedback::with('customer')
            ->select(['id', 'customer_id', 'rating', 'feedback_message', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['data' => $feedbacks]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function showFeedbackForm($customerId, $rating)
    {
        $url = env('REVIEW_URL', 'https://g.co/kgs/pqR37Lm');

        if (!Customer::find($customerId) || $rating < 1 || $rating > 5) {
            abort(404);
        }
        
        $feedback = Feedback::firstOrCreate([
            'customer_id' => $customerId,
            'rating' => $rating,
            'feedback_message' => ''
        ]);

        if ($rating > 3) {
            return redirect($url);
        }

        return view('feedbacks.form', compact('customerId', 'rating', 'url'));
    }

    public function submitFeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' =>'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'feedback_message' => 'required|string|min:10'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $feedback = Feedback::updateOrcreate(
            [
                'customer_id' => $request->customer_id,
                'rating' => $request->rating,
                'feedback_message' => ''
            ], [
                'feedback_message' => $request->feedback_message
            ]
        );

        // $supportEmail = 'gopalhingu123@gmail.com';
        $supportEmail = env('SUPPORT_EMAIL', 'support@c2crestore.com');

        $customer = Customer::find($request->customer_id);

        // Send notification to support
        Mail::to($supportEmail)->send(new CustomerFeedbackNotification($customer, $feedback));

        return response()->json([
            'message' => 'Thank you for your feedback!',
            'feedback' => $feedback
        ]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
