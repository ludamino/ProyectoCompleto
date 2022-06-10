@extends('errors::illustrated-layout')

@section('code', '403 🚫')

@section('title', __('No tienes permiso'))

@section('image')

<div style="background-image: url('https://proyectostics.com/wp-content/uploads/2022/03/alberta-ga5170c449_1920.jpg');" class="absolute pin bg-no-repeat md:bg-left lg:bg-center">
</div>

@endsection

@section('message', __('No tienes permiso para ver esta pagina'))