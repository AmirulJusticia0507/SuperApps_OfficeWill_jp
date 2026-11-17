@extends('layouts.app')

@section('content')
<style>
    .survey-page { min-height: 100vh; background: #f4f6f9; }
    .survey-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .survey-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .survey-page__content, body.sidebar-collapsed .survey-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="survey-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="survey-page__content pt-20">
        <!-- Breadcrumb -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm text-gray-600">
                <li class="inline-flex items-center">
                    <a href="{{ route('employee-list') }}" class="text-blue-600 hover:text-blue-800" title="List of courses taken">撮影したコースのリスト</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                        <a href="{{ route('employee-list') }}" class="text-blue-600 hover:text-blue-800" title="Attendance">出席</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                        <span class="text-gray-500 font-medium" title="Post-course ToDo">コースポストトッド</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Main Content Area -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Course Information Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-slate-900 px-6 py-4 flex items-center justify-between">
                        <h2 class="text-base font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-poll text-blue-400"></i>
                            コース情報 &gt; 調査応答
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="bg-blue-50 border border-blue-200 text-blue-900 px-4 py-2.5 rounded-lg text-sm font-semibold mb-4 text-center">
                            コース情報
                        </div>

                        <table id="employeelistTable" class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs uppercase bg-gray-50 text-gray-700 border-b">
                                <tr>
                                    <th class="px-4 py-3">#</th>
                                    <th class="px-4 py-3" title="Course Name">コース名</th>
                                    <th class="px-4 py-3" title="Deadline for enrollment">登録の締め切り</th>
                                    <th class="px-4 py-3" title="ToDo">ToDo</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($courseScheduleResults as $index => $result)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3">{{ $result->course->coursename ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $result->deadline_enrollment }}</td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $result->todo_complete ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                                {{ $result->todo_complete ? '完了' : '未完了' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Back button -->
                <div>
                    <a href="{{ route('course-list') }}" title="Return to Class" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                        <i class="fas fa-arrow-left"></i> クラスに戻ります
                    </a>
                </div>

                <!-- Course Description & Question Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-blue-50 border-b border-blue-100 px-6 py-3">
                        <h3 class="text-sm font-semibold text-blue-900">コースの説明:</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @foreach($courses as $course)
                            <div class="w-full p-4 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $course->course_description }}
                            </div>
                        @endforeach

                        <div>
                            <button type="button" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition" data-bs-toggle="modal" data-bs-target="#createQuestionModal">
                                <i class="fas fa-plus"></i> 質問を作成します
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sticky Sidebar Menu -->
            <div class="lg:col-span-1">
                <div class="sticky top-24 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100">
                    <div class="bg-slate-900 px-4 py-3 font-semibold text-white text-sm">
                        メニュー
                    </div>
                    <a href="{{ route('course-list') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 font-medium transition">
                        <i class="fas fa-list-ul mr-2 text-gray-400"></i> コース一覧
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 font-medium transition">
                        <i class="fas fa-undo mr-2 text-gray-400"></i> 受講に戻る
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 font-medium transition">
                        <i class="fas fa-tasks mr-2 text-gray-400"></i> ToDoトップ
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm text-blue-600 bg-blue-50 font-semibold transition">
                        <i class="fas fa-poll-h mr-2 text-blue-600"></i> アンケート回答
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 font-medium transition">
                        <i class="fas fa-check-double mr-2 text-gray-400"></i> テスト採点
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 font-medium transition">
                        <i class="fas fa-file-alt mr-2 text-gray-400"></i> レポート提出
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 font-medium transition">
                        <i class="fas fa-save mr-2 text-gray-400"></i> 一時保存
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal for Creating Question -->
        <div class="modal fade" id="createQuestionModal" tabindex="-1" role="dialog" aria-labelledby="createQuestionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-xl overflow-hidden shadow-2xl border-0">
                    <div class="bg-slate-900 px-6 py-4 flex items-center justify-between">
                        <h5 class="text-base font-semibold text-white" id="createQuestionModalLabel">
                            新しい質問を作成します
                        </h5>
                        <button type="button" class="text-gray-400 hover:text-white transition text-lg" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('questionnaire.store') }}">
                        @csrf
                        <div class="p-6 space-y-4">
                            <div>
                                <label for="questionText" class="block text-sm font-semibold text-gray-700 mb-2">質問を書き留める:</label>
                                <input type="text" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" id="questionText" name="questionText" required>
                            </div>
                            <div>
                                <label for="answerType" class="block text-sm font-semibold text-gray-700 mb-2">回答タイプ:</label>
                                <select class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition" id="answerType" name="answerType" required>
                                    <option value="radio">ラジオボタン</option>
                                    <option value="checkbox">チェックボックス</option>
                                    <option value="selectbox">セレクトボックス</option>
                                    <option value="text">テキスト</option>
                                </select>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="isRequired" name="isRequired" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="isRequired" class="ml-2 block text-sm text-gray-700">が必要です (Required)</label>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                            <button type="button" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

@include('includes.footer')
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#employeelistTable').DataTable({
            responsive: true,
            scrollX: true,
            searching: true,
            lengthMenu: [10, 25, 50, 100, 500],
            pageLength: 10,
            dom: 'lBfrtip',
            buttons: ['copy', 'excel', 'pdf']
        });
    });
</script>
@endsection
