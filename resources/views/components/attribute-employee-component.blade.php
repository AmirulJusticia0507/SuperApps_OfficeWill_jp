@for ($i = 1; $i <= 5; $i++)
    @php
        $key_index = 'employee_attribute0' . $i;
        $key_index_displayname = $key_index . '_displayname';
        $key_index_screentype = $key_index . '_screentype';

    @endphp
    @if (isset($attribute->{$key_index_displayname}) && $attribute->{$key_index_displayname})
        <div class="form-group">
            <label for="{{ $key_index }}"
                style="display: inline-block; width: 30%;">&emsp;{{ $attribute->{$key_index_displayname} ?? '' }}</label>
            @switch($attribute->{$key_index_screentype})
                @case(1)
                    <input type="text" class="form-control" title="{{ $attribute->{$key_index_displayname} ?? '' }}"
                        id="{{ $key_index }}" name="{{ $key_index }}" value="{{ request()->{$key_index} }}"
                        placeholder="Enter {{ $attribute->{$key_index_displayname} ?? '' }}"
                        style="display: inline-block; width: 60%;" @input.debounce="$el.form.requestSubmit()">
                @break

                @case(2)
                    <select name="{{ $key_index }}" id="{{ $key_index }}"
                        Title="{{ $attribute->{$key_index_displayname} ?? '' }}" style="display: inline-block; width: 60%;"
                        class="form-control">
                        <option value="-"> </option>
                        <option value=""> </option>
                        <option value=""> </option>
                    </select>
                @break

                @default
            @endswitch

        </div>
        <div class="form-group">
            <label style="display: inline-block; width: 30%;"></label>
            <div style="display: inline-block; width: 60%;">
                <label class="radio-inline">
                    <input type="radio" name="search_option" value="exact_match" Title="Exact Match">
                    完全に一致
                </label>
                <label class="radio-inline">
                    <input type="radio" name="search_option" value="range_search" Title="Range Search">
                    範囲検索
                </label>
                <label class="radio-inline">
                    <input type="radio" name="search_option" value="or_more_search" Title="Or More Search">
                    またはそれ以上の検索
                </label>
                <label class="radio-inline">
                    <input type="radio" name="search_option" value="or_less_search" Title="Or Less Search"> 以下の検索
                </label>
            </div>
        </div>
    @endif
@endfor
