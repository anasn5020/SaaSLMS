<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;
use Modules\OrgSubscription\Entities\OrgCourseSubscription;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Traits\WithFilters;
use Rappasoft\LaravelLivewireTables\Traits\WithSearch;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ShowAutoEnrollmentPath extends DataTableComponent
{
    public array $bulkActions = [
        'exportSelected' => 'Export',
    ];
    public bool $columnSelect = true;
    public bool $rememberColumnSelection = true;
    public string $tableName = 'org_course_subscriptions';
    use WithSearch;
    use WithFilters;
    use WithPagination;

    public $page = 1;
    public $plan = null;

    public bool $searchIsEnabled = false;
    public $theme = 'bootstrap-4';
    public $users = [];
    public array $selectedColumns = [

        'title',
        'duration',
        'created-by',
        'created-date',
    ];
    public array $perPageAccepted = [20, 40, -1];
    public array $org_course_subscriptions = [];
    public bool $hasSerial = true;

    protected $listeners = ['refreshDatatable' => '$refresh'];

    public $selectedItems = [];
    public $edit_path;

    public function mount($edit_path = [])
    {
        $this->plan = null;
        $this->emit('refreshDatatable');
        $this->edit_path = $edit_path;
        $this->selectedItems = $edit_path;


    }


    public function columns(): array
    {
        return [
            Column::make(__('common.Title'), 'title')
                ->sortable()
                ->searchable(),


            Column::make(__('org-subscription.Duration'), 'days')
                ->sortable()
                ->searchable(),

            Column::make(__('org.Created by'), 'created_by')
                ->sortable()
                ->format(fn($value, $row, Column $column) => $row->createdBy->name)
                ->searchable(),
            Column::make(__('org.Created date'), 'created_at')
                ->sortable()
                ->searchable(),


        ];
    }

    public function builder(): Builder
    {
        $query = OrgCourseSubscription::with('createdBy')->where([
            'type' => 2,
            'status' => 1
        ])->latest();
        if (!empty($this->plan)) {
            $query->where('type', $this->plan);
        }
        $query->select('id');
        return $query;
    }

//    public function rowView(): string
//    {
//        $this->emptyMessage = trans("common.No data available in the table");
//        return 'livewire.org-auto-enrollment-plan.row';
//    }
//
//    public function paginationView()
//    {
//        return 'backend.partials._pagination';
//    }


    public function render()
    {

        return view('livewire.org-auto-enrollment-plan.datatable')
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
