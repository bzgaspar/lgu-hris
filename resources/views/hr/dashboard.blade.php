@extends('layouts.app')

@section('customCSS')
    <link href="{{ asset('storage/css/circle-graph.css') }}" rel="stylesheet">
@endsection
@section('title', 'Employees')
@section('content')
    <dashboard-employee></dashboard-employee>

@endsection
