@extends('layouts.maintainer')

@section('content')
    <div class="container">
        @if (session()->has('success'))
            <div class="alert alert-success">
                @if(is_array(session()->get('success')))
                    <ul>
                        @foreach (session()->get('success') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @else
                    {{ session()->get('success') }}
                @endif
            </div>
        @endif
    </div>

    <h1>Maintainer-Dashboard</h1>
@endsection