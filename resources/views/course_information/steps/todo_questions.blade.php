<div class="todo-question-wrapper">
    <template x-if="todo_type=='1' || todo_type=='2'" x-sort class="todo-question space-y-4">
        <template x-for="(field, index) in fields" :key="index">
            <div x-sort:item x-data="{ options: (fields[index].option || ['']).map((option, optionIndex) => ({ correct_answer: Number(optionIndex) === Number(fields[index].correct_answer), option })), others: [] }" class="bg-slate-50 border border-slate-200 rounded-xl overflow-hidden p-4 space-y-4 my-3">
                <div x-sort:handle class="flex justify-between items-center pb-3 border-b border-slate-200 cursor-move">
                    <div class="font-semibold text-slate-800 text-sm flex items-center gap-2">
                        <i class="fas fa-grip-vertical text-slate-400"></i>
                        <span>Question <span x-text="index + 1"></span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1 bg-white hover:bg-slate-100 text-slate-700 text-xs font-medium rounded border border-slate-200 shadow-sm transition"
                            x-on:click="fields.push({ question: '', answer_type: '1', answer_input: '2', option: [''] })">
                            <i class="fas fa-plus"></i> addition
                        </button>
                        <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1 bg-white hover:bg-slate-100 text-slate-700 text-xs font-medium rounded border border-slate-200 shadow-sm transition"
                            x-on:click="fields.splice(index + 1, 0, { ...fields[index] })">
                            <i class="fas fa-copy"></i> copy
                        </button>
                        <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-medium rounded transition"
                            x-show="fields.length > 1"
                            x-on:click="fields.splice(index, 1)">
                            <i class="fas fa-trash"></i> delete
                        </button>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                        <label class="md:col-span-2 text-sm font-medium text-slate-700 pt-2">
                            question <span class="text-red-500">*</span>
                        </label>
                        <div class="md:col-span-6">
                            <textarea x-bind:name="`todo[${index}][question]`" title="Question" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                x-model="fields[index].question" rows="3"></textarea>
                        </div>
                        <div class="md:col-span-4 space-y-3 bg-white p-3 rounded-lg border border-slate-200">
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Answer type</label>
                                <select x-model="fields[index].answer_type" x-bind:name="`todo[${index}][answer_type]`" class="w-full px-2.5 py-1.5 border border-slate-300 rounded text-xs bg-white focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    <option value="1" selected>Text</option>
                                    <option value="2">Radio</option>
                                    <option value="3">Checkbox</option>
                                    <option value="4">Dropdown</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Answer input</label>
                                <div class="flex gap-4 text-xs text-slate-700">
                                    <label class="inline-flex items-center gap-1 cursor-pointer">
                                        <input x-model="fields[index].answer_input" class="text-blue-600" type="radio" x-bind:name="`todo[${index}][answer_input]`" value="1">
                                        Required
                                    </label>
                                    <label class="inline-flex items-center gap-1 cursor-pointer">
                                        <input x-model="fields[index].answer_input" class="text-blue-600" type="radio" x-bind:name="`todo[${index}][answer_input]`" value="2">
                                        Optional
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Radio --}}
                    <template x-if="fields[index].answer_type == '2'">
                        <div class="space-y-3 pl-0 md:pl-24">
                            <template x-for="(option, optionIndex) in options" :key="optionIndex">
                                <div class="flex items-center gap-3">
                                    <input x-model="options[optionIndex].correct_answer" class="w-4 h-4 text-blue-600 rounded" type="radio" x-bind:name="`todo[${index}][correct_answer]`">
                                    <input type="text" x-model="options[optionIndex].option" x-bind:name="`todo[${index}][option][${optionIndex}]`" title="Option" class="flex-1 max-w-md px-3 py-1.5 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="(Option)">
                                    <button x-on:click="confirm('Are you sure?') ? options.splice(optionIndex, 1) : false" type="button" class="w-6 h-6 flex items-center justify-center rounded-full bg-slate-200 hover:bg-red-100 hover:text-red-600 text-xs font-bold transition">×</button>
                                </div>
                            </template>
                            <div class="text-xs text-slate-600 flex items-center gap-2 pt-1">
                                <a href="javascript:void(0);" class="text-blue-600 hover:underline font-medium" x-on:click="options.push({correct_answer : options.length, option: ''})">+ Add choice</a>
                                <span x-show="todo_type=='1'">
                                    or <a href="javascript:void(0);" class="text-blue-600 hover:underline font-medium" x-on:click="others.push({correct_answer : others.length, other : '1'})">+ Add "Other"</a>
                                </span>
                            </div>

                            <template x-if="todo_type=='1'">
                                <div class="space-y-2">
                                    <template x-for="(other, otherIndex) in others" :key="otherIndex">
                                        <div class="flex items-center gap-3">
                                            <input x-model="others[otherIndex].correct_answer" class="w-4 h-4 text-blue-600 rounded" type="radio" x-bind:name="`todo[${index}][correct_answer]`">
                                            <span class="text-sm text-slate-600 italic">others</span>
                                            <input type="hidden" x-model="others[otherIndex].other" x-bind:name="`todo[${index}][other][${otherIndex}]`">
                                            <button x-on:click="confirm('Are you sure?') ? others.splice(otherIndex, 1) : false" type="button" class="w-6 h-6 flex items-center justify-center rounded-full bg-slate-200 hover:bg-red-100 hover:text-red-600 text-xs font-bold transition">×</button>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            <template x-if="todo_type=='2'">
                                <div class="pt-2">
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Explanation <span class="text-red-500">*</span></label>
                                    <textarea x-bind:name="`todo[${index}][explanation]`" title="explanation" required class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-1 focus:ring-blue-500" x-model="fields[index].explanation" rows="2"></textarea>
                                </div>
                            </template>
                        </div>
                    </template>

                    {{-- Checkbox --}}
                    <template x-if="fields[index].answer_type == '3'">
                        <div class="space-y-3 pl-0 md:pl-24">
                            <template x-for="(option, optionIndex) in options" :key="optionIndex">
                                <div class="flex items-center gap-3">
                                    <input x-model="options[optionIndex].correct_answer" class="w-4 h-4 text-blue-600 rounded" type="checkbox" x-bind:name="`todo[${index}][correct_answer]`">
                                    <input type="text" x-model="options[optionIndex].option" x-bind:name="`todo[${index}][option][${optionIndex}]`" title="Option" class="flex-1 max-w-md px-3 py-1.5 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="(Option)">
                                    <button x-on:click="confirm('Are you sure?') ? options.splice(optionIndex, 1) : false" type="button" class="w-6 h-6 flex items-center justify-center rounded-full bg-slate-200 hover:bg-red-100 hover:text-red-600 text-xs font-bold transition">×</button>
                                </div>
                            </template>
                            <div class="text-xs text-slate-600 flex items-center gap-2 pt-1">
                                <a href="javascript:void(0);" class="text-blue-600 hover:underline font-medium" x-on:click="options.push({correct_answer : options.length, option: ''})">+ Add choice</a>
                                <span x-show="todo_type=='1'">
                                    or <a href="javascript:void(0);" class="text-blue-600 hover:underline font-medium" x-on:click="others.push({correct_answer : others.length, other : '1'})">+ Add "Other"</a>
                                </span>
                            </div>

                            <template x-if="todo_type=='1'">
                                <div class="space-y-2">
                                    <template x-for="(other, otherIndex) in others" :key="otherIndex">
                                        <div class="flex items-center gap-3">
                                            <input x-model="others[otherIndex].correct_answer" class="w-4 h-4 text-blue-600 rounded" type="checkbox" x-bind:name="`todo[${index}][correct_answer]`">
                                            <span class="text-sm text-slate-600 italic">others</span>
                                            <input type="hidden" x-model="others[otherIndex].other" x-bind:name="`todo[${index}][other][${otherIndex}]`">
                                            <button x-on:click="confirm('Are you sure?') ? others.splice(otherIndex, 1) : false" type="button" class="w-6 h-6 flex items-center justify-center rounded-full bg-slate-200 hover:bg-red-100 hover:text-red-600 text-xs font-bold transition">×</button>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            <template x-if="todo_type=='2'">
                                <div class="pt-2">
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Explanation <span class="text-red-500">*</span></label>
                                    <textarea x-bind:name="`todo[${index}][explanation]`" title="explanation" required class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-1 focus:ring-blue-500" x-model="fields[index].explanation" rows="2"></textarea>
                                </div>
                            </template>
                        </div>
                    </template>

                    {{-- Dropdown --}}
                    <template x-if="fields[index].answer_type == '4'">
                        <div class="space-y-3 pl-0 md:pl-24">
                            <template x-for="(option, optionIndex) in options" :key="optionIndex">
                                <div class="flex items-center gap-3">
                                    <input type="text" x-model="options[optionIndex].option" x-bind:name="`todo[${index}][option][${optionIndex}]`" title="Option" class="flex-1 max-w-md px-3 py-1.5 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="(Option)">
                                    <button x-on:click="confirm('Are you sure?') ? options.splice(optionIndex, 1) : false" type="button" class="w-6 h-6 flex items-center justify-center rounded-full bg-slate-200 hover:bg-red-100 hover:text-red-600 text-xs font-bold transition">×</button>
                                </div>
                            </template>
                            <div class="text-xs text-slate-600 pt-1">
                                <a href="javascript:void(0);" class="text-blue-600 hover:underline font-medium" x-on:click="options.push({correct_answer : options.length, option: ''})">+ Add choice</a>
                            </div>

                            <template x-if="todo_type=='2'">
                                <div class="pt-2">
                                    <label class="block text-xs font-medium text-slate-600 mb-1">Explanation <span class="text-red-500">*</span></label>
                                    <textarea x-bind:name="`todo[${index}][explanation]`" title="explanation" required class="w-full max-w-md px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-1 focus:ring-blue-500" x-model="fields[index].explanation" rows="2"></textarea>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </template>
</div>
