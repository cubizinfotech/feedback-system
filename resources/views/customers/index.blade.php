@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Customers</h5>
        <div>
            <button type="button" class="btn btn-outline-secondary me-2 refresh-table" title="Refresh Data" data-bs-toggle="tooltip">
                <span class="refresh-icon"><i class="fas fa-sync-alt"></i></span>
                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal" title="Add a new customer" data-bs-toggle="tooltip">
                <i class="fas fa-plus"></i> Add Customer
            </button>
        </div>
    </div>
    <div class="card-body">
        <table id="customersTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mail Status</th>
                    <th>Total Mails</th>
                    <th>Total Feedbacks</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addCustomerForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Customer Modal -->
<div class="modal fade" id="editCustomerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCustomerForm">
                <input type="hidden" name="customer_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#customersTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: "{{ route('customers.data') }}",
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { 
                data: 'is_mail_sent',
                render: function(data) {
                    return data ? 
                        '<span class="badge bg-success">Sent</span>' : 
                        '<span class="badge bg-warning">Not Sent</span>';
                }
            },
            { data: 'total_mail_sent' },
            { data: 'feedbacks_count', defaultContent: 0 },
            {
                data: 'id',
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-info send-mail" data-id="${data}" title="Send feedback request email" data-bs-toggle="tooltip">
                            <i class="fas fa-envelope"></i>
                        </button>
                        <button class="btn btn-sm btn-primary edit-customer" data-id="${data}" title="Edit customer details" data-bs-toggle="tooltip">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-customer" data-id="${data}" title="Delete this customer" data-bs-toggle="tooltip">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                }
            }
        ],
        drawCallback: function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    });

    // Initialize Bootstrap tooltips
    setTimeout(function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }, 500);

    // Add Customer
    $('#addCustomerForm').on('submit', function(e) {
        e.preventDefault();
        var $btn = $('#addCustomerForm button[type="submit"]');
        var originalHtml = $btn.html();
        $btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Saving...').prop('disabled', true);
        $.ajax({
            url: "{{ route('customers.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#addCustomerModal').modal('hide');
                table.ajax.reload();
                toastr.success('Customer added successfully');
                $('#addCustomerForm')[0].reset();
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                Object.keys(errors).forEach(key => {
                    toastr.error(errors[key][0]);
                });
            },
            complete: function() {
                $btn.html(originalHtml).prop('disabled', false);
            }
        });
    });

    // Edit Customer
    $(document).on('click', '.edit-customer', function() {
        const id = $(this).data('id');
        const row = table.row($(this).closest('tr')).data();
        
        $('#editCustomerForm [name="customer_id"]').val(id);
        $('#editCustomerForm [name="name"]').val(row.name);
        $('#editCustomerForm [name="email"]').val(row.email);
        
        $('#editCustomerModal').modal('show');
    });

    $('#editCustomerForm').on('submit', function(e) {
        e.preventDefault();
        const id = $(this).find('[name="customer_id"]').val();
        var $btn = $('#editCustomerForm button[type="submit"]');
        var originalHtml = $btn.html();
        $btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Updating...').prop('disabled', true);
        $.ajax({
            url: `/customers/${id}`,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                $('#editCustomerModal').modal('hide');
                table.ajax.reload();
                toastr.success('Customer updated successfully');
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                Object.keys(errors).forEach(key => {
                    toastr.error(errors[key][0]);
                });
            },
            complete: function() {
                $btn.html(originalHtml).prop('disabled', false);
            }
        });
    });

    // Delete Customer
    $(document).on('click', '.delete-customer', function() {
        const id = $(this).data('id');
        var $btn = $(this);
        var originalHtml = $btn.html();
        confirmDelete(`/customers/${id}`, function() {
            $btn.html('<span class="spinner-border spinner-border-sm"></span>').prop('disabled', true);
            $.ajax({
                url: `/customers/${id}`,
                method: 'DELETE',
                success: function(response) {
                    table.ajax.reload();
                    toastr.success('Customer deleted successfully');
                },
                complete: function() {
                    $btn.html(originalHtml).prop('disabled', false);
                }
            });
        });
    });

    // Send Feedback Mail
    $(document).on('click', '.send-mail', function() {
        const id = $(this).data('id');
        var $btn = $(this);
        var originalHtml = $btn.html();
        $btn.html('<span class="spinner-border spinner-border-sm"></span>').prop('disabled', true);
        $.ajax({
            url: `/customers/${id}/send-feedback`,
            method: 'POST',
            success: function(response) {
                table.ajax.reload();
                toastr.success('Feedback request email sent successfully');
            },
            error: function(xhr) {
                toastr.error('Failed to send feedback request email');
            },
            complete: function() {
                $btn.html(originalHtml).prop('disabled', false);
            }
        });
    });

    // Refresh Table
    $(document).on('click', '.refresh-table', function() {
        var $btn = $(this);
        $btn.find('.refresh-icon').addClass('d-none');
        $btn.find('.spinner-border').removeClass('d-none');
        table.ajax.reload(function() {
            $btn.find('.refresh-icon').removeClass('d-none');
            $btn.find('.spinner-border').addClass('d-none');
        }, false);
    });
});
</script>
@endpush 