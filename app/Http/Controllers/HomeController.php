<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private const EXPLORE = [
        'returns'   => ['My Investment Returns', 'See how your current investments are growing, with AI insights and a one-page PDF.'],
        'portfolio' => ['Stock Portfolio Analysis', 'Nifty 500 shares analysis, for Indian investors.'],
        'tax'       => ['Income Tax Calculator', 'New tax regime income tax calculator for FY 2026-27 (AY 2027-28).'],
        'sip'       => ['SIP Calculator', 'See what delaying your SIP costs you, and build a target-based SIP plan.'],
        'emi'       => ['Home Loan EMI Calculator', 'Compare 10 to 30 year home loan tenures side by side.'],
        'budget'    => ['Budget Planner', 'Plan your month, track actual spending, and get a clear analysis.'],
        'sample'    => ['Sample Portfolio', 'Safe, Moderate and Aggressive sample investment mixes.'],
        'invest'    => ['One Window Investing', 'FD, Bonds, International investing and Mutual Funds in one place.'],
        'gq'        => ['Get Quotes', 'Term, Health, Car and Bike Insurance, Credit Card and Loan quotes.'],
    ];

    public function index()
    {
        return view('index');
    }

    public function explore(string $slug)
    {
        abort_unless(isset(self::EXPLORE[$slug]), 404);

        [$title, $description] = self::EXPLORE[$slug];

        return view('index', [
            'exploreSlug'     => $slug,
            'pageTitle'       => $title . ' – Retirement Plan Karo',
            'pageDescription' => $description,
        ]);
    }
}