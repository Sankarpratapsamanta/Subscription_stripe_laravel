@extends('layouts.userlayout')
@section('content')
@if ($user->hasIncompletePayment())
    <a href="{{ route('cashier.payment', $user->subscription()->latestPayment()->id) }}">
        Please confirm your payment.
    </a>
@endif

@endsection