@extends('layouts.front')

@section('content')
    <!-- Hero Area Start -->
    <section class="hero-area">
        <img class="cars" src="{{ asset('assets/front/images/heroarea-img.jpg') }}" alt="">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="content searchPannel">
                        <div class="heading-area">
                            <h1 class="title">
                                New & Used cars for sale
                            </h1>
                            <p class="sub-title">
                                Dream. Search. Drive.
                            </p>
                        </div>
                        <form id="searchForm" action="{{ route('front.cars') }}" method="get">
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <input name="carname" type="text" class="form-control" placeholder="Type car name">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <select class="form-control" name="brand_id[]">
                                        <option value="" selected disabled>{{ $langg->lang9 }}</option>
                                        @foreach ($brands as $key => $brand)
                                            <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <select class="form-control" name="condition_id[]">
                                        <option value="" selected disabled>{{ $langg->lang10 }}</option>
                                        @foreach ($conditions as $key => $condition)
                                            <option value="{{ $condition->name }}">{{ $condition->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <select class="form-control minprice">
                                        <option selected disabled>Min price</option>
                                        <option value="0">ANY</option>
                                        <option value="50001">R <?php echo number_format(50001); ?></option>
                                        <option value="100001">R <?php echo number_format(100001); ?></option>
                                        <option value="150001">R <?php echo number_format(150001); ?></option>
                                        <option value="250001">R <?php echo number_format(250001); ?></option>
                                        <option value="300001">R <?php echo number_format(300001); ?></option>
                                        <option value="350001">R <?php echo number_format(350001); ?></option>
                                        <option value="450001">R <?php echo number_format(450001); ?></option>
                                        <option value="500001">R <?php echo number_format(500001); ?></option>
                                        <option value="550001">R <?php echo number_format(550001); ?></option>
                                        <option value="600001">R <?php echo number_format(600001); ?></option>
                                        <option value="650001">R <?php echo number_format(650001); ?></option>
                                        <option value="700001">R <?php echo number_format(700001); ?></option>
                                        <option value="750001">R <?php echo number_format(750001); ?></option>
                                        <option value="800001">R <?php echo number_format(800001); ?></option>
                                        <option value="850001">R <?php echo number_format(850001); ?></option>
                                        <option value="900001">R <?php echo number_format(900001); ?></option>
                                        <option value="950001">R <?php echo number_format(950001); ?></option>
                                        <option value="1000001">R <?php echo number_format(1000001); ?></option>
                                        <option value="1250001">R <?php echo number_format(1250001); ?></option>
                                        <option value="1500001">R <?php echo number_format(1500001); ?></option>
                                        <option value="1750001">R <?php echo number_format(1750001); ?></option>
                                        <option value="20000001">R <?php echo number_format(2000001); ?></option>
                                    </select>
                                </div>

                                <div class="col-sm-6 form-group">
                                    <select class="form-control maxprice" placeholder="MAX PRICE">
                                        <option selected disabled>Max price</option>
                                        <option value="10000000000">ANY</option>
                                        <option value="50000">R <?php echo number_format(50000); ?></option>
                                        <option value="100000">R <?php echo number_format(100000); ?></option>
                                        <option value="150000">R <?php echo number_format(150000); ?></option>
                                        <option value="250000">R <?php echo number_format(250000); ?></option>
                                        <option value="300000">R <?php echo number_format(300000); ?></option>
                                        <option value="350000">R <?php echo number_format(350000); ?></option>
                                        <option value="450000">R <?php echo number_format(450000); ?></option>
                                        <option value="500000">R <?php echo number_format(500000); ?></option>
                                        <option value="550000">R <?php echo number_format(550000); ?></option>
                                        <option value="600000">R <?php echo number_format(600000); ?></option>
                                        <option value="650000">R <?php echo number_format(650000); ?></option>
                                        <option value="700000">R <?php echo number_format(700000); ?></option>
                                        <option value="750000">R <?php echo number_format(750000); ?></option>
                                        <option value="800000">R <?php echo number_format(800000); ?></option>
                                        <option value="850000">R <?php echo number_format(850000); ?></option>
                                        <option value="900000">R <?php echo number_format(900000); ?></option>
                                        <option value="950000">R <?php echo number_format(950000); ?></option>
                                        <option value="1000000">R <?php echo number_format(1000000); ?></option>
                                        <option value="1250000">R <?php echo number_format(1250000); ?></option>
                                        <option value="1500000">R <?php echo number_format(1500000); ?></option>
                                        <option value="1750000">R <?php echo number_format(1750000); ?></option>
                                        <option value="20000000">R <?php echo number_format(2000000); ?></option>
                                        <option value="1000000000000">R <?php echo number_format(2000000); ?>+</option>
                                    </select>
                                    <input type="hidden" name="minprice" value="">
                                    <input type="hidden" name="maxprice" value="">
                                </div>
                                <div class="col-sm-12"><button type="submit" class="mybtn1"
                                        style="width: 100%; outline: 0;">{{ $langg->lang12 }}</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Area End -->

    <!-- Featured Cars Area Start -->
    <section class="featuredCars">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10">
                    <div class="section-heading">
                        <h2 class="title">
                            {{ $ps->featured_btxt }}
                        </h2>
                        <p class="text">
                            Featured cars from CarCentral 365.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($fcars as $key => $fcar)
                    <div class="col-lg-4 col-md-6">
                        <a target="_blank" class="car-info-box" href={{ $fcar->siteURL }}>
                            <div class="img-area">
                                <img class="light-zoom" src="{{ $fcar->imgURL }}" alt="">
                            </div>
                            <div class="content">
                                <h4 class="title">
                                    {{ $fcar->title }}
                                </h4>
                                <ul class="top-meta">
                                    <li>
                                        {{-- <i class="far fa-eye"></i> {{ $fcar->views }} {{ $langg->lang13 }} --}}
                                    </li>
                                    <li>
                                        {{-- <i class="far fa-clock"></i> {{ time_elapsed_string($fcar->created_at) }} --}}
                                    </li>
                                </ul>
                                <ul class="short-info">
                                    <li class="north-west" title="Model Year">
                                        <img src="{{ asset('assets/front/images/calender-icon.png') }}" alt="">
                                        <p>{{ $fcar->makeYear }}</p>
                                    </li>
                                    <li class="north-west" title="Mileage">
                                        <img src="{{ asset('assets/front/images/road-icon.png') }}" alt="">
                                        <p>{{ $fcar->mileage }}</p>
                                    </li>
                                    <li class="north-west" title="Top Speed (KMH)">
                                        <img src="{{ asset('assets/front/images/transformar.png') }}" alt="">
                                        <p>{{ $fcar->fuel_type }}</p>
                                    </li>
                                </ul>
                                <div class="footer-area">
                                    <div class="left-area">
                                        <p class="price">
                                            R <?php echo number_format((int) $fcar->price); ?>
                                        </p>
                                    </div>
                                    <div class="right-area">
                                        <p class="condition">
                                            {{ $fcar->new_or_used }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="row justify-content-center mt-3">
                @if (count($fcars) == 6)
                    <a href="{{ route('front.cars') . '?type=featured' }}" class="mybtn1">
                        {{ $langg->lang15 }}
                    </a>
                @endif
            </div>
        </div>
    </section>
    <!-- Featured Cars Area End -->

    <!-- Featured Cars Area Start -->
    <section class="latestCars">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10">
                    <div class="section-heading">
                        <h2 class="title">
                            {{ $ps->latest_btxt }}
                        </h2>
                        <p class="text">
                            Latest cars from CarCentral 365.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">

                @foreach ($lcars as $key => $lcar)
                    <div class="col-lg-4 col-md-6">
                        <a target="_blank" class="car-info-box" href="{{ $lcar->siteURL }}">
                            <div class="img-area">
                                <img class="light-zoom" src="{{ $lcar->imgURL }}" alt="">
                            </div>
                            <div class="content">
                                <h4 class="title" style="height: 28px;">
                                    {{ $lcar->title }}
                                </h4>
                                <ul class="top-meta">
                                    <li>
                                        {{-- <i class="far fa-eye"></i> {{ $lcar->views }} {{ $langg->lang13 }} --}}
                                    </li>
                                    <li>
                                        {{-- <i class="far fa-clock"></i> {{ time_elapsed_string($lcar->created_at) }} --}}
                                    </li>
                                </ul>
                                <ul class="short-info">
                                    <li class="north-west" title="Model Year">
                                        <img src="{{ asset('assets/front/images/calender-icon.png') }}" alt="">
                                        <p>{{ $lcar->makeYear }}</p>
                                    </li>
                                    <li class="north-west" title="Mileage">
                                        <img src="{{ asset('assets/front/images/road-icon.png') }}" alt="">
                                        <p>{{ $lcar->mileage }}</p>
                                    </li>
                                    <li class="north-west" title="Top Speed (KMH)">
                                        <img src="{{ asset('assets/front/images/transformar.png') }}" alt="">
                                        <p>{{ $lcar->fuel_type }}</p>
                                    </li>
                                </ul>
                                <div class="footer-area">
                                    <div class="left-area">
                                        <p class="price">
                                            R <?php echo number_format((int) $lcar->price); ?>
                                        </p>
                                    </div>
                                    <div class="right-area">
                                        <p class="condition">
                                            {{ $lcar->new_or_used }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="row justify-content-center mt-3">
                @if (count($lcars) == 6)
                    <a href="{{ route('front.cars') }}" class="mybtn1">
                        {{ $langg->lang15 }}
                    </a>
                @endif
            </div>
        </div>
    </section>
    <!-- Featured Cars Area End -->

    <!-- Testimonial Area Start -->
    <section class="testimonial">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10">
                    <div class="section-heading">
                        <h2 class="title">
                            {{ $ps->testimonial_title }}
                        </h2>
                        <p class="text">
                            {{ $ps->testimonial_subtitle }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="testimonial-slider">
                        @foreach ($testimonials as $key => $testimonial)
                            <div class="single-testimonial">
                                <div class="people">
                                    <div class="img">
                                        <img src="{{ asset('assets/images/testimonials/' . $testimonial->image) }}"
                                            alt="">
                                    </div>
                                    <h4 class="title">{{ $testimonial->name }}</h4>
                                    <p class="designation">{{ $testimonial->rank }}</p>
                                </div>
                                <div class="review-text">
                                    <p>
                                        "{{ $testimonial->comment }}"
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Area End -->

    <!-- Blog Area Start -->

    <!-- Blog Area End -->
@endsection


@section('scripts')
    <script>
        var minArray = [0, 50001, 100001, 150001, 250001, 300001, 350001, 450001, 500001, 550001, 600001, 650001, 700001,
            750001, 800001, 850001, 900001, 950001, 1000001, 1250001, 1500001, 1750001, 20000001
        ];
        var maxArray = [0, 50000, 100000, 150000, 250000, 300000, 350000, 450000, 500000, 550000, 600000, 650000, 700000,
            750000, 800001, 850000, 900000, 950000, 1000000, 1250000, 1500000, 1750000, 20000000
        ];
        var minprice = 0,
            maxprice = 20000000;
        $(".minprice").on('click', function(e) {
            minprice = $(this).val();
            minprice = parseInt(minprice);
            maxprice = parseInt(maxprice);
            if (minprice > maxprice) {
                for (let i = 0; i < minArray.length; i++) {
                    console.log(minprice, minArray[i]);
                    if (minprice == minArray[i]) {
                        $(".maxprice").val(maxArray[i + 1]).change();
                        $("input[name='maxprice']").val(maxArray[i + 1]);
                    }
                    if (minprice == 20000001 && maxprice == 20000000) {
                        $(".minprice").val(1750001).change();
                        $(".maxprice").val(20000000).change();
                        $("input[name='minprice']").val(1750001);
                        $("input[name='maxprice']").val(20000000);
                    }
                }
            }
            $("input[name='minprice']").val(minprice);
        })
        $(".maxprice").on('click', function(e) {
            maxprice = $(this).val();
            minprice = parseInt(minprice);
            maxprice = parseInt(maxprice);
            if (minprice > maxprice) {
                for (let i = 0; i < minArray.length; i++) {
                    console.log(minprice, minArray[i]);
                    if (maxprice == maxArray[i]) {
                        $(".minprice").val(minArray[i - 1]).change();
                        $("input[name='minprice']").val(minArray[i + 1]);
                    }
                    if (maxprice == 50000) {
                        $(".minprice").val(0).change();
                        $("input[name='minprice']").val(0);
                    }
                }
            }
            $("input[name='maxprice']").val(maxprice);

        })
        $(".sel-price").on('change', function() {
            let url = '{{ url('/') }}/prices/' + $(this).val();
            $.get(
                url,
                function(data) {
                    console.log(data);
                    $("input[name='minprice']").val(data.minimum);
                    $("input[name='maxprice']").val(data.maximum);
                }
            )
        });
    </script>
@endsection
