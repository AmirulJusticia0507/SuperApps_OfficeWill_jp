@for ($i = 1; $i <= 5; $i++)
    @php
        $key_index = 'employee_attribute0' . $i;
        $key_index_displayname = $key_index . '_displayname';
        $key_index_screentype = $key_index . '_screentype';
    @endphp
    @if (isset($attribute->{$key_index_displayname}) && $attribute->{$key_index_displayname})
        <div class="mb-4">
            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                <label for="{{ $key_index }}" class="sm:w-1/3 text-sm font-semibold text-gray-700">
                    {{ $attribute->{$key_index_displayname} ?? '' }}
                </label>
                <div class="sm:w-2/3">
                    @switch($attribute->{$key_index_screentype})
                        @case(1)
                            <input type="text"
                                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                title="{{ $attribute->{$key_index_displayname} ?? '' }}"
                                id="{{ $key_index }}"
                                name="{{ $key_index }}"
                                value="{{ request()->{$key_index} }}"
                                placeholder="Enter {{ $attribute->{$key_index_displayname} ?? '' }}"
                                @input.debounce="$el.form.requestSubmit()">
                        @break

                        @case(2)
                            <select name="{{ $key_index }}" id="{{ $key_index }}"
                                title="{{ $attribute->{$key_index_displayname} ?? '' }}"
                                class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="-">Select...</option>
                            </select>
                        @break

                        @default
                    @endswitch
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center gap-3 mt-2">
                <div class="sm:w-1/3"></div>
                <div class="sm:w-2/3 flex flex-wrap items-center gap-4 text-xs text-gray-600">
                    <label class="inline-flex items-center gap-1.5 cursor-pointer">
                        <input type="radio" name="search_option" value="exact_match" title="Exact Match" class="text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span>完全に一致</span>
                    </label>
                    <label class="inline-flex items-center gap-1.5 cursor-pointer">
                        <input type="radio" name="search_option" value="range_search" title="Range Search" class="text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span>範囲検索</span>
                    </label>
                    <label class="inline-flex items-center gap-1.5 cursor-pointer">
                        <input type="radio" name="search_option" value="or_more_search" title="Or More Search" class="text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span>またはそれ以上の検索</span>
                    </label>
                    <label class="inline-flex items-center gap-1.5 cursor-pointer">
                        <input type="radio" name="search_option" value="or_less_search" title="Or Less Search" class="text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span>以下の検索</span>
                    </label>
                </div>
            </div>
        </div>
    @endif
@endfor
