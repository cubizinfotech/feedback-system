<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Customer Feedback Received</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; color: #222; }
        .container { background: #fff; border-radius: 8px; max-width: 500px; margin: 30px auto; padding: 32px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); }
        .header { font-size: 1.3rem; font-weight: bold; margin-bottom: 18px; }
        .label { color: #888; font-size: 0.98rem; }
        .value { font-size: 1.08rem; margin-bottom: 10px; }
        .feedback-box { background: #f3f3f3; border-radius: 6px; padding: 16px; margin-top: 18px; font-size: 1.05rem; }
        .stars { color: #ffb400; font-size: 1.2rem; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Customer Feedback Received</div>
        <div class="label">Customer Name:</div>
        <div class="value">{{ $customer->name }}</div>
        <div class="label">Customer Email:</div>
        <div class="value">{{ $customer->email }}</div>
        <div class="label">Rating:</div>
        <div class="stars">
            @for ($i = 1; $i <= 5; $i++)
                <span style="color:{{ $i <= $feedback->rating ? '#ffb400' : '#ccc' }}">&#9733;</span>
            @endfor
            ({{ $feedback->rating }}/5)
        </div>
        <div class="label">Feedback Message:</div>
        <div class="feedback-box">{{ $feedback->feedback_message }}</div>
    </div>
</body>
</html> 