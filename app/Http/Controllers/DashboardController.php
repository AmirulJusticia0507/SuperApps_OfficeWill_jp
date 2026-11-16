<?php

namespace App\Http\Controllers;

use App\Models\CourseInformation;
use App\Models\CourseScheduleResultsInformation;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $companyId = request()->attributes->get('tenant.company_id');
        $hasCourses = Schema::hasTable('course_information');
        $hasEnrollments = Schema::hasTable('course_schedule_results_information');

        $courses = $hasCourses ? CourseInformation::query() : null;
        $enrollments = $hasEnrollments ? CourseScheduleResultsInformation::query() : null;

        if ($companyId !== null) {
            $courses?->where('company_id', $companyId);
            $enrollments?->where('company_id', $companyId);
        }

        $courseCount = $courses?->count() ?? 0;
        $enrollmentCount = $enrollments ? (clone $enrollments)->count() : 0;
        $completedCount = $enrollments ? (clone $enrollments)->where('todo_progress', '2')->count() : 0;
        $inProgressCount = $enrollments ? (clone $enrollments)->where('todo_progress', '1')->count() : 0;
        $notStartedCount = $enrollments ? (clone $enrollments)->whereNull('todo_progress')->count() : 0;

        $monthlyEnrollments = $enrollments ? (clone $enrollments)
            ->selectRaw('YEAR(schedule_course) as year, MONTH(schedule_course) as month, COUNT(*) as total')
            ->whereNotNull('schedule_course')
            ->where('schedule_course', '>=', now()->subMonths(5)->startOfMonth())
            ->groupByRaw('YEAR(schedule_course), MONTH(schedule_course)')
            ->get()
            ->keyBy(fn ($row) => sprintf('%04d-%02d', $row->year, $row->month)) : collect();

        $enrollmentTrend = collect(range(5, 0))->map(function ($monthsAgo) use ($monthlyEnrollments) {
            $date = now()->startOfMonth()->subMonths($monthsAgo);
            $key = $date->format('Y-m');

            return [
                'label' => $date->translatedFormat('M Y'),
                'total' => (int) ($monthlyEnrollments->get($key)->total ?? 0),
            ];
        });

        return view('dashboard', compact(
            'courseCount',
            'enrollmentCount',
            'completedCount',
            'inProgressCount',
            'notStartedCount',
            'enrollmentTrend',
        ));
    }
}
