<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $event = trim((string) $request->query('event', ''));

        $leads = DB::table('leads')
            ->when($event !== '', fn ($q) => $q->where('event', $event))
            ->orderByDesc('id')
            ->paginate(40)
            ->withQueryString();

        $events = DB::table('leads')->select('event')->distinct()->orderBy('event')->pluck('event');

        return view('admin.leads', compact('leads', 'event', 'events'));
    }
}