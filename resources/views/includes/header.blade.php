<header class="header sticky-bar">
    <div class="container">
        <div class="main-header">
            <div class="header-left">
                <div class="header-logo">
                    <a class="d-flex" href="{{ url('/') }}">
                        <img alt="#" src="{{ asset('assets/imgs/template/logo.png') }}">
                    </a>
                </div>

                {{-- Desktop Navigation --}}
                <div class="header-nav">
                    <nav class="nav-main-menu d-none d-xl-block">
                        <ul class="main-menu">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ url('/about') }}">About Us</a></li>

                            {{-- Products --}}
                            <li class="has-children">
                                <a href="#">Products</a>
                                <ul class="menu">
                                    @foreach($headerCategories as $category)
                                        <li class="menu-item has-dropdown">
                                            <a href="{{ route('products.listing', $category->slug) }}">
                                                {{ $category->name }}
                                            </a>

                                            {{-- Subcategories --}}
                                            @if($category->subcategories->count())
                                                <ul class="submenu">
                                                    @foreach($category->subcategories as $subcategory)
                                                        <li class="menu-item {{ $subcategory->subSubCategories->count() ? 'has-dropdown' : '' }}">
                                                            <a href="{{ route('products.subcategory', [$category->slug, $subcategory->slug]) }}">
                                                                {{ $subcategory->name }}
                                                            </a>

                                                            {{-- Sub-subcategories --}}
                                                            @if($subcategory->subSubCategories->count())
                                                                <ul class="submenu">
                                                                    @foreach($subcategory->subSubCategories as $subsubcategory)
                                                                        <li>
                                                                            <a href="{{ route('products.subsubcategory', [$category->slug, $subcategory->slug, $subsubcategory->slug]) }}">
                                                                                {{ $subsubcategory->name }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
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

                    {{-- Burger Icon (Mobile Toggle) --}}
                    <div class="burger-icon burger-icon-white">
                        <span class="burger-icon-top"></span>
                        <span class="burger-icon-mid"></span>
                        <span class="burger-icon-bottom"></span>
                    </div>
                </div>

                {{-- Right Section --}}
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
            <div class="mobile-header-info-wrap">
                <div class="mobile-logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/imgs/template/logo.png') }}" alt="logo">
                    </a>
                </div>
                <div class="mobile-close close-mobile-header">
                    <i class="icon-x"></i>
                </div>
            </div>

            <div class="mobile-header-menu">
                <ul class="main-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/about') }}">About Us</a></li>

                    {{-- Products --}}
                    <li class="has-children">
                        <a href="#">Products</a>
                        <ul class="submenu">
                            @foreach($headerCategories as $category)
                                <li class="{{ $category->subcategories->count() ? 'has-children' : '' }}">
                                    <a href="{{ route('products.listing', $category->slug) }}">{{ $category->name }}</a>

                                    @if($category->subcategories->count())
                                        <ul class="submenu">
                                            @foreach($category->subcategories as $subcategory)
                                                <li class="{{ $subcategory->subSubCategories->count() ? 'has-children' : '' }}">
                                                    <a href="{{ route('products.subcategory', [$category->slug, $subcategory->slug]) }}">
                                                        {{ $subcategory->name }}
                                                    </a>

                                                    @if($subcategory->subSubCategories->count())
                                                        <ul class="submenu">
                                                            @foreach($subcategory->subSubCategories as $subsubcategory)
                                                                <li>
                                                                    <a href="{{ route('products.subsubcategory', [$category->slug, $subcategory->slug, $subsubcategory->slug]) }}">
                                                                        {{ $subsubcategory->name }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
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
            </div>

        </div>
    </div>
</div>
