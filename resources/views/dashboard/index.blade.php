@extends('layouts.app')

@section('content')
<div class="row mb-4 dashboard-cards">
    <div class="col-lg-4 col-md-6 col-12 mb-3">
        <div class="card bg-primary text-white shadow rounded-4 h-100">
            <div class="card-body d-flex flex-column align-items-start">
                <h5 class="card-title">Total Customers</h5>
                <h2 class="card-text fw-bold">{{ $totalCustomers }}</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-12 mb-3">
        <div class="card bg-success text-white shadow rounded-4 h-100">
            <div class="card-body d-flex flex-column align-items-start">
                <h5 class="card-title">Total Feedbacks</h5>
                <h2 class="card-text fw-bold">{{ $totalFeedbacks }}</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-12 mb-3">
        <div class="card bg-info text-white shadow rounded-4 h-100">
            <div class="card-body d-flex flex-column align-items-start">
                <h5 class="card-title">Total Mails Sent</h5>
                <h2 class="card-text fw-bold">{{ $totalMailsSent }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8 col-12">
        <div class="card shadow rounded-4 h-100">
            <div class="card-header bg-white border-bottom-0 rounded-top-4">
                <h5 class="card-title mb-0">Feedback Rating Distribution</h5>
            </div>
            <div class="card-body">
                <canvas id="ratingChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="card shadow rounded-4 h-100">
            <div class="card-header bg-white border-bottom-0 rounded-top-4">
                <h5 class="card-title mb-0">Recent Feedbacks</h5>
            </div>
            <div class="card-body">
                @forelse($recentFeedbacks as $feedback)
                <div class="mb-3 pb-2 border-bottom">
                    <h6 class="mb-1">{{ $feedback->customer->name }}</h6>
                    <div class="mb-1">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $feedback->rating ? ' text-warning' : ' text-secondary' }}"></i>
                        @endfor
                    </div>
                    <p class="mb-1 small">{{ Str::limit($feedback->feedback_message, 100) }}</p>
                    <small class="text-muted">{{ $feedback->created_at->diffForHumans() }}</small>
                </div>
                @empty
                <div class="text-muted">No recent feedbacks.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var ratingData = @json($ratingDistribution);
    var barColors = [
        'rgba(255, 99, 132, 0.7)',   // Red
        'rgba(255, 159, 64, 0.7)',   // Orange
        'rgba(255, 205, 86, 0.7)',   // Yellow
        'rgba(75, 192, 192, 0.7)',   // Teal
        'rgba(54, 162, 235, 0.7)'    // Blue
    ];
    var borderColors = [
        'rgba(255, 99, 132, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(255, 205, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(54, 162, 235, 1)'
    ];
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Rating Distribution Chart
    const ctx = document.getElementById('ratingChart').getContext('2d');
    // Use ratingData directly
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ratingData.map(item => item.rating + ' Stars'),
            datasets: [{
                label: 'Number of Feedbacks',
                data: ratingData.map(item => item.count),
                backgroundColor: barColors.slice(0, ratingData.length),
                borderColor: borderColors.slice(0, ratingData.length),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush