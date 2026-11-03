<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $pageTitle ?? 'Retirement Plan Karo – Retirement Planner for India' }}</title>
<meta name="description" content="{{ $pageDescription ?? 'Retirement Plan Karo is a retirement planner for India. Work out your net worth, expenses and retirement fund, then see a year-by-year withdrawal table with your life goals. Sign up to save and download.' }}">
<meta name="color-scheme" content="light">
<meta name="theme-color" content="#050E1A">
<meta property="og:title" content="{{ $pageTitle ?? 'Retirement Plan Karo – Retirement Planner for India' }}">
<meta property="og:description" content="{{ $pageDescription ?? 'Know your number, then plan withdrawals and life goals year by year. Private, and calculations run in your browser.' }}">
<meta property="og:type" content="website">
<link rel="canonical" href="{{ url()->current() }}">

@verbatim
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "WebApplication", "name": "Retirement Plan Karo", "description": "Retirement planner for India with net worth, expenses, retirement corpus and a year-by-year SWP table with life goals.", "applicationCategory": "FinanceApplication", "operatingSystem": "Any", "inLanguage": "en-IN", "offers": {"@type": "Offer", "price": "499", "priceCurrency": "INR", "description": "Premium Personalized Report"}}</script>
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [{"@type": "Question", "name": "How much money do I need to retire?", "acceptedAnswer": {"@type": "Answer", "text": "It depends on your expenses, your retirement age and how long you want your money to last. A common rule of thumb is 25 times your yearly expenses at retirement. For your own number, use Step 3, which adds up every future withdrawal after inflation."}}, {"@type": "Question", "name": "When should I start planning for retirement?", "acceptedAnswer": {"@type": "Answer", "text": "As early as you can. Time is the biggest factor in compounding, and a few years of delay can cost a large share of your final fund."}}, {"@type": "Question", "name": "How much of my income should I save?", "acceptedAnswer": {"@type": "Answer", "text": "A common starting point is 20% of your take-home income, and more if you start late. Step 2 shows your saving rate and how cutting expenses can raise it."}}, {"@type": "Question", "name": "Is the 4% rule right for India?", "acceptedAnswer": {"@type": "Answer", "text": "The 4% rule comes from US data. Indian inflation has been higher, and retirements are getting longer, so many planners start lower, around 3% to 3.5%. Step 4 tests your own numbers and shows a safe starting withdrawal."}}, {"@type": "Question", "name": "What return should I assume?", "acceptedAnswer": {"@type": "Answer", "text": "Use a number you would be comfortable with if markets disappoint. Long-term equity returns are not guaranteed, so check what happens with a return 2% lower. Step 3 shows this."}}, {"@type": "Question", "name": "What is the difference between SIP and SWP?", "acceptedAnswer": {"@type": "Answer", "text": "A SIP puts money in every month while you build your corpus. An SWP takes money out every month once you retire."}}, {"@type": "Question", "name": "Should I invest a lump sum or a SIP?", "acceptedAnswer": {"@type": "Answer", "text": "A SIP spreads your purchases and reduces the risk of investing everything at a bad time. If you have a lump sum, many people invest it in stages over several months."}}, {"@type": "Question", "name": "Are EPF, PPF and NPS enough?", "acceptedAnswer": {"@type": "Answer", "text": "They are a useful base, but for many people they do not cover all expenses after inflation. Add them in Step 1 and compare your total with the corpus you need."}}, {"@type": "Question", "name": "How big should my emergency fund be?", "acceptedAnswer": {"@type": "Answer", "text": "About 6 months of essential expenses, in a bank account, a short-term FD or a liquid fund."}}, {"@type": "Question", "name": "What if I am already close to retirement?", "acceptedAnswer": {"@type": "Answer", "text": "Focus on safe withdrawals, health insurance, clearing loans and keeping 2 to 3 years of expenses in safe assets. Use Steps 5 and 6 to test how long your money will last."}}, {"@type": "Question", "name": "Which inflation rate should I use?", "acceptedAnswer": {"@type": "Answer", "text": "Many Indian planners use 6% for general costs. Medical costs usually rise faster, so a cautious plan uses a higher rate or a separate health budget."}}, {"@type": "Question", "name": "Is my data saved or shared?", "acceptedAnswer": {"@type": "Answer", "text": "No. All calculations run in your browser and your plan numbers are not sent anywhere. Contact details you give at sign-up, and a summary result such as your score, may be sent to us as explained in the Privacy Policy."}}, {"@type": "Question", "name": "Is this financial advice?", "acceptedAnswer": {"@type": "Answer", "text": "No. Retirement Plan Karo is an education tool. Results depend on your inputs and on assumptions that may not come true. Please talk to a SEBI-registered investment adviser or a chartered accountant before you decide."}}, {"@type": "Question", "name": "How are the calculations done?", "acceptedAnswer": {"@type": "Answer", "text": "Monthly compounding at the yearly rate divided by 12. SIPs are paid at the end of each month and withdrawals are taken at the start of each month. Every step has a \"How is this calculated?\" box."}}, {"@type": "Question", "name": "Can I pay for my child's education and marriage from my retirement SIP?", "acceptedAnswer": {"@type": "Answer", "text": "You can, but the money you take out stops growing for retirement. Step 4 lets you add each goal in the year it happens and shows whether your corpus still lasts. If it is short, raise your investment, move a goal later or lower its cost."}}]}</script>
@endverbatim
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%F0%9F%8C%85%3C/text%3E%3C/svg%3E">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{--bg:#F1F7F7;--sf:#fff;--ink:#10243A;--mu:#52667A;--ln:#D6E5E6;--br:#0F766E;--bi:#fff;--ac:#F59E0B;--gd:#059669;--bd:#DC2626;--so:#E1F1F0;--h:'Bricolage Grotesque',system-ui,sans-serif;--b:'Instrument Sans',system-ui,-apple-system,'Segoe UI',sans-serif;box-sizing:border-box;padding-top:env(safe-area-inset-top,0px);padding-bottom:env(safe-area-inset-bottom,0px)}
@media (prefers-color-scheme:dark){:root:not([data-theme="light"]){--bg:#0A1A1F;--sf:#11262C;--ink:#E6F3F2;--mu:#93AFB3;--ln:#223C42;--br:#5EEAD4;--bi:#06222A;--ac:#FBBF24;--gd:#34D399;--bd:#F87171;--so:#17333A;}}
:root[data-theme="dark"]{--bg:#0A1A1F;--sf:#11262C;--ink:#E6F3F2;--mu:#93AFB3;--ln:#223C42;--br:#5EEAD4;--bi:#06222A;--ac:#FBBF24;--gd:#34D399;--bd:#F87171;--so:#17333A;}
*,*::before,*::after{box-sizing:border-box}
html{height:100%;scroll-padding-top:calc(env(safe-area-inset-top,0px) + 70px);scroll-behavior:smooth}
body{margin:0;min-height:100%;background:var(--bg);color:var(--ink);font:16px/1.55 var(--b);-webkit-text-size-adjust:100%}
h1,h2,h3{font-family:var(--h);line-height:1.15;margin:0}
button,input,select{font:inherit;color:inherit}
:focus-visible{outline:3px solid var(--ac);outline-offset:2px;border-radius:6px}
[hidden]{display:none!important}
.w{max-width:1160px;margin:0 auto;padding:0 16px}
.skip{position:absolute;left:-999px;top:8px;background:var(--br);color:var(--bi);padding:10px 16px;border-radius:8px;z-index:99}.skip:focus{left:8px}
.hd{position:sticky;top:env(safe-area-inset-top,0px);z-index:20;background:color-mix(in srgb,var(--sf) 92%,transparent);-webkit-backdrop-filter:blur(10px);backdrop-filter:blur(10px);border-bottom:1px solid var(--ln)}
.hbar{display:flex;align-items:center;gap:10px}
.logo{display:flex;gap:10px;align-items:center;text-decoration:none;color:inherit;margin-right:auto}
.logo svg{width:36px;height:36px;flex:none}.logo b{display:block;font:700 18px var(--h)}.logo small{display:none;color:var(--mu);font-size:12px}
@media(min-width:760px){.logo small{display:block}}
.nav{display:flex;gap:2px}.nav a{padding:8px 14px;border-radius:99px;text-decoration:none;color:var(--ink);font-weight:500;font-size:15px}
.nav a:hover{background:var(--so)}.nav a[aria-current=page]{background:var(--br);color:var(--bi)}
.tb{border:1px solid var(--ln);background:var(--sf);border-radius:99px;min-height:40px;padding:0 14px;cursor:pointer;font-size:14px}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;min-height:44px;padding:10px 18px;border-radius:12px;border:1px solid var(--ln);background:var(--sf);cursor:pointer;font-weight:600;text-decoration:none;color:var(--ink);transition:transform .1s,border-color .15s}
.btn:hover{border-color:var(--br)}.btn:active{transform:scale(.97)}
.btn.pri{background:var(--br);color:var(--bi);border-color:var(--br)}
.btn.acc{background:var(--ac);color:#1B1300;border-color:var(--ac)}
.btn.lite{background:transparent;color:#fff;border-color:rgba(255,255,255,.6)}
.btn.small{min-height:38px;padding:6px 14px;font-size:14px}
.link{border:0;background:none;padding:0;color:var(--br);font-weight:600;cursor:pointer;text-decoration:underline;font-size:14px}
.hero{background:linear-gradient(135deg,#0B2A4A,#0F766E);color:#fff;position:relative;overflow:hidden}
.hero::after{content:"";position:absolute;right:-90px;bottom:-170px;width:440px;height:440px;border-radius:50%;background:radial-gradient(circle,rgba(245,165,36,.55),transparent 65%)}
.hero .w{position:relative;z-index:1;padding-top:52px;padding-bottom:56px}
.hero h1{font-size:clamp(32px,6vw,56px);letter-spacing:-.03em;max-width:15ch}
.hero p{max-width:50ch;color:#DCE6FA;margin:14px 0 0;font-size:18px}
.cta{display:flex;gap:12px;flex-wrap:wrap;margin-top:24px}.hero .tr{font-size:14px;margin-top:18px;color:#BFD0F2}
#planner{padding-top:26px;padding-bottom:40px}
.pills{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:20px}
.pill{display:flex;gap:10px;align-items:center;padding:10px 12px;border:1px solid var(--ln);background:var(--sf);border-radius:14px;cursor:pointer;text-align:left;min-height:56px}
.pill i{font-style:normal;flex:none;display:grid;place-items:center;width:30px;height:30px;border-radius:50%;background:var(--so);font:700 14px var(--h)}
.pill b{font-size:14px;font-weight:600}
.pill[aria-current=step]{background:var(--br);color:var(--bi);border-color:var(--br)}.pill[aria-current=step] i{background:rgba(255,255,255,.22)}
.pill.done:not([aria-current=step]) i{background:var(--gd);color:#fff}
@media(max-width:640px){.pill{flex-direction:column;text-align:center;gap:4px;padding:8px 2px}.pill b{font-size:12px}}
.sh h2{font-size:clamp(24px,4vw,34px);letter-spacing:-.02em}.sh p{color:var(--mu);margin:6px 0 18px;max-width:68ch}
.cols{display:grid;gap:16px}
@media(min-width:960px){.cols{grid-template-columns:5fr 6fr;align-items:start}.res{position:sticky;top:84px}}
.panel{background:var(--sf);border:1px solid var(--ln);border-radius:18px;padding:20px}
.panel h3{font-size:17px;margin:0 0 12px}.panel h3.sp{margin-top:20px;padding-top:16px;border-top:1px solid var(--ln)}
.fg{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:0 16px}
.fd{margin-bottom:14px;min-width:0}.fd label{display:block;font-size:14px;font-weight:500;margin-bottom:5px}
.in{display:flex;align-items:center;border:1px solid var(--ln);background:var(--bg);border-radius:10px;padding:0 10px}
.in:focus-within{border-color:var(--br);box-shadow:0 0 0 3px color-mix(in srgb,var(--br) 22%,transparent)}
.in input{flex:1;min-width:0;border:0;background:none;padding:10px 4px;outline:none;font-variant-numeric:tabular-nums}
.in i{font-style:normal;color:var(--mu);font-size:14px;white-space:nowrap}
.fd small{display:block;color:var(--mu);font-size:12px;margin-top:3px}
.er{display:flex;gap:10px;align-items:flex-end}.er .fd{flex:1}.es{display:flex;gap:6px;align-items:center;min-height:44px;margin-bottom:14px;font-size:13px;color:var(--mu);white-space:nowrap}
.es input{width:18px;height:18px;accent-color:var(--br)}
.row{display:flex;gap:10px;flex-wrap:wrap;align-items:center}
.nr{display:flex;justify-content:space-between;gap:10px;margin-top:18px;flex-wrap:wrap}
.hl{background:linear-gradient(135deg,#0B2A4A,#0F766E);color:#fff;border-radius:18px;padding:20px}
.hl small{display:block;color:#C9D8F6;font-size:14px}.hl b{display:block;font:700 clamp(32px,6vw,46px)/1.05 var(--h);letter-spacing:-.02em;margin:6px 0}.hl p{margin:0;color:#DCE6FA;font-size:14.5px}
.sg{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:10px;margin:12px 0}
.st{background:var(--sf);border:1px solid var(--ln);border-radius:14px;padding:12px 14px}.st span{display:block;color:var(--mu);font-size:13px}.st b{font:700 20px var(--h);font-variant-numeric:tabular-nums}
.st.g b{color:var(--gd)}.st.b b{color:var(--bd)}
.mix{display:flex;height:16px;border-radius:99px;overflow:hidden;background:var(--so);margin:10px 0}.mix i{display:block;height:100%}
.lg{display:grid;gap:6px;font-size:14px}.lg div{display:flex;gap:8px;align-items:center}.lg i{width:12px;height:12px;border-radius:3px;flex:none}.lg span{margin-left:auto;color:var(--mu)}
.meter{height:12px;border-radius:99px;background:var(--so);overflow:hidden;margin:8px 0}.meter i{display:block;height:100%;background:var(--gd);border-radius:99px;transition:width .3s}
.msg{background:var(--so);border-radius:14px;padding:14px 16px;color:var(--ink)}
.tips{margin:8px 0 0;padding-left:20px;color:var(--mu);font-size:14.5px}.tips li{margin:5px 0}
.ctl{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:0 16px;align-items:end}
.sel{width:100%;border:1px solid var(--ln);border-radius:10px;background:var(--bg);padding:10px;min-height:44px}
.ch svg{width:100%;height:auto;display:block}.ch text{fill:var(--mu);font-size:11px;font-family:var(--b)}
.tw{overflow:auto;max-height:70vh;border:1px solid var(--ln);border-radius:12px;background:var(--sf)}
table{border-collapse:collapse;width:100%;min-width:880px;font-size:14px;font-variant-numeric:tabular-nums}
th,td{padding:8px 10px;text-align:right;border-bottom:1px solid var(--ln);white-space:nowrap}
th:first-child,td:first-child{text-align:left}
thead th{position:sticky;top:0;background:var(--so);z-index:2;font-weight:600}
td small{display:block;color:var(--mu);font-size:11px}
tr.rt td{background:color-mix(in srgb,var(--ac) 22%,transparent)}
tr.neg td.c{color:var(--bd);font-weight:700}
td.c{font-weight:600}
.gc{display:flex;gap:6px;justify-content:flex-end}.gi{width:112px;padding:6px 8px;border:1px solid var(--ln);border-radius:8px;background:var(--bg)}.gi[data-t=name]{width:136px}
.only tr.pre{display:none}
.pg{padding-top:34px;padding-bottom:50px}.pg .sh{margin-bottom:6px}
.chips{display:flex;gap:8px;flex-wrap:wrap;margin:0 0 16px}
.chip{border:1px solid var(--ln);background:var(--sf);border-radius:99px;padding:6px 16px;min-height:40px;cursor:pointer;font-weight:500}
.chip:hover{border-color:var(--br)}.chip[aria-pressed=true],.chip[aria-selected=true]{background:var(--br);color:var(--bi);border-color:var(--br)}
.lgrid{display:grid;gap:12px;align-items:start}@media(min-width:820px){.lgrid{grid-template-columns:1fr 1fr}}
details.art{background:var(--sf);border:1px solid var(--ln);border-radius:14px}details.art[open],details.art:hover{border-color:var(--br)}
details.art summary{padding:15px 18px;cursor:pointer;font-weight:600;list-style:none;display:flex;gap:10px;align-items:center;min-height:56px}
details.art summary::-webkit-details-marker{display:none}details.art summary::after{content:"+";margin-left:auto;font-size:24px;color:var(--br)}details.art[open] summary::after{content:"–"}
details.art .body{padding:0 18px 18px;color:var(--mu)}details.art .body p{margin:0 0 10px}.do{color:var(--ink)}
.catg{font-size:12px;font-weight:600;padding:3px 9px;border-radius:99px;background:var(--so);color:var(--br);white-space:nowrap}
.myths{display:grid;gap:12px;grid-template-columns:repeat(auto-fit,minmax(260px,1fr))}
.myth{background:var(--sf);border:1px solid var(--ln);border-radius:14px;padding:16px}.myth .m{color:var(--bd);font-weight:600;margin:0 0 8px}.myth .f{margin:0;color:var(--mu)}.myth .f b{color:var(--gd)}
.gsearch{width:100%;max-width:440px;padding:12px 14px;border:1px solid var(--ln);border-radius:12px;background:var(--sf);min-height:44px}
.glist{display:grid;gap:10px;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));margin:14px 0 0;padding:0}
.gterm{background:var(--sf);border:1px solid var(--ln);border-radius:12px;padding:12px 14px}.gterm dt{font-weight:700}.gterm dd{margin:2px 0 0;color:var(--mu);font-size:14.5px}
.ckpanel{background:var(--sf);border:1px solid var(--ln);border-radius:16px;padding:8px 18px}
.ck{display:flex;gap:12px;align-items:flex-start;padding:12px 0;border-bottom:1px solid var(--ln);cursor:pointer}.ck:last-child{border:0}
.ck input{width:22px;height:22px;margin-top:1px;accent-color:var(--br);flex:none}.ckpanel h3{margin:12px 0 0;font-size:18px}
.ckbar{display:flex;gap:12px;align-items:center;margin:14px 0;color:var(--mu);font-size:14px}.ckbar .meter{flex:1;margin:0}
footer{border-top:1px solid var(--ln);padding:24px 0 34px;color:var(--mu);font-size:13.5px}
.toast{position:fixed;left:50%;bottom:calc(20px + env(safe-area-inset-bottom,0px));transform:translateX(-50%);background:var(--ink);color:var(--bg);padding:10px 18px;border-radius:99px;font-size:14px;opacity:0;pointer-events:none;transition:opacity .2s;z-index:30}.toast.on{opacity:1}
@media print{.hd,.hero,.pills,.nr,.ctl,footer,.sh p,#v-checklist,#v-learn,#v-explore .xhide,.noprint{display:none!important}.tw{max-height:none;overflow:visible}.gi{border:0;background:none}body{background:#fff}}
@media (prefers-reduced-motion:reduce){*{transition:none!important;scroll-behavior:auto!important}}
.cr{flex-wrap:wrap}.cr .fd{min-width:130px}
.ov{position:fixed;inset:0;background:rgba(8,14,28,.6);z-index:40;display:grid;place-items:center;padding:16px;overflow:auto}
.box{background:var(--sf);border:1px solid var(--ln);border-radius:18px;padding:20px;width:100%;max-width:440px;max-height:92vh;overflow:auto}
.box h3{font-size:20px}.box .fd{margin-bottom:10px}.box .btn{width:100%}
.dn{position:relative;width:200px;max-width:100%;margin:6px auto}.dn svg{display:block;width:100%;transform:rotate(-90deg)}.dc{position:absolute;inset:0;display:grid;place-content:center;text-align:center;pointer-events:none;padding:34px}.dc small{color:var(--mu);font-size:12px}.dc b{font:700 18px var(--h)}
.sg-s{cursor:pointer;transition:stroke-width .15s}.sg-s:hover,.sg-s:focus{stroke-width:7.5;outline:none}
.ai{border:1px solid var(--ac)}.ai h3{margin:0 0 6px}.ai ul{list-style:none;margin:0;padding:0}.ai li{padding:8px 0 8px 28px;position:relative;font-size:14.5px;border-top:1px solid var(--ln)}.ai li:first-child{border-top:0}.ai li:before{position:absolute;left:0;top:7px}.ai .g:before{content:"✅"}.ai .w:before{content:"⚠️"}.ai .b:before{content:"❗"}.ai small{color:var(--mu);display:block;margin-top:8px;font-size:12px}
.dbd{margin-top:16px;display:grid;gap:16px}.rng{width:100%;accent-color:var(--br)}.wi{display:grid;gap:8px}.wi label{font-size:13px;color:var(--mu);display:flex;justify-content:space-between}.wi output{font-weight:600;color:var(--ink)}.wi .o{font-size:14.5px;margin:4px 0 0}
.bar{height:10px;background:var(--so);border-radius:6px;overflow:hidden;margin:4px 0 10px}.bar i{display:block;height:100%;background:var(--br)}.bl{display:flex;justify-content:space-between;font-size:13px;color:var(--mu)}
.gr select,.gr input{width:100%}.gr{align-items:end}
.usr{font-size:13px;color:var(--mu);display:flex;gap:8px;align-items:center;margin-left:auto;margin-right:8px}.fgrid{display:grid;gap:12px;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));margin-top:14px}.fcard{border:1px solid var(--ln);border-radius:14px;padding:14px;background:var(--sf)}.fcard h4{margin:0;font:600 16px var(--h)}.fcard p{margin:4px 0 10px;color:var(--mu);font-size:13.5px}.fm2{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:0 10px}.ftw{overflow-x:auto}.ft{width:100%;border-collapse:collapse;font-size:13.5px}.ft th,.ft td{padding:8px 10px;border-bottom:1px solid var(--ln);text-align:left;white-space:nowrap}
.jrbar{background:var(--sf);border-bottom:1px solid var(--ln)}
.jr{list-style:none;margin:0;padding:10px 0;display:grid;grid-template-columns:repeat(4,1fr);gap:8px}
.jr a{display:flex;gap:10px;align-items:center;padding:8px 12px;border:1px solid var(--ln);border-radius:14px;text-decoration:none;color:var(--ink);background:var(--sf);min-height:52px}
.jr a:hover{border-color:var(--br)}
.jr i{font-style:normal;flex:none;display:grid;place-items:center;width:28px;height:28px;border-radius:50%;background:var(--so);font:700 14px var(--h)}
.jr b{display:block;font-size:14px;font-weight:600;line-height:1.2}.jr small{display:block;color:var(--mu);font-size:12px;line-height:1.2}
.jr a.cur{background:var(--br);color:var(--bi);border-color:var(--br)}.jr a.cur i{background:rgba(255,255,255,.22)}.jr a.cur small{color:inherit;opacity:.85}
.jr a.ok:not(.cur) i{background:var(--gd);color:#fff}
@media(max-width:640px){.jr{gap:4px}.jr a{flex-direction:column;text-align:center;gap:3px;padding:6px 2px}.jr small{display:none}.jr b{font-size:12px}}
.rstep{display:flex;gap:12px;align-items:center;padding:14px;border:1px solid var(--ln);border-radius:14px;background:var(--sf);margin-bottom:10px}
.rstep>i{font-style:normal;flex:none;display:grid;place-items:center;width:32px;height:32px;border-radius:50%;background:var(--ac);color:#1B1300;font:700 15px var(--h)}
.rstep.ok>i{background:var(--gd);color:#fff}
.rstep>div{flex:1}.rstep b{font-size:16px}.rstep p{margin:2px 0 0;color:var(--mu);font-size:14px}
.btn:disabled{opacity:.5;cursor:not-allowed}
.usr[hidden]{display:none}
body{background:radial-gradient(900px 420px at 90% -4%,color-mix(in srgb,var(--br) 16%,transparent),transparent),var(--bg)}
.hd{box-shadow:0 2px 16px rgba(11,42,74,.08)}
.logo{flex:0 0 auto;min-width:0}.logo b{white-space:nowrap;color:var(--br)}
.usr{max-width:50vw;white-space:nowrap}.usr span{overflow:hidden;text-overflow:ellipsis;max-width:26vw}
.nav{overflow-x:auto;scrollbar-width:none}.nav a{white-space:nowrap}
@media(max-width:900px){.nav{order:5;flex:1 0 100%;width:100%}.logo small{display:none}}
.panel{box-shadow:0 8px 24px rgba(11,42,74,.07);border-radius:20px}#planner .cols>.panel,#planner .res .panel{border-top:4px solid var(--br)}
.panel h3{color:var(--br)}.sh h2{color:var(--br)}
.btn{border-radius:999px}.btn.pri{background:var(--br);color:var(--bi)}
.btn.go{background:linear-gradient(135deg,var(--gd),var(--br));color:var(--bi);border:0;box-shadow:0 4px 12px rgba(15,118,110,.28)}
.btn.acc{background:linear-gradient(135deg,#FBBF24,#F59E0B)}
.pill[aria-current=step]{background:linear-gradient(135deg,var(--br),#0B2A4A);color:#fff}
.st{border-left:4px solid var(--br)}.st.g{border-left-color:var(--gd)}.st.b{border-left-color:var(--bd)}
.hero::after{background:radial-gradient(circle,rgba(251,191,36,.5),transparent 65%)}
.rgrid{display:grid;gap:16px;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));margin-top:16px}.rc .btn{margin-top:4px}
.rc.pr{border:2px solid var(--ac);background:linear-gradient(180deg,color-mix(in srgb,var(--ac) 12%,var(--sf)),var(--sf))}
.tag{display:inline-block;font:700 11px var(--b);letter-spacing:.06em;padding:3px 10px;border-radius:99px;background:var(--so);color:var(--br);margin-bottom:8px}.rc.pr .tag{background:var(--ac);color:#1B1300}
footer{background:var(--sf);border-top:3px solid var(--br)}
.hd [hidden]{display:none!important}

.logo{margin:0}.nav{justify-content:center;flex:none;width:auto;order:0}
.acts{display:flex;align-items:center;gap:8px;justify-self:end}.acts #authb{display:flex;gap:8px}.usr{margin:0;max-width:none}
.tb{width:40px;padding:0;font-size:18px;display:grid;place-items:center}
@media(max-width:900px){.hbar{grid-template-columns:1fr auto}.nav{grid-column:1/-1;order:3;justify-content:flex-start;overflow-x:auto;width:100%}.usr span{max-width:30vw}}
@media(max-width:420px){.logo b{font-size:16px}.acts .btn.small{padding:6px 10px;min-height:36px}}

/* v13: clearer name, simpler front page, visible login */
.logo b{font:800 clamp(17px,4.6vw,21px)/1.1 var(--h);letter-spacing:-.01em;color:var(--ink)}
.logo svg{width:34px;height:34px}
.acts .btn.small{min-height:40px;font-weight:700}
@media(max-width:520px){#th,.logo small{display:none!important}}
.hero2{background:linear-gradient(135deg,#0B2A4A,#0F766E);color:#fff}
.hg{display:grid;gap:26px;align-items:center;padding-top:34px;padding-bottom:40px}
@media(min-width:900px){.hg{grid-template-columns:1.15fr .85fr;padding-top:58px;padding-bottom:62px}}
.hero2 .bn{font:800 clamp(38px,8vw,66px)/1 var(--h);letter-spacing:-.035em;color:#fff}
.hero2 .sub{font-size:clamp(17px,2.4vw,21px);line-height:1.4;color:#DCEEEC;max-width:36ch;margin:16px 0 0}
.hero2 .tr{font-size:14px;margin-top:14px;color:#BFD8D6}
.ac{background:var(--sf);color:var(--ink);border-radius:20px;padding:22px;box-shadow:0 18px 40px rgba(0,0,0,.28)}
.ac h2{font-size:23px}.ac ul{margin:12px 0 14px;padding-left:20px;color:var(--mu)}.ac li{margin:4px 0}
.ac .btn{width:100%;margin-top:8px}.ac p{color:var(--mu);margin:8px 0 12px}
@media print{.hero2{display:none!important}}

/* v14: layout fixes, spacing scale and premium polish */
:root{--r-sm:10px;--r-md:16px;--r-lg:24px;--sh1:0 1px 2px rgba(11,42,74,.05),0 10px 30px -14px rgba(11,42,74,.18);--sh2:0 2px 4px rgba(11,42,74,.06),0 24px 60px -24px rgba(11,42,74,.35)}
.w{max-width:1200px;padding-left:clamp(16px,4vw,32px);padding-right:clamp(16px,4vw,32px)}
body{background:var(--bg)}
h1,h2,h3{text-wrap:balance}
.jrbar{display:none!important}

/* header */
.hd{background:color-mix(in srgb,var(--sf) 88%,transparent);box-shadow:none;border-bottom:1px solid var(--ln)}
.hbar{display:grid;grid-template-columns:1fr auto 1fr;gap:16px;min-height:72px;padding-top:12px;padding-bottom:12px}
.logo{justify-self:start;margin:0}
.logo b{font:800 20px/1.1 var(--h);letter-spacing:-.015em;color:var(--ink)}
.logo svg{width:38px;height:38px;border-radius:11px;box-shadow:0 4px 12px -4px rgba(14,77,87,.5)}
.nav{justify-self:center;gap:2px;padding:4px;border-radius:99px;background:var(--so);overflow:visible;width:auto}
.nav a{padding:8px 18px;font-size:14.5px;color:var(--mu);transition:background .15s,color .15s}
.nav a:hover{background:transparent;color:var(--ink)}
.nav a[aria-current=page]{background:var(--sf);color:var(--ink);box-shadow:0 1px 3px rgba(11,42,74,.14)}
.acts{justify-self:end;gap:10px}
.acts #authb{gap:10px}
.acts .btn.small{min-height:42px;padding:8px 20px;font-size:14.5px;font-weight:600}
.acts .btn.small:not(.go){background:transparent;border-color:var(--ln)}
.acts .btn.small:not(.go):hover{border-color:var(--br);background:var(--so)}
.tb{width:42px;min-height:42px;border-radius:50%}
.usr{font-size:14px}

/* buttons */
.btn{transition:transform .12s,box-shadow .2s,border-color .15s,background .15s}
.btn.lg{min-height:52px;padding:12px 28px;font-size:16px}
.btn.go:hover,.btn.acc:hover{transform:translateY(-1px);box-shadow:0 10px 22px -8px rgba(15,118,110,.55)}
.btn.acc{box-shadow:0 8px 20px -8px rgba(245,158,11,.7);border:0}
.btn.acc:hover{box-shadow:0 12px 26px -8px rgba(245,158,11,.8)}

/* hero */
.hero2{position:relative;overflow:hidden;background:radial-gradient(60% 90% at 88% 0%,rgba(251,191,36,.2),transparent 62%),linear-gradient(135deg,#0A2540 0%,#0C4A55 55%,#0F766E 100%)}
.hero2::before{content:"";position:absolute;inset:0;background-image:radial-gradient(rgba(255,255,255,.08) 1px,transparent 1px);background-size:24px 24px;-webkit-mask-image:linear-gradient(to bottom,#000 30%,transparent 95%);mask-image:linear-gradient(to bottom,#000 30%,transparent 95%);pointer-events:none}
.hg{position:relative;display:grid;gap:40px;align-items:center;padding-top:48px;padding-bottom:56px}
@media(min-width:900px){.hg{grid-template-columns:minmax(0,1.1fr) minmax(0,.9fr);gap:72px;padding-top:88px;padding-bottom:96px}}
.hcopy{text-align:left}
.hero2 .bn{font:800 clamp(40px,6.4vw,68px)/1.02 var(--h);letter-spacing:-.035em;max-width:11ch}
.hero2 .sub{font-size:clamp(17px,2vw,20px);line-height:1.55;max-width:38ch;margin:24px 0 0}
.hero2 .cta{margin-top:36px}
.trust{list-style:none;margin:32px 0 0;padding:0;display:flex;flex-wrap:wrap;gap:10px 28px;font-size:14.5px;color:#C4DCDA}
.trust li{display:flex;align-items:center;gap:8px}
.trust svg{width:16px;height:16px;color:#FBBF24;flex:none}
.ac{padding:32px;border-radius:var(--r-lg);box-shadow:var(--sh2);border:1px solid rgba(255,255,255,.14)}
@media(min-width:900px){.ac{max-width:460px;justify-self:end;width:100%}}
.ac h2{font-size:26px;letter-spacing:-.02em;color:var(--ink)}
.ac p.acs{margin:8px 0 0;color:var(--mu)}
.ac ul.acl{list-style:none;margin:24px 0 28px;padding:0;display:grid;gap:14px}
.ac ul.acl li{position:relative;margin:0;padding-left:30px;color:var(--ink);font-size:15.5px}
.ac ul.acl li::before{content:"";position:absolute;left:0;top:1px;width:20px;height:20px;border-radius:50%;background:var(--so) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3E%3Cpath d='M5.5 10.5l3 3 6-6.5' fill='none' stroke='%230F766E' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") center/100% no-repeat}
.ac .btn{margin-top:0}
.ac #ha-in .btn{margin-top:12px}
.ac #ha-in p.acs{margin:8px 0 24px}
.alt{display:flex;flex-direction:column;gap:12px;margin-top:20px;padding-top:20px;border-top:1px solid var(--ln);text-align:center}
.alt span{color:var(--mu);font-size:14.5px}

/* planner */
#planner{padding-top:48px;padding-bottom:64px}
.pills{gap:12px;margin-bottom:32px}
.pill{min-height:60px;padding:12px 16px;border-radius:var(--r-md);box-shadow:var(--sh1)}
.pill[aria-current=step]{box-shadow:0 10px 24px -10px rgba(11,42,74,.6)}
.sh h2{color:var(--ink);font-size:clamp(26px,3.6vw,36px);letter-spacing:-.025em}
.sh p{margin:8px 0 28px;color:var(--mu);font-size:16.5px;line-height:1.55;text-wrap:pretty}
.cols{gap:24px}
.panel{padding:28px;border-radius:var(--r-lg);box-shadow:var(--sh1)}
#planner .cols>.panel,#planner .res .panel{border-top:1px solid var(--ln)}
.panel h3{color:var(--ink);font-size:18px;margin-bottom:16px}
.panel h3.sp{margin-top:28px;padding-top:24px}
.fd{margin-bottom:18px}
.fd label{margin-bottom:6px}
.fg{gap:0 20px}
.hl{border-radius:var(--r-lg);padding:28px;box-shadow:var(--sh2)}
.sg{gap:12px;margin:16px 0}
.st{padding:14px 16px;border-radius:var(--r-md);box-shadow:var(--sh1)}
.nr{margin-top:28px}
.chips{margin-bottom:20px}
details.art{border-radius:var(--r-md)}
footer{padding:40px 0 48px;line-height:1.6}
.box{padding:28px;border-radius:var(--r-lg);box-shadow:var(--sh2)}
.ov{background:rgba(6,18,30,.62);-webkit-backdrop-filter:blur(4px);backdrop-filter:blur(4px)}

/* mobile */
@media(max-width:900px){
.hbar{grid-template-columns:1fr auto;gap:8px 12px;min-height:0;padding-top:10px;padding-bottom:10px}
.nav{grid-column:1/-1;order:3;justify-self:stretch;overflow-x:auto;justify-content:flex-start;scrollbar-width:none}
.nav::-webkit-scrollbar{display:none}
.nav a{padding:8px 16px;flex:none}
.hero2 .bn{max-width:none}
.ac{padding:24px}
.panel{padding:20px}
.hl{padding:22px}
.pills{gap:8px;margin-bottom:24px}
#planner{padding-top:32px;padding-bottom:48px}
.pills{grid-template-columns:repeat(4,minmax(0,1fr))}
}
@media(max-width:640px){.pill{padding:8px 4px}}
@media(max-width:520px){
.hbar>.logo{min-width:0}.logo b{font-size:16px;white-space:normal;max-width:9ch;line-height:1.05}.logo svg{width:34px;height:34px}
.nav a{padding:8px 11px;font-size:14px}
.acts,.acts #authb{gap:6px}
.acts .btn.small{min-height:38px;padding:6px 13px;font-size:14px}
.hero2 .cta .btn{width:100%}
.trust{gap:8px 20px;font-size:14px}
}
@media(max-width:360px){.logo b{font-size:15px}.logo{gap:8px}.acts .btn.small{padding:6px 10px}}
@media print{.hero2{display:none!important}}

/* v15: screenshot deterrent, guidance session, mobile-first touch polish */
body{-webkit-user-select:none;user-select:none;-webkit-touch-callout:none;-webkit-tap-highlight-color:transparent}
input,textarea,select{-webkit-user-select:text;user-select:text}
img,svg{-webkit-user-drag:none}
#shield{position:fixed;inset:0;z-index:2147483000;display:grid;place-items:center;padding:24px;text-align:center;background:var(--bg);color:var(--ink)}
#shield b{font:800 24px var(--h);display:block;margin-bottom:8px}#shield p{margin:0;color:var(--mu);max-width:34ch}
@media print{body{display:none!important}}

textarea.sel{resize:vertical;min-height:88px;font:inherit;line-height:1.5}
.rgrid{gap:24px;margin-top:0}
.rc{display:flex;flex-direction:column;align-items:flex-start}
.rc>p{margin:0 0 20px;color:var(--mu);font-size:15px;line-height:1.55;flex:1}
.rc .row{margin-top:auto;width:100%}
.rc .btn{margin-top:0}
.rc.gs{border:1px solid var(--br);background:linear-gradient(180deg,color-mix(in srgb,var(--br) 9%,var(--sf)),var(--sf))}
.rc.gs .tag{background:var(--br);color:var(--bi)}
.msg.bk{width:100%;font-size:15px}.msg.bk small{display:block;margin-top:6px;color:var(--mu);font-size:13px}
.rnote{color:var(--bd);margin:16px 0 0;font-size:14.5px}
#v-report .nr{margin-top:28px}
.gsp{font-size:28px;margin:6px 0 4px}.gsp small{color:var(--mu);font-size:13px}
.gsn{font-size:12.5px;color:var(--mu);margin:12px 0 0}
.box .ck{padding:10px 0;border:0}
.box .tips{margin:10px 0 18px}

/* touch targets and mobile ergonomics */
button,.btn,a,.pill,.chip,summary{touch-action:manipulation}
@media(pointer:coarse),(max-width:640px){
.btn.small,.acts .btn.small{min-height:44px}
.nav a{min-height:44px;display:inline-flex;align-items:center}
.tb{width:44px;min-height:44px}
footer .link{display:inline-flex;align-items:center;min-height:44px;padding:0 4px}
.chip{min-height:44px}
input,select,textarea{font-size:16px}
.link{display:inline-flex;align-items:center;min-height:44px}
p .link,label .link,li .link,span .link,small .link{display:inline;min-height:0;padding:12px 2px}
}
@media(max-width:640px){
.ov{place-items:end center;padding:0}
.box{max-width:none!important;border-radius:24px 24px 0 0;max-height:92vh;max-height:92dvh;padding:24px 20px calc(24px + env(safe-area-inset-bottom,0px));border-bottom:0}
.rc .row{flex-direction:column;align-items:stretch}.rc .row .btn{width:100%}
.nr{display:grid;grid-template-columns:1fr 1fr;gap:12px}.nr .btn{width:100%;padding-left:12px;padding-right:12px}
.nr .btn:only-child{grid-column:1/-1}
.sh p{font-size:16px;margin-bottom:20px}
.fg{grid-template-columns:minmax(0,1fr)}.cols{grid-template-columns:minmax(0,1fr)}.er .fd{min-width:0}
.toast{width:calc(100% - 32px);max-width:420px;text-align:center;border-radius:16px}
}
@media(max-width:900px){.acts .btn.small{min-height:44px}}
.box>.link[aria-label=Close]{display:grid;place-items:center;width:44px;height:44px;margin:-8px -8px 0 0;text-decoration:none;font-size:18px;border-radius:50%}
.box>.link[aria-label=Close]:hover{background:var(--so)}

/* premium finish */
:root{--gold:#C9A24B;--gold2:#F3DFA2}
.hero2{background:radial-gradient(1200px 500px at 85% -10%,rgba(201,162,75,.28),transparent 60%),linear-gradient(135deg,#071E36,#0B3B45 55%,#0F766E)!important}
.hero2 .bn{background:linear-gradient(180deg,#fff,#F3DFA2);-webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent}
.hero2 .bn::before{content:"PREMIUM RETIREMENT INTELLIGENCE";display:block;font:700 12px var(--b);letter-spacing:.22em;color:var(--gold2);-webkit-text-fill-color:var(--gold2);margin-bottom:14px}
.panel{border:1px solid color-mix(in srgb,var(--gold) 22%,var(--ln));box-shadow:0 14px 40px rgba(7,30,54,.09);transition:transform .25s,box-shadow .25s}
.panel:hover{transform:translateY(-2px);box-shadow:0 20px 50px rgba(7,30,54,.14)}
#planner .cols>.panel,#planner .res .panel{border-top:4px solid var(--gold)}
.btn.go,.btn.pri{background:linear-gradient(135deg,#0F766E,#0B3B45);color:#fff;box-shadow:0 8px 22px rgba(11,59,69,.32);letter-spacing:.01em;transition:transform .2s,box-shadow .2s}
.btn.go:hover,.btn.pri:hover{transform:translateY(-1px);box-shadow:0 12px 28px rgba(11,59,69,.4)}
.hero2 .btn.go{background:linear-gradient(135deg,#E8C66E,#C9A24B);color:#2A2108;box-shadow:0 10px 28px rgba(201,162,75,.4)}
.tag{background:linear-gradient(135deg,#E8C66E,#C9A24B)!important;color:#2A2108!important;letter-spacing:.12em;font-weight:800}
.rc.pr,.rc.rf{border-color:var(--gold)}
.refstat{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin:12px 0}
.refstat>div{background:var(--so);border-radius:12px;padding:10px;text-align:center}
.refstat small{display:block;color:var(--mu);font-size:11px;text-transform:uppercase;letter-spacing:.08em}
.refstat b{font:800 20px var(--h);color:var(--br)}
.reflink{width:100%;box-sizing:border-box;margin:0 0 10px;padding:10px 12px;border:1px dashed var(--gold);border-radius:12px;background:transparent;color:var(--ink);font:13px var(--b)}
.sub-ck{font-size:11.5px;color:var(--mu);opacity:.85}
#usr span{font-weight:600}
.ptschip{display:inline-block;margin-left:8px;padding:5px 12px;border-radius:999px;background:linear-gradient(135deg,#2DD4BF,#0F766E);color:#fff;font:700 13px var(--b);text-decoration:none;white-space:nowrap}
.ptsstrip{margin-top:16px;padding-top:14px;border-top:1px solid rgba(15,118,110,.4)}
.ptsstrip .ps{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:10px}
.ptsstrip .ps>div{background:rgba(15,118,110,.12);border-radius:12px;padding:8px;text-align:center}
.ptsstrip small{display:block;font-size:11px;opacity:.8}.ptsstrip .ps b{font:800 17px var(--h);color:var(--br)}
.ptsstrip .psn{display:block;margin-top:8px}
.stk{margin:0 0 10px}.sdots{display:flex;gap:6px}.sd{flex:1;max-width:40px;aspect-ratio:1;border-radius:50%;display:grid;place-items:center;font:700 12px var(--b);font-style:normal;background:rgba(15,118,110,.12);border:1px solid rgba(15,118,110,.4)}.sd.on{background:linear-gradient(135deg,#2DD4BF,#0F766E);color:#fff;border-color:transparent}
.mail{-webkit-user-select:text;user-select:text}
/* v19: compact, premium hero so the planner shows on the first screen */
.hero2 .hg{padding-top:30px;padding-bottom:34px;gap:26px;align-items:center}
@media(min-width:900px){.hero2 .hg{padding-top:34px;padding-bottom:40px;gap:56px;grid-template-columns:minmax(0,1.12fr) minmax(0,.88fr)}}
.hero2 .bn{font:800 clamp(32px,4.2vw,50px)/1.06 var(--h);letter-spacing:-.032em;max-width:none}
.hero2 .bn::before{font-size:11px;letter-spacing:.3em;margin-bottom:12px;font-weight:700}
.hero2 .sub{font-size:clamp(16px,1.45vw,18.5px);line-height:1.6;max-width:47ch;margin:14px 0 0;color:#D9EAE8;font-weight:400;letter-spacing:.005em}
.hero2 .cta{margin-top:22px;display:flex;align-items:center;gap:16px;flex-wrap:wrap}
.hero2 .btn.acc{display:inline-flex!important;flex-direction:row!important;align-items:center;justify-content:center;gap:10px;white-space:nowrap;min-width:190px;background:linear-gradient(135deg,#F3DFA2,#C9A24B);color:#2A2108;border:0;font-weight:800;letter-spacing:.01em;padding:0 30px;box-shadow:0 12px 30px rgba(201,162,75,.38)}
.hero2 .btn.acc::after{content:"→";font-weight:700;transition:transform .2s}.hero2 .btn.acc:hover::after{transform:translateX(3px)}
.cta-n{font-size:13px;color:#BCD5D2;letter-spacing:.02em}
.trust{margin:20px 0 0;gap:8px 10px}
.trust li{padding:6px 12px 6px 10px;border:1px solid rgba(243,223,162,.28);border-radius:999px;background:rgba(255,255,255,.06);font-size:12.5px;white-space:nowrap;letter-spacing:.01em;color:#E6F1EF}
.trust svg{width:14px;height:14px}
.hero2 .ac{padding:20px 22px;border:1px solid rgba(201,162,75,.35);border-top:3px solid var(--gold);box-shadow:0 26px 60px rgba(0,0,0,.30)}
@media(min-width:900px){.hero2 .ac{max-width:430px}}
.hero2 .ac h2{font-size:22px;line-height:1.2;letter-spacing:-.015em}
.hero2 .ac p.acs{margin:4px 0 0;font-size:14px}
.ac ul.acl{margin:14px 0 16px;gap:8px}.ac ul.acl li{font-size:14.5px;padding-left:28px}
.ac ul.acl li::before{width:18px;height:18px}
.alt{flex-direction:row;justify-content:center;align-items:center;gap:12px;margin-top:14px;padding-top:14px;flex-wrap:wrap}
.alt .btn{width:auto;min-height:40px;padding:0 20px}
.ac #ha-in p.acs{margin:4px 0 14px}
.hbtns{display:grid;grid-template-columns:1fr 1fr;gap:10px}
#heroAuth #ha-in .hbtns .btn{margin:0;min-height:46px;padding:0 10px;font-size:15px;font-weight:700}
.ptsstrip{margin-top:14px;padding-top:12px}
.ptsstrip .ps{gap:6px;margin-bottom:8px}.ptsstrip .ps>div{padding:6px 4px}
.ptsstrip small{font-size:10.5px;letter-spacing:.06em;text-transform:uppercase}
.ptsstrip .ps b{font-size:15px;letter-spacing:.01em}
.stk{margin:0 0 8px}.sdots{gap:5px}.sd{max-width:34px;font-size:11.5px}
.ptsstrip .psn{margin-top:6px;font-size:11.5px;line-height:1.45;text-transform:none;letter-spacing:0}
.ptsstrip .row{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:10px}
#heroAuth .ptsstrip .row .btn{width:100%;min-height:38px;margin:0;font-size:13.5px;padding:0 8px}
#planner{padding-top:26px}
@media(max-width:560px){.hero2 .hg{padding-top:24px;padding-bottom:26px;gap:20px}.trust{gap:6px}.trust li{font-size:12px;padding:5px 10px 5px 8px}#heroAuth #ha-in .hbtns .btn{font-size:13.5px;padding:0 6px}.cta-n{display:none}.hero2 .btn.acc{width:100%}.hero2 .ac{padding:18px}}
/* v20: premium price display */
.pz{display:flex;align-items:baseline;gap:10px;flex-wrap:wrap;margin:2px 0 2px}
.pz s{font:600 20px var(--b);color:var(--mu);text-decoration:line-through;text-decoration-thickness:2px;text-decoration-color:#C2412D}
.pz b{font:800 40px/1 var(--h);letter-spacing:-.02em;color:var(--br)}
.pz em{font:800 11px var(--b);font-style:normal;letter-spacing:.1em;padding:5px 11px;border-radius:999px;background:linear-gradient(135deg,#E8C66E,#C9A24B);color:#2A2108;align-self:center;box-shadow:0 4px 12px rgba(201,162,75,.35)}
.pzb{margin-top:14px}.pzb b{font-size:46px}.pzb s{font-size:22px}
.pzn{display:block;margin:6px 0 12px;color:var(--mu);font-size:12.5px;letter-spacing:.03em}

/* ===== v21: luxury finish — champagne gold, deep ink, serif display, hairline detail ===== */
:root{--hd-serif:'Fraunces','Bricolage Grotesque',Georgia,serif;--gold:#B8913A;--gold2:#EBD594;--gold-grad:linear-gradient(135deg,#F3E2A9 0%,#D4AF5A 48%,#B18A33 100%);--hair:rgba(184,145,58,.28);--ease:cubic-bezier(.22,.7,.2,1);--r-md:14px;--r-lg:22px;
--sh1:0 1px 0 rgba(255,255,255,.7) inset,0 1px 2px rgba(7,30,54,.05),0 18px 40px -22px rgba(7,30,54,.22);--sh2:0 2px 6px rgba(7,30,54,.08),0 36px 80px -30px rgba(7,30,54,.5)}
:root{--bg:#F6F4EE;--sf:#FFFEFB;--ink:#0C1E33;--mu:#5B6878;--ln:#E7E2D6;--so:#F0EEE6;--br:#0B4F57}
@media (prefers-color-scheme:dark){:root:not([data-theme="light"]){--bg:#070F18;--sf:#0E1A27;--ink:#F1EEE4;--mu:#9AA8B5;--ln:#1E2D3D;--so:#142333;--br:#E3C675;--bi:#1A1405;--gold:#D9B968;--hair:rgba(217,185,104,.28);--sh1:0 1px 0 rgba(255,255,255,.04) inset,0 18px 40px -22px rgba(0,0,0,.7)}}
:root[data-theme="dark"]{--bg:#070F18;--sf:#0E1A27;--ink:#F1EEE4;--mu:#9AA8B5;--ln:#1E2D3D;--so:#142333;--br:#E3C675;--bi:#1A1405;--gold:#D9B968;--hair:rgba(217,185,104,.28);--sh1:0 1px 0 rgba(255,255,255,.04) inset,0 18px 40px -22px rgba(0,0,0,.7)}

body{background:radial-gradient(900px 480px at 100% -5%,rgba(184,145,58,.07),transparent 60%),var(--bg);font-feature-settings:"ss01","kern";-webkit-font-smoothing:antialiased;text-rendering:optimizeLegibility}
::selection{background:var(--gold2);color:#1A1405}
h1,h2{font-family:var(--hd-serif);font-weight:500;letter-spacing:-.018em}
.sh h2,.panel h3,.ac h2,.hero2 .bn{font-family:var(--hd-serif)}
.panel h3{font-weight:600;letter-spacing:-.005em}
.sh h2{font-weight:500;font-size:clamp(28px,3.8vw,40px)}
.sh h2::after{content:"";display:block;width:56px;height:2px;margin-top:14px;background:var(--gold-grad);border-radius:2px}
.sh p{font-size:16px;color:var(--mu)}

/* header */
.hd{background:color-mix(in srgb,var(--sf) 82%,transparent);-webkit-backdrop-filter:saturate(1.4) blur(18px);backdrop-filter:saturate(1.4) blur(18px);border-bottom:1px solid var(--hair)}
.logo b{font-family:var(--hd-serif);font-weight:600;font-size:20px;letter-spacing:-.01em}
.logo small{letter-spacing:.14em;text-transform:uppercase;font-size:10px;color:var(--gold)}
.logo svg{border-radius:12px;box-shadow:0 0 0 1px var(--hair),0 8px 18px -8px rgba(11,79,87,.6)}
.nav{background:transparent;border:1px solid var(--ln);padding:3px}
.nav a{font-size:13.5px;letter-spacing:.04em;color:var(--mu)}
.nav a[aria-current=page]{background:var(--ink);color:var(--sf);box-shadow:none}
.tb{border-color:var(--hair);transition:border-color .2s,transform .2s}.tb:hover{border-color:var(--gold);transform:rotate(20deg)}

/* buttons */
.btn{border-radius:999px;letter-spacing:.02em;font-weight:600;border-color:var(--ln);transition:transform .25s var(--ease),box-shadow .3s var(--ease),border-color .2s,background .2s}
.btn:hover{border-color:var(--gold)}
.btn.go,.btn.pri{background:linear-gradient(180deg,#12636C,#0A3F47);border:1px solid rgba(255,255,255,.08);color:#fff;box-shadow:0 1px 0 rgba(255,255,255,.18) inset,0 10px 24px -10px rgba(10,63,71,.7)}
@media (prefers-color-scheme:dark){:root:not([data-theme="light"]) .btn.go,:root:not([data-theme="light"]) .btn.pri{background:var(--gold-grad);color:#1A1405;box-shadow:0 10px 26px -10px rgba(217,185,104,.55)}}
:root[data-theme="dark"] .btn.go,:root[data-theme="dark"] .btn.pri{background:var(--gold-grad);color:#1A1405;box-shadow:0 10px 26px -10px rgba(217,185,104,.55)}
.btn.acc,.hero2 .btn.acc,.hero2 .btn.go{background:var(--gold-grad)!important;color:#241A04!important;border:1px solid rgba(255,255,255,.35)!important;box-shadow:0 1px 0 rgba(255,255,255,.55) inset,0 14px 32px -12px rgba(184,145,58,.8)!important}
.btn.go:hover,.btn.pri:hover,.btn.acc:hover{transform:translateY(-2px)}
.acts .btn.small:not(.go){border-color:var(--hair)}

/* hero */
.hero2{background:radial-gradient(900px 420px at 85% -10%,rgba(235,213,148,.22),transparent 60%),radial-gradient(700px 400px at 0% 110%,rgba(15,118,110,.35),transparent 60%),linear-gradient(135deg,#050E1A 0%,#08263A 52%,#0A3B44 100%)!important;border-bottom:1px solid var(--hair)}
.hero2::after{content:"";position:absolute;left:0;right:0;bottom:0;height:1px;background:linear-gradient(90deg,transparent,var(--gold2),transparent);opacity:.7}
.hero2 .bn{font-family:var(--hd-serif);font-weight:400;font-size:clamp(36px,4.8vw,60px);line-height:1.04;letter-spacing:-.028em;background:linear-gradient(180deg,#FFFFFF 10%,#EBD594 120%);-webkit-background-clip:text;background-clip:text}
.hero2 .bn::before{font-family:var(--b);letter-spacing:.34em;font-weight:600;font-size:10.5px;display:flex;align-items:center;gap:14px;margin-bottom:18px}
.hero2 .bn::after{content:"";display:block;width:72px;height:2px;margin-top:20px;background:var(--gold-grad);border-radius:2px}
.hero2 .sub{color:#C9D8DD;font-size:clamp(16px,1.4vw,18px);max-width:50ch}
.trust li{border-color:rgba(235,213,148,.3);background:rgba(255,255,255,.04);-webkit-backdrop-filter:blur(6px);backdrop-filter:blur(6px)}
.hero2 .ac{background:linear-gradient(180deg,rgba(255,254,251,.98),rgba(250,247,238,.97));color:#0C1E33;border:1px solid rgba(235,213,148,.55);border-top:2px solid var(--gold);border-radius:var(--r-lg);box-shadow:0 40px 90px -30px rgba(0,0,0,.7),0 0 0 6px rgba(235,213,148,.06)}
.hero2 .ac h2{color:#0C1E33;font-weight:500}.hero2 .ac p.acs,.hero2 .ac .alt span{color:#5B6878}
.hero2 .ac .btn:not(.go){background:#fff;color:#0C1E33;border-color:#E7E2D6}
.hero2 .ac .btn.go{background:linear-gradient(180deg,#12636C,#0A3F47)!important;color:#fff!important;border:1px solid rgba(255,255,255,.1)!important}
.hero2 .ac .alt{border-top-color:#E7E2D6}
.hero2 .ac ul.acl li{color:#0C1E33}.hero2 .ac ul.acl li::before{background-color:#F3EAD0}

/* step pills */
.pills{gap:10px}
.pill{background:var(--sf);border-color:var(--ln);box-shadow:none;transition:border-color .25s,transform .25s var(--ease),box-shadow .25s}
.pill:hover{border-color:var(--gold);transform:translateY(-2px)}
.pill i{background:transparent;border:1px solid var(--hair);font-family:var(--hd-serif);font-weight:600;color:var(--gold)}
.pill b{letter-spacing:.02em}
.pill[aria-current=step]{background:linear-gradient(180deg,#0E2A44,#08192C);color:#F6EFD8;border-color:var(--gold);box-shadow:0 18px 36px -18px rgba(7,25,44,.8)}
.pill[aria-current=step] i{background:var(--gold-grad);color:#241A04;border-color:transparent}
.pill.done:not([aria-current=step]) i{background:var(--gold-grad);border-color:transparent;color:#241A04}

/* panels */
.panel,.ckpanel,.myth,.gterm,details.art,.st{background:var(--sf);border:1px solid var(--ln);box-shadow:var(--sh1)}
.panel{border-radius:var(--r-lg);padding:clamp(20px,3vw,32px);position:relative}
.panel:hover{transform:none;box-shadow:var(--sh1)}
#planner .cols>.panel,#planner .res .panel{border-top:1px solid var(--ln)}
#planner .cols>.panel::before,#planner .res .panel::before{content:"";position:absolute;left:28px;right:28px;top:-1px;height:2px;background:var(--gold-grad);border-radius:0 0 2px 2px;opacity:.9}
.panel h3.sp{border-top:1px solid var(--ln)}
.st{border-radius:var(--r-md);box-shadow:none;position:relative}
.st b{font-family:var(--hd-serif);font-weight:600;letter-spacing:-.01em}
.st span{font-size:11.5px;letter-spacing:.1em;text-transform:uppercase}

/* highlight card */
.hl{background:radial-gradient(500px 220px at 100% 0%,rgba(235,213,148,.22),transparent 65%),linear-gradient(135deg,#050E1A,#0A3B44);border:1px solid var(--hair);border-radius:var(--r-lg);padding:26px;box-shadow:0 30px 60px -30px rgba(5,14,26,.8)}
.hl small{letter-spacing:.16em;text-transform:uppercase;font-size:11px;color:var(--gold2)}
.hl b{font-family:var(--hd-serif);font-weight:500;background:linear-gradient(180deg,#fff,#EBD594);-webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent}
.hl p{color:#C9D8DD}

/* inputs */
.fd label{font-size:12px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--mu)}
.in,.sel,.gi,.gsearch{background:var(--sf);border:1px solid var(--ln);border-radius:12px;transition:border-color .2s,box-shadow .25s}
.in:hover,.sel:hover{border-color:var(--hair)}
.in:focus-within,.sel:focus,.gi:focus,.gsearch:focus{border-color:var(--gold);box-shadow:0 0 0 4px color-mix(in srgb,var(--gold) 20%,transparent);outline:none}
.in input{font-weight:500}
.in i{color:var(--gold);font-weight:600}
.es input,.ck input{accent-color:var(--gold)}
:focus-visible{outline:2px solid var(--gold);outline-offset:3px}

/* bars */
.meter,.mix{background:var(--so);height:10px;box-shadow:inset 0 1px 2px rgba(7,30,54,.12)}
.meter i{background:var(--gold-grad)}
.msg{background:linear-gradient(180deg,var(--so),color-mix(in srgb,var(--so) 70%,var(--sf)));border:1px solid var(--ln);border-left:3px solid var(--gold);border-radius:12px}

/* tables */
.tw{border:1px solid var(--ln);border-radius:var(--r-md);box-shadow:var(--sh1)}
thead th{background:#08192C;color:#F0E3B8;font-size:11.5px;letter-spacing:.1em;text-transform:uppercase;font-weight:600;border-bottom:1px solid var(--gold)}
tbody tr{transition:background .15s}
tbody tr:hover td{background:color-mix(in srgb,var(--gold) 8%,transparent)}
td{border-bottom-color:color-mix(in srgb,var(--ln) 80%,transparent)}
tr.rt td{background:color-mix(in srgb,var(--gold) 20%,transparent)}

/* chips, learn, checklist */
.chip{border-color:var(--ln);letter-spacing:.02em;transition:all .2s}
.chip:hover{border-color:var(--gold)}
.chip[aria-pressed=true],.chip[aria-selected=true]{background:var(--ink);color:var(--sf);border-color:var(--ink)}
.catg{background:transparent;border:1px solid var(--hair);color:var(--gold);letter-spacing:.08em;text-transform:uppercase;font-size:10.5px}
details.art{border-radius:var(--r-md);transition:border-color .2s,box-shadow .3s}
details.art[open],details.art:hover{border-color:var(--gold)}
details.art summary::after{color:var(--gold);font-family:var(--hd-serif)}
.myth .m{font-family:var(--hd-serif)}
.link{color:var(--br);text-underline-offset:3px;text-decoration-color:var(--hair)}.link:hover{text-decoration-color:var(--gold)}

/* tags / chips from earlier versions */
.tag,.pz em{background:var(--gold-grad)!important;color:#241A04!important}
.pz b{font-family:var(--hd-serif);font-weight:500}
.pz s{text-decoration-color:#B4442F}

/* modals, toast, footer */
.box{border:1px solid var(--hair);border-radius:var(--r-lg);box-shadow:0 50px 120px -30px rgba(0,0,0,.65)}
.toast{background:#08192C;color:#F0E3B8;border:1px solid var(--gold);letter-spacing:.02em}
footer{border-top:1px solid var(--hair);background:linear-gradient(180deg,transparent,color-mix(in srgb,var(--so) 60%,transparent))}

/* motion */
@media (prefers-reduced-motion:no-preference){
.panel,.hero2 .hcopy,.hero2 .ac,.pill{animation:rise .7s var(--ease) both}
.hero2 .ac{animation-delay:.12s}.panel:nth-child(2){animation-delay:.08s}
@keyframes rise{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:none}}}
@media print{body{background:#fff!important}.panel::before{display:none}}
</style>
<style>
.rgrid{grid-template-columns:minmax(0,1.6fr) minmax(0,1fr);align-items:stretch}
@media (max-width:760px){.rgrid{grid-template-columns:1fr}}
.rgrid .rc.pr.el{position:relative;padding:28px;border:1.5px solid #C9A24B;border-radius:20px;background:linear-gradient(160deg,color-mix(in srgb,#C9A24B 14%,var(--sf)),var(--sf) 60%);box-shadow:0 18px 44px rgba(201,162,75,.18),0 2px 6px rgba(0,0,0,.06);overflow:hidden}
.rgrid .rc.pr.el:before{content:"";position:absolute;left:0;right:0;top:0;height:4px;background:linear-gradient(90deg,#E8C66E,#C9A24B,#E8C66E)}
.rgrid .rc.pr.el h3{font-size:1.5rem;letter-spacing:-.01em;margin:6px 0 4px}
.rgrid .rc.pr.el .elsub{margin:0 0 14px;color:var(--mu)}
.rgrid .rc.pr.el .elf{list-style:none;margin:16px 0 20px;padding:0;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px 18px;font-size:14.5px;width:100%}
.rgrid .rc.pr.el .elf li{position:relative;padding-left:24px}
.rgrid .rc.pr.el .elf li:before{content:"✦";position:absolute;left:0;color:#C9A24B}
@media (max-width:480px){.rgrid .rc.pr.el .elf{grid-template-columns:1fr}}
.rgrid .rc.gs{border:1px solid color-mix(in srgb,#C9A24B 45%,var(--ln))}
</style>
<style>
.tst{padding-top:40px;padding-bottom:48px}
.tst .tst-k{display:block;color:var(--ac);font-weight:700;letter-spacing:.08em;font-size:12px;text-transform:uppercase}
.tst h2{margin:4px 0 6px}
.tst .tst-s{margin:0 0 20px;color:var(--mu);max-width:640px}
.tst-g{display:grid;gap:14px;grid-template-columns:repeat(auto-fit,minmax(250px,1fr))}
.tst-c{position:relative;margin:0;padding:22px 20px 18px;background:var(--sf);border:1px solid var(--ln);border-radius:18px;box-shadow:0 8px 24px rgba(11,42,74,.07);display:flex;flex-direction:column;gap:14px}
.tst-c:before{content:"\201C";position:absolute;top:2px;right:16px;font:700 56px/1 Georgia,serif;color:#C9A24B;opacity:.45}
.tst-c blockquote{margin:0;font-size:15px;line-height:1.6}
.tst-c figcaption{display:flex;align-items:center;gap:10px;margin-top:auto;font-weight:600}
.tst-a{display:inline-grid;place-items:center;width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--br),#0B4F4A);color:#fff;font-size:13px;font-weight:700;flex:none}
.tst-n{margin:16px 0 0;font-size:12.5px;color:var(--mu)}
</style>
<style>.tbar{background:#07131f;border-bottom:1px solid rgba(245,184,61,.25);padding-top:env(safe-area-inset-top,0px)}.tbi{display:flex;justify-content:flex-end;align-items:center;gap:18px;padding-top:6px;padding-bottom:6px;flex-wrap:wrap}.lc{display:flex;align-items:center;gap:8px}.lc label{font-size:12px;letter-spacing:.04em;color:#aebccb;font-weight:600}.tbar select{appearance:none;-webkit-appearance:none;background:#0f2234 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M1 1l4 4 4-4' fill='none' stroke='%23F5B83D' stroke-width='1.6'/%3E%3C/svg%3E") no-repeat right 10px center;color:#fff;border:1px solid rgba(255,255,255,.18);border-radius:999px;padding:6px 28px 6px 12px;font-weight:600;font-size:13px;line-height:1.2;font-family:inherit;max-width:210px;cursor:pointer}.tbar select:hover,.tbar select:focus{border-color:#F5B83D;outline:none}.tbar option{color:#0b1b2b;background:#fff}.skiptranslate iframe,#goog-gt-tt,.goog-te-balloon-frame{display:none!important}body{top:0!important}.goog-text-highlight{background:none!important;box-shadow:none!important}@media(max-width:700px){.tbi{justify-content:center;gap:10px}.lc label{display:none}.tbar select{max-width:165px;font-size:12px}}</style>
<style id="explore-css">
.xgrid{display:grid;gap:20px;grid-template-columns:repeat(auto-fill,minmax(280px,1fr))}
.xtile{display:flex;flex-direction:column;gap:10px;padding:24px;border-radius:22px;text-decoration:none;color:#fff;border:1px solid rgba(243,223,162,.45);background:radial-gradient(420px 220px at 100% -10%,rgba(201,162,75,.4),transparent 60%),linear-gradient(135deg,#071E36,#0B3B45 60%,#0F766E);box-shadow:0 14px 36px rgba(7,30,54,.25);transition:transform .25s,box-shadow .25s}
.xtile:hover{transform:translateY(-4px);box-shadow:0 22px 50px rgba(7,30,54,.35)}
.xtile .xic{width:52px;height:52px;border-radius:16px;display:grid;place-items:center;font-size:26px;background:linear-gradient(135deg,#F3E2A9,#C9A24B)}
.xtile h3{font:600 22px/1.2 var(--hd-serif,var(--h));color:#fff;margin:0}
.xtile p{margin:0;color:#F3DFA2;font-size:14.5px}
.xtile .go{margin-top:6px;font-weight:700;color:#fff}
.xcard{border-radius:24px;overflow:hidden;background:var(--sf);border:1px solid color-mix(in srgb,var(--gold) 40%,var(--ln));box-shadow:0 18px 48px rgba(7,30,54,.16)}
.xhead{padding:26px 28px;color:#fff;background:radial-gradient(600px 260px at 100% -20%,rgba(201,162,75,.42),transparent 60%),linear-gradient(135deg,#071E36,#0B3B45 60%,#0F766E)}
.xhead h2{font:600 clamp(24px,4vw,34px)/1.15 var(--hd-serif,var(--h));color:#fff;margin:0 0 6px;letter-spacing:-.02em}
.xhead p{margin:0;color:#F3DFA2;font-size:16px}
.xbody{padding:20px 24px 24px}
.xtw{overflow:auto;border:1px solid var(--ln);border-radius:14px}
.xtab{min-width:860px;width:100%;border-collapse:collapse;font-size:14.5px}
.xtab th,.xtab td{text-align:left;vertical-align:middle;padding:10px 12px;white-space:normal;border-bottom:1px solid var(--ln)}
.xtab thead th{background:var(--so);color:var(--br);font-size:13px;font-weight:700;position:static}
.xtab .in{min-width:120px}.xtab .sel{min-height:44px;min-width:150px}
.xnm{font-weight:600}.xtab td.nm{min-width:200px}
.xe{font-weight:700;color:var(--gd);font-variant-numeric:tabular-nums;white-space:nowrap}
.xtab tfoot td{font-weight:700;background:var(--so);border-bottom:0}
.xtab .ml{display:none}
.xadd{margin-top:14px}
.xaiw{margin-top:22px;padding-top:20px;border-top:1px solid var(--ln)}.xaiw h3{font:600 20px var(--hd-serif,var(--h));margin:0 0 14px;color:var(--ink)}
.xg3{display:grid;gap:14px;grid-template-columns:repeat(auto-fit,minmax(260px,1fr))}
.xg{border:1px solid var(--ln);border-left:5px solid var(--br);border-radius:14px;padding:14px 16px;background:var(--sf)}
.xg.g{border-left-color:var(--gd)}.xg.b{border-left-color:var(--ac)}.xg.w{border-left-color:var(--bd)}
.xg h4{margin:0 0 8px;font:700 15px var(--h)}.xg ul{margin:0;padding-left:18px;display:grid;gap:8px;font-size:14px}
.xaiw small{display:block;margin-top:12px;color:var(--mu)}
.xgate{text-align:center;padding:40px 24px}.xgate h3{font:600 24px var(--hd-serif,var(--h));margin:0 0 8px;color:var(--ink)}.xgate p{color:var(--mu);margin:0 0 20px}.xgate .row{justify-content:center}
@media(max-width:720px){
.xhead{padding:20px}.xbody{padding:14px}.xtw{border:0}
.xtab{min-width:0;display:block}.xtab thead{display:none}.xtab tbody,.xtab tfoot{display:block}
.xtab tbody tr,.xtab tfoot tr{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:10px;padding:14px;border:1px solid var(--ln);border-radius:14px;margin-bottom:10px}
.xtab td{display:block;border:0;padding:0;min-width:0}.xtab td.nm{grid-column:1/-1;min-width:0}
.xtab .ml{display:block;font-size:12px;color:var(--mu);margin-bottom:4px;font-weight:600}
.xtab .in{min-width:0}.xtab .sel{min-width:0;width:100%}
.xtab td.xd:empty{display:none}.xtab td.xd{grid-column:1/-1}.xtab td.xd .btn{width:100%}}
</style>
</head>
<body>
<a class="skip" href="#main">Skip to content</a>
<div class="tbar noprint notranslate"><div class="w tbi"><span class="lc"><label for="ctry">🌍 Country</label><select id="ctry" aria-label="Select country"></select></span><span class="lc"><label for="lang">Language</label><select id="lang" aria-label="Select language"></select></span></div></div>
<header class="hd"><div class="w hbar">
<a class="logo" href="#plan" aria-label="Retirement Plan Karo, home"><svg viewBox="0 0 40 40" aria-hidden="true" focusable="false"><rect width="40" height="40" rx="11" fill="#0E4D57"/><path d="M11 28a9 9 0 0 1 18 0z" fill="#F5B83D"/><path d="M6 28h28" stroke="#fff" stroke-width="2.4" stroke-linecap="round"/><path d="M20 9v4M10 13l2.8 2.8M30 13l-2.8 2.8" stroke="#F5B83D" stroke-width="2.2" stroke-linecap="round"/></svg><span><b>Retirement Plan Karo</b><small>Plan it in 4 simple steps</small></span></a>
<nav class="nav" aria-label="Main"><a href="#plan" data-v="plan">Plan</a><a href="#checklist" data-v="checklist">Checklist</a><a href="#family" data-v="family">Family</a><a href="#report" data-v="report">Report</a><a href="#explore" data-v="explore">Explore</a><a href="#learn" data-v="learn">Learn</a></nav>
<div class="acts"><span class="usr" id="usr" hidden></span><span id="authb"><button class="btn small" type="button" data-auth="li">Login</button><button class="btn go small" type="button" data-auth="su">Sign up</button></span></div></div></header>
<div class="jrbar noprint" id="jr" hidden></div>
<main id="main">

<div id="v-plan">
<section class="hero2"><div class="w hg"><div class="hcopy">
<h1 class="bn">Retirement Plan Karo</h1>
<p class="sub">Know exactly how long your money will last. Bring your savings, spending and life goals together in one clear, year-by-year plan, made for families everywhere.</p>
<div class="cta"><button class="btn acc lg" type="button" data-go="nw">Start my plan</button><span class="cta-n">Free to start · No card needed</span></div>
<ul class="trust"><li><svg viewBox="0 0 20 20" aria-hidden="true" focusable="false"><path d="M4 10.5l4 4 8-9" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>Made for families worldwide</li><li><svg viewBox="0 0 20 20" aria-hidden="true" focusable="false"><path d="M4 10.5l4 4 8-9" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>Ready in 5 minutes</li><li><svg viewBox="0 0 20 20" aria-hidden="true" focusable="false"><path d="M4 10.5l4 4 8-9" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>Private, in your browser</li></ul></div>
<div class="ac" id="heroAuth">
<div id="ha-out"><h2>Create your account</h2><p class="acs">Save your plan and take it with you, on any device.</p><ul class="acl"><li>Save your plan and family details</li><li>Download your PDF summary</li><li>Get an editable Excel dashboard</li></ul>
<button class="btn go lg" type="button" data-auth="su">Sign up</button>
<div class="alt"><span>Already have an account?</span><button class="btn lg" type="button" data-auth="li">Login</button></div></div>
<div id="ha-in" hidden><h2 id="ha-hi">Welcome back</h2><p class="acs">Pick up where you left off.</p>
<div class="hbtns"><button class="btn go lg" type="button" data-go="nw">Continue my plan</button><a class="btn lg" href="#report">Download reports</a></div><div id="ha-pts" class="ptsstrip"></div></div>
</div></div></section>

<section class="w" id="planner">
<nav class="pills" aria-label="Steps"><button class="pill" id="pl-nw" data-go="nw" type="button"><i>1</i><b>Net worth</b></button><button class="pill" id="pl-exp" data-go="exp" type="button"><i>2</i><b>Income and Expense</b></button><button class="pill" id="pl-plan" data-go="plan" type="button"><i>3</i><b>Retirement plan</b></button><button class="pill" id="pl-swp" data-go="swp" type="button"><i>4</i><b>Withdrawal Plan</b></button></nav>

<section id="s-nw"><div class="sh"><h2>Step 1: Your Net Worth Today</h2><p>Add your assets (what you own) and liabilities (what you owe). Net worth = Assets − Liabilities. Leave blank if none. Results update as you type.</p></div>
<div class="cols"><div class="panel"><h3>About you</h3><div class="fg" id="f-me"></div>
<h3 class="sp">Liquid assets <small style="font-weight:400;color:var(--mu)">(cash or easily converted to cash)</small></h3><div class="fg" id="f-a"></div><div id="c-L"></div><button class="btn small" type="button" data-addA="L" style="margin-bottom:6px">+ Add another liquid asset</button>
<h3 class="sp">Non-liquid assets <small style="font-weight:400;color:var(--mu)">(long-term or hard to sell quickly)</small></h3><div class="fg" id="f-a2"></div><div id="c-I"></div><button class="btn small" type="button" data-addA="I" style="margin-bottom:6px">+ Add another non-liquid asset</button>
<h3 class="sp">Liabilities <small style="font-weight:400;color:var(--mu)">(debts you owe)</small></h3><div class="fg" id="f-l"></div>
<div class="row"><button class="btn small" type="button" data-sample>Try sample numbers</button><button class="btn small" type="button" data-clear="nw">Clear</button><button class="btn go small" type="button" data-submit="nw">Submit</button></div></div>
<div class="res" id="r-nw"></div></div>
<div class="nr"><span></span><button class="btn pri" type="button" data-go="exp">Next: Income and Expense</button></div></section>

<section id="s-exp" hidden><div class="sh"><h2>Step 2: Where does your money go?</h2><p>Enter your monthly income and costs. Tick Essential for things you cannot skip. The rest is what you can cut.</p></div>
<div class="cols"><div class="panel"><h3>Income</h3><div class="fg" id="f-i"></div>
<h3 class="sp">Monthly expenses</h3><div class="fg" id="f-e"></div><div id="c-X"></div><button class="btn small" type="button" data-addA="X" style="margin-bottom:12px">+ Add expense category</button>
<h3 class="sp">Your protection <small style="font-weight:400;color:var(--mu)">(life insurance, health insurance and emergency money)</small></h3><div class="fg" id="f-pr"></div>
<div class="row"><button class="btn small" type="button" data-sample>Try sample numbers</button><button class="btn small" type="button" data-clear="exp">Clear</button><button class="btn go small" type="button" data-submit="exp">Submit</button></div></div>
<div class="res" id="r-exp"></div></div>
<div class="nr"><button class="btn" type="button" data-go="nw">Back</button><button class="btn pri" type="button" data-go="plan">Next: Retirement plan</button></div></section>

<section id="s-plan" hidden><div class="sh"><h2>Step 3: Plan your retirement</h2><p>See the fund you need, what you will have, and the monthly investment that closes the gap. Boxes marked as filled come from your earlier steps.</p></div>
<div class="cols"><div class="panel"><h3>Your plan</h3><div class="fg" id="f-p"></div><div class="row" style="margin-top:12px"><button class="btn small" type="button" data-sample>Try sample numbers</button><button class="btn small" type="button" data-reset3>Clear</button><button class="btn go small" type="button" data-submit="plan">Submit</button></div></div>
<div class="res" id="r-plan"></div></div>
<div class="nr"><button class="btn" type="button" data-go="exp">Back</button><button class="btn pri" type="button" data-go="swp">Next: Withdrawal Plan</button></div></section>

<section id="s-swp" hidden><div class="sh"><h2>Step 4: Year by year, with your life goals</h2><p>See your fund grow, then pay you every year after retirement. In any year, add an amount for a life goal such as education, marriage or a car, and watch the fund change.</p></div>
<div class="panel ctl" style="margin-bottom:16px">
<div class="fd"><label for="mode">Plan uses</label><select class="sel" id="mode"></select></div>
<div class="fd"><label for="show">Show</label><select class="sel" id="show"><option value="all">All years</option><option value="post">Retirement years only</option></select></div>
<div class="fd" style="flex:1 1 100%;grid-column:1/-1;width:100%"><label>Your life goals (add as many as you need)</label><div id="gl"></div><button class="btn small" id="gadd" type="button">+ Add life goal</button></div></div>
<div id="r-sw"></div>
<div class="panel"><div class="row" style="justify-content:space-between;margin-bottom:10px"><h3 style="margin:0">Year-by-year table</h3><span class="row noprint"><button class="link" id="jump" type="button">Jump to retirement</button><button class="link" id="clrg" type="button">Remove all goals</button><button class="link" data-jr="checklist" type="button">Next: Checklist</button></span></div>
<p style="margin:0 0 12px;color:var(--mu);font-size:14px">Growth = yearly rate × (start fund + half of the year's net flow). Goal costs grow with price rise until the year you pay them. Type a goal amount in any row.</p>
<div class="tw" id="tw"><table><thead><tr><th>Age</th><th>Fund at start</th><th>Saved (+) or living cost (−)</th><th>Growth</th><th>Life goal (today's <span class="cs">₹</span>)</th><th>Goal cost then</th><th>Fund at end</th></tr></thead><tbody id="tb"></tbody></table></div></div>
<div class="panel noprint" style="margin-top:16px"><h3>Done with your plan? Submit to continue</h3><p style="color:var(--mu);margin:0 0 12px;font-size:14px">Your plan is ready. Next, see what to do at every age. Then add your family and download one complete report.</p><div class="row"><button class="btn small" type="button" data-sgoals>Try sample goals</button><button class="btn small" type="button" id="clrg2">Clear goals</button><button class="btn go small" type="button" data-submit="swp">Submit</button></div></div>
<div class="nr"><button class="btn" type="button" data-go="plan">Back</button></div></section>
</section>
<section class="w tst" id="testimonials" aria-labelledby="tst-h">
<span class="tst-k">Kind words</span><h2 id="tst-h">What people say about Retirement Plan Karo</h2>
<p class="tst-s">Here is what people liked about planning their retirement here.</p>
<div class="tst-g"><figure class="tst-c"><blockquote>I finished my plan in one sitting. The steps are short and the language is simple.</blockquote><figcaption><span class="tst-a" aria-hidden="true">V</span>Vaibhav</figcaption></figure><figure class="tst-c"><blockquote>Seeing my plan year by year made things much clearer for me.</blockquote><figcaption><span class="tst-a" aria-hidden="true">A</span>Aishwary</figcaption></figure><figure class="tst-c"><blockquote>I like that each step explains how the numbers are calculated.</blockquote><figcaption><span class="tst-a" aria-hidden="true">K</span>Kuber</figcaption></figure><figure class="tst-c"><blockquote>Easy to use on my phone. The buttons and text are big and clear.</blockquote><figcaption><span class="tst-a" aria-hidden="true">M</span>Mahaveer</figcaption></figure><figure class="tst-c"><blockquote>The checklist told me what to look at next, one step at a time.</blockquote><figcaption><span class="tst-a" aria-hidden="true">P</span>Padmavati</figcaption></figure><figure class="tst-c"><blockquote>The Family Dashboard puts everyone’s details in one place. It is very handy.</blockquote><figcaption><span class="tst-a" aria-hidden="true">L</span>Laxmi</figcaption></figure><figure class="tst-c"><blockquote>No heavy words. I could follow every step without any help.</blockquote><figcaption><span class="tst-a" aria-hidden="true">S</span>Sharda</figcaption></figure><figure class="tst-c"><blockquote>I liked that it shows the numbers and leaves the decision to me.</blockquote><figcaption><span class="tst-a" aria-hidden="true">R</span>Riddhi</figcaption></figure></div>
<!-- Reminder: each person should confirm their quote before this goes live. -->
<p class="tst-s" style="margin-top:14px;font-size:13px">Testimonials are individual opinions, shared with permission, and are not a promise or guarantee of any result. This tool is for education only.</p></section>
</div>

<div id="v-checklist" class="w pg" hidden><div class="sh"><h2>What to do at every age</h2><p>Pick your decade and tick what you have done. Your age from Step 1 picks the list for you.</p></div>
<div class="chips" role="group" aria-label="Age group"><button class="chip" type="button" data-age="20s" aria-pressed="false">20s</button><button class="chip" type="button" data-age="30s" aria-pressed="false">30s</button><button class="chip" type="button" data-age="40s" aria-pressed="false">40s</button><button class="chip" type="button" data-age="50s" aria-pressed="false">50s</button><button class="chip" type="button" data-age="60p" aria-pressed="false">60+</button></div>
<div class="ckpanel" id="ck-20s" hidden><h3 class="sr" style="margin:10px 0 0;font-size:17px">In your 20s</h3><label class="ck"><input type="checkbox" class="ckitem"><span>Build an emergency money of 3 to 6 months of expenses</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Buy a personal health insurance policy</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Start a monthly investment, even a small one, and raise it every year</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Avoid credit card dues and costly personal loans</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Learn the basics of shares, safe savings and rising prices</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Keep your EPF when you change jobs</span></label></div>
<div class="ckpanel" id="ck-30s" hidden><h3 class="sr" style="margin:10px 0 0;font-size:17px">In your 30s</h3><label class="ck"><input type="checkbox" class="ckitem"><span>Set up a monthly investment with a yearly increase</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Buy life insurance if anyone depends on your income</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Repay costly loans before you add new investments</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Choose a target mix of investments and invest towards it</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Name who gets the money (nominee) in every account</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Open a separate fund for your child&#x27;s education</span></label></div>
<div class="ckpanel" id="ck-40s" hidden><h3 class="sr" style="margin:10px 0 0;font-size:17px">In your 40s</h3><label class="ck"><input type="checkbox" class="ckitem"><span>Work out your retirement fund with real numbers</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Raise your monthly investment to close any gap</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Review health cover for the whole family</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Check your mix of investments and reset it once a year</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Plan to clear your home loan before you retire</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Do not withdraw your EPF when you change jobs</span></label></div>
<div class="ckpanel" id="ck-50s" hidden><h3 class="sr" style="margin:10px 0 0;font-size:17px">In your 50s</h3><label class="ck"><input type="checkbox" class="ckitem"><span>Check your fund gap every year</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Move slowly from shares to safer savings</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Clear remaining loans before retirement</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Write a will and keep a list of your accounts</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Plan how you will pay for healthcare</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Think about part-time or consulting income</span></label></div>
<div class="ckpanel" id="ck-60p" hidden><h3 class="sr" style="margin:10px 0 0;font-size:17px">At 60 and beyond</h3><label class="ck"><input type="checkbox" class="ckitem"><span>Keep 2 to 3 years of expenses in safe savings</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Start taking money out carefully and raise it as prices rise</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Review health and life cover</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Keep nominee names and papers up to date</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Take out a little less after a bad market year</span></label><label class="ck"><input type="checkbox" class="ckitem"><span>Review your plan once a year</span></label></div>
<div class="ckbar"><span id="ckt"></span><div class="meter"><i id="ckf" style="width:0"></i></div></div>
<div class="nr noprint"><button class="btn" type="button" data-jr="plan">← Back: Plan</button><button class="btn pri" type="button" data-jr="family">Next: Family →</button></div></div>

<div id="v-family" class="w pg" hidden></div>
<div id="v-report" class="w pg" hidden></div>
<div id="v-explore" class="w pg" hidden></div>
<div id="v-lock" class="w pg" hidden></div>
<div id="v-learn" class="w pg" hidden><div class="sh"><h2>Learn</h2><p>Plain-English guides. Pick a topic.</p></div>
<div class="chips" role="tablist"><button class="chip lt" role="tab" data-t="guides">Learn</button><button class="chip lt" role="tab" data-t="myths">Common beliefs</button><button class="chip lt" role="tab" data-t="words">Money words</button><button class="chip lt" role="tab" data-t="faq">Most asked questions</button></div>
<div class="lp" id="lp-guides"><div class="lgrid"><details class="art" id="a-compounding"><summary><span class="catg">Basics</span>Compounding: your money earns money</summary><div class="body"><p>Compounding means your returns earn returns of their own. A SIP of ₹10,000 a month at 12% a year for 20 years grows to about ₹98.9 lakh, although you put in only ₹24 lakh.</p><p>Time does most of the work. The same SIP for 10 years gives about ₹23 lakh. Doubling the time gives more than four times the money.</p><p class="do"><b>Do this:</b> Start now, even small, and raise the amount every year.</p><button class="btn small" type="button" data-open="plan">Open the retirement planner →</button></div></details>
<details class="art" id="a-inflation"><summary><span class="catg">Basics</span>Inflation: the quiet cost of living</summary><div class="body"><p>Inflation is the yearly rise in prices. At 6% a year, prices double about every 12 years (72 ÷ 6).</p><p>A household that spends ₹50,000 a month today will need about ₹2.87 lakh a month in 30 years to live the same way.</p><p class="do"><b>Do this:</b> Plan with a realistic inflation rate, and use a higher one for medical costs.</p><button class="btn small" type="button" data-open="plan">Open the corpus calculator →</button></div></details>
<details class="art" id="a-corpus"><summary><span class="catg">Plan</span>How big should your retirement corpus be?</summary><div class="body"><p>Your corpus is the total savings you need on the day you retire. It depends on your monthly expenses at that time (after inflation), how many years you will live in retirement and the returns you earn on the money.</p><p>A common rule of thumb is 25 times your yearly expenses, which means withdrawing 4% a year. That rule comes from long-term US data. Prices rise faster in India and people live longer, so check it against a full calculation like the one in Step 3.</p><p class="do"><b>Do this:</b> Count every year till 90 or later, not only till the average life expectancy.</p><button class="btn small" type="button" data-open="plan">Find my corpus →</button></div></details>
<details class="art" id="a-sip"><summary><span class="catg">Invest</span>SIP and the step-up habit</summary><div class="body"><p>A Systematic Investment Plan (SIP) invests a fixed amount every month. You buy more units when prices are low and fewer when they are high, so you do not need to time the market.</p><p>A yearly step-up raises the SIP as your income grows. In the sample plan, a 5% yearly step-up cuts the starting SIP you need by about a third.</p><p class="do"><b>Do this:</b> Automate the SIP for salary day and never pause it in a market fall.</p><button class="btn small" type="button" data-open="plan">Open the retirement planner →</button></div></details>
<details class="art" id="a-goals"><summary><span class="catg">Plan</span>Plan big goals separately from retirement</summary><div class="body"><p>Children&#x27;s education, marriage, a car, a home or a foreign trip have a fixed date and cost. Retirement has no loan: you can borrow for education, but you cannot borrow for your old age. So protect the retirement fund first.</p><p>Education costs often rise faster than general inflation. Money needed within about 3 years is safer in an FD or debt fund than in equity. If you pay goals from your retirement SIP, every rupee you take out stops compounding for your retirement.</p><p class="do"><b>Do this:</b> List each goal with a year and a price, then add each one to the year-by-year table in Step 4.</p><button class="btn small" type="button" data-open="swp">Plan my goals →</button></div></details>
<details class="art" id="a-emergency"><summary><span class="catg">Protect</span>Build your emergency fund first</summary><div class="body"><p>An emergency fund is money you can reach in a day for job loss, illness or urgent repairs. Keep about 6 months of essential expenses in a savings account, a short-term FD or a liquid fund.</p><p>Without it, a crisis forces you to sell investments at a bad time or take a costly loan.</p><p class="do"><b>Do this:</b> Fill this before you raise your SIP.</p><button class="btn small" type="button" data-open="exp">Check my expenses →</button></div></details>
<details class="art" id="a-allocation"><summary><span class="catg">Invest</span>Asset allocation and rebalancing</summary><div class="body"><p>Asset allocation is how you split money between equity (growth), debt (stability), gold and cash. Younger investors usually hold more equity. As retirement comes closer, move gradually towards debt.</p><p>A simple starting point for equity is 100 minus your age, as a percentage of your financial assets. Rebalance once a year if one part drifts far from your plan. Avoid putting most of your wealth in one house or one asset.</p><p class="do"><b>Do this:</b> Check your mix in Step 1 and act on the guidance.</p><button class="btn small" type="button" data-open="nw">Check my asset mix →</button></div></details>
<details class="art" id="a-epfppfnps"><summary><span class="catg">Invest</span>EPF, PPF and NPS in your plan</summary><div class="body"><p>EPF is the provident fund for salaried employees. PPF is a government-backed long-term savings scheme with a 15-year lock-in. NPS is a market-linked pension account where part of the money must buy an annuity when you exit.</p><p>Rates, limits and exit rules change from time to time, so check the latest from EPFO, your bank or post office, and PFRDA. Treat these as the steady part of your plan, not the whole plan.</p><p class="do"><b>Do this:</b> Record each balance in Step 1 so the planner counts them.</p><button class="btn small" type="button" data-open="nw">Open net worth →</button></div></details>
<details class="art" id="a-swp"><summary><span class="catg">Withdraw</span>SWP: your own monthly pension</summary><div class="body"><p>A Systematic Withdrawal Plan (SWP) pays you a fixed amount every month from a mutual fund or other corpus while the rest stays invested.</p><p>Raise the withdrawal each year for inflation. Many planners keep the first-year withdrawal near 3% to 4% of the corpus. A higher rate runs the money down faster.</p><p class="do"><b>Do this:</b> Test your numbers in Step 4 and check the safe withdrawal shown there.</p><button class="btn small" type="button" data-open="swp">Test my withdrawals →</button></div></details>
<details class="art" id="a-sequence"><summary><span class="catg">Withdraw</span>Sequence-of-returns risk</summary><div class="body"><p>A market fall in the first few years of retirement hurts far more than the same fall later, because you are withdrawing while prices are low.</p><p>Keep 2 to 3 years of expenses in safe assets such as FDs or debt funds, so you do not have to sell equity in a down year. Be ready to trim withdrawals for a year or two.</p><p class="do"><b>Do this:</b> Set aside a bucket of safe money before you retire.</p><button class="btn small" type="button" data-open="swp">Test my withdrawals →</button></div></details>
<details class="art" id="a-health"><summary><span class="catg">Protect</span>Health and life insurance</summary><div class="body"><p>Medical costs usually rise faster than general inflation, and employer cover often ends when you leave or retire. Buy a personal health policy early, when it is cheaper and easier to get.</p><p>If others depend on your income, term life insurance protects them. A common rule of thumb is a cover of 10 to 15 times your yearly income.</p><p class="do"><b>Do this:</b> Make sure premiums appear in your expense sheet.</p><button class="btn small" type="button" data-open="exp">Check my expenses →</button></div></details>
<details class="art" id="a-debt"><summary><span class="catg">Protect</span>Clear costly debt before you retire</summary><div class="body"><p>Credit card, personal and overdraft loans often charge more than your investments earn, so repaying them is a sure gain. Try to keep total EMIs under about 40% of your income.</p><p>Aim to clear your home loan before you retire so your fixed costs fall when your income does.</p><p class="do"><b>Do this:</b> List every loan in Step 1 and repay the costliest first.</p><button class="btn small" type="button" data-open="nw">Open net worth →</button></div></details>
<details class="art" id="a-tax"><summary><span class="catg">Withdraw</span>Think about tax on retirement income</summary><div class="body"><p>Interest, capital gains, pension and annuity income are taxed in different ways, and tax rules change in most Budgets. This planner does not include tax.</p><p>Your take-home amount can be lower than your withdrawal. Ask a chartered accountant to check the latest rules before you decide where to keep your money.</p><p class="do"><b>Do this:</b> Add a margin to your expenses to allow for tax.</p><button class="btn small" type="button" data-open="swp">Test my withdrawals →</button></div></details>
<details class="art" id="a-estate"><summary><span class="catg">Protect</span>Nominees, will and documents</summary><div class="body"><p>Check that every bank account, mutual fund, insurance policy, EPF and NPS has a nominee. A written will and a simple list of your accounts and who to call saves your family time and stress.</p><p>Review nominees after major life events such as marriage, children or the loss of a parent.</p><p class="do"><b>Do this:</b> Keep a one-page list of all accounts where your family can find it.</p><button class="btn small" type="button" data-open="swp">Open my plan →</button></div></details></div></div>
<div class="lp" id="lp-myths" hidden><p style="color:var(--mu);margin:0 0 14px">Ideas that sound right but can leave you short.</p><div class="myths"><div class="myth"><p class="m">&quot;I will start saving when I earn more.&quot;</p><p class="f"><b>Fact:</b> Starting late costs more than saving a little early. In a typical plan, a 5-year delay can cut the final fund by nearly half.</p></div>
<div class="myth"><p class="m">&quot;My EPF or PPF is enough.&quot;</p><p class="f"><b>Fact:</b> Often it is not. Inflation raises your costs every year, so check your balance against the corpus you really need.</p></div>
<div class="myth"><p class="m">&quot;Equity is too risky for retirement.&quot;</p><p class="f"><b>Fact:</b> Over long periods some equity helps beat inflation. Hold less as retirement nears, and keep safe money for the first years.</p></div>
<div class="myth"><p class="m">&quot;My employer or the government will pay a pension.&quot;</p><p class="f"><b>Fact:</b> Most private-sector workers have no guaranteed pension. EPF and NPS balances are savings you must plan to turn into income.</p></div>
<div class="myth"><p class="m">&quot;Expenses fall a lot after retirement.&quot;</p><p class="f"><b>Fact:</b> Some costs fall, such as travel to work, but medical costs rise. Plan for 70% to 100% of your current spending, not less.</p></div>
<div class="myth"><p class="m">&quot;Real estate is my retirement plan.&quot;</p><p class="f"><b>Fact:</b> Property is hard to sell quickly and pays no monthly income unless rented. Keep most of your retirement money in financial assets.</p></div>
<div class="myth"><p class="m">&quot;A SIP guarantees returns.&quot;</p><p class="f"><b>Fact:</b> A SIP only spreads your purchases over time. Returns depend on the market and can be low or negative in some years.</p></div>
<div class="myth"><p class="m">&quot;Employer health cover is enough.&quot;</p><p class="f"><b>Fact:</b> Cover often ends when you leave or retire. Buy a personal policy early.</p></div></div></div>
<div class="lp" id="lp-words" hidden><input id="gsearch" class="gsearch" type="search" placeholder="Search a word, for example SIP" aria-label="Search money words" autocomplete="off"><dl class="glist" id="glist"><div class="gterm"><dt>Annuity</dt><dd>A product that pays you a fixed income, usually for life, in exchange for a lump sum.</dd></div><div class="gterm"><dt>Asset allocation</dt><dd>How your money is split between equity, debt, gold, cash and property.</dd></div><div class="gterm"><dt>Bond</dt><dd>A loan you give to a government or company. It pays interest and returns your money at the end.</dd></div><div class="gterm"><dt>Compounding</dt><dd>Earning returns on your earlier returns, so growth speeds up over time.</dd></div><div class="gterm"><dt>Corpus</dt><dd>The total savings you build or need for a goal such as retirement.</dd></div><div class="gterm"><dt>Credit risk</dt><dd>The chance that a borrower fails to pay back what it owes.</dd></div><div class="gterm"><dt>Debt fund</dt><dd>A mutual fund that invests in bonds and similar loans, usually with lower risk than equity.</dd></div><div class="gterm"><dt>Diversification</dt><dd>Spreading money across different assets so one bad result does not hurt too much.</dd></div><div class="gterm"><dt>EPF</dt><dd>Employees&#x27; Provident Fund. A retirement savings account for salaried employees and their employers.</dd></div><div class="gterm"><dt>ETF</dt><dd>Exchange-traded fund. A fund that trades on the stock exchange and usually tracks an index.</dd></div><div class="gterm"><dt>Emergency fund</dt><dd>Easy-to-reach money kept for job loss, illness or urgent repairs.</dd></div><div class="gterm"><dt>Equity</dt><dd>Ownership in companies, such as shares and equity mutual funds. Higher growth, higher risk.</dd></div><div class="gterm"><dt>Expense ratio</dt><dd>The yearly fee a mutual fund charges, shown as a percentage of your money.</dd></div><div class="gterm"><dt>FD</dt><dd>Fixed deposit. Money kept with a bank for a set time at a fixed interest rate.</dd></div><div class="gterm"><dt>Glide path</dt><dd>A plan that moves your money from equity towards debt as you get older.</dd></div><div class="gterm"><dt>Index fund</dt><dd>A fund that copies a market index, often with low costs.</dd></div><div class="gterm"><dt>Inflation</dt><dd>The yearly rise in prices that lowers what your money can buy.</dd></div><div class="gterm"><dt>Liquid asset</dt><dd>Something you can turn into cash quickly without a big loss, such as bank savings.</dd></div><div class="gterm"><dt>Liquidity</dt><dd>How quickly you can turn an asset into cash.</dd></div><div class="gterm"><dt>Longevity risk</dt><dd>The risk of outliving your money because you live longer than planned.</dd></div><div class="gterm"><dt>Lump sum</dt><dd>A single large investment made at one time.</dd></div><div class="gterm"><dt>Mutual fund</dt><dd>A pool of money from many investors, managed by professionals and invested in shares, bonds or both.</dd></div><div class="gterm"><dt>NAV</dt><dd>Net asset value. The price of one unit of a mutual fund.</dd></div><div class="gterm"><dt>NPS</dt><dd>National Pension System. A market-linked pension account where part of the money buys an annuity at exit.</dd></div><div class="gterm"><dt>Net worth</dt><dd>Everything you own minus everything you owe.</dd></div><div class="gterm"><dt>P2P lending</dt><dd>Lending money to individuals or businesses through an online platform. It carries default risk.</dd></div><div class="gterm"><dt>PPF</dt><dd>Public Provident Fund. A government-backed long-term savings scheme with a 15-year lock-in.</dd></div><div class="gterm"><dt>Real return</dt><dd>Your return after taking away inflation.</dd></div><div class="gterm"><dt>Rebalancing</dt><dd>Selling a little of what has grown and buying what has lagged, to return to your target mix.</dd></div><div class="gterm"><dt>Rule of 72</dt><dd>A quick way to find how long money takes to double: divide 72 by the yearly return.</dd></div><div class="gterm"><dt>Rupee cost averaging</dt><dd>Investing a fixed amount regularly, so you buy more units when prices are low.</dd></div><div class="gterm"><dt>SCSS</dt><dd>Senior Citizens&#x27; Savings Scheme. A government-backed savings scheme for people above a set age.</dd></div><div class="gterm"><dt>SIP</dt><dd>Systematic Investment Plan. A fixed amount invested every month.</dd></div><div class="gterm"><dt>SWP</dt><dd>Systematic Withdrawal Plan. A fixed amount taken out of your investment every month.</dd></div><div class="gterm"><dt>Safe withdrawal rate</dt><dd>The share of your corpus you can withdraw each year with a low chance of running out.</dd></div><div class="gterm"><dt>Sequence risk</dt><dd>The risk that poor market returns early in retirement drain your corpus faster.</dd></div><div class="gterm"><dt>Step-up SIP</dt><dd>A SIP that rises by a set percentage each year.</dd></div><div class="gterm"><dt>Term insurance</dt><dd>Pure life cover that pays your family if you die during the policy term.</dd></div><div class="gterm"><dt>Volatility</dt><dd>How much the price of an investment moves up and down.</dd></div></dl><p id="gc" style="color:var(--mu);font-size:14px"></p></div>
<div class="lp" id="lp-faq" hidden><div class="lgrid"><details class="art"><summary>How much money do I need to retire?</summary><div class="body"><p>It depends on your expenses, your retirement age and how long you want your money to last. A common rule of thumb is 25 times your yearly expenses at retirement. For your own number, use Step 3, which adds up every future withdrawal after inflation.</p><button class="btn small" type="button" data-open="plan">Find my corpus →</button></div></details>
<details class="art"><summary>When should I start planning for retirement?</summary><div class="body"><p>As early as you can. Time is the biggest factor in compounding, and a few years of delay can cost a large share of your final fund.</p><button class="btn small" type="button" data-open="plan">Open the retirement planner →</button></div></details>
<details class="art"><summary>How much of my income should I save?</summary><div class="body"><p>A common starting point is 20% of your take-home income, and more if you start late. Step 2 shows your saving rate and how cutting expenses can raise it.</p><button class="btn small" type="button" data-open="exp">Check my expenses →</button></div></details>
<details class="art"><summary>Is the 4% rule right for India?</summary><div class="body"><p>The 4% rule comes from US data. Indian inflation has been higher, and retirements are getting longer, so many planners start lower, around 3% to 3.5%. Step 4 tests your own numbers and shows a safe starting withdrawal.</p><button class="btn small" type="button" data-open="swp">Test my withdrawals →</button></div></details>
<details class="art"><summary>What return should I assume?</summary><div class="body"><p>Use a number you would be comfortable with if markets disappoint. Long-term equity returns are not guaranteed, so check what happens with a return 2% lower. The SIP step shows this.</p><button class="btn small" type="button" data-open="plan">Try the what-if table →</button></div></details>
<details class="art"><summary>What is the difference between SIP and SWP?</summary><div class="body"><p>A SIP puts money in every month while you build your corpus. An SWP takes money out every month once you retire.</p><button class="btn small" type="button" data-open="swp">Open the SWP planner →</button></div></details>
<details class="art"><summary>Should I invest a lump sum or a SIP?</summary><div class="body"><p>A SIP spreads your purchases and reduces the risk of investing everything at a bad time. If you have a lump sum, many people invest it in stages over several months.</p></div></details>
<details class="art"><summary>Are EPF, PPF and NPS enough?</summary><div class="body"><p>They are a useful base, but for many people they do not cover all expenses after inflation. Add them in Step 1 and compare your total with the corpus you need.</p><button class="btn small" type="button" data-open="nw">Open net worth →</button></div></details>
<details class="art"><summary>How big should my emergency fund be?</summary><div class="body"><p>About 6 months of essential expenses, in a bank account, a short-term FD or a liquid fund.</p><button class="btn small" type="button" data-open="exp">Check my expenses →</button></div></details>
<details class="art"><summary>What if I am already close to retirement?</summary><div class="body"><p>Focus on safe withdrawals, health insurance, clearing loans and keeping 2 to 3 years of expenses in safe assets. Use Steps 5 and 6 to test how long your money will last.</p><button class="btn small" type="button" data-open="plan">Open the corpus step →</button></div></details>
<details class="art"><summary>Which inflation rate should I use?</summary><div class="body"><p>Many Indian planners use 6% for general costs. Medical costs usually rise faster, so a cautious plan uses a higher rate or a separate health budget.</p></div></details>
<details class="art"><summary>Can I pay for my child&#x27;s education and marriage from my retirement SIP?</summary><div class="body"><p>You can, but the money you take out stops growing for retirement. Step 4 shows the SIP each goal needs and what is left for retirement. If it is short, raise your SIP, move a goal later or lower its cost.</p><button class="btn small" type="button" data-open="swp">Plan my goals →</button></div></details>
<details class="art"><summary>Is my data saved or shared?</summary><div class="body"><p>No. All calculations run in your browser and your plan numbers are not sent anywhere. Contact details you give at sign-up, and a summary result such as your score, may be sent to us as explained in the Privacy Policy.</p></div></details>
<details class="art"><summary>Is this financial advice?</summary><div class="body"><p>No. Retirement Plan Karo is an education tool. Results depend on your inputs and on assumptions that may not come true. Please talk to a SEBI-registered investment adviser or a chartered accountant before you decide.</p></div></details>
<details class="art"><summary>How are the calculations done?</summary><div class="body"><p>Monthly compounding at the yearly rate divided by 12. SIPs are paid at the end of each month and withdrawals are taken at the start of each month. Every step has a &quot;How is this calculated?&quot; box.</p></div></details></div></div></div>
</main>
<footer><div class="w"><p style="margin:0 0 8px"><b>Education only. Not investment, tax, insurance, credit or legal advice.</b> Retirement Plan Karo provides learning tools and calculators. Nothing here is a recommendation or an offer to buy, sell or hold any product. Results are estimates based on your inputs and assumptions that may not come true, and real outcomes can be very different.</p>
<p style="margin:0 0 8px">Investments in the securities market, including mutual funds, are subject to market risks. Read all scheme-related documents carefully. Past performance does not guarantee future results. Insurance is the subject matter of solicitation. Loans and credit cards are subject to the lender's approval and terms. We are not a bank, insurer, lender or fund house, and we may earn a referral fee from partners at no extra cost to you.</p>
<p style="margin:0 0 10px">Please talk to a SEBI-registered investment adviser, a chartered accountant or another qualified professional before you decide. You alone are responsible for your decisions. Calculations run in your browser. Page translation is machine-generated and may be inaccurate.</p>
<button class="link" type="button" data-legal="risk">Risk Disclosure</button> · <button class="link" type="button" data-legal="quotes">Quotes and Referral Disclosure</button> · <button class="link" type="button" data-legal="privacy">Privacy Policy</button> · <button class="link" type="button" data-legal="terms">Terms</button> · <button class="link" type="button" data-legal="refund">Refund Policy</button> · <button class="link" type="button" data-legal="grievance">Grievance</button> · Contact: <a class="mail" href="mailto:Retirementplankaro@gmail.com">Retirementplankaro@gmail.com</a></div></footer>
<div class="ov" id="auth" hidden role="dialog" aria-modal="true" aria-labelledby="at"><div class="box"><button class="link" id="ax" type="button" aria-label="Close" style="float:right">✕</button><h3 id="at">Login or Sign up to download</h3><p style="color:var(--mu);margin:6px 0 12px;font-size:14px">It takes a minute. Your report is ready right after.<br><b style="color:var(--br)">⭐ Earn 100 points for every friend you refer.</b></p><div class="chips"><button class="chip" type="button" data-at="su" aria-pressed="true">Sign up</button><button class="chip" type="button" data-at="li" aria-pressed="false">Login</button></div><form id="fsu" novalidate></form><form id="fli" novalidate hidden></form></div></div>
<div class="ov" id="cf" hidden role="dialog" aria-modal="true" aria-labelledby="cft"><div class="box"><button class="link" id="cfx" type="button" aria-label="Close" style="float:right">✕</button><h3 id="cft">Before you download</h3><p style="color:var(--mu);font-size:14px;margin:6px 0 12px">Please confirm to continue.</p><label class="ck"><input type="checkbox" id="cf-ok"><span>I have read the <button class="link" type="button" data-legal="risk">Risk Disclosure</button>. I understand this report is an educational estimate based on my own inputs and assumptions, it is not investment, tax or legal advice, and I am responsible for my own financial decisions. *</span></label><button class="btn pri" id="cf-go" type="button" disabled style="margin-top:14px">Download report</button></div></div>
<div class="ov" id="legal" hidden role="dialog" aria-modal="true" aria-label="Legal"><div class="box" style="max-width:640px"><button class="link" id="lgx" type="button" aria-label="Close" style="float:right">✕</button><div id="lgb"></div></div></div>
<div class="ov" id="fm" hidden role="dialog" aria-modal="true" aria-labelledby="fmt"><div class="box" style="max-width:560px"><button class="link" id="fmx" type="button" aria-label="Close" style="float:right">✕</button><h3 id="fmt">Add family member</h3><form id="ffm" novalidate></form></div></div>
<div class="ov" id="gs" hidden role="dialog" aria-modal="true" aria-labelledby="gst"><div class="box" style="max-width:520px"><button class="link" id="gsx" type="button" aria-label="Close" style="float:right">✕</button><div id="gsb"></div></div></div>
<div class="ov" id="pay" hidden role="dialog" aria-modal="true" aria-labelledby="payt"><div class="box" style="max-width:520px"><button class="link" id="payx" type="button" aria-label="Close" style="float:right">✕</button><div id="payb"></div></div></div>
<div class="toast" id="toast" role="status"></div>

<div id="shield" hidden aria-hidden="true"><div><b>Content hidden</b><p>Screenshots and screen capture are turned off on this site. Return to this tab to continue.</p></div></div>
<div id="gt_el" aria-hidden="true" style="position:absolute;left:-9999px;top:0;width:1px;height:1px;overflow:hidden"></div><script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script><div id="gt_el" aria-hidden="true" style="position:absolute;left:-9999px;top:0;width:1px;height:1px;overflow:hidden"></div><script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js"></script>
<script>
const $=s=>document.querySelector(s),$$=s=>[...document.querySelectorAll(s)],v=id=>parseFloat($('#'+id).value)||0;
const CT={};'IN|India|INR|₹|1|en-IN|6,10,7;US|United States|USD|$|88|en-US|3,8,5;GB|United Kingdom|GBP|£|117|en-GB|3,7,4.5;EU|Eurozone (Germany, France...)|EUR|€|102|de-DE|2.5,6,4;AE|UAE|AED|AED|24|en-US|2.5,7,5;SA|Saudi Arabia|SAR|SAR|23.5|en-US|2.5,7,5;QA|Qatar|QAR|QAR|24|en-US|2.5,7,5;CA|Canada|CAD|CAD|64|en-CA|2.5,7,5;AU|Australia|AUD|AUD|58|en-AU|3,7,5;NZ|New Zealand|NZD|NZD|51|en-NZ|3,7,5;SG|Singapore|SGD|SGD|68|en-SG|2.5,6,4;HK|Hong Kong|HKD|HKD|11.3|en-HK|2.5,6,4;CH|Switzerland|CHF|CHF|110|de-CH|1.5,5,3;JP|Japan|JPY|¥|0.59|ja-JP|1.5,5,3;MY|Malaysia|MYR|MYR|21|en-MY|3,7,5;PH|Philippines|PHP|PHP|1.55|en-PH|4,8,6;NP|Nepal|NPR|NPR|0.625|en-US|5,9,7;BD|Bangladesh|BDT|BDT|0.72|en-US|6,10,7;PK|Pakistan|PKR|PKR|0.31|en-US|8,12,9;ZA|South Africa|ZAR|ZAR|5|en-ZA|5,10,7;NG|Nigeria|NGN|NGN|0.06|en-NG|15,18,14'.split(';').forEach(x=>{const[k,n,c,sy,p,l,d]=x.split('|');CT[k]={n,c,s:sy,p:+p,l,d:d.split(',').map(Number)}});
let CC='IN';try{CC=localStorage.getItem('ctry')||'IN'}catch(e){}if(!CT[CC])CC='IN';
const inr=n=>{const C=CT[CC],a=Math.abs(Math.round(n)),g=n<-.5?'-':'',y=C.s.length>1?C.s+' ':C.s;if(CC==='IN')return g+y+(a>=1e7?(a/1e7).toFixed(2)+' Cr':a>=1e5?(a/1e5).toFixed(2)+' L':a.toLocaleString('en-IN'));return g+y+(a>=1e9?(a/1e9).toFixed(2)+' B':a>=1e6?(a/1e6).toFixed(2)+' M':a.toLocaleString(C.l))};
const csym=t=>t.split(CT[CC].s.trim()).join(CT[CC].c+' ').replace(/₹/g,'Rs. ');
const AS=[['bank','Cash & Savings Accounts'],['fd','Fixed Deposits & Bonds'],['eq','Stocks, Mutual Funds & ETFs'],['epf','Retirement Accounts (401k / IRA / Pension / Provident Fund)'],['gold','Gold & Precious Metals'],['re','Investment Real Estate'],['home','Primary Residence']];
const LI=[['hl','Mortgage'],['cl','Auto & Student Loans'],['pl','Personal Loans & Credit Cards'],['ol','Other Liabilities']];
const EX=[['Rent or home loan payment',1],['Groceries and food',1],['Bills and utilities',1],['Transport and fuel',1],['Insurance payments',1],['Medical',1],['Children and education',1],['Eating out and shopping',0],['Travel and fun',0],['Other',0]];
const COL=['#0F766E','#2563EB','#F59E0B','#059669','#7C3AED','#DB2777','#64748B'];
const fld=(id,l,o={})=>{const pre=o.pre===undefined?'₹':o.pre;return`<div class="fd"><label for="${id}">${l}</label><div class="in">${pre?`<i${pre==='₹'?' class="cs"':''}>${pre}</i>`:''}<input id="${id}" type="number" inputmode="decimal" min="0" step="${o.st||1000}" placeholder="${o.ph||0}"${o.val!=null?` value="${o.val}"`:''}${o.auto?' data-auto="1"':''}>${o.suf?`<i>${o.suf}</i>`:''}</div>${o.auto?'<small>Filled from your earlier steps. Edit if needed.</small>':''}</div>`};
const N={pre:'',st:1},R={pre:'',st:.5};
$('#f-me').innerHTML=fld('age','Your age now',{...N,ph:32,suf:'years'});
$('#f-a').innerHTML=AS.slice(0,3).map(([k,l])=>fld(k,l)).join('');$('#f-a2').innerHTML=AS.slice(3).map(([k,l])=>fld(k,l)).join('');
$('#f-l').innerHTML=LI.map(([k,l])=>fld(k,l)).join('');
$('#f-i').innerHTML=fld('inc','Monthly take-home income');
$('#f-e').innerHTML=EX.map(([l,e],i)=>`<div class="er">${fld('x'+i,l)}<label class="es"><input type="checkbox" id="e${i}"${e?' checked':''}>Essential</label></div>`).join('');
$('#f-p').innerHTML=[fld('ret','Retire at age',{...N,val:60,suf:'years'}),fld('life','Money should last till age',{...N,val:90,suf:'years'}),fld('exp','Monthly spending today',{auto:1}),fld('oth','Pension or rent after retiring, a month (today\'s value)'),fld('infl','Price rise',{...R,val:6,suf:'% a year'}),fld('rpre','Yearly growth before retiring',{...R,val:10,suf:'% a year'}),fld('rpost','Yearly growth after retiring',{...R,val:7,suf:'% a year'}),fld('cur','Savings kept for retirement today',{auto:1}),fld('sip','Monthly investment',{auto:1}),fld('step','Raise investment every year by',{...N,val:5,suf:'%'})].join('');
const esc=t=>String(t).replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
const crow=(k)=>{const d=document.createElement('div');d.className='er cr';d.innerHTML=`<div class="fd"><label>${k==='X'?'Category name':'Asset name'}</label><div class="in"><input class="cn" maxlength="40" placeholder="${k==='X'?'e.g. Pet care':'e.g. Crypto, Chit fund'}"></div></div><div class="fd"><label>${k==='X'?'Monthly amount':'Value'}</label><div class="in"><i class="cs">₹</i><input class="cv" type="number" inputmode="decimal" min="0" step="1000" placeholder="0"></div></div>${k==='X'?'<label class="es"><input type="checkbox" class="ce">Essential</label>':''}<button class="btn small" type="button" data-rm aria-label="Remove" style="margin-bottom:14px">✕</button>`;return d};
const cust=sel=>$$(sel+' .cr').map(r=>({n:r.querySelector('.cn').value.trim()||'Other',v:parseFloat(r.querySelector('.cv').value)||0,e:!!(r.querySelector('.ce')&&r.querySelector('.ce').checked)}));
const assetList=()=>[...AS.map(([k,l],i)=>({n:l,v:v(k),t:i<3?'L':'I'})),...cust('#c-L').map(x=>({...x,t:'L'})),...cust('#c-I').map(x=>({...x,t:'I'}))];
const expList=()=>[...EX.map(([l],i)=>({n:l,v:v('x'+i),e:$('#e'+i).checked})),...cust('#c-X')];
document.addEventListener('click',e=>{const a=e.target.closest('[data-addA]');if(a){const k=a.dataset.adda,box=$('#c-'+k);box.appendChild(crow(k));box.lastChild.querySelector('.cn').focus();return}const r=e.target.closest('[data-rm]');if(r){r.closest('.cr').remove();calc();return}const d=e.target.closest('[data-dl]');if(d)reqDl(d.dataset.dl)});
const S=(l,x,c='')=>`<div class="st ${c}"><span>${l}</span><b>${x}</b></div>`,msg=t=>`<div class="msg">${t}</div>`;
const toast=t=>{const e=$('#toast');e.textContent=t;e.classList.add('on');setTimeout(()=>e.classList.remove('on'),2600)};

/* ---- maths ---- */
const P=()=>({age:v('age'),ret:v('ret'),life:v('life'),exp:v('exp'),oth:v('oth'),infl:v('infl'),rpre:v('rpre'),rpost:v('rpost'),cur:v('cur'),sip:v('sip'),step:v('step')});
const ok=p=>p.age>0&&p.ret>p.age&&p.life>p.ret;
const live=(p,t)=>Math.max(0,(p.exp-p.oth)*12*Math.pow(1+p.infl/100,t));
function rows(p,G){const out=[];let c=p.cur;for(let a=p.age;a<p.life;a++){const t=a-p.age,pre=a<p.ret,r=(pre?p.rpre:p.rpost)/100,flow=pre?p.sip*12*Math.pow(1+p.step/100,t):-live(p,t),g=(G[a]?G[a].amt||0:0)*Math.pow(1+p.infl/100,t),net=flow-g,base=c+net/2,ret=base>0?r*base:0,close=c+net+ret;out.push({a,open:c,flow,ret,g,close,pre});c=close}return out}
function need(p,G){let C=0;for(let a=p.life-1;a>=p.ret;a--){const t=a-p.age,r=p.rpost/100,w=live(p,t)+(G[a]?G[a].amt||0:0)*Math.pow(1+p.infl/100,t);C=(C+w*(1+r/2))/(1+r)}return C}
function proj(p,G){const r=rows({...p,life:p.ret},G);return r.length?r[r.length-1].close:p.cur}
function solve(p,G){const f=s=>proj({...p,sip:s},G),f0=f(0),d=f(1)-f0;return Math.max(0,(need(p,G)-f0)/(d||1))}
function earliest(p){for(let r=p.age+1;r<Math.min(p.life,76);r++){const q={...p,ret:r};if(proj(q,{})>=need(q,{}))return r}return null}

/* ---- results ---- */

const GL=[],GUIDE={nw:[],exp:[],plan:[],swp:[],fam:[],prot:[]},PRE=["Child's education","Child's marriage","Buy a car","Buy a home","Foreign trip","Medical need","Other goal"];let NWF='all';
const gd=(t,x)=>({t,x}),aiBox=a=>`<div class="panel ai"><h3>✨ AI Guidance</h3><ul>${a.map(i=>`<li class="${i.t}">${i.x}</li>`).join('')||'<li class="w">Fill in more details to get guidance.</li>'}</ul><small>Smart guidance generated from the numbers you entered. It is for learning, not financial advice.</small></div>`;
const gbar=(l,val,txt,col)=>`<div class="bl"><span>${l}</span><span>${txt}</span></div><div class="bar"><i style="width:${Math.max(0,Math.min(100,val))}%;${col?'background:'+col:''}"></i></div>`;
const donut=(it,lab)=>{const T=it.reduce((a,x)=>a+x.v,0)||1;let acc=0;const d0=`<small>${lab}</small><b>${inr(T)}</b>`;return `<div class="dn" data-d="${esc(d0)}"><svg viewBox="0 0 42 42">${it.map(x=>{const d=x.v/T*100,o=25-acc;acc+=d;return `<circle class="sg-s" data-seg data-n="${esc(x.n)}" data-v="${inr(x.v)}" data-p="${Math.round(d)}%" tabindex="0" cx="21" cy="21" r="15.9155" fill="none" stroke="${x.c}" stroke-width="6" stroke-dasharray="${d} ${100-d}" stroke-dashoffset="${o-25}"/>`}).join('')}</svg><div class="dc">${d0}</div></div><div class="lg">${it.map(x=>`<div><i style="background:${x.c}"></i>${esc(x.n)}<span>${inr(x.v)} · ${Math.round(x.v/T*100)}%</span></div>`).join('')}</div>`};
const segOn=e=>{const c=e.target.closest&&e.target.closest('[data-seg]');if(c)c.closest('.dn').querySelector('.dc').innerHTML=`<small>${c.dataset.n} · ${c.dataset.p}</small><b>${c.dataset.v}</b>`},segOff=e=>{const c=e.target.closest&&e.target.closest('[data-seg]');if(c){const d=c.closest('.dn');d.querySelector('.dc').innerHTML=d.dataset.d}};
['mouseover','focusin','click'].forEach(t=>document.addEventListener(t,segOn));['mouseout','focusout'].forEach(t=>document.addEventListener(t,segOff));
document.addEventListener('click',e=>{const b=e.target.closest('[data-nwf]');if(b){NWF=b.dataset.nwf;calc()}});
function D1(o){const{AL,liq,ill,ta,debt,A,fin,age}=o;if(ta+debt<=0){GUIDE.nw=[];return}const ess=expList().filter(x=>x.e).reduce((a,x)=>a+x.v,0),it=AL.filter(x=>x.v>0&&(NWF==='all'||x.t===NWF)).map((x,i)=>({n:x.n,v:x.v,c:COL[i%COL.length]})),lr=ta?liq/ta*100:0,dr=ta?debt/ta*100:0,eq=fin?A.eq/fin*100:0,tg=Math.max(20,100-age),top=AL.slice().sort((a,b)=>b.v-a.v)[0],g=[];
if(ta-debt<0)g.push(gd('b',`Your debts are ${inr(debt-ta)} more than what you own. Clear the costliest loan first, then rebuild savings.`));else if(dr>40)g.push(gd('w',`Loans are ${Math.round(dr)}% of what you own. Prepaying the highest-interest loan will raise your net worth fastest.`));else if(debt>0)g.push(gd('g',`Loans are a manageable ${Math.round(dr)}% of what you own.`));else g.push(gd('g','You have no loans. That is a strong base.'));
if(ess){const m=liq/ess;g.push(m<6?gd('w',`Your liquid assets cover ${m.toFixed(1)} months of essential spending. Build this to 6 months (about ${inr(ess*6)}).`):gd('g',`Your liquid assets cover ${m.toFixed(1)} months of essentials, above the 6-month goal.`))}
if(ta&&ill/ta>.7)g.push(gd('w',`${Math.round(ill/ta*100)}% of your wealth is non-liquid. In an emergency you may struggle to raise cash; add more liquid assets.`));
if(fin&&age)g.push(eq>tg+15?gd('w',`Shares are ${Math.round(eq)}% of your savings and investments, higher than the ~${tg}% age guide. Check you are comfortable with the swings.`):eq<tg-20?gd('w',`Shares are only ${Math.round(eq)}% against a ~${tg}% age guide. Price rise may outrun a safe-savings-heavy mix over the long run.`):gd('g',`Your share in stocks (${Math.round(eq)}%) is close to the ~${tg}% age guide.`));
if(top&&ta&&top.v/ta>.5)g.push(gd('w',`${esc(top.n)} is ${Math.round(top.v/ta*100)}% of what you own. Spreading across more things lowers risk.`));
GUIDE.nw=g;$('#r-nw').insertAdjacentHTML('beforeend',`<div class="dbd"><div class="panel"><h3>Interactive dashboard</h3><div class="chips" role="group" aria-label="Filter">${[['all','All'],['L','Liquid'],['I','Non-liquid']].map(([k,l])=>`<button class="chip" type="button" data-nwf="${k}" aria-pressed="${NWF===k}">${l}</button>`).join('')}</div>${it.length?donut(it,'Assets'):''}<p style="color:var(--mu);font-size:12px;margin:6px 0 10px;text-align:center">Tap or hover a slice for details</p>${gbar('Liquid share of what you own',lr,Math.round(lr)+'%','var(--br)')}${gbar('Loans as share of what you own',dr,Math.round(dr)+'%',dr>40?'var(--bd)':'var(--gd)')}${fin?gbar('Share in stocks (age guide ~'+tg+'%)',eq,Math.round(eq)+'%','var(--ac)'):''}</div>${aiBox(g)}</div>`)}
function wi2(el){const b=el.closest('.wi'),f=+b.dataset.f,sv=+b.dataset.sv,r=(+b.dataset.r||8)/100,c=+el.value,x=f*c/100;b.querySelector('output').textContent=c+'%';b.querySelector('.o').innerHTML=`Saves <b>${inr(x)}</b> more a month. New monthly saving: <b>${inr(sv+x)}</b>. Invested for 10 years at ${Math.round(r*100)}%, that extra could grow to about <b>${inr(x*12*((Math.pow(1+r,10)-1)/r))}</b>.`}
function D2(o){const{XL,inc,tot,ess,sv,rate,A,p}=o;if(tot+inc<=0){GUIDE.exp=[];return}const it=XL.filter(x=>x.v>0).sort((a,b)=>b.v-a.v).map((x,i)=>({n:x.n,v:x.v,c:COL[i%COL.length]}));if(sv>0)it.push({n:'Savings',v:sv,c:'#12805C'});const flex=tot-ess,top=XL.slice().sort((a,b)=>b.v-a.v)[0],ef=A.bank+A.fd,g=[];
if(inc){g.push(sv<0?gd('b',`You overspend by ${inr(-sv)} a month. Cut non-essentials before investing more.`):rate<10?gd('b',`Your saving rate is only ${Math.round(rate)}%. Aim for at least 20% of income.`):rate<20?gd('w',`Your saving rate is ${Math.round(rate)}%. Raising it to 20% needs another ${inr(inc*.2-sv)} a month.`):gd('g',`Your saving rate of ${Math.round(rate)}% meets the 20% target.`));if(ess/inc>.6)g.push(gd('w',`Essentials take ${Math.round(ess/inc*100)}% of income, leaving little room to save. Review rent, EMIs and insurance.`));if(top&&top.v/inc>.35)g.push(gd('w',`${esc(top.n)} alone is ${Math.round(top.v/inc*100)}% of income. Check if it can be trimmed.`))}
if(flex>0)g.push(gd('g',`Cutting your flexible spending by 10% releases about ${inr(flex*.1)} a month. Try the slider below.`));
if(ess)g.push(ef>=ess*6?gd('g','Your cash and deposits already cover 6 months of essentials.'):gd('w',`Cash and deposits cover ${(ef/ess).toFixed(1)} months of essentials. Build up to 6 months (${inr(ess*6)}).`));
GUIDE.exp=g;$('#r-exp').insertAdjacentHTML('beforeend',`<div class="dbd">${aiBox(g)}</div>`)}
function wi3(el){const b=el.closest('.wi'),p=P(),s=+b.querySelector('.s1').value,r=+b.querySelector('.s2').value,q={...p,sip:s,ret:r},n=need(q,{}),f=proj(q,{}),rd=Math.min(100,n?f/n*100:100);b.querySelector('.o1').textContent=inr(s)+'/mo';b.querySelector('.o2').textContent='Age '+r;b.querySelector('.o').innerHTML=`Need <b>${inr(n)}</b>, will have <b>${inr(f)}</b>: <b style="color:var(${f>=n?'--gd':'--bd'})">${f>=n?'on track, extra '+inr(f-n):'short by '+inr(n-f)}</b> (${Math.round(rd)}% ready).`;b.querySelector('.bar i').style.width=rd+'%'}
function D3(p){if(!ok(p)){GUIDE.plan=[];return}const n=need(p,{}),f=proj(p,{}),gap=f-n,s=solve(p,{}),e=earliest(p),rd=n>0?f/n*100:100,wr=live(p,p.ret-p.age)/n*100,g=[];
g.push(rd>=100?gd('g','Your current plan fully funds retirement. Next, add life goals in Step 4.'):rd>=70?gd('w',`You are ${Math.round(rd)}% ready and short by ${inr(-gap)}. You are close, so small changes can close the gap.`):gd('b',`You are only ${Math.round(rd)}% ready, short by ${inr(-gap)}. Act early, because time is your biggest advantage.`));
if(gap<0){g.push(gd('w',`Investing about ${inr(s)} a month (${inr(s-p.sip)} more than now) closes the gap.`));if(p.step<10){const t=solve({...p,step:10},{});if(t<s)g.push(gd('g',`With a 10% yearly increase you could start at ${inr(t)} a month instead of ${inr(s)}.`))}}
g.push(e?(e>p.ret?gd('w',`At your current pace the earliest fully funded retirement age is ${e}, ${e-p.ret} years after your target.`):gd('g',`You could retire as early as age ${e} at your current pace.`)):gd('b',`No retirement age before ${p.life} is fully funded at your current pace.`));
if(n>0)g.push(wr>5?gd('w',`The money you take out in year one is ${wr.toFixed(1)}% of the fund, above the usual 4-5% comfort zone.`):gd('g',`The money you take out in year one is ${wr.toFixed(1)}% of the fund, within the usual 4-5% comfort zone.`));
g.push(gd('g',`Price rise turns ${inr(p.exp)} a month today into about ${inr(p.exp*Math.pow(1+p.infl/100,p.ret-p.age))} at age ${p.ret}.`));
GUIDE.plan=g;const mx=Math.max(100000,Math.round(p.sip*3/1000)*1000);$('#r-plan').insertAdjacentHTML('beforeend',`<div class="dbd"><div class="panel wi"><h3>What-if dashboard</h3><label>Monthly investment <output class="o1"></output></label><input class="rng gx s1" type="range" min="0" max="${mx}" step="1000" value="${Math.min(mx,p.sip)}" oninput="wi3(this)"><label>Retire at <output class="o2"></output></label><input class="rng gx s2" type="range" min="${p.age+1}" max="${p.life-1}" value="${p.ret}" oninput="wi3(this)"><div class="bar"><i></i></div><p class="o"></p></div>${aiBox(g)}</div>`);wi3($('#r-plan .s1'))}
function wi4(el){const b=el.closest('.wi'),p=P(),x=+el.value,R=rows({...p,sip:p.sip+x},G),dep=R.find(r=>r.close<0),at=R.filter(r=>r.a<p.ret).pop();b.querySelector('output').textContent='+'+inr(x)+'/mo';b.querySelector('.o').innerHTML=`Fund at ${p.ret}: <b>${inr(at?at.close:p.cur)}</b>. ${dep?`Runs out at age <b style="color:var(--bd)">${dep.a}</b>.`:`<b style="color:var(--gd)">Lasts beyond age ${p.life}</b>, leaving ${inr(R[R.length-1].close)}.`}`}
function dash4(p,Rw,dep,corp,end,tg,s){const ks=Object.keys(G).map(Number).sort((a,b)=>a-b),f=a=>(G[a].amt||0)*Math.pow(1+p.infl/100,a-p.age),mx=Math.max(1,...ks.map(f)),n=need(p,G),wr=n>0?live(p,p.ret-p.age)/n*100:0,pre=ks.filter(a=>a<p.ret).reduce((a,k)=>a+f(k),0),g=[];
g.push(dep?gd('b',`Your fund runs out at age ${dep.a}. Investing about ${inr(s)} a month, retiring later or trimming a goal can fix this.`):gd('g',`Your fund lasts beyond age ${p.life}, leaving ${inr(end)}.`));
g.push(ks.length?gd(tg>corp*.5?'w':'g',`Your ${ks.length} life goal${ks.length>1?'s':''} cost ${inr(tg)} in future money${tg>corp*.5?', over half your retirement fund. Consider phasing them.':'.'}`):gd('w','No life goals added yet. Add goals such as children\'s education or a home for a realistic plan.'));
if(pre>0)g.push(gd('w',`Goals before retirement total ${inr(pre)} and will be paid from your savings, so keep investing steadily.`));
if(!dep&&end>corp*.3)g.push(gd('g',`You have ${inr(end)} left over. You could add goals or retire a little earlier.`));
if(n>0&&ok(p))g.push(wr>5?gd('w',`Money taken out in year one is ${wr.toFixed(1)}% of the fund needed, above the 4-5% comfort zone.`):gd('g',`Money taken out in year one is ${wr.toFixed(1)}% of the fund needed, within the 4-5% comfort zone.`));
GUIDE.swp=g;return`<div class="dbd">${ks.length?`<div class="panel"><h3>Goals dashboard</h3><p style="color:var(--mu);font-size:13px;margin:0 0 8px">Today's cost vs cost at that age (with price rise)</p>${ks.map(a=>gbar(`Age ${a}: ${esc(G[a].name||'Goal')}`,f(a)/mx*100,inr(G[a].amt||0)+' → '+inr(f(a)),'var(--ac)')).join('')}</div>`:''}<div class="panel wi"><h3>What if I invest more?</h3><label>Extra monthly investment <output></output></label><input class="rng gx s4" type="range" min="0" max="${Math.max(50000,Math.round(p.sip/1000)*1000)}" step="1000" value="0" oninput="wi4(this)"><p class="o"></p></div>${aiBox(g)}</div>`}
const syncG=()=>{for(const k in G)delete G[k];const p=P();GL.forEach(x=>{const a=Math.round(x.age);if(!x.amt||!(a>=p.age&&a<p.life))return;const g=G[a]||(G[a]={amt:0,name:''});g.amt+=x.amt;g.name=g.name?g.name+' + '+x.name:x.name})};
function renderGL(){$('#gl').innerHTML=GL.map((x,i)=>`<div class="er gr" data-i="${i}"><div class="fd"><label>Goal</label><select class="sel gx" data-f="name">${(PRE.includes(x.name)?PRE:[x.name,...PRE]).map(n=>`<option${n===x.name?' selected':''}>${esc(n)}</option>`).join('')}</select></div><div class="fd"><label>At age</label><div class="in"><input class="gx" data-f="age" type="number" min="0" placeholder="50" value="${x.age||''}"></div></div><div class="fd"><label>Cost today</label><div class="in"><i class="cs">₹</i><input class="gx" data-f="amt" type="number" min="0" step="10000" placeholder="2000000" value="${x.amt||''}"></div></div><button class="btn small" type="button" data-rmg="${i}" aria-label="Remove goal" style="margin-bottom:14px">✕</button></div>`).join('')}
$('#gl').addEventListener('input',e=>{const t=e.target,r=t.closest('[data-i]');if(!r||!t.dataset.f)return;const x=GL[+r.dataset.i];x[t.dataset.f]=t.dataset.f==='name'?t.value:(parseFloat(t.value)||0);syncG();swp(true)});
$('#gl').addEventListener('change',e=>{if(e.target.tagName==='SELECT'){const r=e.target.closest('[data-i]');GL[+r.dataset.i].name=e.target.value;syncG();swp(true)}});
$('#gl').addEventListener('click',e=>{const b=e.target.closest('[data-rmg]');if(b){GL.splice(+b.dataset.rmg,1);syncG();renderGL();swp(true)}});

const HS=['None','Individual','Family floater','Employer (group) only'],EW=['Savings account','Liquid fund or FD','Both','Not kept separately'];
const pf=(id,l,r)=>`<div class="fd"><label for="${id}">${l}</label><div class="in">${r?'<i class="cs">₹</i>':''}<input id="${id}" type="number" inputmode="decimal" min="0" step="${r?1000:1}" placeholder="0"></div></div>`,ps=(id,l,o)=>`<div class="fd"><label for="${id}">${l}</label><select class="sel" id="${id}">${o.map(x=>`<option>${x}</option>`).join('')}</select></div>`;
$('#f-pr').innerHTML=ps('tmy','Do you have life insurance?',['No','Yes'])+pf('tmc','Life cover amount',1)+pf('tmp','Term yearly payment',1)+pf('tmt','Term policy runs till age',0)+ps('hty','Health insurance type',HS)+pf('hcc','Health cover amount',1)+pf('hcp','Health yearly payment',1)+ps('hto','Extra top-up health policy?',['No','Yes'])+pf('efv','Emergency money you have kept',1)+ps('efw','Where is it kept?',EW);
const prot=()=>({tm:$('#tmy').value,lc:v('tmc'),tp:v('tmp'),tt:v('tmt'),hs:$('#hty').value,hc:v('hcc'),hp:v('hcp'),ht:$('#hto').value,ef:v('efv'),ew:$('#efw').value});
function D5(o){const{inc,tot,age}=o,q=prot(),g=[],box=$('#r-exp');if(tot+inc<=0){GUIDE.prot=[];return}
const tOn=q.tm==='Yes'&&q.lc>0,hOn=q.hs!=='None'&&q.hc>0,need=inc*120,tgt=tot*6,mo=tot?q.ef/tot:0;
if(age<60&&inc>0)g.push(!tOn?gd('b',`No life insurance noted. With your income, a common thumb rule is cover of about ${inr(need)} (10 times yearly income).`):q.lc<need?gd('w',`Your life cover is ${inr(q.lc)}, about ${inr(need-q.lc)} below the 10-times-income guide of ${inr(need)}.`):gd('g',`Your life cover of ${inr(q.lc)} meets the 10-times-income guide.`));
if(tOn&&q.tt>0&&q.tt<60)g.push(gd('w',`Your term policy ends at age ${q.tt}, before a typical retirement age. Consider cover that runs longer.`));
g.push(!hOn?gd(age>=60?'b':'w','No health insurance noted. One hospital stay can use up your savings.'):q.hs==='Employer (group) only'?gd('w','You rely only on employer health cover, which usually ends when the job ends. Buy a personal policy too.'):q.hc<5e5?gd('w',`Your health cover is ${inr(q.hc)}, under the ₹5 lakh guide. Medical costs keep rising.`):gd('g',`Your health cover of ${inr(q.hc)} meets the ₹5 lakh guide.`));
if(hOn&&q.ht==='No')g.push(gd('w','A super top-up policy is a low-cost way to raise your health cover.'));
if(tot)g.push(q.ef<=0?gd('b',`No emergency money noted. Build ${inr(tgt)} (6 months of spending) in a savings account or liquid fund.`):mo<3?gd('b',`Your emergency money covers only ${mo.toFixed(1)} months. Aim for 6 months (${inr(tgt)}).`):mo<6?gd('w',`Your emergency money covers ${mo.toFixed(1)} months. Add about ${inr(tgt-q.ef)} to reach 6 months.`):gd('g',`Your emergency money covers ${mo.toFixed(1)} months, meeting the 6-month goal.`));
if(q.ef>0&&q.ew==='Not kept separately')g.push(gd('w','Keep your emergency money in a separate savings account, liquid fund or FD so you do not spend it by mistake.'));
GUIDE.prot=g;box.insertAdjacentHTML('beforeend',`<div class="dbd"><div class="panel"><h3>Your protection check</h3>${age<60&&inc>0?gbar('Life cover vs 10 times yearly income',need?q.lc/need*100:0,inr(tOn?q.lc:0)+' of '+inr(need),tOn&&q.lc>=need?'var(--gd)':tOn?'var(--ac)':'var(--bd)'):''}${gbar('Health cover vs ₹5 lakh guide'+(q.hs!=='None'?' ('+q.hs.toLowerCase()+')':''),q.hc/5e5*100,hOn?inr(q.hc):'No cover',q.hc>=5e5?'var(--gd)':hOn?'var(--ac)':'var(--bd)')}${tot?gbar('Emergency money vs 6 months of spending',tgt?q.ef/tgt*100:0,inr(q.ef)+' of '+inr(tgt),q.ef>=tgt?'var(--gd)':'var(--ac)'):''}${q.tp+q.hp?`<p style="color:var(--mu);font-size:13px;margin:0">Yearly insurance premium: ${inr(q.tp+q.hp)}</p>`:''}</div>${aiBox(g)}</div>`)}
function calc(){
const AL=assetList(),A={};AS.forEach(([k])=>A[k]=v(k));const liq=AL.filter(x=>x.t==='L').reduce((a,x)=>a+x.v,0),ill=AL.filter(x=>x.t==='I').reduce((a,x)=>a+x.v,0),ta=liq+ill,debt=LI.reduce((a,[k])=>a+v(k),0),cL=cust('#c-L').reduce((a,x)=>a+x.v,0),fin=A.bank+A.fd+A.eq+A.epf+cL,age=v('age'),AV=AL.filter(x=>x.v>0);
$('#r-nw').innerHTML=ta+debt<=0?msg('Fill in what you own to see your net worth.'):`<div class="hl"><small>Your net worth</small><b>${inr(ta-debt)}</b><p>${inr(ta)} owned, less ${inr(debt)} owed.</p></div><div class="sg">${S('Liquid assets',inr(liq))}${S('Non-liquid assets',inr(ill))}${S('Savings and investments',inr(fin))}${S('Loans',inr(debt),debt?'b':'')}${S('Loans as share of what you own',ta?Math.round(debt/ta*100)+'%':'0%')}</div><div class="panel"><h3>Where your money sits</h3><div class="mix">${AV.map((x,i)=>`<i style="width:${x.v/ta*100}%;background:${COL[i%COL.length]}"></i>`).join('')}</div><div class="lg">${AV.map((x,i)=>`<div><i style="background:${COL[i%COL.length]}"></i>${esc(x.n)} <small>(${x.t==='L'?'liquid':'non-liquid'})</small><span>${inr(x.v)} (${Math.round(x.v/ta*100)}%)</span></div>`).join('')}</div><ul class="tips">${ta?`<li>${Math.round(liq/ta*100)}% of what you own is liquid and ${Math.round(ill/ta*100)}% is non-liquid.</li>`:''}${fin&&age?`<li>Shares are ${Math.round(A.eq/fin*100)}% of your savings and investments. A simple guide for your age is about ${Math.max(20,100-age)}%.</li>`:''}</ul></div>`;
const XL=expList(),inc=v('inc'),tot=XL.reduce((a,x)=>a+x.v,0),ess=XL.filter(x=>x.e).reduce((a,x)=>a+x.v,0),sv=inc-tot,rate=inc?sv/inc*100:0,ef=A.bank+A.fd;
const base=Math.max(inc,tot)||1,AR=XL.filter(x=>x.v>0).sort((a,b)=>b.v-a.v).map((x,i)=>({n:x.n,v:x.v,e:x.e,c:COL[i%COL.length]}));if(sv>0)AR.push({n:'Savings',v:sv,c:'var(--gd)'});
const alloc=AR.length?`<div class="panel"><h3>Where your money goes</h3><p style="margin:0 0 6px;color:var(--mu);font-size:13px">Share of your monthly ${inc?'income':'spending'}</p><div class="mix">${AR.map(x=>`<i style="width:${x.v/base*100}%;background:${x.c}"></i>`).join('')}</div><div class="lg">${AR.map(x=>`<div><i style="background:${x.c}"></i>${esc(x.n)}${x.e?' <small>(essential)</small>':''}<span>${inr(x.v)} · ${Math.round(x.v/base*100)}%</span></div>`).join('')}</div>${sv<0?`<p style="margin:10px 0 0;color:var(--bd);font-size:14px">You spend ${inr(-sv)} a month more than you earn.</p>`:''}</div>`:'';
$('#r-exp').innerHTML=tot+inc<=0?msg('Enter your income and expenses to see your saving rate.'):`<div class="hl"><small>You spend each month</small><b>${inr(tot)}</b><p>${inr(tot*12)} a year. ${inc?`You save ${inr(sv)}, which is ${Math.round(rate)}% of your income.`:''}</p></div><div class="sg">${S('Essential',inr(ess))}${S('Can cut',inr(tot-ess))}${S('Saved each month',inr(sv),sv<0?'b':'g')}${S('Emergency money goal',inr(ess*6))}</div>${alloc}<div class="panel"><div class="mix"><i style="width:${tot?ess/tot*100:0}%;background:var(--br)"></i><i style="width:${tot?(tot-ess)/tot*100:0}%;background:var(--ac)"></i></div><ul class="tips">${inc&&rate<20?`<li>Your saving rate is below the common 20% target. Cutting ${inr(Math.min(tot-ess,inc*.2-sv))} of non-essential spending would help.</li>`:''}${ess?`<li>${ef>=ess*6?'Your cash and deposits already cover 6 months of essentials.':'Your cash and deposits cover '+(ef/ess).toFixed(1)+' months of essentials. Aim for 6.'}</li>`:''}</ul></div>`;
const setA=(id,x)=>{const e=$('#'+id);if(e.dataset.auto==='1')e.value=x>0?Math.round(x):''};setA('exp',tot);setA('cur',fin);setA('sip',sv);
const p=P();
$('#r-plan').innerHTML=!ok(p)?msg('Enter your age in Step 1. Retirement age must be above it, and "last till" age above retirement age.'):(()=>{const n=need(p,{}),f=proj(p,{}),gap=f-n,s=solve(p,{}),e=earliest(p),m=p.exp*Math.pow(1+p.infl/100,p.ret-p.age),rd=n>0?Math.min(100,f/n*100):100;
return`<div class="hl"><small>Fund you need at age ${p.ret}</small><b>${inr(n)}</b><p>Spending of ${inr(p.exp)} a month today becomes about ${inr(m)} a month then, at ${p.infl}% price rise.</p></div><div class="sg">${S('You will have',inr(f))}${S(gap>=0?'Extra':'Short by',inr(Math.abs(gap)),gap>=0?'g':'b')}${S('Investment needed',inr(s)+'/mo')}${S('You invest now',inr(p.sip)+'/mo')}</div><div class="panel"><h3>Readiness: ${Math.round(rd)}%</h3><div class="meter"><i style="width:${rd}%"></i></div><ul class="tips"><li>${gap>=0?'You are on track. Next, add your life goals in Step 4.':'Raise your investment to about '+inr(s)+' a month, retire later, or lower your spending.'}</li><li>${e?'At your current pace you could retire as early as age '+e+'.':'At your current pace, no retirement age before '+p.life+' is fully funded.'}</li></ul></div>`})();
D1({AL,liq,ill,ta,debt,A,fin,age});D2({XL,inc,tot,ess,sv,rate,A,p});D5({inc,tot,age});D3(p);swp(true);if(age>=18&&!ckManual)ck(age<30?'20s':age<40?'30s':age<50?'40s':age<60?'50s':'60p')}

/* ---- SWP table ---- */
const G={},YR=new Date().getFullYear();let lastR=[];
function swp(rebuild){const p=P(),el=$('#r-sw');
if(!ok(p)){el.innerHTML=msg('Enter your age in Step 1 and your retirement details in Step 3 to see the table.');$('#tb').innerHTML='';return}
const s=solve(p,G);$('#mode').innerHTML=`<option value="mine">My monthly investment (${inr(p.sip)})</option><option value="need">The investment my goals need (${inr(s)})</option>`;
if(rebuild)$('#mode').value=$('#mode').dataset.m||'mine';
const q=$('#mode').value==='need'?{...p,sip:s}:p,Rw=rows(q,G);lastR=Rw;
if(rebuild)$('#tb').innerHTML=Rw.map(r=>`<tr data-a="${r.a}"><td><b>${r.a}</b><small>${YR+r.a-p.age}</small></td><td class="o"></td><td class="f"></td><td class="r"></td><td><div class="gc"><input class="gi" data-a="${r.a}" data-t="amt" type="number" min="0" step="10000" placeholder="today" value="${G[r.a]&&G[r.a].amt||''}" aria-label="Goal amount at age ${r.a}"><input class="gi" data-a="${r.a}" data-t="name" placeholder="Goal name" value="${G[r.a]&&G[r.a].name||''}" aria-label="Goal name at age ${r.a}"></div></td><td class="g"></td><td class="c"></td></tr>`).join('');
[...$('#tb').rows].forEach((tr,i)=>{const r=Rw[i];if(!r)return;tr.className=(r.a===p.ret?'rt ':'')+(r.close<0?'neg ':'')+(r.a<p.ret?'pre':'');const c=k=>tr.querySelector('.'+k);c('o').textContent=inr(r.open);c('f').textContent=(r.pre?'+':'')+inr(r.flow);c('r').textContent='+'+inr(r.ret);c('g').textContent=r.g?inr(r.g):'–';c('c').textContent=inr(r.close)});
const dep=Rw.find(r=>r.close<0),at=Rw.filter(r=>r.a<p.ret).pop(),corp=at?at.close:p.cur,tg=Rw.reduce((a,r)=>a+r.g,0),end=Rw[Rw.length-1].close,gl=Object.keys(G).length;
el.innerHTML=`<div class="sg" style="margin-top:0">${S('Fund at age '+p.ret,inr(corp))}${S('Lasts till',dep?'Age '+dep.a:'Age '+p.life+' and beyond',dep?'b':'g')}${S('Left at age '+p.life,inr(end),end<0?'b':'g')}${S('Life goals paid',gl?inr(tg):'None yet')}</div>${dep?`<div class="msg" style="margin-bottom:14px"><b>Your fund runs out at age ${dep.a}.</b> To fix it, invest about ${inr(s)} a month (choose it in "Plan uses"), retire later, spend less, or move or shrink a goal.</div>`:''}<div class="panel ch" style="margin-bottom:16px"><h3>Fund by age</h3>${chart(Rw,p.ret)}</div>${dash4(p,Rw,dep,corp,end,tg,s)}`;const k4=el.querySelector('.s4');if(k4)wi4(k4)}
function chart(Rw,ret){const W=640,H=190,m=8,x0=Rw[0].a,x1=Rw[Rw.length-1].a,mx=Math.max(1,...Rw.map(r=>r.close)),mn=Math.min(0,...Rw.map(r=>r.close)),X=a=>m+(a-x0)/((x1-x0)||1)*(W-2*m),Y=y=>H-20-(y-mn)/((mx-mn)||1)*(H-34),pts=Rw.map(r=>X(r.a)+','+Y(r.close)).join(' ');
return`<svg viewBox="0 0 ${W} ${H}" role="img" aria-label="Fund by age"><polygon points="${X(x0)},${Y(0)} ${pts} ${X(x1)},${Y(0)}" fill="var(--br)" opacity=".16"/><polyline points="${pts}" fill="none" stroke="var(--br)" stroke-width="2.5"/><line x1="${X(ret)}" x2="${X(ret)}" y1="8" y2="${H-20}" stroke="var(--ac)" stroke-width="2" stroke-dasharray="4 3"/><text x="${X(ret)+5}" y="18">Retire at ${ret}: ${inr((Rw.filter(r=>r.a<ret).pop()||Rw[0]).close)}</text><text x="${m}" y="${H-4}">Age ${x0}</text><text x="${W-m}" y="${H-4}" text-anchor="end">Age ${x1}</text>${Rw.map(r=>`<rect x="${X(r.a)-W/Rw.length/2}" y="0" width="${W/Rw.length}" height="${H-20}" fill="transparent"><title>Age ${r.a}: ${inr(r.close)}</title></rect>`).join('')}</svg>`}
$('#tb').addEventListener('input',e=>{const i=e.target;if(!i.classList.contains('gi'))return;const a=+i.dataset.a,g=G[a]||{amt:0,name:''};if(i.dataset.t==='amt')g.amt=parseFloat(i.value)||0;else g.name=i.value;for(let k=GL.length;k--;)if(Math.round(GL[k].age)===a)GL.splice(k,1);if(g.amt||g.name)GL.push({age:a,amt:g.amt,name:g.name||'Other goal'});syncG();renderGL();swp(false)});
$('#mode').onchange=e=>{e.target.dataset.m=e.target.value;swp(false)};
$('#show').onchange=e=>$('#tw').classList.toggle('only',e.target.value==='post');
$('#gadd').onclick=()=>{const p=P();GL.push({name:PRE[0],age:ok(p)?Math.min(p.life-1,p.age+10):50,amt:0});renderGL();const r=$('#gl').lastElementChild;if(r)r.querySelector('[data-f=amt]').focus()};
$('#clrg').onclick=()=>{GL.length=0;syncG();renderGL();swp(true)};
$('#jump').onclick=()=>{const t=$('#tb .rt');if(t)t.scrollIntoView({block:'center'})};

/* ---- navigation ---- */
const ST=['nw','exp','plan','swp'];
function openStep(k){if(k==='swp'&&!USER){toast('Login or sign up to see your Withdrawal Plan.');window.xAfter&&xAfter('swp');return}ST.forEach((s,i)=>{$('#s-'+s).hidden=s!==k;const b=$('#pl-'+s);b.setAttribute('aria-current',s===k?'step':'false');b.classList.toggle('done',i<ST.indexOf(k))});calc();$('#planner').scrollIntoView()}
const views=['plan','checklist','family','report','explore','learn'];
const LOCK={checklist:'Checklist',family:'Family',report:'Report',explore:'Explore'};
function show(x){const lk=!!LOCK[x]&&!USER;views.forEach(n=>$('#v-'+n).hidden=lk||n!==x);$('#v-lock').hidden=!lk;if(lk)$('#v-lock').innerHTML='<div class="panel" style="text-align:center;padding:44px 20px;max-width:560px;margin:20px auto"><h2 style="font-size:26px;margin-bottom:10px">Login or sign up to open '+LOCK[x]+'</h2><p style="color:var(--mu);margin:0 0 22px">It takes a minute. Plan and Learn stay free to use without login.</p><div class="row" style="justify-content:center"><button class="btn go lg" type="button" data-auth="su">Sign up</button><button class="btn lg" type="button" data-auth="li">Login</button></div></div>';$$('.nav a').forEach(a=>a.setAttribute('aria-current',a.dataset.v===x?'page':'false'));if(x==='checklist'&&!lk)JR.ck=true;jrDraw(lk?'learn':x)}
function tab(t){$$('.lt').forEach(b=>b.setAttribute('aria-selected',b.dataset.t===t));$$('.lp').forEach(x=>x.hidden=x.id!=='lp-'+t)}
function route(){const[x,t]=(location.hash.slice(1)||'plan').split('/'),n=views.includes(x)?x:'plan';show(n);if(USER){if(n==='family')renderFam();if(n==='report')renderRep()}if(n==='explore'&&USER&&window.renderExplore)renderExplore(t);if(n==='learn')tab(t||'guides');if(n!=='plan')scrollTo(0,0)}
addEventListener('hashchange',route);
document.addEventListener('click',e=>{const o=e.target.closest('[data-open],[data-go]');if(o){const k=o.dataset.open||o.dataset.go;if(location.hash&&location.hash!=='#plan'){location.hash='#plan'}show('plan');openStep(k);return}const t=e.target.closest('.lt');if(t)location.hash='#learn/'+t.dataset.t});
$('#v-plan').addEventListener('input',e=>{if(e.target.dataset.auto)e.target.dataset.auto='0';if(!e.target.classList.contains('gi')&&!e.target.matches('#mode,#show,.gx'))calc()});
$$('[data-clear]').forEach(b=>b.onclick=()=>{$$(b.dataset.clear==='nw'?'#c-L .cr,#c-I .cr':'#c-X .cr').forEach(r=>r.remove());(b.dataset.clear==='nw'?[...AS,...LI].map(x=>x[0]):['inc',...EX.map((_,i)=>'x'+i)]).forEach(k=>$('#'+k).value='');calc()});
$$('[data-sample]').forEach(b=>b.onclick=()=>{const d={age:32,bank:300000,fd:200000,eq:800000,epf:600000,gold:150000,home:5000000,hl:2500000,inc:120000,x0:25000,x1:15000,x2:6000,x3:5000,x4:4000,x5:2000,x6:8000,x7:6000,x8:4000,x9:2000};for(const k in d)$('#'+k).value=d[k];calc();toast('Sample numbers added. Replace them with yours.')});

/* ---- checklist and glossary ---- */
let ckManual=false;
function ckp(){const a=$$('.ckpanel:not([hidden]) .ckitem'),d=a.filter(x=>x.checked).length;$('#ckt').textContent=d+' of '+a.length+' done';$('#ckf').style.width=(a.length?d/a.length*100:0)+'%'}
function ck(a){$$('[data-age]').forEach(b=>b.setAttribute('aria-pressed',b.dataset.age===a));$$('.ckpanel').forEach(x=>x.hidden=x.id!=='ck-'+a);ckp()}
$$('[data-age]').forEach(b=>b.onclick=()=>{ckManual=true;ck(b.dataset.age)});
$$('.ckitem').forEach(i=>i.onchange=ckp);
$('#gsearch').oninput=e=>{const q=e.target.value.toLowerCase().trim();let n=0;$$('.gterm').forEach(t=>{const m=t.textContent.toLowerCase().includes(q);t.hidden=!m;if(m)n++});$('#gc').textContent=n+' of '+$$('.gterm').length+' words'};
$('#gsearch').oninput({target:$('#gsearch')});

/* ---- login / signup gate + report ---- */
const LS={g(k){try{return JSON.parse(localStorage.getItem(k))}catch(e){return null}},s(k,x){try{localStorage.setItem(k,JSON.stringify(x))}catch(e){}}};
let USER=null,PEND=null;
try{const q=new URLSearchParams(location.search).get('ref');if(q&&/^[A-Za-z0-9]{4,12}$/.test(q))LS.s('rpk_ref',q.toUpperCase())}catch(e){}
const tf=(id,l,o='')=>`<div class="fd"><label for="${id}">${l}</label><div class="in"><input id="${id}" ${o}></div><small id="${id}-e" style="color:var(--bd)"></small></div>`;
const CON=`<p style="color:var(--mu);font-size:12.5px;margin:4px 0 8px">Your details are used to set up your account and report.</p><label class="ck"><input type="checkbox" id="c-t"><span>I am 18 years or older and I agree to the <button class="link" type="button" data-legal="terms">Terms</button> and <button class="link" type="button" data-legal="privacy">Privacy Policy</button>. *</span></label><small id="c-t-e" style="color:var(--bd)"></small><label class="ck"><input type="checkbox" id="c-r"><span>I have read and understood the <button class="link" type="button" data-legal="risk">Risk Disclosure</button>: this tool gives educational estimates, not advice, and investments carry risk. *</span></label><small id="c-r-e" style="color:var(--bd)"></small><label class="ck sub-ck"><input type="checkbox" id="c-s"><span>Optional: share my contact details with SEBI-registered advisers and partners so they can reach me about financial products. Withdraw any time at ${'Retirementplankaro@gmail.com'}.</span></label>`;
$('#fsu').innerHTML=tf('su-n','Name *','autocomplete="given-name"')+tf('su-s','Surname *','autocomplete="family-name"')+tf('su-m','Mobile number *','type="tel" inputmode="numeric" maxlength="10" autocomplete="tel-national" placeholder="10-digit number"')+tf('su-e','Email ID *','type="email" autocomplete="email"')+tf('su-c','City *','autocomplete="address-level2"')+tf('su-p','PAN number (optional)','maxlength="10" placeholder="ABCDE1234F" style="text-transform:uppercase"')+CON+'<button class="btn pri" type="submit">Create account</button>';
$('#fli').innerHTML=tf('li-i','Mobile number or Email ID *','autocomplete="username"')+'<button class="btn pri" type="submit">Login</button>';
function authTab(t){$$('[data-at]').forEach(b=>b.setAttribute('aria-pressed',b.dataset.at===t));$('#fsu').hidden=t!=='su';$('#fli').hidden=t!=='li';$('#at').textContent=t==='su'?'Create your account':'Login to your account'}
$$('[data-at]').forEach(b=>b.onclick=()=>authTab(b.dataset.at));
const openAuth=()=>{$('#auth').hidden=false;authTab('su');$('#su-n').focus()},closeAuth=()=>{$('#auth').hidden=true;PEND=null};
$('#ax').onclick=closeAuth;$('#auth').addEventListener('click',e=>{if(e.target.id==='auth')closeAuth()});
addEventListener('keydown',e=>{if(e.key==='Escape'&&!$('#auth').hidden)closeAuth()});
function done(u){if(!u.code){u.code=mkCode(u);const us=LS.g('rpk_users')||[],i=us.findIndex(x=>x.mobile===u.mobile);if(i>=0){us[i]=u;LS.s('rpk_users',us)}}USER=u;LS.s('rpk_user',u);lead(u,'signup');const t=PEND;$('#auth').hidden=true;PEND=null;toast('Welcome, '+u.name+'! ⭐ Your points: '+ptsBal()+'. Earn '+CFG.refPts+' for every friend who signs up.');updUsr();renderRep();if(t==='fam')renderFam();else if(t==='free')mkFree();else if(t==='gs')setTimeout(openGs,200);else if(t)setTimeout(()=>askCf(t),200)}
$('#fsu').onsubmit=e=>{e.preventDefault();const g=i=>$('#'+i).value.trim(),er={};const u={name:g('su-n'),surname:g('su-s'),mobile:g('su-m'),email:g('su-e').toLowerCase(),city:g('su-c'),pan:g('su-p').toUpperCase()};
if(!u.name)er['su-n']='Enter your name';if(!u.surname)er['su-s']='Enter your surname';if(!/^[6-9]\d{9}$/.test(u.mobile))er['su-m']='Enter a valid 10-digit mobile number';if(!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(u.email))er['su-e']='Enter a valid email';if(!u.city)er['su-c']='Enter your city';if(!$('#c-t').checked)er['c-t']='Please accept the Terms and Privacy Policy';if(!$('#c-r').checked)er['c-r']='Please confirm you have read the Risk Disclosure';if(u.pan&&!/^[A-Z]{5}\d{4}[A-Z]$/.test(u.pan))er['su-p']='PAN looks wrong (format ABCDE1234F) or leave it blank';
['su-n','su-s','su-m','su-e','su-c','su-p','c-t','c-r'].forEach(i=>$('#'+i+'-e').textContent=er[i]||'');if(Object.keys(er).length)return;
const isNew=!(LS.g('rpk_users')||[]).some(x=>x.mobile===u.mobile||x.email===u.email),us=(LS.g('rpk_users')||[]).filter(x=>x.mobile!==u.mobile&&x.email!==u.email);u.consent={terms:true,risk:true,share:$('#c-s').checked,ts:new Date().toISOString(),ver:'v1-2026-10'};u.code=mkCode(u);{const rf=LS.g('rpk_ref');if(isNew&&rf&&rf!==u.code){u.refBy=rf;creditRef(rf)}}us.push(u);LS.s('rpk_users',us);done(u)};
$('#fli').onsubmit=e=>{e.preventDefault();const q=$('#li-i').value.trim().toLowerCase(),u=(LS.g('rpk_users')||[]).find(x=>x.mobile===q||x.email===q);if(!u){$('#li-i-e').textContent='No account found here. Please sign up first.';return}done(u)};

let PD=null;
function askCf(t){PD=t;$('#cf-ok').checked=false;$('#cf-go').disabled=true;$('#cf').hidden=false}
$('#cf-ok').onchange=e=>$('#cf-go').disabled=!e.target.checked;
$('#cfx').onclick=()=>{$('#cf').hidden=true;PD=null};
$('#cf-go').onclick=()=>{if(!$('#cf-ok').checked)return;const t=PD;$('#cf').hidden=true;PD=null;try{USER.ack=new Date().toISOString();LS.s('rpk_user',USER)}catch(e){}if(t)dlGate(t)};
const LC={reg:'',officer:'Grievance Officer, Retirement Plan Karo',email:'Retirementplankaro@gmail.com',city:''};
const LG={risk:[`Risk Disclosure`,[`<b>Education only.</b> This website provides general education and calculators. It is not investment, tax, accounting, insurance, credit or legal advice, and nothing here is a recommendation, solicitation or offer to buy, sell or hold any product.`,`<b>Registration status:</b> ${LC.reg||'Retirement Plan Karo does not give investment advice, research analysis or insurance broking, and does not claim to be a SEBI-registered investment adviser or research analyst, an IRDAI-registered insurance intermediary, a bank, an NBFC or a lender. If this changes, registration details will be shown here.'}`,`All results are estimates built from the numbers and assumptions you enter (price rise, investment growth, how long you live, tax, goal costs). Real outcomes can be very different, and you can lose money.`,`Mutual funds, shares, ETFs and other market-linked investments are subject to market risks. Read all scheme-related documents carefully. Past performance does not guarantee future results. No return is assured or guaranteed.`,`Tax figures are simple estimates for learning. They may not reflect your full income, deductions or the latest law. Consult a chartered accountant before filing or planning tax.`,`Wrong or incomplete inputs give wrong results. Check every number before you rely on it.`,`"AI Guidance" is generated by fixed rules from your inputs. It is generic, does not know your full situation, tax position or risk appetite, and can be wrong or out of date.`,`Sample portfolios and interest rates shown (including "up to" rates on partner links) are examples or maximums. They are not personal advice and are not guaranteed.`,`Laws, tax rules, interest rates and product terms change. Verify current rules before you act.`,`Please speak to a SEBI-registered investment adviser, a chartered accountant or another qualified professional before making financial decisions. You alone are responsible for your decisions.`]],
quotes:[`Quotes, Insurance, Cards and Loans Disclosure`,[`<b>Our role:</b> Retirement Plan Karo is an educational and information platform. We are not an insurer, bank, NBFC, fund house or lender. We do not sell, underwrite, approve, price or disburse any product. Only the provider decides.`,`<b>Quotes are indicative.</b> The final premium, interest rate, fees, limit and approval are decided by the provider after its own checks and may differ from any estimate shown here. Read the provider's policy wording, Key Fact Statement and terms before you accept.`,`<b>Not a recommendation:</b> a quote or estimate is not advice and does not mean a product is right for you. Compare options yourself or take advice from a qualified professional.`,`<b>How we earn:</b> we may receive a commission or referral fee from partners when you buy a product or sign up through us, at no extra cost to you. This may influence which partners we introduce, and it does not mean they offer the best price or product.`,`<b>Insurance:</b> insurance is the subject matter of solicitation. Read the policy document, exclusions, waiting periods, sub-limits, co-payment and free-look rules. Wrong or hidden facts about age, tobacco use, health, income or past claims can lead to a rejected claim or a cancelled policy. Term plans are pure protection and most have no maturity benefit.`,`<b>Credit cards and personal loans:</b> subject to approval and the lender's credit policy and terms. Interest, processing fees, late charges and taxes apply and are shown by the lender. Each application can create a credit enquiry and may affect your credit score. Missed payments hurt your score and can lead to penalties. Borrow only what you can repay.`,`<b>Loan against mutual funds:</b> your units are pledged to the lender and cannot be sold while pledged. If their value falls, you may be asked to add security or repay, or the lender may sell your units. Interest is payable. Mutual fund investments are subject to market risks; read all scheme-related documents carefully.`,`<b>No upfront fee:</b> we do not charge you to request a quote. Never pay money to anyone who says they will get your loan, card or claim approved on our behalf. We never ask for your OTP, card number, CVV, PIN or passwords.`,`<b>Contact and consent:</b> by submitting a request you allow us and our partners to contact you by call, SMS, WhatsApp or email about that request, even if your number is on a Do Not Disturb or NDNC list. You can withdraw consent at any time by writing to ${LC.email}.`,`<b>Data we share:</b> only the details you enter in the form, and only with providers and partners that need them to prepare your quote. PAN is optional and is not shown back on screen.`]],
privacy:[`Privacy Policy`,[`<b>What we collect:</b> name, surname, mobile number, email, city and, only if you choose, PAN. For quote requests we also collect the product details you enter (for example age, income, cover or loan amount, fund value). Your plan numbers are processed in your browser.`,`<b>Why:</b> to create your account, let you log in and download your report, prepare and share the quotes you ask for, and contact you about your account or request.`,`<b>Sharing:</b> we share your details with advisers or partners only if you tick the separate consent at sign-up or on a quote request. Saying no does not affect your report. We do not sell your data.`,`<b>Your rights under the Digital Personal Data Protection Act, 2023:</b> to know what we hold, correct it, erase it, withdraw consent at any time, nominate someone to act for you, and complain to us first and then to the Data Protection Board of India.`,`<b>Withdraw consent or ask anything:</b> write to ${LC.email}. We act on requests within a reasonable time.`,`<b>Browser storage:</b> your plan, budget and wallet are saved in this browser's local storage on your device. Clearing your browser data removes them.`,`<b>Third-party services:</b> this site may use Google Translate (to translate page text), PayU (payments) and content delivery networks for scripts. These services have their own privacy terms. Translations are machine-generated and may be wrong; the English text prevails.`,`<b>Retention and security:</b> we keep data only as long as needed for these purposes or as law requires, and use reasonable safeguards. If a data breach affects you, we will inform you and the authorities as the law requires.`,`<b>Family details:</b> these are about other people. Add them only if you have the right to, and for a child only as parent or guardian. They are kept in your account and are not shared unless you give the sharing consent.`,`<b>Age:</b> this service is for people aged 18 and above.`,`Last updated: October 2026.`]],
terms:[`Terms of Use`,[`You must be 18 or older. Provide true details at sign-up and in any request.`,`The tools, calculators and reports are for learning only and come without any warranty of accuracy, completeness or fitness for a purpose. No adviser-client relationship is created by using this site.`,`Third-party links and partner sites are outside our control. We are not responsible for their content, products, prices, approvals or service. Dealings with them are between you and them.`,`Do not misuse the site, copy or scrape it at scale, use it for unlawful purposes or attempt to break it. Site content, design and code belong to us or our licensors.`,`Testimonials are individual opinions and are not a promise of any result.`,`We may change, suspend or stop the service and these terms. Continued use means you accept the changes.`,`To the extent the law allows, RetirementPlanKaro.com and its owner are not liable for losses from decisions based on the tool, reports or any quote or partner offer. Nothing here limits liability that cannot be limited by law.`,`These terms are governed by the laws of India. ${LC.city?'Courts at '+LC.city+', India':'The courts of India with proper jurisdiction'} will decide any dispute, subject to your rights under the Consumer Protection Act, 2019.`]],
refund:[`Wallet Points and Refund Policy`,[`Points can be used only on Explore options. They have no cash value, cannot be transferred and cannot be redeemed for money. Free welcome and referral points are not refundable.`,`Each unlock is valid for the period shown when you unlock it. Points already used for an unlock are not refunded.`,`Payments are handled by PayU. If money is debited but points are not added, write to ${LC.email} with your payment ID. We will add the points or refund the amount.`,`Unused purchased points can be refunded on request within a reasonable time after purchase, where the law requires. Contact us to ask.`,`Get Quotes is free. We do not charge for a quote request.`]],
grievance:[`Grievance Redressal`,[`<b>${LC.officer}</b>, email: <a class="mail" href="mailto:${LC.email}">${LC.email}</a>`,`Write to us about any complaint on this site, your data, payments or a quote request. We aim to acknowledge within 48 hours and resolve within 30 days.`,`If you are not satisfied with a data-related answer, you may approach the Data Protection Board of India.`,`For a complaint about an insurance product, contact the insurer first and then IRDAI (Bima Bharosa). For a bank, card or loan, contact the lender first and then the RBI Complaint Management System. For a mutual fund or securities issue, use the SEBI SCORES platform.`]]};
function openLegal(k){$('#lgb').innerHTML=Object.keys(LG).map(x=>`<section id="lg-${x}" style="margin-bottom:18px"><h3>${LG[x][0]}</h3><ul class="tips">${LG[x][1].map(i=>`<li>${i}</li>`).join('')}</ul></section>`).join('');$('#legal').hidden=false;const e=$('#lg-'+k);if(e)e.scrollIntoView()}
$('#lgx').onclick=()=>$('#legal').hidden=true;$('#legal').addEventListener('click',e=>{if(e.target.id==='legal')$('#legal').hidden=true});
document.addEventListener('click',e=>{const b=e.target.closest('[data-legal]');if(b){e.preventDefault();openLegal(b.dataset.legal)}});
addEventListener('keydown',e=>{if(e.key==='Escape'){$('#legal').hidden=true;$('#cf').hidden=true}});
function reqDl(t){if(!jrState().plan){toast('Add your age in Step 1 and retirement details in Step 3 first.');jrGo('plan');return}if(USER)askCf(t);else{PEND=t;openAuth()}}
const R0=Math.round,pm=n=>csym(inr(n));
function report(){calc();const p=P(),AL=assetList(),XL=expList().filter(x=>x.v>0),inc=v('inc'),tot=XL.reduce((a,x)=>a+x.v,0),sv=inc-tot,L=AL.filter(x=>x.t==='L'),I=AL.filter(x=>x.t==='I'),sum=a=>a.reduce((s,x)=>s+x.v,0),debt=LI.reduce((a,[k])=>a+v(k),0),n=need(p,{}),f=proj(p,{}),sl=solve(p,G),e=earliest(p),base=Math.max(inc,tot)||1,pc=x=>Math.round(x/base*100)+'%';
const SC=[];
SC.push({sh:'Net worth',t:'Money you can use quickly (Liquid assets)',h:['Asset','Value'],r:[...L.map(x=>[x.n,R0(x.v)]),['Total liquid',R0(sum(L))]]});
SC.push({sh:'Net worth',t:'Money that is locked or slow to sell (Non-liquid assets)',h:['Asset','Value'],r:[...I.map(x=>[x.n,R0(x.v)]),['Total non-liquid',R0(sum(I))]]});
SC.push({sh:'Net worth',t:'What you owe (Loans and dues)',h:['What you owe','Amount'],r:[...LI.map(([k,l])=>[l,R0(v(k))]),['Total owed',R0(debt)]]});
SC.push({sh:'Net worth',t:'Your net worth (what you own minus what you owe)',h:['Item','Value'],r:[['Total owned',R0(sum(AL))],['Total owed',R0(debt)],['Net worth',R0(sum(AL)-debt)]]});
SC.push({sh:'Income & expenses',t:'Where your money goes every month',h:['Category','Type','Monthly amount','Share of '+(inc?'income':'spending')],r:[...XL.sort((a,b)=>b.v-a.v).map(x=>[x.n,x.e?'Essential':'Can cut',R0(x.v),pc(x.v)]),['Total spending','',R0(tot),pc(tot)],['Monthly income','',R0(inc),''],[sv>=0?'Saved each month':'Overspent by','',R0(Math.abs(sv)),inc?Math.round(Math.abs(sv)/inc*100)+'%':'']]});
{const q=prot(),tg=tot*6;SC.push({sh:'Income & expenses',t:'Your protection: term, health and emergency money',h:['Item','Details'],r:[['Life insurance',q.tm==='Yes'?'Yes':'No'],['Life cover',R0(q.lc)],['Term yearly payment',R0(q.tp)],['Term policy runs till age',q.tt?String(q.tt):'-'],['Health insurance type',q.hs],['Health cover',R0(q.hc)],['Health yearly payment',R0(q.hp)],['Super top-up',q.ht],['Emergency money kept',R0(q.ef)],['Emergency money goal (6 months)',R0(tg)],['Months covered',tot?(q.ef/tot).toFixed(1)+' months':'-'],['Where it is kept',q.ew]]})}
SC.push({sh:'Retirement plan',t:'Numbers used for your plan',h:['Item','Value'],r:[['Current age',String(p.age)],['Retire at age',String(p.ret)],['Money should last till age',String(p.life)],['Monthly spending today',R0(p.exp)],['Pension or rent after retiring (per month, today)',R0(p.oth)],['Price rise',p.infl+'% a year'],['Yearly growth before retiring',p.rpre+'% a year'],['Yearly growth after retiring',p.rpost+'% a year'],['Savings kept for retirement today',R0(p.cur)],['Monthly investment',R0(p.sip)],['Yearly yearly increase',p.step+'%']]});
SC.push({sh:'Retirement plan',t:'Your retirement result',h:['Item','Value'],r:[['Money needed on retirement day',R0(n)],['Money you will have',R0(f)],[f>=n?'Extra':'Shortfall',R0(Math.abs(f-n))],['Monthly investment needed',R0(sl)],['Earliest age you can retire at this pace',e?String(e):'Not before '+p.life]]});
const gk=Object.keys(G).map(Number).sort((a,b)=>a-b);
SC.push({sh:'Life goals',t:'Your life goals',h:['Age','Goal','Cost today','Cost at that age'],r:gk.length?gk.map(a=>[String(a),G[a].name||'Goal',R0(G[a].amt||0),R0((G[a].amt||0)*Math.pow(1+p.infl/100,a-p.age))]):[['-','None added','','']]});
SC.push({sh:'Year by year',t:'Year by year: your savings and life goals',h:['Age','Year','Savings at start of year','Added (+) / spent (-)','Growth earned','Goal cost that year','Savings at end of year'],r:lastR.map(r=>[String(r.a),String(YR+r.a-p.age),R0(r.open),R0(r.flow),R0(r.ret),R0(r.g),R0(r.close)])});
return SC}
const who=()=>USER?USER.name+' '+USER.surname+(USER.city?', '+USER.city:''):'';
function dl(t){const SC=report(),d=new Date().toLocaleDateString('en-IN');
if(t==='xls'){xlsPro(SC,d).catch(er=>{console.error(er);try{xlsMain(SC,d)}catch(e2){xlsFb(SC,d)}});return}function xlsMain(SC,d){if(!window.XLSX)throw 0;
const wb=XLSX.utils.book_new(),g={};SC.forEach(x=>(g[x.sh]=g[x.sh]||[]).push(x));
const sm=[['RetirementPlanKaro.com - Retirement Report'],['Website','https://www.retirementplankaro.com'],['Email',CFG.mail],['Prepared for',who()],['Date',d],[],['Sheets: '+Object.keys(g).join(', ')]];XLSX.utils.book_append_sheet(wb,XLSX.utils.aoa_to_sheet(sm),'Summary');
Object.keys(g).forEach(k=>{const a=[];g[k].forEach(x=>{a.push([x.t],x.h,...x.r,[])});const ws=XLSX.utils.aoa_to_sheet(a);ws['!cols']=[{wch:44},{wch:22},{wch:22},{wch:26},{wch:16},{wch:16},{wch:18}];XLSX.utils.book_append_sheet(wb,ws,k.slice(0,31))});
fload();if(FAM.length){famDash(FAM);const fa=[['Name','Relation','Age','Monthly income','Monthly spending','Liquid assets','Non-liquid assets','Loans and dues','Net worth','Monthly investment','Life cover','Life cover payment (yearly)','Health type','Health cover','Health cover payment (yearly)','Super top-up','Emergency money','Where kept'],...FAM.map(m=>[m.name,m.rel,m.age,m.inc,m.exp,m.liq,m.ill,m.debt,nwm(m),m.sip,m.lc,m.tp,m.hs,m.hc,m.hp,m.ht,m.ef,m.ew])],wf=XLSX.utils.aoa_to_sheet(fa);wf['!cols']=fa[0].map(()=>({wch:18}));XLSX.utils.book_append_sheet(wb,wf,'Family')}
XLSX.utils.book_append_sheet(wb,XLSX.utils.aoa_to_sheet([['Section','Type','Guidance'],...[['Net worth',GUIDE.nw],['Income and Expense',GUIDE.exp],['Retirement plan',GUIDE.plan],['Protection',GUIDE.prot],['Withdrawal Plan',GUIDE.swp],['Family',GUIDE.fam]].flatMap(([k,a])=>a.map(i=>[k,i.t==='g'?'Good':i.t==='w'?'Watch':'Act',tx(i.x)]))]),'AI Guidance');XLSX.writeFile(wb,'RetirementPlanKaro-Report.xlsx');toast('Excel report downloaded');return}
mkPdf(SC,d)}
const SCF=()=>SC();
function INS(fm){const p=P(),AL=assetList(),XL=expList().filter(x=>x.v>0),inc=v('inc'),tot=XL.reduce((a,x)=>a+x.v,0),sv=inc-tot,debt=LI.reduce((a,[k])=>a+v(k),0),ta=AL.reduce((a,x)=>a+x.v,0),n=need(p,{}),f=proj(p,{}),rd=Math.round(Math.min(100,n?f/n*100:100));
const yrs=Math.max(0,p.ret-p.age),mi=(p.rpre||0)/1200,gap=n-f,fx=mi>0?(Math.pow(1+mi,yrs*12)-1)/mi:yrs*12,xs=gap>0&&fx>0?gap/fx:0,mex=p.exp,fe=mex*Math.pow(1+p.infl/100,yrs),fn=Math.max(0,p.exp-(p.oth||0))*Math.pow(1+p.infl/100,yrs),sr=inc>0?sv/inc*100:null,liq=AL.filter(x=>x.t==='L').reduce((a,x)=>a+x.v,0),mo=tot>0?liq/tot:0,ann=inc*12,bm=p.age<30?1:p.age<40?3:p.age<50?6:p.age<60?8:10,nw2=ann>0?(ta-debt)/ann:null,wr=f>0?fn*12/f*100:null,ins=[];
ins.push(['Are you ready to retire?',rd>=100?'Your savings are expected to reach '+fm(f)+', and you need '+fm(n)+'. You are on track. Keep investing and check your plan once a year.':'You are about '+rd+'% ready. The gap is about '+fm(gap)+'. Investing about '+fm(xs)+' more every month until age '+p.ret+' could close it. Retiring a little later or spending a little less also helps.',rd>=100?'g':rd>=70?'a':'r']);
if(p.infl>0)ins.push(['Rising prices',mex?'With prices rising '+p.infl+'% a year, '+fm(mex)+' a month today will cost about '+fm(fe)+' a month at age '+p.ret+'. Prices double in about '+(72/p.infl).toFixed(0)+' years, so your money must grow faster than prices.':'Prices double in about '+(72/p.infl).toFixed(0)+' years at '+p.infl+'% a year. Your money must grow faster than that.','a']);
if(sr!==null)ins.push(['How much you save','You save about '+Math.round(sr)+'% of your income. '+(sr>=30?'That is a strong habit. Make sure the savings are invested and not sitting idle.':sr>=20?'That is a healthy level. Try to raise it a little each time your income grows.':sr>0?'Many people aim for 20% or more. A small automatic monthly investment on salary day is the easiest way to get there.':'You spend as much as you earn, or more. Fix this first, before any investing goal.'),sr>=20?'g':sr>0?'a':'r']);
if(nw2!==null)ins.push(['Your net worth for your age','Your net worth is about '+nw2.toFixed(1)+' times your yearly income. A common guide for your age is about '+bm+' times. '+(nw2>=bm?'You are at or above the guide.':'You are below the guide, which is common. Steady monthly investing closes the gap over time.'),nw2>=bm?'g':'a']);
if(tot>0)ins.push(['Safety money','Your liquid assets cover about '+mo.toFixed(1)+' months of spending. A good aim is 6 months, kept in a savings account or a safe fund, apart from your long-term investments.',mo>=6?'g':mo>=3?'a':'r']);
if(debt>0&&ta>0)ins.push(['Loans','Your loans are about '+Math.round(debt/ta*100)+'% of what you own. Repay the costliest loan first. Its interest is a sure cost, while investment growth is never sure.',debt/ta<.2?'g':debt/ta<.4?'a':'r']);
if(p.rpre>0)ins.push(['Why starting early wins','At '+p.rpre+'% a year, money doubles in about '+(72/p.rpre).toFixed(1)+' years. Each year of delay costs more than the one before. Time matters more than the exact growth rate.','n']);
if(wr!==null)ins.push(['How long your money will last','In your first year of retirement you will take out about '+wr.toFixed(1)+'% of your savings. Around 4% or less is seen as safe for a long retirement. A higher share raises the risk of running out.',wr<=4?'g':wr<=5.5?'a':'r']);
const sc=[],S=(nm,q)=>{try{const nn=need(q,{}),ff=proj(q,{});sc.push([nm,nn,ff,nn?Math.min(100,Math.round(ff/nn*100)):100,ff-nn])}catch(e){}};
S('Your plan today',p);S('Retire 2 years later',{...p,ret:Math.min(p.ret+2,p.life-1)});S('Invest '+fm(5000)+' more a month',{...p,sip:p.sip+5000});S('Spend 10% less after retiring',{...p,exp:p.exp*.9});S('Growth 2% lower each year',{...p,rpre:Math.max(0,p.rpre-2),rpost:Math.max(0,p.rpost-2)});S('Prices rise 1% faster',{...p,infl:p.infl+1});
return{ins,sc,rd,fe,fn,yrs,n,f,p,xs}}
const tx=h=>csym(String(h).replace(/<[^>]+>/g,''));
function rpkWM(doc,light){try{doc.saveGraphicsState();doc.setGState(new doc.GState({opacity:light?.12:.06}));doc.setFont('helvetica','bold');doc.setFontSize(54);doc.setTextColor(...(light?[255,255,255]:[11,42,74]));doc.text('RetirementPlanKaro.com',297.5,421,{align:'center',angle:45});doc.restoreGraphicsState()}catch(e){}}
function mkPdf(SC,d){if(!window.jspdf){toast('PDF library could not load. Check your connection.');return}
const doc=new jspdf.jsPDF({unit:'pt',format:'a4'}),W=595,NV=[11,42,74],AM=[201,162,75],GR=[18,128,92],RD=[194,65,45],PAL=[[27,58,107],[62,111,216],[18,128,92],[245,165,36],[181,103,28],[138,111,209],[152,162,184]],URL='https://www.retirementplankaro.com';
const p=P(),AL=assetList(),XL=expList().filter(x=>x.v>0).sort((a,b)=>b.v-a.v),inc=v('inc'),tot=XL.reduce((a,x)=>a+x.v,0),sv=inc-tot,debt=LI.reduce((a,[k])=>a+v(k),0),ta=AL.reduce((a,x)=>a+x.v,0),n=need(p,{}),f=proj(p,{}),rd=Math.round(Math.min(100,n?f/n*100:100));
const TOC=[],olq=t=>{try{doc.outline.add(null,t,{pageNumber:doc.getNumberOfPages()})}catch(e){}},ol=t=>{olq(t);TOC.push([t,doc.getNumberOfPages()])};
const T=(t,x,y,sz,c,b,o)=>{doc.setFont('helvetica',b?'bold':'normal');doc.setFontSize(sz);doc.setTextColor(...c);doc.text(String(t),x,y,o)},sec=(t,y)=>{T(t,40,y,13,NV,1);doc.setDrawColor(...AM);doc.setLineWidth(2);doc.line(40,y+5,90,y+5);olq(t);if(/^(Your Financial Checklist|Your personalized action plan|Important risk disclosure)/.test(t))TOC.push([t,doc.getNumberOfPages()])};
const arc=(cx,cy,r,a0,a1,c)=>{doc.setFillColor(...c);doc.setDrawColor(...c);doc.setLineWidth(.3);for(let a=a0;a<a1;a+=2){const b=Math.min(a+2.5,a1),u=a*Math.PI/180,w=b*Math.PI/180;doc.triangle(cx,cy,cx+r*Math.cos(u),cy+r*Math.sin(u),cx+r*Math.cos(w),cy+r*Math.sin(w),'FD')}};
const card=(y0,h,t2,c)=>{const L=doc.splitTextToSize(tx(t2),485),hh=L.length*12+34;if(y0+hh>790){doc.addPage();y0=70}doc.setFillColor(243,245,250);doc.roundedRect(40,y0,515,hh,8,8,'F');doc.setFillColor(...c);doc.rect(40,y0,4,hh,'F');T(h,56,y0+17,10.5,NV,1);doc.setFont('helvetica','normal');doc.setFontSize(9.5);doc.setTextColor(20,33,61);doc.text(L,56,y0+32);return y0+hh+8},CM={g:GR,a:[217,119,6],r:RD,n:NV},dc=t2=>tx(t2).replace(/&#x27;/g,"'").replace(/&amp;/g,'&').replace(/&quot;/g,'"');
// premium cover
{const sc0=SCF(),RID='RPK-'+new Date().toISOString().slice(0,10).replace(/-/g,'')+'-'+String((USER&&USER.code)||'0000').slice(-4),cx=W/2,cy=520,GL=[243,223,162];
doc.setProperties({title:'Premium Retirement Report',author:'RetirementPlanKaro.com',subject:'Retirement plan for '+(who()||'you'),keywords:'retirement plan, India'});
doc.setFillColor(...NV);doc.rect(0,0,W,842,'F');doc.setFillColor(...AM);doc.rect(0,0,W,6,'F');doc.rect(0,836,W,6,'F');
doc.setDrawColor(...AM);doc.setLineWidth(.9);doc.rect(28,28,W-56,786);doc.setLineWidth(.3);doc.rect(34,34,W-68,774);
doc.setFillColor(...AM);doc.roundedRect(cx-24,84,48,48,11,11,'F');T('R',cx,119,30,NV,1,{align:'center'});T('RetirementPlanKaro.com',cx,156,11,GL,1,{align:'center'});
doc.setFont('times','bold');doc.setFontSize(42);doc.setTextColor(255,255,255);doc.text('Premium',cx,244,{align:'center'});doc.text('Retirement Report',cx,292,{align:'center'});
doc.setFillColor(...AM);doc.rect(cx-40,314,80,2.5,'F');
T('Prepared for',cx,358,10,[190,206,232],0,{align:'center'});doc.setFont('times','bold');doc.setFontSize(24);doc.setTextColor(...GL);doc.text(who()||'You',cx,388,{align:'center'});
arc(cx,cy,72,-90,269.9,[24,62,104]);if(rd>0)arc(cx,cy,72,-90,-90+Math.min(359.9,rd*3.6),AM);doc.setFillColor(...NV);doc.circle(cx,cy,52,'F');
T(rd+'%',cx,cy+6,26,[255,255,255],1,{align:'center'});T('ready',cx,cy+22,9,[190,206,232],0,{align:'center'});
T('Retirement readiness',cx,cy+104,11,AM,1,{align:'center'});if(sc0.t!=null)T('Financial Health Score: '+sc0.t+' / 100',cx,cy+124,11,[255,255,255],0,{align:'center'});
T(d,cx,742,10,[190,206,232],0,{align:'center'});T('Report ID: '+RID,cx,758,9,[190,206,232],0,{align:'center'});T('Questions? Email '+CFG.mail,cx,773,9,GL,0,{align:'center'});doc.link(cx-100,762,200,14,{url:'mailto:'+CFG.mail});T('Confidential. Educational estimate, not financial advice.',cx,788,8.5,[150,170,205],0,{align:'center'});doc.link(cx-90,144,180,16,{url:URL})}
doc.addPage(); // page 2 is kept for Contents and filled at the end
// executive summary
{doc.addPage();let y=70;ol('Executive summary');doc.setFillColor(...NV);doc.roundedRect(40,y-18,515,50,10,10,'F');T('Executive Summary',56,y+3,16,[255,255,255],1);T('Your plan on one page.',56,y+21,9.5,[210,222,245]);y+=56;
const top=ACI(),hs=SCF(),vc=rd>=100?GR:rd>=70?[217,119,6]:RD,vt=rd>=100?'You are on track for retirement.':rd>=70?'You are close. A few changes will get you there.':'You have a gap to close, and the earlier you act the easier it is.';
doc.setFillColor(...vc);doc.roundedRect(40,y,515,44,8,8,'F');T(vt,56,y+27,13,[255,255,255],1);y+=60;
[['Net worth',pm(ta-debt)],['Monthly saving',pm(sv)],['Money needed to retire',pm(n)],['Money you will have',pm(f)]].forEach((k,i)=>{const x=40+i*133;doc.setFillColor(232,237,248);doc.roundedRect(x,y,123,56,8,8,'F');doc.setFillColor(...AM);doc.rect(x,y+50,123,2,'F');T(k[0],x+10,y+18,8.5,[85,98,122]);T(k[1],x+10,y+40,12.5,NV,1)});y+=76;
if(hs.t!=null){T('Financial Health Score',40,y,11,NV,1);T(hs.t+' / 100 ('+hs.l+')',W-40,y,11,NV,1,{align:'right'});doc.setFillColor(232,237,248);doc.roundedRect(40,y+8,515,10,5,5,'F');doc.setFillColor(...(hs.t>=70?GR:hs.t>=50?[217,119,6]:RD));doc.roundedRect(40,y+8,Math.max(8,515*hs.t/100),10,5,5,'F');y+=36;(hs.pts||[]).filter(x=>x.pts!=null).forEach(x=>{T(x.n,40,y,9,[20,33,61]);doc.setFillColor(232,237,248);doc.rect(170,y-8,250,9,'F');const pc=x.pts/20*100;doc.setFillColor(...(pc>=70?GR:pc>=40?[217,119,6]:RD));doc.rect(170,y-8,Math.max(1,Math.min(100,pc))/100*250,9,'F');T(Math.round(x.pts)+' / 20',W-40,y,9,NV,1,{align:'right'});y+=16});y+=14}
sec('Do these first',y);y+=26;top.slice(0,3).forEach((a,i)=>{const L=doc.splitTextToSize(dc(a.x),470),hh=L.length*12+16;doc.setFillColor(243,245,250);doc.roundedRect(40,y,515,hh,8,8,'F');doc.setFillColor(...AM);doc.circle(58,y+hh/2,9,'F');T(String(i+1),58,y+hh/2+4,10,NV,1,{align:'center'});doc.setFont('helvetica','normal');doc.setFontSize(9.5);doc.setTextColor(20,33,61);doc.text(L,76,y+14);y+=hh+8});y+=8;
const gd2=[GUIDE.nw,GUIDE.exp,GUIDE.prot,GUIDE.plan,GUIDE.swp,GUIDE.fam].flatMap(a=>a).filter(i=>i.t==='g').slice(0,3);
if(gd2.length){sec('What is going well',y);y+=26;gd2.forEach(a=>{const L=doc.splitTextToSize(dc(a.x),480);doc.setFillColor(...GR);doc.circle(46,y-3,3,'F');doc.setFont('helvetica','normal');doc.setFontSize(9.5);doc.setTextColor(20,33,61);doc.text(L,56,y);y+=L.length*12+6})}}
doc.addPage();TOC.push(['Your snapshot',doc.getNumberOfPages()]);
// cover
doc.setFillColor(...NV);doc.rect(0,0,W,118,'F');doc.setFillColor(...AM);doc.roundedRect(40,30,34,34,8,8,'F');T('R',50,55,22,NV,1);T('RetirementPlanKaro.com',84,48,22,[255,255,255],1);doc.link(84,30,230,24,{url:URL});T('Plan your Retirement, Secure your Future',84,66,10,[210,222,245]);T('Your Snapshot',40,100,13,AM,1);T('Prepared for: '+(who()||'You'),W-40,86,10,[255,255,255],0,{align:'right'});T(d,W-40,102,10,[210,222,245],0,{align:'right'});
const K=[['Net worth',pm(ta-debt)],['Monthly saving',pm(sv)],['Money needed to retire',pm(n)],['Plan ready',rd+'%']];K.forEach((k,i)=>{const x=40+i*133;doc.setFillColor(232,237,248);doc.roundedRect(x,134,123,56,8,8,'F');T(k[0],x+10,152,8.5,[85,98,122]);T(k[1],x+10,175,13,i===3?(rd>=100?GR:rd>=70?AM:RD):NV,1)});
sec('Where your money sits',222);const dt=AL.filter(x=>x.v>0).map((x,i)=>({...x,c:PAL[i%7]}));let a0=-90;dt.forEach(x=>{const a1=a0+x.v/(ta||1)*360;if(a1>a0)arc(130,320,68,a0,Math.min(a1,a0+359.9),x.c);a0=a1});doc.setFillColor(255,255,255);doc.circle(130,320,40,'F');T('Assets',130,316,8,[85,98,122],0,{align:'center'});T(pm(ta),130,330,10,NV,1,{align:'center'});
dt.slice(0,9).forEach((x,i)=>{const y=262+i*17;doc.setFillColor(...x.c);doc.rect(230,y-8,9,9,'F');T(x.n+(x.t==='L'?' (liquid)':' (non-liquid)'),245,y,9,[20,33,61]);T(pm(x.v)+'  '+Math.round(x.v/(ta||1)*100)+'%',W-40,y,9,[20,33,61],1,{align:'right'})});
sec('Where your money goes (monthly)',420);const bx=XL.slice(0,6),mxv=Math.max(1,...bx.map(x=>x.v),sv>0?sv:0),rowsB=sv>0?[...bx,{n:'Savings',v:sv,sv:1}]:bx;rowsB.forEach((x,i)=>{const y=442+i*19;T(x.n.slice(0,22),40,y+9,9,[20,33,61]);doc.setFillColor(...(x.sv?GR:PAL[i%7]));doc.rect(170,y,Math.max(2,x.v/mxv*260),12,'F');T(pm(x.v)+' ('+Math.round(x.v/(Math.max(inc,tot)||1)*100)+'%)',178+x.v/mxv*260,y+9,8.5,[20,33,61])});
sec('Your savings by age',600);const cx0=60,cy0=620,cw=480,ch=120,R=lastR,mxc=Math.max(1,...R.map(r=>r.close)),mnc=Math.min(0,...R.map(r=>r.close)),X=a=>cx0+(a-R[0].a)/((R[R.length-1].a-R[0].a)||1)*cw,Y=y=>cy0+ch-(y-mnc)/((mxc-mnc)||1)*ch;doc.setDrawColor(221,227,239);doc.setLineWidth(.5);doc.rect(cx0,cy0,cw,ch);doc.setLineWidth(1.8);doc.setDrawColor(...NV);R.forEach((r,i)=>{if(i)doc.line(X(R[i-1].a),Y(R[i-1].close),X(r.a),Y(r.close))});doc.setDrawColor(...AM);doc.setLineDashPattern([3,3],0);doc.line(X(p.ret),cy0,X(p.ret),cy0+ch);doc.setLineDashPattern([],0);T('Retire at '+p.ret,X(p.ret)+4,cy0+10,8,AM,1);T('Age '+R[0].a,cx0,cy0+ch+12,8,[85,98,122]);T('Age '+R[R.length-1].a,cx0+cw,cy0+ch+12,8,[85,98,122],0,{align:'right'});T('Peak '+pm(mxc),cx0+4,cy0+10,8,[85,98,122]);
doc.addPage();let y=70;doc.setFillColor(232,237,248);doc.roundedRect(40,y-14,515,100,10,10,'F');T('How to read this report',54,y+4,12,NV,1);['1. Your money today: what you own, what you owe, and your net worth.','2. Your monthly spending: where your income goes.','3. Your retirement plan: money you need and money you will have.','4. Key insights, what-if scenarios, smart tips, a checklist and your Family Dashboard come next.','5. Learning pages and risk notes are at the end. Please read them.'].forEach((t,i)=>T(t,54,y+24+i*14,9.5,[20,33,61]));y+=116;
// tables
SC.forEach(x=>{if(y>700){doc.addPage();y=70}sec(x.t,y);doc.autoTable({startY:y+12,head:[x.h],body:x.r.map(r=>r.map(c=>typeof c==='number'?pm(c):c)),styles:{fontSize:x.h.length>5?7:9,cellPadding:3},headStyles:{fillColor:NV},alternateRowStyles:{fillColor:[243,245,250]},margin:{top:60,left:40,right:40,bottom:40}});y=doc.lastAutoTable.finalY+26});
// insights
{const IN=INS(pm);doc.addPage();let y=70;doc.setFillColor(...NV);doc.roundedRect(40,y-18,515,50,10,10,'F');T('Your Financial Insights',56,y+3,16,[255,255,255],1);T('What your numbers say, in plain words.',56,y+21,9.5,[210,222,245]);ol('Your Financial Insights');y+=54;
IN.ins.forEach(([h,t2,c])=>{y=card(y,h,t2,CM[c])});
const nt=doc.splitTextToSize('These insights use the numbers and assumptions you entered. They are educational estimates, not advice, and real growth and price rise will differ.',515);if(y+30>790){doc.addPage();y=70}doc.setFont('helvetica','italic');doc.setFontSize(8.5);doc.setTextColor(85,98,122);doc.text(nt,40,y+8);
if(IN.sc.length>1){doc.addPage();y=70;doc.setFillColor(...NV);doc.roundedRect(40,y-18,515,50,10,10,'F');T('What if you change your plan?',56,y+3,16,[255,255,255],1);T('See how one change moves your result.',56,y+21,9.5,[210,222,245]);ol('What if you change your plan?');y+=54;
doc.autoTable({startY:y,head:[['Change','Money needed','Money you will have','Ready','Extra or short']],body:IN.sc.map(r=>[r[0],pm(r[1]),pm(r[2]),r[3]+'%',(r[4]>=0?'+':'')+pm(r[4])]),styles:{fontSize:9,cellPadding:5},headStyles:{fillColor:NV,textColor:[243,223,162]},alternateRowStyles:{fillColor:[243,245,250]},margin:{top:60,left:40,right:40,bottom:40},didParseCell:d2=>{if(d2.section==='body'&&d2.column.index===4)d2.cell.styles.textColor=String(d2.cell.raw).indexOf('-')>=0?RD:GR;if(d2.section==='body'&&d2.row.index===0)d2.cell.styles.fontStyle='bold'}});y=doc.lastAutoTable.finalY+16;
const b=IN.sc.slice(1).sort((a,c)=>c[4]-a[4])[0];if(b){const L=doc.splitTextToSize('The biggest improvement in this list comes from: '+b[0].toLowerCase()+'. Try a mix of two small changes rather than one big one.',515);doc.setFont('helvetica','bold');doc.setFontSize(10);doc.setTextColor(...NV);doc.text(L,40,y);y+=L.length*13+6}
doc.setFont('helvetica','italic');doc.setFontSize(8.5);doc.setTextColor(85,98,122);doc.text(doc.splitTextToSize('Each row changes one thing and keeps the rest of your plan the same. These are estimates, not promises.',515),40,y)}}
// roadmap
{const IN=INS(pm),p0=IN.p;if(p0.life>p0.age&&p0.ret>p0.age){doc.addPage();let y=70;doc.setFillColor(...NV);doc.roundedRect(40,y-18,515,50,10,10,'F');T('Your Retirement Roadmap',56,y+3,16,[255,255,255],1);T('Where you are, where you are going.',56,y+21,9.5,[210,222,245]);ol('Your Retirement Roadmap');y+=70;
const x0=60,x1=535,a0=p0.age,a1=Math.max(p0.life,p0.ret+1),XA=a=>x0+(a-a0)/(a1-a0)*(x1-x0),ty=y;
doc.setFillColor(...NV);doc.roundedRect(XA(a0),ty,Math.max(10,XA(p0.ret)-XA(a0)),18,9,9,'F');doc.setFillColor(...AM);doc.roundedRect(XA(p0.ret),ty,Math.max(10,XA(a1)-XA(p0.ret)),18,9,9,'F');
T('Saving years',XA(a0)+10,ty+12,8.5,[255,255,255],1);T('Retirement years',XA(p0.ret)+10,ty+12,8.5,NV,1);
T('Age '+a0,XA(a0),ty+38,9,[85,98,122]);T('Age '+p0.ret,XA(p0.ret),ty+38,9,NV,1,{align:'center'});T('Age '+a1,XA(a1),ty+38,9,[85,98,122],0,{align:'right'});
T((p0.ret-p0.age)+' years to save',XA(a0),ty+56,9.5,NV,1);T((a1-p0.ret)+' years of retirement',XA(a1),ty+56,9.5,NV,1,{align:'right'});y=ty+86;
[['Today','Savings kept for retirement',pm(p0.cur)],['At age '+p0.ret,'Money you will have',pm(IN.f)],['At age '+p0.ret,'Money you need',pm(IN.n)],['Each month at retirement','Your spending, after price rise',pm(IN.fe)]].forEach((k,i)=>{const x=40+(i%2)*263,yy=y+Math.floor(i/2)*92;doc.setFillColor(243,245,250);doc.roundedRect(x,yy,252,80,10,10,'F');doc.setFillColor(...AM);doc.rect(x,yy+10,4,60,'F');T(k[0].toUpperCase(),x+16,yy+20,8,[85,98,122],1);T(k[2],x+16,yy+46,17,NV,1);T(k[1],x+16,yy+64,9,[85,98,122])});y+=200;
const rdv=IN.rd,msg=rdv>=100?'Your savings are expected to cover your retirement. Keep going and review once a year.':'You are '+rdv+'% of the way there. The What-if page shows the easiest ways to close the gap.';
doc.setFillColor(...(rdv>=100?GR:rdv>=70?[217,119,6]:RD));doc.roundedRect(40,y,515,40,8,8,'F');doc.setFont('helvetica','bold');doc.setFontSize(10.5);doc.setTextColor(255,255,255);doc.text(doc.splitTextToSize(msg,490),56,y+17)}}
// guidance
doc.addPage();y=70;const gs=[['Your money today',GUIDE.nw],['Income and spending',GUIDE.exp],['Your retirement plan',GUIDE.plan],['Your protection',GUIDE.prot],['Monthly pension and life goals',GUIDE.swp]];
gs.forEach(([t,a])=>{if(y>700){doc.addPage();y=70}sec('Smart tips (AI Guidance): '+t,y);y+=24;(a.length?a:[gd('w','Add more details to see guidance.')]).forEach(it=>{const L=doc.splitTextToSize(tx(it.x),480);if(y+L.length*12>790){doc.addPage();y=70}doc.setFillColor(...(it.t==='g'?GR:it.t==='w'?AM:RD));doc.circle(46,y-3,3,'F');T('',0,0,9,[0,0,0]);doc.setFontSize(9.5);doc.setTextColor(20,33,61);doc.text(L,56,y);y+=L.length*12+5});y+=10});
const AGS=['20s','30s','40s','50s','60p'],ag=p.age,mine=ag<30?'20s':ag<40?'30s':ag<50?'40s':ag<60?'50s':'60p';doc.addPage();y=70;sec('Your Financial Checklist for every age',y);y+=22;T('Tick each box when done. Start with your own age group, then use the others to plan ahead or help family.',40,y,9,[85,98,122]);y+=22;
[mine,...AGS.filter(k=>k!==mine)].forEach(k=>{const pn=document.getElementById('ck-'+k);if(!pn)return;if(y>740){doc.addPage();y=70}T(pn.querySelector('h3').textContent+(k===mine?'  (your age group)':''),40,y,11.5,k===mine?GR:NV,1);y+=15;[...pn.querySelectorAll('.ck span')].forEach(e=>{const L=doc.splitTextToSize(tx(e.textContent),470);if(y+L.length*12>800){doc.addPage();y=70}doc.setDrawColor(...NV);doc.setLineWidth(1);doc.rect(44,y-8,9,9);{const cb=e.parentElement&&e.parentElement.querySelector('input');if(cb&&cb.checked){doc.setDrawColor(...GR);doc.setLineWidth(1.6);doc.line(45.5,y-3.5,48,y-1);doc.line(48,y-1,52,y-7);doc.setDrawColor(...NV);doc.setLineWidth(1)}}doc.setFont('helvetica','normal');doc.setFontSize(9.5);doc.setTextColor(20,33,61);doc.text(L,62,y);y+=L.length*12+5});y+=10});
// family dashboard
fload();const FM=FAM.slice();
if(FM.length){famDash(FM);
const fs=k=>FM.reduce((a,m)=>a+m[k],0),fInc=fs('inc'),fEx=fs('exp'),fLiq=fs('liq'),fIll=fs('ill'),fDebt=fs('debt'),fNw=fLiq+fIll-fDebt,fSv=fInc-fEx,fEf=fs('ef'),earnF=FM.filter(m=>m.inc>0),fMo=fEx?fEf/fEx:0,fTgt=fEx*(earnF.length===1&&FM.length>1?9:6),ewF=earnF.filter(m=>m.age<60),dec=s=>String(s).replace(/&amp;/g,'&').replace(/&#x27;/g,"'").replace(/&quot;/g,'"').replace(/&lt;/g,'<').replace(/&gt;/g,'>');
const fpg=h=>{if(y+h>790){doc.addPage();y=70}};
const fn2=t=>{const L=doc.splitTextToSize(t,515);fpg(L.length*12);doc.setFont('helvetica','normal');doc.setFontSize(9);doc.setTextColor(85,98,122);doc.text(L,40,y);y+=L.length*12+4};
const fb=(l,pct,t2,col)=>{fpg(20);T(String(l).slice(0,34),40,y,9,[20,33,61]);doc.setFillColor(232,237,248);doc.rect(215,y-8,190,9,'F');doc.setFillColor(...col);doc.rect(215,y-8,Math.max(1,Math.min(100,pct))/100*190,9,'F');T(t2,W-40,y,8.5,[20,33,61],1,{align:'right'});y+=17};
const fdn=(cx,cy,items,t)=>{T(t,cx,cy-62,9.5,NV,1,{align:'center'});const t3=items.reduce((a,x)=>a+x.v,0);if(!t3){T('No data',cx,cy,9,[85,98,122],0,{align:'center'});return}let b1=-90;items.forEach(x=>{const b2=b1+x.v/t3*360;arc(cx,cy,46,b1,Math.min(b2,b1+359.9),x.c);b1=b2});doc.setFillColor(255,255,255);doc.circle(cx,cy,26,'F');items.slice(0,5).forEach((x,i)=>{const ly=cy+62+i*12;doc.setFillColor(...x.c);doc.rect(cx-70,ly-7,7,7,'F');T(String(x.n).slice(0,14),cx-60,ly,8,[20,33,61]);T(Math.round(x.v/t3*100)+'%',cx+70,ly,8,[20,33,61],1,{align:'right'})})};
doc.addPage();y=70;doc.setFillColor(...NV);doc.roundedRect(40,y-18,515,50,10,10,'F');T('Your Family Dashboard',56,y+3,16,[255,255,255],1);T("One view of your family's money, insurance and risks.",56,y+21,9.5,[210,222,245]);ol('Your Family Dashboard');y+=62;
[['Members',String(FM.length)],['Family net worth',pm(fNw)],['Monthly income',pm(fInc)],['Monthly spending',pm(fEx)],['Monthly saving',pm(fSv)],['Life cover',pm(fs('lc'))],['Health cover',pm(fs('hc'))],['Emergency money',pm(fEf)]].forEach((k,i)=>{const x=40+(i%4)*133,yy=y+Math.floor(i/4)*54;doc.setFillColor(232,237,248);doc.roundedRect(x,yy,123,46,8,8,'F');T(k[0],x+10,yy+16,8.5,[85,98,122]);T(k[1],x+10,yy+36,12,((i===4&&fSv<0)||(i===1&&fNw<0))?RD:NV,1)});y+=122;
const cyy=y+70;fdn(110,cyy,FM.map((m,i)=>({n:m.name,v:Math.max(0,nwm(m)),c:PAL[i%7]})).filter(x=>x.v>0),'Net worth by member');fdn(297,cyy,FM.map((m,i)=>({n:m.name,v:m.inc,c:PAL[i%7]})).filter(x=>x.v>0),'Income by member');fdn(485,cyy,[{n:'Liquid',v:fLiq,c:PAL[2]},{n:'Non-liquid',v:fIll,c:PAL[3]}].filter(x=>x.v>0),'Where family money sits');y+=205;
fpg(100);sec('Life insurance cover',y);y+=20;fn2(FM.filter(m=>m.tm==='Yes'&&m.lc>0).length+' of '+FM.length+' members have life cover. Total '+pm(fs('lc'))+', yearly payment '+pm(fs('tp'))+'. Guide: 10 times yearly income for earning members under 60.');if(ewF.length)ewF.forEach(m=>{const nd=m.inc*120;fb(m.name+' - cover vs need',nd?m.lc/nd*100:0,pm(m.lc)+' of '+pm(nd),m.lc>=nd?GR:m.lc>0?AM:RD)});else fn2('No earning member under 60 added.');y+=8;
fpg(100);sec('Health insurance',y);y+=20;fn2(FM.filter(m=>m.hs!=='None'&&m.hc>0).length+' of '+FM.length+' members are covered. Total '+pm(fs('hc'))+', yearly payment '+pm(fs('hp'))+'. Guide: at least Rs. 5 lakh per person.');FM.forEach(m=>fb(m.name+' - '+m.hs.toLowerCase()+(m.ht==='Yes'?' + top-up':''),m.hc/5e5*100,m.hc?pm(m.hc):'No cover',m.hc>=5e5?GR:m.hc>0?AM:RD));y+=8;
fpg(100);sec('Emergency money',y);y+=20;fn2('Goal: '+(fEx?fTgt/fEx:6)+' months of family spending'+(fEx?' = '+pm(fTgt):'')+'. You have '+pm(fEf)+(fEx?' ('+fMo.toFixed(1)+' months)':'')+'.');fb('Family emergency money',fTgt?fEf/fTgt*100:0,pm(fEf)+(fTgt?' of '+pm(fTgt):''),(fEf>=fTgt&&fTgt)?GR:AM);FM.filter(m=>m.ef>0).forEach(m=>fb(m.name+' - '+m.ew.toLowerCase(),fTgt?m.ef/fTgt*100:0,pm(m.ef),NV));y+=8;
fpg(110);sec('All members at a glance',y);doc.autoTable({startY:y+12,head:[['Name','Relation','Age','Income','Spending','Net worth','Life cover','Health cover','Emergency money']],body:FM.map(m=>[m.name,m.rel,String(m.age),pm(m.inc),pm(m.exp),pm(nwm(m)),m.lc?pm(m.lc):'None',m.hc?pm(m.hc):'None',m.ef?pm(m.ef):'None']),styles:{fontSize:7.5,cellPadding:3},headStyles:{fillColor:NV},alternateRowStyles:{fillColor:[243,245,250]},margin:{top:60,left:40,right:40,bottom:40}});y=doc.lastAutoTable.finalY+26;
fpg(80);sec('Smart tips (AI Guidance): Your family',y);y+=24;(GUIDE.fam.length?GUIDE.fam:[gd('w','Add more family details to see guidance.')]).forEach(it=>{const L=doc.splitTextToSize(dec(tx(it.x)),480);fpg(L.length*12+5);doc.setFillColor(...(it.t==='g'?GR:it.t==='w'?AM:RD));doc.circle(46,y-3,3,'F');doc.setFont('helvetica','normal');doc.setFontSize(9.5);doc.setTextColor(20,33,61);doc.text(L,56,y);y+=L.length*12+5})}
const ents=q=>[...document.querySelectorAll(q)],ttl=d=>{const m=d.querySelector('summary').cloneNode(true),c=m.querySelector('.catg');if(c)c.remove();return m.textContent.trim()},body=d=>[...d.querySelectorAll('.body p')].map(x=>x.textContent).join(' ');
const LRN=[['Learn: simple guides','Short lessons on saving, investing and retirement.',ents('#lp-guides details.art').map(d=>[ttl(d),body(d)])],['Common beliefs and the truth','Ideas that sound right but can leave you short.',ents('#lp-myths .myth').map(m=>['Belief: '+m.querySelector('.m').textContent.replace(/[\u201C\u201D"]/g,''),'Truth: '+m.querySelector('.f').textContent.replace(/^Fact:\s*/,'')])],['Money words made simple','Common money words in plain language.',ents('#glist .gterm').map(g=>[g.querySelector('dt').textContent,g.querySelector('dd').textContent])],['Most asked questions','Quick answers to what people ask most.',ents('#lp-faq details.art').map(d=>[ttl(d),body(d)])]];
LRN.forEach(([h,sub,it])=>{if(!it.length)return;doc.addPage();y=70;doc.setFillColor(...NV);doc.roundedRect(40,y-18,515,50,10,10,'F');T(h,56,y+3,16,[255,255,255],1);T(sub,56,y+21,9.5,[210,222,245]);ol(h);y+=54;it.forEach(([q,a])=>{const L1=doc.splitTextToSize(tx(q),480),L2=doc.splitTextToSize(tx(a),480);if(y+(L1.length+Math.min(L2.length,3))*12+12>790){doc.addPage();y=70}doc.setFont('helvetica','bold');doc.setFontSize(10);doc.setTextColor(...NV);doc.text(L1,40,y);y+=L1.length*12+1;doc.setFont('helvetica','normal');doc.setFontSize(9.5);doc.setTextColor(20,33,61);L2.forEach(l=>{if(y>800){doc.addPage();y=70}doc.text(l,40,y);y+=12});y+=9})});
{doc.addPage();y=70;sec('Your personalized action plan',y);y+=24;ACI().forEach((a,i)=>{const L=doc.splitTextToSize(tx((i+1)+'. '+a.x).replace(/&#x27;/g,"'").replace(/&amp;/g,'&'),480);if(y+L.length*12>790){doc.addPage();y=70}doc.setFont('helvetica','normal');doc.setFontSize(9.5);doc.setTextColor(20,33,61);doc.text(L,50,y);y+=L.length*12+6})}
doc.addPage();y=70;sec('Important risk disclosure',y);y+=22;LG.risk[1].concat(['Your details are shared with partner advisers only if you ticked the optional consent at sign-up. You can withdraw consent any time at '+'Retirementplankaro@gmail.com'+'.']).forEach(t=>{const L=doc.splitTextToSize(tx(t),480);if(y+L.length*11>790){doc.addPage();y=70}doc.setFillColor(...AM);doc.circle(46,y-3,2.5,'F');doc.setFont('helvetica','normal');doc.setFontSize(9);doc.setTextColor(20,33,61);doc.text(L,56,y);y+=L.length*11+4});y+=6;T('Generated for '+(who()||'the user')+' on '+d+'. The user confirmed the Risk Disclosure before download.',40,y,8.5,[85,98,122]);y+=24;
if(y>700){doc.addPage();y=70}doc.setFillColor(...NV);doc.roundedRect(40,y,515,80,10,10,'F');T('Revisit your plan any time',58,y+26,13,[255,255,255],1);T('Update your plan any time at RetirementPlanKaro.com  |  Email: '+CFG.mail,58,y+45,10,[210,222,245]);T('Invite friends with code '+((USER&&USER.code)||'')+' and earn 100 points for every sign-up.',58,y+66,9.5,[243,223,162]);doc.link(40,y,515,62,{url:URL});
{doc.setPage(2);let y=70;doc.setFillColor(...NV);doc.roundedRect(40,y-18,515,50,10,10,'F');T('Contents',56,y+3,16,[255,255,255],1);T('Where to find what.',56,y+21,9.5,[210,222,245]);y+=64;
const seen=new Set;TOC.filter(e=>!seen.has(e[0])&&seen.add(e[0])).sort((a,b)=>a[1]-b[1]).forEach(([t,pg])=>{const tt=tx(t);T(tt,50,y,11,[20,33,61]);const tw=doc.getTextWidth(tt);doc.setDrawColor(201,208,224);doc.setLineWidth(.5);doc.setLineDashPattern([1,2],0);doc.line(56+tw,y,W-84,y);doc.setLineDashPattern([],0);T(String(pg),W-50,y,11,NV,1,{align:'right'});doc.link(40,y-12,515,18,{pageNumber:pg});y+=26})}
const N=doc.getNumberOfPages();for(let i=1;i<=N;i++){doc.setPage(i);rpkWM(doc,i===1);if(i===1)continue;if(i!==4){doc.setFillColor(...NV);doc.rect(0,0,W,32,'F');doc.setFillColor(...AM);doc.rect(0,32,W,1.6,'F');T('RetirementPlanKaro.com',40,21,11,[255,255,255],1);doc.link(40,8,160,18,{url:URL});T('Premium Retirement Report',W-40,21,9,AM,0,{align:'right'})}doc.setDrawColor(221,227,239);doc.line(40,812,W-40,812);T('RetirementPlanKaro.com  |  Confidential: prepared for '+(who()||'you')+'  |  Educational tool, not financial advice',40,823,8,[85,98,122]);doc.link(40,814,200,12,{url:URL});T('Questions? Email '+CFG.mail,40,834,8,[85,98,122]);doc.link(40,826,200,12,{url:'mailto:'+CFG.mail});T('Page '+i+' of '+N,W-40,823,8,[85,98,122],0,{align:'right'})}
doc.save('RetirementPlanKaro-Premium-Report.pdf');toast('Premium PDF report downloaded')}
document.addEventListener('click',e=>{const b=e.target.closest('[data-rg]');if(!b)return;if(b.dataset.rg==='all'){for(const k in G)delete G[k]}else delete G[b.dataset.rg];swp(true)});

/* ---- family ---- */
let FAM=[],FEDIT=null;
const REL=['Self','Spouse','Father','Mother','Son','Daughter','Brother','Sister','Grandparent','Other'],NUM=['inc','exp','liq','ill','debt','sip','lc','tp','tt','hc','hp','ef'];
const norm=m=>({...m,tm:m.tm||(m.lc>0?'Yes':'No'),hs:m.hs||(m.hc>0?'Individual':'None'),ht:m.ht||'No',ew:m.ew||'Savings account',...Object.fromEntries(NUM.map(k=>[k,m[k]||0]))});
let FAMCACHE=[];
const fkey=()=>'rpk_fam_'+(USER?USER.mobile:''),fload=()=>{FAM=USER?FAMCACHE.slice():[]},fsave=()=>{},nwm=m=>m.liq+m.ill-m.debt,nm=a=>a.map(m=>esc(m.name)).join(', ');
function updUsr(){const u=$('#usr');u.hidden=!USER;$("#authb").hidden=!!USER;u.innerHTML=USER?`<span>Hi, ${esc(USER.name)}</span><a class="ptschip" href="#report" data-v="report" title="Your Report Points — redeemable on the Premium Report">⭐ ${ptsBal()} Report pts</a><button class="link" type="button" data-flogout>Logout</button>`:''}
const sel=(id,l,o)=>`<div class="fd"><label for="${id}">${l}</label><select class="sel" id="${id}">${o.map(x=>`<option>${x}</option>`).join('')}</select></div>`,nf=(k,l)=>tf('fm-'+k,l,'type="number" inputmode="decimal" min="0" step="1000" placeholder="0"'),H4=t=>`<h4 style="margin:16px 0 6px;color:var(--br)">${t}</h4>`;
$('#ffm').innerHTML=tf('fm-n','Name *','maxlength="40"')+`<div class="fm2">${sel('fm-r','Relation *',REL)}${tf('fm-a','Age *','type="number" inputmode="numeric" min="0" max="110"')}${nf('inc','Monthly income')}${nf('exp','Monthly expenses')}${nf('liq','Liquid assets (savings, FD, stocks, funds)')}${nf('ill','Non-liquid assets (home, gold, property, EPF)')}${nf('debt','Loans and dues')}${nf('sip','Monthly investment')}</div>${H4('Life insurance cover')}<div class="fm2">${sel('fm-tm','Has life insurance?',['No','Yes'])}${nf('lc','Life cover amount')}${nf('tp','Yearly payment')}${nf('tt','Policy runs till age')}</div>${H4('Health insurance')}<div class="fm2">${sel('fm-hs','Type of cover',HS)}${nf('hc','Health cover amount')}${nf('hp','Yearly payment')}${sel('fm-ht','Extra top-up health policy?',['No','Yes'])}</div>${H4('Emergency money')}<div class="fm2">${nf('ef','Emergency money kept for this person')}${sel('fm-ew','Where is it kept?',EW)}</div><label class="ck" style="margin-top:12px"><input type="checkbox" id="fm-c"><span>I confirm I have the right to share these details about my family member. For a child under 18, I am the parent or legal guardian. *</span></label><small id="fm-c-e" style="color:var(--bd)"></small><button class="btn pri" type="submit" style="margin-top:10px">Save member</button>`;
function openFm(id){FEDIT=id;const m=id?norm(FAM.find(x=>x.id===id)):{tm:'No',hs:'None',ht:'No',ew:'Savings account',rel:'Spouse'};$('#fmt').textContent=id?'Edit family member':'Add family member';$('#fm-n').value=m.name||'';$('#fm-r').value=m.rel||'Spouse';$('#fm-a').value=m.age||'';NUM.forEach(k=>$('#fm-'+k).value=m[k]||'');['tm','hs','ht','ew'].forEach(k=>$('#fm-'+k).value=m[k]);$('#fm-c').checked=!!id;['fm-n-e','fm-a-e','fm-c-e'].forEach(i=>$('#'+i).textContent='');$('#fm').hidden=false;$('#fm-n').focus()}
$('#fmx').onclick=()=>$('#fm').hidden=true;$('#fm').addEventListener('click',e=>{if(e.target.id==='fm')$('#fm').hidden=true});
$('#ffm').onsubmit=e=>{e.preventDefault();const n=$('#fm-n').value.trim(),a=parseFloat($('#fm-a').value);$('#fm-n-e').textContent=n?'':'Enter a name';$('#fm-a-e').textContent=a>=0&&a<=110?'':'Enter a valid age';$('#fm-c-e').textContent=$('#fm-c').checked?'':'Please confirm to continue';if(!n||!(a>=0&&a<=110)||!$('#fm-c').checked)return;
const m={id:FEDIT||Date.now(),name:n,rel:$('#fm-r').value,age:a};NUM.forEach(k=>m[k]=Math.max(0,parseFloat($('#fm-'+k).value)||0));['tm','hs','ht','ew'].forEach(k=>m[k]=$('#fm-'+k).value);if(m.tm==='No')m.lc=m.tp=m.tt=0;if(m.hs==='None'){m.hc=m.hp=0;m.ht='No'}const i=FAM.findIndex(x=>x.id===m.id);if(i>=0)FAM[i]=m;else FAM.push(m);fsave();$('#fm').hidden=true;renderFam();toast('Family member saved')};
function addSelf(){const p=P(),AL=assetList(),o=FAM.find(x=>x.rel==='Self'),m=norm({id:o?o.id:Date.now(),name:USER.name,rel:'Self',age:p.age||0,inc:v('inc'),exp:expList().reduce((a,x)=>a+x.v,0),liq:AL.filter(x=>x.t==='L').reduce((a,x)=>a+x.v,0),ill:AL.filter(x=>x.t==='I').reduce((a,x)=>a+x.v,0),debt:LI.reduce((a,[k])=>a+v(k),0),sip:p.sip||0}),pr=prot(),has=pr.tm==='Yes'||pr.hs!=='None'||pr.ef>0;if(has){Object.assign(m,pr);if(m.tm==='No')m.lc=m.tp=m.tt=0;if(m.hs==='None'){m.hc=m.hp=0;m.ht='No'}}else if(o)['tm','lc','tp','tt','hs','hc','hp','ht','ef','ew'].forEach(k=>m[k]=o[k]);if(o)FAM[FAM.indexOf(o)]=m;else FAM.unshift(m);fsave();renderFam();toast('Your numbers were added. Tap Edit to add your insurance and emergency money.')}
function famDash(F){const sum=k=>F.reduce((a,m)=>a+m[k],0),inc=sum('inc'),ex=sum('exp'),liq=sum('liq'),ill=sum('ill'),debt=sum('debt'),nw=liq+ill-debt,sv=inc-ex,rate=inc?sv/inc*100:0,ta=liq+ill,earn=F.filter(m=>m.inc>0),kids=F.filter(m=>m.age<18),sen=F.filter(m=>m.age>=60),ef=sum('ef'),tgt=ex*(earn.length===1&&F.length>1?9:6),mo=ex?ef/ex:0,g=[];
const ew=earn.filter(m=>m.age<60),tNeed=ew.reduce((a,m)=>a+m.inc*120,0),tCov=ew.reduce((a,m)=>a+m.lc,0),tmY=F.filter(m=>m.tm==='Yes'&&m.lc>0),hY=F.filter(m=>m.hs!=='None'&&m.hc>0);
const nT=ew.filter(m=>!(m.tm==='Yes'&&m.lc>0)),lowT=ew.filter(m=>m.tm==='Yes'&&m.lc>0&&m.lc<m.inc*120),shortT=tmY.filter(m=>m.tt>0&&m.tt<60),nH=F.filter(m=>!(m.hs!=='None'&&m.hc>0)),emp=F.filter(m=>m.hs==='Employer (group) only'),lowH=hY.filter(m=>m.hc<500000),noTop=hY.filter(m=>m.ht==='No');
if(nT.length)g.push(gd('b',`No life insurance for earning members: ${nm(nT)}. Life cover protects the family's income if the earner is gone.`));if(lowT.length)g.push(gd('w',`Life cover is below 10 times yearly income for: ${nm(lowT)}.`));if(shortT.length)g.push(gd('w',`Term policy ends before age 60 for: ${nm(shortT)}. Consider cover that runs longer.`));if(!nT.length&&!lowT.length&&!shortT.length&&ew.length)g.push(gd('g','Every earning member has life cover of at least 10 times yearly income.'));
if(nH.length)g.push(gd(nH.some(m=>m.age>=60)?'b':'w',`No health insurance for: ${nm(nH)}. One hospital stay can use up family savings.`));if(emp.length)g.push(gd('w',`${nm(emp)} depend only on employer health cover, which usually ends when the job ends. Buy a personal policy.`));if(lowH.length)g.push(gd('w',`Health cover is under ₹5 lakh for: ${nm(lowH)}. Medical costs keep rising.`));if(noTop.length)g.push(gd('w',`A super top-up policy is a low-cost way to raise cover. None noted for: ${nm(noTop)}.`));if(!nH.length&&!lowH.length&&!emp.length)g.push(gd('g','Every member has personal health insurance of ₹5 lakh or more.'));
if(ex){g.push(ef<=0?gd('b',`No emergency money noted. Build ${inr(tgt)} (${tgt/ex} months of family spending) in a savings account or liquid fund.`):mo<3?gd('b',`Emergency money covers only ${mo.toFixed(1)} months. Aim for ${tgt/ex} months (${inr(tgt)}).`):mo<tgt/ex?gd('w',`Emergency money covers ${mo.toFixed(1)} months. Aim for ${tgt/ex} months, about ${inr(tgt-ef)} more.`):gd('g',`Emergency money covers ${mo.toFixed(1)} months, meeting the ${tgt/ex}-month goal.`));if(F.some(m=>m.ef>0&&m.ew==='Not kept separately'))g.push(gd('w','Keep your emergency money separate in a savings account, liquid fund or FD so you do not spend it by mistake.'))}
if(inc)g.push(sv<0?gd('b',`The family spends ${inr(-sv)} a month more than it earns. Review spending first.`):rate<20?gd('w',`The family saves ${Math.round(rate)}% of its income. Aim for 20%.`):gd('g',`The family saves ${Math.round(rate)}% of its income, meeting the 20% target.`));
if(ta&&debt/ta>.4)g.push(gd('w',`Family loans are ${Math.round(debt/ta*100)}% of what the family owns. Prepay costly loans first.`));
if(earn.length===1&&F.length>1)g.push(gd('w',`Only ${esc(earn[0].name)} earns, so the whole family depends on one income. Keep a bigger emergency money and strong cover.`));
if(kids.length)g.push(gd('g',`You have ${kids.length} child${kids.length>1?'ren':''}. Add education and marriage goals in Plan, Step 4.`));
if(sen.length)g.push(gd('w',`${nm(sen)} ${sen.length>1?'are':'is'} 60 or above. Keep medical money ready and check nominee names and wills.`));
const near=earn.filter(m=>m.age>=50&&m.age<60);if(near.length)g.push(gd('w',`${nm(near)} will retire within about 10 years. Use the Plan page to check readiness.`));
if(F.length>1&&nw>0){const t=F.slice().sort((a,b)=>nwm(b)-nwm(a))[0];if(nwm(t)/nw>.7)g.push(gd('w',`${Math.round(nwm(t)/nw*100)}% of family wealth is in ${esc(t.name)}'s name. Make sure nominee names and a will are in place.`))}
GUIDE.fam=g;const nwI=F.map((m,i)=>({n:m.name,v:Math.max(0,nwm(m)),c:COL[i%COL.length]})).filter(x=>x.v>0),icI=F.map((m,i)=>({n:m.name,v:m.inc,c:COL[i%COL.length]})).filter(x=>x.v>0),mx=Math.max(1,...F.map(m=>Math.max(m.inc,m.exp)));
const ttl=t=>`<h4 style="margin:0 0 4px;text-align:center">${t}</h4>`;
return`<div class="dbd"><div class="sg" style="margin:0">${S('Members',F.length)}${S('Family net worth',inr(nw),nw<0?'b':'g')}${S('Monthly income',inr(inc))}${S('Monthly spending',inr(ex))}${S('Monthly saving',inr(sv),sv<0?'b':'g')}${S('Life cover',inr(sum('lc')))}${S('Health cover',inr(sum('hc')))}${S('Emergency money',inr(ef))}</div>
<div class="panel"><h3>Family dashboard</h3><div class="fgrid">${nwI.length?`<div>${ttl('Net worth by member')}${donut(nwI,'Net worth')}</div>`:''}${icI.length?`<div>${ttl('Income by member')}${donut(icI,'Per month')}</div>`:''}${ta?`<div>${ttl('Where family money sits')}${donut([{n:'Liquid',v:liq,c:COL[2]},{n:'Non-liquid',v:ill,c:COL[3]}].filter(x=>x.v>0),'Assets')}</div>`:''}</div><h4 style="margin:16px 0 6px">Income and spending by member</h4>${F.map(m=>gbar(esc(m.name)+' · income',m.inc/mx*100,inr(m.inc),'var(--br)')+gbar(esc(m.name)+' · spending',m.exp/mx*100,inr(m.exp),'var(--ac)')).join('')}</div>
<div class="panel"><h3>Life insurance</h3><p style="color:var(--mu);font-size:13.5px;margin:0 0 8px">${tmY.length} of ${F.length} members have life cover. Total ${inr(sum('lc'))}, yearly payment ${inr(sum('tp'))}.${tNeed?` Earning members under 60 need about ${inr(tNeed)} (10 times yearly income); gap ${inr(Math.max(0,tNeed-tCov))}.`:''}</p>${ew.length?ew.map(m=>{const nd=m.inc*120;return gbar(esc(m.name)+' · cover vs need',nd?m.lc/nd*100:0,inr(m.lc)+' of '+inr(nd)+(m.tt?' · till age '+m.tt:''),m.lc>=nd?'var(--gd)':m.lc>0?'var(--ac)':'var(--bd)')}).join(''):'<p style="color:var(--mu)">Add an earning member to see the life cover check.</p>'}</div>
<div class="panel"><h3>Health insurance</h3><p style="color:var(--mu);font-size:13.5px;margin:0 0 8px">${hY.length} of ${F.length} members are covered. Total ${inr(sum('hc'))}, yearly payment ${inr(sum('hp'))}. Common guide: at least ₹5 lakh per person.</p>${F.map(m=>gbar(esc(m.name)+' · '+m.hs.toLowerCase()+(m.ht==='Yes'?' + top-up':''),Math.min(100,m.hc/5e5*100),m.hc?inr(m.hc):'No cover',m.hc>=5e5?'var(--gd)':m.hc>0?'var(--ac)':'var(--bd)')).join('')}</div>
<div class="panel"><h3>Emergency money</h3><p style="color:var(--mu);font-size:13.5px;margin:0 0 8px">Goal: ${ex?tgt/ex:6} months of family spending${ex?' = '+inr(tgt):''}. You have ${inr(ef)}${ex?' ('+mo.toFixed(1)+' months)':''}.</p>${gbar('Family emergency money',tgt?ef/tgt*100:0,inr(ef)+(tgt?' of '+inr(tgt):''),ef>=tgt&&tgt?'var(--gd)':'var(--ac)')}${F.filter(m=>m.ef>0).map(m=>gbar(esc(m.name)+' · '+m.ew.toLowerCase(),tgt?m.ef/tgt*100:0,inr(m.ef),'var(--br)')).join('')}</div>
<div class="panel"><h3>All members at a glance</h3><div class="ftw"><table class="ft"><thead><tr><th>Name</th><th>Relation</th><th>Age</th><th>Income</th><th>Spending</th><th>Net worth</th><th>Life cover</th><th>Health cover</th><th>Emergency money</th></tr></thead><tbody>${F.map(m=>`<tr><td>${esc(m.name)}</td><td>${m.rel}</td><td>${m.age}</td><td>${inr(m.inc)}</td><td>${inr(m.exp)}</td><td>${inr(nwm(m))}</td><td>${m.lc?inr(m.lc):'None'}</td><td>${m.hc?inr(m.hc)+' ('+m.hs.toLowerCase()+')':'None'}</td><td>${m.ef?inr(m.ef):'None'}</td></tr>`).join('')}</tbody></table></div></div>${aiBox(g)}</div>`}
const FN='<div class="nr noprint" style="margin-top:18px"><button class="btn" type="button" data-jr="checklist">← Back: Checklist</button><button class="btn pri" type="button" data-jr="report">Next: Download report →</button></div>';
function renderFam(){jrDraw('family');const el=$('#v-family');if(!el)return;const hd='<div class="sh"><h2>Your Family</h2><p>Add each family member once and see one dashboard for your family\'s money, insurance and risks.</p></div>';
if(!USER){el.innerHTML=hd+'<div class="panel" style="margin-top:14px"><h3>Login to manage your family</h3><p style="color:var(--mu)">Family details are private to your account. Login or sign up to add them.</p><button class="btn pri" type="button" data-famlogin>Login or Sign up</button></div>'+FN;return}
fload();el.innerHTML=hd+`<div class="row" style="margin:14px 0"><button class="btn pri" type="button" data-fadd>+ Add family member</button><button class="btn" type="button" data-fself>Add me from my plan</button></div>`+(FAM.length?`<div class="fgrid">${FAM.map(m=>`<div class="fcard"><h4>${esc(m.name)}</h4><p>${m.rel} · Age ${m.age}</p><p style="margin:0 0 10px;color:var(--ink)">Income ${inr(m.inc)} · Spending ${inr(m.exp)}<br>Net worth ${inr(nwm(m))}<br>Term ${m.lc?inr(m.lc):'None'} · Health ${m.hc?inr(m.hc):'None'} · Emergency money ${m.ef?inr(m.ef):'None'}</p><div class="row"><button class="btn small" type="button" data-fedit="${m.id}">Edit</button><button class="btn small" type="button" data-fdel="${m.id}">Remove</button></div></div>`).join('')}</div>${famDash(FAM)}`:'<div class="msg">No family members yet. Tap "+ Add family member" to begin.</div>')+FN}
document.addEventListener('click',e=>{const t=e.target;if(t.closest('[data-famlogin]')){PEND='fam';openAuth()}else if(t.closest('[data-fadd]'))openFm(null);else if(t.closest('[data-fself]'))addSelf();else if(t.closest('[data-fedit]'))openFm(+t.closest('[data-fedit]').dataset.fedit);else if(t.closest('[data-fdel]')){const id=+t.closest('[data-fdel]').dataset.fdel;if(confirm('Remove this family member?')){FAM=FAM.filter(x=>x.id!==id);fsave();renderFam()}}else if(t.closest('[data-flogout]')){USER=null;LS.s('rpk_user',null);updUsr();renderFam();renderRep();toast('Logged out')}});
/* ---- guided journey: Plan > Checklist > Family > Report ---- */
const JR={ck:false},JK=['plan','checklist','family','report'],JL={plan:'Plan',checklist:'Checklist',family:'Family',report:'Report'},JH={plan:'Fill your numbers',checklist:'Tick what you did',family:'Add your family',report:'Download everything'};
function jrState(){fload();const pl=ok(P()),c=JR.ck,f=!!USER&&FAM.length>0;return{plan:pl,checklist:c,family:f,all:pl&&c&&f}}
function jrDraw(cur){const el=$('#jr');if(!el)return;if(cur==='learn'||cur==='explore'){el.hidden=true;return}const s=jrState();el.hidden=false;el.innerHTML='<div class="w"><ol class="jr" aria-label="Your journey">'+JK.map((k,i)=>{const dn=k==='report'?s.all:s[k];return`<li><a href="#${k}" class="${k===cur?'cur':''} ${dn?'ok':''}"${k===cur?' aria-current="step"':''}><i>${dn?'✓':i+1}</i><span><b>${JL[k]}</b><small>${JH[k]}</small></span></a></li>`}).join('')+'</ol></div>'}
function jrGo(k){if(location.hash==='#'+k||(!location.hash&&k==='plan'))route();else location.hash='#'+k;scrollTo(0,0)}
document.addEventListener('click',e=>{const b=e.target.closest('[data-jr]');if(!b)return;e.preventDefault();const k=b.dataset.jr,s=jrState();
if(k==='checklist'&&!s.plan){toast('Add your age in Step 1 and retirement details in Step 3 first.');return}
if(k==='report'&&!s.plan){toast(USER?'Add at least one family member. Tap "Add me from my plan" for a quick start.':'Login to add your family, then come back to download your report.');return}
jrGo(k)});
$('#v-plan').addEventListener('input',()=>jrDraw('plan'));
function renderRep(){const el=$('#v-report');if(!el)return;const s=jrState(),dis=s.plan?'':' disabled',bks=(USER&&LS.g(GK()))||[],lb=bks[bks.length-1];
const fd=x=>{try{return new Date(x+'T00:00').toLocaleDateString('en-IN',{day:'numeric',month:'short',year:'numeric'})}catch(e){return x}};
const gsBody=lb?`<div class="msg bk"><b>Session booked</b><br>${esc(fd(lb.date))} · ${esc(lb.slot)}<br>${esc(lb.mode)}<small>You will get a confirmation on ${esc(lb.mobile)}.</small></div><button class="btn" type="button" data-gs${dis}>Book another session</button>`:`<button class="btn acc" type="button" data-gs${dis}>Book guidance session</button>`;
el.innerHTML=`<div class="sh"><h2>Your reports</h2><p>Download your plan as a PDF or Excel file, or talk through it with a guide.</p></div><div class="rgrid"><div class="panel rc pr el"><span class="tag">✦ PREMIUM</span><h3>Premium Personalized Report</h3><p class="elsub">Your complete retirement plan, built around your own numbers. Download it as a PDF or an Excel file.</p>${priceTag(0)}<ul class="elf"><li>Net worth and expenses</li><li>Retirement plan and life goals</li><li>Year-by-year table</li><li>Personalized action plan</li><li>Age-wise checklist</li><li>Family Dashboard</li><li>Learning pages</li><li>Risk notes</li></ul><div class="row"><button class="btn go" type="button" data-dl="pdf"${dis}>⬇ Premium PDF</button><button class="btn" type="button" data-dl="xls"${dis}>⬇ Premium Excel</button></div></div><div class="panel rc gs"><span class="tag">1-ON-1 · ₹${CFG.gprice}</span><h3>Guidance Session</h3><p>Talk through your personal report with a guide. Bring your questions on retirement age, savings, monthly income and life goals.</p><div class="row">${gsBody}</div></div></div>${refPanel()}${s.plan?'':'<p class="rnote">Complete your plan (Steps 1 to 3) to enable downloads and booking.</p>'}<p class="rnote mail">Questions about your report? Email <a href="mailto:Retirementplankaro@gmail.com">Retirementplankaro@gmail.com</a></p><div class="nr noprint"><button class="btn" type="button" data-jr="family">← Back: Family</button></div>`}

/* ---- Guidance session booking ---- */
const GK=()=>'rpk_gs_'+(USER?USER.mobile:''),GS_SLOTS=['Morning (9 am to 12 pm)','Afternoon (12 pm to 4 pm)','Evening (4 pm to 8 pm)'],GS_MODES=['Phone call','Video call'];
const closeGs=()=>{$('#gs').hidden=true};
function leadX(u,ev,x){if(!u||!CFG.hook)return;try{fetch(CFG.hook,{method:'POST',mode:'no-cors',headers:{'Content-Type':'text/plain'},body:JSON.stringify(Object.assign({ev,ts:new Date().toISOString(),name:u.name,surname:u.surname,mobile:u.mobile,email:u.email,ref:u.refBy||'',code:u.code||'',city:u.city},x||{}))})}catch(e){}}
function openGs(){if(!USER){PEND='gs';openAuth();return}if(!jrState().plan){toast('Complete your plan (Steps 1 to 3) first.');return}
const iso=x=>new Date(x.getTime()-x.getTimezoneOffset()*6e4).toISOString().slice(0,10),n=Date.now(),mn=iso(new Date(n+864e5)),mx=iso(new Date(n+60*864e5));
$('#gsb').innerHTML=`<h3 id="gst">Book a Guidance Session</h3><p class="gsp"><b>₹${CFG.gprice}</b> <small>one-time, per session</small></p><ul class="tips"><li>One-to-one session on your own personal report</li><li>Ask about retirement age, savings, monthly income and life goals</li><li>You choose the date, time and how we talk</li></ul>
<div class="fd"><label for="gs-d">Preferred date *</label><div class="in"><input id="gs-d" type="date" min="${mn}" max="${mx}" value="${mn}"></div></div>
<div class="fd"><label for="gs-s">Preferred time *</label><select class="sel" id="gs-s">${GS_SLOTS.map(x=>`<option>${x}</option>`).join('')}</select></div>
<div class="fd"><label for="gs-m">How should we talk? *</label><select class="sel" id="gs-m">${GS_MODES.map(x=>`<option>${x}</option>`).join('')}</select></div>
<div class="fd"><label for="gs-p">Mobile number *</label><div class="in"><input id="gs-p" type="tel" inputmode="numeric" autocomplete="tel" maxlength="14" value="${esc(USER.mobile||'')}"></div></div>
<div class="fd"><label for="gs-n">What would you like to discuss? (optional)</label><textarea class="sel" id="gs-n" rows="3" maxlength="300" placeholder="For example: Can I retire at 55?"></textarea></div>
<label class="ck"><input type="checkbox" id="gs-c"><span>I understand this session helps me understand my report. It is educational and is not a guarantee of growth. *</span></label>
<button class="btn pri" id="gs-go" type="button" style="margin-top:14px">Pay ₹${CFG.gprice} and book</button>
${CFG.rzp?'<p class="gsn">Payment is handled securely by PayU.</p>':'<p class="gsn" style="color:var(--bd)">Test mode: payment gateway is not connected yet.</p>'}`;$('#gs').hidden=false}
function doGs(){}/* replaced by the real booking flow in the payu-api script below */
document.addEventListener('click',e=>{const c=s=>e.target.closest(s);if(c('[data-gs]')&&!c('[data-gs]').disabled)openGs();else if(c('#gs-go'))doGs();else if(c('#gsx')||e.target.id==='gs')closeGs()});
addEventListener('keydown',e=>{if(e.key==='Escape')closeGs()});
updUsr();
const CFG={price:499,couponApi:'',gprice:1000,rzp:'',hook:'/api/lead',refPts:100,mrp:5000,dayPts:50,streakDays:7,mail:'Retirementplankaro@gmail.com',site:'https://www.retirementplankaro.com/'}; /* rzp: set to 'payu' once PayU is live (payu-api does this automatically). hook: URL that receives leads (POST JSON). mrp: crossed-out list price shown beside price. Coupon codes live in the coupons table now and are checked via /api/coupon/check — never kept here. */
const rupee=n=>'₹'+Number(n).toLocaleString('en-IN'),priceTag=big=>`<div class="pz${big?' pzb':''}"><s>${rupee(CFG.mrp)}</s><b>${rupee(CFG.price)}</b><em>${Math.round((1-CFG.price/CFG.mrp)*100)}% OFF</em></div><small class="pzn">One-time payment · Launch price</small>`;
const strip=h=>String(h).replace(/<[^>]+>/g,'');
function SC(){const p=P(),AL=assetList(),XL=expList(),inc=v('inc'),tot=XL.reduce((a,x)=>a+x.v,0),ess=XL.filter(x=>x.e).reduce((a,x)=>a+x.v,0),ta=AL.reduce((a,x)=>a+x.v,0),debt=LI.reduce((a,[k])=>a+v(k),0),q=prot(),pts=[],add=(n,x)=>pts.push({n,pts:x});
const rate=inc?(inc-tot)/inc:null;add('Saving habit',rate==null?null:Math.max(0,Math.min(20,rate/.2*20)));
const ef=Math.max(q.ef,v('bank')+v('fd'));add('Emergency money',tot?Math.min(20,ef/(ess||tot)*20/6):null);
const tOk=p.age>=60||!inc?10:q.tm==='Yes'&&q.lc>=inc*120?10:q.tm==='Yes'&&q.lc>0?5:0,hOk=q.hs!=='None'&&q.hc>0?(q.hc>=5e5&&q.hs!=='Employer (group) only'?10:5):0;add('Insurance cover',(tot||inc)?tOk+hOk:null);
add('Loan burden',ta+debt?(debt/ta<=.1?20:Math.max(0,20*(1-(debt/ta-.1)/.5))):null);
let rd=null,n=0,f=0,s=0;if(ok(p)){n=need(p,{});f=proj(p,{});s=solve(p,{});rd=n>0?Math.min(100,f/n*100):100}add('Retirement readiness',rd==null?null:rd/100*20);
const a=pts.filter(x=>x.pts!=null),t=a.length>1?Math.round(a.reduce((z,x)=>z+x.pts,0)/(a.length*20)*100):null;
return{p,pts,t,l:t==null?'':t>=75?'Strong':t>=50?'Fair':'Needs attention',rd,n,f,s,nw:ta-debt,rate,cnt:a.length}}
function ACI(){calc();const seen=new Set;return['b','w'].flatMap(k=>[GUIDE.nw,GUIDE.exp,GUIDE.prot,GUIDE.plan,GUIDE.swp,GUIDE.fam].flatMap(a=>a.filter(i=>i.t===k))).filter(i=>!seen.has(i.x)&&seen.add(i.x))}
function mkFree(){if(!window.jspdf){toast('PDF library could not load. Check your connection.');return}const s=SC();if(s.t==null){toast('Fill your plan first (Steps 1 to 3).');return}const doc=new jspdf.jsPDF({unit:'pt',format:'a4'}),NV=[27,58,107],T=(t,x,y,z,c,b)=>{doc.setFont('helvetica',b?'bold':'normal');doc.setFontSize(z);doc.setTextColor(...c);doc.text(String(t),x,y)};let y=130;
doc.setFillColor(...NV);doc.rect(0,0,595,90,'F');T('RetirementPlanKaro.com',40,42,22,[255,255,255],1);T('Basic Financial Summary | '+(who()||'You')+' | '+new Date().toLocaleDateString('en-IN'),40,68,10,[210,222,245]);
T('Financial Health Score: '+s.t+'/100 ('+s.l+')',40,y,15,NV,1);y+=26;s.pts.forEach(x=>{T(x.n+': '+(x.pts==null?'add details':Math.round(x.pts)+' / 20'),50,y,10,[20,33,61]);y+=16});y+=10;
[['Net worth today',pm(s.nw)],s.rd==null?null:['Money needed at retirement',pm(s.n)],s.rd==null?null:['Money you are on track for',pm(s.f)],s.rd==null?null:['Retirement readiness',Math.round(s.rd)+'%']].filter(Boolean).forEach(k=>{T(k[0]+': '+k[1],50,y,10.5,[20,33,61],1);y+=18});y+=10;
T('Your top priorities',40,y,13,NV,1);y+=20;ACI().slice(0,3).forEach((a,i)=>{const L=doc.splitTextToSize(tx((i+1)+'. '+a.x).replace(/&#x27;/g,"'").replace(/&amp;/g,'&'),480);doc.setFont('helvetica','normal');doc.setFontSize(9.5);doc.setTextColor(20,33,61);doc.text(L,50,y);y+=L.length*12+6});y+=14;
doc.setFillColor(232,237,248);doc.roundedRect(40,y,515,86,10,10,'F');T('Want the full picture?',56,y+26,13,NV,1);T('The Premium Personalized Report adds your year-by-year table, life goals, Family Dashboard,',56,y+46,9.5,[20,33,61]);T('full action plan and a year of updates. Get it at RetirementPlanKaro.com',56,y+60,9.5,[20,33,61]);
T('Educational tool, not financial advice. Estimates depend on your inputs and assumptions.',40,812,8,[85,98,122]);T('Questions? Email '+CFG.mail,40,826,8,[85,98,122]);doc.link(40,816,200,14,{url:'mailto:'+CFG.mail});{const n=doc.getNumberOfPages();for(let i=1;i<=n;i++){doc.setPage(i);rpkWM(doc)}}doc.save('RetirementPlanKaro-Basic-Summary.pdf');toast('Basic summary downloaded')}
/* 2. Revenue: lead capture + premium paywall */
function lead(u,ev){if(!u||!CFG.hook)return;try{const s=SC();fetch(CFG.hook,{method:'POST',mode:'no-cors',headers:{'Content-Type':'text/plain'},body:JSON.stringify({ev,ts:new Date().toISOString(),name:u.name,surname:u.surname,mobile:u.mobile,email:u.email,ref:u.refBy||'',code:u.code||'',city:u.city,shareConsent:!!(u.consent&&u.consent.share),reminder:!!u.rem,score:s.t,readiness:s.rd==null?null:Math.round(s.rd),shortfall:s.rd==null?null:Math.round(Math.max(0,s.n-s.f))})})}catch(e){}}
const PK=()=>'rpk_paid_'+(USER?USER.mobile:''),isPaid=()=>!!(USER&&window.RPK_PAID&&window.RPK_PAID.paid);let PD2=null;
const closePay=()=>{$('#pay').hidden=true;PD2=null};
let CPN=0;function openPay(t){PD2=t;CPN=0;$('#payb').innerHTML=`<h3 id="payt">Get your Premium Personalized Report</h3>${priceTag(1)}<ul class="tips"><li>Full year-by-year table, life goals and Family Dashboard</li><li>Your personalized action plan: what to fix first</li><li>Age-wise checklist, protection check and learning pages</li><li>PDF and Excel downloads</li></ul>${ptsBal()>=CFG.refPts?`<label class="ck"><input type="checkbox" id="pay-pts"><span>Redeem ${ptsBal()} Report Points (₹${Math.min(ptsBal(),CFG.price)} off)</span></label>`:''}<div class="row" style="margin-top:12px;gap:8px;flex-wrap:nowrap"><input id="pay-cp" placeholder="Have a coupon code?" maxlength="20" autocapitalize="characters" autocomplete="off" aria-label="Coupon code" style="flex:1;min-width:0;padding:10px;border:1px solid var(--ln);border-radius:10px;background:var(--sf);color:var(--ink);font:inherit;text-transform:uppercase"><button class="btn" id="pay-cpa" type="button">Apply</button></div><small id="pay-cpm" role="status" style="display:block;min-height:18px;margin-top:4px"></small><div class="row" style="margin-top:12px"><button class="btn pri" id="pay-go" type="button">Pay ₹${CFG.price} and download</button></div>${CFG.rzp?'<p style="font-size:12px;color:var(--mu)">Payment is handled securely by PayU.</p>':'<p style="font-size:12px;color:var(--bd)">Test mode: payment gateway is not connected yet.</p>'}<p style="font-size:12px;color:var(--mu)">Educational report, not financial advice.</p>`;$('#pay').hidden=false}

function mkCode(u){return 'RPK'+((u.mobile||'').slice(-4)+Math.random().toString(36).slice(2,5)).toUpperCase()}
function PTK(u){return 'rpk_pts_'+(u?u.mobile:'')}
function ptsGet(u){return Object.assign({e:0,u:0,n:0},LS.g(PTK(u))||{})}
function ptsBal(){if(!USER)return 0;const l=ptsGet(USER);return Math.max(0,l.e-l.u)}
function creditRef(code){const r=(LS.g('rpk_users')||[]).find(x=>x.code===code);if(!r)return;const l=ptsGet(r);l.e+=CFG.refPts;l.n++;LS.s(PTK(r),l)}
function refPanel(){if(!USER)return `<div class="panel rc rf"><span class="tag">REFER &amp; EARN</span><h3>Invite friends, earn ${CFG.refPts} points each</h3><p>Log in to get your personal referral link. Every friend who signs up earns you ${CFG.refPts} points, which you can redeem on your Premium Reports.</p><div class="row"><button class="btn go" type="button" data-rflogin>Login / Sign up</button></div></div>`;
const l=ptsGet(USER),bal=Math.max(0,l.e-l.u),link=CFG.site+'?ref='+USER.code;
return `<div class="panel rc rf"><span class="tag">REFER &amp; EARN</span><h3>Earn ${CFG.refPts} points for every friend who signs up</h3><p>Share your link. When a friend creates an account, you earn ${CFG.refPts} points. Redeem points on your Premium Reports (${CFG.refPts} points = ₹${CFG.refPts} off).</p><div class="refstat"><div><small>Your points</small><b>${bal}</b></div><div><small>Friends joined</small><b>${l.n}</b></div><div><small>Your code</small><b>${esc(USER.code)}</b></div></div><input class="reflink" readonly value="${esc(link)}" aria-label="Your referral link"><div class="row"><button class="btn go" type="button" data-refwa>Share on WhatsApp</button><button class="btn" type="button" data-refcopy>Copy link</button></div></div>`}
document.addEventListener('click',e=>{const c=q=>e.target.closest(q);if(c('[data-rflogin]')){PEND=null;openAuth()}else if(c('[data-refcopy]')&&USER){const l=CFG.site+'?ref='+USER.code;(navigator.clipboard?navigator.clipboard.writeText(l):Promise.reject()).then(()=>toast('Link copied. ⭐ You have '+ptsBal()+' points. Earn '+CFG.refPts+' more per sign-up.'),()=>prompt('Copy your link',l))}else if(c('[data-refwa]')&&USER){window.open('https://wa.me/?text='+encodeURIComponent('I planned my retirement with Retirement Plan Karo. Try it here: '+CFG.site+'?ref='+USER.code),'_blank','noopener');toast('⭐ You have '+ptsBal()+' points. Earn '+CFG.refPts+' more for every friend who signs up.')}});
document.addEventListener('change',e=>{if(e.target.id==='pay-pts')payRefresh()});
/* Daily streak: log in and do any activity, earn dayPts points a day, for streakDays days in a row. Miss a day and it restarts. */
const SKK=u=>'rpk_streak_'+(u?u.mobile:''),dkey=(d=new Date())=>d.getFullYear()+'-'+String(d.getMonth()+1).padStart(2,'0')+'-'+String(d.getDate()).padStart(2,'0'),ykey=()=>{const y=new Date();y.setDate(y.getDate()-1);return dkey(y)};
function stGet(u){return Object.assign({last:'',day:0},LS.g(SKK(u))||{})}
function stView(u){const s=stGet(u),today=s.last===dkey();let day=s.day;if(!today&&(s.last!==ykey()||day>=CFG.streakDays))day=0;return{day,today}}
function dailyCheck(){if(!USER)return;const s=stGet(USER);if(s.last===dkey())return;const day=(s.last===ykey()&&s.day<CFG.streakDays)?s.day+1:1,N=CFG.streakDays,P=CFG.dayPts;s.last=dkey();s.day=day;LS.s(SKK(USER),s);const l=ptsGet(USER);l.e+=P;LS.s(PTK(USER),l);updUsr();toast(day>=N?'⭐ +'+P+' points! '+N+'-day streak complete ('+P*N+' points in total). Come back tomorrow to start a new streak.':'⭐ +'+P+' points! Day '+day+' of '+N+'. Come back tomorrow to keep your streak.')}
function streakBar(){if(!USER)return'';const v=stView(USER),N=CFG.streakDays,P=CFG.dayPts;let d='';for(let i=1;i<=N;i++)d+='<i class="sd'+(i<=v.day?' on':'')+'">'+i+'</i>';return `<div class="stk"><div class="sdots">${d}</div><small class="psn">${v.today?'✓ Today\'s '+P+' points earned. See you tomorrow.':'Do any activity today to earn '+P+' points.'} 7 days in a row = ${P*N} points. Miss a day and it restarts.</small></div>`}
['input','change','click'].forEach(k=>document.addEventListener(k,e=>{if(!USER||!e.isTrusted)return;const t=e.target;if(!t||!t.closest||t.closest('#auth,#shield,[data-flogout],[data-auth]'))return;if(k==='click'&&!t.closest('button,a,summary,[data-v],[data-jr]'))return;dailyCheck()},true));
function ptsStrip(){if(!USER)return'';const l=ptsGet(USER);return `<div class="ps"><div><small>Report Points</small><b>⭐ ${ptsBal()}</b></div><div><small>Friends joined</small><b>${l.n}</b></div><div><small>Your code</small><b>${esc(USER.code||'')}</b></div></div>${streakBar()}<div class="row"><button class="btn small" type="button" data-refwa>Share on WhatsApp</button><button class="btn small" type="button" data-refcopy>Copy link</button></div><small class="psn">Earn ${CFG.refPts} Report Points for every friend who signs up. Redeem them on Premium Reports — different from your Wallet points, which unlock Explore calculators.</small>`}
{const _o=updUsr;updUsr=function(){_o();const hp=$('#ha-pts');if(hp)hp.innerHTML=USER?ptsStrip():''}}
document.addEventListener('visibilitychange',()=>{if(!document.hidden&&USER)updUsr()});
try{updUsr()}catch(e){}
function dlGate(t){if(isPaid()){dl(t)}else openPay(t)}
function payRefresh(){const c=CPN||0,pc=$('#pay-pts'),u=pc&&pc.checked?Math.min(ptsBal(),CFG.price-c):0,a=CFG.price-c-u;$('#pay-go').textContent=a<=0?'Unlock and download':'Pay ₹'+a+' and download'}
const cpnKey=()=>'rpk_cu_'+((USER&&USER.mobile)||'guest');let CPC='';
function cpnMark(){try{const l=LS.g(cpnKey())||[];if(CPC&&!l.includes(CPC)){l.push(CPC);LS.s(cpnKey(),l)}}catch(e){}}
async function applyCoupon(){}/* replaced by the server check in the payu-api script below */
document.addEventListener('click',e=>{if(e.target.closest&&e.target.closest('#pay-cpa'))applyCoupon()});
document.addEventListener('keydown',e=>{if(e.key==='Enter'&&e.target.id==='pay-cp'){e.preventDefault();applyCoupon()}});
function doPay(){}/* replaced by the real payment flow in the payu-api script below */

document.addEventListener('click',e=>{const c=s=>e.target.closest(s);if(c('[data-free]')){if(!ok(P())){toast('Add your age and retirement details first.');return}if(USER)mkFree();else{PEND='free';openAuth()}}else if(c('#pay-go'))doPay();else if(c('#pay-free')){closePay();if(ok(P()))mkFree()}else if(c('#payx')||e.target.id==='pay')closePay()});
addEventListener('keydown',e=>{if(e.key==='Escape')closePay()});

function xlsFb(S,d){const e=h=>String(h==null?'':h).replace(/[&<>]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;'}[c]));let h='<html><head><meta charset="utf-8"></head><body><h2>RetirementPlanKaro.com - Retirement Report</h2><p>'+e(who())+' | '+d+' | Email: '+e(CFG.mail)+'</p>';S.forEach(x=>{h+='<h3>'+e(x.sh+': '+x.t)+'</h3><table border="1"><tr>'+x.h.map(c=>'<th>'+e(c)+'</th>').join('')+'</tr>'+x.r.map(r=>'<tr>'+r.map(c=>'<td>'+e(c)+'</td>').join('')+'</tr>').join('')+'</table>'});const a=document.createElement('a');a.href=URL.createObjectURL(new Blob([h+'</body></html>'],{type:'application/vnd.ms-excel'}));a.download='RetirementPlanKaro-Report.xls';document.body.appendChild(a);a.click();a.remove();toast('Excel report downloaded')}
const SUB={nw:['exp',()=>v('age')>0?assetList().some(x=>x.v>0)||'Add at least one thing you own or owe.':'Please enter your age first.'],exp:['plan',()=>v('inc')>0||expList().some(x=>x.v>0)?1:'Enter your income and expenses first.'],plan:['swp',()=>ok(P())||'Check age, retirement age and "last till" age.'],swp:[null,()=>ok(P())||'Complete Steps 1 to 3 first.']};
document.addEventListener('click',e=>{const b=e.target.closest('[data-submit],[data-reset3],[data-sgoals],#clrg2');if(!b)return;if(b.id==='clrg2'){$('#clrg').click();return}
if(b.dataset.reset3!==undefined){const d={ret:60,life:90,oth:'',infl:6,rpre:10,rpost:7,step:5};for(const k in d)$('#'+k).value=d[k];['exp','cur','sip'].forEach(k=>$('#'+k).dataset.auto='1');calc();toast('Plan reset to default values');return}
if(b.dataset.sgoals!==undefined){const p=P();if(!ok(p)){toast('Fill Steps 1 to 3 first.');return}GL.push({name:PRE[0],age:Math.min(p.life-1,p.age+18),amt:2500000},{name:PRE[1],age:Math.min(p.life-1,p.age+25),amt:2000000});syncG();renderGL();swp(true);toast('Sample goals added. Edit or clear them.');return}
const k=b.dataset.submit,[nx,chk]=SUB[k],r=chk();if(r!==true&&r!==1&&r){toast(r);return}if(r===false){toast('Please fill the required details.');return}toast('Saved. Moving ahead.');if(nx)openStep(nx);else jrGo('checklist')});

async function xlsPro(S,d){if(!window.ExcelJS)throw 0;fload();const wb=new ExcelJS.Workbook();wb.creator='RetirementPlanKaro.com';wb.title='Premium Retirement Report';wb.company='RetirementPlanKaro.com';wb.subject='Retirement plan for '+(who()||'you');wb.created=new Date();
const NV='FF0B2A4A',TL='FF0F766E',LT='FFFAF3DC',GD='FFC9A24B',ZB='FFF5FAFA',AM='FFFEF3C7',RD='FFFEE2E2',ln={style:'thin',color:{argb:'FFC9DADB'}},bd={top:ln,left:ln,bottom:ln,right:ln},NF='"'+CT[CC].s+' "#,##0;[Red]-"'+CT[CC].s+' "#,##0',p=P(),dec=h=>tx(h).replace(/&#x27;/g,"'").replace(/&amp;/g,'&'),fill=c=>({type:'pattern',pattern:'solid',fgColor:{argb:c}});
const mk=(n,tab)=>wb.addWorksheet(n.slice(0,31),{properties:{tabColor:{argb:tab||TL}},views:[{showGridLines:false,zoomScale:105}],pageSetup:{paperSize:9,orientation:'landscape',fitToPage:true,fitToWidth:1,fitToHeight:0,margins:{left:.4,right:.4,top:.5,bottom:.6,header:.3,footer:.3}},headerFooter:{oddFooter:'&L&8RetirementPlanKaro.com&C&8Confidential&R&8Page &P of &N'}});
const sm=mk('Summary',NV);
const banner=(ws,t,n)=>{ws.mergeCells(1,1,1,n);const c=ws.getCell(1,1);c.value=t;c.font={size:18,bold:true,color:{argb:'FFFFFFFF'}};c.fill=fill(NV);c.alignment={vertical:'middle',indent:1};ws.getRow(1).height=34;ws.mergeCells(2,1,2,n);const q=ws.getCell(2,1);q.value='Prepared for '+(who()||'You')+'   |   '+d+'   |   RetirementPlanKaro.com   |   '+CFG.mail;q.font={size:10,bold:true,color:{argb:NV}};q.fill=fill(GD);q.alignment={indent:1};ws.getRow(2).height=20};
const hdr=r=>{r.eachCell(c=>{c.fill=fill(NV);c.font={bold:true,color:{argb:'FFF3DFA2'}};c.alignment={horizontal:'center',vertical:'middle',wrapText:true};c.border=bd});r.height=28};
const tot=l=>/^(Total|Net worth$|Saved|Overspent|Monthly income|Money needed|Money you will have|Extra|Shortfall)/.test(String(l)),g={};S.forEach(x=>(g[x.sh]=g[x.sh]||[]).push(x));
{const LP="'Live Plan'!",N0=Math.max(2,100-p.age),F0=22,L0=F0+N0-1,rg=c=>`$${c}$${F0}:$${c}$${L0}`,lrg=c=>LP+rg(c),nd=need(p,G),fv=proj(p,G),o=rows(p,G).find(x=>x.close<0),s0=SC(),W='FFFFFFFF',blue={color:{argb:'FF0000FF'},bold:true},
db=mk('Dashboard',NV),lp=mk('Live Plan','FFF59E0B'),
head=(ws,a,t)=>{const c=ws.getCell(a);c.value=t;c.fill=fill(TL);c.font={bold:true,color:{argb:W}};c.border=bd;c.alignment={horizontal:'center',vertical:'middle',wrapText:true}},
pf=c=>({type:'pattern',pattern:'solid',bgColor:{argb:c}});wb.calcProperties={fullCalcOnLoad:true};
banner(lp,'Live Plan: change the yellow cells and everything updates',10);
head(lp,'A4','Your inputs (edit the yellow cells)');head(lp,'B4','Value');head(lp,'D4','Result');head(lp,'E4','Value');
[['Current age',p.age],['Retire at age',p.ret],['Money should last till age',p.life],['Monthly spending today',p.exp,1],['Pension or rent after retiring, per month (today)',p.oth,1],['Price rise (% a year)',p.infl],['Return before retiring (% a year)',p.rpre],['Return after retiring (% a year)',p.rpost],['Savings kept for retirement today',p.cur,1],['Monthly investment',p.sip,1],['Yearly yearly increase (%)',p.step],['Market scenario (pick from the list)','Base case']].forEach(([l,x,m],i)=>{const r=5+i,a=lp.getCell(r,1),c=lp.getCell(r,2);a.value=l;a.border=bd;c.value=x;c.font=blue;c.fill=fill(AM);c.border=bd;c.alignment={horizontal:'right'};if(m)c.numFmt=NF});
const adj='IF($B$16="Cautious (-2%)",-2,IF($B$16="Optimistic (+2%)",2,0))';
[[17,'Return before retiring, used (%)','$B$11',p.rpre],[18,'Return after retiring, used (%)','$B$12',p.rpost]].forEach(([r,l,b,x])=>{const a=lp.getCell(r,1),c=lp.getCell(r,2);a.value=l;a.border=bd;c.value={formula:b+'+'+adj,result:x};c.border=bd;c.alignment={horizontal:'right'}});
lp.getCell('B16').dataValidation={type:'list',allowBlank:false,formulae:['"Cautious (-2%),Base case,Optimistic (+2%)"']};
['B5','B6','B7'].forEach(a=>lp.getCell(a).dataValidation={type:'whole',operator:'between',allowBlank:false,showErrorMessage:true,errorTitle:'Check the age',error:'Enter an age from 1 to 100.',formulae:[1,100]});
['B10','B11','B12','B15'].forEach(a=>lp.getCell(a).dataValidation={type:'decimal',operator:'between',allowBlank:false,showErrorMessage:true,errorTitle:'Check the rate',error:'Enter a percentage from 0 to 30.',formulae:[0,30]});
[['Money needed at retirement',`IFERROR(INDEX(${rg('I')},MATCH($B$6,${rg('A')},0)),0)`,nd,NF],['Money you will have',`IFERROR(INDEX(${rg('C')},MATCH($B$6,${rg('A')},0)),0)`,fv,NF],['Surplus or shortfall','E6-E5',fv-nd,NF],['Readiness','IF(E5>0,E6/E5,0)',nd>0?fv/nd:0,'0%'],['Savings last till age',`IFERROR(INDEX(${rg('A')},MATCH(1,${rg('J')},0)),"Lasts till "&$B$7)`,o?o.a:'Lasts till '+p.life],['Status','IF(E7>=0,"On track","Shortfall")',fv>=nd?'On track':'Shortfall']].forEach(([l,f,x,m],i)=>{const r=5+i,a=lp.getCell(r,4),c=lp.getCell(r,5);a.value=l;a.border=bd;a.font={bold:true};c.value={formula:f,result:x};c.border=bd;c.font={bold:true};c.alignment={horizontal:'right'};if(m)c.numFmt=m});
lp.getCell('A20').value='Year by year (all formulas). Type a goal cost in the yellow column to test a life goal.';lp.getCell('A20').font={bold:true,color:{argb:TL}};
['Age','Phase','Savings at start','Added (+) or withdrawn (-)','Goal cost today (edit)','Goal cost that year','Growth earned','Savings at end','Money needed from this year','Ran out? (1 = yes)'].forEach((t,j)=>head(lp,lp.getCell(21,j+1).address,t));
for(let i=0;i<N0;i++){const r=F0+i,A='$A'+r,S=A+'>=$B$7',z=x=>`IF(${S},"",${x})`,F=[i?`A${r-1}+1`:'$B$5',z(`IF(${A}<$B$6,"Saving","Retired")`),z(i?`H${r-1}`:'$B$13'),z(`IF(${A}<$B$6,$B$14*12*(1+$B$15/100)^(${A}-$B$5),-MAX(0,($B$8-$B$9)*12*(1+$B$10/100)^(${A}-$B$5)))`),null,z(`N(E${r})*(1+$B$10/100)^(${A}-$B$5)`),z(`IF(C${r}+(D${r}-F${r})/2>0,IF(${A}<$B$6,$B$17,$B$18)/100*(C${r}+(D${r}-F${r})/2),0)`),z(`C${r}+D${r}-F${r}+G${r}`),`IF(OR(${S},${A}<$B$6),"",(N(I${r+1})+(F${r}-D${r})*(1+$B$18/200))/(1+$B$18/100))`,`IF(ISNUMBER(H${r}),IF(H${r}<0,1,0),0)`];
F.forEach((f,j)=>{const c=lp.getCell(r,j+1);if(f)c.value={formula:f};c.border=bd;if(j>1&&j<9)c.numFmt=NF;if(j===4){c.fill=fill(AM);c.font=blue;const g0=G[p.age+i];if(g0&&g0.amt)c.value=g0.amt}})}
lp.addConditionalFormatting({ref:`A${F0}:D${L0}`,rules:[{type:'expression',formulae:[`$A${F0}=$B$6`],style:{fill:pf(AM)}}]});
[46,14,20,26,22,20,18,20,24,14].forEach((w,j)=>lp.getColumn(j+1).width=w);
banner(db,'Dashboard',4);head(db,'A4','Key numbers');head(db,'B4','Value');head(db,'C4','What it means');
[['Net worth today',Math.round(s0.nw),0,'Assets minus loans, from Step 1',NF],['Money needed at retirement','E5',nd,'Includes your life goals',NF],['Money you will have','E6',fv,'If you keep investing as planned',NF],['Surplus or shortfall','E7',fv-nd,'Positive means extra, negative means short',NF],['Readiness','E8',nd>0?fv/nd:0,'',"0%"],['Savings last till age','E9',o?o.a:'Lasts till '+p.life,'Edit the yellow cells in the Live Plan sheet',''],['Status','E10',fv>=nd?'On track':'Shortfall','','']].forEach(([l,f,x,t,m],i)=>{const r=5+i,a=db.getCell(r,1),c=db.getCell(r,2),d=db.getCell(r,3);a.value=l;a.font={bold:true};a.border=bd;c.value=i?{formula:LP+f,result:x}:f;c.border=bd;c.font={bold:true,size:12};c.alignment={horizontal:'right'};if(m)c.numFmt=m;d.value=t;d.font={italic:true,color:{argb:'FF52667A'}};d.border=bd});
db.getCell('C9').value={formula:'REPT("█",MIN(30,ROUND(B9*20,0)))'};db.getCell('C9').font={color:{argb:TL}};
db.addConditionalFormatting({ref:'B11',rules:[{type:'cellIs',operator:'equal',formulae:['"On track"'],style:{fill:pf('FFD1FAE5')}},{type:'cellIs',operator:'equal',formulae:['"Shortfall"'],style:{fill:pf(RD)}}]});
db.getCell('A14').value='Savings by age (bars update when you change the Live Plan sheet)';db.getCell('A14').font={bold:true,size:12,color:{argb:TL}};
['Age','Savings at end of age','Chart','Phase'].forEach((t,j)=>head(db,db.getCell(15,j+1).address,t));
for(let k=0;k<14;k++){const r=16+k,a=`${LP}$B$5+${5*k}`,F=[`IF(${a}<${LP}$B$7,${a},"")`,`IF(A${r}="","",IFERROR(INDEX(${lrg('H')},MATCH(A${r},${lrg('A')},0)),0))`,`IF(A${r}="","",REPT("█",ROUND(MAX(0,B${r})/MAX(1,MAX($B$16:$B$29))*45,0)))`,`IF(A${r}="","",IF(A${r}>=${LP}$B$6,"Retired","Saving"))`];F.forEach((f,j)=>{const c=db.getCell(r,j+1);c.value={formula:f};c.border=bd;if(j===1)c.numFmt=NF;if(j===2)c.font={color:{argb:TL}}})}
let rr=32;
[['Where your money goes every month',expList().filter(x=>x.v>0).sort((a,b)=>b.v-a.v).map(x=>[x.n,Math.round(x.v)])],['What you own today',assetList().filter(x=>x.v>0).map(x=>[x.n,Math.round(x.v)])]].forEach(([t,it])=>{if(!it.length)return;const h=db.getCell(rr,1);h.value=t;h.font={bold:true,size:12,color:{argb:TL}};['Item','Amount','Chart','Share'].forEach((q,j)=>head(db,db.getCell(rr+1,j+1).address,q));const a=rr+2,z=rr+1+it.length;it.forEach(([n,x],i)=>{const r=a+i;[n,x,{formula:`REPT("█",ROUND(D${r}*40,0))`},{formula:`B${r}/SUM($B$${a}:$B$${z})`}].forEach((q,j)=>{const c=db.getCell(r,j+1);c.value=q;c.border=bd;if(j===1)c.numFmt=NF;if(j===2)c.font={color:{argb:TL}};if(j===3)c.numFmt='0%'})});rr=z+3});
[34,22,50,14].forEach((w,j)=>db.getColumn(j+1).width=w)}

const sc=SC(),IN=INS(inr);
[22,22,22,22,22,22].forEach((w,j)=>sm.getColumn(j+1).width=w);banner(sm,'Premium Retirement Report',6);sm.addRow([]);
const cardX=(r,c0,lab,val,m)=>{sm.mergeCells(r,c0,r,c0+1);sm.mergeCells(r+1,c0,r+1,c0+1);const a=sm.getCell(r,c0),b=sm.getCell(r+1,c0);a.value=lab;a.font={size:9,bold:true,color:{argb:'FF52667A'}};a.fill=fill(ZB);a.alignment={horizontal:'center',vertical:'middle'};b.value=val;b.font={size:18,bold:true,color:{argb:NV}};b.fill=fill(LT);b.alignment={horizontal:'center',vertical:'middle'};if(m)b.numFmt=NF;const gl={style:'medium',color:{argb:GD}};[c0,c0+1].forEach(j=>{sm.getCell(r+1,j).border={bottom:gl};sm.getCell(r+1,j).fill=fill(LT)});sm.getRow(r).height=20;sm.getRow(r+1).height=34};
const rdy=sc.rd==null;cardX(4,1,'TOTAL WORTH TODAY',Math.round(sc.nw),1);cardX(4,3,'MONEY NEEDED AT RETIREMENT',rdy?'-':Math.round(sc.n),!rdy);cardX(4,5,'MONEY YOU WILL HAVE',rdy?'-':Math.round(sc.f),!rdy);
cardX(7,1,'RETIREMENT READINESS',rdy?'-':Math.round(sc.rd)+'%');cardX(7,3,'MONTHLY INVESTMENT NEEDED',sc.s==null?'-':Math.round(sc.s),sc.s!=null);cardX(7,5,'FINANCIAL HEALTH SCORE',sc.t==null?'-':sc.t+' / 100');
let q=10;const sh=(t)=>{sm.mergeCells(q,1,q,6);const c=sm.getCell(q,1);c.value=t;c.font={size:13,bold:true,color:{argb:NV}};c.border={bottom:{style:'medium',color:{argb:GD}}};sm.getRow(q).height=24;q++};
sh('Your rewards');sm.mergeCells(q,1,q,6);{const c=sm.getCell(q,1);c.value='⭐ '+ptsBal()+' points     |     Referral code: '+((USER&&USER.code)||'-')+'     |     Earn '+CFG.refPts+' points for every friend who signs up     |     Daily streak: Day '+(USER?stView(USER).day:0)+' of '+CFG.streakDays+'     |     Email: '+CFG.mail;c.font={bold:true,size:11,color:{argb:NV}};c.fill=fill(LT);c.alignment={vertical:'middle',indent:1};c.border={top:{style:'thin',color:{argb:GD}},bottom:{style:'medium',color:{argb:GD}}};sm.getRow(q).height=30;q+=2}
sh('Health score breakdown');(sc.pts||[]).filter(x=>x.pts!=null).forEach(x=>{sm.mergeCells(q,1,q,2);sm.mergeCells(q,3,q,5);const a=sm.getCell(q,1),b=sm.getCell(q,3),c=sm.getCell(q,6),k=Math.round(x.pts/20*30);a.value=x.n;a.font={bold:true,color:{argb:NV}};a.alignment={indent:1};b.value={formula:'REPT("█",'+k+')',result:'█'.repeat(k)};b.font={color:{argb:x.pts>=14?'FF059669':x.pts>=8?'FFD97706':'FFDC2626'}};c.value=Math.round(x.pts)+' / 20';c.alignment={horizontal:'center'};c.font={bold:true};[1,2,3,4,5,6].forEach(j=>sm.getCell(q,j).border=bd);q++});q++;
sh('Do these first');ACI().slice(0,3).forEach((a,i)=>{sm.mergeCells(q,1,q,6);const c=sm.getCell(q,1);c.value=(i+1)+'.  '+dec(a.x);c.alignment={wrapText:true,vertical:'middle',indent:1};c.fill=fill(a.t==='b'?RD:AM);c.border=bd;sm.getRow(q).height=Math.max(32,Math.ceil(dec(a.x).length/120)*16+10);q++});q++;
sh('Your insights at a glance');IN.ins.slice(0,4).forEach(([h,t,c])=>{sm.mergeCells(q,1,q,2);sm.mergeCells(q,3,q,6);const a=sm.getCell(q,1),b=sm.getCell(q,3);a.value=h;a.font={bold:true,color:{argb:NV}};a.alignment={vertical:'middle',wrapText:true,indent:1};b.value=t;b.alignment={wrapText:true,vertical:'middle'};const fc=c==='g'?'FFD1FAE5':c==='a'?AM:c==='r'?RD:LT;[1,2,3,4,5,6].forEach(j=>{sm.getCell(q,j).fill=fill(fc);sm.getCell(q,j).border=bd});sm.getRow(q).height=Math.max(34,Math.ceil(t.length/85)*16+8);q++});q++;
sh('Inside this workbook');const DS={'Dashboard':'Key numbers and bars that update live','Live Plan':'Change the yellow cells to test your plan','Net worth':'What you own, what you owe and net worth','Income & expenses':'Monthly spending, savings and protection','Retirement plan':'Assumptions and result','Life goals':'Goals with cost adjusted for rising prices','Year by year':'Savings, growth and goals by age',Family:'Family Dashboard with totals','Insights':'What your numbers say, in plain words','What-if':'See how one change moves your result','Action Plan':'Your priorities, most urgent first'};
['Dashboard','Live Plan'].concat(Object.keys(g),FAM.length?['Family']:[],['Insights','What-if','Action Plan']).forEach(k=>{sm.mergeCells(q,2,q,6);const a=sm.getCell(q,1),b=sm.getCell(q,2);a.value={text:k,hyperlink:"#'"+k+"'!A1"};a.font={color:{argb:TL},underline:true,bold:true};b.value=DS[k]||'';[1,2,3,4,5,6].forEach(j=>sm.getCell(q,j).border=bd);q++});q++;
sm.mergeCells(q,1,q,6);const nt=sm.getCell(q,1);nt.value='Educational estimate based on your inputs. Not investment, tax or legal advice.';nt.font={italic:true,size:9,color:{argb:'FF52667A'}};sm.views=[{showGridLines:false}];
Object.keys(g).forEach(k=>{const n=Math.max(...g[k].map(x=>x.h.length)),ws=mk(k),w=Array(n).fill(14);banner(ws,k,n);ws.addRow([]);
g[k].forEach(x=>{const tr=ws.addRow([x.t]);ws.mergeCells(tr.number,1,tr.number,n);tr.getCell(1).font={bold:true,size:12,color:{argb:TL}};tr.height=22;const hr=ws.addRow(x.h);hdr(hr);if(k==='Year by year')ws.views=[{showGridLines:false,state:'frozen',ySplit:hr.number}];
x.r.forEach((r,i)=>{const row=ws.addRow(r),b=tot(r[0]);row.eachCell({includeEmpty:true},(c,j)=>{if(j>x.h.length)return;c.border=bd;if(typeof c.value==='number'){c.numFmt=NF;c.alignment={horizontal:'right'}}if(i%2)c.fill=fill(ZB);if(b){c.font={bold:true};c.fill=fill(LT)}if(k==='Year by year'&&String(r[0])===String(p.ret)){c.fill=fill(AM);c.font={bold:true}}});r.forEach((c,j)=>{w[j]=Math.max(w[j],Math.min(46,String(c).length+4))})});
x.h.forEach((c,j)=>{w[j]=Math.max(w[j],Math.min(30,c.length+4))});ws.addRow([])});w.forEach((x,j)=>ws.getColumn(j+1).width=x)});
if(FAM.length){const H=['Name','Relation','Age','Monthly income','Monthly spending','Liquid assets','Non-liquid assets','Loans and dues','Net worth','Monthly investment','Life cover','Health cover','Emergency money'],ws=mk('Family'),V=m=>[m.inc,m.exp,m.liq,m.ill,m.debt,nwm(m),m.sip,m.lc,m.hc,m.ef];banner(ws,'Family Dashboard',H.length);ws.addRow([]);const hr=ws.addRow(H);hdr(hr);ws.views=[{showGridLines:false,state:'frozen',ySplit:hr.number}];
FAM.forEach((m,i)=>{const r=ws.addRow([m.name,m.rel,m.age,...V(m)]);r.eachCell((c,j)=>{c.border=bd;if(j>3)c.numFmt=NF;if(i%2)c.fill=fill(ZB)})});
const a=hr.number+1,z=hr.number+FAM.length,tr=ws.addRow(['Family total','','']);for(let j=4;j<=H.length;j++){const L=ws.getColumn(j).letter;tr.getCell(j).value={formula:`SUM(${L}${a}:${L}${z})`,result:FAM.reduce((q,m)=>q+V(m)[j-4],0)}}tr.eachCell({includeEmpty:true},(c,j)=>{if(j>H.length)return;c.font={bold:true};c.fill=fill(LT);c.border=bd;if(j>3)c.numFmt=NF});H.forEach((h,j)=>ws.getColumn(j+1).width=j?Math.max(15,h.length+4):22)}
{const ws=mk('Insights',GD);[28,100,14].forEach((w,j)=>ws.getColumn(j+1).width=w);banner(ws,'Your Financial Insights',3);ws.addRow([]);hdr(ws.addRow(['Topic','What your numbers say','Signal']));
IN.ins.forEach(([h,t,c])=>{const r=ws.addRow([h,t,c==='g'?'Good':c==='r'?'Act now':c==='a'?'Watch':'Note']);r.height=Math.max(36,Math.ceil(t.length/95)*16+10);r.getCell(1).font={bold:true,color:{argb:NV}};r.getCell(3).font={bold:true};r.getCell(3).alignment={horizontal:'center',vertical:'middle'};[1,2].forEach(j=>r.getCell(j).alignment={wrapText:true,vertical:'middle',indent:j===1?1:0});[1,2,3].forEach(j=>{r.getCell(j).border=bd});r.getCell(3).fill=fill(c==='g'?'FFD1FAE5':c==='a'?AM:c==='r'?RD:LT)});
ws.addRow([]);ws.addRow(['These insights use your numbers and assumptions. They are educational estimates, not advice.']).getCell(1).font={italic:true,size:9,color:{argb:'FF52667A'}}}
{const ws=mk('What-if',GD);[34,20,22,14,22,26].forEach((w,j)=>ws.getColumn(j+1).width=w);banner(ws,'What if you change your plan?',6);ws.addRow([]);const hr=ws.addRow(['Change','Money needed','Money you will have','Readiness','Extra or short','Bar']);hdr(hr);
IN.sc.forEach(([nm,nn,ff,rp],i)=>{const r=ws.addRow([nm,Math.round(nn),Math.round(ff)]),n=r.number;r.getCell(4).value={formula:`IF(B${n}>0,MIN(1,C${n}/B${n}),1)`,result:rp/100};r.getCell(5).value={formula:`C${n}-B${n}`,result:Math.round(ff-nn)};r.getCell(6).value={formula:`REPT("█",ROUND(D${n}*20,0))`,result:'█'.repeat(Math.round(rp/5))};[2,3,5].forEach(j=>r.getCell(j).numFmt=NF);r.getCell(4).numFmt='0%';r.getCell(6).font={color:{argb:TL}};r.getCell(1).font={bold:i===0};for(let j=1;j<=6;j++){r.getCell(j).border=bd;if(i%2)r.getCell(j).fill=fill(ZB);if(i===0)r.getCell(j).fill=fill(LT)}});
const a0=hr.number+1,z0=hr.number+IN.sc.length;const pf2=c=>({type:'pattern',pattern:'solid',bgColor:{argb:c}});ws.addConditionalFormatting({ref:`D${a0}:D${z0}`,rules:[{type:'cellIs',operator:'greaterThanOrEqual',formulae:['1'],style:{fill:pf2('FFD1FAE5')}},{type:'cellIs',operator:'lessThan',formulae:['0.7'],style:{fill:pf2(RD)}},{type:'cellIs',operator:'between',formulae:['0.7','0.9999'],style:{fill:pf2(AM)}}]});
ws.addRow([]);ws.addRow(['Each row changes one thing and keeps the rest of your plan the same. These are estimates, not promises.']).getCell(1).font={italic:true,size:9,color:{argb:'FF52667A'}};ws.views=[{showGridLines:false,state:'frozen',ySplit:hr.number}]}
{const ws=mk('Action Plan','FFF59E0B');ws.getColumn(1).width=16;ws.getColumn(2).width=110;banner(ws,'Your Personalized Action Plan',2);ws.addRow([]);hdr(ws.addRow(['Priority','What to do']));
ACI().forEach(a=>{const r=ws.addRow([a.t==='b'?'Act now':'Watch',dec(a.x)]);r.getCell(1).font={bold:true};r.getCell(2).alignment={wrapText:true,vertical:'top'};[1,2].forEach(j=>{r.getCell(j).border=bd;r.getCell(j).fill=fill(a.t==='b'?RD:AM)})});const r=ws.addRow(['Yearly','Review and update this plan once a year.']);[1,2].forEach(j=>r.getCell(j).border=bd)}
const buf=await wb.xlsx.writeBuffer(),a=document.createElement('a');a.href=URL.createObjectURL(new Blob([buf],{type:'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'}));a.download='RetirementPlanKaro-Premium-Report.xlsx';document.body.appendChild(a);a.click();a.remove();toast('Premium Excel report downloaded')}
document.addEventListener('click',e=>{const b=e.target.closest('[data-auth]');if(!b)return;PEND=null;openAuth();authTab(b.dataset.auth);$(b.dataset.auth==='su'?'#su-n':'#li-i').focus()});
function syncHero(){const a=$('#ha-in'),o=$('#ha-out');if(!a)return;a.hidden=!USER;o.hidden=!!USER;if(USER)$('#ha-hi').textContent='Welcome back, '+USER.name}
const _uu=updUsr;updUsr=function(){_uu();syncHero()};
updUsr();
ck('30s');route();openStep('nw');scrollTo(0,0);

/* ---- country, currency and language ---- */
const LANGS='en|English;hi|हिन्दी;bn|বাংলা;ta|தமிழ்;te|తెలుగు;mr|मराठी;gu|ગુજરાતી;ur|اردو;ar|العربية;es|Español;fr|Français;de|Deutsch;pt|Português;it|Italiano;ru|Русский;tr|Türkçe;zh-CN|中文;ja|日本語;ko|한국어;id|Bahasa Indonesia;ms|Bahasa Melayu;vi|Tiếng Việt;th|ไทย;fil|Filipino;ne|नेपाली;sw|Kiswahili'.split(';').map(x=>x.split('|'));
$('#ctry').innerHTML=Object.entries(CT).map(([k,c])=>`<option value="${k}">${c.n} (${c.c})</option>`).join('');$('#ctry').value=CC;
$('#lang').innerHTML=LANGS.map(([k,n])=>`<option value="${k}">${n}</option>`).join('');
const applyCur=()=>{const y=CT[CC].s;$$('.cs').forEach(e=>{if(e.textContent!==y)e.textContent=y});$$('.in:has(>i.cs) input').forEach(i=>{if(i.step!=='any')i.step='any'})};
let _raf;new MutationObserver(()=>{cancelAnimationFrame(_raf);_raf=requestAnimationFrame(applyCur)}).observe(document.body,{childList:true,subtree:true});
function setCountry(c,init){const o=CT[CC],n=CT[c];if(!init&&c!==CC){const f=o.p/n.p;$$('.in:has(>i.cs) input').forEach(i=>{if(i.value!=='')i.value=Math.round(parseFloat(i.value)*f)||''});GL.forEach(x=>{x.amt=Math.round((x.amt||0)*f)});['infl','rpre','rpost'].forEach((k,j)=>{const e=$('#'+k);if(e&&+e.value===o.d[j])e.value=n.d[j]})}
CC=c;try{localStorage.setItem('ctry',c)}catch(e){}
if(init){['infl','rpre','rpost'].forEach((k,j)=>{const e=$('#'+k);if(e&&+e.value===CT.IN.d[j])e.value=n.d[j]})}
applyCur();renderGL();syncG();calc();try{swp(true)}catch(e){}toast('Currency: '+n.c+' · all amounts shown in '+n.s.trim())}
$('#ctry').onchange=e=>setCountry(e.target.value);
function gtInit(){if(window._gtI)return;window._gtI=1;try{new google.translate.TranslateElement({pageLanguage:'en',autoDisplay:false,includedLanguages:LANGS.map(x=>x[0]==='fil'?'tl':x[0]).join(',')},'gt_el')}catch(e){window._gtI=0;window.GTFAIL=1}}
function loadGT(){if(window._gtL)return;window._gtL=1;if(window.google&&google.translate&&google.translate.TranslateElement)return gtInit();const sc=document.createElement('script');sc.src='https://translate.google.com/translate_a/element.js?cb=gtInit';sc.onerror=()=>{window.GTFAIL=1;window._gtL=0;sc.remove()};document.head.appendChild(sc)}
function setLang(l){try{localStorage.setItem('lang',l)}catch(e){}const g=l==='fil'?'tl':l;document.documentElement.dir=['ar','ur'].includes(l)?'rtl':'ltr';
const go=()=>{const c=document.querySelector('select.goog-te-combo');if(!c)return false;if(g==='en'){const o=[...c.options].find(x=>x.value==='en');c.value=o?'en':''}else c.value=g;c.dispatchEvent(new Event('change',{bubbles:true}));if(g==='en')setTimeout(()=>{if(/translated-(ltr|rtl)/.test(document.documentElement.className)){document.cookie='googtrans=;expires=Thu,01 Jan 1970 00:00:00 GMT;path=/';location.reload()}},900);return true};
if(g==='en'&&!document.querySelector('select.goog-te-combo'))return;loadGT();if(go())return;let t=0;const w=setInterval(()=>{if(go()){clearInterval(w);return}if(window.GTFAIL||++t>40){clearInterval(w);toast('Translation could not load. Please check your internet connection and open the site over https.')}},300)}
$('#lang').onchange=e=>setLang(e.target.value);
let _sl='en';try{_sl=localStorage.getItem('lang')||'en'}catch(e){}$('#lang').value=_sl;if(_sl!=='en')setLang(_sl);
if(CC!=='IN')setCountry(CC,true);else applyCur();
</script>
<script>
/* Screenshot deterrent (best effort). Hides the page ONLY for real capture shortcuts. */
(function(){
const sh=document.getElementById('shield');
let until=0,timer=null;
const inField=t=>t&&t.closest&&t.closest('input,textarea,select,.mail');
const hold=ms=>{
  until=Date.now()+ms;
  sh.hidden=false;
  clearTimeout(timer);
  timer=setTimeout(()=>{sh.hidden=true},ms);
};
const reveal=()=>{if(Date.now()>=until)sh.hidden=true};
const wipe=()=>{try{navigator.clipboard.writeText('Screenshots are turned off on this site.').catch(()=>{})}catch(_){}};

addEventListener('contextmenu',e=>{if(!inField(e.target))e.preventDefault()});
addEventListener('dragstart',e=>e.preventDefault());
['copy','cut'].forEach(k=>addEventListener(k,e=>{if(!inField(e.target))e.preventDefault()}));

addEventListener('keydown',e=>{
  const c=e.code;
  /* Print Screen */
  if(e.key==='PrintScreen'||c==='PrintScreen'){hold(2500);wipe();return}
  /* Windows snipping: Win + Shift + S */
  if(e.metaKey&&e.shiftKey&&c==='KeyS'){hold(3000);return}
  /* Mac screenshots: Cmd + Shift + 3 / 4 / 5 */
  if(e.metaKey&&e.shiftKey&&(c==='Digit3'||c==='Digit4'||c==='Digit5')){hold(3000);return}
  /* Ctrl + Shift + S (browser screenshot tools), never while typing in a field */
  if(e.ctrlKey&&e.shiftKey&&c==='KeyS'&&!inField(e.target)){hold(2500);return}
  /* Print / Save page, never while typing in a field */
  if((e.ctrlKey||e.metaKey)&&(c==='KeyP'||c==='KeyS')&&!inField(e.target)){e.preventDefault();hold(1500)}
},true);

addEventListener('keyup',e=>{
  if(e.key==='PrintScreen'||e.code==='PrintScreen'){wipe();hold(2500)}
},true);

/* Never hide on blur, focus, tab switch or reload. These only REVEAL the page again. */
addEventListener('focus',reveal);
document.addEventListener('visibilitychange',()=>{if(!document.hidden)reveal()});
addEventListener('pageshow',()=>{sh.hidden=true});
addEventListener('beforeprint',()=>{sh.hidden=false});
addEventListener('afterprint',()=>{sh.hidden=true});
})();
</script>
<style>
#shb{position:fixed;right:16px;bottom:calc(16px + env(safe-area-inset-bottom,0px));z-index:40;font-family:inherit;font-size:14px;line-height:1.5}
#shb *{box-sizing:border-box}
#shb .av{position:relative;display:inline-grid;place-items:center;width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#FBBF24,var(--ac,#F59E0B));color:#10243A;font-weight:700;flex:none}
#shb .av.sm{width:26px;height:26px;font-size:12px;align-self:flex-end}
#shb header .av:after{content:"";position:absolute;right:-1px;bottom:-1px;width:10px;height:10px;border-radius:50%;background:#22C55E;border:2px solid #0F766E}
#shb-fab{display:flex;align-items:center;gap:8px;border:0;border-radius:999px;padding:6px 18px 6px 6px;background:linear-gradient(135deg,var(--br,#0F766E),#0B4F4A);color:#fff;font:inherit;font-weight:600;cursor:pointer;box-shadow:0 8px 24px rgba(15,118,110,.45)}
#shb-win{position:absolute;right:0;bottom:60px;width:min(380px,calc(100vw - 32px));height:min(560px,74vh);display:flex;flex-direction:column;background:var(--sf,#fff);color:var(--ink,#10243A);border:1px solid var(--ln,#D6E5E6);border-radius:20px;box-shadow:0 18px 50px rgba(0,0,0,.32);overflow:hidden;animation:shbin .22s ease-out}
#shb-win[hidden]{display:none}
@keyframes shbin{from{opacity:0;transform:translateY(10px) scale(.98)}}
@keyframes shbd{0%,80%,100%{opacity:.25}40%{opacity:1}}
#shb-win header{display:flex;align-items:center;gap:10px;padding:14px;background:linear-gradient(135deg,var(--br,#0F766E),#0B4F4A);color:#fff}
#shb-win header small{display:block;opacity:.85;font-size:12px}
#shb-x{margin-left:auto;background:rgba(255,255,255,.15);border:0;color:#fff;font-size:15px;cursor:pointer;width:30px;height:30px;border-radius:50%}
#shb-log{flex:1;overflow-y:auto;padding:14px 12px;display:flex;flex-direction:column;gap:10px;background:var(--bg,#F1F7F7)}
#shb-log .r{display:flex;gap:8px;max-width:92%;animation:shbin .2s ease-out}
#shb-log .r.u{align-self:flex-end}
#shb-log .m{padding:9px 13px;border-radius:16px;overflow-wrap:anywhere;box-shadow:0 1px 3px rgba(0,0,0,.08)}
#shb-log .b .m{background:var(--sf,#fff);border-bottom-left-radius:4px}
#shb-log .u .m{background:linear-gradient(135deg,var(--br,#0F766E),#0B4F4A);color:#fff;border-bottom-right-radius:4px}
#shb-log .m p{margin:0 0 6px}#shb-log .m p:last-child{margin:0}
#shb-log .m ul{margin:4px 0 6px;padding-left:18px}
#shb-log .th{display:flex;align-items:center;gap:8px;color:var(--mu,#52667A)}
#shb-log .th i{width:6px;height:6px;border-radius:50%;background:var(--br,#0F766E);animation:shbd 1.2s infinite}
#shb-log .th i:nth-child(3){animation-delay:.15s}#shb-log .th i:nth-child(4){animation-delay:.3s}
#shb-chips{display:flex;flex-wrap:wrap;gap:6px;padding:8px 12px;background:var(--bg,#F1F7F7)}
#shb-chips[hidden]{display:none}
#shb-chips button{border:1px solid var(--ln,#D6E5E6);background:var(--sf,#fff);color:var(--br,#0F766E);border-radius:999px;padding:7px 12px;font:inherit;font-size:12.5px;cursor:pointer}
#shb-f{display:flex;gap:8px;padding:10px 12px;border-top:1px solid var(--ln,#D6E5E6);background:var(--sf,#fff)}
#shb-i{flex:1;min-width:0;padding:10px 14px;border:1px solid var(--ln,#D6E5E6);border-radius:999px;background:var(--bg,#F1F7F7);color:var(--ink,#10243A);font:inherit;font-size:16px}
#shb-f button{width:42px;height:42px;border:0;border-radius:50%;background:linear-gradient(135deg,var(--br,#0F766E),#0B4F4A);color:#fff;font-size:16px;cursor:pointer;flex:none}
#shb-f button:disabled{opacity:.5;cursor:default}
#shb .note{margin:0;padding:0 14px 10px;font-size:11.5px;color:var(--mu,#52667A);background:var(--sf,#fff)}
@media (prefers-reduced-motion:reduce){#shb *{animation:none!important}}
</style>
<div id="shb"><button id="shb-fab" type="button" aria-expanded="false" aria-controls="shb-win"><span class="av">S</span><span>Ask Shubham</span></button>
<section id="shb-win" role="dialog" aria-label="Chat with Shubham" hidden>
<header><span class="av">S</span><div><b>Shubham</b><small>Retirement planning guide · Online</small></div><button id="shb-x" type="button" aria-label="Close chat">✕</button></header>
<div id="shb-log" aria-live="polite"></div>
<div id="shb-chips"></div>
<form id="shb-f" autocomplete="off"><input id="shb-i" maxlength="400" placeholder="Ask about retirement, SIP, tax..." aria-label="Your question"><button type="submit" aria-label="Send">➤</button></form>
<p class="note">Shubham is a virtual guide. General education, not investment advice.</p></section></div>
<script>
(function(){
/* BOT.api = URL of your small backend (see shubham-bot-proxy.js). Replies get Claude-quality only when this is set. */
const BOT={api:'/api/chat'},g=id=>document.getElementById(id),win=g('shb-win'),fab=g('shb-fab'),log=g('shb-log'),inp=g('shb-i'),form=g('shb-f'),send=form.querySelector('button'),chips=g('shb-chips'),hist=[],calm=matchMedia('(prefers-reduced-motion:reduce)').matches;
const QS=['How much do I need to retire?','SIP or lump sum?','What is inflation?'];
function inline(n,t){t.split(/(\*\*[^*]+\*\*)/).forEach(x=>{if(/^\*\*[^*]+\*\*$/.test(x)){const b=document.createElement('strong');b.textContent=x.slice(2,-2);n.appendChild(b)}else if(x)n.appendChild(document.createTextNode(x))})}
function render(el,t){el.textContent='';let ul=null;t.split('\n').forEach(l=>{const m=l.match(/^\s*(??[-•*]|\d+[.)])\s+(.*)/);if(m){if(!ul){ul=document.createElement('ul');el.appendChild(ul)}const li=document.createElement('li');inline(li,m[1]);ul.appendChild(li)}else{ul=null;if(!l.trim())return;const p=document.createElement('p');inline(p,l);el.appendChild(p)}})}
function add(c,t){const r=document.createElement('div');r.className='r '+c;if(c==='b'){const a=document.createElement('span');a.className='av sm';a.textContent='S';r.appendChild(a)}const m=document.createElement('div');m.className='m';if(t)render(m,t);r.appendChild(m);log.appendChild(r);log.scrollTop=log.scrollHeight;return r}
function thinking(){const r=add('b','');r.querySelector('.m').innerHTML='<span class="th"><span>Thinking</span><i></i><i></i><i></i></span>';return r}
const sleep=ms=>new Promise(r=>setTimeout(r,ms));
async function reveal(el,t){if(calm){render(el,t);return}const w=t.split(/(\s+)/);let s='';for(let i=0;i<w.length;i++){s+=w[i];if(i%2===0||i===w.length-1){let x=s;if((x.match(/\*\*/g)||[]).length%2)x=x.replace(/\*\*(?![\s\S]*\*\*)/,'');render(el,x);log.scrollTop=log.scrollHeight;await sleep(28)}}render(el,t)}
let greeted=false;
function open(o){win.hidden=!o;fab.setAttribute('aria-expanded',o);if(o){if(!greeted){greeted=true;add('b','Hi, I am Shubham. Ask me anything about retirement, SIP, inflation, EPF, PPF, NPS or planning your money. I will keep it simple.');QS.forEach(q=>{const b=document.createElement('button');b.type='button';b.textContent=q;b.onclick=()=>ask(q);chips.appendChild(b)})}inp.focus()}else fab.focus()}
fab.onclick=()=>open(win.hidden);g('shb-x').onclick=()=>open(false);
document.addEventListener('keydown',e=>{if(e.key==='Escape'&&!win.hidden)open(false)});
const STOP=new Set('the and for what how why with you are can does did that this from have will about into your when which who should would could they them there their than then also very much more some any all not but get got'.split(' '));
const SYN={sip:'systematic investment plan',swp:'systematic withdrawal plan',mf:'mutual fund',epf:'employees provident fund',ppf:'public provident fund',nps:'national pension system',fd:'fixed deposit',roi:'return on investment',ltcg:'long term capital gain',stcg:'short term capital gain'};
function normalize(s){let t=' '+s.toLowerCase()+' ';for(const k in SYN)t=t.replace(new RegExp('\\b'+k+'\\b','g'),SYN[k]);return t}
function local(q){const l=normalize(q.trim());
if(/^(hi+|hello|hey|namaste|namaskar)\b/.test(l))return'Hi! Good to see you here. What would you like to know about your money or retirement today?';
if(/^(thanks|thank you|thx|shukriya|dhanyavad)/.test(l))return'Happy to help! Ask me anything else whenever you like.';
if(/(who are you|are you (a )?(human|real|bot|ai|person)|aap kaun|kya tum insaan)/.test(l))return'I am Shubham, a virtual planning guide on this site. I explain money and retirement topics in simple words. I am not a person and not a licensed adviser.';
const k=(l.match(/[a-z0-9]{3,}/g)||[]).filter(x=>!STOP.has(x));
if(!k.length)return'I can help with retirement planning, SIP, inflation, EPF, PPF, NPS, emergency fund, insurance and tax basics. Try asking about one of these, or write to us at the email in the footer.';
let best=null,bs=0,src='';
document.querySelectorAll('#lp-faq details,#lp-guides details').forEach(d=>{
  const s=(d.querySelector('summary')||{textContent:''}).textContent.toLowerCase(),b=(d.textContent||'').toLowerCase();
  let n=0;k.forEach(x=>{if(s.includes(x))n+=4;if(b.includes(x))n+=1});
  if(n>bs){bs=n;best=d;src='faq'}
});
document.querySelectorAll('#glist .gterm').forEach(g=>{
  const dt=(g.querySelector('dt')||{textContent:''}).textContent.toLowerCase(),dd=(g.querySelector('dd')||{textContent:''}).textContent.toLowerCase();
  let n=0;k.forEach(x=>{if(dt.includes(x))n+=6;if(dd.includes(x))n+=1});
  if(n>bs){bs=n;best=g;src='glossary'}
});
if(!best||bs<4)return'I did not find a clear match for that. I can help with retirement planning, SIP, inflation, EPF, PPF, NPS, emergency fund, insurance and tax basics — try rephrasing, or write to us at the email in the footer.';
if(src==='glossary'){const dt=best.querySelector('dt').textContent,dd=best.querySelector('dd').textContent;return dt+': '+dd+'\n\nSee more words in the Learn section.'}
const t=(best.querySelector('.body')||best).textContent.replace(/\s+/g,' ').trim(),cut=t.slice(0,420),i=cut.lastIndexOf('. ');
return(i>120?cut.slice(0,i+1):cut)+'\n\nYou can read more in the Learn section.'}
async function ask(q){q=q.trim();if(!q||send.disabled)return;chips.hidden=true;add('u',q);hist.push({role:'user',content:q});inp.value='';send.disabled=true;const th=thinking(),t0=Date.now(),min=1800+Math.random()*1600;let r;
if(BOT.api){try{const c=new AbortController(),tm=setTimeout(()=>c.abort(),25000),res=await fetch(BOT.api,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({messages:hist.slice(-8)}),signal:c.signal});clearTimeout(tm);const d=await res.json();r=d&&d.reply}catch(e){}}
if(!r)r=local(q);await sleep(Math.max(0,min-(Date.now()-t0)));th.remove();log.setAttribute('aria-busy','true');const row=add('b',''),m=row.querySelector('.m');await reveal(m,r);log.setAttribute('aria-busy','false');hist.push({role:'assistant',content:r});send.disabled=false;inp.focus()}
form.onsubmit=e=>{e.preventDefault();ask(inp.value)};
})();
</script>
<script id="explore-js">
(function(){
const A=[['sav','Savings Account',3,'S'],['fd','Fixed Deposit (FD)',6,'M'],['bond','Bonds',11,'M'],['eq','Equity & Mutual Funds',12,'L'],['ppf','PPF',7.1,'L'],['epf','EPF',8.25,'L'],['ssy','Sukanya Samriddhi Yojana',8.2,'L'],['gold','Gold',8,'L'],['re','Real Estate',6,'L']];
const HZ=[['S','Short Term'],['M','Medium Term'],['L','Long Term']];
const EXR={rows:null,cc:CC};let LAST=null;
const fromPlan=()=>{const m={sav:v('bank'),fd:v('fd'),eq:v('eq'),epf:v('epf'),gold:v('gold'),re:v('re')};
return A.map(([k,n,r,t])=>({k,n,c:0,r,t,v:m[k]||0})).concat(cust('#c-L').concat(cust('#c-I')).filter(x=>x.v>0).map(x=>({k:'x',n:x.n,c:1,r:6,t:'M',v:x.v})))};
const rowH=x=>`<tr data-k="${x.k}" data-c="${x.c?1:0}" data-n="${esc(x.n)}"><td class="nm"><span class="ml">Name of Asset</span>${x.c?`<div class="in"><input class="xn" maxlength="40" value="${esc(x.n)}" placeholder="Asset name" aria-label="Asset name"></div>`:`<span class="xnm">${esc(x.n)}</span>`}</td><td><span class="ml">Your Current Investment</span><div class="in"><i class="cs">${CT[CC].s}</i><input class="xv" type="number" inputmode="decimal" min="0" step="any" placeholder="0" value="${x.v>0?x.v:''}" aria-label="Your current investment"></div></td><td><span class="ml">Your Expected Return</span><div class="in"><input class="xr" type="number" inputmode="decimal" min="0" max="100" step="0.01" value="${x.r}" aria-label="Expected return percent"><i>%</i></div></td><td><span class="ml">Your Earning (a year)</span><span class="xe">${inr(0)}</span></td><td><span class="ml">Investment Horizon</span><select class="sel xt" aria-label="Investment horizon">${HZ.map(([c,l])=>`<option value="${c}"${c===x.t?' selected':''}>${l}</option>`).join('')}</select></td><td class="xd">${x.c?'<button class="btn small" type="button" data-xrm aria-label="Remove">✕</button>':''}</td></tr>`;
function read(){if(!$('#xb'))return null;return $$('#xb tr').map(tr=>{const c=tr.dataset.c==='1';return{k:tr.dataset.k,c:c?1:0,n:c?(tr.querySelector('.xn').value.trim()||'Other'):tr.dataset.n,r:parseFloat(tr.querySelector('.xr').value)||0,t:tr.querySelector('.xt').value,v:parseFloat(tr.querySelector('.xv').value)||0}})}
function aiL(R,T,E){
const wr=E/T*100,f=n=>Math.round(n*100)/100,sv=ks=>R.filter(x=>ks.includes(x.k)).reduce((a,x)=>a+x.v,0),sh=ks=>sv(ks)/T,pr=n=>Math.round(n*100)+'%',rt=k=>(R.find(x=>x.k===k)||{}).r;
const G=[],B=[],W=[];
if(wr>=8)G.push(`Your overall return is ${f(wr)}%, a healthy level for a mixed portfolio.`);
if(R.length>=3)G.push(`You hold ${R.length} different investments, so one weak asset will not hurt you much.`);
if(sh(['eq'])>=.2&&sh(['eq'])<=.7)G.push(`Equity is ${pr(sh(['eq']))} of your money. This gives your wealth room to grow over the long term.`);
if(sh(['ppf','epf','ssy','fd','bond'])>=.3)G.push(`${pr(sh(['ppf','epf','ssy','fd','bond']))} sits in steady, lower-risk options like PPF, EPF, FD and Bonds. This gives you stability.`);
if(sv(['ppf','epf','ssy'])>0)G.push('Your PPF, EPF or Sukanya Samriddhi money earns steady, government-run returns.');
if(G.length<2)G.push('You are tracking your returns. This is the first step to better decisions.');
if(G.length<2)G.push('You have started investing, which matters most.');
const sav=sv(['sav']);if(sav>0&&sh(['sav'])>.2&&rt('sav')<=4){const mv=sav*.5,fr=rt('fd')||6;B.push(`${inr(sav)} sits in savings at ${f(rt('sav'))}%. Keep 3 to 6 months of expenses there and move about ${inr(mv)} to a FD or debt fund. That could add about ${inr(mv*(fr-rt('sav'))/100)} a year.`)}
if(sh(['eq'])<.2)B.push(`Equity is only ${pr(sh(['eq']))} of your money. For money you will not need for 5+ years, a monthly SIP can lift your return.`);
if(sh(['eq'])>.7)B.push(`Equity is ${pr(sh(['eq']))} of your money. Add some FD, PPF or Bonds to reduce big ups and downs.`);
if(!sv(['ppf','epf','ssy']))B.push('Consider PPF or EPF for safe, long-term, tax-friendly growth.');
const tp=R.slice().sort((a,b)=>b.v-a.v)[0];if(tp&&tp.v/T>.5&&R.length>1)B.push(`${pr(tp.v/T)} of your money is in ${esc(tp.n)}. Spreading it across more assets lowers risk.`);
B.push('Add to your investments every month, and raise the amount each year.');
B.push('Review this table every 6 to 12 months and update your returns.');
R.filter(x=>x.r>15).forEach(x=>W.push(`${esc(x.n)}: expecting ${f(x.r)}% a year is very high. Few investments give this every year without big risk.`));
const bo=R.find(x=>x.k==='bond');if(bo&&bo.r>9&&bo.r<=15)W.push(`Bonds at ${f(bo.r)}% is on the high side. Safe bonds usually give less, and higher rates often mean higher risk.`);
R.filter(x=>x.t==='S'&&['eq','bond','re'].includes(x.k)).forEach(x=>W.push(`${esc(x.n)} is marked Short Term. Money needed soon can fall in value at the wrong time. Keep short-term money safe.`));
if(sh(['sav'])>.4)W.push(`${pr(sh(['sav']))} of your money is in a low-return savings account. It is growing slowly.`);
const z=R.filter(x=>x.r===0);if(z.length)W.push(`${z.map(x=>esc(x.n)).join(', ')} show${z.length>1?'':'s'} 0% return. If this money has no purpose, put it to work.`);
if(tp&&tp.v/T>.7&&R.length>1)W.push(`${pr(tp.v/T)} in one asset (${esc(tp.n)}) is too concentrated. If it falls, most of your wealth falls.`);
W.push('Expected returns are estimates, not promises. Actual returns can be lower, especially for equity and bonds.');
return{G:G.slice(0,3),B:B.slice(0,4),W:W.slice(0,3)}}
function ai(R,T,E){const{G,B,W}=aiL(R,T,E),L=(c,h,a)=>`<div class="xg ${c}"><h4>${h}</h4><ul>${a.map(x=>`<li>${x}</li>`).join('')}</ul></div>`;
return `<div class="xaiw"><h3>✨ AI Insights</h3><div class="xg3">${L('g','✅ What is good',G)}${L('b','💡 What can be better',B)}${L('w','⚠️ What is wrong',W)}</div><small>Smart guidance from the numbers you entered. For learning, not financial advice.</small></div>`}
function sum(){if(!$('#xb'))return;let T=0,E=0;const R=[];LAST=null;$$('#xb tr').forEach(tr=>{const c=tr.dataset.c==='1',iv=parseFloat(tr.querySelector('.xv').value)||0,r=parseFloat(tr.querySelector('.xr').value)||0,e=iv*r/100;T+=iv;E+=e;tr.querySelector('.xe').textContent=inr(e);if(iv>0)R.push({e,k:tr.dataset.k,n:c?(tr.querySelector('.xn').value.trim()||'Other'):tr.dataset.n,v:iv,r,t:tr.querySelector('.xt').value})});
$('#xf-v').textContent=inr(T);$('#xf-r').textContent=(T>0?Math.round(E/T*10000)/100:0)+'%';$('#xf-e').textContent=inr(E);$('#xai').innerHTML=T>0?ai(R,T,E):'';if(T>0)LAST={R,T,E}}

const HZL={S:'Short Term',M:'Medium Term',L:'Long Term'};
function xPdf(){
if(!window.jspdf){toast('PDF library could not load. Check your connection.');return}
if(!LAST||LAST.T<=0){toast('Enter at least one investment first.');return}
const{R,T,E}=LAST,{G,B,W}=aiL(R,T,E),doc=new jspdf.jsPDF({unit:'pt',format:'a4'}),NV=[7,30,54],TL=[15,118,110],GD=[201,162,75],INK=[20,33,61],MU=[85,98,122],GR=[5,150,105],AMB=[217,119,6],RDc=[200,50,45],PW=595;
const cl=t=>csym(String(t)).replace(/&amp;/g,'&').replace(/&#x27;/g,"'").replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&quot;/g,'"'),
tx=(t,x,y,z,c,b,o)=>{doc.setFont('helvetica',b?'bold':'normal');doc.setFontSize(z);doc.setTextColor(...c);doc.text(String(t),x,y,o)},
fp=n=>(Math.round(n*100)/100)+'%',pmm=n=>csym(inr(n));
/* header */
doc.setFillColor(...NV);doc.rect(0,0,PW,104,'F');doc.setFillColor(...GD);doc.rect(0,104,PW,4,'F');doc.setFillColor(...TL);doc.rect(0,104,170,4,'F');
tx('RetirementPlanKaro.com',40,50,23,[255,255,255],1);tx('Retirement Planner for India',40,70,10,[243,223,162]);
const nm=(typeof who==='function'&&who())||'You';tx('Prepared for',PW-40,42,8.5,[170,190,210],0,{align:'right'});tx(cl(nm),PW-40,56,12,[255,255,255],1,{align:'right'});tx(new Date().toLocaleDateString('en-IN',{day:'numeric',month:'long',year:'numeric'}),PW-40,72,9,[243,223,162],0,{align:'right'});
/* title */
tx('My Investment Returns',40,142,24,NV,1);tx('See How Your Current Investment is Growing',40,160,11.5,[150,115,35]);
/* KPI tiles */
const K=[['TOTAL INVESTMENT',pmm(T),NV],['YEARLY EARNING',pmm(E),GR],['MONTHLY EARNING',pmm(E/12),TL],['OVERALL RETURN (XIRR)',fp(E/T*100),[150,115,35]]],kw=(515-3*10)/4;
K.forEach((k,i)=>{const x=40+i*(kw+10);doc.setFillColor(241,247,247);doc.roundedRect(x,176,kw,58,8,8,'F');doc.setFillColor(...GD);doc.roundedRect(x,176,4,58,2,2,'F');tx(k[0],x+14,194,7.2,MU,1);tx(k[1],x+14,218,k[1].length>13?13:15,k[2],1)});
/* table */
let y=252;const cx=[40,222,312,408,PW-40];
doc.setFillColor(...TL);doc.roundedRect(40,y,515,22,5,5,'F');
[['Name of Asset',cx[0]+10,0],['Your Investment',cx[1]+70,1],['Expected Return',cx[2]+62,1],['Your Earning',cx[3]+70,1],['Horizon',cx[4]-10,1]].forEach(h=>tx(h[0],h[1],y+14.5,8.6,[255,255,255],1,h[2]?{align:'right'}:{}));
y+=22;const rows=R.slice().sort((a,b)=>b.e-a.e||b.v-a.v),show=rows.slice(0,10);
show.forEach((r,i)=>{if(i%2===0){doc.setFillColor(248,251,251);doc.rect(40,y,515,19,'F')}
let n=cl(r.n);if(n.length>30)n=n.slice(0,29)+'.';tx(n,cx[0]+10,y+13,9,INK,1);tx(pmm(r.v),cx[1]+70,y+13,9,INK,0,{align:'right'});tx(fp(r.r),cx[2]+62,y+13,9,INK,0,{align:'right'});tx(pmm(r.e),cx[3]+70,y+13,9,GR,1,{align:'right'});tx(HZL[r.t]||'',cx[4]-10,y+13,8.6,MU,0,{align:'right'});
doc.setDrawColor(226,236,237);doc.setLineWidth(.5);doc.line(40,y+19,555,y+19);y+=19});
if(rows.length>10){tx('+ '+(rows.length-10)+' more asset(s) included in the totals',50,y+12,8,MU);y+=16}
doc.setFillColor(251,243,220);doc.roundedRect(40,y+4,515,24,5,5,'F');tx('Total',50,y+20,10,NV,1);tx(pmm(T),cx[1]+70,y+20,10,NV,1,{align:'right'});tx(fp(E/T*100),cx[2]+62,y+20,10,NV,1,{align:'right'});tx(pmm(E),cx[3]+70,y+20,10,GR,1,{align:'right'});y+=44;
/* earning mix bar */
const PAL=[[15,118,110],[37,99,235],[245,158,11],[5,150,105],[124,58,237],[219,39,119],[100,116,139]],es=rows.filter(r=>r.e>0);
if(es.length&&E>0){tx('Where your earnings come from',40,y,10,NV,1);y+=8;let bx=40;es.forEach((r,i)=>{const w=515*r.e/E;doc.setFillColor(...PAL[i%7]);doc.rect(bx,y,w,11,'F');bx+=w});y+=24;let lx=40;es.slice(0,6).forEach((r,i)=>{let n=cl(r.n);if(n.length>18)n=n.slice(0,17)+'.';const lab=n+' '+Math.round(r.e/E*100)+'%';doc.setFont('helvetica','normal');doc.setFontSize(8);const w=doc.getTextWidth(lab)+22;if(lx+w>555){return}doc.setFillColor(...PAL[i%7]);doc.circle(lx+3,y-3,3,'F');tx(lab,lx+10,y,8,INK);lx+=w+6});y+=22}
/* AI insights */
tx('AI Insights',40,y,14,NV,1);doc.setDrawColor(...GD);doc.setLineWidth(2);doc.line(40,y+5,92,y+5);y+=20;
const cols=[['What is good',G,GR],['What can be better',B,AMB],['What is wrong',W,RDc]],cw=(515-20)/3,pre=cols.map(c=>{doc.setFont('helvetica','normal');doc.setFontSize(8.2);return c[1].map(t=>doc.splitTextToSize(cl(t),cw-26))}),hh=Math.max(...pre.map(a=>a.reduce((s,l)=>s+l.length*10+6,0)))+34,maxH=800-y,H=Math.min(hh,maxH);
cols.forEach((c,i)=>{const x=40+i*(cw+10);doc.setFillColor(...(i===0?[236,250,244]:i===1?[255,248,232]:[254,240,238]));doc.roundedRect(x,y,cw,H,8,8,'F');doc.setFillColor(...c[2]);doc.roundedRect(x,y,cw,22,8,8,'F');doc.rect(x,y+12,cw,10,'F');tx(c[0],x+12,y+15,9.5,[255,255,255],1);
let yy=y+38;pre[i].forEach(L=>{if(yy+L.length*10>y+H)return;doc.setFillColor(...c[2]);doc.circle(x+12,yy-2.6,2.2,'F');doc.setFont('helvetica','normal');doc.setFontSize(8.2);doc.setTextColor(...INK);doc.text(L,x+20,yy);yy+=L.length*10+6})});
/* footer */
doc.setDrawColor(...GD);doc.setLineWidth(1.2);doc.line(40,812,555,812);
tx('Educational estimate based on your own inputs and expected returns. Not investment, tax or legal advice. Returns are before tax and fees.',40,824,7,MU);
tx('RetirementPlanKaro.com  |  '+CFG.mail,40,835,7.5,TL,1);doc.link(40,826,230,12,{url:'https://www.retirementplankaro.com'});tx(new Date().toLocaleDateString('en-IN'),555,835,7.5,MU,0,{align:'right'});
rpkWM(doc);doc.save('RetirementPlanKaro-My-Investment-Returns.pdf');toast('Your one-page PDF is downloaded');
}
const HEAD='<div class="xhead"><h2>My Investment Returns</h2><p>See How Your Current Investment is Growing</p></div>',BACK='<div style="margin-bottom:14px"><a class="btn small" href="#explore">← Back to Explore</a></div>';
window.renderExplore=function(sub){const r=read();if(r){EXR.rows=r;EXR.cc=CC}const el=$('#v-explore');
if(sub!=='returns'){el.innerHTML='<div class="sh"><h2>Explore</h2></div><div class="xgrid"><a class="xtile" href="#explore/returns"><h3>My Investment Returns</h3><p>See How Your Current Investment is Growing</p><span class="go">Open →</span></a></div>';scrollTo(0,0);return}
if(!USER){el.innerHTML=BACK+'<div class="xcard">'+HEAD+'<div class="xgate"><h3>Login or sign up to continue</h3><p>It takes a minute. Then your investment table opens right away.</p><div class="row"><button class="btn go lg" type="button" data-xlogin="su">Sign up</button><button class="btn lg" type="button" data-xlogin="li">Login</button></div></div></div>';scrollTo(0,0);return}
if(!EXR.rows)EXR.rows=fromPlan();
if(EXR.cc!==CC){const f=CT[EXR.cc].p/CT[CC].p;EXR.rows.forEach(x=>{x.v=Math.round(x.v*f)});EXR.cc=CC}
el.innerHTML=BACK+`<div class="xcard">${HEAD}<div class="xbody"><div class="xtw"><table class="xtab"><thead><tr><th>Name of Asset</th><th>Your Current Investment</th><th>Your Expected Return</th><th>Your Earning</th><th>Investment Horizon</th><th aria-label="Remove"></th></tr></thead><tbody id="xb">${EXR.rows.map(rowH).join('')}</tbody><tfoot><tr><td class="nm">Total</td><td><span class="ml">Total Investment</span><span id="xf-v">0</span></td><td><span class="ml">Overall Return (XIRR)</span><span id="xf-r">0%</span> <small style="font-weight:500;color:var(--mu)">XIRR</small></td><td><span class="ml">Total Earning</span><span class="xe" id="xf-e">0</span></td><td></td><td class="xd"></td></tr></tfoot></table></div><div class="row xadd"><button class="btn small" type="button" data-xadd>+ Add another asset</button><button class="btn go small" type="button" data-xpdf>⬇ Download One-Page PDF</button></div><div id="xai"></div></div></div>`;sum();scrollTo(0,0)};
const ex=$('#v-explore');
ex.addEventListener('input',e=>{if(e.target.closest('#xb'))sum()});
ex.addEventListener('click',e=>{const t=e.target,l=t.closest('[data-xlogin]');
if(l){PEND=null;openAuth();authTab(l.dataset.xlogin);return}
if(t.closest('[data-xpdf]')){xPdf();return}
if(t.closest('[data-xadd]')){const b=$('#xb');b.insertAdjacentHTML('beforeend',rowH({k:'x',n:'',c:1,r:6,t:'M',v:0}));b.lastElementChild.querySelector('.xn').focus();return}
if(t.closest('[data-xrm]')){t.closest('tr').remove();sum()}});
const LK=/^#(checklist|family|report|explore)/;
const again=()=>{if(LK.test(location.hash))route()};
let AFT=null;window.xAfter=k=>{AFT=k;PEND=null;openAuth()};
const _dn=done;done=function(u){_dn(u);const a=AFT;AFT=null;if(a==='swp'){show('plan');openStep('swp')}else again()};
document.addEventListener('click',e=>{if(e.target.closest('[data-auth],#ax'))AFT=null;if(e.target.closest('[data-flogout]'))setTimeout(()=>{again();if(!USER&&!$('#s-swp').hidden)openStep('nw')},50)});
const _sc=setCountry;setCountry=function(c,i){_sc(c,i);if($('#xb')){EXR.cc=CC;sum()}};
})();
if(/^#explore/.test(location.hash))route();
</script>
<style id="pf-css">
.pfn{margin:0 0 16px;padding:14px 16px;border-radius:14px;background:#FFF8E6;border:1px solid #E9D49A;color:#5B4510;font-size:14px;line-height:1.5}
.pfn b{color:#3F2F08}
.pfk{display:grid;gap:12px;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));margin:0 0 18px}
.pfk div{padding:12px 14px;border-radius:12px;background:var(--so);border-left:4px solid var(--gold,#C9A24B)}
.pfk small{display:block;color:var(--mu);font-size:12px;font-weight:600}.pfk b{font-size:18px;font-variant-numeric:tabular-nums}
.pfbar{height:10px;border-radius:6px;background:var(--ln);overflow:hidden;min-width:90px}.pfbar i{display:block;height:100%;background:linear-gradient(90deg,#0F766E,#C9A24B)}
.pfbar.hi i{background:#D9342B}
.pfh{font:600 20px var(--hd-serif,var(--h));margin:24px 0 10px;color:var(--ink)}
.pfs{display:block;margin-top:8px;color:var(--mu);font-size:13px}
.pfl{margin:0;padding-left:20px;display:grid;gap:8px;font-size:14.5px}
.pft{white-space:nowrap;font-weight:600}
.pfd{margin-top:22px;padding:14px 16px;border-radius:14px;background:#FDECEA;border:1px solid #F1B5AF;color:#7A1F18;font-size:13.5px;line-height:1.55}
.pfsc{display:grid;grid-template-columns:auto 1fr;gap:22px;align-items:center;margin:0 0 8px;padding:18px;border-radius:18px;border:1px solid var(--ln);background:var(--sf)}.pfring{width:132px;height:132px;border-radius:50%;display:grid;place-content:center;text-align:center;background:radial-gradient(closest-side,var(--sf) 76%,transparent 78%),conic-gradient(var(--c) calc(var(--p)*1%),var(--ln) 0)}.pfring b{font-size:38px;line-height:1;color:var(--c)}.pfring small{color:var(--mu)}@media(max-width:720px){.pfsc{grid-template-columns:1fr;justify-items:center;text-align:center}.pfsc .xtw{text-align:left}}
</style>
<script id="pf-js">
(function(){
const D={'Financial Services':{L:'HDFC Bank,ICICI Bank,State Bank of India,Kotak Mahindra Bank,Axis Bank,IndusInd Bank,Bajaj Finance,Bajaj Finserv,Shriram Finance,Jio Financial Services,HDFC Life Insurance,SBI Life Insurance',M:'Bank of Baroda,Punjab National Bank,Canara Bank,Federal Bank,IDFC First Bank,AU Small Finance Bank,Yes Bank,Cholamandalam Investment,Muthoot Finance,Power Finance Corporation,REC,SBI Cards,LIC Housing Finance,ICICI Lombard,ICICI Prudential Life,Max Financial Services,HDFC AMC,Bandhan Bank,Manappuram Finance,BSE,Piramal Finance,Poonawalla Fincorp'},
'IT & Technology':{L:'Tata Consultancy Services,Infosys,HCL Technologies,Wipro,Tech Mahindra',M:'LTIMindtree,Persistent Systems,Coforge,Mphasis,Oracle Financial Services,KPIT Technologies,Tata Elxsi,Cyient,Sonata Software,Zensar Technologies,Tata Technologies'},
'Oil, Gas & Energy':{L:'Reliance Industries,Oil & Natural Gas Corporation,Coal India',M:'Indian Oil Corporation,Bharat Petroleum,Hindustan Petroleum,GAIL,Oil India,Petronet LNG,Gujarat Gas,Indraprastha Gas,Castrol India,Adani Total Gas'},
'Power & Utilities':{L:'NTPC,Power Grid Corporation,Adani Power,Adani Green Energy',M:'Tata Power,JSW Energy,NHPC,Torrent Power,SJVN,Adani Energy Solutions,NTPC Green Energy,Suzlon Energy,CESC'},
'FMCG & Consumption':{L:'ITC,Hindustan Unilever,Nestle India,Britannia Industries,Tata Consumer Products',M:'Godrej Consumer Products,Dabur India,Marico,Colgate-Palmolive India,Varun Beverages,United Spirits,United Breweries,Patanjali Foods,Emami,Radico Khaitan,Bikaji Foods'},
'Automobile':{L:'Maruti Suzuki,Mahindra & Mahindra,Tata Motors,Bajaj Auto,Eicher Motors,Hero MotoCorp',M:'TVS Motor,Ashok Leyland,Bosch,Motherson Sumi Wiring,Samvardhana Motherson,MRF,Apollo Tyres,Balkrishna Industries,Bharat Forge,Sona BLW Precision,Exide Industries,Hyundai Motor India,Uno Minda,Escorts Kubota,Endurance Technologies'},
'Pharma & Healthcare':{L:'Sun Pharmaceutical,Cipla,Dr Reddys Laboratories,Apollo Hospitals',M:'Divis Laboratories,Lupin,Zydus Lifesciences,Torrent Pharmaceuticals,Mankind Pharma,Aurobindo Pharma,Alkem Laboratories,Biocon,Glenmark Pharma,Max Healthcare,Fortis Healthcare,Syngene International,Laurus Labs,Abbott India,Ipca Laboratories,Metropolis Healthcare,Dr Lal PathLabs,Narayana Hrudayalaya'},
'Metals & Mining':{L:'Tata Steel,JSW Steel,Hindalco Industries',M:'Vedanta,Jindal Steel & Power,Steel Authority of India,NMDC,National Aluminium,Hindustan Zinc,APL Apollo Tubes,Jindal Stainless,Welspun Corp'},
'Capital Goods & Infra':{L:'Larsen & Toubro,Bharat Electronics,Adani Ports,Adani Enterprises',M:'Siemens,ABB India,Hitachi Energy,CG Power,Cummins India,Bharat Heavy Electricals,Hindustan Aeronautics,Polycab India,Havells India,Thermax,Kalpataru Projects,KEC International,Dixon Technologies,Mazagon Dock,Cochin Shipyard,Container Corporation,IRCON,RVNL,Rail Vikas Nigam,GMR Airports,InterGlobe Aviation,Bharat Dynamics,Solar Industries,Kaynes Technology,Waaree Energies,Premier Energies,Inox Wind'},
'Realty':{L:'',M:'DLF,Godrej Properties,Macrotech Developers,Oberoi Realty,Prestige Estates,Phoenix Mills,Brigade Enterprises,Lodha Developers,Anant Raj'},
'Telecom & Media':{L:'Bharti Airtel',M:'Vodafone Idea,Indus Towers,Tata Communications,Sun TV Network,Zee Entertainment,PVR Inox,Info Edge,Nazara Technologies'},
'Retail & Consumer Durables':{L:'Titan Company,Trent,Eternal,Asian Paints',M:'Avenue Supermarts,Page Industries,Voltas,Blue Star,Crompton Greaves Consumer,Berger Paints,Kansai Nerolac,Pidilite Industries,Jubilant Foodworks,Devyani International,Nykaa,FSN E-Commerce,Paytm,One 97 Communications,PB Fintech,Swiggy,Bata India,Kalyan Jewellers,Vishal Mega Mart,Aditya Birla Fashion,Relaxo Footwears,Whirlpool of India,Havells,Metro Brands,Lenskart'},
'Chemicals & Materials':{L:'UltraTech Cement,Grasim Industries',M:'Ambuja Cements,ACC,Shree Cement,Dalmia Bharat,JK Cement,Ramco Cements,SRF,UPL,PI Industries,Aarti Industries,Deepak Nitrite,Tata Chemicals,Navin Fluorine,Atul,Coromandel International,Chambal Fertilisers,Supreme Industries,Astral,Linde India,Solar Industries,Gujarat Fluorochemicals,Vinati Organics'}};
const AL={sbi:'State Bank of India',hul:'Hindustan Unilever',lt:'Larsen & Toubro',mm:'Mahindra & Mahindra',tcs:'Tata Consultancy Services',infy:'Infosys',reliance:'Reliance Industries',ongc:'Oil & Natural Gas Corporation',zomato:'Eternal',sunpharma:'Sun Pharmaceutical',drreddy:'Dr Reddys Laboratories',drreddys:'Dr Reddys Laboratories',hdfc:'HDFC Bank',icici:'ICICI Bank',kotak:'Kotak Mahindra Bank',bel:'Bharat Electronics',hal:'Hindustan Aeronautics',bhel:'Bharat Heavy Electricals',lic:'LIC Housing Finance',bpcl:'Bharat Petroleum',ioc:'Indian Oil Corporation',jsw:'JSW Steel',tatamotorspassengervehicles:'Tata Motors',itc:'ITC',nestle:'Nestle India',britannia:'Britannia Industries',dlf:'DLF',titan:'Titan Company',adani:'Adani Enterprises',bajaj:'Bajaj Finance',pfc:'Power Finance Corporation'};
const nz=s=>String(s||'').toLowerCase().replace(/&/g,'and').replace(/\b(ltd|limited|the)\b/g,'').replace(/[^a-z0-9]/g,'');
const MAP={},NAMES=[];
Object.entries(D).forEach(([s,o])=>['L','M'].forEach(c=>o[c].split(',').filter(Boolean).forEach(n=>{const k=nz(n);if(!MAP[k]){MAP[k]={n,s,c};NAMES.push(n)}})));
Object.entries(AL).forEach(([a,n])=>{const m=MAP[nz(n)];if(m)MAP[nz(a)]=m});
const find=t=>MAP[nz(t)]||null;
const DEF=['FMCG & Consumption','Pharma & Healthcare','Power & Utilities','IT & Technology'],CYC=['Automobile','Metals & Mining','Capital Goods & Infra','Realty','Chemicals & Materials','Oil, Gas & Energy'];
const PF={rows:[{n:'',d:'',p:'',q:''},{n:'',d:'',p:'',q:''},{n:'',d:'',p:'',q:''}]};
const e=s=>String(s==null?'':s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const m=n=>'₹'+Math.round(n).toLocaleString('en-IN'),pc=n=>(Math.round(n*10)/10)+'%';
const HEAD='<div class="xhead"><h2>Stock Portfolio Analysis</h2><p>Nifty 500 Shares Analysis</p></div>',BK='<div style="margin-bottom:14px"><a class="btn small" href="#explore">← Back to Explore</a></div>';
const DISC='<b>Risk–return disclosure:</b> Equity shares carry market risk. Prices can rise or fall, and you can lose part or all of your capital. Past performance and past growth do not guarantee future returns. Higher expected return always comes with higher risk. <b>This is an AI-generated educational analysis, not investment advice or a recommendation to buy, hold or sell any share.</b> The tool is not a SEBI-registered investment adviser. Please consult a SEBI-registered investment adviser before you decide.';
const row=r=>`<tr><td class="nm"><span class="ml">Name of Shares</span><div class="in"><input class="pn" list="pf-dl" maxlength="60" value="${e(r.n)}" placeholder="e.g. HDFC Bank" aria-label="Name of share"></div></td><td><span class="ml">Purchase Date</span><div class="in"><input class="pd" type="date" max="${new Date().toISOString().slice(0,10)}" value="${e(r.d)}" aria-label="Purchase date"></div></td><td><span class="ml">Buying Price (₹ per share)</span><div class="in"><i class="cs">₹</i><input class="pp" type="number" inputmode="decimal" min="0" step="any" placeholder="0" value="${e(r.p)}" aria-label="Buying price"></div></td><td><span class="ml">Qty</span><div class="in"><input class="pq" type="number" inputmode="numeric" min="0" step="any" placeholder="0" value="${e(r.q)}" aria-label="Quantity"></div></td><td><span class="ml">Value (Qty × Buying Price)</span><span class="xe pvv">${pv(r)}</span></td><td class="xd"><button class="btn small" type="button" data-prm aria-label="Remove">✕</button></td></tr>`;
function pv(r){const v=parseFloat(r.p)*parseFloat(r.q);return v>0?m(v):'₹0'}
function rd(){return[...document.querySelectorAll('#pb tr')].map(t=>{const p=t.querySelector('.pp').value,q=t.querySelector('.pq').value,v=parseFloat(p)*parseFloat(q);t.querySelector('.pvv').textContent=v>0?m(v):'₹0';return{n:t.querySelector('.pn').value.trim(),d:t.querySelector('.pd').value,p,q,v:v>0?String(v):''}})}
function analyse(){
const raw=rd().filter(r=>r.n&&parseFloat(r.v)>0),out=document.getElementById('pr');
if(!raw.length){out.innerHTML='<div class="pfn">Please add at least one share name with its value, then press Analyse.</div>';return}
const mg={};raw.forEach(r=>{const f=find(r.n),k=f?f.n:r.n;(mg[k]=mg[k]||{n:k,f,v:0,pv:0,sh:0,ds:[]});const v=parseFloat(r.v),q=parseFloat(r.q);mg[k].v+=v;mg[k].sh+=q;mg[k].pv+=v;if(r.d)mg[k].ds.push([r.d,v])});
const H=Object.values(mg),T=H.reduce((a,x)=>a+x.v,0);
H.forEach(x=>{x.w=x.v/T*100;x.s=x.f?x.f.s:'Unclassified';x.c=x.f?(x.f.c==='L'?'Large cap':'Mid cap'):'—';x.avg=x.pv>0?x.pv/x.sh:0});H.sort((a,b)=>b.v-a.v);
const sec={};H.forEach(x=>sec[x.s]=(sec[x.s]||0)+x.w);const SE=Object.entries(sec).sort((a,b)=>b[1]-a[1]);
const n=H.length,top1=H[0].w,top3=H.slice(0,3).reduce((a,x)=>a+x.w,0),lg=H.filter(x=>x.c==='Large cap').reduce((a,x)=>a+x.w,0),md=H.filter(x=>x.c==='Mid cap').reduce((a,x)=>a+x.w,0),un=H.filter(x=>!x.f),df=SE.filter(s=>DEF.includes(s[0])).reduce((a,s)=>a+s[1],0),cy=SE.filter(s=>CYC.includes(s[0])).reduce((a,s)=>a+s[1],0);
const now=Date.now(),yr=365*864e5;let rec=0,dw=0,dt=0;H.forEach(x=>x.ds.forEach(([d,v])=>{const t=new Date(d).getTime();if(!isNaN(t)){dt+=v;dw+=v*(now-t)/yr;if(now-t<yr)rec+=v}}));
const G=[],B=[],W=[];
if(n>=10&&n<=25)G.push(`You hold ${n} stocks, a range many investors find manageable and reasonably diversified.`);
if(top1<=15&&n>=5)G.push(`No single stock is above ${pc(top1)}, so one bad result will not hurt much.`);
if(SE.length>=5&&SE[0][1]<=30)G.push(`Your money is spread across ${SE.length} sectors, with the largest at ${pc(SE[0][1])}.`);
if(lg>=40)G.push(`${pc(lg)} sits in large caps, which are usually less volatile than smaller companies.`);
if(df>=15&&cy>=15)G.push('You have a mix of defensive sectors (FMCG, Pharma, IT, Utilities) and cyclical sectors (Auto, Metals, Infra). This can smooth ups and downs.');
if(dt>0&&dw/(dt/T)>=3)G.push('Much of your money has been invested for 3+ years, which suits equity better than short-term holding.');
if(G.length<2)G.push('You are tracking your portfolio and looking at its structure. That is a good habit.');
if(n<10)W.push(`Only ${n} stock${n>1?'s':''}. With fewer than 10 stocks, one company can swing your whole portfolio.`);
if(n>30)B.push(`${n} stocks is hard to track. Many small positions can dilute your best ideas and behave like an index fund with higher effort.`);
if(top1>20)W.push(`${H[0].n} is ${pc(top1)} of your portfolio. A single stock above 20% is a concentration risk.`);
else if(top3>50)W.push(`Your top 3 stocks make up ${pc(top3)} of the portfolio. Results depend on just a few companies.`);
SE.filter(s=>s[1]>30&&s[0]!=='Unclassified').forEach(s=>W.push(`${s[0]} is ${pc(s[1])} of your portfolio. A policy or cycle change in one industry can hit many holdings together.`));
if(n>=8&&SE.length<4)W.push(`${n} stocks but only ${SE.length} sector${SE.length>1?'s':''}. Owning many stocks in the same industry is not real diversification.`);
if(md>60)W.push(`${pc(md)} is in mid/small-size companies. These can give higher growth but fall much harder in weak markets.`);
if(lg>=95&&n>=3)B.push('Almost all of your money is in large caps. This is steady, but you may be giving up some growth from mid-size companies.');
if(cy>60)W.push(`${pc(cy)} sits in cyclical sectors (Auto, Metals, Infra, Energy, Realty, Chemicals). Earnings of these swing with the economy.`);
if(df<10&&n>=5)B.push(`Only ${pc(df)} is in defensive sectors (FMCG, Pharma, IT, Utilities). Adding some can reduce shocks in a falling market.`);
if(SE.some(s=>s[0]==='Financial Services'&&s[1]>=25)&&SE[0][0]==='Financial Services')B.push('Banks, NBFCs and insurers move together with interest rates and credit cycles, so treat them as one risk.');
if(un.length)B.push(`${un.map(x=>e(x.n)).join(', ')} could not be matched to our Nifty 500 list. Check the spelling, or it may be outside Nifty 500, so it is left out of sector analysis.`);
if(dt>0&&rec/dt>.6)B.push(`${pc(rec/dt*100)} of your money was invested in the last 12 months. A short history means your results are not yet tested across market cycles.`);
B.push('Invest in stages (monthly or quarterly) and review once or twice a year instead of reacting to daily prices.');
if(!W.length)W.push('No major structural issue found from the numbers you entered. Company-level risks can still exist.');
const L=(c,h,a)=>`<div class="xg ${c}"><h4>${h}</h4><ul>${a.slice(0,5).map(x=>`<li>${x}</li>`).join('')}</ul></div>`;
const hold=H.map(x=>`<tr><td class="nm"><span class="ml">Share</span><span class="xnm">${e(x.n)}</span></td><td><span class="ml">Sector</span>${e(x.s)}</td><td><span class="ml">Segment</span>${x.c}</td><td><span class="ml">Avg Buy Price</span>${x.avg?'₹'+(Math.round(x.avg*100)/100).toLocaleString('en-IN'):'—'}</td><td><span class="ml">Value</span><span class="xe">${m(x.v)}</span></td><td><span class="ml">Weight</span><div class="pfbar${x.w>20?' hi':''}"><i style="width:${Math.min(100,x.w)}%"></i></div><small>${pc(x.w)}</small></td></tr>`).join('');
const secr=SE.map(s=>`<tr><td class="nm"><span class="ml">Sector</span><span class="xnm">${e(s[0])}</span></td><td><span class="ml">Weight</span>${pc(s[1])}</td><td><div class="pfbar${s[1]>30&&s[0]!=='Unclassified'?' hi':''}"><i style="width:${Math.min(100,s[1])}%"></i></div></td></tr>`).join('');
const SK=SE.filter(s=>s[0]!=='Unclassified'),mx=SK.length?SK[0][1]:100,unW=un.reduce((a,x)=>a+x.w,0);
const sc1=n>30?15:n>=15?20:n>=10?16:n>=7?12:n>=5?8:n>=3?5:2;
let sc2=top1<=10?20:top1<=15?16:top1<=20?12:top1<=30?7:3;if(top3>60)sc2=Math.max(0,sc2-3);
let sc3=mx<=20?25:mx<=25?21:mx<=30?17:mx<=40?10:4;if(SK.length<3)sc3=Math.min(sc3,8);else if(n>=8&&SK.length<4)sc3=Math.max(0,sc3-5);
const sc4=md>60&&md<=80?7:md>80?4:lg>=95?10:lg>=30?15:8;
const sc5=df>=15&&cy<=60?10:cy>60&&df<10?2:df>=10?7:5;
let sc6=dt>0?(rec/dt<=.4?10:rec/dt<=.6?7:4):5;sc6=Math.max(0,sc6-Math.round(unW/10));
const SCR=[['Number of stocks',sc1,20],['Single-stock concentration',sc2,20],['Sector spread',sc3,25],['Large / mid cap balance',sc4,15],['Defensive vs cyclical mix',sc5,10],['Holding history & data match',sc6,10]],TOT=Math.max(0,Math.min(100,SCR.reduce((a,x)=>a+x[1],0)));
const LB=TOT>=80?['Strong structure','#059669']:TOT>=65?['Good, can improve','#0F766E']:TOT>=50?['Average, needs attention','#D97706']:['Weak, high structural risk','#D9342B'];
const sbox=`<div class="pfsc"><div class="pfring" style="--c:${LB[1]};--p:${TOT}"><b>${TOT}</b><small>/ 100</small></div><div><h3 class="pfh" style="margin:0 0 4px">Portfolio Score: <span style="color:${LB[1]}">${LB[0]}</span></h3><p class="pfs" style="margin:0 0 10px">AI score on the shares you entered, based on spread, concentration and balance. It does not judge company quality, valuation or future returns.</p><div class="xtw"><table class="xtab" style="min-width:0"><thead><tr><th>Factor</th><th>Score</th></tr></thead><tbody>${SCR.map(x=>`<tr><td class="nm"><span class="ml">Factor</span>${x[0]}</td><td><span class="ml">Score</span><b>${x[1]}</b> / ${x[2]}</td></tr>`).join('')}</tbody></table></div></div></div>`;
out.innerHTML=`<div class="pfk"><div><small>Total value</small><b>${m(T)}</b></div><div><small>Stocks</small><b>${n}</b></div><div><small>Sectors</small><b>${SE.filter(s=>s[0]!=='Unclassified').length}</b></div><div><small>Top stock weight</small><b>${pc(top1)}</b></div><div><small>Large / Mid cap</small><b>${Math.round(lg)}% / ${Math.round(md)}%</b></div></div>
<div class="pfn">${DISC}</div>
${sbox}
<h3 class="pfh">1. Diversification &amp; Portfolio Health</h3><div class="xg3">${L('g','✅ What is good',G)}${L('b','💡 What can be better',B)}${L('w','⚠️ What is wrong / risky',W)}</div>
<h3 class="pfh">Your holdings</h3><div class="xtw"><table class="xtab"><thead><tr><th>Share</th><th>Sector</th><th>Segment</th><th>Avg Buy Price</th><th>Value</th><th>Weight</th></tr></thead><tbody>${hold}</tbody></table></div>
<h3 class="pfh">Sector allocation</h3><div class="xtw"><table class="xtab" style="min-width:0"><thead><tr><th>Sector</th><th>Weight</th><th>Share of portfolio</th></tr></thead><tbody>${secr}</tbody></table></div>
<h3 class="pfh">2. AI Insight: What to check when choosing a good stock</h3>
<ol class="pfl"><li><b>Growth quality:</b> Sales and profit growing for 4+ quarters in a row, with profit growing at least as fast as sales. Sales falling while profit rises can mean one-time gains.</li><li><b>Profitability:</b> ROE and ROCE consistently above about 15%, and healthy operating margins compared with peers.</li><li><b>Debt:</b> Low debt-to-equity and interest cover above 3x. Banks and NBFCs need a different check: asset quality (NPA) and capital adequacy.</li><li><b>Cash flow:</b> Operating cash flow should broadly match profit. Profit without cash is a warning.</li><li><b>Valuation:</b> Compare P/E with the company's own history and with peers. A great company at a very high price can still give poor returns.</li><li><b>Promoter &amp; governance:</b> Stable or rising promoter holding, low pledging, clean audit record and honest management communication.</li><li><b>Business strength:</b> A clear moat (brand, scale, cost edge), a growing industry and not dependent on one customer or one product.</li><li><b>Size &amp; liquidity:</b> Smaller companies can grow faster but fall harder and can be hard to sell. Match size to your risk comfort.</li><li><b>Portfolio fit:</b> Before buying, check that the new stock does not push one sector above about 25–30% or one stock above about 10–15%.</li></ol>
<div class="pfd">${DISC}<br><br><b>Data note:</b> Sector and segment tags are indicative and may change. Analysis uses only the values you entered. Calculations run in your browser.</div>`;
out.scrollIntoView({behavior:'smooth',block:'start'})}
function render(){const el=document.getElementById('v-explore');
if(typeof USER==='undefined'||!USER){el.innerHTML=BK+'<div class="xcard">'+HEAD+'<div class="xgate"><h3>Login or sign up to continue</h3><p>It takes a minute. Then your portfolio table opens right away.</p><div class="row"><button class="btn go lg" type="button" data-xlogin="su">Sign up</button><button class="btn lg" type="button" data-xlogin="li">Login</button></div></div></div>';scrollTo(0,0);return}
el.innerHTML=BK+`<div class="xcard">${HEAD}<div class="xbody"><div class="pfn">Add the Nifty 500 shares you own. Start typing a company name to pick it from the list. <b>Value</b> is filled automatically as Qty × Buying Price. We then give a simple AI analysis. <b>Educational only. Not investment advice.</b></div><div class="xtw"><table class="xtab" style="min-width:860px"><thead><tr><th>Name of Shares</th><th>Purchase Date</th><th>Buying Price (₹)</th><th>Qty</th><th>Value (Qty × Price)</th><th aria-label="Remove"></th></tr></thead><tbody id="pb">${PF.rows.map(row).join('')}</tbody></table></div><datalist id="pf-dl">${NAMES.map(x=>`<option value="${e(x)}">`).join('')}</datalist><div class="row xadd"><button class="btn small" type="button" data-padd>+ Add another share</button><button class="btn go small" type="button" data-pgo>✨ Analyse my portfolio</button></div><div id="pr"></div></div></div>`;scrollTo(0,0)}
const ex=document.getElementById('v-explore'),_r=window.renderExplore;
window.renderExplore=function(sub){if(sub==='portfolio'){render();return}_r(sub);if(sub!=='returns'){const g=ex.querySelector('.xgrid');if(g)g.insertAdjacentHTML('beforeend','<a class="xtile" href="#explore/portfolio"><h3>Stock Portfolio Analysis</h3><p>Nifty 500 Shares Analysis</p><span class="go">Open →</span></a>')}};
ex.addEventListener('click',t=>{const x=t.target;
if(x.closest('[data-padd]')){PF.rows=rd();const b=document.getElementById('pb');b.insertAdjacentHTML('beforeend',row({n:'',d:'',p:'',q:''}));b.lastElementChild.querySelector('.pn').focus();return}
if(x.closest('[data-prm]')){const r=x.closest('tr');if(document.querySelectorAll('#pb tr').length>1)r.remove();else r.querySelectorAll('input').forEach(i=>i.value='');return}
if(x.closest('[data-pgo]')){PF.rows=rd();analyse()}});
ex.addEventListener('input',t=>{if(t.target.closest('#pb'))PF.rows=rd()});
if(/^#explore\/portfolio/.test(location.hash))route();
else if(/^#explore\/?$/.test(location.hash))route();
})();
</script>
<style id="tx-css">
.tg{display:grid;gap:14px;grid-template-columns:repeat(auto-fit,minmax(230px,1fr))}
.tf label{display:block;font-size:13px;font-weight:600;margin:0 0 4px;color:var(--ink)}
.tf small{display:block;margin-top:3px;color:var(--mu);font-size:12px}
.tf select{width:100%;min-height:44px}
.txb{display:grid;gap:10px;margin:0;padding:0;list-style:none}
.txb li{display:flex;justify-content:space-between;gap:12px;padding:9px 12px;border-radius:10px;background:var(--so);font-size:14.5px}
.txb li b{font-variant-numeric:tabular-nums;white-space:nowrap}.txb li.t{background:#FBF3DC;font-weight:700}
.txh{padding:16px 18px;border-radius:16px;margin:0 0 16px;border:1px solid var(--ln);background:var(--sf);display:flex;gap:18px;align-items:center;flex-wrap:wrap}
.txh .big{font:700 34px/1 var(--h);color:var(--c)}.txh p{margin:4px 0 0;color:var(--mu);font-size:14px}
</style>
<script id="tx-js">
(function(){
const e=s=>String(s==null?'':s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const m=n=>(n<0?'-':'')+'₹'+Math.round(Math.abs(n)).toLocaleString('en-IN'),pc=n=>(Math.round(n*10)/10)+'%';
const NS=[[4e5,0],[8e5,.05],[12e5,.1],[16e5,.15],[2e6,.2],[24e5,.25],[Infinity,.3]],OS=[[25e4,0],[5e5,.05],[1e6,.2],[Infinity,.3]];
const SUR={n:[[5e6,.1],[1e7,.15],[2e7,.25]],o:[[5e6,.1],[1e7,.15],[2e7,.25],[5e7,.37]]};
const slab=(N,S)=>{let t=0,lo=0;for(const[h,r]of S){if(N>lo)t+=(Math.min(N,h)-lo)*r;lo=h}return t};
function base(N,ST,LT,R,g){const ex=R==='n'?4e5:25e4;let st=ST,lt=LT;
if(g.res){let sh=Math.max(0,ex-N);const a=Math.min(sh,st);st-=a;sh-=a;lt-=Math.min(sh,lt)}
const sl=slab(N,R==='n'?NS:OS),tot=N+ST+LT;let reb=0;
if(g.res){const lim=R==='n'?12e5:5e5,cap=R==='n'?6e4:12500;if(tot<=lim)reb=Math.min(sl,cap);else if(R==='n')reb=Math.min(sl,Math.max(0,sl-(tot-lim)))}
const nt=sl-reb,stT=st*.2,ltT=lt*.125;return{sl,reb,nt,stT,ltT,b:nt+stT+ltT,tot}}
function full(N,ST,LT,R,g){const b=base(N,ST,LT,R,g),T=SUR[R],tot=N+ST+LT;let i=-1;T.forEach((x,k)=>{if(tot>x[0])i=k});let sur=0;
if(i>=0){const r=T[i][1],p=i>0?T[i-1][1]:0;sur=b.nt*r+(b.stT+b.ltT)*Math.min(r,.15);const x=tot-T[i][0],nN=Math.max(0,N-x);let rem=x-(N-nN);const nS=Math.max(0,ST-rem);rem-=ST-nS;const nL=Math.max(0,LT-rem),b0=base(nN,nS,nL,R,g),lim=b0.b+b0.nt*p+(b0.stT+b0.ltT)*Math.min(p,.15)+x;if(b.b+sur>lim)sur=Math.max(0,lim-b.b)}
const cess=(b.b+sur)*.04;return{...b,sur,cess,tax:b.b+sur+cess}}
function prep(o,R){const std=R==='n'?75000:50000,S=o.sal>0?Math.min(o.sal,std):0;let hp=o.rent*.7-o.rint;hp=R==='n'?Math.max(0,hp):Math.max(-2e5,hp);
const bs=o.basic>0?o.basic:o.sal*.5,nd=Math.min(o.nps,.14*bs),N=Math.max(0,o.sal-S+o.biz+hp+o.intr+o.div+o.oth-nd-(R==='o'?o.od:0));
return{N,ST:o.stcg,LT:Math.max(0,o.ltcg-125000),S,hp,nd,bs}}
const calc=(o,R)=>{const p=prep(o,R);return{p,r:full(p.N,p.ST,p.LT,R,{res:o.res})}};
const F=[['sal','Salary / Pension (gross, a year)','Before standard deduction'],['basic','Basic + DA (a year)','Used to cap employer NPS at 14%'],['nps','Employer NPS contribution (a year)','Section 80CCD(2)'],['biz','Business / Profession income (net)','After business expenses'],['rent','Rent received (a year)','30% standard deduction is applied'],['rint','Home loan interest (let-out house)','Loss cannot be set off in New Regime'],['intr','Interest income','Savings, FD, bonds'],['div','Dividend income','Taxed at your slab rate'],['oth','Other income','Taxed at your slab rate'],['stcg','Short-term gain, listed equity','Taxed at 20% (STT paid)'],['ltcg','Long-term gain, listed equity','₹1.25 lakh exempt, then 12.5%'],['tds','TDS / advance tax already paid','Reduces what you pay now'],['od','Old Regime deductions (optional)','80C, 80D, HRA, home loan etc. Only for comparison']];
const V={res:'1'};let LAST=null;
const grp=(t,a)=>`<h3 class="pfh">${t}</h3><div class="tg">${a.map(k=>{const f=F.find(x=>x[0]===k);return`<div class="tf"><label for="t-${k}">${f[1]}</label><div class="in"><i class="cs">₹</i><input id="t-${k}" data-t="${k}" type="number" inputmode="decimal" min="0" step="any" placeholder="0" value="${e(V[k]||'')}"></div><small>${f[2]}</small></div>`}).join('')}</div>`;
const HEAD='<div class="xhead"><h2>Income Tax Calculator</h2><p>New Tax Regime · FY 2026-27 (AY 2027-28)</p></div>',BK='<div style="margin-bottom:14px"><a class="btn small" href="#explore">← Back to Explore</a></div>';
const DISC='<b>Disclaimer:</b> This is an AI-assisted estimate for learning. It is <b>not tax, legal or investment advice</b>. Actual tax depends on your full facts, employer and bank records, and the law at the time you file. Rates here follow the New Regime as of FY 2026-27 (Budget 2026 made no slab change). Not covered: other capital gains (property, debt funds, gold), crypto, foreign income, AMT and special cases. Please check with a Chartered Accountant before filing.';
function get(){const g=k=>parseFloat(V[k])||0;return{res:V.res==='1',sal:g('sal'),basic:g('basic'),nps:g('nps'),biz:g('biz'),rent:g('rent'),rint:g('rint'),intr:g('intr'),div:g('div'),oth:g('oth'),stcg:g('stcg'),ltcg:g('ltcg'),tds:g('tds'),od:g('od')}}
function run(){const o=get(),out=document.getElementById('txo');
const gross=o.sal+o.biz+o.rent+o.intr+o.div+o.oth+o.stcg+o.ltcg;
if(gross<=0){LAST=null;out.innerHTML='<div class="pfn">Enter your income above. The result updates as you type.</div>';return}
const{p,r}=calc(o,'n'),tax=r.tax,tt=p.N+p.ST+p.LT,eff=gross>0?tax/gross*100:0,pay=tax-o.tds;
const sl=[];let lo=0;NS.forEach(([h,rt])=>{const inc=Math.max(0,Math.min(p.N,h)-lo);if(inc>0)sl.push([lo,h,rt,inc,inc*rt]);lo=h});
const slr=sl.map(x=>`<tr><td class="nm"><span class="ml">Slab</span>${x[1]===Infinity?'Above '+m(x[0]):m(x[0])+' – '+m(x[1])}</td><td><span class="ml">Rate</span>${pc(x[2]*100)}</td><td><span class="ml">Income in slab</span>${m(x[3])}</td><td><span class="ml">Tax</span><b>${m(x[4])}</b></td></tr>`).join('');
const rows=[['Gross income (all sources)',gross],['Less: standard deduction (salary)',-p.S],['Less: employer NPS 80CCD(2)',-p.nd],['Taxable income (slab rates)',p.N],p.ST>0?['Short-term gain taxed at 20%',p.ST]:null,p.LT>0?['Long-term gain above ₹1.25 lakh, taxed at 12.5%',p.LT]:null,['Tax on slabs',r.sl],r.reb>0?['Less: rebate / marginal relief (87A)',-r.reb]:null,r.stT+r.ltT>0?['Tax on capital gains',r.stT+r.ltT]:null,r.sur>0?['Surcharge',r.sur]:null,['Health & Education Cess (4%)',r.cess]].filter(Boolean);
const bd=rows.map(x=>`<li><span>${x[0]}</span><b>${m(x[1])}</b></li>`).join('')+`<li class="t"><span>Total tax</span><b>${m(tax)}</b></li>`;
const hl=p.N<=0&&tax<=0?'Nil':m(tax);const col=tax<=0?'#059669':eff>20?'#D9342B':eff>10?'#D97706':'#0F766E';
const G=[],B=[],W=[];
const z=o.res&&r.reb>0&&r.nt<=0;
if(tax<=0)G.push(o.res?'Your tax is nil. The Section 87A rebate cancels the slab tax when taxable income is up to ₹12 lakh.':'Your tax is nil on these numbers.');
if(o.sal>0&&tax<=0)G.push('A salaried person with no other income pays zero tax up to a gross salary of about ₹12.75 lakh (₹12 lakh + ₹75,000 standard deduction).');
if(p.nd>0)G.push(`Employer NPS of ${m(p.nd)} is already cutting your taxable income.`);
if(eff>0&&eff<=10)G.push(`Your overall tax rate is ${pc(eff)} of income, which is moderate.`);
if(!G.length)G.push('You have entered your income. Knowing your tax early helps you plan, and that is a good habit.');
const m1=full(...(()=>{const q=prep({...o,oth:o.oth+1e5},'n');return[q.N,q.ST,q.LT,'n',{res:o.res}]})()).tax-tax;
B.push(`Your next ₹1 lakh of income would be taxed at about ${pc(m1/1e3)} (including cess).`);
if(o.sal>0){const pot=Math.max(0,.14*p.bs-p.nd);if(pot>1e3){const q=prep({...o,nps:o.nps+pot},'n'),sv=tax-full(q.N,q.ST,q.LT,'n',{res:o.res}).tax;if(sv>500)B.push(`If your employer offers NPS, up to ${m(p.bs*.14)} (14% of basic${o.basic>0?'':', assumed 50% of salary'}) is deductible. Using ${m(pot)} more could save about ${m(sv)}.`)}}
const od=calc({...o},'o').r.tax;let lo2=0,hi=5e6;const at=d=>calc({...o,od:d},'o').r.tax;
if(at(hi)>=tax)B.push('Old Regime is unlikely to beat the New Regime for you, even with very large deductions.');
else{for(let i=0;i<40;i++){const mid=(lo2+hi)/2;if(at(mid)>tax)lo2=mid;else hi=mid}B.push(`Old Regime would be cheaper only if your deductions and exemptions (80C, 80D, HRA, home loan interest etc.) total about ${m(hi)} or more.`)}
if(o.od>0){const d=od-tax;B.push(d>0?`With your ${m(o.od)} of deductions, the New Regime is cheaper by about ${m(d)}.`:`With your ${m(o.od)} of deductions, the Old Regime would be cheaper by about ${m(-d)}.`)}
if(tt>12e5&&tt<13e5&&o.res&&p.ST+p.LT===0)B.push('You are in the marginal relief zone just above ₹12 lakh. Tax here is capped at the amount above ₹12 lakh.');
if(o.res&&tt<=12e5&&p.N>0&&p.ST+p.LT===0)B.push(`You are ${m(12e5-tt)} below the ₹12 lakh limit for full rebate. Extra income beyond it loses the rebate quickly.`);
if(pay>=1e4)B.push('Tax payable after TDS is ₹10,000 or more, so pay advance tax: 15% by 15 Jun, 45% by 15 Sep, 75% by 15 Dec, 100% by 15 Mar.');
if(!o.res)W.push('The Section 87A rebate is only for resident individuals. It is not applied to your tax.');
if(p.ST+p.LT>0)W.push('Rebate does not apply to short-term and long-term equity gains. They are taxed at special rates on top of slab tax.');
if(o.biz>0)W.push('For business or professional income, opting for the New Regime and later switching back has restrictions. Check this with a CA.');
if(o.rent*.7-o.rint<0)W.push('Home loan interest on a let-out house gives no loss set-off in the New Regime, so the excess interest is ignored here.');
if(o.sal>0&&!o.basic&&o.nps>0)W.push('Basic salary was not entered, so the NPS limit assumes basic is 50% of salary. Enter it for a better result.');
if(o.intr+o.div>0&&o.tds<=0)W.push('You have interest or dividend income but no TDS entered. Check your Form 26AS / AIS so nothing is missed.');
if(r.sur>0)W.push('Surcharge applies at your income level. It is already included.');
if(!W.length)W.push('No major issue found. Always match with your Form 16 and AIS before filing.');
const L=(c,h,a)=>`<div class="xg ${c}"><h4>${h}</h4><ul>${a.slice(0,5).map(x=>`<li>${x}</li>`).join('')}</ul></div>`;
LAST={o,gross,tt,tax,eff,pay,p,r,rows,sl,G,B,W};
out.innerHTML=`<div class="txh" style="--c:${col}"><div><small style="color:var(--mu);font-weight:600">Total tax for the year</small><div class="big">${hl}</div></div><p>${tax<=0?'No tax to pay on this income.':`Effective rate ${pc(eff)} · about ${m(tax/12)} a month`}</p></div>
<div class="row" style="margin:0 0 16px"><button class="btn go small" type="button" data-txpdf>⬇ Download Computation PDF</button></div><div class="pfk"><div><small>Gross income</small><b>${m(gross)}</b></div><div><small>Taxable income</small><b>${m(tt)}</b></div><div><small>Income after tax (monthly)</small><b>${m((gross-tax)/12)}</b></div><div><small>${pay>=0?'Balance tax to pay':'Refund expected'}</small><b>${m(Math.abs(pay))}</b></div></div>
<h3 class="pfh">How your tax is calculated</h3><ul class="txb">${bd}</ul>
${sl.length?`<h3 class="pfh">Slab-wise tax (New Regime)</h3><div class="xtw"><table class="xtab" style="min-width:0"><thead><tr><th>Slab</th><th>Rate</th><th>Income in slab</th><th>Tax</th></tr></thead><tbody>${slr}</tbody></table></div>`:''}
<div class="xaiw"><h3>✨ AI Insights</h3><div class="xg3">${L('g','✅ What is good',G)}${L('b','💡 What can be better',B)}${L('w','⚠️ What to watch',W)}</div></div>
<div class="pfd">${DISC}</div>`}
function render(){const el=document.getElementById('v-explore');
if(typeof USER==='undefined'||!USER){el.innerHTML=BK+'<div class="xcard">'+HEAD+'<div class="xgate"><h3>Login or sign up to continue</h3><p>It takes a minute. Then your tax calculator opens right away.</p><div class="row"><button class="btn go lg" type="button" data-xlogin="su">Sign up</button><button class="btn lg" type="button" data-xlogin="li">Login</button></div></div></div>';scrollTo(0,0);return}
el.innerHTML=BK+`<div class="xcard">${HEAD}<div class="xbody"><div class="pfn">Enter your yearly income in ₹. The tax updates as you type. Rates: ₹0–4L nil, 4–8L 5%, 8–12L 10%, 12–16L 15%, 16–20L 20%, 20–24L 25%, above 24L 30%, plus 4% cess. Standard deduction ₹75,000 for salary or pension. <b>Educational only. Not tax advice.</b></div>
<div class="tg"><div class="tf"><label for="t-res">Residential status</label><select class="sel" id="t-res" data-t="res"><option value="1"${V.res==='1'?' selected':''}>Resident individual</option><option value="0"${V.res==='0'?' selected':''}>Non-resident individual</option></select><small>Rebate 87A is for residents only</small></div></div>
${grp('Salary & NPS',['sal','basic','nps'])}${grp('Other income',['biz','rent','rint','intr','div','oth'])}${grp('Capital gains (listed equity)',['stcg','ltcg'])}${grp('Taxes paid & comparison',['tds','od'])}
<div id="txo" style="margin-top:22px"></div></div></div>`;run();scrollTo(0,0)}
const pm=n=>{const a='Rs. '+Math.round(Math.abs(n)).toLocaleString('en-IN');return n<0?'('+a+')':a};
const cl=t=>String(t).replace(/<[^>]+>/g,'').replace(/₹/g,'Rs. ').replace(/&amp;/g,'&').replace(/&#39;/g,"'").replace(/[^\x20-\x7E\u2013\u2014\u00B7]/g,'').replace(/\s+/g,' ').trim();
function txPdf(){
if(!window.jspdf){toast('PDF library could not load. Check your connection.');return}
if(!LAST){toast('Enter your income first.');return}
const doc=new jspdf.jsPDF({unit:'pt',format:'a4'});
if(typeof doc.autoTable!=='function'){toast('PDF table library could not load. Check your connection.');return}
const{o,gross,tt,tax,eff,pay,r,rows,sl}=LAST,NV=[7,30,54],TL=[15,118,110],GD=[201,162,75],INK=[20,33,61],MU=[85,98,122],PW=595,ML=40,CW=515,GR=[5,150,105],AMB=[217,119,6],RD=[200,50,45];
const T=(t,x,y,z,c,b,op)=>{doc.setFont('helvetica',b?'bold':'normal');doc.setFontSize(z);doc.setTextColor(...c);doc.text(String(t),x,y,op)};
let y=0;const need=h=>{if(y+h>792){doc.addPage();y=76}};
/* header */
doc.setFillColor(...NV);doc.rect(0,0,PW,96,'F');doc.setFillColor(...GD);doc.rect(0,96,PW,4,'F');doc.setFillColor(...TL);doc.rect(0,96,170,4,'F');
T('RetirementPlanKaro.com',ML,48,23,[255,255,255],1);T('Retirement Planner for India',ML,67,10,[243,223,162]);
const nm=(typeof who==='function'&&who())||'';T('Prepared for',PW-ML,40,8.5,[170,190,210],0,{align:'right'});T(nm||'You',PW-ML,54,12,[255,255,255],1,{align:'right'});T(new Date().toLocaleDateString('en-IN',{day:'numeric',month:'long',year:'numeric'}),PW-ML,70,9,[243,223,162],0,{align:'right'});
T('Income Tax Computation',ML,136,24,NV,1);T('New Tax Regime  |  FY 2026-27 (AY 2027-28)  |  '+(o.res?'Resident':'Non-resident')+' Individual',ML,154,10.5,[150,115,35]);
/* KPI tiles */
const K=[['GROSS INCOME',pm(gross),NV],['TAXABLE INCOME',pm(tt),TL],['TOTAL TAX',pm(tax),tax>0?RD:GR],[pay>=0?'BALANCE TAX PAYABLE':'REFUND EXPECTED',pm(Math.abs(pay)),[150,115,35]]],kw=(CW-30)/4;
K.forEach((k,i)=>{const x=ML+i*(kw+10);doc.setFillColor(241,247,247);doc.roundedRect(x,170,kw,56,8,8,'F');doc.setFillColor(...GD);doc.roundedRect(x,170,4,56,2,2,'F');T(k[0],x+14,188,7,MU,1);T(k[1],x+14,212,k[1].length>13?11.5:14,k[2],1)});
T('Effective tax rate '+(Math.round(eff*10)/10)+'% of gross income'+(tax>0?'  |  about '+pm(tax/12)+' a month':'  |  no tax payable'),ML,246,9.5,MU);
y=268;
const sec=t=>{need(80);T(t,ML,y,12.5,NV,1);doc.setDrawColor(...GD);doc.setLineWidth(1.6);doc.line(ML,y+5,ML+44,y+5);y+=14};
const tbl=(head,body,foot,right)=>{doc.autoTable({startY:y,head:[head],body,foot:foot||undefined,showFoot:'lastPage',theme:'plain',margin:{left:ML,right:ML,top:62,bottom:50},styles:{font:'helvetica',fontSize:9.5,cellPadding:{top:5,bottom:5,left:8,right:8},textColor:INK,lineColor:[226,236,237],lineWidth:{bottom:.5}},headStyles:{fillColor:TL,textColor:255,fontStyle:'bold',lineWidth:0},footStyles:{fillColor:[251,243,220],textColor:NV,fontStyle:'bold',lineWidth:0},alternateRowStyles:{fillColor:[248,251,251]},didParseCell:d=>{if(right.includes(d.column.index))d.cell.styles.halign='right'}});y=doc.lastAutoTable.finalY+22};
/* 1 income */
const inc=[['Salary / Pension',o.sal],['Business / Profession (net)',o.biz],['Rent received',o.rent],['Interest income',o.intr],['Dividend income',o.div],['Other income',o.oth],['Short-term gain, listed equity',o.stcg],['Long-term gain, listed equity',o.ltcg]].filter(x=>x[1]>0).map(x=>[x[0],pm(x[1])]);
sec('1. Income details');tbl(['Income source','Amount'],inc,[['Gross total income',pm(gross)]],[1]);
/* 2 computation */
const cb=rows.map(x=>[cl(x[0]),pm(x[1])]),ft=[['Total tax payable (incl. cess)',pm(tax)]];if(o.tds>0)ft.push(['Less: TDS / advance tax paid',pm(-o.tds)]);ft.push([pay>=0?'Balance tax payable':'Refund expected',pm(Math.abs(pay))]);
sec('2. Tax computation');tbl(['Particulars','Amount'],cb,ft,[1]);
/* 3 slabs */
if(sl.length){sec('3. Slab-wise tax (New Regime)');tbl(['Income slab','Rate','Income in slab','Tax'],sl.map(x=>[x[1]===Infinity?'Above '+pm(x[0]):pm(x[0])+' - '+pm(x[1]),Math.round(x[2]*100)+'%',pm(x[3]),pm(x[4])]),[['Tax on slab income','','',pm(sl.reduce((a,x)=>a+x[4],0))]],[1,2,3])}
doc.setLineHeightFactor(1.2);
/* 5 basis */
y+=4;sec('4. Basis of computation');
['Slabs: nil up to Rs. 4,00,000; 5% to 8 lakh; 10% to 12 lakh; 15% to 16 lakh; 20% to 20 lakh; 25% to 24 lakh; 30% above.','Standard deduction Rs. 75,000 on salary or pension. Employer NPS under Section 80CCD(2) allowed up to 14% of basic salary.','Section 87A rebate up to Rs. 60,000 for residents with total income up to Rs. 12,00,000, with marginal relief just above. Not available on special-rate capital gains.','Short-term gain on listed equity (STT paid) at 20%. Long-term gain above Rs. 1,25,000 at 12.5%.','Surcharge 10%, 15% and 25% above Rs. 50 lakh, 1 crore and 2 crore (with marginal relief). Health and Education Cess 4%.'].forEach(t=>{const L=doc.splitTextToSize(t,CW-22);need(L.length*11.5+6);doc.setFillColor(...MU);doc.circle(ML+5,y-3,2,'F');doc.setFont('helvetica','normal');doc.setFontSize(9);doc.setTextColor(...MU);doc.text(L,ML+16,y);y+=L.length*11.5+5});
/* disclaimer */
const DT=cl(DISC),DL=doc.splitTextToSize(DT,CW-24),dh=DL.length*10.5+22;y+=10;need(dh+6);doc.setFillColor(253,236,234);doc.roundedRect(ML,y,CW,dh,6,6,'F');doc.setFont('helvetica','normal');doc.setFontSize(8.4);doc.setTextColor(122,31,24);doc.setLineHeightFactor(1.25);doc.text(DL,ML+12,y+16);
/* header strip, footer, watermark on every page */
const N=doc.getNumberOfPages(),dt=new Date().toLocaleDateString('en-IN');
for(let i=1;i<=N;i++){doc.setPage(i);
if(i>1){doc.setFillColor(...NV);doc.rect(0,0,PW,34,'F');doc.setFillColor(...GD);doc.rect(0,34,PW,2.5,'F');T('RetirementPlanKaro.com',ML,22,11,[255,255,255],1);T('Income Tax Computation  |  FY 2026-27',PW-ML,22,9,[243,223,162],0,{align:'right'})}
doc.setDrawColor(...GD);doc.setLineWidth(1.2);doc.line(ML,812,PW-ML,812);
T('Educational estimate based on your inputs. Not tax, legal or investment advice. Please consult a Chartered Accountant before filing.',ML,824,7,MU);
T('RetirementPlanKaro.com  |  '+CFG.mail,ML,835,7.5,TL,1);doc.link(ML,826,230,12,{url:'https://www.retirementplankaro.com'});
T(dt+'  |  Page '+i+' of '+N,PW-ML,835,7.5,MU,0,{align:'right'});
rpkWM(doc)}
doc.save('RetirementPlanKaro-Income-Tax-Computation.pdf');toast('Your tax computation PDF is downloaded')}
const ex=document.getElementById('v-explore'),_r=window.renderExplore;
ex.addEventListener('click',t=>{if(t.target.closest('[data-txpdf]'))txPdf()});
window.renderExplore=function(sub){if(sub==='tax'){render();return}_r(sub);if(sub!=='returns'&&sub!=='portfolio'){const g=ex.querySelector('.xgrid');if(g)g.insertAdjacentHTML('beforeend','<a class="xtile" href="#explore/tax"><h3>Income Tax Calculator</h3><p>New Tax Regime · FY 2026-27</p><span class="go">Open →</span></a>')}};
const hd=t=>{const i=t.target;if(i.dataset&&i.dataset.t&&i.closest('#v-explore')&&document.getElementById('txo')){V[i.dataset.t]=i.value;run()}};
ex.addEventListener('input',hd);ex.addEventListener('change',hd);
if(/^#explore\/tax/.test(location.hash)||/^#explore\/?$/.test(location.hash))route();
})();
</script>
<script id="onep-js">
window.rpkOnePager=function(c){
if(!window.jspdf){toast('PDF library could not load. Check your connection.');return}
const doc=new jspdf.jsPDF({unit:'pt',format:'a4'});
if(typeof doc.autoTable!=='function'){toast('PDF table library could not load. Check your connection.');return}
const NV=[7,30,54],TL=[15,118,110],GD=[201,162,75],INK=[20,33,61],MU=[85,98,122],RD=[200,50,45],GR=[5,150,105],PW=595;
const rs=t=>String(t).replace(/₹/g,'Rs. ').replace(/[–—]/g,'-').replace(/[’‘]/g,"'");
const T=(t,x,y,z,col,b,o)=>{doc.setFont('helvetica',b?'bold':'normal');doc.setFontSize(z);doc.setTextColor(...col);doc.text(rs(t),x,y,o)};
const dt=new Date().toLocaleDateString('en-IN',{day:'numeric',month:'long',year:'numeric'});
doc.setFillColor(...NV);doc.rect(0,0,PW,104,'F');doc.setFillColor(...GD);doc.rect(0,104,PW,4,'F');doc.setFillColor(...TL);doc.rect(0,104,170,4,'F');
T('RetirementPlanKaro.com',40,50,23,[255,255,255],1);T('Retirement Planner for India',40,70,10,[243,223,162]);
const nm=(typeof who==='function'&&who())||'You';T('Prepared for',PW-40,42,8.5,[170,190,210],0,{align:'right'});T(nm,PW-40,56,12,[255,255,255],1,{align:'right'});T(dt,PW-40,72,9,[243,223,162],0,{align:'right'});
T(c.title,40,142,24,NV,1);T(c.sub,40,160,11.5,[150,115,35]);T(c.assump,40,178,8.8,MU);
const n=c.kpis.length,kw=(515-(n-1)*10)/n;
c.kpis.forEach((k,i)=>{const x=40+i*(kw+10);doc.setFillColor(241,247,247);doc.roundedRect(x,190,kw,54,8,8,'F');doc.setFillColor(...GD);doc.roundedRect(x,190,4,54,2,2,'F');T(k[0],x+14,208,7.2,MU,1);T(k[1],x+14,232,16,k[2]||NV,1)});
let y=266;
c.tables.forEach(t=>{T(t.title,40,y,11.5,NV,1);doc.setDrawColor(...GD);doc.setLineWidth(1.6);doc.line(40,y+4,40+Math.min(150,doc.getTextWidth(rs(t.title))),y+4);if(t.sub){T(t.sub,555,y,8.2,MU,0,{align:'right'})}
doc.autoTable({startY:y+11,head:[t.head.map(rs)],body:t.body.map(r=>r.map(v=>rs(v))),theme:'plain',margin:{left:40,right:40},
styles:{font:'helvetica',fontSize:8.5,cellPadding:{top:4.2,bottom:4.2,left:3,right:3},textColor:INK,lineColor:[226,236,237],lineWidth:{bottom:.5},halign:'center',valign:'middle'},
headStyles:{fillColor:NV,textColor:[255,255,255],fontStyle:'bold',fontSize:8.8},
columnStyles:{0:{halign:'left',fontStyle:'bold',fillColor:[225,241,240],cellWidth:t.w0||108,cellPadding:{top:4.2,bottom:4.2,left:6,right:3}}},
didParseCell:d=>{if(d.section==='head'&&d.column.index===0)d.cell.styles.halign='left';
if(d.section==='body'){const h=t.hl&&t.hl[d.row.index],st=d.cell.styles;
if(h==='gold'){st.fillColor=[251,243,220];st.fontStyle='bold';st.textColor=[63,47,8]}
else if(h==='red'){st.textColor=RD;st.fontStyle='bold'}
else if(h==='green'){st.textColor=[4,120,87];st.fontStyle='bold'}
else if(h==='key'){st.fontStyle='bold';st.fontSize=9.2}}}});
y=doc.lastAutoTable.finalY+20});
doc.setDrawColor(...GD);doc.setLineWidth(1.2);doc.line(40,812,555,812);
T(c.disc,40,824,7,MU);
T('RetirementPlanKaro.com  |  '+CFG.mail,40,835,7.5,TL,1);doc.link(40,826,230,12,{url:'https://www.retirementplankaro.com'});T(new Date().toLocaleDateString('en-IN'),555,835,7.5,MU,0,{align:'right'});
try{rpkWM(doc)}catch(e){}
while(doc.getNumberOfPages()>1)doc.deletePage(doc.getNumberOfPages());
doc.save(c.file);toast('Your one-page PDF is downloaded')};
</script>
<style id="sip-css">
.pdr{display:flex;flex-wrap:wrap;gap:12px;align-items:center;margin-top:20px}.pdn{color:var(--mu);font-size:12.5px}
.tpm{display:flex;flex-wrap:wrap;gap:8px;margin-top:14px}.tpm span{padding:6px 12px;border-radius:999px;background:var(--so);font-size:13px;color:var(--mu);font-weight:600}.tpm b{color:var(--ink)}
.spt.tp{min-width:0;table-layout:auto}.spt.tp th{font-size:12.5px;padding:11px 10px;font-family:var(--h);white-space:normal;line-height:1.25}
.spt.tp td{padding:11px 10px;white-space:nowrap}.spt.tp td:first-child{position:static;background:var(--so);font-weight:700}.spt.tp td:first-child b{font-size:15px}
.spt.tp thead th:first-child{position:static}.spt.tp td.sk{background:#FBF3DC;color:#3F2F08;font-weight:700;font-size:15px}.spt.tp td.sk small{color:#6B5416}
.spt.tp td.sg2{color:#047857;font-weight:700}.spt.tp tbody tr:last-child td{border-bottom:0}
@media(max-width:520px){.spt.tp th,.spt.tp td{padding:10px 6px;font-size:13px}.spt.tp td.sk,.spt.tp td:first-child b{font-size:13.5px}.spt.tp small{font-size:10.5px}}
.spw{overflow-x:auto;border:1px solid color-mix(in srgb,var(--gold,#C9A24B) 45%,var(--ln));border-radius:18px;box-shadow:0 10px 30px rgba(7,30,54,.10);background:var(--sf)}
.spt{width:100%;min-width:760px;border-collapse:separate;border-spacing:0;font-size:14.5px;font-variant-numeric:tabular-nums}
.spt th,.spt td{padding:12px 14px;text-align:center;border-bottom:1px solid var(--ln);white-space:nowrap}
.spt small{display:block;font-size:11.5px;font-weight:600;color:var(--mu);margin-top:2px}
.spt thead th{background:linear-gradient(135deg,#071E36,#0B3B45 65%,#0F766E);color:#fff;font:700 20px var(--h);border-bottom:3px solid #C9A24B}
.spt thead th small{color:#F3DFA2}.spt thead th:first-child{font-size:14px;text-align:left;letter-spacing:.02em}
.spt td:first-child{text-align:left;font-weight:700;color:var(--ink);background:var(--so);position:sticky;left:0;z-index:1}
.spt thead th:first-child{position:sticky;left:0;z-index:2}
.spt td.z{background:color-mix(in srgb,#0F766E 9%,var(--sf));font-weight:600}
.spt tr.kc td:not(:first-child){font-weight:700;font-size:15.5px}.spt tr.kc td small{color:var(--gd)}
.spt tr.kl td:first-child,.spt tr.kl td.l{color:#D9342B;font-weight:700}.spt tr.kl td.l{background:#FDF1EF}
.spt tr.kn td{border-bottom:0;background:#FBF3DC;color:#3F2F08;font-weight:700}.spt tr.kn td:first-child{background:#F3E2A9;color:#3F2F08}.spt tr.kn td small{color:#6B5416}
.spt .na{color:var(--mu)}
.sg{display:grid;gap:14px;grid-template-columns:repeat(auto-fit,minmax(170px,1fr))}
.sg label{display:block;font-size:13px;font-weight:600;margin:0 0 4px;color:var(--ink)}
.sg small{display:block;margin-top:3px;color:var(--mu);font-size:12px}
.sdk{display:grid;gap:12px;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));margin:0 0 6px}
.sdk div{padding:14px 16px;border-radius:14px;background:var(--so);border-left:4px solid var(--gold,#C9A24B)}
.sdk small{display:block;color:var(--mu);font-size:12px;font-weight:600}.sdk b{font:700 22px var(--h);font-variant-numeric:tabular-nums}
.sdk div.r{border-left-color:#D9342B}.sdk div.r b{color:#D9342B}
.scs{display:grid;gap:16px;grid-template-columns:repeat(auto-fit,minmax(340px,1fr));margin-top:6px}
.sc{border:1px solid var(--ln);border-radius:18px;background:var(--sf);overflow:hidden;box-shadow:0 6px 20px rgba(7,30,54,.06)}
.sc-h{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:12px 16px;background:linear-gradient(135deg,#071E36,#0B3B45 65%,#0F766E);color:#fff}
.sc-h b{font:600 17px var(--hd-serif,var(--h));color:#fff}.sc-h span{font-size:12px;font-weight:700;padding:3px 10px;border-radius:999px;background:linear-gradient(135deg,#F3E2A9,#C9A24B);color:#3F2F08;white-space:nowrap}
.sct{width:100%;border-collapse:collapse;font-size:14px;font-variant-numeric:tabular-nums}
.sct th,.sct td{padding:9px 14px;text-align:right;border-bottom:1px solid var(--ln)}
.sct th:first-child,.sct td:first-child{text-align:left;color:var(--mu);font-weight:600}
.sct thead th{background:var(--so);color:var(--br);font-size:12.5px;font-weight:700}
.sct td.d{color:#D9342B;font-weight:700}.sct tr.k td{background:#FBF3DC;color:#3F2F08;font-weight:700;border-bottom:0}
.sct tr.k td:first-child{color:#3F2F08}
.sbar{padding:12px 16px 16px;display:grid;gap:6px}
.sbar div{display:flex;align-items:center;gap:8px;font-size:12px;color:var(--mu)}
.sbar i{display:block;height:8px;border-radius:8px;background:linear-gradient(90deg,#0F766E,#34D399)}.sbar i.x{background:linear-gradient(90deg,#C9A24B,#F3E2A9)}
.sna{padding:22px 16px;text-align:center;color:var(--mu);font-size:14px}
.snote{margin:18px 0 0;color:var(--mu);font-size:12.5px;text-align:center}
</style>
<script id="sip-js">
(function(){
const OPTK='sip';
const e=s=>String(s==null?'':s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
let LASTP=null,LASTT=null;
const V={age:'30',ret:'60',sip:'10000',r:'12',step:'0',tg:'10000000',tr:null,tgs:0};
const n0=n=>Math.round(n).toLocaleString('en-IN');
const m=n=>n>=1e7?'₹'+(n/1e7).toFixed(2)+' Cr':n>=1e5?'₹'+(n/1e5).toFixed(2)+' L':'₹'+n0(n);
const HEAD='<div class="xhead"><h2>SIP Calculator</h2><p>See what waiting costs you, 2 years at a time</p></div>',BK='<div style="margin-bottom:14px"><a class="btn small" href="#explore">← Back to Explore</a></div>';
/* month-end compounding on monthly SIP; step = yearly SIP increase */
function fv(sip,yrs,r,step){const mr=Math.pow(1+r,1/12)-1;let b=0,c=sip;for(let y=0;y<yrs;y++){for(let k=0;k<12;k++)b=(b+c)*(1+mr);c*=1+step}return b}
function inv(sip,yrs,step){let t=0,c=sip;for(let y=0;y<yrs;y++){t+=c*12;c*=1+step}return t}
function get(){const g=k=>parseFloat(V[k]);return{age:Math.round(g('age')),ret:Math.round(g('ret')),sip:g('sip'),r:g('r')/100,step:(parseFloat(V.step)||0)/100}}
function tgt(o){LASTT=null;const T=parseFloat(V.tg),trv=V.tr!=null?V.tr:V.r,rr=parseFloat(trv)/100;
let h=`<div class="emx"><h3 class="pfh" style="margin-top:28px">What SIP do you need for your target?</h3><div class="emr"><div><label for="s-tg">Target amount (₹)</label><div class="in"><i class="cs">₹</i><input id="s-tg" data-sg="1" type="number" inputmode="decimal" min="0" step="any" value="${e(V.tg)}"></div><small>The goal you want to reach</small></div><div><label for="s-tr">Expected return (% a year)</label><div class="in"><input id="s-tr" data-sr="1" type="number" inputmode="decimal" min="0" step="any" value="${e(trv)}"></div><small>${o.step>0?'Yearly SIP increase from above is applied':'Long term equity funds often 10–12%'}</small></div><button class="btn go" type="button" data-sgo>✨ Suggest my SIP</button></div><div id="sgo">`;
if(V.tgs){if(!(T>0)||!(rr>0)||rr>0.3)h+='<div class="pfn" style="margin-top:14px">Enter a target amount above zero and a return between 0.1% and 30%.</div>';
else{const P=[5,10,15,20,25,30],S=P.map(y=>{const q=T/fv(1,y,rr,o.step);return{y,q,ti:inv(q,y,o.step)}});LASTT={T,rr,S,o};
const rt=(rr*100).toFixed(1).replace(/\.0$/,'');
h+=`<div class="tpm"><span>Target <b>${m(T)}</b></span><span>Return <b>${rt}% a year</b></span>${o.step>0?`<span>SIP rises <b>${(o.step*100).toFixed(0)}% yearly</b></span>`:''}</div><div class="spw" style="margin-top:10px"><table class="spt tp"><thead><tr><th>Time Period</th><th>Monthly SIP Needed</th><th>Total Invested</th><th>Wealth Gained</th></tr></thead><tbody>${S.map((z,i)=>`<tr><td><b>${z.y} Years</b><small>Age ${o.age+z.y}</small></td><td class="sk">₹${n0(z.q)}<small>${o.step>0?'first year':'per month'}</small></td><td>${m(z.ti)}<small>₹${n0(z.ti)}</small></td><td class="sg2">${m(T-z.ti)}<small>${((T-z.ti)/T*100).toFixed(0)}% of target</small></td></tr>`).join('')}</tbody></table></div>`}}
return h+'</div></div>'}
function pdfSip(){if(!LASTP){toast('Fill your details first.');return}
const{o,Y,base,bi,C}=LASTP,pc=x=>(x*100).toFixed(1).replace(/\.0$/,''),last=[...C].reverse().find(x=>!x.na&&x.d>0),dash=x=>x.na;
const kp=[['CORPUS IF YOU START NOW',m(base),[7,30,54]],['YOU INVEST IN TOTAL',m(bi),[15,118,110]]];if(last)kp.push(['LOST BY WAITING '+last.d+' YEARS',m(last.loss),[200,50,45]]);
const tb=[{title:'Start now vs start late',sub:'Corpus at age '+o.ret,w0:106,head:['Starting Age',...C.map(x=>(o.age+x.d)+'\n'+(x.d?x.d+' yrs late':'On time'))],
body:[['Last SIP Year (Age)',...C.map(x=>dash(x)?'-':o.ret)],['Years Invested',...C.map(x=>dash(x)?'-':x.y)],['SIP Amount',...C.map(x=>dash(x)?'-':'₹'+n0(o.sip))],['Invested Amount',...C.map(x=>dash(x)?'-':m(x.ti))],['Corpus at '+o.ret,...C.map(x=>dash(x)?'-':m(x.c))],['You Lose by Late',...C.map(x=>dash(x)?'-':x.d?m(x.loss)+'\n('+x.pct.toFixed(0)+'% less)':'-')],['SIP to Catch Up',...C.map(x=>dash(x)?'-':x.d?'₹'+n0(x.need):'₹'+n0(o.sip))]],hl:{4:'key',5:'red',6:'gold'}}];
if(LASTT){const{T,rr,S,o:p}=LASTT;tb.push({title:'SIP needed for your target',sub:'Target '+m(T)+'  |  Return '+pc(rr)+'% a year',w0:120,head:['Time Period','Monthly SIP Needed','Total Invested','Wealth Gained','Share of Target'],body:S.map(z=>[z.y+' Years (Age '+(p.age+z.y)+')','₹'+n0(z.q)+(p.step>0?' *':''),m(z.ti),m(T-z.ti),((T-z.ti)/T*100).toFixed(0)+'%']),hl:{}});}
rpkOnePager({title:'SIP Calculator',sub:'See what waiting costs you, 2 years at a time',assump:'Age '+o.age+' to '+o.ret+'   |   SIP ₹'+n0(o.sip)+' a month   |   Return '+pc(o.r)+'% a year   |   Yearly SIP increase '+pc(o.step)+'%',kpis:kp,tables:tb,disc:'Educational estimate at a constant return. Actual market returns vary. Not investment advice.'+(LASTT&&LASTT.o.step>0?' * First-year SIP, rises yearly.':''),file:'RetirementPlanKaro-SIP-Calculator.pdf'})}
function run(){const o=get(),out=document.getElementById('sipo');if(!out)return;
const Y=o.ret-o.age;
if(!(o.age>0)||!(o.ret>o.age)||!(o.sip>0)||!(o.r>0)){out.innerHTML='<div class="pfn">Fill your age, retirement age, monthly SIP and expected return. Results update as you type.</div>';return}
if(Y<3){out.innerHTML='<div class="pfn">Retirement age should be at least 3 years after your current age.</div>';return}
const base=fv(o.sip,Y,o.r,o.step),bi=inv(o.sip,Y,o.step);
const D=[0,2,4,6,8,10],C=D.map(d=>{const y=Y-d;if(y<=0)return{d,y,na:1};const c=fv(o.sip,y,o.r,o.step),ti=inv(o.sip,y,o.step),loss=base-c;return{d,y,c,ti,loss,pct:loss/base*100,need:o.sip*base/c}});LASTP={o,Y,base,bi,C};
const R=(p,k)=>C.map(x=>`<td class="${x.d===0?'z':''}${k&&x.d?' '+k:''}">${x.na?'<span class="na">–</span>':p(x)}</td>`).join('');
const last=[...C].reverse().find(x=>!x.na&&x.d>0);
out.innerHTML=`<div class="sdk"><div><small>Corpus if you start now</small><b>${m(base)}</b></div><div><small>You invest in total</small><b>${m(bi)}</b></div>${last?`<div class="r"><small>Lost by waiting ${last.d} years</small><b>${m(last.loss)}</b></div>`:''}</div>
<div class="pdr" style="margin-top:14px"><button class="btn go small" type="button" data-sippdf>⬇ Download One-Page PDF</button></div>
<h3 class="pfh">Start now vs start late</h3>
<div class="spw"><table class="spt"><thead><tr><th>Starting Age</th>${C.map(x=>`<th class="${x.d===0?'z':''}">${o.age+x.d}${x.d?`<small>${x.d} yrs late</small>`:'<small>On time</small>'}</th>`).join('')}</tr></thead><tbody>
<tr><td>Last SIP Year (Age)</td>${R(()=>o.ret)}</tr>
<tr><td>Years Invested</td>${R(x=>x.y)}</tr>
<tr><td>SIP Amount</td>${R(()=>'₹'+n0(o.sip))}</tr>
<tr><td>Invested Amount</td>${R(x=>'₹'+n0(x.ti))}</tr>
<tr class="kc"><td>Corpus at ${o.ret}</td>${R(x=>'₹'+n0(x.c)+'<small>'+m(x.c)+'</small>')}</tr>
<tr class="kl"><td>You Lose by Late</td>${R(x=>x.d?'₹'+n0(x.loss)+'<small>'+x.pct.toFixed(0)+'% less</small>':'–','l')}</tr>
<tr class="kn"><td>SIP to Catch Up</td>${R(x=>x.d?'₹'+n0(x.need)+'<small>+₹'+n0(x.need-o.sip)+' a month</small>':'–')}</tr>
</tbody></table></div>
${tgt(o)}
<div class="pdr"><button class="btn go small" type="button" data-sippdf>⬇ Download One-Page PDF</button><span class="pdn">Includes your target SIP plan once you generate it.</span></div>
<p class="snote">Educational estimate at a constant return. Actual market returns vary. Not investment advice.</p>`}
const F=[['age','Your age now','Years'],['ret','Retirement age','Years'],['sip','Monthly SIP (₹)','Per month'],['r','Expected return (% a year)','Equity funds long term often 10–12%'],['step','Yearly SIP increase (%)','Optional']];
function render(){const el=document.getElementById('v-explore');
if(typeof USER==='undefined'||!USER){el.innerHTML=BK+'<div class="xcard">'+HEAD+'<div class="xgate"><h3>Login or sign up to continue</h3><p>It takes a minute. Then your SIP calculator opens right away.</p><div class="row"><button class="btn go lg" type="button" data-xlogin="su">Sign up</button><button class="btn lg" type="button" data-xlogin="li">Login</button></div></div></div>';scrollTo(0,0);return}
el.innerHTML=BK+`<div class="xcard">${HEAD}<div class="xbody"><div class="sg">${F.map(f=>`<div><label for="s-${f[0]}">${f[1]}</label><div class="in"><input id="s-${f[0]}" data-s="${f[0]}" type="number" inputmode="decimal" min="0" step="any" value="${e(V[f[0]])}"></div><small>${f[2]}</small></div>`).join('')}</div><div id="sipo" style="margin-top:20px"></div></div></div>`;V.tgs=0;V.tr=null;run();scrollTo(0,0)}
const ex=document.getElementById('v-explore'),_r=window.renderExplore;
window.renderExplore=function(sub){if(sub===OPTK){render();return}_r(sub);if(sub!=='returns'&&sub!=='portfolio'&&sub!=='tax'){const g=ex.querySelector('.xgrid');if(g&&!g.querySelector('[href="#explore/sip"]'))g.insertAdjacentHTML('beforeend','<a class="xtile" href="#explore/sip"><h3>SIP Calculator</h3><p>Delay cost and target-based SIP plan</p><span class="go">Open →</span></a>')}};
const hd=t=>{const i=t.target;if(i.dataset&&i.dataset.s&&i.closest('#v-explore')&&document.getElementById('sipo')){V[i.dataset.s]=i.value;run()}};
const hg=t=>{const i=t.target;if(i.dataset&&(i.dataset.sg||i.dataset.sr)&&i.closest('#v-explore')){if(i.dataset.sg)V.tg=i.value;else V.tr=i.value;V.tgs=0;const q=document.getElementById('sgo');if(q)q.innerHTML=''}};
ex.addEventListener('input',hg);ex.addEventListener('change',hg);
ex.addEventListener('click',t=>{if(t.target.closest('[data-sgo]')&&document.getElementById('sipo')){V.tgs=1;run();const q=document.getElementById('sgo');if(q)q.scrollIntoView({behavior:'smooth',block:'nearest'})}});
ex.addEventListener('click',t=>{if(t.target.closest('[data-sippdf]'))pdfSip()});
ex.addEventListener('input',hd);ex.addEventListener('change',hd);
})();
</script>
<style id="emi-css">
.emr{display:flex;flex-wrap:wrap;gap:14px;align-items:flex-end;padding:16px;border-radius:16px;background:var(--so);border-left:5px solid var(--gold,#C9A24B)}
.emr>div{flex:1 1 240px}.emr label{display:block;font-size:13px;font-weight:600;margin:0 0 4px;color:var(--ink)}.emr small{display:block;margin-top:3px;color:var(--mu);font-size:12px}
.emr .btn{min-height:44px}
.spt tr.kg td:first-child,.spt tr.kg td.g{color:#047857;font-weight:700}.spt tr.kg td.g{background:#ECFDF5}
</style>
<script id="emi-js">
(function(){
const OPTK='emi';
const e=s=>String(s==null?'':s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
let LASTE=null,LASTX=null;
const V={p:'5000000',r:'8.5',x:'1',show:0};
const n0=n=>Math.round(n).toLocaleString('en-IN');
const m=n=>n>=1e7?'₹'+(n/1e7).toFixed(2)+' Cr':n>=1e5?'₹'+(n/1e5).toFixed(2)+' L':'₹'+n0(n);
const HEAD='<div class="xhead"><h2>Home Loan EMI Calculator</h2><p>Compare 10 to 30 year tenures side by side</p></div>',BK='<div style="margin-bottom:14px"><a class="btn small" href="#explore">← Back to Explore</a></div>';
const emi=(P,rate,y)=>{const n=y*12,r=rate/1200;return r>0?P*r*Math.pow(1+r,n)/(Math.pow(1+r,n)-1):P/n};
const sim=(P,rate,em,ex)=>{const r=rate/1200;let b=P,k=0,t=0;while(b>0.5&&k<1200){k++;const q=b*r;t+=q;b=b+q-em;if(k%12===0&&b>0)b-=ex}return{k,int:t}};
const ym=k=>{const y=Math.floor(k/12),mo=k%12;return (y?y+' yr'+(y>1?'s':''):'')+(y&&mo?' ':'')+(mo?mo+' mth'+(mo>1?'s':''):'')||'0'};
function extra(P,rate,C){LASTX=null;const x=parseFloat(V.x);
let o=`<div class="emx"><h3 class="pfh" style="margin-top:28px">Pay extra EMI every year?</h3><div class="emr"><div><label for="e-x">Extra EMIs paid each year</label><div class="in"><input id="e-x" data-x="1" type="number" inputmode="decimal" min="0" step="any" value="${e(V.x)}"></div><small>Paid once a year, after the 12th EMI. Goes fully to principal.</small></div><button class="btn go" type="button" data-emix>✨ Show impact</button></div><div id="emxo">`;
if(V.show){if(!(x>0)||x>12)o+='<div class="pfn" style="margin-top:14px">Enter extra EMIs between 0.5 and 12 a year.</div>';
else{const S=C.map(c=>{const ex=c.x*x,s=sim(P,rate,c.x,ex);return{c,ex,s,sv:c.int-s.int,ts:c.y*12-s.k,tot:P+s.int}});LASTX={x,S};
const R=(p,k)=>S.map((z,i)=>`<td class="${i===0?'z ':''}${k||''}">${p(z)}</td>`).join('');
o+=`<div class="spw" style="margin-top:14px"><table class="spt"><thead><tr><th>With ${x} Extra EMI a Year</th>${S.map((z,i)=>`<th class="${i===0?'z':''}">${z.c.y} Years<small>Original</small></th>`).join('')}</tr></thead><tbody>
<tr><td>Monthly EMI</td>${R(z=>'₹'+n0(z.c.x))}</tr>
<tr><td>Extra Paid Each Year</td>${R(z=>'₹'+n0(z.ex))}</tr>
<tr class="kc"><td>New Loan Tenure</td>${R(z=>ym(z.s.k)+'<small>was '+z.c.y+' years</small>')}</tr>
<tr class="kg"><td>Time Saved</td>${R(z=>ym(z.ts)+'<small>'+(z.ts/(z.c.y*12)*100).toFixed(0)+'% shorter</small>','g')}</tr>
<tr><td>Interest Without Extra</td>${R(z=>'₹'+n0(z.c.int)+'<small>'+m(z.c.int)+'</small>')}</tr>
<tr><td>Interest With Extra</td>${R(z=>'₹'+n0(z.s.int)+'<small>'+m(z.s.int)+'</small>')}</tr>
<tr class="kn"><td>Interest Saved</td>${R(z=>'₹'+n0(z.sv)+'<small>'+m(z.sv)+'</small>')}</tr>
</tbody></table></div>`}}
return o+'</div></div>'}
function pdfEmi(){if(!LASTE){toast('Enter the loan details first.');return}
const{P,rate,C,l30}=LASTE,c20=C[2];
const tb=[{title:'Tenure comparison',sub:'EMI at a fixed rate, no prepayment',w0:118,head:['Loan Tenure',...C.map(x=>x.y+' Years\n'+x.y*12+' EMIs')],
body:[['Loan Amount',...C.map(()=>m(P))],['Interest Rate',...C.map(()=>rate+'%')],['Monthly EMI',...C.map(x=>'₹'+n0(x.x))],['Total Interest',...C.map(x=>m(x.int))],['Total Payment',...C.map(x=>m(x.tot))],['Interest on Loan',...C.map(x=>(x.int/P*100).toFixed(0)+'%')],['Income Needed (EMI 40%)',...C.map(x=>'₹'+n0(x.x/0.4))],['Interest Saved vs 30 Yrs',...C.map(x=>x.y===30?'-':m(l30-x.int))]],hl:{2:'key',3:'red',7:'gold'}}];
if(LASTX){const{x,S}=LASTX;tb.push({title:'With '+x+' extra EMI paid every year',sub:'Paid after the 12th EMI, fully to principal',w0:118,head:['Original Tenure',...S.map(z=>z.c.y+' Years')],
body:[['Monthly EMI',...S.map(z=>'₹'+n0(z.c.x))],['Extra Paid Each Year',...S.map(z=>'₹'+n0(z.ex))],['New Loan Tenure',...S.map(z=>ym(z.s.k))],['Time Saved',...S.map(z=>ym(z.ts))],['Interest Without Extra',...S.map(z=>m(z.c.int))],['Interest With Extra',...S.map(z=>m(z.s.int))],['Interest Saved',...S.map(z=>m(z.sv))]],hl:{2:'key',3:'green',6:'gold'}})}
rpkOnePager({title:'Home Loan EMI Calculator',sub:'Compare 10 to 30 year tenures side by side',assump:'Loan ₹'+n0(P)+'   |   Interest rate '+rate+'% a year   |   Fixed rate, no prepayment in the first table',kpis:[['EMI FOR 20 YEARS','₹'+n0(c20.x),[7,30,54]],['INTEREST FOR 20 YEARS',m(c20.int),[200,50,45]],['INTEREST SAVED, 10 VS 30 YRS',m(l30-C[0].int),[5,150,105]]],tables:tb,disc:'Educational estimate with a fixed rate. Your lender\u2019s final EMI may differ. Not financial advice.',file:'RetirementPlanKaro-Home-Loan-EMI.pdf'})}
function run(){const out=document.getElementById('emio');if(!out)return;
const P=parseFloat(V.p),rate=parseFloat(V.r);
if(!(P>0)||!(rate>=0)||V.r===''){out.innerHTML='<div class="pfn">Enter the loan amount and the interest rate. Results update as you type.</div>';return}
if(rate>30){out.innerHTML='<div class="pfn">Please enter an interest rate up to 30% a year.</div>';return}
const T=[10,15,20,25,30],C=T.map(y=>{const x=emi(P,rate,y),tot=x*y*12;return{y,x,tot,int:tot-P}}),l30=C[4].int;LASTE={P,rate,C,l30};
const R=(p,k)=>C.map((x,i)=>`<td class="${i===0?'z ':''}${k||''}">${p(x)}</td>`).join('');
const c20=C[2];
out.innerHTML=`<div class="sdk"><div><small>EMI for 20 years</small><b>₹${n0(c20.x)}</b></div><div><small>Interest for 20 years</small><b>${m(c20.int)}</b></div><div class="r"><small>Interest saved, 10 vs 30 years</small><b>${m(l30-C[0].int)}</b></div></div>
<div class="pdr" style="margin-top:14px"><button class="btn go small" type="button" data-emipdf>⬇ Download One-Page PDF</button></div>
<h3 class="pfh">Tenure comparison</h3>
<div class="spw"><table class="spt"><thead><tr><th>Loan Tenure</th>${C.map((x,i)=>`<th class="${i===0?'z':''}">${x.y} Years<small>${x.y*12} EMIs</small></th>`).join('')}</tr></thead><tbody>
<tr><td>Loan Amount</td>${R(()=>'₹'+n0(P))}</tr>
<tr><td>Interest Rate</td>${R(()=>rate+'% a year')}</tr>
<tr class="kc"><td>Monthly EMI</td>${R(x=>'₹'+n0(x.x))}</tr>
<tr class="kl"><td>Total Interest</td>${R(x=>'₹'+n0(x.int)+'<small>'+m(x.int)+'</small>','l')}</tr>
<tr><td>Total Payment</td>${R(x=>'₹'+n0(x.tot)+'<small>'+m(x.tot)+'</small>')}</tr>
<tr><td>Interest on Loan</td>${R(x=>(x.int/P*100).toFixed(0)+'%')}</tr>
<tr><td>Income Needed (EMI at 40%)</td>${R(x=>'₹'+n0(x.x/0.4)+'<small>a month</small>')}</tr>
<tr class="kn"><td>Interest Saved vs 30 Yrs</td>${R(x=>x.y===30?'–':'₹'+n0(l30-x.int)+'<small>'+m(l30-x.int)+'</small>')}</tr>
</tbody></table></div>
${extra(P,rate,C)}
<div class="pdr"><button class="btn go small" type="button" data-emipdf>⬇ Download One-Page PDF</button><span class="pdn">Includes your extra EMI plan once you generate it.</span></div>
<p class="snote">Educational estimate with a fixed rate and no prepayment. Your lender’s final EMI may differ. Not financial advice.</p>`}
const F=[['p','Loan amount (₹)','Amount you borrow','₹'],['r','Interest rate (% a year)','Fixed rate assumed','']];
function render(){const el=document.getElementById('v-explore');
if(typeof USER==='undefined'||!USER){el.innerHTML=BK+'<div class="xcard">'+HEAD+'<div class="xgate"><h3>Login or sign up to continue</h3><p>It takes a minute. Then your EMI calculator opens right away.</p><div class="row"><button class="btn go lg" type="button" data-xlogin="su">Sign up</button><button class="btn lg" type="button" data-xlogin="li">Login</button></div></div></div>';scrollTo(0,0);return}
el.innerHTML=BK+`<div class="xcard">${HEAD}<div class="xbody"><div class="sg" style="grid-template-columns:repeat(auto-fit,minmax(220px,1fr))">${F.map(f=>`<div><label for="e-${f[0]}">${f[1]}</label><div class="in">${f[3]?`<i class="cs">${f[3]}</i>`:''}<input id="e-${f[0]}" data-e="${f[0]}" type="number" inputmode="decimal" min="0" step="any" value="${e(V[f[0]])}"></div><small>${f[2]}</small></div>`).join('')}</div><div id="emio" style="margin-top:20px"></div></div></div>`;V.show=0;run();scrollTo(0,0)}
const ex=document.getElementById('v-explore'),_r=window.renderExplore;
window.renderExplore=function(sub){if(sub===OPTK){render();return}_r(sub);if(!['returns','portfolio','tax','sip'].includes(sub)){const g=ex.querySelector('.xgrid');if(g&&!g.querySelector('[href="#explore/emi"]'))g.insertAdjacentHTML('beforeend','<a class="xtile" href="#explore/emi"><h3>Home Loan EMI Calculator</h3><p>10 to 30 year tenures, side by side</p><span class="go">Open →</span></a>')}};
const hd=t=>{const i=t.target;if(i.dataset&&i.dataset.e&&i.closest('#v-explore')&&document.getElementById('emio')){V[i.dataset.e]=i.value;run()}};
const hx=t=>{const i=t.target;if(i.dataset&&i.dataset.x&&i.closest('#v-explore')){V.x=i.value;V.show=0;const q=document.getElementById('emxo');if(q)q.innerHTML=''}};
ex.addEventListener('input',hx);ex.addEventListener('change',hx);
ex.addEventListener('click',t=>{if(t.target.closest('[data-emix]')&&document.getElementById('emio')){V.show=1;run();const q=document.getElementById('emxo');if(q)q.scrollIntoView({behavior:'smooth',block:'nearest'})}});
ex.addEventListener('click',t=>{if(t.target.closest('[data-emipdf]'))pdfEmi()});
ex.addEventListener('input',hd);ex.addEventListener('change',hd);
})();
</script>
<style id="bp-css">
.bpr{display:flex;flex-wrap:wrap;gap:14px;align-items:flex-end;padding:16px;border-radius:16px;background:var(--so);border-left:5px solid var(--gold,#C9A24B)}
.bpr>div{flex:1 1 220px}.bpr label{display:block;font-size:13px;font-weight:600;margin:0 0 4px;color:var(--ink)}
.bpr select{flex:1;border:0;background:none;padding:10px 4px;color:inherit;font:inherit;min-height:44px;outline:none}
.bpt{display:flex;gap:8px;margin:20px 0 10px;flex-wrap:wrap}
.bpd{border:0;background:none;color:#D9342B;font-size:22px;cursor:pointer;min-height:44px;min-width:44px}
.bpi{margin:18px 0 0;padding:16px 20px;border-radius:16px;background:var(--so);border-left:5px solid var(--gold,#C9A24B)}
.bpi li{margin:6px 0;line-height:1.5}
</style>
<script id="bp-js">
(function(){
const OPTK='budget';
const e=s=>String(s==null?'':s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const n0=n=>Math.round(n).toLocaleString('en-IN'),m=n=>'₹'+n0(n),num=x=>parseFloat(x)||0;
const SUG=['Rent / Home Loan EMI','Groceries & Food','Electricity & Water','Mobile & Internet','Transport & Fuel','Medical & Insurance','Kids School & Education','Eating Out & Entertainment','Shopping & Others'];
const HEAD='<div class="xhead"><h2>Budget Planner</h2><p>Plan your month, track actual spending, get a clear analysis</p></div>',BK='<div style="margin-bottom:14px"><a class="btn small" href="#explore">← Back to Explore</a></div>';
const now=new Date(),ymOf=d=>d.getFullYear()+'-'+String(d.getMonth()+1).padStart(2,'0');
const lab=ym=>{const p=ym.split('-');return new Date(p[0],p[1]-1,1).toLocaleDateString('en-IN',{month:'long',year:'numeric'})};
const S={ym:ymOf(now),d:null,res:0};
const KEY=()=>'rpk_bud_'+USER.mobile,all=()=>LS.g(KEY())||{};
function load(){const a=all()[S.ym];S.d=a?JSON.parse(JSON.stringify(a)):{inc:'',items:SUG.map(n=>({n,b:'',a:''})),saved:0,done:0};S.res=S.d.done?1:0}
function save(){const a=all();a[S.ym]=S.d;LS.s(KEY(),a)}
function read(){const el=document.getElementById('bpb');if(!el)return;const i=document.getElementById('bp-i');if(i)S.d.inc=i.value;
el.querySelectorAll('tr[data-i]').forEach(tr=>{const it=S.d.items[+tr.dataset.i];if(!it)return;const n=tr.querySelector('.bn'),b=tr.querySelector('.bb'),a=tr.querySelector('.ba');if(n)it.n=n.value.trim()||'Other';if(b)it.b=b.value;if(a)it.a=a.value})}
const tots=()=>S.d.items.reduce((t,x)=>({b:t.b+num(x.b),a:t.a+num(x.a)}),{b:0,a:0});
function ana(){const D=S.d,inc=num(D.inc),T=tots(),tb=T.b,ta=T.a,sv=inc-ta,rate=inc>0?Math.round(sv/inc*100):0;
const rows=D.items.filter(x=>num(x.b)>0||num(x.a)>0).map(x=>({n:x.n,b:num(x.b),a:num(x.a),v:num(x.a)-num(x.b)}));
const over=rows.filter(r=>r.v>0).sort((x,y)=>y.v-x.v),un=rows.filter(r=>r.b===0&&r.a>0),top=rows.slice().sort((x,y)=>y.a-x.a)[0],ins=[];
ins.push(ta>tb?`You spent ${m(ta-tb)} more than planned. Biggest overspends: ${over.slice(0,3).map(r=>r.n+' (+'+m(r.v)+')').join(', ')}.`:`Well done. You stayed ${m(tb-ta)} under your budget.`);
if(sv<0)ins.push(`Your spending was ${m(-sv)} more than your income. Cut this first, even before you invest more.`);
else if(rate>=20)ins.push(`You saved ${rate}% of your income (${m(sv)}). That is a healthy level. Move it into your SIP or emergency fund on day one next month.`);
else ins.push(`You saved ${rate}% of your income. A good target is 20%, which is ${m(inc*.2)} a month. You need ${m(inc*.2-sv)} more.`);
if(un.length)ins.push(`Unplanned spends: ${un.map(r=>r.n+' ('+m(r.a)+')').join(', ')}. Add them to next month’s budget.`);
if(top&&inc>0&&top.a/inc>.3)ins.push(`${top.n} takes ${Math.round(top.a/inc*100)}% of your income. This is your best place to save.`);
if(over.length)ins.push(`Next month, set a realistic limit for ${over[0].n} near ${m(over[0].a)}, or find a way to cut it.`);
return{inc,tb,ta,sv,rate,rows,ins}}
function result(){const A=ana(),ov=A.ta-A.tb;
return`<div class="sdk" style="margin-top:22px"><div><small>Planned budget</small><b>${m(A.tb)}</b></div><div><small>Actual spent</small><b>${m(A.ta)}</b></div><div class="${ov>0?'r':''}"><small>${ov>0?'Over budget by':'Under budget by'}</small><b>${m(Math.abs(ov))}</b></div><div class="${A.sv<0?'r':''}"><small>Savings (${A.rate}% of income)</small><b>${A.sv<0?'−':''}${m(Math.abs(A.sv))}</b></div></div>
<div class="bpi"><b>Your analysis for ${lab(S.ym)}</b><ul style="margin:8px 0 0;padding-left:20px">${A.ins.map(x=>'<li>'+e(x)+'</li>').join('')}</ul></div>
<div class="pdr"><button class="btn go small" type="button" data-bpdf>⬇ Download PDF</button></div>
<p class="snote">Educational tool based on the numbers you enter. Your data stays in this browser. Not financial advice.</p>`}
function planSum(){const inc=num(S.d.inc),T=tots();return`<div class="sdk" style="margin-top:22px"><div><small>Monthly income</small><b>${m(inc)}</b></div><div><small>Planned budget</small><b>${m(T.b)}</b></div><div class="${inc<T.b?'r':''}"><small>Planned savings</small><b>${inc<T.b?'−':''}${m(Math.abs(inc-T.b))}</b></div></div><p class="pfn" style="margin-top:14px">${inc<T.b?'Your budget is more than your income. Reduce some expenses.':'Budget saved. At month end, come back, enter Actual spent and click Submit.'}</p>`}
function render(){const el=document.getElementById('v-explore');
if(typeof USER==='undefined'||!USER){el.innerHTML=BK+'<div class="xcard">'+HEAD+'<div class="xgate"><h3>Login or sign up to continue</h3><p>Your budgets are saved on your device.</p><div class="row"><button class="btn go lg" type="button" data-xlogin="su">Sign up</button><button class="btn lg" type="button" data-xlogin="li">Login</button></div></div></div>';scrollTo(0,0);return}
if(!S.d)load();const D=S.d,R=S.res,mo=[];for(let i=-11;i<=2;i++)mo.push(ymOf(new Date(now.getFullYear(),now.getMonth()+i,1)));
const cell=(c,l,v)=>`<td class="bpc"><span class="ml">${l}</span><div class="in"><i class="cs">₹</i><input class="${c}" type="number" inputmode="decimal" min="0" step="any" placeholder="0" value="${e(v)}" aria-label="${l}"></div></td>`;
const rows=D.items.map((x,i)=>{const v=num(x.a)-num(x.b),sh=num(x.b)>0||num(x.a)>0;
return`<tr data-i="${i}"><td class="nm"><span class="ml">Expense</span>${x.c?`<div class="in"><input class="bn" maxlength="40" value="${e(x.n)}" aria-label="Expense name"></div>`:`<span class="xnm">${e(x.n)}</span>`}</td>${cell('bb','Budget',x.b)}${cell('ba','Actual',x.a)}${R?`<td class="bpx"><span class="ml">Difference</span>${sh?(v>0?'+':v<0?'−':'')+m(Math.abs(v)):''}</td><td class="bpx"><span class="ml">Status</span>${sh?`<span class="${v>0?'wneg':'wpos'}">${v>0?'Over':'On track'}</span>`:''}</td>`:''}<td>${x.c?`<button class="bpd" type="button" data-bd="${i}" aria-label="Remove">×</button>`:''}</td></tr>`}).join('');
const T=tots(),dv=T.a-T.b;
el.innerHTML=BK+`<div class="xcard">${HEAD}<div class="xbody">
<div class="bpr"><div><label for="bp-m">Select month</label><div class="in"><select id="bp-m">${mo.map(x=>`<option value="${x}"${x===S.ym?' selected':''}>${lab(x)}</option>`).join('')}</select></div></div><div><label for="bp-i">Monthly income (₹)</label><div class="in"><i class="cs">₹</i><input id="bp-i" type="number" inputmode="decimal" min="0" step="any" placeholder="e.g. 80000" value="${e(D.inc)}"></div></div></div>
<p class="pfn" style="margin-top:16px"><b>Start of month:</b> enter your Budget and click Save. <b>Month end:</b> come back, enter Actual spent and click Submit.</p>
<div id="bpb"><div class="xtw"><table class="xtab" style="min-width:0"><thead><tr><th>Expense</th><th>Budget</th><th>Actual</th>${R?'<th class="bpx">Difference</th><th class="bpx">Status</th>':''}<th></th></tr></thead><tbody>${rows}<tr><td class="nm"><b>Total</b></td><td class="bpc"><span class="ml">Budget total</span><b id="bp-tb">${m(T.b)}</b></td><td class="bpc"><span class="ml">Actual total</span><b id="bp-ta">${m(T.a)}</b></td>${R?`<td class="bpx"><span class="ml">Difference</span><b>${dv>0?'+':dv<0?'−':''}${m(Math.abs(dv))}</b></td><td class="bpx"></td>`:''}<td></td></tr></tbody></table></div></div>
<div class="bpr" style="margin-top:14px"><div><label for="bp-nn">Add new expense</label><div class="in"><input id="bp-nn" maxlength="40" placeholder="e.g. Gym, Pet care"></div></div><div><label for="bp-nb">Budget (₹)</label><div class="in"><i class="cs">₹</i><input id="bp-nb" type="number" inputmode="decimal" min="0" step="any" placeholder="0"></div></div><button class="btn small" type="button" data-badd>+ Add</button></div>
<div class="pdr" style="margin-top:20px"><button class="btn lg" type="button" data-bsave>💾 Save Budget</button><button class="btn go lg" type="button" data-bsub>✅ Submit &amp; See Analysis</button><button class="btn lg" type="button" data-bpdf>⬇ Download PDF</button></div>
<div id="bpo">${R?result():''}</div></div></div>`}
function pdf(){read();const A=ana();if(!A.rows.length){toast('Add your expenses first.');return}
if(!(A.ta>0)){const ps=A.inc-A.tb,pc=x=>A.inc>0?Math.round(x/A.inc*100)+'%':'-';
rpkOnePager({title:'Monthly Budget Plan',sub:lab(S.ym),assump:'Monthly income '+m(A.inc)+'   |   Planned budget '+m(A.tb),kpis:[['MONTHLY INCOME',m(A.inc)],['PLANNED BUDGET',m(A.tb)],['PLANNED SAVINGS',(ps<0?'-':'')+m(Math.abs(ps)),ps<0?[200,50,45]:[5,150,105]]],tables:[{title:'Planned budget',sub:lab(S.ym),w0:200,head:['Expense','Budget','% of Income'],body:A.rows.map(r=>[r.n,m(r.b),pc(r.b)]).concat([['Total',m(A.tb),pc(A.tb)]]),hl:{[A.rows.length]:'gold'}},{title:'Tip',w0:515,head:['Before you start the month'],body:[[ps<0?'Your budget is more than your income. Reduce some expenses.':'Aim to save at least 20% of income ('+m(A.inc*.2)+'). Pay yourself first by moving savings on salary day.'],['At month end, open Budget Planner and add your actual expenses to get the full analysis.']]}],disc:'Educational plan based on the numbers you entered. Not financial advice.',file:'Budget-Plan-'+S.ym+'.pdf'});return}
const tb=[{title:'Budget vs Actual',sub:lab(S.ym),w0:150,head:['Expense','Budget','Actual','Difference'],body:A.rows.map(r=>[r.n,m(r.b),m(r.a),(r.v>0?'+':r.v<0?'-':'')+m(Math.abs(r.v))]).concat([['Total',m(A.tb),m(A.ta),(A.ta>A.tb?'+':'-')+m(Math.abs(A.ta-A.tb))]]),hl:{[A.rows.length]:'gold'}},{title:'Your analysis',w0:515,head:['What we found'],body:A.ins.map(x=>[x])}];
rpkOnePager({title:'Monthly Budget Report',sub:lab(S.ym),assump:'Monthly income '+m(A.inc)+'   |   Planned budget '+m(A.tb)+'   |   Actual spent '+m(A.ta),kpis:[['ACTUAL SPENT',m(A.ta)],[A.ta>A.tb?'OVER BUDGET BY':'UNDER BUDGET BY',m(Math.abs(A.ta-A.tb)),A.ta>A.tb?[200,50,45]:[5,150,105]],['SAVINGS RATE',A.rate+'%',A.rate>=20?[5,150,105]:[200,50,45]]],tables:tb,disc:'Educational report based on the numbers you entered. Not financial advice.',file:'Budget-Report-'+S.ym+'.pdf'})}
const ex=document.getElementById('v-explore'),_r=window.renderExplore,TILE='<a class="xtile" href="#explore/budget"><h3>Budget Planner</h3><p>Plan your month, track spending, get analysis</p><span class="go">Open →</span></a>';
window.renderExplore=function(sub){if(sub===OPTK){S.d=null;render();return}_r(sub);if(!['returns','portfolio','tax','sip','emi'].includes(sub)){const g=ex.querySelector('.xgrid');if(g&&!g.querySelector('[href="#explore/budget"]'))g.insertAdjacentHTML('beforeend',TILE)}};
ex.addEventListener('click',t=>{const x=t.target;if(!document.getElementById('bpb'))return;let b;
if(b=x.closest('[data-bd]')){read();S.d.items.splice(+b.dataset.bd,1);render()}
else if(x.closest('[data-badd]')){read();const n=document.getElementById('bp-nn').value.trim(),v=document.getElementById('bp-nb').value;if(!n){toast('Type the expense name.');return}S.d.items.push({n,b:v,a:'',c:1});render()}
else if(x.closest('[data-bsave]')){read();if(!(num(S.d.inc)>0)){toast('Enter your monthly income.');return}if(!(tots().b>0)){toast('Enter a budget for at least one expense.');return}S.d.saved=1;save();toast('Budget saved for '+lab(S.ym));if(!S.res)document.getElementById('bpo').innerHTML=planSum()}
else if(x.closest('[data-bsub]')){read();if(!(num(S.d.inc)>0)){toast('Enter your monthly income.');return}if(!(tots().a>0)){toast('Enter your actual spending.');return}S.d.saved=1;S.d.done=1;S.res=1;save();render();document.getElementById('bpo').scrollIntoView({behavior:'smooth',block:'start'});toast('Analysis ready and saved')}
else if(x.closest('[data-bpdf]'))pdf()});
ex.addEventListener('change',t=>{if(t.target.id==='bp-m'&&document.getElementById('bpb')){S.ym=t.target.value;load();render()}});
ex.addEventListener('input',t=>{const c=t.target.classList;if(!document.getElementById('bpb')||!(c&&(c.contains('bb')||c.contains('ba'))))return;read();const T=tots(),a=document.getElementById('bp-tb'),b=document.getElementById('bp-ta');if(a)a.textContent=m(T.b);if(b)b.textContent=m(T.a);if(S.res){S.res=0;ex.querySelectorAll('.bpx').forEach(n=>n.remove());const o=document.getElementById('bpo');if(o)o.innerHTML=''}});
})();
</script>
<style id="wl-css">
.xhero{display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:16px;margin:0 0 22px}
.xey{display:block;font-size:12px;font-weight:700;letter-spacing:.2em;color:#9A7420;margin:0 0 8px}
.xhero h2{margin:0;font:600 clamp(26px,4.2vw,40px)/1.1 var(--hd-serif,var(--h));letter-spacing:-.02em;color:var(--ink)}
.xhero h2::after{content:"";display:block;width:64px;height:3px;border-radius:3px;margin-top:12px;background:linear-gradient(90deg,#C9A24B,#F3E2A9)}
.xhero p{margin:12px 0 0;color:var(--mu);font-size:15.5px;max-width:560px}
.wchip{display:inline-flex;align-items:center;gap:8px;min-height:44px;padding:8px 16px;border-radius:999px;cursor:pointer;font:600 14.5px var(--h);color:var(--ink);background:var(--sf);border:1px solid color-mix(in srgb,var(--gold,#C9A24B) 60%,var(--ln));box-shadow:0 4px 14px rgba(7,30,54,.08);transition:box-shadow .2s,transform .15s}
.wchip:hover{box-shadow:0 8px 20px rgba(7,30,54,.14);transform:translateY(-1px)}.wchip b{font-variant-numeric:tabular-nums}.wchip i{font-style:normal;color:var(--mu);transition:transform .2s}.wchip[aria-expanded=true] i{transform:rotate(180deg)}
.wpanel{margin:-8px 0 22px;padding:18px 20px;border-radius:18px;border:1px solid color-mix(in srgb,var(--gold,#C9A24B) 40%,var(--ln));background:linear-gradient(135deg,#FFFBF0,#F4FBF9);color:#14213D;display:flex;flex-wrap:wrap;gap:16px;align-items:center;justify-content:space-between}
.wpanel[hidden]{display:none}.wpanel small{display:block;color:#55627A;font-weight:600;font-size:12.5px}.wpanel .n{font:700 30px/1.1 var(--h);font-variant-numeric:tabular-nums}.wpanel p{margin:4px 0 0;color:#55627A;font-size:13.5px}
.xtrust{margin:22px 0 0;text-align:center;color:var(--mu);font-size:13px;letter-spacing:.02em}
.wpk{position:relative;display:flex;flex-direction:column;align-items:center;gap:4px;padding:22px 16px 18px;border-radius:18px;border:1px solid var(--ln);background:var(--sf);text-align:center}
.wpk.pop{border:2px solid var(--gold,#C9A24B);box-shadow:0 10px 28px rgba(201,162,75,.22)}
.wpk .wp{font:700 38px/1 var(--h);color:var(--br)}.wpk small{color:var(--mu)}.wpk .wpr{font:700 22px var(--h);margin-top:6px}.wpk p{margin:2px 0 10px;color:var(--mu);font-size:13.5px}
.wtag{position:absolute;top:-11px;padding:3px 12px;border-radius:999px;background:var(--gold,#C9A24B);color:#fff;font-size:12px;font-weight:700}
.wpk .btn{width:100%}
.wbal{display:flex;align-items:center;gap:18px;flex-wrap:wrap;padding:18px 20px;border-radius:16px;margin:0 0 6px;background:var(--so);border-left:5px solid var(--gold,#C9A24B)}
.wbal .n{font:700 42px/1 var(--h);color:var(--br)}
.wpos{color:#059669;font-weight:700}.wneg{color:#D9342B;font-weight:700}
</style>
<style id="mob-css">
/* ===== Mobile polish (iPhone + Android) for Explore and Budget Planner ===== */
#v-explore{max-width:100%}.xtile,.btn,.wchip,.bpd{-webkit-tap-highlight-color:transparent}
.xtw,.spw{-webkit-overflow-scrolling:touch}
@media(max-width:720px){
.xgrid{grid-template-columns:1fr;gap:14px}.xtile{padding:20px;border-radius:18px}.xtile h3{font-size:20px}
.xhero{flex-direction:column;align-items:stretch;gap:14px}.xhero p{font-size:14.5px}
.wchip{width:100%;justify-content:center}.wpanel{padding:16px}.wpanel .row{width:100%}.wpanel .row .btn{flex:1;text-align:center}
.xcard{border-radius:18px}.xgate{padding:28px 16px}.xgate .row .btn{width:100%}
.xg3{grid-template-columns:1fr}.wbal{padding:14px 16px}.wbal .n{font-size:34px}
.bpr{padding:14px;gap:12px}.bpr>div{flex:1 1 100%}.bpr>.btn{width:100%}
.bpt{display:grid;grid-template-columns:1fr 1fr;gap:8px}.bpt button{width:100%;min-height:46px;padding:8px 6px;font-size:14px}
#bpb .xtab tbody tr{grid-template-columns:1fr 1fr}
#bpb td:empty{display:none}#bpb td:has(.bpd){grid-column:1/-1}
.bpd{width:100%;min-height:40px;border:1px solid var(--ln);border-radius:10px;font-size:15px}.bpd::after{content:" Remove";font-size:13px;font-weight:600}
.sdk{grid-template-columns:1fr 1fr}.sdk b{font-size:18px}.sdk div{padding:12px}
.bpa{margin-bottom:70px}.bpa .btn{width:100%}
.pdr .btn{width:100%}.bpi{padding:14px 16px}
.pfh{font-size:18px}}
@media(max-width:480px){#usr>span:first-child{display:none}}
@media(min-width:900px){.xgrid{grid-template-columns:repeat(3,minmax(0,1fr))}}
@media(min-width:721px) and (max-width:899px){.xgrid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:380px){.xhead h2{font-size:22px}.xhead p{font-size:14px}.sdk{grid-template-columns:1fr}}
</style>
<script id="wl-js">
(function(){
const api=(...a)=>window.rpkApi(...a);
const WC={per:200,hours:24,welcome:600,packs:[[200,200,'Starter'],[1000,500,'Popular'],[5000,1000,'Best value']]};
const OPT={returns:['My Investment Returns','See How Your Current Investment is Growing'],portfolio:['Stock Portfolio Analysis','Nifty 500 Shares Analysis'],tax:['Income Tax Calculator','New Tax Regime · FY 2026-27'],sip:['SIP Calculator','Delay cost and target-based SIP plan'],emi:['Home Loan EMI Calculator','10 to 30 year tenures, side by side'],budget:['Budget Planner','Plan your month, track spending, get analysis']};
const e=s=>String(s==null?'':s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
window.RPK_PTS=window.RPK_PTS||{bal:0,unl:{},report:0,friends:0,code:'',streakDay:0,streakToday:false};
let TX=[];
const left=k=>{const x=window.RPK_PTS.unl[k];if(!x)return 0;const t=new Date(x).getTime();return t>Date.now()?Math.ceil((t-Date.now())/864e5):0};
const fd=t=>new Date(t).toLocaleString('en-IN',{day:'numeric',month:'short',hour:'numeric',minute:'2-digit',hour12:true});
const n0=n=>Number(n).toLocaleString('en-IN'),BK='<div style="margin-bottom:14px"><a class="btn small" href="#explore">← Back to Explore</a></div>';
const WH=(t,p)=>`<div class="xhead"><h2>${t}</h2><p>${p}</p></div>`;
let CUR={v:'',k:''};
const DISC='Points (including free welcome points) can be used only on Explore options. They have no cash value and cannot be transferred. Purchases are subject to our Terms and Refund Policy. Explore tools give educational estimates and are not investment, tax or legal advice.';
function again(){if(CUR.v==='wallet')wallet();else if(CUR.v==='pay')paywall(CUR.k)}

async function buy(i){}/* replaced: real wallet recharge is handled by the data-wbuy interceptor in payu-api below */

async function unlock(k){if(!OPT[k]||!USER)return;if(left(k)>0){goTo(k);return}
if(window.RPK_PTS.bal<WC.per){toast('Not enough points. Please recharge your wallet.');location.hash='#explore/wallet';return}
const r=await api('POST','/api/wallet/unlock',{key:k});
if(!r.ok){toast((r.data&&r.data.message)||'Could not unlock. Please try again.');return}
window.RPK_PTS.bal=r.data.balance;window.RPK_PTS.unl[k]=r.data.expires_at;
TX.unshift({t:Date.now(),p:-WC.per,n:'Unlocked '+OPT[k][0]+' (valid till '+fd(r.data.expires_at)+')'});TX=TX.slice(0,40);
toast(OPT[k][0]+' unlocked');if(typeof updUsr==='function')updUsr();goTo(k)}

function goTo(k){if(location.hash==='#explore/'+k)window.renderExplore(k);else location.hash='#explore/'+k}

function paywall(k){CUR={v:'pay',k};const ok=window.RPK_PTS.bal>=WC.per,el=document.getElementById('v-explore');
el.innerHTML=BK+`<div class="xcard">${WH(OPT[k][0],OPT[k][1])}<div class="xgate"><h3>🔒 Unlock this option with ${n0(WC.per)} points</h3><p>One unlock lets you use <b>${OPT[k][0]}</b> as many times as you like. It stays valid for ${WC.hours} hours after you unlock.</p>
<div class="wbal" style="max-width:420px;margin:0 auto 16px;text-align:left"><div><small style="color:var(--mu);font-weight:600">Your wallet balance</small><div class="n">${n0(window.RPK_PTS.bal)}</div></div><small style="color:var(--mu)">points</small></div>
<div class="row">${ok?`<button class="btn go lg" type="button" data-wunl="${k}">Unlock for ${n0(WC.per)} points</button>`:`<a class="btn go lg" href="#explore/wallet">Recharge wallet</a>`}<a class="btn lg" href="#explore">Maybe later</a></div>${ok?'':`<p style="margin-top:14px">You need ${n0(WC.per-window.RPK_PTS.bal)} more points.</p>`}</div></div>`;scrollTo(0,0)}

function wallet(){CUR={v:'wallet',k:''};const el=document.getElementById('v-explore');
if(!USER){el.innerHTML=BK+'<div class="xcard">'+WH('My Wallet','Points for Explore options')+'<div class="xgate"><h3>Login or sign up to continue</h3><p>Your wallet is saved to your account.</p><div class="row"><button class="btn go lg" type="button" data-xlogin="su">Sign up</button><button class="btn lg" type="button" data-xlogin="li">Login</button></div></div></div>';scrollTo(0,0);return}
const bal=window.RPK_PTS.bal,nOpt=Math.floor(bal/WC.per);
const pp=n=>'₹'+(Math.round(n*100)/100).toString(),packs=WC.packs.map((p,i)=>{const o=Math.floor(p[0]/WC.per),r=p[0]%WC.per;return`<div class="wpk${p[2]==='Best value'?' pop':''}">${p[2]?`<span class="wtag">${e(p[2])}</span>`:''}<b class="wp">${n0(p[0])}</b><small>points</small><div class="wpr">₹${n0(p[1])}</div><p>${o} Explore option${o>1?'s':''}${r?' + '+r+' extra points':''}<br>${pp(p[1]/p[0])} per point</p><button class="btn go" type="button" data-wbuy="${i}">Recharge ₹${n0(p[1])}</button></div>`}).join('');
const opts=Object.keys(OPT).map(k=>{const d=left(k);return`<tr><td class="nm"><span class="ml">Option</span><span class="xnm">${OPT[k][0]}</span></td><td><span class="ml">Cost</span>${n0(WC.per)} points</td><td><span class="ml">Status</span>${d>0?`<span class="wpos">Unlocked · valid till ${fd(window.RPK_PTS.unl[k])}</span>`:'Locked'}</td><td><span class="ml">Action</span>${d>0?`<a class="btn small" href="#explore/${k}">Open</a>`:`<button class="btn go small" type="button" data-wunl="${k}">Unlock · ${n0(WC.per)} pts</button>`}</td></tr>`}).join('');
const hist=TX.length?TX.map(t=>`<tr><td><span class="ml">Date</span>${new Date(t.t).toLocaleDateString('en-IN',{day:'numeric',month:'short',year:'numeric'})}</td><td class="nm"><span class="ml">Details</span>${e(t.n)}</td><td><span class="ml">Points</span><span class="${t.p>0?'wpos':'wneg'}">${t.p>0?'+':'−'}${n0(Math.abs(t.p))}</span></td></tr>`).join(''):'<tr><td colspan="3" style="color:var(--mu)">No activity yet this session.</td></tr>';
el.innerHTML=BK+`<div class="xcard">${WH('My Wallet','Recharge and use points on Explore options · '+n0(WC.per)+' points per option')}<div class="xbody">
<div class="wbal"><div><small style="color:var(--mu);font-weight:600">Available points</small><div class="n">${n0(bal)}</div></div><div style="color:var(--mu)">${nOpt>0?`Enough for ${nOpt} Explore option${nOpt>1?'s':''}`:'Recharge to unlock Explore options'}</div></div>
<h3 class="pfh">Recharge wallet</h3><div class="xg3" style="padding-top:8px">${packs}</div>${CFG.rzp?'<p class="pfs">Payment is handled securely by PayU.</p>':'<p class="pfs" style="color:var(--bd)">Test mode: payment gateway is not connected yet. Points are added instantly for testing.</p>'}
<h3 class="pfh">Your Explore options</h3><div class="xtw"><table class="xtab" style="min-width:0"><thead><tr><th>Option</th><th>Cost</th><th>Status</th><th></th></tr></thead><tbody>${opts}</tbody></table></div>
<h3 class="pfh">Wallet history</h3><div class="xtw"><table class="xtab" style="min-width:0"><thead><tr><th>Date</th><th>Details</th><th>Points</th></tr></thead><tbody>${hist}</tbody></table></div>
<div class="pfn" style="margin-top:20px">${DISC}</div></div></div>`;scrollTo(0,0)}

function decorate(){const el=document.getElementById('v-explore'),g=el.querySelector('.xgrid');if(!g||el.querySelector('.xhero'))return;const sh=el.querySelector('.sh');if(sh)sh.remove();
const chip=USER?`💰 <span>Wallet</span> <b>${n0(window.RPK_PTS.bal)}</b> points <i>▾</i>`:`🎁 <span>${n0(WC.welcome)} free points</span> <i>▾</i>`;
const panel=USER?`<div><small>Wallet balance</small><div class="n">${n0(window.RPK_PTS.bal)} points</div><p>Each Explore option: ${n0(WC.per)} points. Each unlock is valid for ${WC.hours} hours. Free points are for Explore only.</p></div><div class="row" style="gap:8px"><a class="btn go small" href="#explore/wallet">+ Recharge</a><a class="btn small" href="#explore/wallet">Details &amp; history</a></div>`:`<div><small>Welcome gift</small><div class="n">${n0(WC.welcome)} free points</div><p>Login to claim. Each Explore option needs ${n0(WC.per)} points. Free points are for Explore only.</p></div><div class="row" style="gap:8px"><button class="btn go small" type="button" data-xlogin="su">Sign up</button><button class="btn small" type="button" data-xlogin="li">Login</button></div>`;
g.insertAdjacentHTML('beforebegin',`<div class="xhero"><div><span class="xey">EXPLORE</span><h2>Smart tools for smarter money decisions</h2><p>Six smart tools made for Indian investors. Pick one and get a clear, simple answer in minutes.</p></div><button class="wchip" type="button" data-wchip aria-expanded="false" aria-controls="wpn">${chip}</button></div><div class="wpanel" id="wpn" hidden>${panel}</div>`);
g.insertAdjacentHTML('afterend','<p class="xtrust">Educational tools · Calculations run in your browser · Not investment, tax or legal advice</p>')}

const inner=window.renderExplore;
window.renderExplore=function(sub){
if(sub==='wallet'){wallet();return}
if(OPT[sub]&&USER&&left(sub)<=0){paywall(sub);return}
CUR={v:'',k:''};inner(sub);if(!OPT[sub])decorate()};
const ex=document.getElementById('v-explore');
ex.addEventListener('click',t=>{const x=t.target,b=x.closest('[data-wbuy]'),u=x.closest('[data-wunl]'),c=x.closest('[data-wchip]');if(b)buy(+b.dataset.wbuy);else if(u)unlock(u.dataset.wunl);else if(c){const p=document.getElementById('wpn'),o=p.hidden;p.hidden=!o;c.setAttribute('aria-expanded',o?'true':'false')}});

function guard(){if(typeof USER==='undefined'||!USER||CUR.v==='pay'||CUR.v==='wallet')return false;
const q=('#'+(window.rpkVH?rpkVH():location.hash.slice(1))).match(/^#explore\/([a-z]+)/),k=q&&q[1];if(!k||!OPT[k])return false;
if(left(k)>0)return false;
toast('Your '+WC.hours+'-hour access has ended. Unlock again with '+n0(WC.per)+' points.');paywall(k);return true}
setInterval(guard,15000);
['visibilitychange','focus','pageshow'].forEach(n=>addEventListener(n,()=>{if(n!=='visibilitychange'||!document.hidden)guard()}));
['click','input','change'].forEach(n=>ex.addEventListener(n,t=>{if(guard()){t.stopPropagation();t.preventDefault()}},true));
if(/^#explore/.test(location.hash))route();

window.rpkWalletRefresh=function(){
if(CUR.v==='wallet'){wallet();return}
if(CUR.v==='pay'){if(left(CUR.k)>0)goTo(CUR.k);else paywall(CUR.k);return}
const chipB=document.querySelector('#v-explore .xhero .wchip b');if(chipB)chipB.textContent=n0(window.RPK_PTS.bal);
const pn=document.querySelector('#wpn .n');if(pn)pn.textContent=n0(window.RPK_PTS.bal)+' points'};
})();
</script>
<style id="sample-css">
.spx{--c1:#C9A24B;--c2:#0F766E;--c3:#2563EB;--c4:#7C3AED;--c5:#DB2777;--c6:#EA580C;--c7:#0891B2;--c8:#65A30D;--c9:#64748B}
.sptabs{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:18px}
.sptab{flex:1 1 150px;display:flex;flex-direction:column;gap:2px;text-align:left;padding:14px 16px;border-radius:16px;border:2px solid var(--ln);background:var(--sf);color:var(--ink);cursor:pointer;font:inherit;transition:.2s}
.sptab b{font-size:17px}.sptab small{color:var(--mu);font-size:13px}
.sptab:hover{transform:translateY(-2px)}
.sptab.on{border-color:var(--c1);background:linear-gradient(135deg,rgba(201,162,75,.18),rgba(15,118,110,.12));box-shadow:0 8px 22px rgba(7,30,54,.15)}
.spgrid{display:grid;gap:22px;grid-template-columns:minmax(220px,300px) 1fr;align-items:center}
.spdon{position:relative;max-width:300px;margin:0 auto;width:100%}
.spdon svg{width:100%;height:auto;display:block;transform:rotate(-90deg)}
.spdon circle{transition:stroke-dasharray .5s}
.spmid{position:absolute;inset:0;display:grid;place-content:center;text-align:center}
.spmid b{font-size:28px;color:var(--ink)}.spmid small{color:var(--mu);font-weight:600}
.sptb{width:100%;border-collapse:collapse;font-size:15px}
.sptb th{text-align:left;background:var(--so);color:var(--br);font-size:13px;padding:10px 12px}
.sptb th:last-child,.sptb td:last-child{text-align:right}
.sptb td{padding:9px 12px;border-bottom:1px solid var(--ln)}
.sptb td i{display:inline-block;width:12px;height:12px;border-radius:4px;margin-right:9px;vertical-align:-1px}
.sptb .bar{display:block;height:6px;border-radius:6px;margin-top:6px;opacity:.85}
.sptb tfoot td{font-weight:700;background:var(--so);border-bottom:0}
.spkp{display:grid;gap:10px;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));margin-top:16px}
.spkp div{padding:12px 14px;border-radius:14px;background:var(--so);border:1px solid var(--ln)}
.spkp small{display:block;color:var(--mu);font-size:12.5px}.spkp b{font-size:19px;color:var(--ink)}
.sprisk{margin-top:24px;padding:18px 20px;border-radius:18px;border:1px solid #E8B4B4;border-left:6px solid #DC2626;background:color-mix(in srgb,#DC2626 7%,var(--sf))}
.sprisk h3{margin:0 0 10px;font:600 19px var(--hd-serif,var(--h));color:var(--ink)}
.sprisk ul{margin:0;padding-left:20px;display:grid;gap:7px;font-size:14.5px;color:var(--ink)}
.sprisk p{margin:12px 0 0;font-weight:700;font-size:14.5px;color:var(--ink)}
@media(max-width:720px){.spgrid{grid-template-columns:1fr}.spdon{max-width:240px}}
</style>
<script id="sample-js">
(function(){
const P={
safe:{n:'Safe Investor',ic:'🛡️',d:'Lower ups and downs',col:'#0F766E',a:[['Gold',10],['Silver',10],['InvIT',10],['REITs',10],['Large Cap',10],['Mid Cap',10],['Small Cap',10],['International Fund',10],['Bonds',20]],eq:40},
mod:{n:'Moderate Investor',ic:'⚖️',d:'Balanced growth and risk',col:'#2563EB',a:[['Gold',10],['Silver',10],['InvIT',10],['REITs',10],['Large Cap',15],['Mid Cap',15],['Small Cap',10],['International Fund',20]],eq:60},
agg:{n:'Aggressive Investor',ic:'🚀',d:'Higher growth, bigger swings',col:'#DB2777',a:[['Gold',20],['Large Cap',20],['Mid Cap',20],['Small Cap',20],['International Fund',20]],eq:80}};
const PAL=['#C9A24B','#94A3B8','#0F766E','#7C3AED','#2563EB','#EA580C','#DB2777','#0891B2','#65A30D'];
const COL={'Gold':PAL[0],'Silver':PAL[1],'InvIT':PAL[2],'REITs':PAL[3],'Large Cap':PAL[4],'Mid Cap':PAL[5],'Small Cap':PAL[6],'International Fund':PAL[7],'Bonds':PAL[8]};
const RISK=['<b>Market risk:</b> All investments can go up or down. You may get back less than you invested, including a loss of the full amount.','<b>No guarantee:</b> Returns are not assured or guaranteed. Past performance does not indicate future results.','<b>Sample only:</b> These portfolios are examples for education. They are not personal advice, a recommendation or an offer to buy or sell any product.','<b>Not personalised:</b> Your age, income, goals, tax position and time horizon are not considered. A label like "Safe" does not mean risk free.','<b>Gold and Silver:</b> Prices can swing sharply due to global demand, currency moves and policy changes, and may stay flat for years.','<b>Small and Mid Cap:</b> These can fall much more than large companies and can be hard to sell in stressed markets.','<b>InvIT and REITs:</b> Payouts are not fixed and can be cut. Unit prices can fall, trading volume may be low, and they depend on rent, tolls, occupancy and debt levels.','<b>International funds:</b> Subject to foreign market, currency, regulatory and overseas investment limit risks. Fund houses may pause fresh inflows.','<b>Bonds:</b> Value can fall when interest rates rise (interest rate risk), and the issuer may delay or default (credit risk). Some bonds are hard to sell early (liquidity risk).','<b>Taxes and costs:</b> Tax rules change and differ by product. Expense ratios, brokerage and exit loads reduce returns.','<b>Rebalancing:</b> Allocations drift as markets move. Rebalancing may cost money and trigger tax.','<b>Mutual funds and ETFs:</b> Mutual fund investments are subject to market risks. Read all scheme related documents carefully before investing.','<b>Advice:</b> Please consult a SEBI registered investment adviser before investing. Retirement Plan Karo is an educational tool and does not provide investment advice.'];
let cur='safe';
const TILE='<a class="xtile" href="#explore/sample"><h3>Sample Portfolio</h3><p>Safe, Moderate and Aggressive mixes</p><span class="go">Open →</span></a>';
function donut(a){let off=0;const R=70,C=2*Math.PI*R;return '<svg viewBox="0 0 200 200" role="img" aria-label="Allocation chart"><circle cx="100" cy="100" r="'+R+'" fill="none" stroke="var(--so)" stroke-width="34"/>'+a.map(x=>{const l=C*x[1]/100,s='<circle cx="100" cy="100" r="'+R+'" fill="none" stroke="'+COL[x[0]]+'" stroke-width="34" stroke-dasharray="'+Math.max(l-1.5,0)+' '+(C-l+1.5)+'" stroke-dashoffset="'+(-off)+'"/>';off+=l;return s}).join('')+'</svg>'}
function render(){const p=P[cur],el=document.getElementById('v-explore');
const tabs=Object.keys(P).map(k=>'<button type="button" class="sptab'+(k===cur?' on':'')+'" data-sp="'+k+'"><b>'+P[k].ic+' '+P[k].n.replace(' Investor','')+'</b><small>'+P[k].d+'</small></button>').join('');
const rows=p.a.map(x=>'<tr><td><i style="background:'+COL[x[0]]+'"></i>'+x[0]+'<span class="bar" style="width:'+x[1]*4+'%;background:'+COL[x[0]]+'"></span></td><td>'+x[1]+'%</td></tr>').join('');
el.innerHTML='<div style="margin-bottom:14px"><a class="btn small" href="#explore">← Back to Explore</a></div><div class="xcard spx"><div class="xhead"><h2>Sample Portfolio</h2><p>Example mixes based on your risk appetite</p></div><div class="xbody"><div class="sptabs">'+tabs+'</div><div class="spgrid"><div class="spdon">'+donut(p.a)+'<div class="spmid"><b>100%</b><small>'+p.n+'</small></div></div><div><table class="sptb"><thead><tr><th>'+p.n+'</th><th>Allocation</th></tr></thead><tbody>'+rows+'</tbody><tfoot><tr><td>Total</td><td>100%</td></tr></tfoot></table></div></div><div class="spkp"><div><small>Equity (Large, Mid, Small, International)</small><b>'+p.eq+'%</b></div><div><small>Assets in mix</small><b>'+p.a.length+'</b></div><div><small>Risk level</small><b style="color:'+p.col+'">'+p.n.split(' ')[0]+'</b></div></div><div class="sprisk"><h3>⚠️ Risk Disclosure</h3><ul>'+RISK.map(r=>'<li>'+r+'</li>').join('')+'</ul><p>Investments are subject to market risks. Please read all related documents carefully and invest only what you can afford to lose.</p></div></div></div>';scrollTo(0,0)}
const prev=window.renderExplore;
window.renderExplore=function(sub){
if(sub==='sample'){render();return}
prev(sub);
const g=document.querySelector('#v-explore .xgrid');
if(g&&!g.querySelector('[href="#explore/sample"]'))g.insertAdjacentHTML('beforeend',TILE);
const h=document.querySelector('#v-explore .xhero p');if(h)h.textContent=h.textContent.replace('Six smart tools','Seven smart tools')};
document.getElementById('v-explore').addEventListener('click',t=>{const b=t.target.closest('[data-sp]');if(b&&P[b.dataset.sp]){cur=b.dataset.sp;render()}});
if(/^#explore/.test(location.hash))route();
})();
</script>
<style id="ow-css">
.owtb{width:100%;border-collapse:collapse;font-size:15.5px}
.owtb th{text-align:left;background:var(--so);color:var(--br);font-size:13.5px;padding:12px 14px;border-bottom:1px solid var(--ln)}
.owtb td{padding:14px;border-bottom:1px solid var(--ln);vertical-align:middle}
.owtb th:last-child,.owtb td:last-child{text-align:center;width:190px}
.owtb tr:last-child td{border-bottom:0}
.owtb .btn{min-width:120px}
.ownote{margin-top:16px;padding:12px 16px;border-radius:14px;background:var(--so);border:1px solid var(--ln);color:var(--mu);font-size:13.5px}
@media(max-width:600px){.owtb th:last-child,.owtb td:last-child{width:120px}.owtb .btn{min-width:90px;padding:10px 12px}.owtb td,.owtb th{padding:12px 10px}}
</style>
<script id="ow-js">
(function(){
const R=[['fd','Want to Invest in FD Upto 9% Interest Rate','cWVzOXRpenYvTFdrci9lbS5rbmlsZW5vLnllbm9tZWxiYXRzLy86c3B0dGg='],['bonds','Want to Invest in Bonds Upto 14% Interest Rate','cHBhLXNvaT1tcm9mdGFscF9tdHUmbm90dHViX2VyYWhzPW11aWRlbV9tdHUmcHBhc3RhaHc9ZWNydW9zX210dSZGNzc0NDQ9ZWRvQ2xhcnJlZmVyP2V0aXZuaS9sYXJyZWZlci9zZG5vYi9tb2MuaHRsYWV3dG5pdy53d3cvLzpzcHR0aA=='],['intl','Want to Invest in International Market','OTV1M3M1YncvQ0htUi9lbS5rbmlsZW5vLnllbm9tZG5pLy86c3B0dGg='],['mfs','Want to Invest in Mutual Fund or Indian Stocks','MTIwMTE9ZGlwcmcmYnA9ZXB5dCYyMzYwMT1kY3ByZz9yZXRzaWdlUi90bnVvY2NBL3BwYS9tb2MubmFoa2VyYWhzLnlpZC8vOnNwdHRo']];
const dec=s=>{try{return atob(s).split('').reverse().join('')}catch(e){return ''}};
const TILE='<a class="xtile" href="#explore/invest"><h3>One Window Investing</h3><p>FD, Bonds, International and Mutual Funds in one place</p><span class="go">Open →</span></a>';
function render(){const el=document.getElementById('v-explore');
const rows=R.map(r=>'<tr><td>'+r[1]+'</td><td><button type="button" class="btn go" data-ow="'+r[0]+'">Click</button></td></tr>').join('');
el.innerHTML='<div style="margin-bottom:14px"><a class="btn small" href="#explore">← Back to Explore</a></div><div class="xcard"><div class="xhead"><h2>One Window Investing</h2><p>Choose where you want to invest and get something extra</p></div><div class="xbody"><div class="xtw"><table class="owtb"><thead><tr><th>Investment Type</th><th>Use This Referral Link To Get Something Extra</th></tr></thead><tbody>'+rows+'</tbody></table></div><div class="ownote">Tap Click to open the partner website in a new tab. We may earn a referral reward if you sign up through these links, at no extra cost to you. These are third-party platforms. Interest rates shown are the maximum offered and are not guaranteed. Investments are subject to market risks. Please read all related documents carefully before investing. This is not investment advice.</div></div></div>';scrollTo(0,0)}
const prev=window.renderExplore;
window.renderExplore=function(sub){
if(sub==='invest'){render();return}
prev(sub);
const g=document.querySelector('#v-explore .xgrid');
if(g&&!g.querySelector('[href="#explore/invest"]'))g.insertAdjacentHTML('beforeend',TILE);
const h=document.querySelector('#v-explore .xhero p');if(h)h.textContent=h.textContent.replace('Seven smart tools','Eight smart tools')};
document.getElementById('v-explore').addEventListener('click',t=>{const b=t.target.closest('[data-ow]');if(!b)return;
const r=R.find(x=>x[0]===b.dataset.ow);if(!r)return;const u=dec(r[2]);if(!u)return;
try{if(typeof CFG!=='undefined'&&CFG.hook)fetch(CFG.hook,{method:'POST',mode:'no-cors',headers:{'Content-Type':'text/plain'},body:JSON.stringify({type:'referral_click',option:r[0],mobile:(typeof USER!=='undefined'&&USER)?USER.mobile:'',t:Date.now()})})}catch(x){}
const w=window.open(u,'_blank','noopener,noreferrer');if(!w)location.href=u});
if(/^#explore/.test(location.hash))route();
})();
</script>
<style id="gq-css">
.gqt{margin:28px 0 14px;padding-bottom:10px;border-bottom:1px solid var(--ln);font:600 19px var(--hd-serif,var(--h));color:var(--ink)}
.gqg{display:grid;gap:14px 16px;grid-template-columns:repeat(auto-fit,minmax(240px,1fr))}
.gqg .full{grid-column:1/-1}
.gqg label{display:block;font-weight:600;font-size:14px;margin-bottom:6px;color:var(--ink)}
.gqc{display:flex;flex-wrap:wrap;gap:8px}
.gqc button{min-height:44px;padding:8px 16px;border-radius:999px;border:1.5px solid var(--ln);background:var(--sf);color:var(--ink);font:600 14px var(--h);cursor:pointer;transition:.15s}
.gqc button.on{border-color:#0F766E;background:#0F766E;color:#fff}
.gqerr input,.gqerr select{border-color:#D9342B!important}.gqerr>label{color:#D9342B}
.gqh{margin-top:18px;padding:14px 16px;border-radius:14px;background:var(--so);border:1px solid var(--ln);font-size:14.5px}
.gqh b{color:var(--br)}.gqh ul{margin:6px 0 0;padding-left:20px;display:grid;gap:4px}
.gqk{display:flex;gap:10px;align-items:flex-start;margin-top:18px;font-size:13.5px;color:var(--mu)}.gqk input{width:22px;height:22px;flex:none;margin-top:2px}
.gqn{margin-top:14px;font-size:13px;color:var(--mu)}
.gqok{text-align:center;padding:10px 0 4px}.gqok .ic{width:60px;height:60px;border-radius:50%;margin:0 auto 10px;display:grid;place-items:center;background:#0F766E}.gqok h3{font:600 24px var(--hd-serif,var(--h));margin:6px 0;color:var(--ink)}
.gqref{display:inline-block;margin:6px 0 14px;padding:6px 14px;border-radius:999px;background:var(--so);font-weight:700;letter-spacing:.04em}
.gqs{width:100%;border-collapse:collapse;font-size:14.5px;text-align:left}.gqs td{padding:9px 12px;border-bottom:1px solid var(--ln);vertical-align:top}.gqs td:first-child{color:var(--mu);width:42%}
.gqx{display:grid;gap:12px;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));margin-top:10px}
.gqx a{display:block;padding:14px 16px;border-radius:14px;border:1px solid var(--ln);background:var(--sf);text-decoration:none;color:var(--ink)}.gqx a b{display:block}.gqx a small{color:var(--mu)}
@media(max-width:720px){.gqc button{flex:1 1 auto}}
</style>
<script id="gq-js">
(function(){
const e=s=>String(s==null?'':s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const n0=n=>Math.round(n).toLocaleString('en-IN'),m=n=>'₹'+n0(n),num=x=>parseFloat(x)||0;
const BK='<div style="margin-bottom:14px"><a class="btn small" href="#explore">← Back to Explore</a></div>';
const YN=['Yes','No'],EMP=['Salaried','Self-employed'],CIB=['Below 650','650 to 699','700 to 749','750 to 799','800 and above',"Don't know"];
const CV={'50 Lakh':5e6,'75 Lakh':75e5,'1 Crore':1e7,'1.5 Crore':15e6,'2 Crore':2e7,'3 Crore':3e7,'5 Crore':5e7},SIv={'5 Lakh':5e5,'10 Lakh':1e6,'15 Lakh':15e5,'25 Lakh':25e5,'50 Lakh':5e6,'1 Crore':1e7};
const yr=new Date().getFullYear(),YRS=Array.from({length:16},(_,i)=>String(yr-i));
const DOB={k:'dob',l:'Date of birth',t:'date',r:1},PAN={k:'pan',l:'PAN (optional, add only if you want a firmer quote)',t:'text',max:10,p:'ABCDE1234F'};
const P={
motor:{n:'Car / Bike',d:'New or renewal',f:[
{k:'vt',l:'Vehicle type',t:'chips',o:['Car','Bike'],r:1},{k:'vm',l:'Make and model',t:'text',p:'e.g. Maruti Swift VXi',r:1},{k:'vy',l:'Manufacturing year',t:'sel',o:YRS,r:1},{k:'vr',l:'Registration number (optional)',t:'text',max:13,p:'MP09AB1234'},
{k:'pt',l:'Policy type',t:'chips',o:['Comprehensive','Third-party only','Own damage only'],r:1},{k:'pe',l:'Current policy expiry date (if any)',t:'date'},{k:'cl',l:'Any claim in the last year?',t:'chips',o:YN},{k:'ncb',l:'No Claim Bonus',t:'sel',o:['0%','20%','25%','35%','45%','50%','Not sure']}]},
term:{n:'Term Insurance',d:'Life cover for family',f:[
DOB,{k:'gen',l:'Gender',t:'chips',o:['Male','Female','Other'],r:1},{k:'tob',l:'Smoke or use tobacco?',t:'chips',o:YN,r:1},{k:'inc',l:'Annual income (₹)',t:'num',i:1,r:1,p:'e.g. 1200000'},
{k:'occ',l:'Occupation',t:'sel',o:['Salaried','Self-employed','Business owner','Professional (doctor, CA, etc.)','Other'],r:1},{k:'edu',l:'Education',t:'sel',o:['Up to 12th','Graduate','Post graduate','Professional degree'],r:1},
{k:'cov',l:'Cover amount wanted',t:'sel',o:Object.keys(CV),r:1},{k:'till',l:'Cover till age',t:'sel',o:['60','65','70','75','85'],r:1},{k:'pay',l:'How do you want to pay?',t:'chips',o:['Monthly','Yearly','Limited pay (5 or 10 years)']},{k:'ex',l:'Existing life cover (₹, optional)',t:'num',i:1}]},
health:{n:'Health Insurance',d:'Hospital cover',f:[
{k:'who',l:'Who needs cover?',t:'multi',o:['Self','Spouse','Kids','Father','Mother'],r:1},{k:'age',l:'Age of eldest member',t:'num',r:1,p:'e.g. 45'},{k:'ages',l:'Ages of all members',t:'text',p:'e.g. 45, 42, 12'},
{k:'ped',l:'Any existing health conditions?',t:'multi',o:['None','Diabetes','Blood pressure','Heart','Thyroid','Asthma','Other'],r:1},{k:'si',l:'Sum insured wanted',t:'sel',o:Object.keys(SIv),r:1},{k:'ft',l:'Plan type',t:'chips',o:['Family floater','Individual']},
{k:'eh',l:'Already have a health policy?',t:'chips',o:YN},{k:'hp',l:'Preferred hospital (optional)',t:'text',p:'e.g. Bombay Hospital, Indore'}]},
card:{n:'Credit Card',d:'Best card for you',f:[
DOB,PAN,{k:'emp',l:'Employment type',t:'chips',o:EMP,r:1},{k:'co',l:'Company name',t:'text',w:['emp','Salaried'],r:1},{k:'mi',l:'Monthly income (₹)',t:'num',i:1,r:1,p:'e.g. 60000'},
{k:'ec',l:'Do you already have a credit card?',t:'chips',o:YN},{k:'cb',l:'CIBIL score (approx.)',t:'sel',o:CIB},{k:'sp',l:'Monthly card spend (₹, optional)',t:'num',i:1},
{k:'bn',l:'What matters most?',t:'multi',o:['Cashback','Travel','Fuel','Shopping rewards','Airport lounge','Lifetime free']}]},
loan:{n:'Personal Loan',d:'Quick personal funds',f:[
DOB,PAN,{k:'emp',l:'Employment type',t:'chips',o:EMP,r:1},{k:'co',l:'Company / business name',t:'text',r:1},{k:'mi',l:'Monthly income (₹)',t:'num',i:1,r:1,p:'e.g. 60000'},
{k:'la',l:'Loan amount needed (₹)',t:'num',i:1,r:1,p:'e.g. 500000'},{k:'lt',l:'Tenure',t:'sel',o:['12 months','24 months','36 months','48 months','60 months'],r:1},{k:'lp',l:'Purpose (optional)',t:'sel',o:['Medical','Wedding','Travel','Home renovation','Education','Debt consolidation','Other']},
{k:'ee',l:'Total existing EMIs per month (₹)',t:'num',i:1,p:'0 if none'},{k:'cb',l:'CIBIL score (approx.)',t:'sel',o:CIB}]},
lamf:{n:'Loan Against Mutual Funds',d:'Cash without selling',f:[
{k:'hn',l:'Name of folio holder',t:'text',r:1,p:'As in your mutual fund folio'},PAN,{k:'pv',l:'Approx. value of mutual funds (₹)',t:'num',i:1,r:1,p:'e.g. 1000000'},
{k:'ft2',l:'Type of funds held',t:'multi',o:['Equity','Debt','Hybrid'],r:1},{k:'rg',l:'Registrar (CAMS or KFintech)',t:'chips',o:['CAMS','KFintech','Both','Not sure'],r:1},{k:'la',l:'Loan amount needed (₹)',t:'num',i:1,r:1},
{k:'lt',l:'Tenure',t:'sel',o:['6 months','12 months','24 months','36 months'],r:1},{k:'ee',l:'Existing loan EMIs per month (₹, optional)',t:'num',i:1}]}};
const CT=[{k:'nm',l:'Full name',t:'text',r:1,ac:'name'},{k:'mb',l:'Mobile number',t:'text',r:1,max:10,p:'10 digit number',ac:'tel',inp:1},{k:'em',l:'Email ID',t:'text',r:1,ac:'email'},{k:'ct',l:'City',t:'text',r:1,ac:'address-level2'},{k:'pn',l:'PIN code',t:'text',r:1,max:6,inp:1},
{k:'ch',l:'How should we contact you?',t:'multi',o:['Call','WhatsApp','Email']},{k:'bt',l:'Best time to reach you',t:'chips',o:['Morning','Afternoon','Evening','Anytime']}];
const REL={motor:[['#explore/budget','Budget Planner','See how the premium fits your month']],term:[['#explore/budget','Budget Planner','Check the premium against your budget'],['#plan','Retirement Plan','Cover goals and retirement together']],health:[['#explore/budget','Budget Planner','Keep a medical line in your budget'],['#plan','Retirement Plan','Include health costs in retirement']],card:[['#explore/budget','Budget Planner','Track card spends every month']],loan:[['#explore/emi','Home Loan EMI Calculator','Compare tenures side by side'],['#explore/budget','Budget Planner','Check EMI against income']],lamf:[['#explore/portfolio','Stock Portfolio Analysis','Review what you hold'],['#explore/returns','My Investment Returns','See how your funds are growing']]};
const emi=(p,r,n)=>{const i=r/1200;return p*i*Math.pow(1+i,n)/(Math.pow(1+i,n)-1)};
const age=d=>{if(!d)return null;const b=new Date(d),t=new Date();let a=t.getFullYear()-b.getFullYear();if(t<new Date(t.getFullYear(),b.getMonth(),b.getDate()))a--;return a};
const NT={motor:'Insurance is the subject matter of solicitation. Read the policy wording, exclusions and add-ons before you buy. Third-party cover is required by law for every vehicle on the road.',term:'Insurance is the subject matter of solicitation. Term insurance is pure protection and most plans have no maturity benefit. Wrong or hidden facts about age, tobacco use, health or income can lead to a rejected claim.',health:'Insurance is the subject matter of solicitation. Check waiting periods, sub-limits, co-payment and exclusions. Tell the insurer about all existing conditions, as hidden facts can lead to a rejected claim.',card:'Subject to approval by the card issuer. Fees, interest, late charges and taxes apply, and a new application can affect your credit score. Spend only what you can repay.',loan:'Subject to the lender\'s approval and terms. Interest rate, processing fee and charges are set by the lender and shown in its Key Fact Statement. Missed EMIs hurt your credit score. We charge no fee, and nobody on our behalf will ask you to pay for approval.',lamf:'Mutual fund investments are subject to market risks. Read all scheme-related documents carefully. Your units are pledged to the lender. If their value falls, you may be asked to add security or the lender may sell your units.'};
const S={p:'term',v:{},ok:null,done:null};
function prefill(){if(typeof USER==='undefined'||!USER)return;const v=S.v;if(!v.nm)v.nm=((USER.name||'')+' '+(USER.surname||'')).trim();if(!v.mb)v.mb=USER.mobile||'';if(!v.em)v.em=USER.email||'';
try{const b=LS.g('rpk_bud_'+USER.mobile)||{},k=Object.keys(b).filter(x=>num(b[x].inc)>0).sort().pop();if(k&&!v.mi){v.mi=String(num(b[k].inc));if(!v.inc)v.inc=String(num(b[k].inc)*12);S.bud=1}}catch(x){}}
function fld(f){if(f.w&&S.v[f.w[0]]!==f.w[1])return'';const v=S.v[f.k];let h;
if(f.t==='chips'||f.t==='multi'){const on=x=>f.t==='multi'?(v||[]).includes(x):v===x;h='<div class="gqc">'+f.o.map(x=>`<button type="button" class="${on(x)?'on':''}" data-gk="${f.k}" data-gv="${e(x)}" aria-pressed="${on(x)}">${e(x)}</button>`).join('')+'</div>'}
else if(f.t==='sel')h=`<div class="in"><select data-gk="${f.k}"><option value="">Select</option>${f.o.map(x=>`<option${v===x?' selected':''}>${e(x)}</option>`).join('')}</select></div>`;
else h=`<div class="in">${f.t==='num'&&f.i?'<i class="cs">₹</i>':''}<input data-gk="${f.k}" type="${f.t==='num'?'number':f.t==='date'?'date':'text'}"${f.t==='num'?' inputmode="decimal" min="0" step="any"':''}${f.inp?' inputmode="numeric"':''}${f.max?' maxlength="'+f.max+'"':''}${f.ac?' autocomplete="'+f.ac+'"':''} placeholder="${e(f.p||'')}" value="${e(v)}"></div>`;
return`<div data-w="${f.k}"${f.t==='chips'||f.t==='multi'||f.k==='ages'?' class="full"':''}><label>${e(f.l)}${f.r?' *':''}</label>${h}</div>`}
function hint(){const v=S.v,p=S.p,L=[];
if(p==='term'){const i=num(v.inc);if(i>0){L.push(`A common guide is 10 to 15 times your yearly income: <b>${m(i*10)} to ${m(i*15)}</b>.`);if(CV[v.cov]){L.push(CV[v.cov]<i*10?`You picked ${v.cov}, which is below that guide. Consider going higher.`:`Your pick of ${v.cov} is in a sensible range.`)}}const a=age(v.dob);if(a!==null)L.push(a<18||a>65?'Term plans usually need an age between 18 and 65.':`Age ${a}: buying early keeps the premium lower for life.`);if(v.tob==='Yes')L.push('Tobacco use raises the premium. Answer honestly, as a wrong answer can lead to a rejected claim.')}
else if(p==='health'){const w=v.who||[],par=w.includes('Father')||w.includes('Mother');L.push(`For your members, a base cover of <b>${par?'₹15 to 25 lakh':w.length>1?'₹10 to 15 lakh':'₹5 to 10 lakh'}</b> is common, and a low-cost super top-up can add more.`);if((v.ped||[]).some(x=>x!=='None'))L.push('Existing conditions usually have a waiting period. Tell us everything so the quote is accurate.');if(num(v.age)>=45)L.push('Choose a plan with no or low co-payment and no room-rent limit.')}
else if(p==='card'){const i=num(v.mi);if(i>0)L.push(i<25000?'Some cards ask for income of ₹25,000 or more. We will look for cards that fit.':'Your income opens up many cards. Tell us your top benefit and we will narrow it down.');if(v.cb==='Below 650'||v.cb==='650 to 699')L.push('A score below 700 can limit approval. A secured or entry-level card may be suggested.');L.push('Applying to many banks together lowers your CIBIL score, so we share one quote at a time.')}
else if(p==='loan'){const a=num(v.la),n=parseInt(v.lt),i=num(v.mi);if(a>0&&n>0){const lo=emi(a,11,n),hi=emi(a,18,n);L.push(`Indicative EMI: <b>${m(lo)} to ${m(hi)}</b> a month (rates of about 11% to 18%; your actual rate depends on your profile).`);if(i>0){const r=Math.round((hi+num(v.ee))/i*100);L.push(r>50?`EMIs would take about ${r}% of your income at the higher rate. Lenders prefer under 50%, so a longer tenure or smaller amount may help.`:`EMIs would be about ${r}% of your income at the higher rate, which is comfortable.`)}}}
else if(p==='lamf'){const pv=num(v.pv),ft=v.ft2||[];if(pv>0&&ft.length){const f=ft.length===1&&ft[0]==='Debt'?.8:.5;L.push(`You may get up to about <b>${m(pv*f*.9)} to ${m(pv*f)}</b> (about ${f*100}% of fund value; it varies by lender and fund).`);if(num(v.la)>pv*f)L.push('The amount you asked for is above the usual limit. Please reduce it or add more funds.');L.push('Your units stay invested and are only pledged, so you do not have to sell them.')}}
else if(p==='motor')L.push('Keep your RC copy and previous policy handy. A claim-free year earns you a No Claim Bonus discount.');
return L.length?`<div class="gqh"><b>Quick estimate</b><ul>${L.map(x=>'<li>'+x+'</li>').join('')}</ul></div>`:''}
function draw(){const el=document.getElementById('gqb');if(!el)return;
if(S.done){const d=S.done;el.innerHTML=`<div class="gqok"><div class="ic"><svg viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg></div><h3>Our Team Will Contact You</h3><div class="gqref">Ref: ${e(d.ref)}</div><p style="color:var(--mu);margin:0 0 16px">Thank you, ${e(d.name)}. We have received your request for <b>${e(d.pn)}</b>. Our team will contact you on ${e(d.ch)} with your quotes.</p></div>
<h3 class="gqt">What you submitted</h3><div class="xtw"><table class="gqs"><tbody>${d.rows.map(r=>`<tr><td>${e(r[0])}</td><td>${e(r[1])}</td></tr>`).join('')}</tbody></table></div>
${CFG.hook?'':`<div class="pdr" style="margin-top:16px"><a class="btn lg" href="${d.mail}">Also email this request</a></div>`}
<h3 class="gqt">Make the most of this quote</h3><div class="gqx">${(REL[d.p]||[]).map(r=>`<a href="${r[0]}"><b>${e(r[1])}</b><small>${e(r[2])}</small></a>`).join('')}</div>
<div class="pdr" style="margin-top:20px"><button class="btn go lg" type="button" data-gnew>Get another quote</button></div>`;return}
const tabs=Object.keys(P).map(k=>`<button type="button" class="sptab${k===S.p?' on':''}" data-gp="${k}"><b>${P[k].n}</b><small>${P[k].d}</small></button>`).join('');
let rec='';try{const h=LS.g('rpk_quotes_'+S.v.mb)||[];if(h.length)rec=`<h3 class="gqt">Your recent requests</h3><div class="xtw"><table class="gqs"><tbody>${h.slice(0,5).map(x=>`<tr><td>${new Date(x.t).toLocaleDateString('en-IN',{day:'numeric',month:'short',year:'numeric'})}</td><td>${e(x.n)} · ${e(x.ref)}</td></tr>`).join('')}</tbody></table></div>`}catch(x){}
el.innerHTML=`<div class="sptabs">${tabs}</div>${S.bud&&(S.p==='card'||S.p==='loan'||S.p==='term')?'<p class="pfn" style="margin:0 0 14px">Income is pre-filled from your Budget Planner. You can change it.</p>':''}
<h3 class="gqt" style="margin-top:6px">${P[S.p].n}: your details</h3><div class="gqg">${P[S.p].f.map(fld).join('')}</div><div id="gqh">${hint()}</div>
<h3 class="gqt">How can we reach you?</h3><div class="gqg">${CT.map(fld).join('')}</div>
<label class="gqk"><input type="checkbox" id="gqk"${S.v.ok?' checked':''}><span>I agree to be contacted by call, SMS, WhatsApp or email about this request, even if my number is on a DND list, and I allow my details to be shared with insurers, banks, lenders and partner advisers only to prepare my quote. I can withdraw this consent any time. *</span></label>
<label class="gqk"><input type="checkbox" id="gqa"${S.v.ak?' checked':''}><span>I understand that Retirement Plan Karo is an educational platform and not an insurer, bank or lender, that quotes are indicative and not advice, and that the provider decides the final terms. * <button class="link" type="button" data-legal="quotes">Read full disclosure</button></span></label>
<div class="pdr" style="margin-top:20px"><button class="btn go lg" type="button" data-gsub>Get My Quotes →</button></div>
<p class="gqn"><b>Important:</b> ${NT[S.p]} We never ask for OTP, card number, CVV or passwords. This is for education only and is not financial advice. <button class="link" type="button" data-legal="quotes">Full disclosure</button> · <button class="link" type="button" data-legal="privacy">Privacy Policy</button></p>${rec}`}
function submit(){const v=S.v,f=P[S.p].f.concat(CT),bad=[];
f.forEach(x=>{if(x.w&&v[x.w[0]]!==x.w[1])return;const val=v[x.k],empty=x.t==='multi'?!(val&&val.length):!String(val==null?'':val).trim();if(x.r&&empty)bad.push(x.k)});
const t=(k,ok)=>{if(!ok&&!bad.includes(k))bad.push(k)};
t('mb',!v.mb||/^[6-9]\d{9}$/.test(v.mb));t('em',!v.em||/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.em));t('pn',!v.pn||/^\d{6}$/.test(v.pn));t('pan',!v.pan||/^[A-Za-z]{5}\d{4}[A-Za-z]$/.test(v.pan));
if(v.dob){const a=age(v.dob);t('dob',a>=18&&a<=(S.p==='term'?65:80))}
document.querySelectorAll('#gqb .gqerr').forEach(n=>n.classList.remove('gqerr'));
if(bad.length){bad.forEach(k=>{const n=document.querySelector('#gqb [data-w="'+k+'"]');if(n)n.classList.add('gqerr')});const n=document.querySelector('#gqb .gqerr');if(n)n.scrollIntoView({behavior:'smooth',block:'center'});toast('Please fix the highlighted fields.');return}
if(!v.ok||!v.ak){toast('Please tick both boxes to continue.');return}
const rows=[],det={};f.forEach(x=>{if(x.w&&v[x.w[0]]!==x.w[1])return;const val=Array.isArray(v[x.k])?v[x.k].join(', '):String(v[x.k]==null?'':v[x.k]).trim();if(!val)return;det[x.k]=val;
const lbl=x.l.replace(/ \(.*\)$/,'');rows.push([lbl,x.k==='pan'?'Provided':x.t==='num'&&x.i?m(num(val)):val])});
const ref='GQ'+Date.now().toString(36).toUpperCase(),pn=P[S.p].n,ch=(v.ch&&v.ch.length?v.ch.join(' / '):'call or WhatsApp');
const body=encodeURIComponent('Quote request '+ref+' for '+pn+'\n\n'+rows.map(r=>r[0]+': '+r[1]).join('\n')),mail='mailto:'+CFG.mail+'?subject='+encodeURIComponent('Quote request: '+pn+' ('+ref+')')+'&body='+body;
try{if(CFG.hook)fetch(CFG.hook,{method:'POST',mode:'no-cors',headers:{'Content-Type':'text/plain'},body:JSON.stringify({type:'quote_request',ref,product:S.p,productName:pn,consent:{given:true,acknowledged:true,version:'2026-10',ts:new Date().toISOString()},ts:new Date().toISOString(),details:det})})}catch(x){}
try{const k='rpk_quotes_'+v.mb,h=LS.g(k)||[];h.unshift({ref,n:pn,t:Date.now()});LS.s(k,h.slice(0,20))}catch(x){}
S.done={ref,p:S.p,pn,ch,mail,rows,name:(v.nm||'').split(' ')[0]};draw();document.getElementById('v-explore').scrollIntoView({behavior:'smooth'});toast('Quote request submitted')}
function render(){const el=document.getElementById('v-explore');prefill();
el.innerHTML=BK+'<div class="xcard"><div class="xhead"><h2>Get Quotes</h2><p>Insurance, credit cards and loans. Share a few details and get quotes</p></div><div class="xbody" id="gqb"></div></div>';draw();scrollTo(0,0)}
const TILE='<a class="xtile" href="#explore/gq"><h3>Get Quotes</h3><p>Term, Health, Car/Bike Insurance, Credit Card and Loans</p><span class="go">Open →</span></a>';
const prev=window.renderExplore;
window.renderExplore=function(sub){if(sub==='gq'){S.done=null;render();return}
prev(sub);const g=document.querySelector('#v-explore .xgrid');if(g&&!g.querySelector('[href="#explore/gq"]'))g.insertAdjacentHTML('beforeend',TILE);
const h=document.querySelector('#v-explore .xhero p');if(h)h.textContent=h.textContent.replace('Eight smart tools','Nine smart tools')};
const ex=document.getElementById('v-explore');
ex.addEventListener('click',t=>{if(!document.getElementById('gqb'))return;const x=t.target;let b;
if(b=x.closest('[data-gp]')){S.p=b.dataset.gp;draw()}
else if(b=x.closest('[data-gv]')){const k=b.dataset.gk,val=b.dataset.gv,f=P[S.p].f.concat(CT).find(q=>q.k===k);if(!f)return;
if(f.t==='multi'){const a=S.v[k]||[];S.v[k]=a.includes(val)?a.filter(y=>y!==val):a.concat(val)}else S.v[k]=S.v[k]===val?'':val;draw()}
else if(x.closest('[data-gsub]'))submit();
else if(x.closest('[data-gnew]')){S.done=null;S.v=Object.assign({},{nm:S.v.nm,mb:S.v.mb,em:S.v.em,ct:S.v.ct,pn:S.v.pn,ch:S.v.ch,bt:S.v.bt,ok:S.v.ok,ak:S.v.ak});render()}});
const upd=t=>{const i=t.target;if(!document.getElementById('gqb'))return;if(i.id==='gqk'){S.v.ok=i.checked;return}if(i.id==='gqa'){S.v.ak=i.checked;return}if(!i.dataset||!i.dataset.gk||i.dataset.gv)return;
let val=i.value;if(i.dataset.gk==='pan')val=val.toUpperCase();if(i.dataset.gk==='mb'||i.dataset.gk==='pn')val=val.replace(/\D/g,'');if(val!==i.value&&i.type==='text')i.value=val;S.v[i.dataset.gk]=val;
const w=i.closest('[data-w]');if(w)w.classList.remove('gqerr');const h=document.getElementById('gqh');if(h)h.innerHTML=hint()};
ex.addEventListener('input',upd);ex.addEventListener('change',upd);
if(/^#explore/.test(location.hash))route();
})();
</script>
<style id="dis-css">.gqdis{margin:22px 0 0;padding:14px 16px;border-radius:14px;border:1px solid var(--ln);background:var(--so);color:var(--mu);font-size:12.5px;line-height:1.55}.gqdis b{color:var(--ink)}.gqdis .link{font-size:12.5px}</style>
<script id="dis-js">
(function(){
const G='Education only. Not investment, tax, insurance, credit or legal advice. Results are estimates, not guarantees, and real outcomes can differ. Talk to a qualified professional before you decide.';
const MK='Investments in securities markets, including mutual funds, are subject to market risks. Read all scheme-related documents carefully. Past performance does not guarantee future results.';
const D={tax:'Tax figures are simple estimates for learning and may not reflect your full income, deductions or the latest law. Consult a chartered accountant before you file or plan tax.',returns:MK,portfolio:MK+' Nifty 500 analysis is for learning and is not a buy, sell or hold call.',sip:MK+' SIP projections assume a steady return, which is not guaranteed.',sample:MK+' Sample portfolios are examples and are not personal advice.',invest:MK+' Partner links are third-party sites. We may earn a referral reward at no extra cost to you. "Up to" interest rates are maximums and are not guaranteed.',emi:'EMI figures are estimates. Your lender sets the actual rate, fees and approval. Loans are subject to the lender\'s terms and credit checks. Borrow only what you can repay.',budget:'Budget analysis is based only on the numbers you enter and is for learning. Your data stays in this browser.',gq:'We are not an insurer, bank or lender. Quotes are indicative and the provider decides final terms. We may earn a referral fee from partners at no extra cost to you.'};
const ex=document.getElementById('v-explore');if(!ex)return;
function add(){const k=(location.hash.match(/^#explore\/(\w+)/)||[])[1]||'',t=D[k]||'Explore tools give educational estimates only.';
if(!ex.children.length||ex.lastElementChild.classList.contains('gqdis'))return;
ob.disconnect();ex.insertAdjacentHTML('beforeend','<div class="gqdis"><b>'+G+'</b> '+t+' <button class="link" type="button" data-legal="risk">Risk Disclosure</button> · <button class="link" type="button" data-legal="quotes">Quotes and Referral Disclosure</button> · <button class="link" type="button" data-legal="terms">Terms</button></div>');ob.observe(ex,{childList:true})}
const ob=new MutationObserver(add);ob.observe(ex,{childList:true});add();
})();
</script>
<script id="auth-api">
(function(){
const mt=()=>document.querySelector('meta[name="csrf-token"]');

/* Shared fetch helper. Later phases reuse it as window.rpkApi(method,url,body) */
async function api(method,url,body,retry){
  let r;
  try{
    r=await fetch(url,{method,credentials:'same-origin',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':mt().content,'X-Requested-With':'XMLHttpRequest'},body:body===undefined?undefined:JSON.stringify(body)});
  }catch(e){return{ok:false,status:0,data:{message:'Network problem. Please check your connection and try again.'}}}
  if(r.status===419&&!retry){await syncMe();return api(method,url,body,true)}
  let d=null;try{d=await r.json()}catch(e){}
  return{ok:r.ok,status:r.status,data:d};
}
window.rpkApi=api;

async function syncMe(){
  try{
    const r=await fetch('/api/auth/me',{credentials:'same-origin',headers:{'Accept':'application/json'}});
    const d=await r.json();
    if(d.csrf)mt().content=d.csrf;
    return d.user||null;
  }catch(e){return undefined}
}

/* Password fields added to the existing modal forms */
const pw=(id,l,ac)=>`<div class="fd"><label for="${id}">${l}</label><div class="in"><input id="${id}" type="password" autocomplete="${ac}" maxlength="64"></div><small id="${id}-e" style="color:var(--bd)"></small></div>`;
$('#su-e').closest('.fd').insertAdjacentHTML('afterend',pw('su-pw','Password * (at least 8 characters)','new-password')+pw('su-pc','Confirm password *','new-password'));
$('#li-i').closest('.fd').insertAdjacentHTML('afterend',pw('li-pw','Password *','current-password'));

const SU_IDS=['su-n','su-s','su-m','su-e','su-c','su-p','su-pw','su-pc','c-t','c-r'];
const MAP={name:'su-n',surname:'su-s',mobile:'su-m',email:'su-e',city:'su-c',pan:'su-p',password:'su-pw',terms:'c-t',risk:'c-r'};
const setErr=m=>Object.keys(m).forEach(i=>{const e=$('#'+i+'-e');if(e)e.textContent=m[i]||''});
function busy(f,on,txt){const b=f.querySelector('button[type=submit]');if(!b)return;if(on){b.dataset.t=b.textContent;b.textContent=txt;b.disabled=true}else{b.textContent=b.dataset.t||b.textContent;b.disabled=false}}

/* SIGN UP */
$('#fsu').onsubmit=async e=>{
  e.preventDefault();
  const f=e.target,g=i=>$('#'+i).value.trim(),er={};
  const p={name:g('su-n'),surname:g('su-s'),mobile:g('su-m'),email:g('su-e').toLowerCase(),city:g('su-c'),pan:g('su-p').toUpperCase(),
    password:$('#su-pw').value,password_confirmation:$('#su-pc').value,
    terms:$('#c-t').checked,risk:$('#c-r').checked,share:$('#c-s').checked,ref:LS.g('rpk_ref')||null};
  if(!p.name)er['su-n']='Enter your name';
  if(!p.surname)er['su-s']='Enter your surname';
  if(!/^[6-9]\d{9}$/.test(p.mobile))er['su-m']='Enter a valid 10-digit mobile number';
  if(!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(p.email))er['su-e']='Enter a valid email';
  if(!p.city)er['su-c']='Enter your city';
  if(p.pan&&!/^[A-Z]{5}\d{4}[A-Z]$/.test(p.pan))er['su-p']='PAN looks wrong (format ABCDE1234F) or leave it blank';
  if(p.password.length<8)er['su-pw']='Use at least 8 characters';
  else if(p.password!==p.password_confirmation)er['su-pc']='Passwords do not match';
  if(!p.terms)er['c-t']='Please accept the Terms and Privacy Policy';
  if(!p.risk)er['c-r']='Please confirm you have read the Risk Disclosure';
  const clear={};SU_IDS.forEach(i=>clear[i]=er[i]||'');setErr(clear);
  if(Object.keys(er).length){const first=SU_IDS.find(i=>er[i]);if(first)$('#'+first).focus();return}

  busy(f,true,'Creating account...');
  const r=await api('POST','/api/auth/register',p);
  busy(f,false);
  if(!r.ok){
    if(r.status===422&&r.data&&r.data.errors){
      const m={};
      for(const k in r.data.errors){const id=MAP[k];if(id&&!m[id])m[id]=r.data.errors[k][0]}
      if(Object.keys(m).length){setErr(m);const first=SU_IDS.find(i=>m[i]);if(first)$('#'+first).focus();return}
    }
    toast((r.data&&r.data.message)||'Could not create your account. Please try again.');
    return;
  }
  $('#su-pw').value='';$('#su-pc').value='';
  if(r.data.csrf)mt().content=r.data.csrf;
  done(r.data.user);
};

/* LOGIN */
$('#fli').onsubmit=async e=>{
  e.preventDefault();
  const f=e.target,id=$('#li-i').value.trim(),pwd=$('#li-pw').value;
  setErr({'li-i':'','li-pw':''});
  if(!id){setErr({'li-i':'Enter your mobile number or email'});return}
  if(!pwd){setErr({'li-pw':'Enter your password'});return}
  busy(f,true,'Logging in...');
  const r=await api('POST','/api/auth/login',{identifier:id,password:pwd});
  busy(f,false);
  if(!r.ok){
    if(r.status===422&&r.data&&r.data.errors&&r.data.errors.identifier){setErr({'li-i':r.data.errors.identifier[0]})}
    else if(r.status===429){toast('Too many attempts. Please wait a minute and try again.')}
    else toast((r.data&&r.data.message)||'Could not log in. Please try again.');
    return;
  }
  $('#li-pw').value='';
  if(r.data.csrf)mt().content=r.data.csrf;
  done(r.data.user);
};

/* LOGOUT: tell the server too (your existing handler still clears the screen instantly) */
document.addEventListener('click',e=>{
  if(e.target.closest('[data-flogout]'))api('POST','/api/auth/logout').then(r=>{if(r.data&&r.data.csrf)mt().content=r.data.csrf});
},true);

/* RESTORE SESSION on page load, no reload needed */
syncMe().then(u=>{
  if(u===undefined)return;
  USER=u||null;
  updUsr();
  route();
  if(USER&&window.rpkLoadPlan)window.rpkLoadPlan(false);
});
})();
</script>
<script id="plan-api">
(function(){
const api=window.rpkApi;
const num=id=>{const x=parseFloat(($('#'+id)||{}).value);return isNaN(x)?0:x};
const val=x=>x>0?x:'';

/* ---------- read the forms ---------- */
function nwData(){
  const assets=AS.map(([k,l],i)=>({slot:k,type:i<3?'liquid':'non_liquid',label:l,amount:num(k)}));
  [['L','liquid'],['I','non_liquid']].forEach(([g,t])=>$$('#c-'+g+' .cr').forEach(r=>{
    const label=r.querySelector('.cn').value.trim(),amount=parseFloat(r.querySelector('.cv').value)||0;
    if(label||amount>0)assets.push({slot:null,type:t,label:label||'Other',amount});
  }));
  return{age:num('age')||null,country:CC,assets,liabilities:LI.map(([k,l])=>({slot:k,label:l,amount:num(k)}))};
}
function ieData(){
  const expenses=EX.map(([l],i)=>({slot:'x'+i,label:l,amount:num('x'+i),essential:$('#e'+i).checked}));
  $$('#c-X .cr').forEach(r=>{
    const label=r.querySelector('.cn').value.trim(),amount=parseFloat(r.querySelector('.cv').value)||0,ce=r.querySelector('.ce');
    if(label||amount>0)expenses.push({slot:null,label:label||'Other',amount,essential:!!(ce&&ce.checked)});
  });
  return{income:num('inc'),expenses,protection:{
    life_insurance:$('#tmy').value,life_cover:num('tmc'),term_premium:num('tmp'),term_till_age:num('tmt'),
    health_type:$('#hty').value,health_cover:num('hcc'),health_premium:num('hcp'),health_topup:$('#hto').value,
    emergency_fund:num('efv'),emergency_where:$('#efw').value}};
}
function rpData(){
  const a=id=>$('#'+id).dataset.auto==='1';
  return{retirement_age:num('ret'),life_expectancy:num('life'),monthly_spending:num('exp'),other_income:num('oth'),
    inflation_rate:num('infl'),return_pre:num('rpre'),return_post:num('rpost'),current_corpus:num('cur'),
    monthly_sip:num('sip'),step_up_percent:num('step'),spending_auto:a('exp'),corpus_auto:a('cur'),sip_auto:a('sip')};
}
const EP={nw:['/api/plan/net-worth',nwData],exp:['/api/plan/income-expense',ieData],plan:['/api/plan/retirement-plan',rpData]};

/* ---------- save one step ---------- */
function leadGuest(ev,data){
  if(!CFG.hook)return;
  try{fetch(CFG.hook,{method:'POST',mode:'no-cors',headers:{'Content-Type':'text/plain'},body:JSON.stringify({ev,ts:new Date().toISOString(),guest:true,details:data})})}catch(e){}
}
async function save(k){
  if(!USER){leadGuest('guest_'+k,EP[k][1]());return false}
  const r=await api('POST',EP[k][0],EP[k][1]());
  if(r.ok)return true;
  if(r.status===401){USER=null;updUsr();toast('Your session ended. Please login again.');return false}
  toast('Could not save to your account. Your numbers are still here, press Submit again.');
  return false;
}

/* ---------- fill the forms from saved data ---------- */
function fillNW(d){
  if(d.country&&CT[d.country]&&d.country!==CC){CC=d.country;try{localStorage.setItem('ctry',CC)}catch(e){}$('#ctry').value=CC;applyCur()}
  const keys=AS.map(x=>x[0]);
  $('#age').value=d.age>0?d.age:'';
  AS.forEach(([k])=>$('#'+k).value='');
  LI.forEach(([k])=>$('#'+k).value='');
  $('#c-L').innerHTML='';$('#c-I').innerHTML='';
  (d.assets||[]).forEach(a=>{
    if(a.slot&&keys.includes(a.slot)){$('#'+a.slot).value=val(a.amount);return}
    const g=a.type==='liquid'?'L':'I',row=crow(g);
    $('#c-'+g).appendChild(row);
    row.querySelector('.cn').value=a.label;
    row.querySelector('.cv').value=val(a.amount);
  });
  const lk=LI.map(x=>x[0]);
  (d.liabilities||[]).forEach(l=>{if(l.slot&&lk.includes(l.slot))$('#'+l.slot).value=val(l.amount)});
}
function fillIE(d){
  $('#inc').value=val(d.income);
  EX.forEach((_,i)=>$('#x'+i).value='');
  $('#c-X').innerHTML='';
  (d.expenses||[]).forEach(x=>{
    const m=/^x([0-9])$/.exec(x.slot||'');
    if(m){$('#x'+m[1]).value=val(x.amount);$('#e'+m[1]).checked=!!x.essential;return}
    const row=crow('X');
    $('#c-X').appendChild(row);
    row.querySelector('.cn').value=x.label;
    row.querySelector('.cv').value=val(x.amount);
    row.querySelector('.ce').checked=!!x.essential;
  });
  const p=d.protection;
  if(p){
    $('#tmy').value=p.life_insurance;$('#tmc').value=val(p.life_cover);$('#tmp').value=val(p.term_premium);$('#tmt').value=val(p.term_till_age);
    $('#hty').value=p.health_type;$('#hcc').value=val(p.health_cover);$('#hcp').value=val(p.health_premium);$('#hto').value=p.health_topup;
    $('#efv').value=val(p.emergency_fund);$('#efw').value=p.emergency_where;
  }
}
function fillRP(d){
  const raw={ret:'retirement_age',life:'life_expectancy',infl:'inflation_rate',rpre:'return_pre',rpost:'return_post',step:'step_up_percent'};
  for(const id in raw){const x=d[raw[id]];$('#'+id).value=(x===null||x===undefined)?'':x}
  const opt={exp:'monthly_spending',oth:'other_income',cur:'current_corpus',sip:'monthly_sip'};
  for(const id in opt)$('#'+id).value=val(d[opt[id]]);
  $('#exp').dataset.auto=d.spending_auto?'1':'0';
  $('#cur').dataset.auto=d.corpus_auto?'1':'0';
  $('#sip').dataset.auto=d.sip_auto?'1':'0';
}

/* ---------- load after login / page refresh ---------- */
let loading=false;
async function loadPlan(afterLogin){
  if(loading||!USER)return;
  loading=true;
  try{
    if(afterLogin){
      /* Push whatever was typed in the 3 forms before login/signup. The server only
         fills a step this account has nothing saved for yet — it never overwrites a
         plan this account already saved earlier, so this is always safe. */
      const local={};
      if(v('age')>0||assetList().some(x=>x.v>0))local.netWorth=nwData();
      if(v('inc')>0||expList().some(x=>x.v>0))local.incomeExpense=ieData();
      if(ok(P()))local.retirementPlan=rpData();
      if(Object.keys(local).length){
        const sr=await api('POST','/api/plan/sync-local',local);
        if(!sr.ok)toast('Could not save your earlier entries. Please recheck Steps 1 to 3.');
      }
    }
    const r=await api('GET','/api/plan');
    if(!r.ok||!r.data)return;
    const d=r.data;
    if(d.netWorth||d.incomeExpense||d.retirement){
      if(d.netWorth)fillNW(d.netWorth);
      if(d.incomeExpense)fillIE(d.incomeExpense);
      if(d.retirement)fillRP(d.retirement);
      calc();
      if(afterLogin)toast('Welcome back! Your saved plan is loaded.');
    }
  }finally{loading=false}
}
window.rpkLoadPlan=async function(a){await loadPlan(a);if(window.rpkAfterPlan)await window.rpkAfterPlan(a)};

/* run after every successful login / signup */
const _done=done;
done=function(u){_done(u);window.rpkLoadPlan(true)};

/* ---------- Submit buttons: save for logged-in users ---------- */
document.addEventListener('click',e=>{
  const b=e.target.closest('[data-submit]');
  if(!b)return;
  const k=b.dataset.submit;
  if(!EP[k])return;
  const chk=SUB[k]&&SUB[k][1],r=chk?chk():true;
  if(r!==true&&r!==1)return;
  save(k);
});

/* ---------- logout: wipe the forms so nothing leaks to the next person ---------- */
function resetForm(){
  $('#age').value='';
  AS.forEach(([k])=>$('#'+k).value='');
  LI.forEach(([k])=>$('#'+k).value='');
  $('#c-L').innerHTML='';$('#c-I').innerHTML='';$('#c-X').innerHTML='';
  $('#inc').value='';
  EX.forEach(([,e],i)=>{$('#x'+i).value='';$('#e'+i).checked=!!e});
  ['tmc','tmp','tmt','hcc','hcp','efv'].forEach(id=>$('#'+id).value='');
  [['tmy','No'],['hty','None'],['hto','No'],['efw','Savings account']].forEach(([id,x])=>$('#'+id).value=x);
  const d=CT[CC].d;
  $('#ret').value=60;$('#life').value=90;$('#oth').value='';$('#infl').value=d[0];$('#rpre').value=d[1];$('#rpost').value=d[2];$('#step').value=5;
  ['exp','cur','sip'].forEach(k=>{$('#'+k).value='';$('#'+k).dataset.auto='1'});
  if(typeof GL!=='undefined'){GL.length=0;syncG();renderGL()}
  calc();
}
document.addEventListener('click',e=>{if(e.target.closest('[data-flogout]'))setTimeout(resetForm,0)});
})();
</script>
<script id="phase3-api">
(function(){
const api=window.rpkApi;
const keyOf=i=>{const p=i.closest('.ckpanel');return p.id.replace('ck-','')+'-'+[...p.querySelectorAll('.ckitem')].indexOf(i)};

/* ---------- Step 4: save ---------- */
async function saveSwp(){
  if(!USER)return;
  const goals=GL.filter(g=>(+g.amt)>0).map(g=>({name:String(g.name||'Other goal').slice(0,60),age:+g.age||0,amt:+g.amt||0}));
  const r=await api('POST','/api/plan/withdrawal-plan',{mode:$('#mode').value||'mine',show:$('#show').value||'all',goals});
  if(!r.ok)toast('Could not save your goals. Press Submit again.');
}
document.addEventListener('click',e=>{
  const b=e.target.closest('[data-submit="swp"]');
  if(!b||!USER)return;
  const r=SUB.swp[1]();
  if(r!==true&&r!==1)return;
  saveSwp();
});

/* ---------- Checklist: save each tick ---------- */
document.addEventListener('change',e=>{
  const i=e.target;
  if(!USER||!i.classList||!i.classList.contains('ckitem'))return;
  api('POST','/api/checklist/toggle',{item_key:keyOf(i),is_checked:i.checked}).then(r=>{if(!r.ok)toast('Could not save your checklist tick.')});
});

/* ---------- load goals + ticks (runs after the plan loads) ---------- */
window.rpkAfterPlan=async function(afterLogin){
  if(!USER)return;
  const [w,c]=await Promise.all([api('GET','/api/plan/withdrawal'),api('GET','/api/checklist')]);

  if(w.ok&&w.data){
    const d=w.data;
    if(d.saved){
      GL.length=0;
      (d.goals||[]).forEach(g=>GL.push({name:g.name,age:+g.age,amt:+g.amt}));
      $('#mode').dataset.m=d.mode;
      $('#show').value=d.show;
      $('#tw').classList.toggle('only',d.show==='post');
      syncG();renderGL();swp(true);
    }else if(afterLogin&&GL.some(g=>(+g.amt)>0)){
      await saveSwp();
    }
  }

  if(c.ok&&c.data){
    const set=new Set(c.data.checked||[]);
    if(set.size){
      $$('.ckitem').forEach(i=>i.checked=set.has(keyOf(i)));
      ckp();
    }else if(afterLogin){
      await Promise.all($$('.ckitem').filter(i=>i.checked).map(i=>api('POST','/api/checklist/toggle',{item_key:keyOf(i),is_checked:true})));
    }
  }
};

/* ---------- logout: clear Step 4 + ticks ---------- */
document.addEventListener('click',e=>{
  if(!e.target.closest('[data-flogout]'))return;
  setTimeout(()=>{
    $$('.ckitem').forEach(i=>i.checked=false);ckp();
    $('#show').value='all';$('#tw').classList.remove('only');$('#mode').dataset.m='mine';
  },0);
});
})();
</script>
<script id="family-api">
(function(){
const api=window.rpkApi;
const NUMF=['inc','exp','liq','ill','debt','sip','lc','tp','tt','hc','hp','ef'];

function fmPayload(){
  const d={name:$('#fm-n').value.trim(),rel:$('#fm-r').value,age:parseFloat($('#fm-a').value)||0};
  NUMF.forEach(k=>d[k]=Math.max(0,parseFloat($('#fm-'+k).value)||0));
  ['tm','hs','ht','ew'].forEach(k=>d[k]=$('#fm-'+k).value);
  if(d.tm==='No'){d.lc=d.tp=d.tt=0}
  if(d.hs==='None'){d.hc=d.hp=0;d.ht='No'}
  return d;
}

async function loadFamily(){
  if(!USER){FAMCACHE=[];return}
  const r=await api('GET','/api/family');
  FAMCACHE=(r.ok&&r.data&&r.data.members)?r.data.members.map(norm):[];
}

/* chain into the same load sequence plan-api / phase3-api use */
const _after=window.rpkAfterPlan;
window.rpkAfterPlan=async function(afterLogin){
  if(_after)await _after(afterLogin);
  await loadFamily();
  if(!$('#v-family').hidden)renderFam();
};

/* ---- add / edit ---- */
$('#ffm').onsubmit=async e=>{
  e.preventDefault();
  const n=$('#fm-n').value.trim(),a=parseFloat($('#fm-a').value);
  $('#fm-n-e').textContent=n?'':'Enter a name';
  $('#fm-a-e').textContent=(a>=0&&a<=110)?'':'Enter a valid age';
  $('#fm-c-e').textContent=$('#fm-c').checked?'':'Please confirm to continue';
  if(!n||!(a>=0&&a<=110)||!$('#fm-c').checked)return;

  const body=fmPayload(),btn=$('#ffm button[type=submit]');
  btn.disabled=true;
  const r=FEDIT?await api('PUT','/api/family/'+FEDIT,body):await api('POST','/api/family',body);
  btn.disabled=false;
  if(!r.ok){toast('Could not save. Please try again.');return}

  const m=norm(r.data.member),i=FAMCACHE.findIndex(x=>x.id===m.id);
  if(i>=0)FAMCACHE[i]=m;else FAMCACHE.push(m);
  $('#fm').hidden=true;
  renderFam();
  toast('Family member saved');
};

/* ---- add me from my plan (upsert "Self") ---- */
addSelf=async function(){
  const p=P(),AL=assetList(),o=FAMCACHE.find(x=>x.rel==='Self');
  const body={name:USER.name,rel:'Self',age:p.age||0,
    inc:v('inc'),exp:expList().reduce((a,x)=>a+x.v,0),
    liq:AL.filter(x=>x.t==='L').reduce((a,x)=>a+x.v,0),
    ill:AL.filter(x=>x.t==='I').reduce((a,x)=>a+x.v,0),
    debt:LI.reduce((a,[k])=>a+v(k),0),sip:p.sip||0,
    tm:o?o.tm:'No',lc:o?o.lc:0,tp:o?o.tp:0,tt:o?o.tt:0,
    hs:o?o.hs:'None',hc:o?o.hc:0,hp:o?o.hp:0,ht:o?o.ht:'No',
    ef:o?o.ef:0,ew:o?o.ew:'Savings account'};
  const pr=prot();
  if(pr.tm==='Yes'||pr.hs!=='None'||pr.ef>0){
    Object.assign(body,pr);
    if(body.tm==='No'){body.lc=body.tp=body.tt=0}
    if(body.hs==='None'){body.hc=body.hp=0;body.ht='No'}
  }
  const r=o?await api('PUT','/api/family/'+o.id,body):await api('POST','/api/family',body);
  if(!r.ok){toast('Could not save. Please try again.');return}
  const m=norm(r.data.member),i=FAMCACHE.findIndex(x=>x.id===m.id);
  if(i>=0)FAMCACHE[i]=m;else FAMCACHE.unshift(m);
  renderFam();
  toast('Your numbers were added. Tap Edit to add your insurance and emergency money.');
};

/* ---- delete: intercept before the original (localStorage) handler runs ---- */
document.addEventListener('click',async e=>{
  const b=e.target.closest('[data-fdel]');
  if(!b)return;
  e.stopImmediatePropagation();
  const id=+b.dataset.fdel;
  if(!confirm('Remove this family member?'))return;
  const r=await api('DELETE','/api/family/'+id);
  if(!r.ok){toast('Could not remove. Please try again.');return}
  FAMCACHE=FAMCACHE.filter(x=>x.id!==id);
  renderFam();
},true);

/* ---- logout: clear the cache ---- */
document.addEventListener('click',e=>{if(e.target.closest('[data-flogout]'))FAMCACHE=[]});
})();
</script>
<script id="points-api">
(function(){
const api=window.rpkApi;
function defaults(){return{bal:0,unl:{},report:0,friends:0,code:'',streakDay:0,streakToday:false}}
window.RPK_PTS=window.RPK_PTS||defaults();

async function loadPoints(){
  if(!USER){window.RPK_PTS=defaults();return}
  const [p,w]=await Promise.all([api('GET','/api/points/balance'),api('GET','/api/wallet/status')]);
  if(p.ok&&p.data){
    window.RPK_PTS.report=p.data.report||0;
    window.RPK_PTS.friends=p.data.friends||0;
    window.RPK_PTS.code=p.data.code||'';
    window.RPK_PTS.streakDay=p.data.streak?p.data.streak.day:0;
    window.RPK_PTS.streakToday=p.data.streak?!!p.data.streak.today:false;
  }
  if(w.ok&&w.data){
    window.RPK_PTS.bal=w.data.balance||0;
    window.RPK_PTS.unl=w.data.unlocks||{};
  }
     if(typeof updUsr==='function')updUsr();
     if(window.rpkWalletRefresh)window.rpkWalletRefresh();
     if(!window.RPK_PTS.streakToday)dailyCheck();
   }

const _after=window.rpkAfterPlan;
window.rpkAfterPlan=async function(afterLogin){
  if(_after)await _after(afterLogin);
  await loadPoints();
};

/* ---- overrides: these were plain functions in the main script, so reassigning here replaces them everywhere ---- */
ptsGet=function(u){
  if(!u||!USER||u.mobile!==USER.mobile)return{e:0,u:0,n:0};
  const p=window.RPK_PTS||defaults();
  return{e:p.report||0,u:0,n:p.friends||0};
};
ptsBal=function(){return USER?(window.RPK_PTS?window.RPK_PTS.report:0):0};
creditRef=function(){/* crediting now happens server-side at signup */};

let streaking=false;
dailyCheck=async function(){
  if(!USER||streaking)return;
  if(window.RPK_PTS&&window.RPK_PTS.streakToday)return;
  streaking=true;
  const r=await api('POST','/api/points/streak-check');
  streaking=false;
  if(!r.ok||!r.data||!r.data.credited)return;
  window.RPK_PTS.streakDay=r.data.day;
  window.RPK_PTS.streakToday=true;
  window.RPK_PTS.report=(window.RPK_PTS.report||0)+r.data.points;
  updUsr();
  const N=CFG.streakDays,P=r.data.points;
  toast(r.data.day>=N?'⭐ +'+P+' points! '+N+'-day streak complete ('+P*N+' points in total). Come back tomorrow to start a new streak.':'⭐ +'+P+' points! Day '+r.data.day+' of '+N+'. Come back tomorrow to keep your streak.');
};
streakBar=function(){
  if(!USER)return'';
  const p=window.RPK_PTS||defaults(),N=CFG.streakDays,P=CFG.dayPts;
  let d='';for(let i=1;i<=N;i++)d+='<i class="sd'+(i<=p.streakDay?' on':'')+'">'+i+'</i>';
  return `<div class="stk"><div class="sdots">${d}</div><small class="psn">${p.streakToday?'✓ Today\'s '+P+' Report Points earned. See you tomorrow.':'Do any activity today to earn '+P+' Report Points.'} ${N} days in a row = ${P*N} Report Points. Miss a day and it restarts.</small></div>`;
};

document.addEventListener('click',e=>{if(e.target.closest('[data-flogout]')){window.RPK_PTS=defaults();if(window.rpkWalletRefresh)window.rpkWalletRefresh()}});
})();
</script>
<script id="payu-api">
(function(){
const api=(...a)=>window.rpkApi(...a);
const PDK='rpk_pd';
window.RPK_PAID={paid:false};

/* ---------- state from the server: paid report, booked sessions, prices, gateway on/off ---------- */
async function loadState(){
  if(!USER){window.RPK_PAID={paid:false};return}
  const r=await api('GET','/api/report/state');
  if(r.ok&&r.data){
    const d=r.data;
    window.RPK_PAID={paid:!!d.paid,at:d.paid_at||null};
    CFG.rzp=d.live?'payu':'';
    if(d.price>0)CFG.price=d.price;
    if(d.session_price>0)CFG.gprice=d.session_price;
    if(d.ref_pts>0)CFG.refPts=d.ref_pts;
    if(d.streak_days>0)CFG.streakDays=d.streak_days;
    if(d.streak_points>0)CFG.dayPts=d.streak_points;
    LS.s(GK(),d.sessions||[]);
    if(window.RPK_PTS&&typeof d.report_points==='number')window.RPK_PTS.report=d.report_points;
  }
  updUsr();
  if(typeof renderRep==='function')renderRep();
}

async function refreshPoints(){
  if(!USER)return;
  const [p,w]=await Promise.all([api('GET','/api/points/balance'),api('GET','/api/wallet/status')]);
  const P=window.RPK_PTS;
  if(p.ok&&p.data){P.report=p.data.report||0;P.friends=p.data.friends||0}
  if(w.ok&&w.data){P.bal=w.data.balance||0;P.unl=w.data.unlocks||{}}
  updUsr();
  if(window.rpkWalletRefresh)window.rpkWalletRefresh();
}

/* ---------- Budget Planner: keep the browser copy and the server copy in step ---------- */
const _lsSet=LS.s;let bt=null;
LS.s=function(k,x){
  _lsSet(k,x);
  if(USER&&k==='rpk_bud_'+USER.mobile){clearTimeout(bt);bt=setTimeout(()=>{api('PUT','/api/blobs/budget',{data:x})},800)}
};
async function loadBudget(){
  const r=await api('GET','/api/blobs');
  if(!r.ok||!r.data)return;
  const key='rpk_bud_'+USER.mobile;
  if(r.data.budget&&typeof r.data.budget==='object'&&Object.keys(r.data.budget).length){_lsSet(key,r.data.budget)}
  else{const l=LS.g(key);if(l&&Object.keys(l).length)api('PUT','/api/blobs/budget',{data:l})}
}

/* ---------- after payment: refresh everything and continue where the user was ---------- */
async function settledUI(purpose,target){
  closePay();closeGs();
  await Promise.all([loadState(),refreshPoints()]);
  if(purpose==='report'){toast('Premium unlocked');if(target){try{dl(target)}catch(e){console.error(e)}}}
  else if(purpose==='session'){toast('Session booked. We will confirm on your mobile number.')}
  else{toast('Points added to your wallet')}
  if(typeof renderRep==='function')renderRep();
}

/* ---------- send the customer to PayU (or finish at once when nothing is left to pay) ---------- */
window.rpkPayGo=async function(d,o){
  if(d.done){await settledUI(d.purpose,o&&o.target);return}
  const f=document.createElement('form');
  f.method='POST';f.action=d.action;f.style.display='none';
  Object.keys(d.fields).forEach(k=>{const i=document.createElement('input');i.type='hidden';i.name=k;i.value=d.fields[k];f.appendChild(i)});
  document.body.appendChild(f);
  toast('Taking you to PayU to complete the payment...');
  f.submit();
};

/* ---------- coupon: checked on the server ---------- */
applyCoupon=async function(){
  const c=($('#pay-cp').value||'').trim().toUpperCase(),m=$('#pay-cpm');
  if(!c){m.textContent='Enter a coupon code.';return}
  m.style.color='var(--mu)';m.textContent='Checking...';
  const r=await api('POST','/api/coupon/check',{code:c});
  if(!r.ok||!r.data||!(r.data.off>0)){
    CPN=0;CPC='';m.style.color='var(--bd)';
    m.textContent=(r.data&&r.data.message)||'Could not check the coupon. Try again.';
    payRefresh();return;
  }
  CPN=Math.min(r.data.off,CFG.price);CPC=c;
  m.style.color='var(--br)';m.textContent='Coupon applied: ₹'+CPN+' off';payRefresh();
};

/* ---------- Premium report payment ---------- */
doPay=async function(){
  if(!USER)return;
  const t=PD2,btn=$('#pay-go'),use=!!($('#pay-pts')&&$('#pay-pts').checked);
  if(btn)btn.disabled=true;
  const r=await api('POST','/api/pay/initiate',{purpose:'report',coupon:CPC||null,use_points:use});
  if(btn)btn.disabled=false;
  if(!r.ok){toast((r.data&&r.data.message)||'Could not start the payment. Please try again.');return}
  if(r.data.already){await settledUI('report',t);return}
  try{sessionStorage.setItem(PDK,t||'')}catch(e){}
  window.rpkPayGo(r.data,{target:t});
};

/* ---------- Guidance session booking (replaces the old doGs) ---------- */
doGs=async function(){
  const g=id=>$('#'+id),dt=g('gs-d').value,sl=g('gs-s').value,md=g('gs-m').value,mb=g('gs-p').value.trim(),nt=g('gs-n').value.trim(),ck=g('gs-c').checked;
  if(!dt||dt<g('gs-d').min||dt>g('gs-d').max){toast('Pick a date from tomorrow onwards.');g('gs-d').focus();return}
  if(!/^[6-9]\d{9}$/.test(mb.replace(/\D/g,'').slice(-10))){toast('Enter a valid 10-digit mobile number.');g('gs-p').focus();return}
  if(!ck){toast('Please tick the confirmation box.');return}
  const btn=g('gs-go');btn.disabled=true;
  const r=await api('POST','/api/pay/initiate',{purpose:'session',session:{date:dt,slot:sl,mode:md,mobile:mb,note:nt}});
  btn.disabled=false;
  if(!r.ok){toast((r.data&&r.data.message)||'Could not start the payment. Please try again.');return}
  window.rpkPayGo(r.data,{});
};

/* ---------- Wallet recharge: take over the buy buttons before the old handler sees them ---------- */
document.addEventListener('click',async e=>{
  const b=e.target.closest&&e.target.closest('[data-wbuy]');
  if(!b||!USER)return;
  e.stopImmediatePropagation();e.preventDefault();
  const r=await api('POST','/api/pay/initiate',{purpose:'wallet',pack:+b.dataset.wbuy});
  if(!r.ok){toast((r.data&&r.data.message)||'Could not start the payment. Please try again.');return}
  window.rpkPayGo(r.data,{});
},true);

/* ---------- coming back from PayU (?pay=ok&txn=...) ---------- */
let returned=false;
async function handleReturn(){
  if(returned)return;returned=true;
  const q=new URLSearchParams(location.search),txn=q.get('txn');
  if(!txn||!q.get('pay'))return;
  try{history.replaceState(null,'',location.pathname+location.hash)}catch(e){}
  let target='';try{target=sessionStorage.getItem(PDK)||'';sessionStorage.removeItem(PDK)}catch(e){}
  const r=await api('GET','/api/pay/status?txn='+encodeURIComponent(txn));
  if(!r.ok||!r.data){toast('We could not confirm your payment yet. Please check again in a minute.');return}
  if(r.data.status==='success'){await settledUI(r.data.purpose,r.data.purpose==='report'?target:'')}
  else if(r.data.status==='pending'){toast('Your payment is still being confirmed. Please check again in a minute.')}
  else{await refreshPoints();toast('The payment was not completed. If money was deducted, your bank will refund it.')}
}

const _after=window.rpkAfterPlan;
window.rpkAfterPlan=async function(afterLogin){
  if(_after)await _after(afterLogin);
  await loadState();
  await loadBudget();
  await handleReturn();
};

/* ---------- logout ---------- */
document.addEventListener('click',e=>{if(e.target.closest('[data-flogout]')){window.RPK_PAID={paid:false};CFG.rzp=''}});
})();
</script>
<style id="vb-css">
body.has-vb{padding-bottom:64px}
body.has-vb #shb{bottom:calc(76px + env(safe-area-inset-bottom,0px))}
body.has-vb .toast{bottom:calc(84px + env(safe-area-inset-bottom,0px))}
@media(max-width:600px){
body.has-vb{padding-bottom:104px}
body.has-vb #shb{bottom:calc(112px + env(safe-area-inset-bottom,0px))}
body.has-vb .toast{bottom:calc(120px + env(safe-area-inset-bottom,0px))}
}
</style>
<script id="verify-api">
(function(){
const api=window.rpkApi;
const qs=new URLSearchParams(location.search);
if(qs.has('verified')){
  const ok=qs.get('verified')==='1';
  try{history.replaceState(null,'',location.pathname+location.hash)}catch(e){}
  setTimeout(()=>{if(typeof toast==='function')toast(ok?'Email verified. Thank you!':'That verification link is invalid or expired.')},300);
}
function banner(){
  const old=document.getElementById('rpk-verify-banner');if(old)old.remove();
  if(!USER||USER.verified)return;
  const d=document.createElement('div');
  d.id='rpk-verify-banner';
  d.style.cssText='position:fixed;left:0;right:0;bottom:0;z-index:9999;background:#111827;color:#fff;padding:10px 16px;font:14px/1.4 system-ui,sans-serif;display:flex;gap:12px;align-items:center;justify-content:center;flex-wrap:wrap';
  d.innerHTML='<span>Please verify your email to receive referral points for friends you invite.</span><button type="button" id="rpk-verify-go" style="background:#fff;color:#111827;border:0;padding:6px 14px;border-radius:6px;font-weight:600;cursor:pointer">Resend email</button>';
  document.body.appendChild(d);
  document.getElementById('rpk-verify-go').onclick=async()=>{
    const r=await api('POST','/api/auth/verify/resend');
    if(typeof toast==='function')toast(r.ok?(r.data&&r.data.already?'Already verified.':'Verification email sent.'):'Could not send right now.');
  };
}
const _after=window.rpkAfterPlan;
window.rpkAfterPlan=async function(a){if(_after)await _after(a);banner()};
document.addEventListener('click',e=>{if(e.target.closest('[data-flogout]')){const b=document.getElementById('rpk-verify-banner');if(b)b.remove()}});
})();
</script>
<script id="clean-urls">
(function(){
const EX={returns:'/my-investment-returns',portfolio:'/stock-portfolio-analysis',tax:'/income-tax-calculator',sip:'/sip-calculator',emi:'/home-loan-emi-calculator',budget:'/budget-planner',sample:'/sample-portfolio',invest:'/one-window-investing',gq:'/get-quotes'};
const REV=Object.fromEntries(Object.entries(EX).map(([k,v])=>[v,k]));
const PG={checklist:'/checklist',family:'/family',report:'/report',explore:'/explore',learn:'/learn'};
const TABS=['guides','myths','words','faq'];
const norm=p=>p.replace(/\/+$/,'')||'/';

function toPath(h){
  h=String(h).replace(/^#/,'');
  if(h===''||h==='plan')return '/';
  const [a,b]=h.split('/');
  if(a==='explore'){if(!b)return '/explore';if(EX[b])return EX[b];if(b==='wallet')return '/explore/wallet';return null}
  if(a==='learn'){if(!b)return '/learn';return TABS.includes(b)?'/learn/'+b:null}
  return (!b&&PG[a])?PG[a]:null;
}
function toVH(p){
  p=norm(p);
  if(p==='/')return 'plan';
  if(REV[p])return 'explore/'+REV[p];
  if(p==='/explore/wallet')return 'explore/wallet';
  const m=p.match(/^\/learn\/(\w+)$/);
  if(m&&TABS.includes(m[1]))return 'learn/'+m[1];
  const s=p.slice(1);
  return PG[s]===p?s:null;
}
window.rpkVH=()=>toVH(location.pathname)||'plan';

let last='';
const _route=route;
removeEventListener('hashchange',_route);

route=function(){
  if(location.hash){
    const p=toPath(location.hash);
    if(p===null)return;
    history.replaceState(null,'',p);
  }
  const vh=toVH(location.pathname);
  if(vh===null)return;
  const [x,t]=vh.split('/'),n=views.includes(x)?x:'plan';
  show(n);
  if(USER){if(n==='family')renderFam();if(n==='report')renderRep()}
  if(n==='explore'&&USER&&window.renderExplore)renderExplore(t);
  if(n==='learn')tab(t||'guides');
  if(n!=='plan')scrollTo(0,0);
  last=location.pathname+location.hash;
};

const sync=()=>{if(location.pathname+location.hash!==last)route()};
addEventListener('hashchange',sync);
addEventListener('popstate',sync);

document.addEventListener('click',e=>{
  const a=e.target.closest('a[href^="#"]');
  if(!a||e.metaKey||e.ctrlKey||e.shiftKey||e.button)return;
  const p=toPath(a.getAttribute('href'));
  if(p===null)return;
  e.preventDefault();
  if(norm(location.pathname)!==p||location.hash)history.pushState(null,'',p);
  route();
});

jrGo=function(k){
  const p=toPath(k);if(p===null)return;
  if(norm(location.pathname)!==p)history.pushState(null,'',p);
  route();scrollTo(0,0);
};

document.addEventListener('click',e=>{
  if(e.target.closest('[data-open],[data-go]')&&(norm(location.pathname)!=='/'||location.hash))history.pushState(null,'','/');
},true);

const _d=done;
done=function(u){_d(u);if(norm(location.pathname)!=='/')route()};
document.addEventListener('click',e=>{
  if(e.target.closest('[data-flogout]'))setTimeout(()=>{if(norm(location.pathname)!=='/')route()},80);
});

if(norm(location.pathname)!=='/'||location.hash)route();
})();
</script>
<style id="vb-fix">
#rpk-verify-banner{z-index:25!important}
body:has(#rpk-verify-banner){padding-bottom:64px}
body:has(#rpk-verify-banner) #shb{bottom:calc(76px + env(safe-area-inset-bottom,0px))}
body:has(#rpk-verify-banner) .toast{bottom:calc(84px + env(safe-area-inset-bottom,0px))}
@media(max-width:600px){
body:has(#rpk-verify-banner){padding-bottom:104px}
body:has(#rpk-verify-banner) #shb{bottom:calc(112px + env(safe-area-inset-bottom,0px))}
body:has(#rpk-verify-banner) .toast{bottom:calc(120px + env(safe-area-inset-bottom,0px))}
}
</style>

</body>
</html>