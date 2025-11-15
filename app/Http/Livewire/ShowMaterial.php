<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Modules\CourseSetting\Entities\Category;
use Modules\Org\Entities\OrgBranch;
use Modules\Org\Entities\OrgMaterial;
use Modules\OrgInstructorPolicy\Entities\OrgPolicyCategory;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class  ShowMaterial extends DataTableComponent
{
    use WithPagination;

    public bool $columnSelect = true;
    public bool $rememberColumnSelection = true;
    protected $listeners = ['addCategoryFilter', 'selectTypeFilter', 'checkCategory'];

    public $showAddBtn = false, $categories = [];
    public bool $hasSerial = true;

    public $page = 1;

    protected $materials = [];
    public $categoriesIds = [];
    public $type = null;
    public $serial = 0;

    public bool $columnSelectStatus = true;
    public bool $searchStatus = false;
    public bool $searchIsEnabled = false;
    public $theme = 'bootstrap-4';
    public array $selectedColumns = [
        'sl',
        'title',
        'category',
        'type',
        'create-by',
        'status',
        'create-date',
        'action'
    ];
    public array $perPageAccepted = [20, 40, -1];

    public function selectType()
    {
        $this->emit('selectTypeFilter', $this->type);
    }

    public function checkCategory($codes)
    {
        if (count($codes) != 0) {
            $this->categories = $codes;
            $this->showAddBtn = true;

        } else {
            $this->showAddBtn = false;

        }
    }

    public function addCategoryFilter($branchCode)
    {

        if (($key = array_search($branchCode, $this->categoriesIds)) !== false) {
            unset($this->categoriesIds[$key]);
            $branch = Category::where('id', $branchCode)->first();
            $childs = $branch->getAllChildIds($branch);
            foreach ($childs as $child) {
                if (($key2 = array_search($child, $this->categoriesIds)) !== false) {
                    unset($this->categoriesIds[$key2]);
                }
            }
        } else {
            array_push($this->categoriesIds, $branchCode);
        }

        $this->emit('checkCategory', $this->categoriesIds);

    }

    public function selectTypeFilter($type)
    {
        $this->type = $type;

    }

    public function columns(): array
    {
        return [
            Column::make(__('common.SL'), 'id'),
            Column::make(__('common.Title'), 'title')
                ->sortable()
                ->searchable(),
            Column::make(__('common.Category'), 'category')
                ->sortable()
                ->format(fn($value, $row, Column $column) => $row->fullPath)
                ->searchable(),
            Column::make(__('common.Type'), 'type')
                ->sortable()
                ->searchable(),
            Column::make(__('org.Create By'), 'user.name')
                ->sortable()
                ->searchable(),
            Column::make(__('common.Status'), 'status')
                ->format(fn($value, $row, Column $column) => $row->status == 1 ? trans('common.Active') : trans('common.Inactive'))
            ,
            Column::make(__('org.Create Date'), 'created_at')
                ->sortable()
                ->format(fn($value, $row, Column $column) => showDate($row->created_at))
                ->searchable(),

            Column::make(__('common.Action'))
                ->label(
                    fn($row, Column $column) => view('livewire.material._action', compact('row', 'column'))
                )
                ->unclickable(),
        ];
    }

    public function builder(): Builder
    {
        $this->serial = ($this->page - 1) * 10;

        $query = OrgMaterial::with('user', 'cat', 'default');
        if (Auth::user()->role_id != 1) {
//            $query->where('user_id', Auth::user()->id);
        }
        if (count($this->categoriesIds) != 0) {
            foreach ($this->categoriesIds as $key => $code) {
                $category = Category::find($code);
                if ($category) {
                    $ids = $category->getAllChildIds($category, [$code]);
                    if ($key == 0) {
                        $query->whereIn('category', $ids);
                    } else {
                        $query->orWhereIn('category', $ids);
                    }
                }

            }
        } else {
            if (Auth::user()->role_id != 1) {
                $ids = OrgPolicyCategory::where('policy_id', \auth()->user()->policy_id)->pluck('category_id')->toArray();
                $query->whereIn('category', $ids);
            }
        }

        if (!empty($this->type)) {
            $query->where('type', $this->type);
        }
        $query->select('file_id', 'scorm_version', 'scorm_identifier', 'scorm_title', 'category');
        return $query->latest();
    }


    public function render()
    {
        return view('livewire.material.datatable')
            ->with([
                'columns' => $this->getColumns(),
                'rows' => $this->getRows(),
                'showSearch' => true,
            ]);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setEmptyMessage(trans("common.No data available in the table"))
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
