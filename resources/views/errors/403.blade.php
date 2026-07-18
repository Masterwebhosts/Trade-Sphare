<!DOCTYPE html>
<html>
<head>
    <title>403 - Forbidden</title>
    <style>
        body {
            font-family: Arial;
            background: #f3f4f6;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }

        .box {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        h1 {
            font-size: 48px;
            color: #ef4444;
        }

        p {
            color: #6b7280;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #111827;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="box">
    <h1>403</h1>
    <p>You are not authorized to access this page.</p>
    @php
    $user = auth()->user();

    $redirectUrl = match($user?->role) {
        'admin' => url('/admin/dashboard'),
        'publisher' => url('/publisher'),
        'advertiser' => url('/advertiser'),
        default => url('/')
    };
@endphp

<a href="{{ $redirectUrl }}">
    Go Back
</a>
</div>

</body>
</html>
