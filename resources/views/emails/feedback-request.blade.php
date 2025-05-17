<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>We Value Your Feedback</title>
    <link rel="icon" href="{{asset('/')}}images/c2c-restoration.png">

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
      integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <style>
      * {
        box-sizing: border-box;
      }
      @import url("https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap");
      body {
        padding: 0;
        margin: 0;
        font-family: "Montserrat", sans-serif;
        font-size: 18px;
        line-height: 24px;
        color: #282828;
        background: #f8f9fa;
      }
      p {
        margin: 0 0 30px;
      }
      .main_wrapper {
        max-width: 600px;
        margin: 40px auto;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 0 24px rgba(0,0,0,0.10);
        padding: 48px 32px 32px 32px;
        text-align: center;
      }
      .logo {
        margin-bottom: 1.5rem;
      }
      .logo img {
        max-width: 260px;
      }
      h2 {
        font-weight: 700;
        margin-bottom: 0.5rem;
      }
      .lead {
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
        letter-spacing: 0.2rem;
      }
      .star-rating a {
        text-decoration: none;
      }
      .star-rating a:hover span {
        color: #ffb400 !important;
      }
      .star-rating a:focus span {
        color: #ffb400 !important;
      }
      .star-rating .fa-star {
        color: #ccc;
        transition: color 0.2s;
      }
      .star-rating .fa-star.active {
        color: #ffb400;
      }
      .text-muted {
        color: #888;
        font-size: 0.95rem;
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
        
        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 1.5rem;">
          <tr>
            <td align="center" style="display: flex; justify-content: center; align-items: center;">
              <div style="margin-right: 10px;">
                <img src="{{ asset('images/c2c-restoration.png') }}" alt="C2C Restoration" style="width:70px;height:70px;border-radius:50%;background:#fff;border:1px solid #eee;display:block;">
              </div>
              <div style="margin-top: 2px;">
                <div style="font-weight:700;font-size:1.15rem;line-height:1.2;">C2C Restoration</div>
                <div style="color:#888;font-size:1rem;">Roofing & Restoration</div>
              </div>
            </td>
          </tr>
        </table>

        <div class="mb-2 fw-semibold" style="font-weight:600;">Rate your experience:</div>
        <div class="star-rating" style="letter-spacing: 0.2rem;">
          @for ($i = 1; $i <= 5; $i++)
            <a href="{{ route('feedback.form', ['customerId' => $customer->id, 'rating' => $i]) }}" target="_blank" title="Rate {{ $i }} star{{ $i > 1 ? 's' : '' }}" style="text-decoration:none;">
              <span style="font-size:2.2rem; color:#ccc; display:inline-block; line-height:1;">&#9733;</span>
            </a>
          @endfor
        </div>
        <div class="text-muted mb-2">Tap a star to rate</div>
      </div>
      <div class="help">
        Your feedback helps us improve our service.
      </div>
    </div>
  </body>
</html>
