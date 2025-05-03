<?php

namespace App\Livewire\Dashboard;

use App\Models\Expense;
use App\Models\POSOrderItems;
use App\Models\POSOrders;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use stdClass;


class Dashboard extends Component
{
    public $startDate;
    public $endDate;
    public $chartData;
    public $weeklyChartData;
    public $donutChartData;
    public $isLoading = false;
    public $bestSellingProducts = [];
    public $net;
    public $monthlyNetChartData;
    public $yearlyNetChartData;

    //filter
    public $filter = [
        'Daily',
        'Weekly',
        'Monthly',
        'Yearly'
    ];

    public $selectedFilter = 'Daily';

    //cards
    public $gross;
    public $expense;
    public $psoOrders;
    public $averageSale;

    public function render()
    {
        return view('livewire.dashboard.dashboard');
    }

    public function mount()
    {
        $this->isLoading = true;

        $this->getGross($this->selectedFilter);
        $this->getNet($this->selectedFilter);
        $this->getExpense($this->selectedFilter);
        $this->getOrders($this->selectedFilter);
        $this->fetchChartData();
        $this->fetchWeeklyChartData();
        $this->fetchMonthlyNetChartData(); 
        $this->fetchYearlyNetChartData(); 
        $this->getAverageSale($this->selectedFilter);
        $this->getBestSellingProducts($this->selectedFilter);
        $this->isLoading = false;
    }

    public function setFilter($filterOption)
    {
        $this->selectedFilter = $filterOption;
        $this->isLoading = true;
        $this->getGross($this->selectedFilter);
        $this->getExpense($this->selectedFilter);
        $this->getNet($this->selectedFilter);
        $this->getAverageSale($this->selectedFilter);
        $this->getOrders($this->selectedFilter);
        $this->getBestSellingProducts($this->selectedFilter);
        $this->isLoading = false;
    }

    public function fetchWeeklyChartData()
    {
        $year = date('Y');

        $posOrders = POSOrders::selectRaw('WEEK(created_at, 1) as week, SUM(total_amount) as total')
            ->whereYear('created_at', $year)
            ->groupBy('week')
            ->orderBy('week')
            ->pluck('total', 'week');

        $expenses = Expense::selectRaw('WEEK(created_at, 1) as week, SUM(amount) as total')
            ->whereYear('created_at', $year)
            ->where('status', 'approved')
            ->groupBy('week')
            ->orderBy('week')
            ->pluck('total', 'week');

        $weeksInYear = Carbon::createFromDate($year, 12, 28)->weekOfYear;

        $weekLabels = [];
        for ($i = 1; $i <= $weeksInYear; $i++) {
            $weekLabels[$i] = "Week " . $i;
        }

        $posOrdersData = array_replace(array_fill(1, $weeksInYear, 0), $posOrders->toArray());
        $expensesData = array_replace(array_fill(1, $weeksInYear, 0), $expenses->toArray());

        $this->weeklyChartData = [
            'labels' => array_values($weekLabels),
            'pos_orders' => array_values($posOrdersData),
            'expenses' => array_values($expensesData)
        ];
    }

    public function fetchChartData()
    {
        $posOrders = POSOrders::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $expenses = Expense::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $this->chartData = [
            'labels' => $months,
            'pos_orders' => array_replace(array_fill(1, 12, 0), $posOrders->toArray()),
            'expenses' => array_replace(array_fill(1, 12, 0), $expenses->toArray())
        ];
    }

    private function dateRanges($selectedFilter)
    {
        $range = new stdClass();
        $range->today = now()->toDateString();

        if ($selectedFilter == 'Daily') {
            $range->selectedDate = now()->toDateString();
            $range->pastDate = now()->subDay()->toDateString();
        } elseif ($selectedFilter == 'Weekly') {
            $range->selectedDate = now()->startOfWeek()->toDateString();
            $range->pastDate = now()->subWeek()->startOfWeek()->toDateString();
        } elseif ($selectedFilter == 'Monthly') {
            $range->selectedDate = now()->startOfMonth()->toDateString();
            $range->pastDate = now()->subMonth()->startOfMonth()->toDateString();
        } elseif ($selectedFilter == 'Yearly') {
            $range->selectedDate = now()->startOfYear()->toDateString();
            $range->pastDate = now()->subYear()->startOfYear()->toDateString();
        }

        return $range;
    }

