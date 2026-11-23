<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * The WhatsApp/Email popups on Transactions, Prospects, Quote Requests and the client page
 * used templates written into each page. They now use Messages & Email templates, so the
 * ones that were only in the pages are added here (a template with the same channel + name
 * that already exists is left as it is).
 */
return new class extends Migration
{
    private const TEMPLATES = array (
  0 => 
  array (
    'name' => 'Welcome',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Namaste {name}

Retirement Plan Karo me aapka swagat hai! Aapke account me 600 welcome points add ho gaye hain.

Apna free retirement plan banayein {link}
– Team Retirement Plan Karo',
  ),
  1 => 
  array (
    'name' => 'Plan incomplete reminder',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Hi {name},

Aapne Retirement Plan Karo par account banaya tha, lekin abhi tak apna retirement plan complete nahi kiya.

Sirf 4 simple steps, 5 minute
Free retirement corpus & SIP calculation
600 welcome points aapke account me wait kar rahe hain

Abhi plan banayein: {link}

Koi sawal ho to bas reply karein.
– Team Retirement Plan Karo',
  ),
  2 => 
  array (
    'name' => 'Payment failed',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Hi {name},

Aapka {purpose} payment complete nahi ho paya.

Koi baat nahi Aap yahan se dobara try kar sakte hain: {link}

Agar paise kat gaye hain to 2–3 din me auto-refund ho jayenge. Madad chahiye to reply karein.
– Team Retirement Plan Karo',
  ),
  3 => 
  array (
    'name' => 'Report ready',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Hi {name}, aapki Premium Retirement Report ready hai
Download karein: {link}
– Team Retirement Plan Karo',
  ),
  4 => 
  array (
    'name' => 'Session confirmation',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Hi {name}, aapka guidance session confirm ho gaya hai.

Hamari team aapko call / video link share karegi. Kisi badlav ke liye bas reply karein.
– Team Retirement Plan Karo',
  ),
  5 => 
  array (
    'name' => 'Hot lead follow-up',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Hi {name}, aapne retirement guidance me interest dikhaya tha

Kya hum kal ek chhota call fix kar dein? Aapko kaunsa time suit karega? Reply karein.
– Team Retirement Plan Karo',
  ),
  6 => 
  array (
    'name' => 'Inactive user nudge',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Hi {name}, kaafi din se aap Retirement Plan Karo par nahi aaye.

Aapka plan wahin save hai — 2 minute me update karein {link}
– Team Retirement Plan Karo',
  ),
  7 => 
  array (
    'name' => 'Coupon / promotion',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Hi {name}

Sirf aapke liye special offer: coupon code *{coupon}* use karein aur Premium Report / Guidance Session par discount payein.

Abhi use karein {link}
– Team Retirement Plan Karo',
  ),
  8 => 
  array (
    'name' => 'Greeting / follow-up',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Namaste {name}

Retirement Plan Karo se baat kar rahe hain. Aapke retirement plan me madad chahiye to bas reply karein.
– Team Retirement Plan Karo',
  ),
  9 => 
  array (
    'name' => 'Welcome email',
    'channel' => 'em',
    'subject' => 'Welcome to Retirement Plan Karo, {name}!',
    'body' => 'Hi {name},

Retirement Plan Karo me aapka swagat hai!

Aapke account me 600 welcome points add ho gaye hain. Sirf 5 minute me aap ye sab kar sakte hain:
  • Apna retirement corpus aur SIP calculate karein
  • Life goals aur family ka plan banayein
  • Free calculators (SIP, Tax, Home Loan EMI) use karein

Abhi shuru karein: {link}

Koi bhi sawal ho to is mail ka reply karein, hum madad karenge.

Warm regards,
Team Retirement Plan Karo
retirementplankaro.com',
  ),
  10 => 
  array (
    'name' => 'Payment failed',
    'channel' => 'em',
    'subject' => 'Aapka {purpose} payment complete nahi hua',
    'body' => 'Hi {name},

Aapka {purpose} payment complete nahi ho paya. Koi baat nahi, aap dobara try kar sakte hain: {link}

Dhyan dein:
 • Agar paise kat gaye hain to 2–3 din me auto-refund ho jayenge.
 • Payment dobara fail ho to UPI ya card badal kar try karein.

Agar koi dikkat ho to hume is mail ka reply karein.

Warm regards,
Team Retirement Plan Karo
retirementplankaro.com',
  ),
  11 => 
  array (
    'name' => 'Hot lead follow-up',
    'channel' => 'em',
    'subject' => '{name} kya hum aapke retirement plan par baat karein?',
    'body' => 'Hi {name},

Aapne retirement guidance me interest dikhaya tha, isliye hum follow-up kar rahe hain.

Ek chhote 20–30 minute ke call me hum:
• Aapka retirement corpus aur gap samjhayenge
• Aapke liye sahi SIP / investment mix batayenge
• Aapke sawalon ke jawab denge

Bas bataiye aapko kaunsa din aur time suit karega.

Warm regards,
Team Retirement Plan Karo
retirementplankaro.com',
  ),
  12 => 
  array (
    'name' => 'Festival wishes',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Hi {name}, aapko aur parivaar ko tyohaar ki hardik shubhkamnayein
Is saal apne retirement ko bhi surakshit banayein {link}
– Team Retirement Plan Karo',
  ),
  13 => 
  array (
    'name' => 'Referral update',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Congratulations {name},

Aapke referral link se naye signups hue hain.

Points check karein, Aur dosto ko invite karein: {link}
– Team Retirement Plan Karo',
  ),
  14 => 
  array (
    'name' => 'Quote · Term Insurance',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Hi {name}, aapki Term Insurance request ke liye shukriya

Aapke details ke hisaab se best options:
1) ______ – ₹____ /year
2) ______ – ₹____ /year

Cover aur premium compare karke plan select karein.
Agle step ke liye bas reply karein.
– Team Retirement Plan Karo',
  ),
  15 => 
  array (
    'name' => 'Quote · Health Insurance',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Hi {name}, aapki Health Insurance request ke liye shukriya

Aapke details ke hisaab se best options:
1) ______ – ₹____ /year
2) ______ – ₹____ /year

