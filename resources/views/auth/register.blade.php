<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registration Page</title>
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

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <b>Admin</b>LTE</a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new membership</p>

                <form action="{{route('register')}}" method="post">
                    <div class="form-group {{$errors->has('email') ? 'has-error' : ''}} has-feedback">
                        <input id="email" value="{{old('email')}}" type="email" name="email" class="form-control" placeholder="Email Address">
                        @if($errors->has('email'))
                        <span class="help-block">
                            <strong>{{$errors->first('email')}}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->has('username') ? 'has-error' : ''}} has-feedback">
                        <input id="username" value="{{old('username')}}" type="text" name="name" class="form-control" placeholder="Username">
                        @if($errors->has('username'))
                        <span class="help-block">
                            <strong>{{$errors->first('username')}}</strong>
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
                    <div class="form-group {{$errors->has('address') ? 'has-error' : ''}} has-feedback">
                        <input id="address" value="{{old('address')}}" type="text" name="address" class="form-control" placeholder="Address">
                        @if($errors->has('address'))
                        <span class="help-block">
                            <strong>{{$errors->first('address')}}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->has('city') ? 'has-error' : ''}} has-feedback">
                        <input id="city" value="{{old('city')}}" type="text" name="city" class="form-control" placeholder="City">
                        @if($errors->has('city'))
                        <span class="help-block">
                            <strong>{{$errors->first('city')}}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->has('phone_number') ? 'has-error' : ''}} has-feedback">
                        <input id="phone_number" value="{{old('avatar')}}" type="text" name="phone_number" class="form-control" placeholder="Phone Number">
                        @if($errors->has('phone_number'))
                        <span class="help-block">
                            <strong>{{$errors->first('phone_number')}}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->has('avatar') ? 'has-error' : ''}} has-feedback">
                        <input id="avatar" value="{{old('avatar')}}" type="file" name="avatar" class="form-control" placeholder="Avatar">
                        @if($errors->has('avatar'))
                        <span class="help-block">
                            <strong>{{$errors->first('avatar')}}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <a href="{{route('login')}}" class="text-center">I already have a membership</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
</body>

</html>