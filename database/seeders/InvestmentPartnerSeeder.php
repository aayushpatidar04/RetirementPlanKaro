<?php

namespace Database\Seeders;

use App\Models\InvestmentPartner;
use Illuminate\Database\Seeder;

class InvestmentPartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            [
                'label' => 'Digital Gold',
                'category' => 'Precious Metals',
                'partner' => 'SafeGold',
                'url' => 'https://www.safegold.com/invest?ref=rpk',
                'is_active' => true,
                'sort_order' => 1,
                'clicks' => 1247,
            ],
            [
                'label' => 'Sovereign Gold Bonds',
                'category' => 'Precious Metals',
                'partner' => 'RBI / Banks',
                'url' => 'https://www.rbi.org.in/scripts/SGB.aspx?ref=rpk',
                'is_active' => true,
                'sort_order' => 2,
                'clicks' => 892,
            ],
            [
                'label' => 'Silver ETF',
                'category' => 'Precious Metals',
                'partner' => 'Nippon India',
                'url' => 'https://mutualfund.nipponindiaim.com/silver-etf?ref=rpk',
                'is_active' => true,
                'sort_order' => 3,
                'clicks' => 456,
            ],
            [
                'label' => 'Fixed Deposit (Corporate)',
                'category' => 'Fixed Income',
                'partner' => 'Bajaj Finance',
                'url' => 'https://www.bajajfinserv.in/fixed-deposit?ref=rpk',
                'is_active' => true,
                'sort_order' => 4,
                'clicks' => 2134,
            ],
            [
                'label' => 'Fixed Deposit (Bank)',
                'category' => 'Fixed Income',
                'partner' => 'HDFC Bank',
                'url' => 'https://www.hdfcbank.com/fixed-deposit?ref=rpk',
                'is_active' => true,
                'sort_order' => 5,
                'clicks' => 1876,
            ],
            [
                'label' => 'Corporate Bonds',
                'category' => 'Fixed Income',
                'partner' => 'GoldenPi',
                'url' => 'https://www.goldenpi.com/corporate-bonds?ref=rpk',
                'is_active' => true,
                'sort_order' => 6,
                'clicks' => 634,
            ],
            [
                'label' => 'NCD (Non-Convertible Debentures)',
                'category' => 'Fixed Income',
                'partner' => 'BondsIndia',
                'url' => 'https://www.bondsindia.com/ncd?ref=rpk',
                'is_active' => true,
                'sort_order' => 7,
                'clicks' => 421,
            ],
            [
                'label' => 'ELSS (Tax Saver Funds)',
                'category' => 'Mutual Funds',
                'partner' => 'Zerodha Coin',
                'url' => 'https://coin.zerodha.com/mf/elss?ref=rpk',
                'is_active' => true,
                'sort_order' => 8,
                'clicks' => 1567,
            ],
            [
                'label' => 'Index Funds (Nifty 50)',
                'category' => 'Mutual Funds',
                'partner' => 'Groww',
                'url' => 'https://groww.in/mutual-funds/index-funds/nifty-50?ref=rpk',
                'is_active' => true,
                'sort_order' => 9,
                'clicks' => 1342,
            ],
            [
                'label' => 'International Funds (US/Global)',
                'category' => 'Mutual Funds',
                'partner' => 'ET Money',
                'url' => 'https://www.etmoney.com/mutual-funds/international?ref=rpk',
                'is_active' => true,
                'sort_order' => 10,
                'clicks' => 789,
            ],
            [
                'label' => 'REITs (Real Estate Investment Trusts)',
                'category' => 'Real Estate',
                'partner' => 'PropertyShare',
                'url' => 'https://www.propertyshare.in/reits?ref=rpk',
                'is_active' => true,
                'sort_order' => 11,
                'clicks' => 324,
            ],
            [
                'label' => 'Fractional Real Estate',
                'category' => 'Real Estate',
                'partner' => 'hBits',
                'url' => 'https://hbits.in/fractional-ownership?ref=rpk',
                'is_active' => true,
                'sort_order' => 12,
                'clicks' => 287,
            ],
            [
                'label' => 'P2P Lending',
                'category' => 'Alternative',
                'partner' => 'LenDenClub',
                'url' => 'https://www.lendenclub.com/invest?ref=rpk',
                'is_active' => false,
                'sort_order' => 13,
                'clicks' => 156,
            ],
            [
                'label' => 'Invoice Discounting',
                'category' => 'Alternative',
                'partner' => 'TradeCred',
                'url' => 'https://www.tradecred.com/invoice-discounting?ref=rpk',
                'is_active' => false,
                'sort_order' => 14,
                'clicks' => 98,
            ],
        ];

        foreach ($partners as $data) {
            InvestmentPartner::create($data);
        }
    }
}