    private function calculatePercent($currentTotal, $previousTotal)
    {
        return $previousTotal > 0
            ? (($currentTotal - $previousTotal) / $previousTotal) * 100
            : ($currentTotal > 0 ? 100 : 0);
    }

    private function getGross($selectedFilter)
    {
        $range = $this->dateRanges($selectedFilter);
        $currentTotal = 0;
        $previousTotal = 0;

        switch ($selectedFilter) {
            case 'Daily':
                $currentTotal = POSOrders::whereDate('created_at', $range->selectedDate)
                    ->sum('total_amount');

                $previousTotal = POSOrders::whereDate('created_at', $range->pastDate)
                    ->sum('total_amount');
                break;

            case 'Weekly':
                $currentStart = Carbon::parse($range->selectedDate)->startOfWeek();
                $currentEnd = Carbon::parse($range->selectedDate)->endOfWeek();

                $previousStart = Carbon::parse($range->pastDate)->startOfWeek();
                $previousEnd = Carbon::parse($range->pastDate)->endOfWeek();

                $currentTotal = POSOrders::whereBetween('created_at', [
                    $currentStart->toDateTimeString(),
                    $currentEnd->toDateTimeString()
                ])->sum('total_amount');

                $previousTotal = POSOrders::whereBetween('created_at', [
                    $previousStart->toDateTimeString(),
                    $previousEnd->toDateTimeString()
                ])->sum('total_amount');
                break;

            case 'Monthly':
                $currentStart = Carbon::parse($range->selectedDate)->startOfMonth();
                $currentEnd = Carbon::parse($range->selectedDate)->endOfMonth();

                $previousStart = Carbon::parse($range->pastDate)->startOfMonth();
                $previousEnd = Carbon::parse($range->pastDate)->endOfMonth();

                $currentTotal = POSOrders::whereBetween('created_at', [
                    $currentStart->toDateTimeString(),
                    $currentEnd->toDateTimeString()
                ])->sum('total_amount');

                $previousTotal = POSOrders::whereBetween('created_at', [
                    $previousStart->toDateTimeString(),
                    $previousEnd->toDateTimeString()
                ])->sum('total_amount');
                break;

            case 'Yearly':
                $currentStart = Carbon::parse($range->selectedDate)->startOfYear();
                $currentEnd = Carbon::parse($range->selectedDate)->endOfYear();

                $previousStart = Carbon::parse($range->pastDate)->startOfYear();
                $previousEnd = Carbon::parse($range->pastDate)->endOfYear();

                $currentTotal = POSOrders::whereBetween('created_at', [
                    $currentStart->toDateTimeString(),
                    $currentEnd->toDateTimeString()
                ])->sum('total_amount');

                $previousTotal = POSOrders::whereBetween('created_at', [
                    $previousStart->toDateTimeString(),
                    $previousEnd->toDateTimeString()
                ])->sum('total_amount');
                break;

            default:
                $this->gross = (object)[
                    'total' => 0,
                    'percentage' => 0,
                ];
                return;
        }

        $percentageChange = $this->calculatePercent($currentTotal, $previousTotal);

        $this->gross = (object)[
            'total' => $currentTotal ?? 0,
            'percentage' => round($percentageChange, 2),
        ];
    }

