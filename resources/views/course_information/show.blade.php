@extends('layouts.app')

@section('content')
<style>
    .course-detail-page { min-height: 100vh; background: #f1f5f9; }
    .course-detail-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .course-detail-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .course-detail-page__content, body.sidebar-collapsed .course-detail-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="course-detail-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="course-detail-page__content space-y-6">
        <nav aria-label="breadcrumb" class="text-sm text-slate-500">
            <a href="{{ route('course-settings') }}" class="hover:text-blue-700">{{ __('Course Settings') }}</a>
            <span class="mx-2">/</span><span class="font-medium text-slate-700">{{ __('Course Details') }}</span>
        </nav>

        <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <header class="flex flex-wrap items-center justify-between gap-3 bg-blue-900 px-5 py-4 text-white">
                <div>
                    <p class="text-sm text-blue-200">{{ __('Course Details') }}</p>
                    <h1 class="text-xl font-semibold">{{ $course->coursename }}</h1>
                </div>
                <a href="{{ route('course-settings') }}" class="inline-flex items-center gap-2 rounded-lg border border-white/40 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>{{ __('Back to course settings') }}
                </a>
            </header>

            <div class="grid gap-6 p-5 lg:grid-cols-2">
                <section class="rounded-xl border border-slate-200 p-5">
                    <h2 class="mb-4 text-base font-semibold text-slate-800">{{ __('Course Information') }}</h2>
                    <dl class="grid gap-4 sm:grid-cols-2">
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Course Name') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $course->coursename ?: '?' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Course Name Kana') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $course->coursename_kana ?: '?' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Course Classification') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $course->classification?->course_classification_name ?? __('Not available') }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Course Classification Details') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $course->classification_detail?->course_classification_detailsname ?? __('Not available') }}</dd></div>
                        <div class="sm:col-span-2"><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Description') }}</dt><dd class="mt-1 whitespace-pre-line text-sm text-slate-800">{{ $course->course_description ?: '?' }}</dd></div>
                        <div class="sm:col-span-2"><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Remarks') }}</dt><dd class="mt-1 whitespace-pre-line text-sm text-slate-800">{{ $course->remarks ?: '?' }}</dd></div>
                    </dl>
                </section>

                <section class="rounded-xl border border-slate-200 p-5">
                    <h2 class="mb-4 text-base font-semibold text-slate-800">{{ __('Completion and Test Settings') }}</h2>
                    <dl class="grid gap-4 sm:grid-cols-2">
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Retake') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $course->possible_retake_course_deadline ?: '?' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Repeated Retest') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $course->repeated_retest ?: '?' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Test Passing Score') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $course->test_passed_score !== null ? $course->test_passed_score . '%' : '?' }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('ToDo Type') }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $course->todo_type ?: '?' }}</dd></div>
                        <div class="sm:col-span-2"><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('ToDo Description') }}</dt><dd class="mt-1 whitespace-pre-line text-sm text-slate-800">{{ $course->todo_description ?: '?' }}</dd></div>
                    </dl>
                </section>

                <section class="rounded-xl border border-slate-200 p-5">
                    <h2 class="mb-4 text-base font-semibold text-slate-800">{{ __('Course Materials') }}</h2>
                    @forelse ($course->material as $material)
                        <article class="border-t border-slate-100 py-3 first:border-0 first:pt-0">
                            <h3 class="text-sm font-semibold text-slate-800">{{ $material->teaching_material_name ?: __('Untitled material') }}</h3>
                            <p class="mt-1 text-xs text-slate-500">{{ $material->material_type ?: '?' }}</p>
                            @if ($material->youtube_video_url)
                                <a href="{{ $material->youtube_video_url }}" target="_blank" rel="noopener noreferrer" class="mt-2 inline-flex items-center gap-1 text-sm text-blue-700 hover:underline"><i class="fas fa-external-link-alt" aria-hidden="true"></i>{{ __('Open material') }}</a>
                            @elseif ($material->book_file_path)
                                <a href="{{ asset($material->book_file_path) }}" target="_blank" rel="noopener noreferrer" class="mt-2 inline-flex items-center gap-1 text-sm text-blue-700 hover:underline"><i class="fas fa-file-alt" aria-hidden="true"></i>{{ __('Open material') }}</a>
                            @endif
                        </article>
                    @empty
                        <p class="text-sm text-slate-500">{{ __('No course materials.') }}</p>
                    @endforelse
                </section>

                <section class="rounded-xl border border-slate-200 p-5">
                    <h2 class="mb-4 text-base font-semibold text-slate-800">{{ __('ToDo Questions') }}</h2>
                    @forelse ($course->todo as $todo)
                        <article class="border-t border-slate-100 py-3 first:border-0 first:pt-0">
                            <h3 class="text-sm font-semibold text-slate-800">{{ $todo->question }}</h3>
                            <p class="mt-1 text-xs text-slate-500">{{ $todo->answer_type }}{{ $todo->required_settings ? ' ? ' . __('Required') : '' }}</p>
                            @if ($todo->choices->isNotEmpty())
                                <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-slate-700">
                                    @foreach ($todo->choices as $choice)
                                        <li>{{ $choice->choices }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </article>
                    @empty
                        <p class="text-sm text-slate-500">{{ __('No ToDo questions.') }}</p>
                    @endforelse
                </section>

                <section class="rounded-xl border border-slate-200 p-5 lg:col-span-2">
                    <h2 class="mb-4 text-base font-semibold text-slate-800">{{ __('Course Attributes') }}</h2>
                    <dl class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                        @foreach (range(1, 5) as $number)
                            @php($attribute = 'course_attributes_0' . $number)
                            <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Attribute') }} {{ str_pad((string) $number, 2, '0', STR_PAD_LEFT) }}</dt><dd class="mt-1 text-sm text-slate-800">{{ $course->{$attribute} ?: '?' }}</dd></div>
                        @endforeach
                    </dl>
                </section>
            </div>
        </section>
    </main>
</div>
@include('includes.footer')
@endsection
