<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C2C Restoration Review</title>
    <link rel="icon" href="{{ asset('images/c2c-restoration.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .main_wrapper {
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 0 24px rgba(0,0,0,0.10);
            padding: 48px 32px 32px 32px;
            text-align: center;
        }
        .main_wrapper .logo {
            margin-bottom: 1.5rem;
        }
        .main_wrapper .logo img {
            max-width: 260px;
        }
        .main_wrapper h2 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .main_wrapper p.lead {
            color: #555;
            margin-bottom: 2rem;
        }
        .review_box {
            border: 1px solid #e0e0e0;
            border-radius: 14px;
            padding: 32px 18px 24px 18px;
            text-align: center;
            margin: 0 0 30px;
            background: #fafbfc;
        }
        .company_info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .company_img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            overflow: hidden;
            background: #fff;
            border: 1px solid #eee;
        }
        .company_img img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .conpany_text {
            text-align: left;
        }
        .conpany_text h4 {
            margin: 0 0 5px 0;
            font-weight: 700;
        }
        .conpany_text p {
            margin: 0;
            color: #888;
            font-size: 1rem;
        }
        .star-rating {
            font-size: 2.2rem;
            color: #ddd;
            cursor: pointer;
            margin-bottom: 0.5rem;
        }
        .star-rating .fa-star.selected,
        .star-rating .fa-star:hover,
        .star-rating .fa-star.hovered {
            color: #ffb400;
        }
        .thank-you {
            display: none;
            text-align: center;
            padding: 2rem 0 0 0;
        }
        .help {
            text-align: center;
            color: #747474;
            margin-top: 2.5rem;
            font-size: 1.05rem;
        }
        @media (max-width: 600px) {
            .main_wrapper {
                padding: 1.2rem 0.5rem;
            }
            .review_box {
                padding: 18px 4px 18px 4px;
            }
        }
    </style>
</head>
<body>
    <div class="main_wrapper">
        <div class="logo">
            <img src="{{ asset('images/c2c-restoration.png') }}" alt="C2C Restoration">
        </div>
        <h2>How was your experience?</h2>
        <p class="lead">Thank you for your business. We would really appreciate a review if you can spare a few minutes.</p>
        <div class="review_box">
            <div class="company_info">
                <div class="company_img">
                    <img src="{{ asset('images/c2c-restoration.png') }}" alt="C2C Restoration">
                </div>
                <div class="conpany_text">
                    <h4>C2C Restoration</h4>
                    <p>Roofing & Restoration</p>
                </div>
            </div>
            <div class="mb-2 fw-semibold">Rate your experience:</div>
            <div class="star-rating" id="starRating">
                <i class="fa fa-star" data-value="1"></i>
                <i class="fa fa-star" data-value="2"></i>
                <i class="fa fa-star" data-value="3"></i>
                <i class="fa fa-star" data-value="4"></i>
                <i class="fa fa-star" data-value="5"></i>
            </div>
            <div class="text-muted mb-2" style="font-size: 0.95rem;">Tap a star to rate</div>
        </div>
        <div class="thank-you" id="thankYouMsg">
            <h4 class="text-success mb-3"><i class="fa fa-check-circle"></i> Thank you for your feedback!</h4>
        </div>
        <div class="help">
            Your feedback helps us improve our service.
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="reviewModalLabel">Write your review</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="reviewForm">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="customer_id" value="{{ $customerId }}">
                <input type="hidden" name="rating" id="modalRating">
                <div class="mb-3">
                    <textarea class="form-control" name="feedback_message" rows="4" placeholder="Write your review..."></textarea>
                    <div class="invalid-feedback d-block" id="feedbackError" style="display:none;"></div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">
                <span class="submit-text">Submit</span>
                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Set up CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val()
            }
        });

        $(document).ready(function () {
            let selectedRating = 0;
            const stars = document.querySelectorAll('#starRating .fa-star');

            // Function to highlight stars
            function highlightStars(rating) {
                stars.forEach(star => {
                    star.classList.toggle('text-warning', star.dataset.value <= rating);
                    star.classList.toggle('text-secondary', star.dataset.value > rating);
                });
            }

            // Attach hover and click events
            stars.forEach(star => {
                star.addEventListener('mouseenter', function () {
                    highlightStars(this.dataset.value);
                });
                star.addEventListener('mouseleave', function () {
                    highlightStars(selectedRating);
                });
                star.addEventListener('click', function () {
                    selectedRating = this.dataset.value;
                    highlightStars(selectedRating);
                    $('#modalRating').val(selectedRating);

                    if (selectedRating > 3) {
                        window.location.href = "{{ $url }}";
                        return
                    } else {
                        const reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));
                        reviewModal.show();
                    }
                });
            });

            // If rating already selected from backend, simulate click
            const preSelected = "{{ $rating }}";
            if (preSelected > 0) {
                selectedRating = preSelected;
                highlightStars(selectedRating);
                $('#modalRating').val(selectedRating);

                const reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));
                reviewModal.show();
            }
        });

        function highlightStars(rating) {
            stars.forEach(star => {
                star.classList.remove('selected');
                if (star.dataset.value <= rating) {
                    star.classList.add('selected');
                }
            });
        }

        // Handle review form submit
        $('#reviewForm').on('submit', function(e) {
            e.preventDefault();
            var $btn = $('#reviewForm button[type="submit"]');
            $btn.find('.submit-text').addClass('d-none');
            $btn.find('.spinner-border').removeClass('d-none');
            $('#feedbackError').hide().text("");
            $.ajax({
                url: "{{ route('feedback.submit') }}",
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    var reviewModal = bootstrap.Modal.getInstance(document.getElementById('reviewModal'));
                    reviewModal.hide();
                    $('#thankYouMsg').fadeIn();
                },
                error: function(xhr) {
                    let msg = 'An error occurred. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        msg = Object.values(errors).map(arr => arr[0]).join('<br>');
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    $('#feedbackError').html(msg).show();
                },
                complete: function() {
                    $btn.find('.submit-text').removeClass('d-none');
                    $btn.find('.spinner-border').addClass('d-none');
                }
            });
        });
    </script>
</body>
</html> 