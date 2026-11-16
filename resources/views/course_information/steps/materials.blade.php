<div id="textbookinformation" class="card-header" style="background-color: #92CDFC"><b
                            style="color:aliceblue">{{ __('Teaching Materials') }}</b></div>
                    <div class="card-body" x-sort x-data="{ fields: @js(old('teaching_material', [['teaching_material_name' => '', 'material_type' => '']])) }">
                        <template x-for="(field, index) in fields" :key="index">
                            <div x-sort:item x-data="{ movie: false, book: false }">
                                <div x-sort:handle class="card-header" style="background-color: #F7F7F7">
                                    <div class="row">
                                        <div class="col row justify-content-center">
                                            <b style="color:black">{{ __('Material') }}</b>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-right">
                                                <button type="button" class="btn btn-light btn-sm"
                                                    x-on:click="fields.push({ teaching_material_name: '', material_type: '' })">addition</button>
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    x-show="fields.length > 1"
                                                    x-on:click="fields.splice(index, 1)">delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label for="Teaching Material Name"
                                        class="col-sm-2 col-form-label required">{{ __('Material Name') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            x-bind:name="`teaching_material[${index}][teaching_material_name]`"
                                            title="Teaching Material Name" required class="form-control"
                                            x-model="fields[index].teaching_material_name">
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="material_type" class="col-sm-2 col-form-label required">{{ __('Material Type') }}</label>
                                    <div class="col-sm-10">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input x-on:click="movie = true;book=false"
                                                    x-model="fields[index].material_type" class="form-check-input"
                                                    type="radio"
                                                    x-bind:name="`teaching_material[${index}][material_type]`"
                                                    value="1" title="Video" required>
                                                {{ __('Video') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input x-on:click="movie = false;book=true"
                                                    x-model="fields[index].material_type" class="form-check-input"
                                                    type="radio"
                                                    x-bind:name="`teaching_material[${index}][material_type]`"
                                                    value="2" title="Books" required>
                                                {{ __('Book') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" x-show="movie">
                                    <label for="youtube_video_url" class="col-sm-2 col-form-label required">{{ __('Video URL') }}</label>
                                    <div class="col-sm-10">
                                        <input type="url" x-model="fields[index].youtube_video_url"
                                            x-bind:name="`teaching_material[${index}][youtube_video_url]`"
                                            title="Video URL" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row" x-show="book">
                                    <label for="book_file_path" class="col-sm-2 col-form-label required">{{ __('Book File') }}</label>
                                    <div class="col-sm-10">
                                        <input type="file" accept=".pdf,.doc,.docx,.ppt,.pptx"
                                            x-bind:name="`teaching_material[${index}][bookfile]`" class="form-control"
                                            title="Book File">
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>
