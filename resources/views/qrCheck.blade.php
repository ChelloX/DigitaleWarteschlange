@extends('layouts.user')
@section('content')

    <div align="center">

        <br>
        <br>
        <br>
        <br>
        <br>

        Wollen Sie sich in der Warteschlange {{$poi->name}} anmelden?

        <br>
        <br>

        <form action="{{route('postQueueUser')}}" method="POST">
            @csrf
            <button name="applyBtn" type="submit" class="btn btn-dark" value="{{$queue->uuid}}">
                Einreihen
            </button>
        </form>

    </div>
@endsection
