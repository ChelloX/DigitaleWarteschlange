@extends('layouts.admin')

@section('content')
<h2>Markt verwalten</h2>
<form action="{{route('admin.managePoi')}}" method="post">
    @csrf
    <table class="table"><tr><th scope="col">id</th><th scope="col">name</th><th scope="col">löschen</th></tr>
        @foreach($pois as $poi)
            <tr><th scope="row">{{$poi->id}}</th><td>{{$poi->name}}</td><td><button value="{{$poi->id}}" name="deleteButton" type="submit" class="btn btn-outline-danger">Danger</button></td></tr>
        @endforeach
    </table>
</form>
@endsection
