@extends('layouts.checkout')

@section('title', 'Checkout')

@section('content')
    <x-checkout-card :items="$items" :total="$total" />
@endsection


