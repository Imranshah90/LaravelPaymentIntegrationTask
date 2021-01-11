@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Make Payment</div>

                @if(session()->has('payment-status'))
                <div class="alert alert-info">
                    <p class="mb-0"><strong>Result Code: </strong> {{ session('payment-status.code') }}</p>
                    <p><strong>Description: </strong> {{ session('payment-status.description') }}</p>
                </div>
                @endif

                <div class="card-body">
                    <form action="{{ route('init-payment') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">Amount</label>

                            <div class="col-md-6">
                                <input id="amount" type="number" placeholder="E.g: 20.00" min="0.01" step="0.01"
                                    class="form-control @error('amount') is-invalid @enderror" name="amount"
                                    value="{{ old('amount') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="reference" class="col-md-4 col-form-label text-md-right">Reference</label>

                            <div class="col-md-6">
                                <input id="reference" class="form-control @error('reference') is-invalid @enderror"
                                    name="reference" value="{{ old('reference') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <button class="btn btn-primary mx-auto">
                                Submit Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">Past Payments</div>
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Payment Timestamp</th>
                    <th>Amount</th>
                    <th>Reference</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <th>{{ $payment->payment_time ? $payment->payment_time->format('d-m-Y H:i') : 'N\A'}}</th>
                    <th>£{{ $payment->amount }}</th>
                    <th>{{ $payment->reference }}</th>
                    <th>
                        <span
                            class="badge {{ $payment->status === 'COMPLETED' ? 'badge-success' : 'bdage-default' }}">{{ $payment->status }}</span>
                    </th>
                    <th></th>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
