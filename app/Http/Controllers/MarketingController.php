<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarketingController extends Controller
{
    public function home(): View
    {
        return view('marketing.home');
    }

    public function features(): View
    {
        return view('marketing.features');
    }

    public function pricing(): View
    {
        return view('marketing.pricing');
    }

    public function contact(): View
    {
        return view('marketing.contact');
    }

    public function submitContact(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        return redirect()->route('marketing.contact')
            ->with('status', __('marketing.contact_success'));
    }

    public function terms(): View
    {
        return view('marketing.legal.terms');
    }

    public function privacy(): View
    {
        return view('marketing.legal.privacy');
    }

    public function cookiePolicy(): View
    {
        return view('marketing.legal.cookie-policy');
    }
}
