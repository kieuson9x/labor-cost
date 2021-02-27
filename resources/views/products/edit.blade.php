@extends('base')
@section('main')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-3">Cập nhật sản phẩm</h1>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br />
        @endif
        <form method="post" action="{{ route('products.update', ['id' => $product->id]) }}">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="product_code">Mã sản phẩm</label>
                <input type="text" class="form-control" name="product_code" length={255}
                    value="{{ $product->product_code }}" />
            </div>

            <div class="form-group">
                <label for="name">Tên sản phẩm</label>
                <input type="text" class="form-control" name="name" length={255}
                    value="{{ $product->name }}" />
            </div>

            <div class="form-group">
                <label for="rate">Hệ số</label>

                <input type="text" class="form-control" name="rate" length={10}
                value="{{ $product->rate }}" />
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a class="btn btn-default"  href="{{ route('products.index') }}">Trở lại</a>
        </form>
    </div>
</div>
@endsection