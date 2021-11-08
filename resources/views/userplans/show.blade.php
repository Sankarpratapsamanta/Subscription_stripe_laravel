@extends('layouts.userlayout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="text-center">
                <p class="mt-3">-----| You will be pay Rs {{ number_format($plan->price, 2) }} for {{ $plan->plan_name }} Plan |-----</p>
            </div>
            <div class="card" >
                <form action="/plans" method="POST" id="payment-form"> 
                    @csrf  
                    <div style="margin:auto auto;width:50%;">
                        <h6 class="text-start mt-3 mb-5">Customer information <hr style="color:red;"> </h6>

                        <div class="form-group mb-5">
                            <h6 class="text-muted">NAME</h6>
                            <input type="text" name="name" class="form-control" value={{Auth::user()->name}}>
                        </div>

                        <div class="form-group mb-5">
                            <h6 class="text-muted">EMAIL</h6>
                            <input type="text" name="email" class="form-control" value={{Auth::user()->email}}>
                        </div>

                        <div class="form-group mb-5">
                            <h6 class="text-muted">PRESENT ADDRESS</h6>
                            <input type="text" name="line1" class="form-control">
                        </div>

                        <div class="form-group mb-5">
                            <h6 class="text-muted">PERMANENT ADDRESS</h6>
                            <input type="text" name="line2" class="form-control">
                        </div>

                        <div class="form-group mb-5">
                            <h6 class="text-muted">CITY</h6>
                            <input type="text" name="city" class="form-control">
                        </div>
                        <div class="form-group mb-5">
                            <h6 class="text-muted">STATE</h6>
                            <input type="text" name="state" class="form-control">
                        </div>

                        <div class="form-group mb-5">
                            <h6 class="text-muted">COUNTRY</h6>
                            <input type="text" name="country" class="form-control">
                        </div>

                        <div class="form-group mb-5">
                            <h6 class="text-muted">POSTAL CODE</h6>
                            <input type="text" name="postal_code" class="form-control">
                        </div>
                    </div>
                    <div style="margin:auto auto;width:50%;">
                        <h6 class="text-start mb-5">Payment information <hr style="color:red;"> </h6>
                        <input id="card-holder-name" class="form-control" placeholder="Card Holder Name" type="text">

                        <!-- Stripe Elements Placeholder -->
                        <div class="form-control mt-3" style="background:white;" id="card-element"></div>

                        <div id="card-errors" role="alert"></div>
                        <!-- plan_id -->
                        <input type="hidden" name="plan" value="{{ $plan->slug }}" />

                        <input type="hidden" name="plan_id" value="{{ $plan->id }}" />


                        <!-- payment method -->
                        <input type="hidden" name="payment_method" id="payment-method">

                        <button  id="card-button" type="submit"  class="btn btn-dark mt-5" data-secret="{{ $intent->client_secret }}">
                            Pay
                        </button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe('pk_test_51Jokj5SGZ6dC5yOb9nhgoIhDDq9qmNwE5jZTCnqT8h1mLVljFtq2vSn0peSdW5zsbAX1LwcPGkGAgmje0DdjlX5q002JlUVl3C');

    const elements = stripe.elements();
    const cardElement = elements.create('card');
    const cardHoldername = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;
    cardElement.mount('#card-element');


    cardElement.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });



    // Handle form submission.

    const paymentForm = document.getElementById('payment-form');

    paymentForm.addEventListener('submit',function(event){
        event.preventDefault();
        // paymentForm.submit();
        stripe.handleCardSetup(clientSecret, cardElement, {
                payment_method_data: {
                    billing_details: { name: cardHoldername.value }
                }
            })
            .then(function(result) {
                console.log(result);
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    console.log(result);
                    const paymentMethodInput = document.getElementById('payment-method');
                    paymentMethodInput.value = result.setupIntent.payment_method;
                    paymentForm.submit();
                    // Send the token to your server.
                    // stripeTokenHandler(result.setupIntent.payment_method);
                }
            });
    })
</script>



@endsection
