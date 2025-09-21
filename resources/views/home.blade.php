@extends('app') {{-- not layouts.app, since you kept it in views/ --}}

@section('title', 'Home')

@section('content')
    
    {{-- Breadcrumbs --}}
    @include('includes.breadcrumbs', ['pageTitle' => 'Home'])

    {{-- Page Content --}}
    <section class="section-box mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="mb-30">Welcome to Gamma Scientific</h1>
                    <p class="font-md color-gray-700">
                        This is your home page. You can replace this content with banners, product listings,
                        or any custom frontend content you want to display.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
