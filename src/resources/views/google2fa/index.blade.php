@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default" style="margin: 30px 0;">

                    <div class="panel-body">
                        <form method="POST" action="{{ route('2fa') }}">
                            <div class="form-group">
                                <div class="heading-block" style="margin-left: 15px;">Register</div>
                            </div>
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="one_time_password" class="col-md-4 control-label">Google authenticator code</label>

                                <div class="col-md-6">
                                    <input id="one_time_password" type="number" class="form-control"
                                           name="one_time_password" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-link">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
