@extends('layouts.main')
@section('content')

    <div class="container mx-auto p-6">
        <h1>ChartMander - Column Chart</h1>
    </div>
    <div class="container mx-auto p-6 bg-slate-100 rounded-md">
        <livewire:column-chart></livewire:column-chart>
    </div>

@endsection
