@extends('app')

@section('content')

    <main role="main" class="pl-5 pt-4 pr-5">

        <div class="input-group pb-3">
            <select name="category_id" class="custom-select" id="inputGroupSelect04">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button">Select</button>
            </div>
        </div>

        <div class="row pt-2 pb-4">
            @foreach($products as $product)
                <div class="col-sm-3 pl-3 pr-1 pb-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text text-center"><img src="{{ $product->image }}" alt="{{ $product->name }}" class="product-image-list"></p>
                            <h3 class="card-title text-left">
                                {{ $product->name }}
                            </h3>
                            <span class="card-text small">{{ $product->description }}</span>
                            <p class="card-text alert alert-light text-right">{{ $product->price }} грн</p>
                            {{--<a href="" class="btn btn-primary btn-sm btn-block">View</a>--}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{--@foreach($products as $product)--}}

            {{--<div class="product-list">--}}
                {{--<div>--}}
                    {{--<img src="{{ $product->image }}" alt="{{ $product->name }}" class="product-image-list">--}}
                {{--</div>--}}
                {{--<div>--}}
                    {{--<h3>{{ $product->name }}</h3>--}}
                    {{--<p>{{ $product->description }}</p>--}}
                    {{--<ul>--}}
                        {{--@foreach($product->note as $note)--}}
                            {{--<li>{{ $note }}</li>--}}
                        {{--@endforeach--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}

        {{--@endforeach--}}

        {{ $products->links() }}
    </main>

@endsection