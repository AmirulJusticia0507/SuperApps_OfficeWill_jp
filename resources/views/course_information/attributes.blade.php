@for ($i = 1; $i <= 5; $i++)
    @php
        $displayname = 'course_attribute0' . $i . '_displayname';
        $screenType = 'course_attribute0' . $i . '_screentype';
        $inputName = 'course_attributes_0' . $i;
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center mb-4">
        <label for="{{ $inputName }}" class="md:col-span-3 text-sm font-medium text-slate-700">{{ $displayname }}</label>
        <div class="md:col-span-9">
            @switch($attribute->{$screenType})
                @case(1)
                    <input type="text" name="{{ $inputName }}" id="{{ $inputName }}" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        title="{{ $displayname }}">
                @break

                @case(2)
                    <select name="{{ $inputName }}" id="{{ $inputName }}" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" title="{{ $displayname }}">
                        <option value="">Dropdown</option>
                        <option value="">Dropdown</option>
                        <option value="">Dropdown</option>
                        <option value="">Dropdown</option>
                    </select>
                @break

                @case(3)
                    <input type="text" name="{{ $inputName }}" id="{{ $inputName }}" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 date-picker"
                        title="{{ $displayname }}">
                @break

                @case(4)
                    <input type="text" name="{{ $inputName }}" id="{{ $inputName }}"
                        class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 month-picker" title="{{ $displayname }}">
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
