<html>
    <head>
        <title>Cars</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/cars.css">
    </head>
    <body>
        <h2>Cars list of autotrader</h2>

        <div class="container-body">
            <div class="filter">
                <h4 id="numbercars">Number of cars: {{ $cars->total() }}</h4>
                <form action="{{ route('cars') }}" method="GET">
                    <div class="heading">YEAR</div>
                    <div class="row">
                        <div class="form-group">
                            <input type="number" class="form-control" id="yearMin" name="yearMin" value="{{ request('yearMin') ?? 2020 }}">
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" id="yearMax" name="yearMax" value="{{ request('yearMax') ?? 2022 }}">
                        </div>
                    </div>
                    <div class="heading">PRICE</div>
                    <div class="row">
                        <div class="form-group">
                            <input type="number" class="form-control" id="priceMin" name="priceMin" step="1000" value="{{ request('priceMin') ?? 0 }}">
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" id="priceMax" name="priceMax" step="1000" value="{{ request('priceMax') ?? 1000000 }}">
                        </div>
                    </div>
                    <div class="heading">Mileage</div>
                    <div class="form-group">
                        <input type="number" class="form-control" id="mileage" name="mileage" step="1000" value="{{ request('mileage') ?? 5000 }}">
                    </div>
                    <div class="heading">Manual / automatic</div>
                    <div class="form-group">
                        <select class="form-control" id="transmission" name="transmission">
                            <option value="All" {{ request('transmission') == 'All' ? 'selected' : '' }}>All</option>
                            <option value="Manual" {{ request('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                            <option value="Automatic" {{ request('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
            
            <div class="container-card">
                <div class="cards">
                    @foreach($cars as $car)
                        <div class="card">
                            <a href="{{ 'https://www.autotrader.co.za'.$car['listingUrl'] }}">
                                <img class="card-img-top" src="{{ $car['imageUrl'] ?? 'https://www.phautobodysale.com/dealercenter/img/vehicle-image-notavailable-320x240.jpg' }}" alt="Card image">
                            </a>
                            <div class="card-body">
                                <h4 class="title">{{ $car['makeModelLongVariant'] ?? 'title not available' }}</h4>
                                <p class="price">{{ $car['price'] ?? ''}}</p>
                                <p class="little-text"><span class="used">{{ $car['newUsedDescription'] ?? ''}} </span> | {{ $car['summaryIcons'][1]['text'] ?? ''}} | {{ $car['summaryIcons'][2]['text'] ?? ''}} | {{ $car['registrationYear'] ?? ''}}</p>
                            </div>
                        </div>
                    @endforeach 
                </div>
            </div>
        </div>

        {{ $cars->links( "pagination::bootstrap-4") }}       
    </body>
</html>

