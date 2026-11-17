<div class="space-y-4" x-sort x-data="{ fields: @js(old('teaching_material', [['teaching_material_name' => '', 'material_type' => '']])) }">
    <template x-for="(field, index) in fields" :key="index">
        <div x-sort:item x-data="{ movie: false, book: false }" class="bg-slate-50 border border-slate-200 rounded-xl overflow-hidden p-4 space-y-4">
            <div x-sort:handle class="flex justify-between items-center pb-3 border-b border-slate-200 cursor-move">
                <div class="font-semibold text-slate-800 text-sm flex items-center gap-2">
                    <i class="fas fa-grip-vertical text-slate-400"></i>
                    <span>{{ __('Material') }} <span x-text="index + 1"></span></span>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1 bg-white hover:bg-slate-100 text-slate-700 text-xs font-medium rounded border border-slate-200 shadow-sm transition"
                        x-on:click="fields.push({ teaching_material_name: '', material_type: '' })">
                        <i class="fas fa-plus"></i> addition
                    </button>
                    <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-medium rounded transition"
                        x-show="fields.length > 1"
                        x-on:click="fields.splice(index, 1)">
                        <i class="fas fa-trash"></i> delete
                    </button>
                </div>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label class="md:col-span-3 text-sm font-medium text-slate-700">
                        {{ __('Material Name') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="md:col-span-9">
                        <input type="text" x-bind:name="`teaching_material[${index}][teaching_material_name]`"
                            title="Teaching Material Name" required class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                            x-model="fields[index].teaching_material_name">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <label class="md:col-span-3 text-sm font-medium text-slate-700">
                        {{ __('Material Type') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="md:col-span-9 flex gap-6 text-sm text-slate-700">
                        <label class="inline-flex items-center gap-1.5 cursor-pointer">
                            <input x-on:click="movie = true;book=false" x-model="fields[index].material_type" class="text-blue-600"
                                type="radio" x-bind:name="`teaching_material[${index}][material_type]`" value="1" title="Video" required>
                            {{ __('Video') }}
                        </label>
                        <label class="inline-flex items-center gap-1.5 cursor-pointer">
                            <input x-on:click="movie = false;book=true" x-model="fields[index].material_type" class="text-blue-600"
                                type="radio" x-bind:name="`teaching_material[${index}][material_type]`" value="2" title="Books" required>
                            {{ __('Book') }}
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center" x-show="movie">
                    <label class="md:col-span-3 text-sm font-medium text-slate-700">
                        {{ __('Video URL') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="md:col-span-9">
                        <input type="url" x-model="fields[index].youtube_video_url" x-bind:name="`teaching_material[${index}][youtube_video_url]`"
                            title="Video URL" class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://youtube.com/...">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center" x-show="book">
                    <label class="md:col-span-3 text-sm font-medium text-slate-700">
                        {{ __('Book File') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="md:col-span-9">
                        <input type="file" accept=".pdf,.doc,.docx,.ppt,.pptx" x-bind:name="`teaching_material[${index}][bookfile]`"
                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" title="Book File">
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