Cover, network hospitals aur waiting period compare karein.
Agle step ke liye bas reply karein.
– Team Retirement Plan Karo',
  ),
  16 => 
  array (
    'name' => 'Quote · Car / Bike Insurance',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Hi {name}, aapki Car / Bike Insurance request ke liye shukriya

Aapke details ke hisaab se best options:
1) ______ – ₹____ /year
2) ______ – ₹____ /year

Aapki policy expiry se pehle renew karna best rahega.
Agle step ke liye bas reply karein.
– Team Retirement Plan Karo',
  ),
  17 => 
  array (
    'name' => 'Quote · Credit Card',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Hi {name}, aapki Credit Card request ke liye shukriya

Aapke details ke hisaab se best options:
1) ______ – ₹____ /year
2) ______ – ₹____ /year

Fees, rewards aur eligibility compare karein.
Agle step ke liye bas reply karein.
– Team Retirement Plan Karo',
  ),
  18 => 
  array (
    'name' => 'Quote · Personal Loan',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Hi {name}, aapki Personal Loan request ke liye shukriya

Aapke details ke hisaab se best options:
1) ______ – ₹____ /year
2) ______ – ₹____ /year

Interest rate aur processing fee compare karein.
Agle step ke liye bas reply karein.
– Team Retirement Plan Karo',
  ),
  19 => 
  array (
    'name' => 'Quote · Loan Against Mutual Fund',
    'channel' => 'wa',
    'subject' => NULL,
    'body' => 'Hi {name}, aapki Loan Against Mutual Fund request ke liye shukriya

Aapke details ke hisaab se best options:
1) ______ – ₹____ /year
2) ______ – ₹____ /year

