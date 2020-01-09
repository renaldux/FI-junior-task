@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>MY ACCOUNTS</h2>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <nav class="navbar navbar-expand-md bg-white shadow-sm">
                            <a class="navbar-brand" href="{{ route('newAccount') }}">
                                Create account
                            </a>
                            <a class="navbar-brand" href="{{ url('/transfer') }}">
                                New transfer
                            </a>
                            <a class="navbar-brand" href="{{ url('/mytransfers') }}">
                                My transfers
                            </a>
                        </nav>
                        @if ($accounts->count())
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Account number</th>
                                    <th>Account balance</th>
                                    <th>Created at</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($accounts as $account)
                                    <tr>
                                        <td>{{$account->id}}</td>
                                        <td>{{$account->account_no}}</td>
                                        <td>{{$account->balance}}</td>
                                        <td>{{$account->created_at}}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
