<div class="space-y-4" x-data="{ fields: @js(old('todo', [['question' => '', 'answer_type' => '1', 'answer_input' => '2', 'option' => ['']]])) }">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
        <label class="md:col-span-3 text-sm font-medium text-slate-700">
            {{ __('ToDo Type') }}: <span class="text-red-500">*</span>
        </label>
        <div class="md:col-span-9 flex flex-wrap gap-6 text-sm text-slate-700">
            <label class="inline-flex items-center gap-1.5 cursor-pointer">
                <input type="radio" x-model="todo_type" x-bind:name="`todo_type`" id="survey_answers" value="1" title="Survey answers" class="text-blue-600" required>
                {{ __('Survey Answers') }}
            </label>
            <label class="inline-flex items-center gap-1.5 cursor-pointer">
                <input type="radio" x-model="todo_type" x-bind:name="`todo_type`" id="tests" value="2" title="Tests" class="text-blue-600" required>
                {{ __('Test') }}
            </label>
            <label class="inline-flex items-center gap-1.5 cursor-pointer">
                <input type="radio" x-model="todo_type" x-bind:name="`todo_type`" id="reports" value="3" title="Reports" class="text-blue-600" required>
                {{ __('Report') }}
            </label>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
        <label for="todo_description" class="md:col-span-3 text-sm font-medium text-slate-700 pt-2">
            {{ __('ToDo Description') }}: <span class="text-red-500">*</span>
        </label>
        <div class="md:col-span-9">
            <textarea name="todo_description" id="todo_description" rows="4" class="w-full max-w-xl px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                title="ToDo Description" required>{{ old('todo_description') }}</textarea>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
        <label class="md:col-span-3 text-sm font-medium text-slate-700">
            {{ __('Retest') }}: <span class="text-red-500">*</span>
        </label>
        <div class="md:col-span-9 flex gap-6 text-sm text-slate-700">
            <label class="inline-flex items-center gap-1.5 cursor-pointer">
                <input type="radio" name="repeated_retest" id="retest_availability" value="1" title="Retest availability" class="text-blue-600" required @checked(old('repeated_retest') === '1')>
                {{ __('Retest available') }}
            </label>
            <label class="inline-flex items-center gap-1.5 cursor-pointer">
                <input type="radio" name="repeated_retest" id="no_retest_availability" value="2" title="No Retest Availability" class="text-blue-600" required @checked(old('repeated_retest') === '2')>
                {{ __('No retest') }}
            </label>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
        <label for="test_passed_score" class="md:col-span-3 text-sm font-medium text-slate-700">
            {{ __('Passing Score Threshold') }}:
        </label>
        <div class="md:col-span-9">
            <input type="number" min="0" max="100" step="0.01" name="test_passed_score" id="test_passed_score" class="w-full max-w-xs px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="0-100" value="{{ old('test_passed_score') }}" title="Test Pass Threshold">
            <p class="text-xs text-slate-500 mt-1">{{ __('Complete the course by answering at least this percentage correctly.') }}</p>
        </div>
    </div>
</div>
