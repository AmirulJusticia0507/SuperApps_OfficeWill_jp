@extends('layouts.app')

@section('content')
<style>
    .inquiry-page { min-height: 100vh; background: #f4f6f9; }
    .inquiry-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; }
    html.dark-mode .inquiry-page { background: #0b1220; }
    html.dark-mode .inquiry-page .bg-white { background-color: #172235 !important; }
    html.dark-mode .inquiry-page .border-slate-200 { border-color: #334155 !important; }
    html.dark-mode .inquiry-page .border-slate-100 { border-color: #334155 !important; }
    html.dark-mode .inquiry-page .bg-slate-50 { background-color: #10203a !important; }
    html.dark-mode .inquiry-page .text-slate-700,
    html.dark-mode .inquiry-page .text-slate-800 { color: #e2e8f0 !important; }
    html.dark-mode .inquiry-page .text-slate-500 { color: #a7b4c7 !important; }
    @media (max-width: 767.98px) { .inquiry-page__content { margin-left: 0; width: 100%; padding: 1rem; } }
</style>
<div class="inquiry-page">
    @include('includes.header')
    @include('includes.sidebar')
    <main class="inquiry-page__content space-y-5">
        <nav class="text-sm text-slate-500"><a href="{{ route('course-inquiry.results') }}" class="hover:underline">{{ __('Course Result Inquiry') }}</a> / <span class="font-medium text-slate-700">{{ $course->coursename }}</span></nav>
        <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-3 rounded-t-xl bg-blue-900 px-5 py-4 text-white"><div><p class="text-xs text-blue-100">{{ $course->classification?->course_classification_name }} / {{ $course->classification_detail?->course_classification_detailsname }}</p><h1 class="font-semibold">{{ $course->coursename }}</h1></div><span class="rounded-full bg-white/15 px-3 py-1 text-sm">{{ $enrollments->count() }} {{ __('enrollments') }}</span></div>
            <div class="overflow-x-auto p-5">
                <table class="w-full min-w-[850px] text-left text-sm">
                    <thead class="bg-slate-50 text-slate-700"><tr><th class="px-3 py-3">{{ __('Employee Code') }}</th><th class="px-3 py-3">{{ __('Full Name') }}</th><th class="px-3 py-3">{{ __('Affiliation') }}</th><th class="px-3 py-3">{{ __('Course Deadline') }}</th><th class="px-3 py-3">{{ __('ToDo Progress') }}</th><th class="px-3 py-3 text-right">{{ __('Actions') }}</th></tr></thead>
                    <tbody>
                        @forelse($enrollments as $enrollment)
                            <tr class="border-t border-slate-100">
                                <td class="px-3 py-3">{{ $enrollment->employee?->employee_code ?? '—' }}</td>
                                <td class="px-3 py-3 font-medium text-slate-800">{{ $enrollment->employee?->fullname ?? __('Employee unavailable') }}</td>
                                <td class="px-3 py-3">{{ $enrollment->employee?->employee_affiliation?->affiliation?->affiliation_name ?? '—' }}</td>
                                <td class="px-3 py-3">{{ $enrollment->deadline_enrollment ?: '—' }}</td>
                                <td class="px-3 py-3">{{ __($enrollment->todo_progress_text) }}</td>
                                <td class="px-3 py-3 text-right"><a href="{{ route('course-inquiry.responses', $enrollment->attendance_setting_id) }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-700 px-3 py-2 font-medium text-white hover:bg-blue-800"><i class="fas fa-clipboard-list"></i>{{ __('View responses') }}</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-8 text-center text-slate-500">{{ __('No employees are enrolled in this course yet.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
        <a href="{{ route('course-inquiry.results') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"><i class="fas fa-arrow-left"></i>{{ __('Back to courses') }}</a>
    </main>
</div>
@include('includes.footer')
@endsection
