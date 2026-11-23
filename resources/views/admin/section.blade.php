@extends('admin.layout')

@section('title', $name)

@push('styles')
  <style>
    .hh { display: flex; justify-content: space-between; gap: 12px; flex-wrap: wrap; align-items: flex-start; margin-bottom: 16px }
    .sub { color: var(--mut) }
    .cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 14px }
    .card-link { background: var(--card); border: 1px solid var(--line); border-radius: 14px; padding: 18px 20px; text-decoration: none; color: inherit; display: flex; flex-direction: column; gap: 6px; position: relative }
    .card-link:hover { border-color: var(--pri) }
    .card-link h3 { margin: 0; font-size: 16px }
    .card-link p { margin: 0; color: var(--mut); font-size: 13px }
    .card-link .num { font-size: 28px; font-weight: 700; margin-top: 6px }
    .card-link .chev { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: var(--mut); font-size: 18px }
  </style>
@endpush

@section('content')
  <div class="hh">
    <div>
      <h2 style="margin:0">{{ $name }}</h2>
      <div class="sub" style="margin:2px 0 0">{{ $desc }}</div>
    </div>
  </div>

  <div class="cards">
    @foreach($tiles as $t)
      <a class="card-link" href="{{ $t['route'] }}">
        <h3>{{ $t['label'] }}</h3>
        <p>{{ $t['about'] }}</p>
        <span class="num" style="font-size:17px">{{ $t['stat'] }}</span>
        <span class="chev">›</span>
      </a>
    @endforeach
  </div>
@endsection