    private function getExpense($selectedFilter)
    {
        $range = $this->dateRanges($selectedFilter);

        switch ($selectedFilter) {
            case 'Daily':
                $currentTotal = Expense::whereDate('created_at', $range->selectedDate)->sum('amount');
                $previousTotal = Expense::whereDate('created_at', $range->pastDate)->sum('amount');
                break;

            case 'Weekly':
                $startOfWeek = Carbon::parse($range->selectedDate)->startOfWeek()->toDateTimeString();
                $endOfWeek = now()->endOfDay()->toDateTimeString();

                $currentTotal = Expense::whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('amount');

                $prevStartOfWeek = Carbon::parse($range->pastDate)->startOfWeek()->toDateTimeString();
                $prevEndOfWeek = Carbon::parse($range->pastDate)->endOfWeek()->toDateTimeString();

                $previousTotal = Expense::whereBetween('created_at', [$prevStartOfWeek, $prevEndOfWeek])->sum('amount');
                break;

            case 'Monthly':
                $startOfMonth = Carbon::parse($range->selectedDate)->startOfMonth()->toDateTimeString();
                $endOfMonth = now()->endOfDay()->toDateTimeString();

                $currentTotal = Expense::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount');

                $prevStartOfMonth = Carbon::parse($range->pastDate)->startOfMonth()->toDateTimeString();
                $prevEndOfMonth = Carbon::parse($range->pastDate)->endOfMonth()->toDateTimeString();

                $previousTotal = Expense::whereBetween('created_at', [$prevStartOfMonth, $prevEndOfMonth])->sum('amount');
                break;

            case 'Yearly':
                $startOfYear = Carbon::parse($range->selectedDate)->startOfYear()->toDateTimeString();
                $endOfYear = now()->endOfDay()->toDateTimeString();

                $currentTotal = Expense::whereBetween('created_at', [$startOfYear, $endOfYear])->sum('amount');

                $prevStartOfYear = Carbon::parse($range->pastDate)->startOfYear()->toDateTimeString();
                $prevEndOfYear = Carbon::parse($range->pastDate)->endOfYear()->toDateTimeString();

                $previousTotal = Expense::whereBetween('created_at', [$prevStartOfYear, $prevEndOfYear])->sum('amount');
                break;

            default:
                return;
        }

        $percentageChange = $this->calculatePercent($currentTotal, $previousTotal);

        $this->expense = (object)[
            'total' => $currentTotal,
            'percentage' => round($percentageChange, 2),
        ];
    }

    private function getOrders($selectedFilter)
    {
        $range = $this->dateRanges($selectedFilter);

        switch ($selectedFilter) {
            case 'Daily':
                $currentTotal = POSOrderItems::whereDate('created_at', $range->selectedDate)->sum('qty');
                $previousTotal = POSOrderItems::whereDate('created_at', $range->pastDate)->sum('qty');
                break;

            case 'Weekly':
                $startOfWeek = Carbon::parse($range->selectedDate)->startOfWeek()->toDateTimeString();
                $endOfWeek = now()->endOfDay()->toDateTimeString(); // Ensures today's data is included

                $currentTotal = POSOrderItems::whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('qty');

                $prevStartOfWeek = Carbon::parse($range->pastDate)->startOfWeek()->toDateTimeString();
                $prevEndOfWeek = Carbon::parse($range->pastDate)->endOfWeek()->toDateTimeString();

                $previousTotal = POSOrderItems::whereBetween('created_at', [$prevStartOfWeek, $prevEndOfWeek])->sum('qty');
                break;

            case 'Monthly':
                $startOfMonth = Carbon::parse($range->selectedDate)->startOfMonth()->toDateTimeString();
                $endOfMonth = now()->endOfDay()->toDateTimeString(); // Ensures today's data is included

                $currentTotal = POSOrderItems::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('qty');

                $prevStartOfMonth = Carbon::parse($range->pastDate)->startOfMonth()->toDateTimeString();
                $prevEndOfMonth = Carbon::parse($range->pastDate)->endOfMonth()->toDateTimeString();

                $previousTotal = POSOrderItems::whereBetween('created_at', [$prevStartOfMonth, $prevEndOfMonth])->sum('qty');
                break;

            case 'Yearly':
                $startOfYear = Carbon::parse($range->selectedDate)->startOfYear()->toDateTimeString();
                $endOfYear = now()->endOfDay()->toDateTimeString(); // Ensures today's data is included

                $currentTotal = POSOrderItems::whereBetween('created_at', [$startOfYear, $endOfYear])->sum('qty');

                $prevStartOfYear = Carbon::parse($range->pastDate)->startOfYear()->toDateTimeString();
                $prevEndOfYear = Carbon::parse($range->pastDate)->endOfYear()->toDateTimeString();

                $previousTotal = POSOrderItems::whereBetween('created_at', [$prevStartOfYear, $prevEndOfYear])->sum('qty');
                break;

            default:
                return;
        }

        $percentageChange = $this->calculatePercent($currentTotal, $previousTotal);

        $this->psoOrders = (object)[
            'total' => $currentTotal,
            'percentage' => round($percentageChange, 2),
        ];
    }

