<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Payment Processor Demo</title>

        <!-- Fonts -->
        <link href="css/app.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">


    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        @if (session('statusError'))
                            <div class="alert alert-danger">
                                {{ session('statusError') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ url("/process-checkout") }}" id="payment-form">
                            {{ csrf_field() }}
                            <div class="card">
                                <div class="card-header">Order Information</div>
                                <div class="card-body">
                                        
                                        <div class="form-group">
                                            <label for="currency">Select currency:</label>
                                            <select name="currency" id = "currency" class="form-control">
                                                <option value="USD" {{ old('currency')=="USD"?'selected':''}} >USD</option>
                                                <option value="EUR" {{ old('currency')=="EUR"?'selected':''}}>EUR</option>
                                                <option value="HKD" {{ old('currency')=="HKD"?'selected':''}}>THB</option>
                                                <option value="SGD" {{ old('currency')=="SGD"?'selected':''}}>SGD</option>
                                                <option value="AUD" {{ old('currency')=="AUD"?'selected':''}}>AUD</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="text" class="form-control" id="price" name="price" value="{{old('price')}}" placeholder="Enter product price">
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Full Name</label>
                                            <input type="text" class="form-control" id="full_name" name="full_name" value="{{old('full_name')}}" placeholder="Enter Full Name">
                                        </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">Payment Information</div>
                                <div class="card-body">
                                        <div class="form-group">
                                            <label for="card_holder_name">Card Holder Name:</label>
                                            <input type="text" class="form-control" id="card_holder_name" name="card_holder_name" placeholder="Full Name" value="{{old('card_holder_name')}}">
                                        </div>
                                        
                                        <div class="bt-drop-in-wrapper">
                                            <div id="bt-dropin"></div>
                                        </div>
                                        <input type="hidden" name = "order_id" id = "order_id" value = "{{$order_id}}">
                                        <input id="nonce" name="payment_method_nonce" type="hidden" />
                                        <input type="submit" class="btn btn-info" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <script language="javascript" type="text/javascript" src="js/jquery.min.js"></script>
        <script language="javascript" type="text/javascript" src="js/bootstrap.min.js"></script>
        <!-- Load the required Braintree dropin component. -->
        <script src="https://js.braintreegateway.com/web/dropin/1.13.0/js/dropin.min.js"></script>
        @include('partials.braintree-dropin')
    </body>
</html>
