@extends('layouts.sidebar')
{{-- スクール予約 --}}

@section('content')
    <div class="vh-100 pt-5 bottom_5" style="background:#ECF1F6;">
        <div class="border w-75 m-auto pb-5"
            style=" box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2); border-radius: 15px; padding: 20px; background:#FFF;">
            <div class="w-60 m-auto" style="border-radius:5px;">

                <p class="text-center" style="font-size: 18px; font-weight: bold;">{{ $calendar->getTitle() }}</p>
                <div class="">
                    {!! $calendar->render() !!}
                </div>
            </div>
            <div class="text-right w- m70-auto" style="margin-top: 20px;">
                <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
            </div>
        </div>
    </div>

    {{-- キャンセルモーダル --}}
    {{-- CSSに記述あり --}}
    <div class="delete_modal modal">
        <div class="modal__bg modal_close"></div>
        <div class="modal__content">
            <form action="{{ route('deleteParts') }}" method="post">
                @csrf
                {{-- 表示用 --}}
                <div class="btn_modal">
                    <div class="reserve_date"></div>
                    <div class="reserve_part"></div>
                    <p>こちらの予約をキャンセルしますか？</p>
                    <div class="btn_area">
                        <a class="modal_close btn btn-primary" href="">戻る</a>
                        <input type="submit" class="m-auto btn btn-danger" href="/delete/calendar" value="キャンセル">
                    </div>
                </div>
                {{-- 送信用 --}}
                <input type="hidden" name="reserve_date" class="reserve_date" value="">
                <input type="hidden" name="reserve_part" class="reserve_part" value="">
            </form>
        </div>
    </div>

    {{-- @csrf From::open使えないため必須 --}}
    {{-- <input type="hidden" name="id" value="">
                <input type="hidden" name="reserve_date" value="">
                <input type="hidden" name="reserve_part" value="">
                <button type="submit" class="m-auto btn btn-danger">キャンセル</button>
                <button type="button" class="js-modal-close btn btn-primary">戻る</button>
            </form>
        </div>
    </div> --}}
@endsection
