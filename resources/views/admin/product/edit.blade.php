@extends('layouts.admin_master')
@section('admin-content')
@section('products')
    active show-sub
@endsection
@section('manage-product')
    active
@endsection

<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('admin.dashboard') }}">LazyChat</a>
        <span class="breadcrumb-item active">Update Product</span>
    </nav>

    <div class="sl-pagebody">
        <div class="card pd-20 pd-sm-40">
            <h6 class="card-body-title">Update product</h6>
            <form action="{{ route('update-product-data') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="row row-sm">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Select Category: <span
                                    class="tx-danger">*</span></label>
                            <select class="form-control select2-show-search" data-placeholder="Select One"
                                name="category_id">
                                <option label="Choose one"></option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ $cat->id == $product->category_id ? 'selected' : '' }}>
                                        {{ ucwords($cat->title) }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Select Sub-Category: <span
                                    class="tx-danger">*</span></label>
                            <select class="form-control select2-show-search" data-placeholder="Select One"
                                name="subcategory_id">
                                <option label="Choose one"></option>
                                @foreach ($subcategories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ $cat->id == $product->subcategory_id ? 'selected' : '' }}>
                                        {{ ucwords($cat->title) }}</option>
                                @endforeach
                            </select>
                            @error('subcategory_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Product Title: <span
                                    class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="title" value="{{ $product->title }}"
                                placeholder="Enter Product Title">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Product Price: <span
                                    class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="price" value="{{ $product->price }}"
                                placeholder="Product Price">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-control-label">Description: <span class="tx-danger">*</span></label>
                            <textarea name="description" id="summernote3">{{ $product->description }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-layout-footer mt-3">
                    <button class="btn btn-info mg-r-5" type="submit" style="cursor: pointer;">Update Product</button>
                </div><!-- form-layout-footer -->
            </form>

            <form action="{{ route('update-product-thumbnail') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="old_img" value="{{ $product->thumbnail }}">
                <br>
                <h4>Update Product Thumbnail</h4>
                <div class="row row-sm" style="margin-top:30px;">
                    <div class="col-md-3">
                        <div class="card">
                            <img class="card-img-top" src="{{ asset($product->thumbnail) }}" alt="Card image cap"
                                style="height: 150px; width:150px;">
                            <div class="card-body">
                                <p class="card-text">
                                <div class="form-group">
                                    <label class="form-control-label">Change Image<span
                                            class="tx-danger">*</span></label>
                                    <input class="form-control" type="file" name="thumbnail"
                                        onchange="mainThumbUrl(this)">
                                </div>
                                <img src="" id="mainThumb">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-layout-footer">
                    <button type="submit" style="cursor: pointer" class="btn btn-info">Update Thumbnail</button>
                </div><!-- form-layout-footer -->
            </form>

        </div><!-- row -->
    </div>

    <script src="{{ asset('backend') }}/lib/jquery-2.2.4.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="category_id"]').on('change', function() {
                var category_id = $(this).val();
                if (category_id) {
                    $.ajax({
                        url: "{{ url('/admin/subcategory/ajax') }}/" + category_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="subcategory_id"]').empty();
                            $.each(data, function(key, value) {

                                $('select[name="subcategory_id"]').append(
                                    '<option value="' + value.id + '">' + value
                                    .title + '</option>');

                            });

                        },

                    });
                } else {
                    alert('danger');
                }

            });
        });
    </script>

    <script>
        function mainThumbUrl(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#mainThumb').attr('src', e.target.result).width(80)
                        .height(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

@endsection
