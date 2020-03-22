@extends('layouts.user')
@section('content')
    <div class="container d-flex align-content-center flex-column justify-content-between mt-lg-5">
        @if($userQueues != null)
            <h2 class="text-center pb-5">Ihre aktuellen Warteschlangen</h2>

                    <div class="container d-flex justify-content-center w-75 mb-lg-5">

                        @foreach($userQueues as $d)
                            <div class="card m-3" style="width: 18rem;">
                                <div class="card-header">
                                    <h5 class="card-title text-center">Ihre aktuelle Position in:</h5>
                                    <h3 class="card-text text-center text-primary">{{$d->queue->poi->name}}</h3>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="card-body d-flex justify-content-center flex-column">
                                            <h2 class="text-center">161</h2>
                                            <a href="#" class="btn btn-secondary active ce" role="button" aria-pressed="true">Details</a>
                                        </div>
                                    </li>

                                </ul>
                            </div>

                        @endforeach
                    </div>


        @endif

            @if($queues != null)
                <div class="container">
                    <h2 class="text-center pb-3">Offene Warteschlangen</h2>

                    <table class="table table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Postleitzahl</th>
                            <th scope="col">Aktuelle Wareschlange</th>
                            <th scope="col">Warteschlange</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($queues as $q)
                            <tr>
                                <th scope="row">{{$q->id}}</th>
                                <td>{{$q->poi->name}}</td>
                                <td>{{$q->poi->location->zip}}</td>
                                <td> 161 </td>
                                <td >
                                    <form action="{{route('postQueueUser')}}" method="POST">
                                        @csrf

                                        <button name="applyBtn" type="submit" class="btn btn-dark" value="{{$q->uuid}}">
                                            Einreihen
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>

            @endif
    </div>

@endsection
