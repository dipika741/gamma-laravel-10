<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="msapplication-TileColor" content="#0E0E0E">
  <meta name="template-color" content="#0E0E0E">
  <meta name="description" content="@yield('meta_description', 'Index page')">
  <meta name="keywords" content="@yield('meta_keywords', 'index, page')">
  <meta name="author" content="">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/imgs/template/favicon.ico') }}">
  <link href="{{ asset('assets/css/style.css?v=3.0.0') }}" rel="stylesheet">
  <title>@yield('title', 'Gamma Scientific')</title>
</head>
<body>
<div id="preloader-active">
  <div class="preloader d-flex align-items-center justify-content-center">
    <div class="preloader-inner position-relative">
      <div class="text-center">
        <img class="mb-10" src="{{ asset('assets/imgs/template/favicon.png') }}" alt="#">
        <div class="preloader-dots ml-75"></div>
      </div>
    </div>
  </div>
</div>

@include('includes.topbar')
@include('includes.menubar')
