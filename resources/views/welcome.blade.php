<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>UNIC-Warehouse</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

		<link rel="manifest" href="{{ asset('css/manifest.json') }}">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #131313;
                color: #fff;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 44px;
			}

            .links > a {
                color: #fff;
                padding: 0 10px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        @can('manage-users')
                            <a href="{{ url('/home') }}">Home</a>
                        @endcan
                        @can('create-vouchers')
                            <a href="{{ route('customerlist') }}">Vouchers</a>
                        @endcan
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
					Welcome to<br/>
                    <strong>UNIC Sales</strong> Warehouse
                </div>
				<div class="links">
					<a href="https://goo.gl/maps/M7iTZDpcsFt8oRwcA"><img src="{{ url('/images/gmap.png') }}" width="35px"></a>
					<a href="mailto: gmail@gmail.com"><img src="{{ url('/images/gmail.png') }}" width="35px"></a>
					<a href="https://api.whatsapp.com/send?phone=91phonenumber"><img src="{{ url('/images/whatsapp.png') }}" width="35px"></a>
                </div>
            </div>
        </div>
    </body>
</html>
