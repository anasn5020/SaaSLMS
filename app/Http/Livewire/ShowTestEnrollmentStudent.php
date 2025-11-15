<?php

namespace App\Http\Livewire;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Modules\Org\Entities\OrgBranch;
use Modules\Org\Entities\OrgPosition;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ShowTestEnrollmentStudent extends DataTableComponent
{
    use WithPagination;

    public array $bulkActions = [
        'exportSelected' => 'Export',
    ];
    public bool $columnSelectStatus = true;
    public bool $rememberColumnSelection = true;
    public bool $columnSelect = true;
    public string $tableName = 'users';

    protected $listeners = ['addBranchFilter', 'addPositionFilter', 'addShiftFilter', 'reloadTable'];
    public $page = 1;
    protected $students = [];
    public $branchCodes = [];
    public $position = null;
    public $pos = null;
    public $shift_no = null;
    public $test_id = null;

    public bool $searchStatus = false;
    public bool $searchIsEnabled = false;
    public $theme = 'bootstrap-4';
    public $users = [];
    public array $selectedColumns = [
        'name',
        'org-chart',
        'position',
        'employee-id',
    ];
    public array $perPageAccepted = [20, 40, -1];
    public bool $hasSerial = true;


    public function selectPosition()
    {
        $this->emit('addPositionFilter', $this->pos);
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

    public function addPositionFilter($position)
    {
        $this->position = $position;

    }

    public function addShiftFilter($test_id, $shift_no)
    {
        $this->shift_no = $shift_no;
        $this->test_id = $test_id;

    }


    public function columns(): array
    {
        return [
            Column::make(__('common.Name'), 'name')
                ->sortable()
                ->searchable(),
            Column::make(__('org.Org Chart'), 'org_chart_code')
                ->sortable()
                ->format(fn($value, $row, Column $column) => $row->branch->fullTextPath)
                ->searchable(),

            Column::make(__('org.Position'), 'org_position_code')
                ->sortable()
                ->format(fn($value, $row, Column $column) => $row->position->name)
                ->searchable(),

            Column::make(__('org.Employee ID'), 'employee_id')
                ->sortable()
                ->searchable(),
        ];
    }

    public function builder(): Builder
    {

        $query = User::where('teach_via', 1)->where('status', 1)->with('position', 'branch', 'studentCourses');


        if (isModuleActive('UserType')) {
            $query->whereHas('userRoles', function ($q) {
                $q->whereIn('role_id', [3]);
            });
        } else {
            $query->whereIn('role_id', [3]);
        }


        if (count($this->branchCodes) != 0) {
            foreach ($this->branchCodes as $key => $code) {
                $branch = OrgBranch::where('code', $code)->first();
                if ($branch) {
                    $ids = $branch->getAllChildIds($branch, [$code]);
                }
                if ($key == 0) {
                    $query->whereIn('org_chart_code', $ids);
                } else {
                    $query->orWhereIn('org_chart_code', $ids);

                }
            }
        }

        if (Auth::user()->role_id != 1) {
            $code = [];
            if (Auth::user()->policy) {
                $branches = Auth::user()->policy->branches;
                foreach ($branches as $branch) {
                    $code[] = $branch->branch->code;
                }
            }
            $query->whereIn('org_chart_code', $code);
        }

        if (!empty($this->position)) {
            $query->where('org_position_code', $this->position);
        }

        if (!empty($this->test_id) && !empty($this->shift_no)) {
            $query->whereDoesntHave('studentCourses', function ($q) {
                $q->where('course_id', $this->test_id);
                $q->where('shift', '>', 0);

            });
        }
        $query->select('id');
        return $query;
    }


    public function render()
    {

        $positions = OrgPosition::orderBy('order', 'asc')->get();
        return view('livewire.org-test-enrollment-student.datatable')
            ->with([
                'columns' => $this->getColumns(),
                'rows' => $this->getRows(),
                'showSearch' => true,
                'positions' => $positions,

            ]);
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

    public function reloadTable()
    {
        $this->clearSelected();
    }
}
