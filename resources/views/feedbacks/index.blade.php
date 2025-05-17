@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Customer Feedbacks</h5>
        <button type="button" class="btn btn-outline-secondary refresh-table" title="Refresh Data" data-bs-toggle="tooltip">
            <span class="refresh-icon"><i class="fas fa-sync-alt"></i></span>
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        </button>
    </div>
    <div class="card-body">
        <table id="feedbacksTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Rating</th>
                    <th>Feedback</th>
                    <th>Date</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!-- Feedback Message Modal -->
<div class="modal fade" id="feedbackMessageModal" tabindex="-1" aria-labelledby="feedbackMessageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="feedbackMessageModalLabel">Feedback Message</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="fullFeedbackMessage"></div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script>
$(document).ready(function() {
    $('#feedbacksTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: "{{ route('feedbacks.data') }}",
        columns: [
            { data: 'id' },
            { data: 'customer.name' },
            { 
                data: 'rating',
                render: function(data) {
                    let stars = '';
                    for (let i = 1; i <= 5; i++) {
                        stars += `<i class="fas fa-star${i <= data ? ' text-warning' : ' text-secondary'}"></i>`;
                    }
                    return stars;
                }
            },
            { 
                data: 'feedback_message',
                render: function(data) {
                    const limit = 60;
                    if (data.length > limit) {
                        const short = data.substring(0, limit) + '...';
                        return `<div style="max-width: 575px;">${short} <button class='btn btn-link p-0 read-more-feedback' data-message="${encodeURIComponent(data)}">Read more</button></div>`;
                    }
                    return `<div style="max-width: 575px;">${data}</div>`;
                }
            },
            { 
                data: 'created_at',
                render: function(data) {
                    return moment(data).format('YYYY-MM-DD HH:mm');
                }
            }
        ],
        order: [[0, 'desc']]
    });

    // Refresh Table
    $(document).on('click', '.refresh-table', function() {
        var $btn = $(this);
        $btn.find('.refresh-icon').addClass('d-none');
        $btn.find('.spinner-border').removeClass('d-none');
        $('#feedbacksTable').DataTable().ajax.reload(function() {
            $btn.find('.refresh-icon').removeClass('d-none');
            $btn.find('.spinner-border').addClass('d-none');
        }, false);
    });

    // Read more feedback message
    $(document).on('click', '.read-more-feedback', function() {
        const message = decodeURIComponent($(this).data('message'));
        $('#fullFeedbackMessage').text(message);
        var modal = new bootstrap.Modal(document.getElementById('feedbackMessageModal'));
        modal.show();
    });

    // Initialize Bootstrap tooltips
    setTimeout(function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }, 500);
});
</script>
@endpush 