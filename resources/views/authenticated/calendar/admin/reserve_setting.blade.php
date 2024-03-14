@extends('layouts.sidebar')
@section('content')
    {{-- <div class="w-100 vh-100 d-flex" style="align-items:center; justify-content:center;">
        <div class="w-100 vh-100 border p-5"> --}}
    <div class="vh-100 pt-5 bottom_5" style="background:#ECF1F6;">
        <div class="border w-75 m-auto"
            style=" box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2); border-radius: 15px; padding: 20px; background:#FFF;">
            <p class="text-center" style="font-size: 18px; font-weight: bold;">{{ $calendar->getTitle() }}
            </p>
            {!! $calendar->render() !!}
            <div class="adjust-table-btn m-auto text-right">
                <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting"
                    onclick="return confirm('登録してよろしいですか？')" style="margin-top: 20px">
            </div>
        </div>
    </div>
@endsection
