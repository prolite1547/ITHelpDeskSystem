<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

         <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ITMonitoring') }}</title>
        
      
     
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/app_2.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
       


       
        <!-- <link href="css/custom.css" rel="stylesheet"> -->
       
     


        <style>
            label{
                font-weight: bold;
            }

            h3, h4, h5{
                font-size:16px;
            }
            label{
                font-size:14px;
            }

           
        </style>
    </head>
<body class="bg-light">
 



 