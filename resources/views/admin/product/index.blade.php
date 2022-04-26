@extends('layouts.admin_master')
@section('products')
    active show-sub
@endsection
@section('manage-product')
    active
@endsection
@section('admin-content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{ route('admin.dashboard') }}">LazyChat</a>
            <span class="breadcrumb-item active">Products</span>
        </nav>

        <div class="sl-pagebody">
            <div class="row row-sm">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Product List</div>
                        <div class="card-body">
                            <form class="form-control float-end " action="{{ url('admin/search') }}">
                                <div class="input-group mb-3 w-25">
                                    <input class=" form-control" type="search" name="query">
                                    <button class="btn" type="submit">Search</button>
                                </div>
                            </form>

                            {{-- <input id="myInput" onkeyup="myFunction()" type="text" class="form-control"
                                    placeholder="Search Book!" aria-label="Recipient's username"
                                    aria-describedby="button-addon2"> --}}
                            {{-- <button onclick="searchBook()" class="btn btn-primary text-dark " type="button"
                                    id="button-search">Search</button> --}}

                            <div class="table-wrapper">
                                <table class="table display responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product Title</th>
                                            <th>Product Price</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($products as $item)
                                            <tr>
                                                <td>
                                                    <img src="{{ asset($item->thumbnail) }}" alt="product thumbnail"
                                                        style="height: 60px; width: 60px;">
                                                </td>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td>{!! $item->description !!}</td>
                                                <td>{{ $item->category->title }}</td>
                                                <td>{{ $item->subcategory->title }}</td>
                                                <td>
                                                    <a href="{{ url('admin/product-edit/' . $item->id) }}"
                                                        class="btn btn-info btn-sm" title="edit data"><i
                                                            class="fa fa-pencil"></i></a>

                                                    <a href="{{ url('admin/product-delete/' . $item->id) }}"
                                                        class="btn btn-sm btn-danger" id="delete" title="delete data"><i
                                                            class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div><!-- table-wrapper -->
                        </div>
                    </div><!-- card -->
                </div>
            </div>
        </div>
    </div>
@endsection
