@extends('layouts.sidebar')
{{-- たぶん予約確認ページ --}}

@section('content')
    {{-- <div class="w-75 m-auto">
        <div class="w-100"> --}}
    <div class="vh-60 pt-2" style="background:#ECF1F6;">
        <div class="border w-75 m-auto"
            style=" box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2); border-radius: 15px; padding: 20px; background:#FFF;">
            <p style="text-align: center; font-size: 18px; font-weight: bold;">{{ $calendar->getTitle() }}</p>
            <p>{!! $calendar->render() !!}</p>
        </div>
    </div>
@endsection
