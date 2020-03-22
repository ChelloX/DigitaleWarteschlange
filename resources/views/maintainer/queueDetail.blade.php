@extends('layouts.maintainer')

@section('content')

    <div class="card d-flex flex-column justify-content-center mx-auto" style="width: 80%;">
        <div class="card-header">
            <h2 class="text-center">Warteschlange {{$queue->name}}</h2>
        </div>

        <ul class="list-group list-group-flush">
            <li class="list-group-item">{{$queue->info}}</li>
            <li class="list-group-item"><h2>Aktuell wartende Personen: {{$queue->current_user}} </h2></li>
            <li class="list-group-item">
                <form action="{{route('maintainer.skipUser')}}" method="post">
                    @csrf
                    <table class="table table-hover w-100">
                        <tr>
                            <th scope="col">#</th>
                            <th>Info</th>
                            <th class="text-right">#</th>
                        </tr>
                        @foreach($queueUsers as $queueUser)
                            <tr>
                                <td>{{$queueUser->wartenummer}}</td>
                                <td>{{$queueUser->info}}</td>
                                <td class="text-right">
                                    <button value="{{$queueUser->id}}" name="skipButton" type="submit"
                                            class="btn btn-outline-danger">Vorlassen
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </form>
            </li>

            <li class="list-group-item">
                <div class="container d-flex flex-row justify-content-between">

                        <form action="{{route('maintainer.queueDetail')}}" method="post">
                            @csrf
                            <button value="{{$queue->id}}" name="popButton" type="submit" class="btn btn-dark btn-lg">Nächster
                                Kunde
                            </button>
                        </form>
                        <form action="{{route('maintainer.editQueue')}}" method="post">
                            @csrf
                            <?php $status = 'pause';?>
                            @if($queue->status=='pause')
                                <?$status = 'aktiv';?>
                            @endif

                            @if($queue->status=='aktiv')
                                <?php $status = 'pause';?>
                            @endif

                            <input type="hidden" name="queue_id" id="queue_id" placeholder="queue_id" class="form-control"
                                   value="{{$queue->id}}">
                            <button value="<?php echo $status ?>" name="status" type="submit"
                                    class="btn btn-lg btn-danger"><?php echo $status ?></button>
                        </form>
                        <a class="btn btn-primary btn-lg" href="/info/{{$queue->uuid}}" role="button">QR-Code</a>
                    </div>

            </li>

            <li class="list-group-item">
                <form action="{{route('maintainer.editQueue')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Info für Kunden</label>
                        <input type="text" name="info" id="info" placeholder="info" class="form-control">
                        <input type="hidden" name="queue_id" id="queue_id" placeholder="queue_id" class="form-control"
                               value="{{$queue->id}}">
                    </div>
                    <button type="submit" class="btn btn-dark">Submit</button>
                </form>
                <form action="{{route('maintainer.editQueue')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Warteschlangenende</label>
                        <input type="datetime-local" name="close_time" id="close_time" placeholder="close_time"
                               class="form-control">
                        <input type="hidden" name="queue_id" id="queue_id" placeholder="queue_id" class="form-control"
                               value="{{$queue->id}}">
                    </div>
                    <button type="submit" class="btn btn-dark">Submit</button>
                </form>
            </li>
        </ul>
    </div>


@endsection
