<?php

namespace App\Http\Livewire;

use App\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Modules\Org\Entities\OrgBranch;
use Modules\Org\Entities\OrgPosition;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;

class ShowStudents extends DataTableComponent
{
    use WithPagination;

    public array $bulkActions = [
        'exportSelected' => 'Export',
    ];
    public string $tableName = 'users';

    public bool $columnSelectStatus = true;
    public bool $rememberColumnSelection = true;

    public bool $searchStatus = false;
    public bool $searchIsEnabled = false;
    public $theme = 'bootstrap-4';
    public $users = [];
    public array $selectedColumns = [
        'sl',
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


    public $pos, $showAddBtn = false, $org_chart;
    protected $listeners = ['addBranchFilter', 'addPositionFilter', 'checkOrgChart', 'refreshDatatable' => '$refresh'];
    public $page = 1;
    protected $students = [];
    public $branchCodes = [];
    public $position = null;
    public $serial = 0;

    public function mount()
    {
        $this->pos = null;
        $this->showAddBtn = false;
        $this->org_chart = '';
    }

    public function selectPosition()
    {
        $this->emit('addPositionFilter', $this->pos);
        $this->refresh = true;
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


    public function columns(): array
    {
        return [
            Column::make(__('common.SL'), 'id'),
            Column::make(__('common.Username'), 'username')
                ->sortable()
                ->deselected()
                ->searchable(),
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
            Column::make(__('common.Email'), 'email')
                ->sortable()
                ->searchable(),
            Column::make(__('common.Date of Birth'), 'dob')
                ->sortable()
                ->searchable(),

            Column::make(__('common.gender'), 'gender')
                ->sortable()
                ->searchable(),

            Column::make(__('org.Start working date'), 'start_working_date')
                ->sortable()
                ->searchable(),

            Column::make(__('common.Phone'), 'phone')
                ->sortable()
                ->searchable(),

            Column::make(__('common.Status'), 'status')
                ->sortable()
                ->label(fn($row) => $row->status == 1 ? trans('common.Active') : trans('common.Inactive')),
        ];
    }

    /*    public function query()
        {

            $this->serial = ($this->page - 1) * 10;

            $query = User::select(
                'id',
                'username',
                'name',
                'org_chart_code',
                'org_position_code',
                'employee_id',
                'email',
                'dob',
                'gender',
                'start_working_date',
                'phone',
                'status'
            )->where('teach_via', 1)->with('position', 'branch');
            if (isModuleActive('UserType')) {
                $query->whereHas('userRoles', function ($q) {
                    $q->where('role_id', 3);
                });
            } else {
                $query->where('role_id', 3);
            }
            if (count($this->branchCodes) != 0) {
                $ids = [];
                foreach ($this->branchCodes as $key => $code) {
                    $branch = OrgBranch::where('code', $code)->first();
                    if ($branch) {
                        $branchIds = $branch->getAllChildIds($branch, [$code]);
                        $ids = array_merge($ids, $branchIds);
                    }

                }
                $query->whereIn('org_chart_code', $ids);

            }
            if (Auth::user()->role_id != 1) {
                $assign_code = [];
                if (Auth::user()->policy) {
                    $branches = Auth::user()->policy->branches;
                    foreach ($branches as $branch) {
                        $assign_code[] = $branch->branch->code;
                    }
                }
                $query->whereIn('org_chart_code', $assign_code);
            }

            if (!empty($this->position)) {
                $query->where('org_position_code', $this->position);
            }
            $query->latest();
            return $query;
        }*/


    public function render()
    {
//        $this->serial = ($this->page - 1) * 10;
        if (isModuleActive('Org')) {
            $positions = OrgPosition::getAllData();
        } else {
            $positions = [];
        }
        return view('livewire.student.datatable')
            ->with([
                'columns' => $this->getColumns(),
                'rows' => $this->getRows(),
                'positions' => $positions,
                'showSearch' => true,
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

    public function builder(): Builder
    {

        $this->serial = (request('usersPage', 1) - 1) * 20;

        $query = User::select(
            'id',
            'username',
            'name',
            'org_chart_code',
            'org_position_code',
            'employee_id',
            'email',
            'dob',
            'gender',
            'start_working_date',
            'phone',
            'status'
        )->where('teach_via', 1)->with('position', 'branch');
        if (isModuleActive('UserType')) {
            $query->whereHas('userRoles', function ($q) {
                $q->where('role_id', 3);
            });
        } else {
            $query->where('role_id', 3);
        }
        if (count($this->branchCodes) != 0) {
            $ids = [];
            foreach ($this->branchCodes as $key => $code) {
                $branch = OrgBranch::where('code', $code)->first();
                if ($branch) {
                    $branchIds = $branch->getAllChildIds($branch, [$code]);
                    $ids = array_merge($ids, $branchIds);
                }

            }
            $query->whereIn('org_chart_code', $ids);

        }
        if (Auth::user()->role_id != 1) {
            $assign_code = [];
            if (Auth::user()->policy) {
                $branches = Auth::user()->policy->branches;
                foreach ($branches as $branch) {
                    $assign_code[] = $branch->branch->code;
                }
            }
            $query->whereIn('org_chart_code', $assign_code);
        }

        if (!empty($this->position)) {
            $query->where('org_position_code', $this->position);
        }
        $query->latest();
        return $query;

    }


}
