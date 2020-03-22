@extends('layouts.maintainer')
@section('content')
    <div class="container d-flex justify-content-center flex-column">
        <div class="container d-flex justify-content-center flex-column align-content-center">
            <h2 class="text-center mb-5">Hier die aktuellen Warteschlangen:</h2>
            <form action="{{route('maintainer.deleteQueue')}}" method="post" class="d-flex justify-content-center">
                @csrf
                <table class="table table-responsive-sm w-50">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col"></th>
                        <th class="text-right"></th>
                    </tr>
                    </thead>

                    @foreach($queues as $queue)
                        <tr>
                            <td>{{$queue->name}}</td>
                            <td class="text-right"><a href="{{route('maintainer.queueDetail')}}?id={{$queue->id}}"
                                                      class="btn btn-secondary active ce" role="button"
                                                      aria-pressed="true">Details</a></td>
                            <td class="text-right">
                                <button value="{{$queue->id}}" name="deleteButton" type="submit"
                                        class="btn btn-outline-danger">Schließen
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </form>
        </div>

        <div class="container d-flex justify-content-center flex-column align-content-center mt-lg-5">
            <div class="card d-flex justify-content-center w-100">
                <div class="card-header">
                    <h2 class="text-center">Erstelle eine neue Warteschlange!</h2>
                </div>
                <div class="card-body">

                    <form action="{{route('maintainer.createQueue')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" placeholder="name" class="form-control" required>
                        </div>
                        <button class="btn btn-dark float-right" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>


    </div>

@endsection
