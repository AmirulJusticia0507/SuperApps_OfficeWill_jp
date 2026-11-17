@extends('layouts.app')

@section('content')
<style>
    .class-details-page { min-height: 100vh; background: #f4f6f9; }
    .class-details-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .class-details-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .class-details-page__content, body.sidebar-collapsed .class-details-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="class-details-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="class-details-page__content">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="flex flex-wrap gap-1 text-sm text-slate-500 mb-4">
                <li><a href="#" title="{{ __('Course Classification Details Registration') }}" class="hover:text-blue-600">{{ __('Course Classification Details Registration') }}</a></li>
                <li class="before:content-['/'] before:mx-1"><a href="{{ route('course-classification-details.index') }}" title="{{ __('Course Classification Details') }}" class="hover:text-blue-600">{{ __('Course Classification Details') }}</a></li>
                <li class="before:content-['/'] before:mx-1 text-slate-700 font-medium" aria-current="page" title="{{ __('Edit Course Classification Detail') }}">{{ __('Edit Course Classification Detail') }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-5 py-4 bg-blue-900 text-white rounded-t-xl font-semibold" title="{{ __('Edit Course Classification Detail') }}">
                {{ __('Edit Course Classification Detail') }}
            </div>

            <div class="p-6">
                @if($detail)
                    <form method="POST" action="{{ route('course-classification-details.update', $detail->course_classification_details_id) }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                                <ul class="list-inside list-disc space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div>
                            <label for="course_classification_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Classification ID: <span class="text-rose-500">*</span></label>
                            <select class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm bg-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" id="course_classification_id" name="course_classification_id" required>
                                <option value="">Select Classification ID</option>
                                @foreach ($classifications as $classification)
                                    <option value="{{ $classification->course_classification_id }}" {{ $detail->course_classification_id == $classification->course_classification_id ? 'selected' : '' }}>
                                        {{ $classification->course_classification_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="course_classification_detailsname" class="block text-sm font-semibold text-slate-700 mb-1.5">Classification Detail Name: <span class="text-rose-500">*</span></label>
                            <input type="text" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" id="course_classification_detailsname" name="course_classification_detailsname" value="{{ $detail->course_classification_detailsname }}" required>
                        </div>

                        <div>
                            <label for="icon_file_path" class="block text-sm font-semibold text-slate-700 mb-1.5">Icon File Path:</label>
                            <input type="file" accept="image/*" class="block w-full rounded-xl border border-slate-300 bg-white p-2 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:font-semibold file:text-blue-800 hover:file:bg-blue-100 cursor-pointer" id="icon_file_path" name="icon_file_path" onchange="previewDetailIcon(this)">
                            @if (!empty($detail->icon_url))
                                <img id="icon_preview" src="{{ $detail->icon_url }}" alt="Current icon" class="mt-3 max-w-[100px] rounded-lg border border-slate-200 object-contain p-1">
                            @else
                                <img id="icon_preview" src="#" alt="{{ __('Icon preview') }}" class="mt-3 hidden max-h-24 rounded-lg border border-slate-200 object-contain p-1">
                            @endif
                        </div>

                        <div>
                            <label for="display_order" class="block text-sm font-semibold text-slate-700 mb-1.5">Display Order: <span class="text-rose-500">*</span></label>
                            <input type="number" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" id="display_order" name="display_order" value="{{ $detail->display_order }}" required>
                        </div>

                        <div class="pt-5 flex justify-end gap-3 border-t border-slate-100">
                            <a href="{{ route('course-classification-details.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold transition hover:bg-slate-50">{{ __('Cancel') }}</a>
                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold shadow-sm transition"><i class="fas fa-edit"></i> Update</button>
                        </div>
                    </form>
                @else
                    <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg text-sm">
                        Course classification detail not found.
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>

@include('includes.footer')

<script>
    function previewDetailIcon(input) {
        const preview = document.getElementById('icon_preview');
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.classList.remove('hidden');
        }
    }
</script>
@endsection
