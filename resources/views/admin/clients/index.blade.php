@extends('admin.layout')

@section('title', 'Clients')

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
      <h2 style="margin:0">Clients</h2>
      <div class="sub" style="margin:2px 0 0">Registrations, prospects and transactions</div>
    </div>
  </div>

  <div class="cards">
    <a class="card-link" href="{{ route('admin.users') }}">
      <h3>Client Records</h3>
      <p>Every registered client with profile and history</p>
      <span class="num">{{ number_format($stats['clients']) }}</span>
      <span class="chev">›</span>
    </a>
    <a class="card-link" href="{{ route('admin.leads') }}">
      <h3>Prospects</h3>
      <p>Prospects awaiting follow-up</p>
      <span class="num">{{ number_format($stats['prospects']) }}</span>
      <span class="chev">›</span>
    </a>
    <a class="card-link" href="{{ route('admin.payments') }}">
      <h3>Transactions</h3>
      <p>Receipts, failed transactions and refunds</p>
      <span class="num">{{ number_format($stats['transactions']) }}</span>
      <span class="chev">›</span>
    </a>
  </div>
@endsection
