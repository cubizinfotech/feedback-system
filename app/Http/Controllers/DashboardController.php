<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Feedback;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Customer::count();
        $totalFeedbacks = Feedback::count();
        $totalMailsSent = Customer::sum('total_mail_sent');
        
        // Get rating distribution for chart
        $ratingDistribution = Feedback::selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->orderBy('rating')
            ->get();

        // Get recent feedbacks with customer names
        $recentFeedbacks = Feedback::with('customer')
            ->latest()
            ->take(4)
            ->get();

        return view('dashboard.index', compact(
            'totalCustomers',
            'totalFeedbacks',
            'totalMailsSent',
            'ratingDistribution',
            'recentFeedbacks'
        ));
    }
}
