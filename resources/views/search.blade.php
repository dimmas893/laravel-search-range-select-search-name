<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="icon" href="{{ URL::asset('photo/box2.svg') }}" type="image/x-icon" />
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    <link href="{{ asset('external-css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <div class="d-flex">
                        <div><img src="{{ asset('photo/box.svg') }}" style="height:50px;" alt=""></div>
                        <div class="pl-3 ml-3 pt-2" style="border-left:1px solid rgba(0, 0, 0, 0.5); font-size:1.5rem;">
                            {{ config('app.name', 'Laravel') }}</div>
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item">
                            <div class="d-flex">
                                <a class="nav-link" href="">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i><span
                                        class="badge">{{ Session::has('cart') ? Session::get('cart')->totalQuantity : '' }}</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <main class="py-4">

            <div class="container p-0">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-4 col-5 pl-4 filter">
                        <div class="fixedfilter">
                            <h3><i class="fa fa-filter"></i> Filter </h3>
                            <input class="mt-3" type="text" id="search" placeholder="Enter product name"
                                style="width:100%;">

                            <div class="filterprice card">
                                <div class="card-body">
                                    <h5 class="card-title">Price</h5>
                                    <input type="range" min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                        value="{{ $maxPrice }}" class="slider selector" id="pricerange">
                                    <p class="p-0 m-0">Max: RM <span id="currentrange">{{ $maxPrice }}</span></p>
                                </div>
                            </div>
                            <div class="filtergender card">
                                <div class="card-body">
                                    <h5 class="card-title">Gender</h5>
                                    @foreach ($genders as $genders)
                                        <input type="checkbox" id="{{ $genders['gender'] }}" class="gender selector"
                                            name="gender" value="{{ $genders['gender'] }}">
                                        <label for="{{ $genders['gender'] }}">{{ $genders['gender'] }}</label><br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="filterbrand card">
                                <div class="card-body">
                                    <h5 class="card-title">Brand</h5>
                                    @foreach ($brands as $brands)
                                        <input type="checkbox" id="{{ $brands['brand'] }}" class="brand selector"
                                            name="brand" value="{{ $brands['brand'] }}">
                                        <label for="{{ $brands['brand'] }}">{{ $brands['brand'] }}</label><br>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-8 col-7 pr-4">
                        <h3>Product</h3>
                        <div class="row d-flex justify-content-start" id="products"></div>
                    </div>
                </div>
            </div>
        </main>

    </div>

    <footer>
        <div class='container-fluid footer'>
            <div class='container p-0 pt-3'>
                <div class='row'>
                    <div class='col-md-4 col-sm-12 pt-3'>
                        <h3>Contact Information</h3>
                        <p>Endah Promenade <br> Bukit Jalil <br> +123456789 <br> customercare@therack.com</p>
                    </div>
                    <div class='col-md-4 col-sm-12 pt-3'>
                        <h3>Follow Us On</h3>
                        <ul>
                            <li><a href='https://facebook.com/' target='_blank'>
                                    <i class="fa fa-instagram"></i></a></li>
                            <li><a href='https://instagram.com/' target='_blank'>
                                    <i class="fa fa-facebook"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class='col-12 divider-footer p-0'>
                    </div>
                    <div class='col-md-6 col-sm-12 copyright'>
                        <p>Designed from scratch by Sherwin Variancia</p>
                        <p>therack &copy; 2019. All Rights Reserved</p>
                    </div>
                    <div class='col-md-6 col-sm-12 payment'> <img src="{{ asset('photo/cards.png') }}"
                            alt=''>
                    </div>
                    <div class='col-12 p-0 mt-3'>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>


<script src="{{ asset('js/jquery-3.3.1.slim.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>

@yield('script')
<script>
    $(document).ready(function() {

        filter_data('');

        function filter_data(query = '') {
            var search = JSON.stringify(query);
            var price = JSON.stringify($('#pricerange').val());
            var gender = JSON.stringify(get_filter('gender'));
            var brand = JSON.stringify(get_filter('brand'));
            $.ajax({
                url: "/search",
                method: 'GET',
                data: {
                    query: search,
                    price: price,
                    gender: gender,
                    brand: brand,
                },
                dataType: 'json',
                success: function(data) {
                    $('#products').html(data.table_data);
                }
            })
        }

        function get_filter(class_name) {
            var filter = [];
            $('.' + class_name + ':checked').each(function() {
                filter.push($(this).val());
            });
            return filter;
        }

        $(document).on('keyup', '#search', function() {
            var query = $(this).val();
            filter_data(query);
        });

        $('.selector').click(function() {
            var query = $('#search').val();
            filter_data(query);
        });

        $(document).on('input', '#pricerange', function() {
            var range = $(this).val();
            $('#currentrange').html(range);
        });

        $(document).on('change', '#size-dropdown', function() {
            var size = $(this).val();
            document.cookie = "shoes_size=" + size + ";" + "path=/";
            $('#add-to-cart').removeClass('disabled');
        });

    });
</script>

</html>
