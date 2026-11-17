<div class="bg-slate-50 border border-slate-200 rounded-xl p-6 space-y-6">
    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">{{ __('Course') }}</h3>
        <dl class="grid grid-cols-1 md:grid-cols-12 gap-3 text-sm bg-white p-4 rounded-lg border border-slate-100">
            <dt class="md:col-span-4 font-medium text-slate-600">Name</dt>
            <dd class="md:col-span-8 font-semibold text-slate-800" data-course-summary="name">-</dd>
            <dt class="md:col-span-4 font-medium text-slate-600">Classification</dt>
            <dd class="md:col-span-8 text-slate-800" data-course-summary="classification">-</dd>
            <dt class="md:col-span-4 font-medium text-slate-600">Detail</dt>
            <dd class="md:col-span-8 text-slate-800" data-course-summary="detail">-</dd>
        </dl>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">{{ __('Teaching Materials') }}</h3>
        <div class="bg-white p-4 rounded-lg border border-slate-100 text-sm">
            <ul class="space-y-1 list-disc list-inside text-slate-700" data-course-summary="materials">
                <li>No material added</li>
            </ul>
        </div>
    </div>

    <div class="space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">{{ __('Post-course ToDo') }}</h3>
        <dl class="grid grid-cols-1 md:grid-cols-12 gap-3 text-sm bg-white p-4 rounded-lg border border-slate-100">
            <dt class="md:col-span-4 font-medium text-slate-600">Type</dt>
            <dd class="md:col-span-8 font-semibold text-slate-800" data-course-summary="todo-type">-</dd>
            <dt class="md:col-span-4 font-medium text-slate-600">Description</dt>
            <dd class="md:col-span-8 text-slate-800" data-course-summary="todo-description">-</dd>
            <dt class="md:col-span-4 font-medium text-slate-600">Questions</dt>
            <dd class="md:col-span-8 font-semibold text-slate-800" data-course-summary="questions">0</dd>
        </dl>
    </div>
</div>
