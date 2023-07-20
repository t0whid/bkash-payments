<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bkash Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">


</head>

<body>
    <div class="container mt-5">
        @yield('content')
    </div>
    <script src="{{ asset('assets/js/jquery-1.8.3.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <script id="myScript" src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js">
    </script>
    <script>
        var accessToken = '';

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });

            $.ajax({
                url: "{!! route('token') !!}",
                type: 'POST',
                contentType: 'application/json',
                success: function(data) {
                    console.log('got data from token  ..');
                    console.log(JSON.stringify(data));

                    accessToken = JSON.stringify(data);
                },
                error: function() {
                    console.log('error');

                }
            });

            var paymentConfig = {
                createCheckoutURL: "{!! route('create.payment') !!}",
                executeCheckoutURL: "{!! route('execute.payment') !!}",
            };


            var paymentRequest;
            paymentRequest = {
                amount: $('.amount').text(),
                intent: 'sale',
                invoice: $('.invoice').text(),
            };
            console.log(JSON.stringify(paymentRequest));

            bKash.init({
                paymentMode: 'checkout',
                paymentRequest: paymentRequest,
                createRequest: function(request) {
                    console.log('=> createRequest (request) :: ');
                    console.log(request);

                    $.ajax({
                        url: paymentConfig.createCheckoutURL + "?amount=" + paymentRequest
                            .amount + "&invoice=" + paymentRequest.invoice,
                        type: 'GET',
                        contentType: 'application/json',
                        success: function(data) {
                            console.log('got data from create  ..');
                            console.log('data ::=>');
                            console.log(JSON.stringify(data));

                            var obj = JSON.parse(data);

                            if (data && obj.paymentID != null) {
                                paymentID = obj.paymentID;
                                bKash.create().onSuccess(obj);
                            } else {
                                console.log('error');
                                bKash.create().onError();
                            }
                        },
                        error: function() {
                            console.log('error');
                            bKash.create().onError();
                        }
                    });
                },

                executeRequestOnAuthorization: function() {
                    console.log('=> executeRequestOnAuthorization');
                    $.ajax({
                        url: paymentConfig.executeCheckoutURL + "?paymentID=" + paymentID,
                        type: 'GET',
                        contentType: 'application/json',
                        success: function(data) {
                            console.log('got data from execute  ..');
                            console.log('data ::=>');
                            console.log(JSON.stringify(data));

                            data = JSON.parse(data);
                            if (data && data.paymentID != null) {
                                alert('[SUCCESS] data : ' + JSON.stringify(data));
                                window.location.href = "{!! route('orders.index') !!}";
                            } else {
                                bKash.execute().onError();
                            }
                        },
                        error: function() {
                            bKash.execute().onError();
                        }
                    });
                }
            });

            console.log("Right after init ");
        });

        function callReconfigure(val) {
            bKash.reconfigure(val);
        }

        function clickPayButton() {
            $("#bKash_button").trigger('click');
        }
    </script>

</body>

</html>
