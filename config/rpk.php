<?php

return [
    // Prices live on the server only. The page just displays what /api/report/state returns.
    'report_price'  => 499,
    'session_price' => 1000,
    'ref_pts'       => 100,   // minimum report points before they can be redeemed (1 point = Rs 1)
    'report_days'   => 365,   // how long a Premium Report purchase stays valid

    // [points, price in rupees]
    'packs' => [[200, 200], [1000, 500], [5000, 1000]],

    'payu' => [
        'key'  => env('PAYU_KEY'),
        'salt' => env('PAYU_SALT'),
        'env'  => env('PAYU_ENV', 'test'),      // test | live
        // Local testing only: with no key set, mark payments as paid without PayU. Ignored unless APP_ENV=local.
        'fake' => (bool) env('PAYU_FAKE', false),
    ],
];