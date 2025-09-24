{{-- resources/views/layouts/partials/metadata.blade.php --}}

<title>{{ $meta['title'] ?? config('app.name') }}</title>

<meta name="description" content="{{ $meta['description'] ?? 'high-quality pharmaceutical laboratory products and manufacturing solutions ' }}">
<meta name="keywords" content="{{ $meta['keywords'] ?? 'pharmaceutical reference standards, impurities, columns, consumables, various instruments, chemical equipment' }}">
<link rel="canonical" href="{{ $meta['canonical'] ?? url()->current() }}">

{{-- Open Graph / Facebook --}}
<meta property="og:title" content="{{ $meta['title'] ?? config('app.name') }}">
<meta property="og:description" content="{{ $meta['description'] ?? '' }}">
<meta property="og:url" content="{{ $meta['canonical'] ?? url()->current() }}">
<meta property="og:type" content="{{ $meta['type'] ?? 'website' }}">
<meta property="og:image" content="{{ $meta['image'] ?? asset('images/default-og.jpg') }}">

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $meta['title'] ?? config('app.name') }}">
<meta name="twitter:description" content="{{ $meta['description'] ?? '' }}">
<meta name="twitter:image" content="{{ $meta['image'] ?? asset('images/default-og.jpg') }}">
