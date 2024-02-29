@extends('layouts.sidebar')
{{-- 予約詳細 --}}

@section('content')
    <div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
        <div class="w-50 m-auto" style="height: 45%">
            <p><span style="font-size:18px; font-weight: bold;">{{ $date }}</span><span class="ml-3"
                    style="font-size:18px; font-weight: bold;">{{ $part }}部</span></p>
            <div class="reserve_users_container">
                <table class="reserve_users"
                    style=" box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2); border-radius: 15px; padding: 20px;">
                    <tr class="text-center" style="background-color: #03aad2; color: #FFF;">
                        <th class="w-35" style="height: 50px;">ID</th>
                        <th class="w-35" style="height: 50px;">名前</th>
                        <th class="w-35" style="height: 50px;">場所</th>
                    </tr>
                    {{-- Calendarcontrollerから$reservePersons --}}
                    @foreach ($reservePersons as $reservePerson)
                        @foreach ($reservePerson->users as $user)
                            <tr class="text-center">
                                <td class="w-35" style="height: 50px;">{{ $user->id }}</td>
                                <td class="w-35" style="height: 50px;">{{ $user->over_name . $user->under_name }}</td>
                                <td class="w-35" style="height: 50px;">リモート</td>
                                {{-- リモート以外ないけどこれでいい？ --}}
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
