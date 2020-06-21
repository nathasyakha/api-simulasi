<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Login Page</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="{{asset('/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="{{asset('/css.css')}}" rel="stylesheet">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <b>DEEKEY&reg</b>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="{{route('login')}}" method="post">
                    @csrf
                    <div class="form-group {{$errors->has('email') ? 'has-error' : ''}} has-feedback">
                        <input id="email" value="{{old('email')}}" type="email" name="email" class="form-control" placeholder="Email Address">
                        @if($errors->has('email'))
                        <span class="help-block">
                            <strong>{{$errors->first('email')}}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->has('password') ? 'has-error' : ''}} has-feedback">
                        <input id="password" value="{{old('password')}}" type="password" name="password" class="form-control" placeholder="Password">
                        @if($errors->has('password'))
                        <span class="help-block">
                            <strong>{{$errors->first('password')}}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" name="remember" {{old('remember') ? 'checked' : ''}}>
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <a onclick="login()" class="btn btn-primary btn-block">Sign In</a>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-1">
                    <a href="{{route('password.request')}}">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="{{route('register')}}" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>

    <script type="text/javascript">
        function login() {

            const data = {
                "grant_type": "password",
                "client_id": "2",
                "client_secret": "hpfOOKQmOI5tlFmX6AOyvlhhNRCXY6rN2pB4SrTt",
                "username": $('#email').val(),
                "password": $('#password').val(),
                "scope": ""
            }

            const dataJson = JSON.stringify(data);
            const authUser = {}

            $.ajax({
                type: "POST",
                url: "http://localhost:8000/oauth/token",
                data: dataJson,
                dataType: "json",
                contentType: "application/json"
            }).then(response => {
                console.log('oauth token', response)
                authUser.access_token = response.access_token
                authUser.refresh_token = response.refresh_token
                window.localStorage.setItem('authUser', JSON.stringify(authUser))

                const tokenData = JSON.parse(window.localStorage.getItem('authUser'))
                const header = {
                    "Accept": "application/json",
                    "Authorization": "Bearer " + tokenData.access_token,
                    "Content-Type": "application/json"
                }
                $.ajax({
                    type: "POST",
                    url: "{{route('login')}}",

                    data: {
                        "email": $('#email').val(),
                        "password": $('#password').val(),
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        window.location.replace(data);
                    }
                })
            });

        }
    </script>
</body>

</html>