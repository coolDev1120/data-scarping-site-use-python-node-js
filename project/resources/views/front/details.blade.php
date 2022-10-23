@extends('layouts.front')

@section('content')
	<!-- Breadcrumb Area Start -->
	<div class="breadcrumb-area">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<h1 class="pagetitle">
							{{ $detail->attributes->title }}
						</h1>
						<ul class="pages">
							<li>
								<a href="{{ route('front.index') }}">
									{{ $langg->lang1 }}
								</a>
							</li>
							<li class="active">
								<a href="#">
									{{ $detail->attributes->title }}
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Breadcrumb Area End -->

	<!-- Single Details Area Start -->
	<section class="single-details">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="model-gallery-image">
						<div class="one-item-slider">
							@foreach ($images as $image)
								<div class="item"><img src="{{ $image }}" alt=""></div>
							@endforeach
						</div>
						<ul class="all-item-slider">
							@foreach ($images as $image)
								<li><img src="{{ $image }}" alt=""></li>
							@endforeach
						</ul>
					</div>
					<div class="profile-area">
						<div class="profile-info">
							<div class="left">								
								<img src="{{asset('assets/user/blank.png')}}" alt="" style="border-radius: 50%;">							
							</div>
							<div class="right">
								<h4 class="title">
									{{ property_exists($detail->attributes, "agent_name") ? $detail->attributes->agent_name : '' }}									
								</h4>
								<ul class="profile-meta">
									<li>
										<p>
											<i class="fas fa-map-marker-alt"></i> 
											{{ property_exists($detail->attributes, "agent_locality") ? $detail->attributes->agent_locality : '' }}
										</p>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="product-details-tab">
						<div class="prouct-details-tab-menu">
							<ul class="nav" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="pills-productdetails-tab" data-toggle="pill" href="#pills-productdetails"
										role="tab" aria-controls="pills-productdetails" aria-selected="false">{{ $langg->lang60 }}</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
										aria-controls="pills-contact" aria-selected="false"> Finance Estimate </a>
								</li>
							</ul>
						</div>
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-productdetails" role="tabpanel"
								aria-labelledby="pills-productdetails-tab">
								<div class="content-product-details">
									{{ property_exists($detail->attributes, "description") ? $detail->attributes->description : '' }}
								</div>
							</div>
							<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
								<div class="content-product-details">
									{!! property_exists($detail->attributes, "finance_estimate") ? $detail->attributes->finance_estimate : '' !!}
								</div>									
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="details-info-area">
						<div class="heading">
							<h4 class="title">
								{{ $langg->lang46 }}
							</h4>
							<ul class="details-list">								
								<li>
									<p>Make:</p>
									<p>{{ property_exists($detail->attributes, "make") ? $detail->attributes->make : '' }}</p>
								</li>
								<li>
									<p>Model:</p>
									<p>{{ property_exists($detail->attributes, "model") ? $detail->attributes->model : '' }}</p>
								</li>
								<li>
									<p>Condition:</p>
									<p>{{ property_exists($detail->attributes, "condition") ? $detail->attributes->condition : '' }}</p>
								</li>
								<li>
									<p>New or Used:</p>
									<p>{{ property_exists($detail->attributes, "new_or_used") ? $detail->attributes->new_or_used : '' }}</p>
								</li>
								<li>
									<p>Price:</p>
									<p>R {{ property_exists($detail->attributes, "price") ? $detail->attributes->price : '' }}</p>
								</li>								
								<li>
									<p>Colour:</p>
									<p>{{ property_exists($detail->attributes, "colour") ? $detail->attributes->colour : '' }}</p>
								</li>														
								<li>
									<p>Fuel Type:</p>
									<p>{{ property_exists($detail->attributes, "fuel_type") ? $detail->attributes->fuel_type : '' }}</p>
								</li>								
								<li>
									<p>Mileage:</p>
									<p>{{ property_exists($detail->attributes, "mileage") ? $detail->attributes->mileage : '' }}</p>
								</li>								
								<li>
									<p>Province:</p>
									<p>{{ property_exists($detail->attributes, "province") ? $detail->attributes->province : '' }}</p>
								</li>
								<li>
									<p>Transmission:</p>
									<p>{{ property_exists($detail->attributes, "transmission") ? $detail->attributes->transmission : '' }}</p>
								</li>								
								<li>
									<p>Vehicle Axle Config:</p>
									<p>{{ property_exists($detail->attributes, "vehicle_axle_config") ? $detail->attributes->vehicle_axle_config : '' }}</p>
								</li>
								<li>
									<p>Year:</p>
									<p>{{ property_exists($detail->attributes, "year") ? $detail->attributes->year : '' }}</p>
								</li>
							</ul>
						</div>
					</div>					
				</div>
			</div>
		</div>
	</section>
	<!-- Single Details Area End -->
@endsection

@section('scripts')
<script type="text/javascript">
	var lat = {{ $car->user->latitude }};
	var long = {{ $car->user->longitude }};
	var address = "{{ $car->user->address }}";
	var mapicon = "{{ asset('assets/front/images/map-marker.png') }}";
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7eALQrRUekFNQX71IBNkxUXcz-ALS-MY&sensor=false"></script>
<script src="{{ asset('assets/front/js/map.js') }}"></script>
@endsection