    private function getAverageSale($selectedFilter)
    {
        $range = $this->dateRanges($selectedFilter);

        switch ($selectedFilter) {
            case 'Daily':
                $currentTotal = POSOrders::whereDate('created_at', $range->selectedDate)->sum('total_amount');
                $currentCount = POSOrders::whereDate('created_at', $range->selectedDate)->count();
                $currentAverage = $currentCount > 0 ? ($currentTotal / $currentCount) : 0;

                $previousTotal = POSOrders::whereDate('created_at', $range->pastDate)->sum('total_amount');
                $previousCount = POSOrders::whereDate('created_at', $range->pastDate)->count();
                $previousAverage = $previousCount > 0 ? ($previousTotal / $previousCount) : 0;
                break;

            case 'Weekly':
                $startOfWeek = Carbon::parse($range->selectedDate)->startOfWeek()->toDateTimeString();
                $endOfWeek = now()->endOfDay()->toDateTimeString();
                $currentTotal = POSOrders::whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('total_amount');
                $currentCount = POSOrders::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
                $currentAverage = $currentCount > 0 ? ($currentTotal / $currentCount) : 0;

                $prevStartOfWeek = Carbon::parse($range->pastDate)->startOfWeek()->toDateTimeString();
                $prevEndOfWeek = Carbon::parse($range->pastDate)->endOfWeek()->toDateTimeString();
                $previousTotal = POSOrders::whereBetween('created_at', [$prevStartOfWeek, $prevEndOfWeek])->sum('total_amount');
                $previousCount = POSOrders::whereBetween('created_at', [$prevStartOfWeek, $prevEndOfWeek])->count();
                $previousAverage = $previousCount > 0 ? ($previousTotal / $previousCount) : 0;
                break;

            case 'Monthly':
                $startOfMonth = Carbon::parse($range->selectedDate)->startOfMonth()->toDateTimeString();
                $endOfMonth = now()->endOfDay()->toDateTimeString();
                $currentTotal = POSOrders::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('total_amount');
                $currentCount = POSOrders::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
                $currentAverage = $currentCount > 0 ? ($currentTotal / $currentCount) : 0;

                $prevStartOfMonth = Carbon::parse($range->pastDate)->startOfMonth()->toDateTimeString();
                $prevEndOfMonth = Carbon::parse($range->pastDate)->endOfMonth()->toDateTimeString();
                $previousTotal = POSOrders::whereBetween('created_at', [$prevStartOfMonth, $prevEndOfMonth])->sum('total_amount');
                $previousCount = POSOrders::whereBetween('created_at', [$prevStartOfMonth, $prevEndOfMonth])->count();
                $previousAverage = $previousCount > 0 ? ($previousTotal / $previousCount) : 0;
                break;

            case 'Yearly':
                $startOfYear = Carbon::parse($range->selectedDate)->startOfYear()->toDateTimeString();
                $endOfYear = now()->endOfDay()->toDateTimeString();
                $currentTotal = POSOrders::whereBetween('created_at', [$startOfYear, $endOfYear])->sum('total_amount');
                $currentCount = POSOrders::whereBetween('created_at', [$startOfYear, $endOfYear])->count();
                $currentAverage = $currentCount > 0 ? ($currentTotal / $currentCount) : 0;

                $prevStartOfYear = Carbon::parse($range->pastDate)->startOfYear()->toDateTimeString();
                $prevEndOfYear = Carbon::parse($range->pastDate)->endOfYear()->toDateTimeString();
                $previousTotal = POSOrders::whereBetween('created_at', [$prevStartOfYear, $prevEndOfYear])->sum('total_amount');
                $previousCount = POSOrders::whereBetween('created_at', [$prevStartOfYear, $prevEndOfYear])->count();
                $previousAverage = $previousCount > 0 ? ($previousTotal / $previousCount) : 0;
                break;

            default:
                $currentAverage = 0;
                $previousAverage = 0;
        }

        $percentageChange = $this->calculatePercent($currentAverage, $previousAverage);

        $this->averageSale = (object)[
            'total' => round($currentAverage, 2),
            'percentage' => round($percentageChange, 2),
            'order_count' => $currentCount ?? 0
        ];
    }

