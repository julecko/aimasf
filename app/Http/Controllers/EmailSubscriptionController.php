<?php

namespace App\Http\Controllers;

use App\Mail\EmailSubscriptionConfirmation;
use App\Models\EmailSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EmailSubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:email_subscriptions,email',
        ]);

        $token = Str::random(126);

        $subscription = EmailSubscription::create([
            'email' => $request->input('email'),
            'token' => $token,
        ]);

        Mail::to($request->input('email'))->send(new EmailSubscriptionConfirmation($token));

        return response()->json(['message' => 'Please check your email to confirm your subscription.']);
    }
    public function confirm($token)
    {
        $subscription = EmailSubscription::where('token', $token)->first();

        if (!$subscription) {
            return response()->json(['error' => 'Invalid token.'], 400);
        }

        $subscription->is_confirmed = true;
        $subscription->save();

        return response()->json(['message' => 'Your email has been confirmed.']);
    }
}
