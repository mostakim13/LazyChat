@extends('layouts.admin_master')
@section('admin-content')
@section('products')
    active show-sub
@endsection
@section('add-product')
    active
@endsection

<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="index.html">LazyChat</a>
        <span class="breadcrumb-item active">Add Product</span>
    </nav>

    <div class="sl-pagebody">
        <div class="card pd-20 pd-sm-40">
            <h6 class="card-body-title">Add product</h6>
            <form action="{{ route('store-product') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row row-sm">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">Select Category: <span
                                    class="tx-danger">*</span></label>
                            <select class="form-control select2-show-search" data-placeholder="Select One"
                                name="category_id">
                                <option label="Choose one"></option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ ucwords($cat->title) }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">Select Sub-Category: <span
                                    class="tx-danger">*</span></label>
                            <select class="form-control select2-show-search" data-placeholder="Select One"
                                name="subcategory_id">
                                <option label="Choose one"></option>
                                {{-- @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ ucwords($cat->title) }}</option>
                                @endforeach --}}
                            </select>
                            @error('subcategory_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">Product Title: <span
                                    class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="title" value="{{ old('title') }}"
                                placeholder="Enter Product Title">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">Product Price: <span
                                    class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="price" value="{{ old('price') }}"
                                placeholder="Product Price">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">Product Thambnail: <span
                                    class="tx-danger">*</span></label>
                            <input class="form-control" type="file" name="thumbnail" value="{{ old('thumbnail') }}"
                                onchange="mainThumbUrl(this)">
                            @error('thumbnail')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <img src="" id="thumbnail">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-control-label">Description: <span class="tx-danger">*</span></label>
                            <textarea name="description" id="summernote3"></textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-layout-footer mt-3">
                        <button class="btn btn-info mg-r-5" type="submit" style="cursor: pointer;">Add
                            Products</button>
                    </div><!-- form-layout-footer -->
            </form>
        </div>
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
                $('#thumbnail').attr('src', e.target.result).width(80)
                    .height(80);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


@endsection
