@extends('layouts.blank')
@section('title', 'Carrinho')

@section('content')
    <x-cart-card :items="$items" :total="$total" />
@endsection
