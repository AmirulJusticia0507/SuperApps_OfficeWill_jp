@extends('layouts.app')

@section('content')
<style>
    .test-answer-page { min-height: 100vh; background: #f4f6f9; }
    .test-answer-page__content { margin-left: 16rem; width: calc(100% - 16rem); padding: 1.5rem 2rem; transition: margin-left .2s ease, width .2s ease; }
    body.sidebar-collapsed .test-answer-page__content { margin-left: 4.5rem; width: calc(100% - 4.5rem); }
    @media (max-width: 767.98px) {
        .test-answer-page__content, body.sidebar-collapsed .test-answer-page__content { margin-left: 0; width: 100%; padding: 1rem; }
    }
</style>

<div class="test-answer-page">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="test-answer-page__content pt-20">
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
                    <div class="bg-slate-900 px-6 py-4">
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
                                    <th class="px-4 py-3">受講者名</th>
                                    <th class="px-4 py-3" title="Deadline for enrollment">登録の締め切り</th>
                                    <th class="px-4 py-3" title="ToDo">全て</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($courseScheduleResults as $index => $result)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3">{{ $result->course->coursename ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $result->employee->fullname ?? 'N/A' }}</td>
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

                @php
                    $totalQuestions = $testAnswers->count();
                    $totalCorrectAnswers = $testAnswers->where('is_correct', true)->count();
                    $passFail = $totalQuestions > 0 && ($totalCorrectAnswers / $totalQuestions) >= 0.6 ? 'Pass' : 'Fail';
                    $correctAnswerRate = $totalQuestions > 0 ? ($totalCorrectAnswers / $totalQuestions) * 100 : 0;
                @endphp

                <!-- Scoring Results Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-blue-50 border-b border-blue-100 px-6 py-3">
                        <h3 class="text-sm font-semibold text-blue-900">得点の結果 (Scoring Results)</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-center">
                                <span class="text-xs text-gray-500 block mb-1">パス/失敗</span>
                                <span class="text-lg font-bold {{ $passFail === 'Pass' ? 'text-emerald-600' : 'text-red-600' }}">{{ $passFail }}</span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-center">
                                <span class="text-xs text-gray-500 block mb-1">質問の数</span>
                                <span class="text-lg font-bold text-gray-800">{{ $totalQuestions }}</span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-center">
                                <span class="text-xs text-gray-500 block mb-1">正解の数</span>
                                <span class="text-lg font-bold text-blue-600">{{ $totalCorrectAnswers }}</span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-center">
                                <span class="text-xs text-gray-500 block mb-1">正解率</span>
                                <span class="text-lg font-bold text-purple-600">{{ number_format($correctAnswerRate, 2) }}%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Back button -->
                <div>
                    <a href="{{ route('course-list') }}" title="Return to Class" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                        <i class="fas fa-arrow-left"></i> クラスに戻ります
                    </a>
                </div>

                <!-- Test Explanation Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-blue-50 border-b border-blue-100 px-6 py-3">
                        <h3 class="text-sm font-semibold text-blue-900">テストの説明 (Test Explanation)</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        @foreach ($questions as $question)
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 space-y-2">
                                <p class="text-sm text-gray-900"><strong class="font-semibold text-gray-700">Question:</strong> {{ $question->question_text }}</p>
                                <p class="text-sm text-gray-700"><strong class="font-semibold text-gray-700">Answer Type:</strong> {{ $question->answer_type }}</p>
                                <p class="text-sm text-gray-700"><strong class="font-semibold text-gray-700">Answered:</strong> {{ $question->answered }}</p>
                                <p class="text-sm text-gray-700"><strong class="font-semibold text-gray-700">Explanation:</strong> {{ $question->explanation }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center justify-center gap-4 py-4">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
                        <i class="fas fa-check-circle"></i> Complete
                    </button>
                    <button type="reset" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition">
                        <i class="fas fa-rotate"></i> Retest
                    </button>
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
                    <a href="#" class="block px-4 py-3 text-sm text-blue-600 bg-blue-50 font-semibold transition">
                        <i class="fas fa-check-double mr-2 text-blue-600"></i> テスト採点
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 font-medium transition">
                        <i class="fas fa-redo-alt mr-2 text-gray-400"></i> 再テスト
                    </a>
                    <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 font-medium transition">
                        <i class="fas fa-check-circle mr-2 text-gray-400"></i> 完了
                    </a>
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
