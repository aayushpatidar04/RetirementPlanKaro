<?php

/**
 * Single source of truth for the permission matrix.
 * Roles page and Team page both read this (before, the list was copy-pasted 3 times inside the views).
 * Format: group => [ label shown in UI => permission key stored on the role ]
 */
return [
    'groups' => [
        'Overview' => ['Home (Dashboard)' => 'Home'],
        'Clients' => ['Client Records' => 'Customers', 'Prospects' => 'Leads', 'Transactions' => 'Payments'],
        'Business Development' => ['Get Quotes' => 'Get Quotes', 'Advisory Sessions' => 'Sessions', 'Referrals' => 'Referrals', 'Messages & Email' => 'Messages & Email'],
        'Pricing & Incentives' => ['Discount Codes' => 'Coupons', 'Settings' => 'Pricing & rewards'],
        'Website Content' => ['Investment Partners' => 'One Window Investing', 'Testimonials' => 'Testimonials'],
        'Administration' => ['Published Versions' => 'Website versions', 'Audit Trail' => 'Audit log'],
        'Access Control' => ['Team Members' => 'Team', 'Roles & Permissions' => 'Roles'],
    ],

    // key => label
    'special' => [
        '@export' => 'Download Excel / export data',
        '@publish' => 'Publish changes to website',
    ],
];