    private function getBestSellingProducts($selectedFilter)
    {
        $range = $this->dateRanges($selectedFilter);

        $query = POSOrderItems::select(
            'product_name',
            DB::raw('SUM(qty) as total_quantity'),
            DB::raw('SUM(total_amount) as total_revenue')
        )
            ->groupBy('product_name')
            ->orderByDesc('total_quantity')
            ->limit(5);

        switch ($selectedFilter) {
            case 'Daily':
                $query->whereDate('created_at', $range->selectedDate);
                break;
            case 'Weekly':
                $startOfWeek = Carbon::parse($range->selectedDate)->startOfWeek()->toDateTimeString();
                $endOfWeek = now()->endOfDay()->toDateTimeString();
                $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                break;
            case 'Monthly':
                $startOfMonth = Carbon::parse($range->selectedDate)->startOfMonth()->toDateTimeString();
                $endOfMonth = now()->endOfDay()->toDateTimeString();
                $query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                break;
            case 'Yearly':
                $startOfYear = Carbon::parse($range->selectedDate)->startOfYear()->toDateTimeString();
                $endOfYear = now()->endOfDay()->toDateTimeString();
                $query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                break;
        }

        $this->bestSellingProducts = $query->get()->map(function ($item) {
            return [
                'product_name' => $item->product_name,
                'total_quantity' => $item->total_quantity,
                'total_revenue' => $item->total_revenue,
                'average_price' => $item->total_quantity > 0
                    ? round($item->total_revenue / $item->total_quantity, 2)
                    : 0
            ];
        });
    }

    private function getNet($selectedFilter)
    {
        $range = $this->dateRanges($selectedFilter);

        // Get current period values
        $currentGross = $this->getCurrentPeriodGross($selectedFilter, $range);
        $currentExpense = $this->getCurrentPeriodExpense($selectedFilter, $range);
        $currentNet = $currentGross - $currentExpense;

        // Get previous period values
        $previousGross = $this->getPreviousPeriodGross($selectedFilter, $range);
        $previousExpense = $this->getPreviousPeriodExpense($selectedFilter, $range);
        $previousNet = $previousGross - $previousExpense;

        $percentageChange = $this->calculatePercent($currentNet, $previousNet);

        $this->net = (object)[
            'total' => $currentNet,
            'percentage' => round($percentageChange, 2),
        ];
    }

    private function getCurrentPeriodGross($selectedFilter, $range)
    {
        switch ($selectedFilter) {
            case 'Daily':
                return POSOrders::whereDate('created_at', $range->selectedDate)->sum('total_amount');
            case 'Weekly':
                $start = Carbon::parse($range->selectedDate)->startOfWeek();
                $end = Carbon::parse($range->selectedDate)->endOfWeek();
                return POSOrders::whereBetween('created_at', [$start, $end])->sum('total_amount');
            case 'Monthly':
                $start = Carbon::parse($range->selectedDate)->startOfMonth();
                $end = Carbon::parse($range->selectedDate)->endOfMonth();
                return POSOrders::whereBetween('created_at', [$start, $end])->sum('total_amount');
            case 'Yearly':
                $start = Carbon::parse($range->selectedDate)->startOfYear();
                $end = Carbon::parse($range->selectedDate)->endOfYear();
                return POSOrders::whereBetween('created_at', [$start, $end])->sum('total_amount');
            default:
                return 0;
        }
    }

