@extends('app')

@section('content')

    {{--@include('sidebar')--}}
    <main role="main" class="pl-5 pt-4 pr-5">

        {{--<div class="input-group pb-3">--}}
            {{--<select name="category_id" class="custom-select" id="inputGroupSelect04">--}}
                {{--@foreach($categories as $category)--}}
                    {{--<option value="{{ $category->id }}">{{ $category->name }}</option>--}}
                {{--@endforeach--}}
            {{--</select>--}}
            {{--<div class="input-group-append">--}}
                {{--<button class="btn btn-outline-secondary" type="button">Select</button>--}}
            {{--</div>--}}
        {{--</div>--}}

        <div class="row pb-4">
            <div class="col-12 pb-2">
                <form method="GET" action="#" accept-charset="UTF-8" class="navbar-form" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control mr-2" name="search" placeholder="Поиск..." value="{{ request('search') }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Найти</button>
                        </span>
                    </div>
                </form>
            </div>
            @foreach($products as $product)
                <div class="col-sm-3 pl-3 pr-1 pb-4">
                    <div class="card" onmouseover="this.style.boxShadow='0 0 10px #fff';" onmouseout="this.style.boxShadow='none';" style="cursor: pointer;">
                        <div class="card-body">
                            <p class="card-text text-center"><img src="{{ $product->image }}" alt="{{ $product->name }}" class="product-image-list"></p>
                            <h3 class="card-title text-left">
                                <a href="{{ url('products/' . $product->id) }}">{{ $product->name }}</a>
                            </h3>
                            <span class="card-text small">{{ $product->description }}</span>
                            <p class="card-text alert alert-light text-right">{{ $product->price }} грн</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $products->links() }}
    </main>

@endsection