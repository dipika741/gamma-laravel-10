<header class="header sticky-bar">
  <div class="container">
    <div class="main-header">
      <div class="header-left">
        <div class="header-logo">
          <a class="d-flex" href="{{ url('/') }}">
            <img alt="#" src="{{ asset('assets/imgs/template/logo.png') }}">
          </a>
        </div>
        <div class="header-nav">
          <nav class="nav-main-menu d-none d-xl-block">
            <ul class="main-menu">
              <li><a href="{{ url('/') }}">Home</a></li>
              <li><a href="{{ url('/about') }}">About Us</a></li>
              <li class="has-children"><a href="#">Products</a>
                <!-- <ul class="sub-menu">
                  <li><a href="#">Laboratory Equipment</a></li>
                  <li><a href="#">Analytical Instruments</a></li>
                  <li><a href="#">Material Testing Equipment</a></li>
                  <li><a href="#">HPLC Consumables</a></li>
                  <li><a href="#">Laboratory Glasswares</a></li>
                  <li><a href="#">Laboratory Plasticwares</a></li>
                  <li><a href="#">Laboratory Furnitures</a></li>
                  <li><a href="#">Food Testing Equipment</a></li>
                </ul> -->
                <ul class="menu">
        @foreach($headerCategories as $category)
            <li class="menu-item has-dropdown">
                <a href="#">{{ $category->name }}</a>

                {{-- Subcategory dropdown --}}
                @if($category->subcategories->count())
                    <ul class="submenu">
                        @foreach($category->subcategories as $subcategory)
                            <li>
                                <a href="{{ url('products/'.$category->id.'/'.$subcategory->id) }}">
                                    {{ $subcategory->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
              </li>
              <li><a href="{{ url('/services') }}">Services</a></li>
              <li><a href="{{ url('/downloads') }}">Downloads</a></li>
              <li><a href="{{ url('/contact') }}">Contact Us</a></li>
            </ul>
          </nav>
          <div class="burger-icon burger-icon-white">
            <span class="burger-icon-top"></span>
            <span class="burger-icon-mid"></span>
            <span class="burger-icon-bottom"></span>
          </div>
        </div>
        <div class="header-shop">
          <div class="d-inline-block box-dropdown-cart">
            <span class="font-lg icon-list icon-account"><span>Brands</span></span>
          </div>
          <a class="font-lg icon-list icon-wishlist" href="#"><span>Promotions</span></a>
        </div>
        <a class="font-lg icon-list icon-compare" href="#"><span>News</span></a>
      </div>
    </div>
  </div>
</header>

{{-- Mobile Menu --}}
<div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
  <div class="mobile-header-wrapper-inner">
    <div class="mobile-header-content-area">
      <div class="mobile-logo">
        <a class="d-flex" href="{{ url('/') }}">
          <img alt="#" src="{{ asset('assets/imgs/template/logo.svg') }}">
        </a>
      </div>
      <div class="perfect-scroll">
        <div class="mobile-menu-wrap mobile-header-border">
          <nav class="mt-15">
            <ul class="mobile-menu font-heading">
              <li><a class="active" href="{{ url('/') }}">Home</a></li>
              <li><a href="{{ url('/about') }}">About Us</a></li>
              <li class="has-children"><a href="#">Products</a>
                <ul class="sub-menu">
                  <li><a href="#">Laboratory Equipment</a></li>
                  <li><a href="#">Analytical Instruments</a></li>
                  <li><a href="#">Material Testing Equipment</a></li>
                  <li><a href="#">HPLC Consumables</a></li>
                  <li><a href="#">Laboratory Glasswares</a></li>
                  <li><a href="#">Laboratory Plasticwares</a></li>
                  <li><a href="#">Laboratory Furnitures</a></li>
                  <li><a href="#">Food Testing Equipment</a></li>
                </ul>
              </li>
              <li><a href="{{ url('/services') }}">Services</a></li>
              <li><a href="{{ url('/downloads') }}">Downloads</a></li>
              <li><a href="{{ url('/contact') }}">Contact Us</a></li>
            </ul>
          </nav>
        </div>
        <div class="mobile-banner">
          <div class="bg-5 block-iphone">
            <span class="color-brand-3 font-sm-lh32">Starting from $500</span>
            <h3 class="font-xl mb-10">LABORATORY GENERATORS</h3>
            <p class="font-base color-brand-3 mb-10">Special offers</p>
            <a class="btn btn-arrow" href="#">more..</a>
          </div>
        </div>
        <div class="site-copyright color-gray-400 mt-30">
          Copyright 2024 &copy; Delta Scientific.
        </div>
      </div>
    </div>
  </div>
</div>
