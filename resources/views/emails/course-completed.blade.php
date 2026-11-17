<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Course completion confirmation') }}</title>
</head>
<body style="margin:0;background:#f1f5f9;padding:32px 16px;font-family:Arial,sans-serif;color:#0f172a">
    <main style="max-width:560px;margin:0 auto;border:1px solid #e2e8f0;border-radius:18px;background:#fff;padding:32px">
        <p style="margin:0 0 24px;color:#0891b2;font-size:12px;font-weight:700;letter-spacing:.12em;text-transform:uppercase">DEP Service</p>
        <h1 style="margin:0 0 16px;font-size:24px;line-height:1.3">{{ __('Course completion confirmation') }}</h1>
        <p style="margin:0 0 16px;line-height:1.7">{{ __('Hello :name,', ['name' => $employeeName]) }}</p>
        <p style="margin:0 0 20px;line-height:1.7">{{ __('You have successfully completed the course: :course', ['course' => $courseName]) }}</p>
        <div style="margin:0 0 24px;border-radius:12px;background:#f8fafc;padding:16px">
            <p style="margin:0 0 6px;color:#64748b;font-size:12px">{{ __('Completed at') }}</p>
            <p style="margin:0;font-size:15px;font-weight:700">{{ $completedAt }}</p>
        </div>
        <p style="margin:0 0 24px;color:#475569;line-height:1.7">{{ __('Thank you for completing the course materials and ToDo.') }}</p>
        <p style="margin:0 0 24px"><a href="{{ $certificateUrl }}" style="display:inline-block;border-radius:10px;background:#1d4ed8;padding:12px 18px;color:#fff;font-weight:700;text-decoration:none">{{ __('View and download your certificate') }}</a></p>
        <p style="margin:0;border-top:1px solid #e2e8f0;padding-top:18px;color:#64748b;font-size:13px">{{ config('app.name') }}</p>
    </main>
</body>
</html>
