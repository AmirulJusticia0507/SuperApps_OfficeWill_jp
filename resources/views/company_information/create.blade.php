<!-- Create Company Modal -->
<div class="modal fade" id="{{$modalId}}" tabindex="-1" aria-labelledby="{{$modalId}}Label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{$modalId}}Label" title="{{ __('Create Company') }}">{{ __('Create Company') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Create Company -->
                <form method="POST" action="{{ route('company-information.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="company_name">{{ __('Company Name') }}:</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" required title="Company Name">
                    </div>

                    <div class="form-group">
                        <label for="login_screen_url">{{ __('Login Screen URL') }}:</label>
                        <input type="text" class="form-control" title="Login Screen URL" id="company_username" name="company_username" maxlength="150" required>
                        <input type="text" class="form-control" title="Login Screen URL" id="login_screen_url" readonly>
                    </div>

                    <div class="form-group">
                        <label for="icon_storage_file_path">{{ __('Company Icon File') }}:</label>
                        <input type="file" class="form-control" id="icon_storage_file_path" title="Icon Storage File" name="icon_storage_file_path" required onchange="previewIcon(this)">
                        <!-- Tambahkan atribut 'required' untuk memastikan file dipilih -->
                        <img id="icon_preview" src="#" alt="Preview Icon" style="max-width: 100px; display: none;">
                    </div>
                    <div class="form-group">
                        <label for="login_screen_url">{{ __('Teaching Materials Storage') }}:</label>
                        <input type="text" class="form-control" title="Teaching Material Storage Fil" id="teaching_material_storage_file_path"  readonly>
                    </div>

                    {{-- <div class="form-group">
                        <label for="teaching_material_storage_file_path">{{ __('Teaching Materials Storage') }}:</label>
                        <input type="file" class="form-control" id="teaching_material_storage_file_path" title="Teaching Material Storage File" name="teaching_material_storage_file_path" onchange="previewMaterial(this)">
                        <img id="material_preview" src="#" alt="Preview Material"
                            style="max-width: 100px; display: none;">
                    </div><br><br> --}}
                    <div align="center">
                        <button type="reset" class="btn btn-light" title="{{ __('Reset') }}"><i class="fas fa-undo"></i> {{ __('Reset') }}</button>
                        <button type="submit" class="btn btn-primary" title="{{ __('Submit') }}"><i class="fas fa-sent"></i> {{ __('Submit') }}</button>
                        <button type="button" class="btn btn-dark" title="{{ __('Delete') }}" id="deleteButton"><i class="fas fa-trash"></i> {{ __('Delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
