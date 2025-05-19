<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{

    
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $customers = $user->customers()->count();
        $cases = $user->customers()->withCount('cases')->get()->sum('cases_count');
        $sessions = $user->customers()->with('cases.sessions')->get()->pluck('cases')->flatten()->pluck('sessions')->flatten()->count();
        $contracts = $user->customers()->with('cases')->get()->pluck('cases')->flatten()->sum('contract_price');
        $payments = $user->customers()->with('cases.payments')->get()->pluck('cases')->flatten()->pluck('payments')->flatten()->sum('amount');
        $remaining = $contracts - $payments;
        $expenses = $user->expenses()->sum('amount');
        $expenses = (int) $expenses;
        $revenue = $payments - $expenses;

        return response()->json([
            'customers' => $customers,
            'cases'     => $cases,
            'sessions'  => $sessions,
            'contracts' => $contracts,
            'payments'  => $payments,
            'remaining' => $remaining,
            'expenses'  => $expenses,
            'revenue'   => $revenue,
        ]);
    }

    public function sessionDates($year, $month)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $sessions = $user->customers()->with('cases.sessions')->get()
            ->pluck('cases')->flatten()
            ->pluck('sessions')->flatten()
            ->filter(function ($session) use ($year, $month) {
                return $session->date->format('Y') == $year && $session->date->format('m') == $month;
            })
            ->groupBy(function ($session) {
                return $session->date->format('Y-m-d');
            })->map->count();

        // إنشاء تقويم شهري كامل مع 0 للأيام الفارغة
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $result = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = sprintf('%d-%02d-%02d', $year, $month, $day);
            $result[$date] = $sessions[$date] ?? 0;
        }

        return response()->json($result);
    }

    public function paymentDetails()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $payments = $user->customers()->with('cases.payments')->get()
            ->pluck('cases')->flatten()
            ->pluck('payments')->flatten()
            ->map(function ($payment) {
                return [
                    'amount' => $payment->amount,
                    'date' => $payment->created_at->format('Y-m-d'),
                    'case_id' => $payment->case_id,
                ];
            });

        return response()->json($payments);
    }

    public function contractDetails()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $contracts = $user->customers()->with('cases')->get()
            ->pluck('cases')->flatten()
            ->map(function ($case) {
                return [
                    'contract_price' => $case->contract_price,
                    'case_id' => $case->id,
                    'created_at' => $case->created_at->format('Y-m-d'),
                ];
            });

        return response()->json($contracts);
    }
}
