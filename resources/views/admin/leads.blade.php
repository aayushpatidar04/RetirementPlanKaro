@extends('admin.layout')

@section('content')
    <div class="top">
        <div>
            <h2>Leads</h2>
            <p>{{ $leads->total() }} total.</p>
        </div>

        <form class="row" method="GET" action="{{ url()->current() }}">
            <select name="event" onchange="this.form.submit()">
                <option value="">All events</option>

                @foreach ($events as $e)
                    <option value="{{ $e }}" {{ $event === $e ? 'selected' : '' }}>
                        {{ $e }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="panel">
        @if ($leads->isEmpty())
            <div class="empty">No leads.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>IP</th>
                        <th>When</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($leads as $l)
                        <tr>
                            <td>
                                <span class="tag mu">
                                    {{ $l->event }}
                                </span>
                            </td>

                            <td>{{ $l->mobile ?? '—' }}</td>

                            <td>{{ $l->email ?? '—' }}</td>

                            <td>{{ $l->ip ?? '—' }}</td>

                            <td>
                                {{ \Illuminate\Support\Carbon::parse($l->created_at)->format('d M Y, h:i A') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="pager">
        {{ $leads->appends(request()->query())->links() }}
    </div>
@endsection