    private function getPreviousPeriodGross($selectedFilter, $range)
    {
        switch ($selectedFilter) {
            case 'Daily':
                return POSOrders::whereDate('created_at', $range->pastDate)->sum('total_amount');
            case 'Weekly':
                $start = Carbon::parse($range->pastDate)->startOfWeek();
                $end = Carbon::parse($range->pastDate)->endOfWeek();
                return POSOrders::whereBetween('created_at', [$start, $end])->sum('total_amount');
            case 'Monthly':
                $start = Carbon::parse($range->pastDate)->startOfMonth();
                $end = Carbon::parse($range->pastDate)->endOfMonth();
                return POSOrders::whereBetween('created_at', [$start, $end])->sum('total_amount');
            case 'Yearly':
                $start = Carbon::parse($range->pastDate)->startOfYear();
                $end = Carbon::parse($range->pastDate)->endOfYear();
                return POSOrders::whereBetween('created_at', [$start, $end])->sum('total_amount');
            default:
                return 0;
        }
    }

    private function getCurrentPeriodExpense($selectedFilter, $range)
    {
        switch ($selectedFilter) {
            case 'Daily':
                return Expense::whereDate('created_at', $range->selectedDate)->sum('amount');
            case 'Weekly':
                $start = Carbon::parse($range->selectedDate)->startOfWeek();
                $end = Carbon::parse($range->selectedDate)->endOfWeek();
                return Expense::whereBetween('created_at', [$start, $end])->sum('amount');
            case 'Monthly':
                $start = Carbon::parse($range->selectedDate)->startOfMonth();
                $end = Carbon::parse($range->selectedDate)->endOfMonth();
                return Expense::whereBetween('created_at', [$start, $end])->sum('amount');
            case 'Yearly':
                $start = Carbon::parse($range->selectedDate)->startOfYear();
                $end = Carbon::parse($range->selectedDate)->endOfYear();
                return Expense::whereBetween('created_at', [$start, $end])->sum('amount');
            default:
                return 0;
        }
    }

    private function getPreviousPeriodExpense($selectedFilter, $range)
    {
        switch ($selectedFilter) {
            case 'Daily':
                return Expense::whereDate('created_at', $range->pastDate)->sum('amount');
            case 'Weekly':
                $start = Carbon::parse($range->pastDate)->startOfWeek();
                $end = Carbon::parse($range->pastDate)->endOfWeek();
                return Expense::whereBetween('created_at', [$start, $end])->sum('amount');
            case 'Monthly':
                $start = Carbon::parse($range->pastDate)->startOfMonth();
                $end = Carbon::parse($range->pastDate)->endOfMonth();
                return Expense::whereBetween('created_at', [$start, $end])->sum('amount');
            case 'Yearly':
                $start = Carbon::parse($range->pastDate)->startOfYear();
                $end = Carbon::parse($range->pastDate)->endOfYear();
                return Expense::whereBetween('created_at', [$start, $end])->sum('amount');
            default:
                return 0;
        }
    }

    public function fetchMonthlyNetChartData()
    {
        $currentYear = date('Y');

        $monthlyGross = POSOrders::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyExpenses = Expense::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $months = range(1, 12);
        $monthlyNet = [];

        foreach ($months as $month) {
            $gross = $monthlyGross[$month] ?? 0;
            $expense = $monthlyExpenses[$month] ?? 0;
            $monthlyNet[$month] = $gross - $expense;
        }

        $this->monthlyNetChartData = [
            'labels' => [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ],
            'data' => array_values(array_replace(array_fill(1, 12, 0), $monthlyNet))
        ];
    }

    public function fetchYearlyNetChartData()
    {
        $currentYear = date('Y');
        $years = range($currentYear - 4, $currentYear); 

        $yearlyGross = POSOrders::selectRaw('YEAR(created_at) as year, SUM(total_amount) as total')
            ->whereIn(DB::raw('YEAR(created_at)'), $years)
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('total', 'year')
            ->toArray();

        $yearlyExpenses = Expense::selectRaw('YEAR(created_at) as year, SUM(amount) as total')
            ->whereIn(DB::raw('YEAR(created_at)'), $years)
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('total', 'year')
            ->toArray();

        $yearlyNet = [];
        $labels = [];

        foreach ($years as $year) {
            $gross = $yearlyGross[$year] ?? 0;
            $expense = $yearlyExpenses[$year] ?? 0;
            $yearlyNet[] = $gross - $expense;
            $labels[] = $year;
        }

        $this->yearlyNetChartData = [
            'labels' => $labels,
            'data' => $yearlyNet
        ];
    }
}
