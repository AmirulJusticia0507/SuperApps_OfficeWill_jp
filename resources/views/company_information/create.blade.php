<!-- Create Company Modal -->
<div class="modal fade" id="{{$modalId}}" tabindex="-1" aria-labelledby="{{$modalId}}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-xl border border-slate-200 overflow-hidden shadow-xl">
            <div class="modal-header px-5 py-4 bg-blue-900 text-white">
                <h5 class="modal-title font-semibold text-white" id="{{$modalId}}Label" title="{{ __('Create Company') }}">{{ __('Create Company') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-6">
                <!-- Form Create Company -->
                <form method="POST" action="{{ route('company-information.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Company Name') }}: <span class="text-red-500">*</span></label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" id="company_name" name="company_name" required title="Company Name">
                    </div>

                    <div>
                        <label for="company_username" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Login Screen URL') }}: <span class="text-red-500">*</span></label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2" title="Login Screen URL" id="company_username" name="company_username" maxlength="150" required placeholder="username">
                        <input type="text" class="w-full px-3 py-2 border border-slate-200 bg-slate-50 text-slate-500 rounded-lg text-sm" title="Login Screen URL" id="login_screen_url" readonly>
                    </div>

                    <div>
                        <label for="icon_storage_file_path" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Company Icon File') }}: <span class="text-red-500">*</span></label>
                        <input type="file" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" id="icon_storage_file_path" title="Icon Storage File" name="icon_storage_file_path" required onchange="previewIcon(this)">
                        <img id="icon_preview" src="#" alt="Preview Icon" class="mt-2 max-w-[100px] rounded border border-slate-200" style="display: none;">
                    </div>

                    <div>
                        <label for="teaching_material_storage_file_path" class="block text-sm font-medium text-slate-700 mb-1">{{ __('Teaching Materials Storage') }}:</label>
                        <input type="text" class="w-full px-3 py-2 border border-slate-200 bg-slate-50 text-slate-500 rounded-lg text-sm" title="Teaching Material Storage File" id="teaching_material_storage_file_path" readonly>
                    </div>

                    <div class="pt-4 flex justify-center items-center gap-3">
                        <button type="reset" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition border border-slate-200" title="{{ __('Reset') }}"><i class="fas fa-undo"></i> {{ __('Reset') }}</button>
                        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold rounded-lg shadow-sm transition" title="{{ __('Submit') }}"><i class="fas fa-paper-plane"></i> {{ __('Submit') }}</button>
                        <button type="button" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-lg transition" title="{{ __('Delete') }}" id="deleteButton"><i class="fas fa-trash"></i> {{ __('Delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
