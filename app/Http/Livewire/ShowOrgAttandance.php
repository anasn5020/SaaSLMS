<?php

namespace App\Http\Livewire;

use App\Exports\OrgAttendanceList;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Modules\CourseSetting\Entities\Category;
use Modules\Org\Entities\OrgBranch;
use Modules\Org\Entities\OrgPosition;
use Modules\OrgSubscription\Entities\OrgAttendance;
use Modules\OrgSubscription\Entities\OrgCourseSubscription;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ShowOrgAttandance extends DataTableComponent
{

    use WithPagination;

    public array $bulkActions = [
        'exportSelected' => 'Export',
    ];
    public string $tableName = 'users';
    public bool $columnSelect = true;
    public bool $rememberColumnSelection = true;


    public $pos, $showAddBtn = false, $org_chart;
    protected $listeners = ['addBranchFilter', 'addPositionFilter', 'checkOrgChart', 'refreshDatatable' => '$refresh'];
    public $page = 1;
    protected $students = [];
    public $branchCodes = [];
    public $position = null;
    public $serial = 0;
    public $class_ids = [];
    public $student_status = 1;
    public $class_type = 'offline';
    public $plan_ids = [];

    public bool $searchStatus = false;
    public bool $searchIsEnabled = false;
    public $theme = 'bootstrap-4';
    public $users = [];
    public array $selectedColumns = [
        'name',
        'org-chart',
        'position',
        'employee-id',
        'email',
        'date-of-birth',
        'gender',
        'start-working-date',
        'phone',
        'status'
    ];
    public array $perPageAccepted = [20, 40, -1];
    public bool $hasSerial = true;

    public function mount()
    {
        $this->pos = null;
        $this->showAddBtn = false;
        $this->org_chart = '';
    }

    public function selectPosition()
    {
        $this->emit('addPositionFilter', $this->pos);
        $this->resetPage();
    }

    public function addBranchFilter($branchCode)
    {
        if (($key = array_search($branchCode, $this->branchCodes)) !== false) {
            unset($this->branchCodes[$key]);
            $branch = OrgBranch::where('code', $branchCode)->first();
            $childs = $branch->getAllChildIds($branch);
            foreach ($childs as $child) {
                if (($key2 = array_search($child, $this->branchCodes)) !== false) {
                    unset($this->branchCodes[$key2]);
                }
            }
        } else {
            array_push($this->branchCodes, $branchCode);
        }
        $this->emit('checkOrgChart', $this->branchCodes);

    }

    public function checkOrgChart($codes)
    {
        if (count($codes) == 1) {
            $this->showAddBtn = true;
            $chart = OrgBranch::where('code', $codes[0] ?? '')->first();
            if ($chart) {
                $this->org_chart = $chart->fullPath;
            }
        } else {
            $this->showAddBtn = false;
        }
    }

    public function addPositionFilter($position)
    {
        $this->position = $position;
    }

    public function selectClass($type, $ids)
    {
        $this->class_type = $type;
        $this->class_ids = $ids;
        $this->resetPage();
    }

    public function selectStudentStatus($status)
    {
        $this->student_status = $status;
        $this->resetPage();
    }


    public function columns(): array
    {
        return [
            Column::make(__('common.SL'), 'id'),
            Column::make(__('common.Name'), 'user.name')
                ->searchable(),
            Column::make(__('org.Org Chart'), 'user.org_chart_code')
                ->sortable()
                ->format(fn($value, $row, Column $column) => $row->branch ? $row->branch->fullTextPath : '')
                ->searchable(),

            Column::make(__('org.Position'), 'user.org_position_code')
                ->sortable()
                ->format(fn($value, $row, Column $column) => $row->position ? $row->position->name : '')
                ->searchable(),
            Column::make(__('org.Employee ID'), 'user.employee_id')
                ->searchable(),
            Column::make(__('org.Start date'), 'created_at')
                ->sortable()
                ->format(fn($value, $row, Column $column) => showDate($row->created_at))
                ->searchable(),
            Column::make(__('org.Class Type'), 'class_type')
                ->format(fn($value, $row, Column $column) => $row->class_type == 1 ? trans('org.Virtual Class') : trans('org.Offline Class'))
            ,
            Column::make(__('courses.Course'), 'course.title'),

            Column::make(__('org.Class'), 'class.title'),
            Column::make(__('org.Attend'), 'attend')
                ->sortable()
                ->searchable(),

            Column::make(__('org.Total score'), 'total_score')
                ->sortable()
                ->searchable(),

            Column::make(__('org.Pass Rate'), 'pass_rate')
                ->sortable()
                ->searchable(),

            Column::make(__('org.Actual score'), 'actual_score')
                ->sortable()
                ->searchable(),

            Column::make(__('common.Status'), 'user.status')
                ->label(fn($row) => $row->status == 1 ? trans('common.Active') : trans('common.Inactive')),
        ];
    }

    public function builder(): Builder
    {
        $this->serial = ($this->page - 1) * 10;

        $query = OrgAttendance::query();
        if (count($this->class_ids) != 0) {
            if ($this->class_type == 'offline') {
                $query->whereIn('class_id', $this->class_ids);
            } else {
                $query->whereHas('course', function ($q) {
                    $q->whereIn('id', $this->class_ids);
                });
            }


        }

        $query->with('course', 'user');

        if (count($this->branchCodes) != 0) {
            $ids = [];
            foreach ($this->branchCodes as $key => $code) {
                $branch = OrgBranch::where('code', $code)->first();
                if ($branch) {
                    $branchIds = $branch->getAllChildIds($branch, [$code]);
                    $ids = array_merge($ids, $branchIds);
                }
            }
            $query->whereHas('user', function ($q) use ($ids) {
                $q->whereIn('org_chart_code', $ids);
            });
        }


        if (!empty($this->position)) {
            $query->whereHas('user', function ($q) {
                $q->where('org_position_code', $this->position);
            });
        }
        $query->whereHas('user', function ($q) {
            $q->where('status', $this->student_status);
        });
        return $query->select('org_attendances.id');
    }


    public function render()
    {
        $categories = Category::where('parent_id', null)->orderBy('name', 'asc')->get();
        $positions = OrgPosition::orderBy('order', 'asc')->get();
        return view('livewire.attandance.datatable')
            ->with([

                'categories' => $categories,
                'columns' => $this->getColumns(),
                'rows' => $this->getRows(),
                'positions' => $positions,
                'showSearch' => true,


            ]);
    }

    public function export()
    {
        return Excel::download(new OrgAttendanceList($this->builder()), 'attendance_list.xlsx');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setEmptyMessage(trans("common.No data available in the table"))
//            ->setDebugEnabled()
            ->setColumnSelectStatus(true)
            ->setColumnSelectEnabled()
            ->setSingleSortingDisabled()
            ->setHideBulkActionsWhenEmptyEnabled()
            ->setUseHeaderAsFooterEnabled()
            ->setPerPageVisibilityStatus(false)
            ->setSearchVisibilityStatus(true)
            ->setSearchStatus(true)
            ->setPerPage(20)
            ->setSearchDebounce(1000)
            ->bulkActionsAreEnabled();
    }
}
