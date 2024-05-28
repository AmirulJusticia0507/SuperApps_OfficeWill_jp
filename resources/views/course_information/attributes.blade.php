@for ($i = 1; $i <= 5; $i++)
    @php
        $displayname = 'course_attribute0' . $i . '_displayname';
        $screenType = 'course_attribute0' . $i . '_screentype';
        $inputName = 'course_attributes_0' . $i;
    @endphp
    <div class="form-group row">
        <label for="{{ $inputName }}" class="col-sm-3 col-form-label">{{ $displayname }}</label>
        <div class="col-sm-9">

            @switch($attribute->{$screenType})
                @case(1)
                    <input type="text" name="{{ $inputName }}" id="{{ $inputName }}" class="form-control"
                        title="{{ $displayname }}">
                @break

                @case(2)
                    <select name="{{ $inputName }}" id="{{ $inputName }}" class="form-control" title="{{ $displayname }}">
                        <option value="">Dropdown</option>
                        <option value="">Dropdown</option>
                        <option value="">Dropdown</option>
                        <option value="">Dropdown</option>
                    </select>
                @break

                @case(3)
                    <input type="text" name="{{ $inputName }}" id="{{ $inputName }}" class="form-control date-picker"
                        title="{{ $displayname }}">
                @break

                @case(4)
                    <input type="text" name="{{ $inputName }}" id="{{ $inputName }}"
                        class="form-control month-picker" title="{{ $displayname }}">
                @break

                @default
            @endswitch
        </div>

    </div>
@endfor

<script>
    $(document).ready(function() {
        $('.date-picker').datepicker({
            format: 'yyyy-mm-dd',
        });
        $('.month-picker').datepicker({
            format: 'yyyy-mm',
            viewMode: 'months',
            minViewMode: 'months'
        });
        $('.year-picker').datepicker({
            format: 'yyyy',
            viewMode: 'years',
            minViewMode: 'years'
        });
    });
</script>
