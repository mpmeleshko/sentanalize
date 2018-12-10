@extends('app')

@section('content')

    <main role="main" class="pl-5 pt-4 pr-5">

        <div class="card">
            <div class="card-body row mt-2  mb-4">
                <div class="col-sm-4">
                    <p class="card-text image-show"><img src="{{ $product->image }}" alt="{{ $product->name }}" class="image-show"></p>
                </div>
                <div class="col-sm-8">
                    <h1 class="card-title cast-text-right pb-4">
                        {{ $product->name }}
                    </h1>
                    {{--<span class="card-text small">{{ $product->description }}</span>--}}
                    <ul class="card-text cast-text-right">
                        @foreach($product->note as $note)
                            <li>{{ $note }}</li>
                        @endforeach
                    </ul>
                    <h4 class="card-text pt-2">Цена: {{ $product->price }} грн</h4>
                </div>

            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body row">
                <div class="col-sm-6">
                    <h3>Отзывы</h3>
                    @foreach($product->reviews as $review)
                        <p class="card-title pt-2">{{ $review->author }}<span class="card-text alert alert-light text-right">{{ $review->date }}</span></p>
                        <p class="card-text">{{ $review->review }}</p>
                        <p class="card-text">{{ $review->quality ?? '' }}</p>
                        <p class="card-text pb-1">{{ $review->defect ?? '' }}</p>
                        <hr>
                    @endforeach
                </div>
                <div class="col-sm-6">
                    {!! $chartDonut->html() !!}
                </div>
            </div>
        </div>
    </main>

@endsection

@section('script')
    {!! Charts::scripts() !!}
    {!! $chartDonut->script() !!}
@endsection