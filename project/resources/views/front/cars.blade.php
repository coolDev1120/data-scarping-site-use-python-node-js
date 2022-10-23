@extends('layouts.front')

@section('styles')
    <style>

    </style>
@endsection

@section('content')

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="pagetitle">
                        {{ $langg->lang301 }}
                    </h1>
                    <ul class="pages">
                        <li>
                            <a href="{{ route('front.index') }}">
                                {{ $langg->lang1 }}
                            </a>
                        </li>
                        <li class="active">
                            <a href="#">
                                {{ $langg->lang301 }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End -->

    <!-- sub-categori Area Start -->
    <section class="sub-categori">
        <div class="container">
            <div class="row">
                <div class="item-filter col-sm-12">
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-sm-12">
                            <select class="short-item sel-sort form-control" name="sort"
                                style="margin-left: 10px;width: 200px; float: right;">
                                <option value="desc" {{ request()->input('sort') == 'desc' ? 'selected' : '' }}>
                                    {{ $langg->lang24 }}</option>
                                <option value="asc" {{ request()->input('sort') == 'asc' ? 'selected' : '' }}>
                                    {{ $langg->lang25 }}</option>
                                <option value="price_desc" {{ request()->input('sort') == 'price_desc' ? 'selected' : '' }}>
                                    {{ $langg->lang26 }}</option>
                                <option value="price_asc" {{ request()->input('sort') == 'price_asc' ? 'selected' : '' }}>
                                    {{ $langg->lang27 }}</option>
                            </select>

                            <select class="short-itemby-no sel-view form-control"
                                style="margin-left: 10px; width: 100px; float:right;">
                                <option value="10" {{ request()->input('per_page') == 10 ? 'selected' : '' }}>
                                    {{ $langg->lang29 }}</option>
                                <option value="20" {{ request()->input('per_page') == 20 ? 'selected' : '' }}>
                                    {{ $langg->lang30 }}</option>
                                <option value="30" {{ request()->input('per_page') == 30 ? 'selected' : '' }}>
                                    {{ $langg->lang31 }}</option>
                                <option value="40" {{ request()->input('per_page') == 40 ? 'selected' : '' }}>
                                    {{ $langg->lang32 }}</option>
                                <option value="50" {{ request()->input('per_page') == 50 ? 'selected' : '' }}>
                                    {{ $langg->lang33 }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="left-area">
                        <div class="design-area">
                            <div class="header-area">
                                <h4 class="title">
                                    Name
                                </h4>
                            </div>
                            <div class="body-area">
                                <input name="carname" id="carname" class="form-control" placeholder="Type car name"
                                    value="{{ !empty(request()->input('carname')) ? request()->input('carname') : '' }}">
                                <button class="filter-btn price-btn carname-btn"
                                    type="button">{{ $langg->lang34 }}</button>
                            </div>
                        </div>
                        <div class="design-area">
                            <?php
                            $locations = ['Eastern Cape', 'Free State', 'Gauteng', 'Kwazulu Natal', 'Limpopo', 'Mpumalanga', 'North West Province', 'Northern Cape', 'Western Cape'];
                            ?>
                            <div class="header-area">
                                <h4 class="title">
                                    Location
                                </h4>
                            </div>
                            <div class="body-area">
                                <ul class="filter-list location-list">
                                    @foreach ($locations as $location)
                                        <li>
                                            <div class="content">
                                                <div class="check-box">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input location-check" type="checkbox"
                                                            id="{{ 'location_' . str_replace(' ', '_', $location) }}"
                                                            value="{{ $location }}">
                                                        <span class="checkmark"></span>
                                                        <label class="form-check-label location-label"
                                                            for="{{ 'location_' . str_replace(' ', '_', $location) }}">
                                                            {{ $location }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="design-area">
                            <?php $car_conditions = ['New', 'Used']; ?>
                            <div class="header-area">
                                <h4 class="title">
                                    {{ $langg->lang44 }}
                                </h4>
                            </div>
                            <div class="body-area">
                                <ul class="filter-list condition-list">
                                    @foreach ($car_conditions as $car_condition)
                                        <li>
                                            <div class="content">
                                                <div class="check-box">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input condition-check" type="checkbox"
                                                            id="{{ 'condition_' . $car_condition }}"
                                                            value="{{ $car_condition }}"
                                                            {{ in_array($car_condition, $derived_conditions) ? 'checked' : '' }}>
                                                        <span class="checkmark"></span>
                                                        <label class="form-check-label condition-label"
                                                            for="{{ 'condition_' . $car_condition }}">
                                                            {{ $car_condition }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="filter-result-area" style="margin-top: 30px;">
                            <div class="header-area">
                                <h4 class="title">
                                    Price (R)
                                </h4>
                            </div>
                            <div class="body-area">
                                <form action="#">
                                    <div class="price-range-block">
                                        <div class="row">
                                            <div class="col-sm-12 form-group">
                                                <select class="form-control minprice">
                                                    <option selected disabled>Min price</option>
                                                    <option>ANY</option>
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
                                            <div class="col-sm-12 form-group">
                                                <select class="form-control maxprice" placeholder="MAX PRICE">
                                                    <option selected disabled>Max price</option>
                                                    <option>ANY</option>
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
                                        </div>
                                    </div>
                                    <button class="filter-btn price-btn price-apply-btn"
                                        type="button">{{ $langg->lang34 }}</button>
                                </form>
                            </div>
                        </div>

                        <div class="filter-result-area" style="margin-top: 30px;">
                            <div class="header-area">
                                <h4 class="title">
                                    Mileage (KM)
                                </h4>
                            </div>
                            <div class="body-area">
                                <form action="#">
                                    <div class="price-range-block">
                                        <div id="mile-slider-range" class="price-filter-range" name="rangeInput"></div>
                                        <div class="livecount">
                                            <input class="mileageMin" type="number" min=0 max="11499999"
                                                oninput="validity.valid||(value='0');" id="min_mile"
                                                class="price-range-field" />
                                            <input class="mileageMax" type="number" min=0 max="11499999"
                                                oninput="validity.valid||(value='10000');" id="max_mile"
                                                class="price-range-field" />
                                        </div>
                                    </div>

                                    <button class="filter-btn price-btn mile-apply-btn"
                                        type="button">{{ $langg->lang34 }}</button>
                                </form>
                            </div>
                        </div>

                        <div class="design-area">
                            <div class="header-area">
                                <h4 class="title">
                                    Model
                                </h4>
                            </div>
                            <div class="body-area">
                                <ul class="filter-list brand-list">
                                    <?php $brandNames = []; ?>
                                    @foreach ($brands as $key => $brand)
                                        <?php array_push($brandNames, $brand->name); ?>
                                        <li>
                                            <div class="content">
                                                <div class="check-box">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input brand-check" type="checkbox"
                                                            id="b{{ $brand->id }}" value="{{ $brand->name }}"
                                                            {{ in_array($brand->name, $derived_brands) ? 'checked' : '' }}>
                                                        <span class="checkmark"></span>
                                                        <label class="form-check-label brand-label"
                                                            for="b{{ $brand->id }}">
                                                            {{ $brand->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    <?php $brandNames = json_encode($brandNames); ?>
                                    <div class="row">
                                        <div class="col-lg-6">
                                        </div>
                                        <div class="col-lg-6">
                                            <a href="#" id="showMore" class="d-inline-block mt-2">show more</a>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                        </div>

                        <div class="design-area">
                            <?php
                            $fuel_types = ['Diesel', 'Electric', 'Hybrid', 'Petrol'];
                            ?>
                            <div class="header-area">
                                <h4 class="title">
                                    Fuel Type
                                </h4>
                            </div>
                            <div class="body-area">
                                <ul class="filter-list fuel-type-list">
                                    @foreach ($fuel_types as $fuel_type)
                                        <li>
                                            <div class="content">
                                                <div class="check-box">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fuel-type-check" type="checkbox"
                                                            id="{{ 'fuel_type_' . $fuel_type }}"
                                                            value="{{ $fuel_type }}">
                                                        <span class="checkmark"></span>
                                                        <label class="form-check-label fuel-type-label"
                                                            for="{{ 'fuel_type_' . $fuel_type }}">
                                                            {{ $fuel_type }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="design-area">
                            <?php
                            $colors = ['Beige', 'Black', 'Blue', 'Brown', 'Gold', 'Green', 'Grey', 'Orange', 'Pink', 'Purple', 'Red', 'Silver', 'Unknown', 'White', 'Yellow'];
                            ?>
                            <div class="header-area">
                                <h4 class="title">
                                    Colors
                                </h4>
                            </div>
                            <div class="body-area">
                                <ul class="filter-list color-list">
                                    @foreach ($colors as $color)
                                        <li>
                                            <div class="content">
                                                <div class="check-box">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input color-check" type="checkbox"
                                                            id="{{ 'color_' . $color }}" value="{{ $color }}">
                                                        <span class="checkmark"></span>
                                                        <label class="form-check-label color-label"
                                                            for="{{ 'color_' . $color }}">
                                                            {{ $color }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="design-area">
                            <?php
                            $transmissions = ['Automatic', 'Manual'];
                            ?>
                            <div class="header-area">
                                <h4 class="title">
                                    Manual / Auto
                                </h4>
                            </div>
                            <div class="body-area">
                                <ul class="filter-list transmission-list">
                                    @foreach ($transmissions as $transmission)
                                        <li>
                                            <div class="content">
                                                <div class="check-box">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input transmission-check" type="checkbox"
                                                            id="{{ 'transmission_' . $transmission }}"
                                                            value="{{ $transmission }}">
                                                        <span class="checkmark"></span>
                                                        <label class="form-check-label transmission-label"
                                                            for="{{ 'transmission_' . $transmission }}">
                                                            {{ $transmission }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 order-first order-lg-last">
                    <div class="right-area">

                        <div class="categori-item-area">
                            <div class="row" id="loadingDiv" style="display: none;">
                                <div class="loading">
                                    <span class="loading__anim"></span>
                                </div>
                            </div>
                            <div class="row" id="carsDiv">

                            </div>
                        </div>
                        <div class="custom-pagination">
                            <div class="pagination">

                                <input type="hidden" value="{{ $totalPages }}" id="totalPages" />
                                <ul>
                                    <!--pages or li are comes from javascript -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- sub-categori Area End -->

    <form id="searchForm" class="d-none" action="{{ route('front.cars') }}" method="get">
        <input type="text" name="minprice"
            value="{{ !empty(request()->input('minprice')) ? request()->input('minprice') : $minprice }}">
        <input type="hidden" name="maxprice"
            value="{{ !empty(request()->input('maxprice')) ? request()->input('maxprice') : $maxprice }}">
        <input type="hidden" name="category_id"
            value="{{ !empty(request()->input('category_id')) ? request()->input('category_id') : null }}">
        @if (!empty(request()->input('brand_id')))
            @php
                $brands = request()->input('brand_id');
            @endphp
            @foreach ($brands as $key => $brand)
                <input type="hidden" name="brand_id[]" value="{{ $brand }}">
            @endforeach
        @endif
        <input type="hidden" name="fuel_type_id"
            value="{{ !empty(request()->input('fuel_type_id')) ? request()->input('fuel_type_id') : null }}">
        <input type="hidden" name="transmission_type_id"
            value="{{ !empty(request()->input('transmission_type_id')) ? request()->input('transmission_type_id') : null }}">
        <input type="hidden" name="type"
            value="{{ !empty(request()->input('type')) ? request()->input('type') : 'all' }}">
        <input type="hidden" name="sort"
            value="{{ !empty(request()->input('sort')) ? request()->input('sort') : 'desc' }}">
        <input type="hidden" name="per_page"
            value="{{ !empty(request()->input('per_page')) ? request()->input('per_page') : 10 }}">
        <input type="hidden" name="carname"
            value="{{ !empty(request()->input('carname')) ? request()->input('carname') : '' }}">
        <button type="submit"></button>
    </form>

    <form id="detailForm" class="d-none" action="{{ route('front.cars.detail') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="detail_data" value="">
    </form>

    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection


@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script>
        var minprice = {{ $minprice }};
        var maxprice = {{ $maxprice }};
        // pricing range
        var minArray = [0, 50001, 100001, 150001, 250001, 300001, 350001, 450001, 500001, 550001, 600001, 650001, 700001,
            750001, 800001, 850001, 900001, 950001, 1000001, 1250001, 1500001, 1750001, 20000001
        ];
        var maxArray = [0, 50000, 100000, 150000, 250000, 300000, 350000, 450000, 500000, 550000, 600000, 650000, 700000,
            750000, 800001, 850000, 900000, 950000, 1000000, 1250000, 1500000, 1750000, 20000000
        ];

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


        // mile range
        $(document).ready(function() {
            $("#mile-range-submit").hide(), $("#min_mile,#max_mile").on("change", function() {
                $("#mile-range-submit").show();
                var e = parseInt($("#min_mile").val()),
                    i = parseInt($("#max_mile").val());
                e > i && $("#max_mile").val(e), $("#mile-slider-range").slider({
                    values: [e, i]
                })
            }), $("#min_mile,#max_mile").on("paste keyup", function() {
                $("#mile-range-submit").show();
                var e = parseInt($("#min_mile").val()),
                    i = parseInt($("#max_mile").val());
                e == i && (i = e + 100, $("#min_mile").val(e), $("#max_mile").val(i)), $(
                    "#mile-slider-range").slider({
                    values: [e, i]
                })
            }), $(function() {
                $("#mile-slider-range").slider({
                    range: !0,
                    orientation: "horizontal",
                    min: 0,
                    max: 10199999,
                    values: [0, 10199999],
                    step: 50,
                    slide: function(e, i) {
                        if (i.values[0] == i.values[1]) return !1;
                        $("#min_mile").val(i.values[0]), $("#max_mile").val(i.values[1])
                    }
                }), $("#min_mile").val($("#mile-slider-range").slider("values", 0)), $("#max_mile").val(
                    $("#mile-slider-range").slider("values", 1))
            }), $("#mile-slider-range,#mile-range-submit").click(function() {
                var e = $("#min_mile").val(),
                    i = $("#max_mile").val();
                $("#searchResults").text("Here List of products will be shown which are cost between " + e +
                    " and " + i + ".")
            })
        });
    </script>


    <script>
        $(document).ready(function() {
            $(".brand-list li").each(function(i) {
                if (i < 6) {
                    $(this).addClass('d-block');
                } else {
                    $(this).addClass('d-none addbrand');
                }
            });

            $("#showMore").on('click', function(e) {
                e.preventDefault();

                let btntxt = $(e.target).html();

                if (btntxt == 'show more') {
                    $(e.target).html('show less');
                } else {
                    $(e.target).html('show more');
                }

                $(".brand-list li").each(function() {
                    if ($(this).hasClass('addbrand')) {
                        $(this).toggleClass('d-none');
                    }
                });
            })
        })
    </script>



    {{-- Populate search form with values --}}
    <script>
        $(document).ready(function() {

            $(".price-btn").click(function() {
                $("input[name='minprice']").val($(".minprice").val());
                $("input[name='maxprice']").val($(".maxprice").val());
            });

            $(".cat-anchor").click(function(e) {
                e.preventDefault();
                $("input[name='category_id']").val($(this).data('cat_id'));
                $("#searchForm").trigger('submit');
            });

            $(".brand-check").on("click", function() {
                if ($("input[name='brand_id[]']").length > 0) {
                    $("input[name='brand_id[]']").remove();
                }
                $(".brand-check").each(function() {
                    if ($(this).prop("checked")) {
                        // console.log($(this).prop("checked"));
                        $("#searchForm").append(
                            `<input type="hidden" name="brand_id[]" value="${$(this).val()}">`);
                    }
                });
            });

            $("#selFuel").on('change', function() {
                $("input[name='fuel_type_id']").val($(this).val());
                $("#searchForm").trigger('submit');
            });

            $("#selTransmission").on('change', function() {
                $("input[name='transmission_type_id']").val($(this).val());
                $("#searchForm").trigger('submit');
            });

            $("#selCondition").on('change', function() {
                $("input[name='condition_id']").val($(this).val());
                $("#searchForm").trigger('submit');
            });

            $(".apply-btn").on('click', function() {
                $("#searchForm").trigger('submit');
            });

            $(".sel-sort").on('change', function() {
                $("input[name='sort']").val($(this).val());
                $("#searchForm").trigger('submit');
            });

            $(".sel-view").on('change', function() {
                $("input[name='per_page']").val($(this).val());
                $("#searchForm").trigger('submit');
            });

            $(".sel-view").on('carname', function() {
                $("input[name='carname']").val($(this).val());
                $("#searchForm").trigger('submit');
            });
        })
    </script>

    {{-- get car info --}}
    <script>
        let currentApiData = [],
            locationArray = [],
            conditionsArray = {!! json_encode($derived_conditions) !!},
            brandsArray = {!! json_encode($derived_brands) !!},
            priceArray = [],
            mileArray = [],
            fueltypesArray = [],
            colorsArray = [],
            transmissionArray = [],
            totalPages = 0,
            page = 1,
            per_page = $("input[name='per_page']").val(),
            sort = $("input[name='sort']").val(),
            carname = $("input[name='carname']").val()

        priceArray[0] = parseInt(minprice);
        priceArray[1] = parseInt(maxprice);

        let price_temp = [],
            priceFlag = false;
        $("#priceMax").on('click', function(e) {
            priceFlag = !priceFlag;
            price_temp = [2000000, 10000000000000];
        })

        function generateCarDivContent(data) {
            // createPagination(totalPages, 1);
            let carDivHtml = "";
            data.forEach((apiDataItem) => {
                // var Carprice = apiDataItem.category == 1 ? apiDataItem.price ? 'R' + apiDataItem.price;

                var outPrice = apiDataItem.price.toLocaleString(undefined, {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 2
                })

                carDivHtml += `
					<div class="col-lg-6 col-md-6">
                        <div class="carItem">
                            <a target="_blank" class="car-info-box" href='${apiDataItem.siteURL}'">
                                <div class="img-area">
                                    <img class="light-zoom" src="${apiDataItem.imgURL == '/Common/Content/Images/NoImage/no-image-car.svg?z=683289' ? 'https://www.autotrader.co.za/Common/Content/Images/NoImage/no-image-car.svg?z=683289': apiDataItem.imgURL}" alt="">
                                </div>
                                <div class="content">
                                    <h4 class="title">
                                        ${apiDataItem.title}
                                    </h4>
                                    <ul class="top-meta">
                                        <li>
                                            <i class="fas fa-road"></i> ${apiDataItem.mileage}
                                        </li>
                                        <li>
                                            <i class="fas fa-code-branch"></i> ${apiDataItem.transmission}
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/front/images/calender-icon.png') }}" alt="" style="filter: grayscale(1);padding-bottom: 6px;">
                                            ${apiDataItem.makeYear}
                                        </li>
                                    </ul>
                                    <ul class="short-info">
                                        <li class="north-west" title="Position">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p>${apiDataItem.province}</p>
                                        </li>
                                        <li class="north-west" title="Fuel Type">
                                            ${apiDataItem.fuel_type != "None"? `<i class="fas fa-gas-pump"></i>` : ``}
                                            
                                            <p>${apiDataItem.fuel_type != "None"? apiDataItem.fuel_type:apiDataItem.dealername}</p>
                                        </li>
                                        <li class="north-west" title="Color">
                                            ${  apiDataItem.category == 1 ? `<i class="fas fa-palette"></i><p>${apiDataItem.colour}</p>` : apiDataItem.dealerImg == "None" ? `<i class="fas fa-palette"></i><p>None</p>` : `<img style="margin-top: -30px;" src="${apiDataItem.dealerImg}">` }
                                            
                                        </li>
                                    </ul>
                                    <div class="footer-area">
                                        <div class="left-area">																	
                                            <p class="price">
                                                R ${outPrice}
                                            </p>																	
                                        </div>
                                        <div class="right-area">
                                            <p class="condition">
                                                ${apiDataItem.new_or_used}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
					</div>
				`;
            });

            $("#loadingDiv").hide();
            $("#carsDiv").show();
            $("#carsDiv").append(carDivHtml);
        }

        function getApiData(page) {
            $("#loadingDiv").show();
            $("#carsDiv").hide();
            $("#carsDiv").html('');

            priceArray = priceFlag ? price_temp : priceArray;
            if (priceArray[0] == "ANY" || priceArray[0] == null) {
                priceArray[0] = 0;
            }
            if (priceArray[1] == "ANY" || priceArray[1] == null) {
                priceArray[1] = 10000000000;
            }

            var isLocation = (JSON.stringify(locationArray)).length;
            $.ajax({
                url: "{{ route('front.carApi') }}",
                data: {
                    "page": page,
                    "per_page": per_page,
                    "locations": JSON.stringify(locationArray),
                    "conditions": JSON.stringify(conditionsArray),
                    "brands": JSON.stringify(brandsArray),
                    "fuel_types": JSON.stringify(fueltypesArray),
                    "colors": JSON.stringify(colorsArray),
                    "transmissions": JSON.stringify(transmissionArray),
                    "prices": JSON.stringify(priceArray),
                    "miles": JSON.stringify(mileArray),
                    "sort": sort,
                    "carname": carname
                },
                type: 'POST',
                success: function(data) {
                    data = JSON.parse(data);
                    console.log(data);
                    var apiData = data.result;
                    totalPages = data.totalPage;
                    if (apiData.length > 0) {
                        currentApiData = apiData;
                        generateCarDivContent(apiData);
                        if (totalPages == 0) {
                            const element = document.querySelector(".pagination ul");
                            $(".pagination").html("");
                        }
                    } else {
                        $("#loadingDiv").hide();
                        $("#carsDiv").show();
                        $("#carsDiv").html('<h4 style="margin: 0 auto;">Sorry. You have 0 results. </h4>');
                    }
                    // createPagination(totalPages, page);
                    updatePagination(totalPages, page);
                },
                error: function(xhr, status, error) {
                    alert("There's an error unexpectedly. Please try it again.");
                }
            });
        }

        function showDetail(id) {
            let data = currentApiData.find(x => x.id == id);
            if (!data) {
                alert("No detail data. Please try again later.");
                return;
            }

            $("input[name='detail_data']").val(JSON.stringify(data));
            $("#detailForm").submit();
        }


        $('.location-check').change(function() {
            locationArray = [];
            $('.location-check').each(function() {
                var sThisVal = (this.checked ? $(this).val() : "");
                if (sThisVal != '')
                    locationArray.push(sThisVal);
            });
            page = 1;
            createPagination(totalPages, page);
        });

        $('.condition-check').change(function() {
            conditionsArray = [];
            $('.condition-check').each(function() {
                var sThisVal = (this.checked ? $(this).val() : "");
                if (sThisVal != '')
                    conditionsArray.push(sThisVal);
            });
            page = 1;
            createPagination(totalPages, page);
        });

        $('.brand-check').change(function() {
            brandsArray = [];
            $('.brand-check').each(function() {
                var sThisVal = (this.checked ? $(this).val() : "");
                if (sThisVal != '')
                    brandsArray.push(sThisVal);
            });
            page = 1;
            createPagination(totalPages, page);
        });

        $('.fuel-type-check').change(function() {
            fueltypesArray = [];
            $('.fuel-type-check').each(function() {
                var sThisVal = (this.checked ? $(this).val() : "");
                if (sThisVal != '')
                    fueltypesArray.push(sThisVal);
            });
            page = 1;
            createPagination(totalPages, page);
        });

        $('.color-check').change(function() {
            colorsArray = [];
            $('.color-check').each(function() {
                var sThisVal = (this.checked ? $(this).val() : "");
                if (sThisVal != '')
                    colorsArray.push(sThisVal);
            });
            page = 1;
            createPagination(totalPages, page);
        });

        $('.transmission-check').change(function() {
            transmissionArray = [];
            $('.transmission-check').each(function() {
                var sThisVal = (this.checked ? $(this).val() : "");
                if (sThisVal != '')
                    transmissionArray.push(sThisVal);
            });
            page = 1;
            createPagination(totalPages, page);
        });

        $(".price-apply-btn").on('click', function() {
            var min_price = $(".minprice").val();
            var max_price = $(".maxprice").val();
            // priceArray.push(min_price, max_price);
            priceArray[0] = min_price;
            priceArray[1] = max_price;
            page = 1;
            createPagination(totalPages, page);
        });

        $(".mile-apply-btn").on('click', function() {
            mileArray = [];
            var min_mile = $("#min_mile").val();
            var max_mile = $("#max_mile").val();
            mileArray.push(min_mile, max_mile);
            page = 1;
            createPagination(totalPages, page);
        });

        $(".carname-btn").on('click', function() {
            mileArray = [];
            carname = $("#carname").val();
            page = 1;
            createPagination(totalPages, page);
        });
    </script>

    {{-- Pagination --}}
    <script>
        const element = document.querySelector(".pagination ul");
        totalPages = parseInt($('#totalPages').val()) + 1;

        //calling function with passing parameters and adding inside element which is ul tag
        element.innerHTML = createPagination(totalPages, page);

        async function createPagination(totalPages, page) {
            await getApiData(page);
            console.log(totalPages);

            if (totalPages == 0) {
                element.innerHTML = "";
                return;
            }
            let liTag = '';
            let active;
            let beforePage = page - 1;
            let afterPage = page + 1;

            if (page > 1) { //show the next button if the page value is greater than 1
                liTag +=
                    `<li class="btn prev" onclick="createPagination(totalPages, ${page - 1})"><span><i class="fas fa-angle-left"></i> Prev</span></li>`;
            }

            if (page > 2) { //if page value is less than 2 then add 1 after the previous button
                liTag += `<li class="first numb" onclick="createPagination(totalPages, 1)"><span>1</span></li>`;
                if (page > 3) { //if page value is greater than 3 then add this (...) after the first li or page
                    liTag += `<li class="dots"><span>...</span></li>`;
                }
            }

            // how many pages or li show before the current li
            if (page == totalPages) {
                beforePage = beforePage - 2;
            } else if (page == totalPages - 1) {
                beforePage = beforePage - 1;
            }
            // how many pages or li show after the current li
            if (page == 1) {
                afterPage = afterPage + 2;
            } else if (page == 2) {
                afterPage = afterPage + 1;
            }

            for (var plength = beforePage; plength <= afterPage; plength++) {
                if (plength > totalPages) { //if plength is greater than totalPage length then continue
                    continue;
                }
                if (plength == 0) { //if plength is 0 than add +1 in plength value
                    plength = plength + 1;
                }
                if (page == plength) { //if page is equal to plength than assign active string in the active variable
                    active = "active";
                } else { //else leave empty to the active variable
                    active = "";
                }
                liTag +=
                    `<li class="numb ${active}" onclick="createPagination(totalPages, ${plength})"><span>${plength}</span></li>`;
            }

            if (page < totalPages -
                1) { //if page value is less than totalPage value by -1 then show the last li or page
                if (page < totalPages -
                    2
                ) { //if page value is less than totalPage value by -2 then add this (...) before the last li or page
                    liTag += `<li class="dots"><span>...</span></li>`;
                }
                liTag +=
                    `<li class="last numb" onclick="createPagination(totalPages, ${totalPages})"><span>${totalPages}</span></li>`;
            }

            if (page < totalPages) { //show the next button if the page value is less than totalPage(20)
                liTag +=
                    `<li class="btn next" onclick="createPagination(totalPages, ${page + 1})"><span>Next <i class="fas fa-angle-right"></i></span></li>`;
            }

            if (totalPages == 1) {
                liTag = '<li class=" numb active " onclick="createPagination(totalPages, 1) "><span>1</span></li>';
            }
            element.innerHTML = liTag; //add li tag inside ul tag
            return liTag; //reurn the li tag
        }


        function updatePagination(totalPage, page) {
            if (totalPage == 0) {
                element.innerHTML = "";
                return;
            }
            let liTag = '';
            let active;
            let beforePage = page - 1;
            let afterPage = page + 1;
            if (page > 1) { //show the next button if the page value is greater than 1
                liTag +=
                    `<li class="btn prev" onclick="createPagination(totalPages, ${page - 1})"><span><i class="fas fa-angle-left"></i> Prev</span></li>`;
            }

            if (page > 2) { //if page value is less than 2 then add 1 after the previous button
                liTag += `<li class="first numb" onclick="createPagination(totalPages, 1)"><span>1</span></li>`;
                if (page > 3) { //if page value is greater than 3 then add this (...) after the first li or page
                    liTag += `<li class="dots"><span>...</span></li>`;
                }
            }

            // how many pages or li show before the current li
            if (page == totalPages) {
                beforePage = beforePage - 2;
            } else if (page == totalPages - 1) {
                beforePage = beforePage - 1;
            }
            // how many pages or li show after the current li
            if (page == 1) {
                afterPage = afterPage + 2;
            } else if (page == 2) {
                afterPage = afterPage + 1;
            }

            for (var plength = beforePage; plength <= afterPage; plength++) {
                if (plength > totalPages) { //if plength is greater than totalPage length then continue
                    continue;
                }
                if (plength == 0) { //if plength is 0 than add +1 in plength value
                    plength = plength + 1;
                }
                if (page == plength) { //if page is equal to plength than assign active string in the active variable
                    active = "active";
                } else { //else leave empty to the active variable
                    active = "";
                }
                liTag +=
                    `<li class="numb ${active}" onclick="createPagination(totalPages, ${plength})"><span>${plength}</span></li>`;
            }

            if (page < totalPages - 1) { //if page value is less than totalPage value by -1 then show the last li or page
                if (page < totalPages -
                    2) { //if page value is less than totalPage value by -2 then add this (...) before the last li or page
                    liTag += `<li class="dots"><span>...</span></li>`;
                }
                liTag +=
                    `<li class="last numb" onclick="createPagination(totalPages, ${totalPages})"><span>${totalPages}</span></li>`;
            }

            if (page < totalPages) { //show the next button if the page value is less than totalPage(20)
                liTag +=
                    `<li class="btn next" onclick="createPagination(totalPages, ${page + 1})"><span>Next <i class="fas fa-angle-right"></i></span></li>`;
            }
            if (totalPages == 1) {
                liTag = '<li class=" numb active " onclick="createPagination(totalPages, 1) "><span>1</span></li>';
            }
            element.innerHTML = liTag; //add li tag inside ul tag
            return liTag; //reurn the li tag
        }

        var searchCarName = <?php echo $brandNames; ?>;
        
        $(function() {
            $("#carname").autocomplete({
                source: searchCarName
            });
        });
    </script>
@endsection
