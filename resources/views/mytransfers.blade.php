@extends('layouts.app')

@section('content')
    <h1>MY TRANSFERS</h1>
    <nav class="navbar navbar-expand-md bg-white shadow-sm">
        <a class="navbar-brand" href="{{ url('/dashboard') }}">
            My accounts
    </nav>
    @if (count($transfers) > 0)
        <table class="table">
            <thead>
            <tr>
                <th>Transfer No</th>
                <th>Payer account</th>
                <th>Recipient account</th>
                <th>Amount</th>
                <th>Transfer date</th>
            </tr>
            </thead>
            <tbody>
        @foreach($transfers as $transfer)
            <tr>
                <td>{{$transfer->transfer_no}}</td>
                <td>{{$transfer->payer_account_no}}</td>
                <td>{{$transfer->recipient_account_no}}</td>
                <td>{{$transfer->amount}}</td>
                <td>{{$transfer->created_at}}</td>
            </tr>
        @endforeach
            </tbody>
        </table>

    @endif
@endsection


