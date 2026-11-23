@extends('admin.layout')

@section('title', 'No access')

@section('content')
  <div class="card" style="max-width:560px;margin:40px auto">
    <div style="padding:28px;text-align:center">
      <h3 style="margin:0 0 6px">No access to {{ $area }}</h3>
      <p style="margin:0 0 16px;color:var(--mut)">{{ $message }}</p>
      @php $home = \App\Support\AdminAccess::home(); @endphp
      @if($home !== url()->current())
        <a class="btn p" href="{{ $home }}">Go to a page you can open</a>
      @endif
    </div>
  </div>
@endsection
