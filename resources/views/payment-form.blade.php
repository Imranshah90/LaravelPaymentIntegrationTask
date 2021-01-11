@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Make Payment</div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Reference:</th>
                                <td>{{ $payment->reference }}</td>
                            </tr>
                            <tr>
                                <th>Payment Amount:</th>
                                <td>£{{ $payment->amount }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <form action="{{ route('make-payment', $payment->id) }}" method="POST" class="paymentWidgets"
                        data-brands="VISA MASTER AMEX">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    var wpwlOptions = {
      style: "card",
      billingAddress: {
        country: "",
        state: "",
        city: "",
        street1: "",
        street2: "",
        postcode: ""
      },
      showCVVHint: true,
      brandDetection: true,
    }
</script>
<script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{ $payment_data['id'] }}"></script>
@endpush
