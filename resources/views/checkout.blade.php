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
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                                <br><br>
                                LONG URL: {{ session('long_url') }}<br>
                                SHORT URL: {{ session('short_url') }}<br>
                                Total Hits: {{ session('hits') }}<br>
                                Expires On: {{ session('expires_on') }}
                                
                            </div>
                            
                        @endif

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
                        <form method="post" action="{{ url("/process-checkout") }}">
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
                                        <div class="form-group">
                                            <label for="price">Credit Card Number:</label>
                                            <input type="text" class="form-control" id="credit_card_number" name="credit_card_number" value="{{old('credit_card_number')}}" placeholder="Credit Card Number">
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Credit Card Expiry</label>
                                            <select name="month" id = "month" class="form-control">
                                                <option value="01" {{ old('month')=="01"?'selected':''}}>JAN</option>
                                                <option value="02" {{ old('month')=="02"?'selected':''}}>FEB</option>
                                                <option value="03" {{ old('month')=="03"?'selected':''}}>MAR</option>
                                                <option value="04" {{ old('month')=="04"?'selected':''}}>APR</option>
                                                <option value="05" {{ old('month')=="05"?'selected':''}}>MAY</option>
                                                <option value="06" {{ old('month')=="06"?'selected':''}}>JUN</option>
                                                <option value="07" {{ old('month')=="07"?'selected':''}}>JUL</option>
                                                <option value="08" {{ old('month')=="08"?'selected':''}}>AUG</option>
                                                <option value="09" {{ old('month')=="09"?'selected':''}}>SEP</option>
                                                <option value="10" {{ old('month')=="10"?'selected':''}}>OCT</option>
                                                <option value="11" {{ old('month')=="11"?'selected':''}}>NOV</option>
                                                <option value="12" {{ old('month')=="12"?'selected':''}}>DEC</option>
                                            </select>
                                            <select name="year" id = "year" class="form-control">
                                                <option value="2018" {{ old('year')=="2018"?'selected':''}}>2018</option>
                                                <option value="2019" {{ old('year')=="2019"?'selected':''}}>2019</option>
                                                <option value="2020" {{ old('year')=="2020"?'selected':''}}>2020</option>
                                                <option value="2021" {{ old('year')=="2021"?'selected':''}}>2021</option>
                                                <option value="2022" {{ old('year')=="2022"?'selected':''}}>2022</option>
                                                <option value="2023" {{ old('year')=="2023"?'selected':''}}>2023</option>
                                                <option value="2024" {{ old('year')=="2024"?'selected':''}}>2024</option>
                                                <option value="2025" {{ old('year')=="2025"?'selected':''}}>2025</option>
                                                <option value="2026" {{ old('year')=="2026"?'selected':''}}>2026</option>
                                                <option value="2027" {{ old('year')=="2027"?'selected':''}}>2027</option>
                                                <option value="2028" {{ old('year')=="2028"?'selected':''}}>2028</option>
                                                <option value="2029" {{ old('year')=="2029"?'selected':''}}>2029</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Credit Card CVV</label>
                                            <input type="text" class="form-control" id="cvv" name="cvv" value="{{old('cvv')}}" placeholder="CVV">
                                        </div>
                                        <input type="submit" class="btn btn-info" value="Submit">
                                    </form>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <script language="javascript" type="text/javascript" src="js/jquery.min.js"></script>
        <script language="javascript" type="text/javascript" src="js/bootstrap.min.js"></script>
    </body>
</html>
