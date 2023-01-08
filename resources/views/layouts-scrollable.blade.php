@extends('layouts.master')

@section('title') @lang('translation.Scrollable') @endsection

@section('body')
    <body data-sidebar="dark" data-layout-scrollable="true">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Layouts @endslot
        @slot('title') Scrollable @endslot
    @endcomponent
@endsection

@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <!-- dashboard init -->
    <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
@endsection
