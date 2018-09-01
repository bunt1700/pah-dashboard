@extends('layout.app')
@push('scripts')
    <script src="{{ asset('/js/custom/categorization.js') }}"></script>
@endpush
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Categorie-beheer</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('homepage') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    Inventaris
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('categorization') }}">Categorie&euml;n</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('categorization.form', [$activeCategory]) }}">
                        <strong>{{ $activeCategory }}</strong>
                    </a>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight ecommerce">
        <div class="ibox-content m-b-sm border-bottom">
			<h3>{{ $activeCategory }}</h3>
            <form method="POST" id="selection">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label class="col-form-label">Subcategorie</label>
                            @if($activeSubcategory)
                                <input value="{{ $activeSubcategory }}" readonly class="form-control">
                            @else
                                <select name="selected-subcategories" class="form-control">
                                    @foreach($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}">
                                            {{ $subcategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label class="col-form-label">Productgroep</label>
                            @if($activeProductgroup)
                                <input value="{{ $activeProductgroup }}" readonly class="form-control">
                            @else
                                <select name="selected-productgroups" class="form-control">
                                </select>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="col-form-label">&nbsp;</label>
                            <div>
                                @if($activeProductgroup)
                                    <a href="{{ route('categorization.form', [$activeCategory]) }}" class="btn btn-outline-secondary">
                                        Deselecteren
                                    </a>
                                @else
                                    <button class="btn btn-primary">
                                        Selecteren
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="ibox-content m-b-sm border-bottom">
			<h3>Productgroep overzetten</h3>
            <form method="POST" action="{{ route('categorization.submit', [$activeCategory]) }}" id="modifications">
                {{ csrf_field() }}
                @if($activeProductgroup)
                    <input type="hidden" name="selected-productgroups" value="{{ $activeProductgroup->id }}">
                @endif
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label class="col-form-label">Categorie</label>
                            @if($activeProductgroup)
                                <select name="new-categories" class="form-control">
                                    @foreach($categories as $category)
                                        @if($category->id == $activeCategory->id)
                                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                        @else
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            @else
                                <input disabled class="form-control">
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label class="col-form-label">Subcategorie</label>
                            @if($activeProductgroup)
                                <select name="new-subcategories" class="form-control">
                                </select>
                            @else
                                <input disabled class="form-control">
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="col-form-label">&nbsp;</label>
                            <div>
                                <button class="btn btn-primary"@if(!$activeProductgroup) disabled @endif>
                                    Verplaatsen
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="ibox-content m-b-sm border-bottom">
            <h3>Productgroep samenvoegen</h3>
            <form method="POST" action="{{ route('categorization.submit', [$activeCategory]) }}" id="merging">
                {{ csrf_field() }}
                @if($activeProductgroup)
                    <input type="hidden" name="selected-productgroups" value="{{ $activeProductgroup->id }}">
                @endif
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label class="col-form-label">Productgroep</label>
                            @isset($productgroups)
                                <select name="combined-productgroups" class="form-control">
                                    @foreach($productgroups as $productgroup)
                                        @if($productgroup->id == $activeProductgroup->id)
                                            <option value="{{ $productgroup->id }}" disabled>
                                                {{ $productgroup->name }}
                                            </option>
                                        @else
                                            <option value="{{ $productgroup->id }}">
                                                {{ $productgroup->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            @else
                                <input disabled class="form-control">
                            @endisset
                        </div>
                    </div>
                    <div class="col-sm-5">&nbsp;</div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="col-form-label">&nbsp;</label>
                            <div>
                                <button class="btn btn-primary"@if(!$activeProductgroup) disabled @endif>
                                    Samenvoegen
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection