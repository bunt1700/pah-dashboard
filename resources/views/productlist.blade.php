@extends('layout.app')
@push('scripts')
    <script src="{{ asset('/js/custom/productlist.js') }}"></script>
@endpush
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
                    <strong>Producten</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox-content m-b-sm border-bottom">
            <form method="POST" id="filters">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="col-form-label">Categorie</label>
                            <select name="filter-categories" class="form-control">
                                <option value="">Categorie&hellip;</option>
                                @isset($categories)
                                    @foreach($categories as $category)
                                        @if($category->id == $activeCategory->id)
                                            <option value="{{ $category->id }}" selected="selected">
                                                {{ $category->name }}
                                            </option>
                                        @else
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="col-form-label">Subcategorie</label>
                            <select name="filter-subcategories" class="form-control">
                                <option value="">Subcategorie&hellip;</option>
                                @isset($subcategories)
                                    @foreach($subcategories as $subcategory)
                                        @if($subcategory->id == $activeSubcategory->id)
                                            <option value="{{ $subcategory->id }}" selected="selected">
                                                {{ $subcategory->name }}
                                            </option>
                                        @else
                                            <option value="{{ $subcategory->id }}">
                                                {{ $subcategory->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="col-form-label">Productgroup</label>
                            <select name="filter-productgroups"class="form-control">
                                <option value="">Productgroep&hellip;</option>
                                @isset($productgroups)
                                    @foreach($productgroups as $productgroup)
                                        @if($productgroup->id == $activeProductgroup->id)
                                            <option value="{{ $productgroup->id }}" selected="selected">
                                                {{ $productgroup->name }}
                                            </option>
                                        @else
                                            <option value="{{ $productgroup->id }}">
                                                {{ $productgroup->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="col-form-label">Product naam</label>
                            <div>
                                <input name="filter-productname" value="{{ $search }}" placeholder="Zoekterm" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label class="col-form-label">&nbsp;</label>
                            <button class="btn btn-primary" name="filter-submit" value="search">Zoeken</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            @foreach ($products as $product)
                @include('cards.product')
            @endforeach
        </div>
    </div>
@endsection