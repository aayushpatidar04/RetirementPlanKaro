<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Payment;
use App\Models\User;

class ClientController extends Controller
{
    public function index()
    {
        $stats = [
            'clients' => User::count(),
            'prospects' => Lead::count(),
            'transactions' => Payment::count(),
        ];

        return view('admin.clients.index', compact('stats'));
    }
}
