<div class="section-box">
  <div class="breadcrumbs-div">
    <div class="container">
      <ul class="breadcrumb">
        <li><a class="font-xs color-gray-1000" href="{{ url('/') }}">Home</a></li>
        @foreach($breadcrumps ?? [] as $item)
          <li><a class="font-xs color-gray-1000" href="#">{{ $item }}</a></li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
