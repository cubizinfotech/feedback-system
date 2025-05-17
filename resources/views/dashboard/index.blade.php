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
                    <div class="text-warning mb-1">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $feedback->rating ? '' : '-o' }}"></i>
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
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
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