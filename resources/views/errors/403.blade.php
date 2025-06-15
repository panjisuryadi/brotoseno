@extends('errors.illustrated-layout')

@section('code', '403 🤐')

@section('title', __('Unauthorized'))

@section('image')
    <div style="background-image: url({{ asset('images/bg.jpg') }});" class="absolute pin bg-no-repeat md:bg-left lg:bg-center bg-cover"></div>
@endsection

@section('message', __('Maaf, Anda tidak diperbolehkan mengakses Module ini...'))
