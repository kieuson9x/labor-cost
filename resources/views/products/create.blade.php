@extends('base')

@section('main')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-3">Thêm mới sản phẩm</h1>
        <div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
            @endif
            <form method="post" action="{{ route('products.store') }}">
                @csrf
                <div class="form-group">
                    <label for="product_code">Mã sản phẩm</label>
                    <input type="text" class="form-control" name="product_code" length={255} />
                </div>

                <div class="form-group">
                    <label for="name">Tên sản phẩm</label>
                    <input type="text" class="form-control" name="name" length={255} />
                </div>

                <div class="form-group">
                    <label for="rate">Hệ số</label>

                    <input type="text" class="form-control" name="rate" length={10} />
                </div>

                <button type="submit" class="btn btn-primary">Thêm</button>
                <a class="btn btn-default"  href="{{ route('products.index') }}">Trở lại</a>
            </form>
        </div>
    </div>
</div>
@endsection
