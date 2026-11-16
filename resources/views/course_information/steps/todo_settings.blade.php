<div id="posttodo" class="card-header" style="background-color: #92CDFC;border-radius:0;"><b
                            style="color:aliceblue">
                            {{ __('Post-course ToDo') }}</b></div>
                    <div class="card-body" x-data="{ fields: @js(old('todo', [['question' => '', 'answer_type' => '1', 'answer_input' => '2', 'option' => ['']]])) }">
                        <div class="mb-3">
                            <div style="display: flex; align-items: center;">
                                <label for="todo_type" style="margin-right: 10px;" style="width: 100%">{{ __('ToDo Type') }}: <b
                                        style="color: red">*</b></label>
                                <div style="display: flex;">
                                    <input type="radio" x-model="todo_type" x-bind:name="`todo_type`"
                                        id="survey_answers" value="1" title="Survey answers" required>
                                    <label for="survey_answers" style="margin-right: 10px;">{{ __('Survey Answers') }}</label>
                                    <input type="radio" x-model="todo_type" x-bind:name="`todo_type`" id="tests"
                                        value="2" title="Tests" required>
                                    <label for="tests" style="margin-right: 10px;">{{ __('Test') }}</label>
                                    <input type="radio" x-model="todo_type" x-bind:name="`todo_type`" id="reports"
                                        value="3" title="Reports" required>
                                    <label for="reports" style="margin-right: 10px;">{{ __('Report') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="todo_description">{{ __('ToDo Description') }}: <b style="color: red">*</b></label>
                            <textarea name="todo_description" id="todo_description" cols="5" rows="5" class="form-control"
                                title="ToDo Description" required>{{ old('todo_description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <div style="display: flex; align-items: center;">
                                <label for="sex" style="margin-right: 10px;" style="width: 100%">{{ __('Retest') }}: <b
                                        style="color: red">*</b></label>
                                <div style="display: flex;">
                                    <input type="radio" name="repeated_retest" id="retest_availability" value="1"
                                        title="Retest availability" required @checked(old('repeated_retest') === '1')>
                                    <label for="retest_availability" style="margin-right: 10px;">{{ __('Retest available') }}</label>
                                    <input type="radio" name="repeated_retest" id="no_retest_availability"
                                        value="2" title="No Retest Availability" required @checked(old('repeated_retest') === '2')>
                                    <label for="no_retest_availability" style="margin-right: 10px;">{{ __('No retest') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="test_passed_score">{{ __('Passing Score Threshold') }}:</label>
                            <input type="number" min="0" max="100" step="0.01" name="test_passed_score" id="test_passed_score" class="form-control"
                                placeholder="0?100" value="{{ old('test_passed_score') }}"
                                title="Test Pass Threshold">
                            <p>{{ __('Complete the course by answering at least this percentage correctly.') }}</p>
                        </div>