Aapke funds becheye bina low-interest loan mil sakta hai.
Agle step ke liye bas reply karein.
– Team Retirement Plan Karo',
  ),
  20 => 
  array (
    'name' => 'Plan incomplete reminder',
    'channel' => 'em',
    'subject' => '{name}, aapka retirement plan adhura hai',
    'body' => 'Hi {name},

Aapne Retirement Plan Karo par account banaya tha, lekin plan abhi complete nahi hua. Sirf 4 simple steps baaki hain:
  Net worth aur expenses
  Retirement age aur investment
  Life goals
  Free report aur SIP suggestion

Plan complete karne ke liye yahan click karein: {link}

Aapke 600 welcome points bhi wahin wait kar rahe hain.

Warm regards,
Team Retirement Plan Karo
retirementplankaro.com',
  ),
  21 => 
  array (
    'name' => 'Report ready',
    'channel' => 'em',
    'subject' => 'Aapki Premium Retirement Report ready hai',
    'body' => 'Hi {name},

Aapki Premium Retirement Report ready hai.

Isme aapko milega:
• Corpus needed aur shortfall ka poora hisaab
• Monthly SIP aur SWP income plan
• Goal-wise readiness

Report download karein: {link}

Report samajhne me madad chahiye to guidance session book kar sakte hain.

Warm regards,
Team Retirement Plan Karo
retirementplankaro.com',
  ),
  22 => 
  array (
    'name' => 'Session confirmation',
    'channel' => 'em',
    'subject' => 'Aapka guidance session confirm ho gaya',
    'body' => 'Hi {name},

Aapka guidance session confirm ho gaya hai.

Kya karein:
• Session ke time par phone / video par available rahein
• Apna planner aur report saath rakhein
• Koi sawal ho to pehle se likh lein

Hamari team call / video link WhatsApp par share karegi. Badlav ke liye is mail ka reply karein.

Warm regards,
Team Retirement Plan Karo
retirementplankaro.com',
  ),
  23 => 
  array (
    'name' => 'Inactive user nudge',
    'channel' => 'em',
    'subject' => '{name}, aapka plan aapka intezaar kar raha hai',
    'body' => 'Hi {name},

Kaafi din se aap Retirement Plan Karo par nahi aaye. Aapka plan wahin save hai.

Naya kya hai:
• Income Tax Calculator (New Regime FY 2026-27)
• SIP aur Home Loan EMI Calculators
• Budget Planner

Wapas aayein: {link}

Warm regards,
Team Retirement Plan Karo
retirementplankaro.com',
  ),
  24 => 
  array (
    'name' => 'Coupon / promotion',
    'channel' => 'em',
    'subject' => 'Aapke liye special coupon: LAUNCH20',
    'body' => 'Hi {name},

Aapke liye ek special offer.

Coupon Code: LAUNCH20
Laagu hai: Premium Report aur Guidance Session par.

Checkout ke time ye code daalein: {link}

Offer limited time ke liye hai, isliye der na karein.

Warm regards,
Team Retirement Plan Karo
retirementplankaro.com',
  ),
  25 => 
  array (
    'name' => 'Festival wishes',
    'channel' => 'em',
    'subject' => 'Tyohaar ki hardik shubhkamnayein, {name}!',
    'body' => 'Hi {name},

Aapko aur aapke parivaar ko tyohaar ki hardik shubhkamnayein.

Is tyohaar par apne aur parivaar ke surakshit bhavishya ka sankalp lein. Aapka retirement plan banane me hum madad ke liye taiyar hain.

Shuruaat karein: {link}

Warm regards,
Team Retirement Plan Karo
retirementplankaro.com',
  ),
  26 => 
  array (
    'name' => 'Referral update',
    'channel' => 'em',
    'subject' => 'Aapke dost join kar chuke hain',
    'body' => 'Hi {name},

Shukriya! Aapke referral link se ab tak {referral_count} dost join kar chuke hain ({referral_names}).

Aapko {points} points mile hain. Aur dosto ko invite karne ke liye apna link share karein:
{link}

Jitne zyada dost, utne zyada rewards!

Warm regards,
Team Retirement Plan Karo
retirementplankaro.com',
  ),
  27 => 
  array (
    'name' => 'Quote · Term Insurance',
    'channel' => 'em',
    'subject' => 'Aapke Term Insurance quotes',
    'body' => 'Hi {name},

Aapne hamare paas Term Insurance ke liye quote request bheji thi, uske liye dhanyavaad. Aapke diye gaye details ke aadhar par humne best options shortlist kiye hain:

1) {plan_1_name} – ₹{plan_1_premium}/year
2) {plan_2_name} – ₹{plan_2_premium}/year

Cover aur premium compare karke plan select karein.

Agle step ke liye aapko ID proof, address proof, income proof (salary slip / ITR) aur recent photo chahiye hongi. Aap inhe is mail ke reply me ya WhatsApp par bhej sakte hain.

Koi sawal ho ya options compare karne me madad chahiye to bataiye, hum call par samjha denge.

Warm regards,
Team Retirement Plan Karo
retirementplankaro.com',
  ),
  28 => 
  array (
    'name' => 'Quote · Health Insurance',
    'channel' => 'em',
    'subject' => 'Aapke Health Insurance quotes',
    'body' => 'Hi {name},

Aapne hamare paas Health Insurance ke liye quote request bheji thi, uske liye dhanyavaad. Aapke diye gaye details ke aadhar par humne best options shortlist kiye hain:

1) {option_1_name} – ₹{option_1_premium}/year
2) {option_2_name} – ₹{option_2_premium}/year

Cover, network hospitals aur waiting period compare karein.

Agle step ke liye aapko sabhi members ki age aur ID proof, aur kisi pehle se chal rahi bimari ki jaankari chahiye hongi. Aap inhe is mail ke reply me ya WhatsApp par bhej sakte hain.

