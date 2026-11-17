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
        <nav class="text-sm text-slate-500"><a href="{{ route('course-inquiry.results') }}" class="hover:underline">{{ __('Course Result Inquiry') }}</a> / <a href="{{ route('course-inquiry.enrollments', $enrollment->course_id) }}" class="hover:underline">{{ $enrollment->course?->coursename }}</a> / <span class="font-medium text-slate-700">{{ __('Responses') }}</span></nav>
        <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="rounded-t-xl bg-blue-900 px-5 py-4 text-white"><h1 class="font-semibold">{{ __('Course Responses') }}</h1><p class="mt-1 text-sm text-blue-100">{{ $enrollment->course?->coursename }} · {{ $employee->fullname }} ({{ $employee->employee_code }})</p></div>
            <div class="grid gap-4 border-b border-slate-200 p-5 sm:grid-cols-2 lg:grid-cols-4">
                <div><p class="text-xs text-slate-500">{{ __('ToDo Progress') }}</p><p class="mt-1 font-semibold text-slate-800">{{ __($enrollment->todo_progress_text) }}</p></div>
                <div><p class="text-xs text-slate-500">{{ __('Completed At') }}</p><p class="mt-1 font-semibold text-slate-800">{{ $enrollment->todo_complete ?: '—' }}</p></div>
                <div><p class="text-xs text-slate-500">{{ __('Latest Test Score') }}</p><p class="mt-1 font-semibold text-slate-800">{{ $enrollment->latest_test_accuracy_rate !== null ? $enrollment->latest_test_accuracy_rate . '%' : '—' }}</p></div>
                <div><p class="text-xs text-slate-500">{{ __('Test Passing Score') }}</p><p class="mt-1 font-semibold text-slate-800">{{ $enrollment->course?->test_passed_score !== null ? $enrollment->course->test_passed_score . '%' : '—' }}</p></div>
            </div>
            <div class="space-y-4 p-5">
                @forelse($enrollment->course?->todo ?? [] as $index => $todo)
                    @php
                        $typeLabels = ['1' => __('Survey'), '2' => __('Test'), '3' => __('Report')];
                        $itemAnswer = $textAnswers->get($todo->todo_item_id);
                        $itemSelections = $selectionAnswers->get($todo->todo_item_id, collect());
                    @endphp
                    <article class="rounded-xl border border-slate-200 p-4">
                        <div class="mb-3 flex flex-wrap items-center justify-between gap-2"><h2 class="font-semibold text-slate-800">{{ $index + 1 }}. {{ $todo->question }}</h2><span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-800">{{ $typeLabels[(string) $enrollment->course->todo_type] ?? __('Response') }}</span></div>
                        @if($itemSelections->isNotEmpty())
                            <ul class="space-y-2 text-sm text-slate-700">
                                @foreach($itemSelections as $selection)
                                    @php $selectedChoice = $todo->choices->firstWhere('todo_option_id', $selection->todo_option_id); @endphp
                                    <li class="flex flex-wrap items-center gap-2 rounded-lg bg-slate-50 px-3 py-2">
                                        <span>{{ $selectedChoice?->choices ?? $selection->selection ?? '—' }}</span>
                                        @if($selection->other_text_answer)<span class="text-slate-500">— {{ $selection->other_text_answer }}</span>@endif
                                        @if((string) $enrollment->course->todo_type === '2')
                                            <span class="ml-auto text-xs font-semibold {{ (string) $selectedChoice?->test_choice_correct_answer === '1' ? 'text-emerald-700' : 'text-red-600' }}">{{ (string) $selectedChoice?->test_choice_correct_answer === '1' ? __('Correct') : __('Incorrect') }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        @if($itemAnswer && ($itemAnswer->report || $itemAnswer->text_answer))
                            <div class="whitespace-pre-wrap rounded-lg bg-slate-50 p-3 text-sm text-slate-700">{{ $itemAnswer->report ?: $itemAnswer->text_answer }}</div>
                        @endif
                        @if(!$itemAnswer && $itemSelections->isEmpty())
                            <p class="text-sm italic text-slate-500">{{ __('No response recorded for this item.') }}</p>
                        @endif
                    </article>
                @empty
                    <p class="py-8 text-center text-slate-500">{{ __('This course has no post-course questions.') }}</p>
                @endforelse
            </div>
        </section>
        <a href="{{ route('course-inquiry.enrollments', $enrollment->course_id) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"><i class="fas fa-arrow-left"></i>{{ __('Back to course results') }}</a>
    </main>
</div>
@include('includes.footer')
@endsection
