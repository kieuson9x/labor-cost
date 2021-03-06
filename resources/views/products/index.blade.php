@extends('base')

@section('main')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="p-4 border-bottom bg-light">
                <h4 class="card-title mb-0">Sản phẩm</h4>
            </div>
            <div class="card-body">
                <a href="{{ route('products.create')}}" class="btn btn-outline-primary mb-2">Tạo sản phẩm mới</a>

                <table class="table table-striped" id="table_products">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Mã sản phẩm</td>
                            <td>Tên sản phẩm</td>
                            {{-- <td>Mã yếu tố chi phí</td>
                            <td>Tên yếu tố</td> --}}
                            <td>Hệ số</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->product_code}}</td>
                            <td>{{$product->name}}
                            <td>{{$product->rate}}</td>
                            <td>
                                <a href="{{ route('products.edit',['id' => $product->id])}}"
                                    class="btn btn-primary">Sửa</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customScript')
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
    jQuery(document).ready(function () {
        $('#table_products').DataTable({
            responsive: true,
        });
    });

</script>
@endSection
