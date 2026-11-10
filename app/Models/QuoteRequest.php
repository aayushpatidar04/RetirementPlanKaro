<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_type',
        'customer_name',
        'customer_mobile',
        'customer_email',
        'customer_city',
        'details',
        'note',
        'status',
        'consent',
    ];

    protected $casts = [
        'details' => 'array',
        'consent' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function statuses(): array
    {
        return [
            'New',
            'Quote shared',
            'Follow-up',
            'Converted',
            'Lost',
        ];
    }

    public static function productTypes(): array
    {
        return [
            'Term Insurance',
            'Health Insurance',
            'Car / Bike Insurance',
            'Credit Card',
            'Personal Loan',
            'Loan Against Mutual Fund',
        ];
    }

    public static function quoteFields(): array
    {
        return [
            'Term Insurance' => [
                ['key' => 'dob', 'label' => 'Date of birth', 'type' => 'date'],
                ['key' => 'gen', 'label' => 'Gender', 'type' => 'select', 'options' => ['Male', 'Female']],
                ['key' => 'tob', 'label' => 'Tobacco / smoker', 'type' => 'select', 'options' => ['No', 'Yes']],
                ['key' => 'inc', 'label' => 'Annual income (₹)', 'type' => 'number'],
                ['key' => 'occ', 'label' => 'Occupation', 'type' => 'select', 'options' => ['Salaried', 'Self-employed', 'Business']],
                ['key' => 'cover', 'label' => 'Cover needed (₹)', 'type' => 'number'],
                ['key' => 'till', 'label' => 'Cover till age', 'type' => 'number'],
                ['key' => 'edu', 'label' => 'Education', 'type' => 'text'],
                ['key' => 'ex', 'label' => 'Existing life cover', 'type' => 'select', 'options' => ['None', 'Yes']],
            ],
            'Health Insurance' => [
                ['key' => 'ty', 'label' => 'Cover type', 'type' => 'select', 'options' => ['Family floater', 'Individual']],
                ['key' => 'mem', 'label' => 'Members & ages (e.g. Self 34, Spouse 32, Son 6)', 'type' => 'text'],
                ['key' => 'pin', 'label' => 'Pincode', 'type' => 'text'],
                ['key' => 'si', 'label' => 'Sum insured (₹)', 'type' => 'number'],
                ['key' => 'ped', 'label' => 'Pre-existing disease', 'type' => 'select', 'options' => ['No', 'Yes']],
                ['key' => 'ped2', 'label' => 'Disease details (if yes)', 'type' => 'text'],
                ['key' => 'par', 'label' => 'Parents covered', 'type' => 'select', 'options' => ['No', 'Yes']],
                ['key' => 'ex', 'label' => 'Existing policy', 'type' => 'select', 'options' => ['No', 'Yes']],
            ],
            'Car / Bike Insurance' => [
                ['key' => 'v', 'label' => 'Vehicle', 'type' => 'select', 'options' => ['Car', 'Bike']],
                ['key' => 'mm', 'label' => 'Make / model / variant', 'type' => 'text'],
                ['key' => 'rno', 'label' => 'Registration no.', 'type' => 'text'],
                ['key' => 'yr', 'label' => 'Registration year', 'type' => 'number'],
                ['key' => 'pins', 'label' => 'Previous insurer', 'type' => 'text'],
                ['key' => 'pexp', 'label' => 'Policy expiry', 'type' => 'date'],
                ['key' => 'ncb', 'label' => 'NCB', 'type' => 'select', 'options' => ['0%', '20%', '25%', '35%', '45%', '50%']],
                ['key' => 'ty', 'label' => 'Plan', 'type' => 'select', 'options' => ['Comprehensive', 'Third party']],
            ],
            'Credit Card' => [
                ['key' => 'emp', 'label' => 'Employment', 'type' => 'select', 'options' => ['Salaried', 'Self-employed', 'Business']],
                ['key' => 'inc', 'label' => 'Annual income (₹)', 'type' => 'number'],
                ['key' => 'cib', 'label' => 'CIBIL range', 'type' => 'select', 'options' => ['Not sure', '750+', '700-749', '650-699', 'Below 650']],
                ['key' => 'ncards', 'label' => 'Existing cards (count)', 'type' => 'number'],
                ['key' => 'use', 'label' => 'Main spend', 'type' => 'select', 'options' => ['Shopping', 'Travel', 'Fuel', 'Dining', 'Rewards / Cashback']],
                ['key' => 'fee', 'label' => 'Annual fee', 'type' => 'select', 'options' => ['Free only', 'Up to ₹1,000', 'Any']],
            ],
            'Personal Loan' => [
                ['key' => 'amt', 'label' => 'Loan amount (₹)', 'type' => 'number'],
                ['key' => 'ten', 'label' => 'Tenure (months)', 'type' => 'number'],
                ['key' => 'emp', 'label' => 'Employment', 'type' => 'select', 'options' => ['Salaried', 'Self-employed', 'Business']],
                ['key' => 'inc', 'label' => 'Monthly income (₹)', 'type' => 'number'],
                ['key' => 'co', 'label' => 'Company / business', 'type' => 'text'],
                ['key' => 'emi', 'label' => 'Existing EMIs / month (₹)', 'type' => 'number'],
                ['key' => 'cib', 'label' => 'CIBIL range', 'type' => 'select', 'options' => ['Not sure', '750+', '700-749', '650-699', 'Below 650']],
                ['key' => 'pur', 'label' => 'Purpose', 'type' => 'text'],
            ],
            'Loan Against Mutual Fund' => [
                ['key' => 'pv', 'label' => 'Portfolio value (₹)', 'type' => 'number'],
                ['key' => 'ft', 'label' => 'Fund type', 'type' => 'select', 'options' => ['Equity', 'Debt', 'Hybrid', 'Mixed']],
                ['key' => 'rta', 'label' => 'Units held with', 'type' => 'select', 'options' => ['CAMS', 'KFintech', 'Not sure']],
                ['key' => 'amt', 'label' => 'Loan required (₹)', 'type' => 'number'],
                ['key' => 'ten', 'label' => 'Tenure (months)', 'type' => 'number'],
                ['key' => 'pan', 'label' => 'PAN (last 4 digits)', 'type' => 'text'],
                ['key' => 'pur', 'label' => 'Purpose', 'type' => 'text'],
            ],
        ];
    }
}