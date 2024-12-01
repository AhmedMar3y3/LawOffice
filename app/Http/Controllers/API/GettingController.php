<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Issue;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Session;

class GettingController extends Controller
{
    public function getAllSessions()
{
    $sessions = Session::with('case.customer')
        ->whereHas('case.customer', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->get();

    return response()->json([
        'sessions' => $sessions->map(function ($session) {
            return [
                'session_id' => $session->id,
                'title' => $session->title,
                'description' => $session->description,
                'date' => $session->date,
                'case_number' => $session->case->case_number,
                'customer_name' => $session->case->customer->name,
            ];
        }),
    ], 200);
}

    
    public function getAllPayments()
    {
        $payments = Payment::with('case.customer')
        ->whereHas('case.customer', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->get();

    return response()->json([
        'payments' => $payments->map(function ($payment) {
            return [
                'payment_id' => $payment->id,
                'title' => $payment->title,
                'amount' => $payment->amount,
                'method' => $payment->method,
                'date' => $payment->date,
                'case_id' => $payment->case->id,
                'case_number' => $payment->case->case_number,
                'customer_name' => $payment->case->customer->name,
            ];
        }),
    ], 200);
}
    public function getAllAttachments()
    {
        $attachments = Attachment::with('case.customer')
        ->whereHas('case.customer', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->get();

    return response()->json([
        'attachments' => $attachments->map(function ($attachment) {
            return [
                'attachment_id' => $attachment->id,
                'title' => $attachment->title,
                'file path' => $attachment->file_path,
                'file type' => $attachment->file_type,
                'case_id' => $attachment->case->id,
                'case_number' => $attachment->case->case_number,
                'customer_name' => $attachment->case->customer->name,
            ];
        }),
    ], 200);
}
    
public function getAllCases()
{
    $cases = Issue::with('customer', 'category', 'payments') // Eager load the necessary relationships
        ->whereHas('customer', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->get();

    return response()->json([
        'cases' => $cases->map(function ($case) {
            // Calculate the paid and remaining amounts
            $paidAmount = $case->payments->sum('amount');
            $remainingAmount = $case->contract_price - $paidAmount;

            return [
                'case_id' => $case->id,
                'case_number' => $case->case_number,
                'customer_name' => $case->customer->name,
                'customer_phone' => $case->customer->phone,
                'customer_category' => $case->customer->category->name,
                'case_category' => $case->category->name,
                'contract_price' => $case->contract_price,
                'paid_amount' => $paidAmount,
                'remaining_amount' => $remainingAmount,
            ];
        }),
    ], 200);
}

}
