@extends('layouts.main')
@section('content')

    <div class="container mx-auto p-6">
        <h1>ChartMander - Heat Map</h1>
    </div>
    <div class="container mx-auto p-6 bg-slate-100 rounded-md">
        <livewire:heat-map></livewire:heat-map>
    </div>

@endsection
