<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Certificate of Completion') }} - {{ $course->coursename }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @page { size: A4 landscape; margin: 12mm; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #eef2f7; color: #172554; font-family: Georgia, 'Times New Roman', serif; }
        .certificate-actions { display: flex; justify-content: center; gap: .75rem; padding: 1.25rem; font-family: Arial, sans-serif; }
        .certificate-actions a, .certificate-actions button { border: 0; border-radius: .65rem; padding: .75rem 1rem; background: #1d4ed8; color: #fff; font: 600 .9rem Arial, sans-serif; text-decoration: none; cursor: pointer; }
        .certificate-actions a { background: #334155; }
        .certificate { position: relative; display: flex; min-height: min(760px, calc(100vh - 100px)); max-width: 1180px; margin: 0 auto 1.5rem; flex-direction: column; align-items: center; justify-content: center; overflow: hidden; border: 12px solid #17345f; outline: 2px solid #c7a65b; outline-offset: -22px; background: #fff; padding: 4rem 5rem; text-align: center; box-shadow: 0 20px 60px rgba(15,23,42,.16); }
        .certificate::before, .certificate::after { position: absolute; width: 180px; height: 180px; border: 1px solid rgba(199,166,91,.4); border-radius: 50%; content: ''; }
        .certificate::before { top: -100px; left: -100px; box-shadow: 0 0 0 18px rgba(199,166,91,.07), 0 0 0 36px rgba(199,166,91,.06); }
        .certificate::after { right: -100px; bottom: -100px; box-shadow: 0 0 0 18px rgba(199,166,91,.07), 0 0 0 36px rgba(199,166,91,.06); }
        .certificate-logo { width: 92px; height: 62px; object-fit: contain; margin-bottom: .5rem; }
        .certificate-kicker { margin: 0; color: #9b7c38; font: 700 .8rem Arial, sans-serif; letter-spacing: .28em; text-transform: uppercase; }
        .certificate h1 { margin: .8rem 0 1rem; color: #17345f; font-size: clamp(2rem, 4vw, 3.4rem); font-weight: 500; letter-spacing: .08em; }
        .certificate-copy { margin: 0 0 .8rem; color: #475569; font: 1.05rem Arial, sans-serif; }
        .certificate-name { margin: .25rem 0 1rem; color: #17345f; font-size: clamp(2rem, 4vw, 3rem); font-style: italic; }
        .certificate-course { max-width: 850px; margin: .4rem 0 1.5rem; color: #9b7c38; font-size: clamp(1.45rem, 3vw, 2.25rem); }
        .certificate-meta { display: flex; width: min(720px, 100%); justify-content: space-between; gap: 2rem; margin-top: 1.5rem; font: .85rem Arial, sans-serif; }
        .certificate-meta div { min-width: 200px; border-top: 1px solid #cbd5e1; padding-top: .65rem; color: #475569; }
        .certificate-meta strong { display: block; margin-bottom: .25rem; color: #17345f; }
        .certificate-number { position: absolute; right: 3.1rem; bottom: 2.2rem; color: #64748b; font: .7rem Arial, sans-serif; letter-spacing: .04em; }
        @media (max-width: 720px) {
            .certificate { min-height: 680px; margin: 0 .75rem 1rem; padding: 3rem 2rem; }
            .certificate-meta { flex-direction: column; align-items: center; gap: 1rem; }
        }
        @media print {
            body { background: #fff; print-color-adjust: exact; -webkit-print-color-adjust: exact; }
            .certificate-actions { display: none !important; }
            .certificate { width: 100%; max-width: none; min-height: 180mm; height: 180mm; margin: 0; padding: 2rem 3rem; box-shadow: none; break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="certificate-actions">
        <a href="{{ route('confirm-courses.index') }}">{{ __('Back to courses') }}</a>
        <button type="button" onclick="window.print()">{{ __('Download / print certificate') }}</button>
    </div>
    <main class="certificate" aria-label="{{ __('Certificate of Completion') }}">
        <img class="certificate-logo" src="{{ asset('img/dep-service-logo.svg') }}" alt="DEP Service">
        <p class="certificate-kicker">{{ $company?->company_name ?? config('app.name') }}</p>
        <h1>{{ __('Certificate of Completion') }}</h1>
        <p class="certificate-copy">{{ __('This certificate is proudly presented to') }}</p>
        <p class="certificate-name">{{ $employee->fullname }}</p>
        <p class="certificate-copy">{{ __('for successfully completing the course') }}</p>
        <p class="certificate-course">{{ $course->coursename }}</p>
        <p class="certificate-copy">{{ __('We recognize your commitment to learning and professional development.') }}</p>
        <div class="certificate-meta">
            <div><strong>{{ $completedAt->translatedFormat('F j, Y') }}</strong>{{ __('Date of completion') }}</div>
            <div><strong>{{ config('app.name', 'DEP Service') }}</strong>{{ __('Authorized training provider') }}</div>
        </div>
        <p class="certificate-number">{{ __('Certificate No.') }}: {{ $certificateNumber }}</p>
    </main>
</body>
</html>
