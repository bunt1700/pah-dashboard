@extends('layout.app')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Categorie-beheer</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('homepage') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Inventaris</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Categorie&euml;n</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight ecommerce">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                            <thead>
                                <tr>
                                    <th data-toggle="true">Categorienaam</th>
                                    {{--<th data-hide="phone,tablet">Aantal productgroepen</th>--}}
                                    {{--<th data-hide="phone">Aantal producten</th>--}}

                                    <th class="text-right" data-sort-ignore="true">Acties</th>
                                </tr>
                            </thead>
                            @foreach($categories as $category)
                                <tbody>
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        {{--<td>&nbsp;</td>--}}
                                        {{--<td>&nbsp;</td>--}}
                                        <td class="text-right">
                                            <div class="btn-group">
                                                <a href="{{ route('categorization.form', [$category]) }}" class="btn-white btn btn-xs">
                                                    Bewerken
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection