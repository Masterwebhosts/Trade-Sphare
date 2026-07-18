@extends('layouts.app')

@section('content')
<div class="container">

    <h2>Wallet Top-Up</h2>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div style="color: green; margin-bottom: 10px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERRORS --}}
    @if ($errors->any())
        <div style="color: red; margin-bottom: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <form method="POST" action="{{ route('advertiser.topup.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- AMOUNT --}}
        <div style="margin-bottom: 12px;">
            <label>Amount (min $10)</label>
            <input type="number" name="amount" min="10" step="0.01" required>
        </div>

        {{-- PAYER --}}
        <div style="margin-bottom: 12px;">
            <label>Payer Name</label>
            <input type="text" name="payer_name" required>
        </div>

        {{-- COMPANY --}}
        <div style="margin-bottom: 12px;">
            <label>Company (optional)</label>
            <input type="text" name="company_name">
        </div>

        {{-- METHOD --}}
        <div style="margin-bottom: 12px;">
            <label>Payment Method</label>
            <select name="payment_method" required>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="cash">Cash</option>
                <option value="manual">Manual</option>
            </select>
        </div>

        {{-- RECEIPT --}}
        <div style="margin-bottom: 12px;">
            <label>Receipt</label>
            <input type="file" name="receipt" required>
        </div>

        <button type="submit">Submit Top-Up</button>
    </form>

</div>
@endsection
