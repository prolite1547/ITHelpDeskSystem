<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset("assets/css/all.min.css") }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ mix('/css/styles.css') }}" />
</head>
<body>
<div class="container-login">
    <div class="banner"></div>
    <div class="login">
        <div class="u-center-text u-margin-bottom-small">
            <h2 class="heading-secondary">
                IT &dash; Monitoring
            </h2>
        </div>
        <div class="login__form">

            {!! Form::open(['method' => 'POST','route' => 'login', 'class' => 'form']) !!}
            <div class="form__group form__group--login">
            <i class="form__icon fas fa-user"></i>
            {!! Form::text('uname','',['class'=>'form__input', 'placeholder' => 'username', 'id' => 'uname', 'required']) !!}
            </div>

            <div class="form__group form__group--login">
            <i class="form__icon fas fa-ellipsis-h"></i>
            {!! Form::password('password',['class'=>'form__input', 'placeholder' => 'password', 'id' => 'password', 'required']) !!}
            </div>

            <div class="form-group u-margin-top-xsmall">
            {!! Form::button('Login',['type' => 'submit','class' => 'btn btn--blue']) !!}
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>
</body>
</html>
