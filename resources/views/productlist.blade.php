@extends('layout.app')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Productbeheer</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('homepage') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Inventaris</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Productbeheer</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="ibox-content m-b-sm border-bottom">
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="col-form-label" for="status">Categorie</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" selected>Enabled</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="col-form-label" for="status">Subcategorie</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" selected>Enabled</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="col-form-label" for="status">Productgroup</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" selected>Enabled</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="col-form-label" for="product_name">Product naam</label>
                        <input type="text" id="product_name" name="product_name" value="" placeholder="Product Name" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="col-form-label" for="price">Prijs</label>
                        <input type="text" id="price" name="price" value="" placeholder="Price" class="form-control">
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label class="col-form-label" for="status">Filter</label>
                        <div class="">
                            <div class="btn btn-primary">Filter</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($products as $product)
                @include('cards.product')
            @endforeach
        </div>
    </div>
@endsection