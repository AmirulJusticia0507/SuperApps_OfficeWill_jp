@extends('layouts.app')

@section('content')
<style>
    .inquiry-page { min-height: 100vh; background: #f4f6f9; }
    .inquiry-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; }
    html.dark-mode .inquiry-page { background: #0b1220; }
    html.dark-mode .inquiry-page .bg-white { background-color: #172235 !important; }
    html.dark-mode .inquiry-page .border-slate-200 { border-color: #334155 !important; }
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
        <nav class="text-sm text-slate-500"><a href="{{ route('course-inquiry') }}" class="hover:underline">{{ __('Course Inquiries') }}</a> / <span class="font-medium text-slate-700">{{ __('Course Result Inquiry') }}</span></nav>
        <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <h1 class="rounded-t-xl bg-blue-900 px-5 py-4 font-semibold text-white">{{ __('Course Result Inquiry') }}</h1>
            <div class="overflow-x-auto p-5">
                <table class="w-full min-w-[680px] text-left text-sm">
                    <thead class="bg-slate-50 text-slate-700"><tr><th class="px-4 py-3">{{ __('Course Classification') }}</th><th class="px-4 py-3">{{ __('Course Classification Details') }}</th><th class="px-4 py-3">{{ __('Course Name') }}</th><th class="px-4 py-3 text-right">{{ __('Actions') }}</th></tr></thead>
                    <tbody>
                        @forelse($courses as $course)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3">{{ $course->classification?->course_classification_name ?? __('Not available') }}</td>
                                <td class="px-4 py-3">{{ $course->classification_detail?->course_classification_detailsname ?? __('Not available') }}</td>
                                <td class="px-4 py-3 font-medium text-slate-800">{{ $course->coursename }}</td>
                                <td class="px-4 py-3 text-right"><a href="{{ route('course-inquiry.enrollments', $course->course_id) }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-700 px-3 py-2 font-medium text-white hover:bg-blue-800"><i class="fas fa-eye"></i>{{ __('View results') }}</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">{{ __('No courses found.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
@include('includes.footer')
@endsection
