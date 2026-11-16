@extends('layouts.app')

@section('content')
    @include('includes.header')

    <div class="row justify-content-center">
        <aside class="col-md-3">
            @include('includes.sidebar')
        </aside>

        <main class="col-md-8 py-4">
            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('course-list') }}">{{ __('Course List') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Register Course') }}</li>
                </ol>
            </nav>

            <div class="card course-stepper" data-course-stepper x-data="{ todo_type: @js(old('todo_type', '')) }">
                <div class="card-header course-stepper__header">
                    <h1 class="h4 mb-1">{{ __('Register a course') }}</h1>
                    <p class="mb-0 text-muted">{{ __('Complete each step, then review before saving.') }}</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger mx-3 mt-3" role="alert">
                        <p class="mb-1">{{ __('Please correct these items before saving:') }}</p>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('course-information.store') }}" method="POST" enctype="multipart/form-data"
                    novalidate data-course-form data-validation-errors='@json($errors->keys())'>
                    @csrf

                    <ol class="course-stepper__progress" aria-label="{{ __('Course registration progress') }}">
                        <li><button type="button" data-step-indicator aria-controls="course-step-basic"><span class="course-stepper__number">1</span><span>{{ __('Course details') }}</span></button></li>
                        <li><button type="button" data-step-indicator aria-controls="course-step-materials"><span class="course-stepper__number">2</span><span>{{ __('Materials') }}</span></button></li>
                        <li><button type="button" data-step-indicator aria-controls="course-step-todo"><span class="course-stepper__number">3</span><span>{{ __('Post-course ToDo') }}</span></button></li>
                        <li><button type="button" data-step-indicator aria-controls="course-step-review"><span class="course-stepper__number">4</span><span>{{ __('Review') }}</span></button></li>
                    </ol>

                    <section id="course-step-basic" class="course-stepper__panel" data-step-panel data-step-label="{{ __('Course details') }}" aria-labelledby="course-step-basic-title">
                        <h2 id="course-step-basic-title" class="h5 course-stepper__title">{{ __('Course details') }}</h2>
                        <p class="text-muted">{{ __('Set the course name, classification, and description.') }}</p>
                        @include('course_information.steps.basic')
                    </section>

                    <section id="course-step-materials" class="course-stepper__panel" data-step-panel data-step-label="{{ __('Materials') }}" aria-labelledby="course-step-materials-title" hidden>
                        <h2 id="course-step-materials-title" class="h5 course-stepper__title">{{ __('Teaching materials') }}</h2>
                        <p class="text-muted">{{ __('Add one or more videos or book files.') }}</p>
                        @include('course_information.steps.materials')
                    </section>

                    <section id="course-step-todo" class="course-stepper__panel" data-step-panel data-step-label="{{ __('Post-course ToDo') }}" aria-labelledby="course-step-todo-title" hidden>
                        <h2 id="course-step-todo-title" class="h5 course-stepper__title">{{ __('Post-course ToDo') }}</h2>
                        <p class="text-muted">{{ __('Choose what learners need to complete after the course.') }}</p>
                        @include('course_information.steps.todo_settings')
                        @include('course_information.steps.todo_questions')
                    </section>

                    <section id="course-step-review" class="course-stepper__panel" data-step-panel data-step-label="{{ __('Review') }}" aria-labelledby="course-step-review-title" hidden>
                        <h2 id="course-step-review-title" class="h5 course-stepper__title">{{ __('Review course details') }}</h2>
                        <p class="text-muted">{{ __('Check the summary before creating the course.') }}</p>
                        @include('course_information.steps.review')
                    </section>

                    <div class="course-stepper__navigation">
                        <button type="button" class="btn btn-outline-secondary" data-step-previous hidden>{{ __('Back') }}</button>
                        <span class="course-stepper__step-count" data-step-count aria-live="polite"></span>
                        <button type="button" class="btn btn-primary" data-step-next>{{ __('Continue') }}</button>
                        <button type="submit" class="btn btn-primary" data-step-submit hidden>{{ __('Create course') }}</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    @include('includes.footer')
@endsection

@push('scripts')
    <script src="{{ asset('js/course-form-stepper.js') }}" defer></script>
@endpush
