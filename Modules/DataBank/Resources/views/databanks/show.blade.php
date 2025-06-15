@extends('layouts.app')

@section('title', ''.$module_title.' Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
         <li class="breadcrumb-item"><a href="{{ route("databank.index") }}">{{$module_title}}</a></li>
        <li class="breadcrumb-item active">{{$module_action}}</li>
    </ol>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th> Name</th>
                                    <td>{{ @$detail->name }}</td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

