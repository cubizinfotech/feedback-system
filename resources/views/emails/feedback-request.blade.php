<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>C2C Restoration Review Form</title>
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
      }
      p {
        margin: 0 0 30px;
      }
      .main_wrapper {
        max-width: 800px;
        margin: 50px auto;
        box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.1);
        padding: 40px;
        border-radius: 10px;
      }
      .logo {
        text-align: center;
        margin: 0 0 30px;
      }
      .title_wrap {
        text-align: center;
      }
      h2 {
        margin: 0 0 20px;
      }
      .review_box {
        border: 1px solid #c5c5c5;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        margin: 0 0 30px;
      }
      .company_info {
        display: flex;
        align-items: center;
        justify-content: center;
        max-width: 300px;
        margin: 0 auto 30px;
      }
      .company_img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        overflow: hidden;
      }
      .company_img img {
        width: 100%;
        height: 100%;
        object-fit: contain;
      }
      .conpany_text {
        width: calc(100% - 70px);
        text-align: left;
        padding-left: 20px;
      }
      .conpany_text h4 {
        margin: 0 0 5px;
      }
      .conpany_text p {
        margin: 0;
      }

      .rating-group {
        display: inline-flex;
        margin: 0 0 30px;
      }

      .rating__icon {
        pointer-events: none;
      }

      .rating__input {
        position: absolute !important;
        left: -9999px !important;
      }

      .rating__input--none {
        display: none;
      }

      .rating__label {
        cursor: pointer;
        padding: 0 0.1em;
        font-size: 2rem;
      }

      .rating__icon--star {
        color: orange;
      }

      .rating__input:checked ~ .rating__label .rating__icon--star {
        color: #ddd;
      }

      .rating-group:hover .rating__label .rating__icon--star {
        color: orange;
      }

      .rating__input:hover ~ .rating__label .rating__icon--star {
        color: #ddd;
      }
      .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease-in-out;
        z-index: 1000;
        backdrop-filter: blur(2px);
    }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
            transform: scale(0.9);
            transition: all 0.3s ease-in-out;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .modal-overlay.open {
            opacity: 1;
            visibility: visible;
        }

        .modal-overlay.open .modal-content {
            transform: scale(1);
        }

      .btn_submit {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #333;
            border: 1px solid #333;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
      }
      .btn_close{
        margin-top: 20px;
        padding: 10px 20px;
        background-color: transparent;
        color: #333;
        border: 1px solid #333;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }
      .btn_submit:hover {
        background-color: #555;
        border: 1px solid #555;
      }
      .modal-content .form-control{
        width: 100%;
        padding: 10px 15px;
        border-radius: 5px;
        border: 1px solid #ddd;
        box-shadow: none;
        outline: 0;
        height: 110px;
        font-family: "Montserrat", sans-serif;
      }
      .button_group{
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 20px;
      }
      .button_group button{
        margin: 0 5px;
      }
      .help{
        text-align: center;
      }
      .help p{
        margin: 0;
        color: #747474;
      }
    </style>
  </head>
  <body>
    <div class="main_wrapper">
      <div class="logo">
        <img src="{{ asset('images/c2c-restoration.png') }}" alt="" style="width: -webkit-fill-available; max-width: 325px;" />
      </div>
      <div class="title_wrap">
        <h2>How was your experience?</h2>
        <p>
          Thank you for your business. We would really appreciate a review if
          you can spare a few minutes.
        </p>
      </div>
      <div class="review_box">
        <div class="company_info">
          <div class="company_img">
            <img src="{{ asset('images/c2c-restoration.png') }}" alt="" />
          </div>
          <div class="conpany_text">
            <h4>C2C Restoration</h4>
            <p>Roofing & Restoration</p>
          </div>
        </div>
        <div class="rating_wrap">
          <h4>Rate your experiance:</h4>
          <div class="rating-group">
            <input
              disabled
              checked
              class="rating__input rating__input--none"
              name="rating3"
              id="rating3-none"
              value="0"
              type="radio"
            />
            <label
              aria-label="1 star"
              class="rating__label open-modal-btn"
              for="rating3-1"
            >
              <i class="rating__icon rating__icon--star fa fa-star"></i>
            </label>
            <input
              class="rating__input"
              name="rating3"
              id="rating3-1"
              value="1"
              type="radio"
            />
            <label aria-label="2 stars" class="rating__label open-modal-btn" for="rating3-2">
              <i class="rating__icon rating__icon--star fa fa-star"></i>
            </label>
            <input
              class="rating__input"
              name="rating3"
              id="rating3-2"
              value="2"
              type="radio"
            />
            <label aria-label="3 stars" class="rating__label open-modal-btn" for="rating3-3">
              <i class="rating__icon rating__icon--star fa fa-star"></i>
            </label>
            <input
              class="rating__input"
              name="rating3"
              id="rating3-3"
              value="3"
              type="radio"
            />
            <label aria-label="4 stars" class="rating__label open-modal-btn" for="rating3-4">
              <i class="rating__icon rating__icon--star fa fa-star"></i>
            </label>
            <input
              class="rating__input"
              name="rating3"
              id="rating3-4"
              value="4"
              type="radio"
            />
            <label aria-label="5 stars" class="rating__label open-modal-btn" for="rating3-5">
              <i class="rating__icon rating__icon--star fa fa-star"></i>
            </label>
            <input
              class="rating__input"
              name="rating3"
              id="rating3-5"
              value="5"
              type="radio"
            />
          </div>
          <p>Tap a star to rate</p>
        </div>
      </div>
      <div class="help">
        <p>Your feedback helps us improve our service.</p>
        </div>
    </div>

    <div class="modal-overlay">
      <div class="modal-content">
        <h2>Write your review</h2>
            <textarea name="review" id="review" class="form-control" placeholder="Write you review"></textarea>
            <div class="button_group">
                <button class="btn_submit" type="submit">Submit</button>
                <button class="btn_close">Close</button>
            </div>
      </div>
    </div>

    <script>
        const openModalBtns = document.querySelectorAll(".open-modal-btn");
        const modalOverlay = document.querySelector(".modal-overlay");
        const closeModalBtn = document.querySelector(".btn_close");

        openModalBtns.forEach(btn => {
        btn.addEventListener("click", function() {
            modalOverlay.style.transition = 'none';
            modalOverlay.classList.add("open");
            void modalOverlay.offsetWidth;
            modalOverlay.style.transition = 'all 0.3s ease-in-out';
        });
        });

        closeModalBtn.addEventListener("click", function() {
        modalOverlay.classList.remove("open");
        });

        modalOverlay.addEventListener("click", function(e) {
        if (e.target === modalOverlay) {
            modalOverlay.classList.remove("open");
        }
        });

        document.addEventListener("keydown", function(e) {
        if (e.key === "Escape") {
            modalOverlay.classList.remove("open");
        }
        });
                
    </script>
  </body>
</html>
