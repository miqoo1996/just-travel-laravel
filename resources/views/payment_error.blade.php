@extends('layouts.regular_nf')
@section('content')
<div class="greybg tour-details">
    <br>
    <br>
    <br>
    <h1 class="alert alert-danger text-center">{{isset($response['content']['errorMessage']) ? $response['content']['errorMessage'] : 'Error'}}</h1>
</div>
@endsection
