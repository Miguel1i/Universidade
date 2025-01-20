@extends('layouts.main')

@section('title', $medicamento->nome)

@section('content')
    <x-product-card :medicamento="$medicamento"/>
@endsection
