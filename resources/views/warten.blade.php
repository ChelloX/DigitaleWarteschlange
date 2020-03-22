@extends('layouts.warten')

@section('content')
    <div class="container-fluid text-center justify-content-center" style="max-width:500px">
        <h2>{{$queue->name}}</h2>
        <h3>{{$queue->info}}</h3>
        <p>Die Warteschlange schließt am {{ date('d.m.Y H:i', strtotime($queue->close_time)) }} Uhr</p>


            <div class="row">

                <div class="col" style="background-color:#009fe3; color: white;"><h4 style="margin: 0.5em;margin-bottom: 0em;">An der Reihe ist:</h4></div>
            </div>
            <div class="row text-center">
                <div class="col" style="background-color:#009fe3; color: white;"><h4 style="margin: 0.5em;"><b>{{$queue->current_user}}</b></h4></div>
            </div>
            <div class="row">

                <div class="col" style="background-color:#e0dfd1;"><h4 style="margin: 0.5em;margin-bottom: 0em;">Du bist an der Stelle:</h4></div>
            </div>
            <div class="row">
                <div class="col" style="background-color:#e0dfd1;"><h4 style="margin: 0.5em;"><b>{{$queueUser->wartenummer}}</b></h4></div>
            </div>


        <p>Es sind noch {{$queueUser->wartenummer-$queue->current_user}} Personen vor Ihnen an der Reihe. Das entspricht ca. 38min.</p>

        <form action="{{route('warten')}}" method="get">
            @csrf
            <button name="refresh" type="submit" class="btn btn-outline-info">aktualisieren</button>
        </form>

        <p>Zeige Sie Herz und geben Sie älteren und schwachen Mitbürgern den Vortritt! Sie sind ein Held in der Not!</p>

        <form action="{{route('editWarten')}}" method="post">
            @csrf
            <button value="{{$queueUser->id}}" name="cancelButton" type="submit" class="btn btn-outline-danger">austragen</button>
        </form>
    </div>
@endsection
