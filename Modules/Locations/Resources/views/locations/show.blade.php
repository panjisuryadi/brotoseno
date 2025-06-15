@extends('layouts.app')

@section('title', 'location Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('locations.index') }}">locations</a></li>
        <li class="breadcrumb-item active">Details</li>
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
                                    <td>{{ $location->name }}</td>
                                </tr>


                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

