<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $customers = auth()->user()->customers()->count();
        $cases = auth()->user()->customers()->withCount('cases')->get()->sum('cases_count');
        $sessions = auth()->user()->customers()->with('cases.sessions')->get()->pluck('cases')->flatten()->pluck('sessions')->flatten()->count();
        $contracts = auth()->user()->customers()->with('cases')->get()->pluck('cases')->flatten()->sum('contract_price');
        $payments = auth()->user()->customers()->with('cases.payments')->get()->pluck('cases')->flatten()->pluck('payments')->flatten()->sum('amount');
        $remaining = $contracts - $payments;
        $expenses = auth()->user()->expenses()->sum('amount');
        $expenses = (int) $expenses;
        $revnue = $payments - $expenses;
        return response()->json([
            'customers' => $customers,
            'cases' => $cases,
            'sessions' => $sessions,
            'contracts' => $contracts,
            'payments' => $payments,
            'remaining' => $remaining,
            'expenses' => $expenses,
            'revnue' => $revnue,
        ]);
    }
}
