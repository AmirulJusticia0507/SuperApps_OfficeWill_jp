<div id="basicinformation" class="card-header" style="background-color: #92CDFC;border-radius:0;"><b
                            style="color:aliceblue">
                            basic information</b></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="course_classification_id" style="display: inline-block; width: 30%;">{{ __('Course Classification') }}
                                :</label><b style="color: red">*</b>
                            <select class="form-control" id="course_classification_id" name="course_classification_id"
                                required style="display: inline-block; width: 60%;" title="Course Classification"
                                onchange="loadCourseAttribute(this)">
                                <option value="">Select Course Classification</option>
                                @foreach ($classifications as $classification)
                                    <option value="{{ $classification->course_classification_id }}" @selected((string) old('course_classification_id') === (string) $classification->course_classification_id)>
                                        {{ $classification->course_classification_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="course_classification_details_id" style="display: inline-block; width: 30%;">{{ __('Course Classification Details') }}
                                :</label>
                            <select class="form-control" id="course_classification_details_id"
                                name="course_classification_details_id" required style="display: inline-block; width: 60%;"
                                title="Classification Detail">
                                <option value="">Select Course Classification Detail</option>
                                @foreach ($details as $detail)
                                    <option value="{{ $detail->course_classification_details_id }}" @selected((string) old('course_classification_details_id') === (string) $detail->course_classification_details_id)>
                                        {{ $detail->course_classification_detailsname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="coursename" style="display: inline-block; width: 30%;">{{ __('Course Name') }}: </label><b
                                style="color: red">*</b>
                            <input id="coursename" type="text" class="form-control" name="coursename"
                                value="{{ old('coursename', $course->coursename ?? '') }}" required
                                style="display: inline-block; width: 60%;" title="Course Name">
                        </div>

                        <div class="form-group">
                            <label for="coursename_kana" style="display: inline-block; width: 30%;">{{ __('Course Name (Kana)') }}:</label>
                            <input type="text" name="coursename_kana" id="coursename_kana" class="form-control"
                                style="display: inline-block; width: 60%;" title="Course Name (Kana)" value="{{ old('coursename_kana', $course->coursename_kana ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label for="course_description" style="display: inline-block; width: 30%;">{{ __('Course Description') }}: <b
                                    style="color: red">*</b></label>
                            <textarea name="course_description" id="course_description" class="form-control" cols="5" rows="5" required
                                style="display: inline-block; width: 60%;" title="Course Description">{{ old('course_description', $course->course_description ?? '') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="possible_retake_course_deadline"
                                style="display: inline-block; width: 30%;">{{ __('Retake within course period') }}
                                :<b style="color: red">*</b></label>
                            <div style="display: inline-block; width: 60%;">
                                <input type="radio" name="possible_retake_course_deadline" id="re_attendance_possible"
                                    value="1" required title="Re-attendance possible" @checked(old('possible_retake_course_deadline') === '1')>
                                <label for="re_attendance_possible"
                                    style="margin-right: 5px; margin-left: 5px;">{{ __('Allowed') }}</label>
                                <input type="radio" name="possible_retake_course_deadline"
                                    id="re_attendance_not_allowed" value="2" required
                                    title="Re-attendance not allowed" @checked(old('possible_retake_course_deadline') === '2')>
                                <label for="re_attendance_not_allowed"
                                    style="margin-right: 10px; margin-left: 5px;">{{ __('Not allowed') }}</label>
                            </div>
                        </div>

                        <div id="attributeWrapper"></div>
                        <div class="form-group">
                            <label for="remarks" style="display: inline-block; width: 30%;">{{ __('Remarks') }}:</label>
                            <textarea name="remarks" id="remarks" cols="5" rows="5" class="form-control"
                                style="display: inline-block; width: 60%;" title="Remarks">{{ old('remarks', $course->remarks ?? '') }}</textarea>
                        </div>
                    </div>
