<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
        <label for="course_classification_id" class="md:col-span-3 text-sm font-medium text-slate-700">
            {{ __('Course Classification') }} : <span class="text-red-500">*</span>
        </label>
        <div class="md:col-span-9">
            <select class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_id" name="course_classification_id"
                required title="Course Classification" onchange="loadCourseAttribute(this)">
                <option value="">{{ __('Select Course Classification') }}</option>
                @foreach ($classifications as $classification)
                    <option value="{{ $classification->course_classification_id }}" @selected((string) old('course_classification_id') === (string) $classification->course_classification_id)>
                        {{ $classification->course_classification_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
        <label for="course_classification_details_id" class="md:col-span-3 text-sm font-medium text-slate-700">
            {{ __('Course Classification Details') }} :
        </label>
        <div class="md:col-span-9">
            <select class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" id="course_classification_details_id"
                name="course_classification_details_id" required title="Classification Detail">
                <option value="">{{ __('Select Course Classification Detail') }}</option>
                @foreach ($details as $detail)
                    <option value="{{ $detail->course_classification_details_id }}" @selected((string) old('course_classification_details_id') === (string) $detail->course_classification_details_id)>
                        {{ $detail->course_classification_detailsname }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
        <label for="coursename" class="md:col-span-3 text-sm font-medium text-slate-700">
            {{ __('Course Name') }}: <span class="text-red-500">*</span>
        </label>
        <div class="md:col-span-9">
            <input id="coursename" type="text" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" name="coursename"
                value="{{ old('coursename', $course->coursename ?? '') }}" required title="Course Name">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
        <label for="coursename_kana" class="md:col-span-3 text-sm font-medium text-slate-700">
            {{ __('Course Name (Kana)') }}:
        </label>
        <div class="md:col-span-9">
            <input type="text" name="coursename_kana" id="coursename_kana" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                title="Course Name (Kana)" value="{{ old('coursename_kana', $course->coursename_kana ?? '') }}">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
        <label for="course_description" class="md:col-span-3 text-sm font-medium text-slate-700 pt-2">
            {{ __('Course Description') }}: <span class="text-red-500">*</span>
        </label>
        <div class="md:col-span-9">
            <textarea name="course_description" id="course_description" class="w-full max-w-xl px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4" required
                title="Course Description">{{ old('course_description', $course->course_description ?? '') }}</textarea>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
        <label class="md:col-span-3 text-sm font-medium text-slate-700">
            {{ __('Retake within course period') }}: <span class="text-red-500">*</span>
        </label>
        <div class="md:col-span-9 flex gap-6 text-sm text-slate-700">
            <label class="inline-flex items-center gap-1.5 cursor-pointer">
                <input type="radio" name="possible_retake_course_deadline" id="re_attendance_possible"
                    value="1" required title="Re-attendance possible" class="text-blue-600" @checked(old('possible_retake_course_deadline') === '1')>
                {{ __('Allowed') }}
            </label>
            <label class="inline-flex items-center gap-1.5 cursor-pointer">
                <input type="radio" name="possible_retake_course_deadline" id="re_attendance_not_allowed"
                    value="2" required title="Re-attendance not allowed" class="text-blue-600" @checked(old('possible_retake_course_deadline') === '2')>
                {{ __('Not allowed') }}
            </label>
        </div>
    </div>

    <div id="attributeWrapper"></div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
        <label for="remarks" class="md:col-span-3 text-sm font-medium text-slate-700 pt-2">
            {{ __('Remarks') }}:
        </label>
        <div class="md:col-span-9">
            <textarea name="remarks" id="remarks" rows="4" class="w-full max-w-xl px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                title="Remarks">{{ old('remarks', $course->remarks ?? '') }}</textarea>
        </div>
    </div>
</div>
