@extends('layouts.app')

@section('content')
<style>
    .course-info-page { min-height: 100vh; background: #f4f6f9; }
    .course-info-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .course-info-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .course-info-page__content, body.sidebar-collapsed .course-info-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }

    /* ── Wizard stepper indicator states ── */
    /* Default (not yet visited) */
    [data-step-indicator] {
        color: #94a3b8; /* slate-400 */
        transition: color .15s, background .15s;
    }
    [data-step-indicator] .course-stepper__number {
        background: #f1f5f9; /* slate-100 */
        color: #94a3b8;
        transition: background .15s, color .15s;
    }

    /* Current active step */
    [data-step-indicator].is-current {
        color: #1e3a8a; /* blue-900 */
        font-weight: 700;
        background: #eff6ff; /* blue-50 */
        border-radius: .5rem;
    }
    [data-step-indicator].is-current .course-stepper__number {
        background: #1d4ed8; /* blue-700 */
        color: #fff;
        box-shadow: 0 0 0 3px #bfdbfe; /* blue-200 ring */
    }

    /* Completed step */
    [data-step-indicator].is-complete {
        color: #15803d; /* green-700 */
    }
    [data-step-indicator].is-complete .course-stepper__number {
        background: #dcfce7; /* green-100 */
        color: #15803d;
        font-size: 0; /* hide number, show checkmark */
        position: relative;
    }
    [data-step-indicator].is-complete .course-stepper__number::after {
        content: '✓';
        font-size: .75rem;
        font-weight: 700;
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Connector line between steps */
    .course-stepper__progress li:not(:last-child)::after {
        content: '';
        display: inline-block;
        width: 1.5rem;
        height: 2px;
        background: #e2e8f0;
        vertical-align: middle;
        margin: 0 .25rem;
        border-radius: 1px;
    }
    .course-stepper__progress li:not(:last-child):has(button.is-complete)::after {
        background: #86efac; /* green-300 */
    }
</style>

<div class="course-info-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="course-info-page__content">
        <nav aria-label="Breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a href="{{ route('course-list') }}" class="hover:text-blue-600">{{ __('Course List') }}</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page">{{ __('Register Course') }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden course-stepper" data-course-stepper x-data="{ todo_type: @js(old('todo_type', '')) }">
            <div class="px-6 py-5 border-b border-slate-100 course-stepper__header">
                <h1 class="text-xl font-bold text-slate-800 mb-1">{{ __('Register a course') }}</h1>
                <p class="text-sm text-slate-500 mb-0">{{ __('Complete each step, then review before saving.') }}</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mx-6 mt-4 text-sm" role="alert">
                    <p class="font-medium mb-1">{{ __('Please correct these items before saving:') }}</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('course-information.store') }}" method="POST" enctype="multipart/form-data"
                novalidate data-course-form data-validation-errors='@json($errors->keys())' class="p-6 space-y-6">
                @csrf

                <ol class="course-stepper__progress flex flex-wrap gap-2 pb-4 border-b border-slate-100" aria-label="{{ __('Course registration progress') }}">
                    <li><button type="button" data-step-indicator aria-controls="course-step-basic" class="inline-flex items-center gap-2 text-sm font-medium px-3 py-1.5 rounded-lg"><span class="course-stepper__number w-6 h-6 rounded-full bg-blue-100 text-blue-800 text-xs flex items-center justify-center font-bold">1</span><span>{{ __('Course details') }}</span></button></li>
                    <li><button type="button" data-step-indicator aria-controls="course-step-materials" class="inline-flex items-center gap-2 text-sm font-medium px-3 py-1.5 rounded-lg"><span class="course-stepper__number w-6 h-6 rounded-full bg-slate-100 text-slate-600 text-xs flex items-center justify-center font-bold">2</span><span>{{ __('Materials') }}</span></button></li>
                    <li><button type="button" data-step-indicator aria-controls="course-step-todo" class="inline-flex items-center gap-2 text-sm font-medium px-3 py-1.5 rounded-lg"><span class="course-stepper__number w-6 h-6 rounded-full bg-slate-100 text-slate-600 text-xs flex items-center justify-center font-bold">3</span><span>{{ __('Post-course ToDo') }}</span></button></li>
                    <li><button type="button" data-step-indicator aria-controls="course-step-review" class="inline-flex items-center gap-2 text-sm font-medium px-3 py-1.5 rounded-lg"><span class="course-stepper__number w-6 h-6 rounded-full bg-slate-100 text-slate-600 text-xs flex items-center justify-center font-bold">4</span><span>{{ __('Review') }}</span></button></li>
                </ol>

                <section id="course-step-basic" class="course-stepper__panel space-y-4" data-step-panel data-step-label="{{ __('Course details') }}" aria-labelledby="course-step-basic-title">
                    <div>
                        <h2 id="course-step-basic-title" class="text-lg font-semibold text-slate-800">{{ __('Course details') }}</h2>
                        <p class="text-sm text-slate-500">{{ __('Set the course name, classification, and description.') }}</p>
                    </div>
                    @include('course_information.steps.basic')
                </section>

                <section id="course-step-materials" class="course-stepper__panel space-y-4" data-step-panel data-step-label="{{ __('Materials') }}" aria-labelledby="course-step-materials-title" hidden>
                    <div>
                        <h2 id="course-step-materials-title" class="text-lg font-semibold text-slate-800">{{ __('Teaching materials') }}</h2>
                        <p class="text-sm text-slate-500">{{ __('Add one or more videos or book files.') }}</p>
                    </div>
                    @include('course_information.steps.materials')
                </section>

                <section id="course-step-todo" class="course-stepper__panel space-y-4" data-step-panel data-step-label="{{ __('Post-course ToDo') }}" aria-labelledby="course-step-todo-title" hidden>
                    <div>
                        <h2 id="course-step-todo-title" class="text-lg font-semibold text-slate-800">{{ __('Post-course ToDo') }}</h2>
                        <p class="text-sm text-slate-500">{{ __('Choose what learners need to complete after the course.') }}</p>
                    </div>
                    @include('course_information.steps.todo_settings')
                    @include('course_information.steps.todo_questions')
                </section>

                <section id="course-step-review" class="course-stepper__panel space-y-4" data-step-panel data-step-label="{{ __('Review') }}" aria-labelledby="course-step-review-title" hidden>
                    <div>
                        <h2 id="course-step-review-title" class="text-lg font-semibold text-slate-800">{{ __('Review course details') }}</h2>
                        <p class="text-sm text-slate-500">{{ __('Check the summary before creating the course.') }}</p>
                    </div>
                    @include('course_information.steps.review')
                </section>

                <div class="course-stepper__navigation flex items-center justify-between pt-6 border-t border-slate-100">
                    <button type="button" class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-lg transition" data-step-previous hidden><i class="fas fa-chevron-left"></i> {{ __('Back') }}</button>
                    <span class="course-stepper__step-count text-sm text-slate-500" data-step-count aria-live="polite"></span>
                    <button type="button" class="inline-flex items-center gap-1.5 px-5 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg shadow-sm transition ml-auto" data-step-next>{{ __('Continue') }} <i class="fas fa-chevron-right"></i></button>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-sm transition" data-step-submit hidden><i class="fas fa-check"></i> {{ __('Create course') }}</button>
                </div>
            </form>
        </div>
    </main>
</div>

<!-- Footer -->
@include('includes.footer')
@endsection

@push('scripts')
    <script src="{{ asset('js/course-form-stepper.js') }}" defer></script>
@endpush