Koi sawal ho ya options compare karne me madad chahiye to bataiye, hum call par samjha denge.

Warm regards,
Team Retirement Plan Karo
retirementplankaro.com',
  ),
  29 => 
  array (
    'name' => 'Quote · Car / Bike Insurance',
    'channel' => 'em',
    'subject' => 'Aapke Car / Bike Insurance quotes',
    'body' => 'Hi {name},

Aapne hamare paas Car / Bike Insurance ke liye quote request bheji thi, uske liye dhanyavaad. Aapke diye gaye details ke aadhar par humne best options shortlist kiye hain:

1) {option_1_name} – ₹{option_1_premium}/year
2) {option_2_name} – ₹{option_2_premium}/year

Aapki policy expiry se pehle renew karna best rahega.

Agle step ke liye aapko RC copy, purani policy ki copy aur ID proof chahiye hongi. Aap inhe is mail ke reply me ya WhatsApp par bhej sakte hain.

Koi sawal ho ya options compare karne me madad chahiye to bataiye, hum call par samjha denge.

Warm regards,
Team Retirement Plan Karo
retirementplankaro.com',
  ),
  30 => 
  array (
    'name' => 'Quote · Credit Card',
    'channel' => 'em',
    'subject' => 'Aapke Credit Card quotes',
    'body' => 'Hi {name},

Aapne hamare paas Credit Card ke liye quote request bheji thi, uske liye dhanyavaad. Aapke diye gaye details ke aadhar par humne best options shortlist kiye hain:

1) {option_1_name} – ₹{option_1_fee}/year
2) {option_2_name} – ₹{option_2_fee}/year

Fees, rewards aur eligibility compare karein.

Agle step ke liye aapko PAN, Aadhaar aur income proof (salary slip / ITR) chahiye hongi. Aap inhe is mail ke reply me ya WhatsApp par bhej sakte hain.

Koi sawal ho ya options compare karne me madad chahiye to bataiye, hum call par samjha denge.

Warm regards,
Team Retirement Plan Karo
retirementplankaro.com',
  ),
  31 => 
  array (
    'name' => 'Quote · Personal Loan',
    'channel' => 'em',
    'subject' => 'Aapke Personal Loan quotes',
    'body' => 'Hi {name},

Aapne hamare paas Personal Loan ke liye quote request bheji thi, uske liye dhanyavaad. Aapke diye gaye details ke aadhar par humne best options shortlist kiye hain:

1) {option_1_name} – ₹{option_1_rate}/year
2) {option_2_name} – ₹{option_2_rate}/year

Interest rate aur processing fee compare karein.

Agle step ke liye aapko PAN, Aadhaar, 3 mahine ki salary slip aur 6 mahine ka bank statement chahiye hongi. Aap inhe is mail ke reply me ya WhatsApp par bhej sakte hain.

Koi sawal ho ya options compare karne me madad chahiye to bataiye, hum call par samjha denge.

Warm regards,
Team Retirement Plan Karo
retirementplankaro.com',
  ),
  32 => 
  array (
    'name' => 'Quote · Loan Against Mutual Fund',
    'channel' => 'em',
    'subject' => 'Aapke Loan Against Mutual Fund quotes',
    'body' => 'Hi {name},

Aapne hamare paas Loan Against Mutual Fund ke liye quote request bheji thi, uske liye dhanyavaad. Aapke diye gaye details ke aadhar par humne best options shortlist kiye hain:

1) {option_1_name} – ₹{option_1_rate}/year
2) {option_2_name} – ₹{option_2_rate}/year

Aapke funds beche bina low-interest loan mil sakta hai.

Agle step ke liye aapko PAN, Aadhaar aur mutual fund holdings statement (CAS) chahiye hongi. Aap inhe is mail ke reply me ya WhatsApp par bhej sakte hain.

Koi sawal ho ya options compare karne me madad chahiye to bataiye, hum call par samjha denge.

Warm regards,
Team Retirement Plan Karo
retirementplankaro.com',
  ),
);

    public function up(): void
    {
        $have = DB::table('message_templates')->get(['channel', 'name'])
            ->map(fn ($t) => $t->channel . '|' . mb_strtolower(trim($t->name)))->flip();

        foreach (self::TEMPLATES as $t) {
            if (isset($have[$t['channel'] . '|' . mb_strtolower(trim($t['name']))])) {
                continue;
            }
            DB::table('message_templates')->insert([
                'name' => $t['name'],
                'channel' => $t['channel'],
                'subject' => $t['subject'],
                'body' => $t['body'],
                'is_default' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // imported templates may have been edited since; leave them
    }
};
