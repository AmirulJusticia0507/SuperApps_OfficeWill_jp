<div class="todo-question-wrapper">
                            <template x-if="todo_type=='1' || todo_type=='2'" x-sort class="todo-question ">
                                <template x-for="(field, index) in fields" :key="index">
                                    <div x-sort:item x-data="{ options: (fields[index].option || ['']).map((option, optionIndex) => ({ correct_answer: Number(optionIndex) === Number(fields[index].correct_answer), option })), others: [] }">
                                        <div x-sort:handle class="card-header" style="background-color: #F7F7F7">
                                            <div class="row">
                                                <div class="col row justify-content-center">
                                                    <b style="color:black">Question</b>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="text-right">
                                                        <button type="button" class="btn btn-light btn-sm" href="#"
                                                            x-on:click="fields.push({ question: '', answer_type: '1', answer_input: '2', option: [''] })">addition</button>
                                                        <button type="button" class="btn btn-light btn-sm" href="#"
                                                            x-on:click="fields.splice(index + 1, 0, { ...fields[index] })">copy</button>
                                                        <button type="button" class="btn btn-secondary btn-sm" href="#"
                                                            x-show="fields.length > 1"
                                                            x-on:click="fields.splice(index, 1)">delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group row">
                                            <label for="Question"
                                                class="col-sm-2 col-form-label required">question</label>
                                            <div class="col-sm-6">
                                                <textarea x-bind:name="`todo[${index}][question]`" title="Question" required class="form-control"
                                                    x-model="fields[index].question"rows="3"></textarea>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label for="Answer type" class="col-sm-5 col-form-label ">Answer
                                                        type</label>
                                                    <div class="col-sm-7">
                                                        <select x-model="fields[index].answer_type"
                                                            x-bind:name="`todo[${index}][answer_type]`"
                                                            class="custom-select custom-select-sm">
                                                            <option value="1" selected>Text</option>
                                                            <option value="2">Radio</option>
                                                            <option value="3">Checkbox</option>
                                                            <option value="4">Dropdown</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="Answer type" class="col-sm-5 col-form-label ">Answer
                                                        input</label>
                                                    <div class="col-sm-7">
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input x-model="fields[index].answer_input"
                                                                    class="form-check-input" type="radio"
                                                                    x-bind:name="`todo[${index}][answer_input]`"
                                                                    class="custom-control-input" value="1">
                                                                Required</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input x-model="fields[index].answer_input"
                                                                    class="form-check-input" type="radio"
                                                                    x-bind:name="`todo[${index}][answer_input]`"
                                                                    class="custom-control-input" value="2">
                                                                Optional</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        {{-- Radio --}}
                                        <template x-if="fields[index].answer_type == '2'">
                                            <div><template x-for="(option, optionIndex) in options"
                                                    :key="optionIndex">
                                                    <div class="form-group row">
                                                        <div class="col-sm-2">
                                                            <div
                                                                class="d-flex justify-content-end align-items-center h-100">
                                                                <input x-model="options[optionIndex].correct_answer"
                                                                    class="form-check-input" type="radio"
                                                                    x-bind:name="`todo[${index}][correct_answer]`"
                                                                    class="custom-control-input">

                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" x-model="options[optionIndex].option"
                                                                x-bind:name="`todo[${index}][option][${optionIndex}]`"
                                                                title="Option" class="form-control"
                                                                placeholder="(Option)">

                                                        </div>
                                                        <div class="col-sm-1 pl-0">
                                                            <button
                                                                x-on:click="confirm('Are you sure?') ? options.splice(optionIndex, 1) : false"
                                                                type="button">X</button>
                                                        </div>
                                                    </div>
                                                </template>
                                                <div class="form-group row">
                                                    <div class="col-sm-2">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <a href="javascript:void(0);"
                                                            x-on:click="options.push({correct_answer : options.length, option: ''})">Add
                                                            choice</a>
                                                        <span x-show="todo_type=='1'">
                                                            or
                                                            <a href="javascript:void(0);"
                                                                x-on:click="others.push({correct_answer : others.length, other : '1'})">Add
                                                                "Other"</a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <template x-if="todo_type=='1'">
                                                    <template x-for="(other, otherIndex) in others"
                                                        :key="otherIndex">
                                                        <div class="form-group row">
                                                            <div class="col-sm-2">
                                                                <div
                                                                    class="d-flex justify-content-end align-items-center h-100">
                                                                    <input x-model="others[otherIndex].correct_answer"
                                                                        class="form-check-input" type="radio"
                                                                        x-bind:name="`todo[${index}][correct_answer]`"
                                                                        class="custom-control-input">

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 ">
                                                                <p>others</p>
                                                                <input type="hidden" x-model="others[otherIndex].other"
                                                                    x-bind:name="`todo[${index}][other][${otherIndex}]`">
                                                            </div>
                                                            <div class="col-sm-1 pl-0">
                                                                <button
                                                                    x-on:click="confirm('Are you sure?') ? others.splice(otherIndex, 1) : false"
                                                                    type="button">X</button>

                                                            </div>
                                                        </div>
                                                    </template>
                                                </template>
                                                <template x-if="todo_type=='2'">
                                                    <div class="form-group row">
                                                        <label for="explanation"
                                                            class="col-sm-2 col-form-label required">Explanation</label>
                                                        <div class="col-sm-6">
                                                            <textarea x-bind:name="`todo[${index}][explanation]`" title="explanation" required class="form-control"
                                                                x-model="fields[index].explanation"rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                        {{-- Checkbox --}}
                                        <template x-if="fields[index].answer_type == '3'">
                                            <div><template x-for="(option, optionIndex) in options"
                                                    :key="optionIndex">
                                                    <div class="form-group row">
                                                        <div class="col-sm-2">
                                                            <div
                                                                class="d-flex justify-content-end align-items-center h-100">
                                                                <input x-model="options[optionIndex].correct_answer"
                                                                    class="form-check-input" type="checkbox"
                                                                    x-bind:name="`todo[${index}][correct_answer]`"
                                                                    class="custom-control-input">

                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 ">
                                                            <input type="text" x-model="options[optionIndex].option"
                                                                x-bind:name="`todo[${index}][option][${optionIndex}]`"
                                                                title="Option" class="form-control"
                                                                placeholder="(Option)">

                                                        </div>
                                                        <div class="col-sm-1 pl-0">
                                                            <button
                                                                x-on:click="confirm('Are you sure?') ? options.splice(optionIndex, 1) : false"
                                                                type="button">X</button>
                                                        </div>
                                                    </div>
                                                </template>
                                                <div class="form-group row">
                                                    <div class="col-sm-2">

                                                    </div>
                                                    <div class="col-sm-10">
                                                        <a href="javascript:void(0);"
                                                            x-on:click="options.push({correct_answer : options.length, option: ''})">Add
                                                            choice</a>
                                                        <span x-show="todo_type=='1'">
                                                            or
                                                            <a href="javascript:void(0);"
                                                                x-on:click="others.push({correct_answer : others.length, other : '1'})">Add
                                                                "Other"</a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <template x-if="todo_type=='1'">
                                                    <template x-for="(other, otherIndex) in others"
                                                        :key="otherIndex">
                                                        <div class="form-group row">
                                                            <div class="col-sm-2">
                                                                <div
                                                                    class="d-flex justify-content-end align-items-center h-100">
                                                                    <input x-model="others[otherIndex].correct_answer"
                                                                        class="form-check-input" type="checkbox"
                                                                        x-bind:name="`todo[${index}][correct_answer]`"
                                                                        class="custom-control-input">

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <p>others</p>
                                                                <input type="hidden" x-model="others[otherIndex].other"
                                                                    x-bind:name="`todo[${index}][other][${otherIndex}]`">
                                                            </div>
                                                            <div class="col-sm-1 pl-0">
                                                                <button
                                                                    x-on:click="confirm('Are you sure?') ? others.splice(otherIndex, 1) : false"
                                                                    type="button">X</button>

                                                            </div>
                                                        </div>
                                                    </template>
                                                </template>
                                                <template x-if="todo_type=='2'">
                                                    <div class="form-group row">
                                                        <label for="explanation"
                                                            class="col-sm-2 col-form-label required">Explanation</label>
                                                        <div class="col-sm-6">
                                                            <textarea x-bind:name="`todo[${index}][explanation]`" title="explanation" required class="form-control"
                                                                x-model="fields[index].explanation"rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                        {{-- Dropdown --}}
                                        <template x-if="fields[index].answer_type == '4'">
                                            <div><template x-for="(option, optionIndex) in options"
                                                    :key="optionIndex">
                                                    <div class="form-group row">
                                                        <div class="col-sm-2">
                                                            <div
                                                                class="d-flex justify-content-end align-items-center h-100">
                                                                {{-- <input x-model="options[optionIndex].correct_answer"
                                                                class="form-check-input" type="radio"
                                                                x-bind:name="`todo[${index}][correct_answer]`"
                                                                class="custom-control-input"> --}}

                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" x-model="options[optionIndex].option"
                                                                x-bind:name="`todo[${index}][option][${optionIndex}]`"
                                                                title="Option" class="form-control"
                                                                placeholder="(Option)">

                                                        </div>
                                                        <div class="col-sm-1 pl-0">
                                                            <button
                                                                x-on:click="confirm('Are you sure?') ? options.splice(optionIndex, 1) : false"
                                                                type="button">X</button>
                                                        </div>
                                                    </div>
                                                </template>
                                                <div class="form-group row">
                                                    <div class="col-sm-2">

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <a href="javascript:void(0);"
                                                            x-on:click="options.push({correct_answer : options.length, option: ''})">Add
                                                            choice</a>
                                                    </div>
                                                </div>
                                                <template x-if="todo_type=='2'">
                                                    <div class="form-group row">
                                                        <label for="explanation"
                                                            class="col-sm-2 col-form-label required">Explanation</label>
                                                        <div class="col-sm-6">
                                                            <textarea x-bind:name="`todo[${index}][explanation]`" title="explanation" required class="form-control"
                                                                x-model="fields[index].explanation"rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                </template>
                            </template>
                        </div>
