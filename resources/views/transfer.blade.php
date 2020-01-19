@extends('layouts.app')

@section('content')
    <h1>TRANSFER TO</h1>

    {!! Form::open(['url' => route('submitTransfer')]) !!}

    <div class="form-group">
        {{ Form::label('payerAccount', 'Payer account') }}
        <select name="payerAccount" class="form-control">
            @foreach($accounts as $account)
                <option value="{{ $account}}" >{{ $account}}</option>
            @endforeach
        </select>

    </div>
    <div class="form-group">
        {{Form::label('recipientAccount', 'Recipient account' )}}
        {{Form::text('recipientAccount', ' ', ['class'=>'form-control', 'placeholder' => 'enter recipient account'])}}
    </div>

    <div class="form-group">
        {{Form::label('amount', 'Amount')}}
        {{Form::text('amount', ' ', ['class'=>'form-control', 'placeholder' => 'amount, EUR'])}}
    </div>
    <div>
        {{Form::submit('TRANSFER', ['class' => 'btn btn-primary'])}}
    </div>
    {!! Form::close() !!}


@endsection




