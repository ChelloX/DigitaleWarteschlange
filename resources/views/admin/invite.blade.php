@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.invite.send')}}" method="post">
                    @csrf
                    @if(count($errors) > 0 )
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <ul>
                                @foreach($errors as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($message = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                          <p>E-Mail versand!</p>
                        </div>
                        @endif
                    <input type="hidden" value="{{$regtoken}}" name="regtoken" id="regtoken">
                    <div class="form-group">
                        <label for="reglink">Regstrierungstoken</label>
                        <input class="form-control" type="text" name="regLink" id="reglink"
                               placeholder="digitale-warteschlange.de/register/{{$regtoken}}" value="https://digitale-warteschlange.de/register/{{$regtoken}}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="mailto">Markt-EMailadresse</label>
                        <input type="email" class="form-control" name="mailto" id="mailto" aria-describedby="emailHelp"
                               placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">Hier die Mailaddresse des zu einladenen Markt
                            angeben.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary">E-Mail senden</button>
                </form>
            </div>
        </div>
    </div>

@endsection