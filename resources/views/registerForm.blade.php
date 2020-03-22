@extends('layouts.user')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                @if($message = Session::get('mailerror'))
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <p>Ihre Mail befindet sich bereits in unserem System.</p>
                    </div>
                @endif
                    @if($message = Session::get('passerror'))
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <p>Die beiden Passwörter sind nicht identisch.</p>
                        </div>
                    @endif
                <form action="{{route('register.post')}}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="lastname">Nachname</label>
                        <input class="form-control" type="text" name="lastname" id="lastname"
                               placeholder="Nachname" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Vorname</label>
                        <input class="form-control" type="text" name="firstname" id="firstname"
                               placeholder="Vorname" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail:</label>
                        <input class="form-control" type="email" name="email" id="email"
                               placeholder="E-Mail" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Passwort</label>
                        <input class="form-control" type="password" name="password" id="password"
                               placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_conf">Passwort-Bestätigung</label>
                        <input class="form-control" type="password" name="password_conf" id="password_conf"
                               placeholder="Passwort-Bestätigung" required>
                    </div>

                    <div class="form-group">
                        <label for="poi_name">Ihr Unternehmen: </label>
                        <input class="form-control" type="text" name="poi_name" id="poi_name"
                               placeholder="Ihr Unternehmen:" required>
                    </div>
                    <div class="form-group">
                        <label for="zip">Postleitzahl: </label>
                        <input class="form-control" type="text" name="zip" id="zip"
                               placeholder="Ihr Standort (PlZ)" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Registrieren</button>
                </form>
            </div>
        </div>
    </div>
@endsection