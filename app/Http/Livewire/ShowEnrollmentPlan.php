<?php

namespace App\Http\Livewire;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Org\Entities\OrgPosition;
use Modules\OrgSubscription\Entities\OrgCourseSubscription;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Traits\WithFilters;
use Rappasoft\LaravelLivewireTables\Traits\WithSearch;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class ShowEnrollmentPlan extends DataTableComponent
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
    public $org_course_subscriptions = [];

    public bool $hasSerial = false;

    protected $listeners = ['refreshDatatable' => '$refresh'];
    public array $selectedColumns = [
        'title',
        'join-date',
        'end-date',
        'duration',
        'plan',
    ];

    public function mount()
    {
        $this->plan = null;
        $this->emit('refreshDatatable');
    }


    public function columns(): array
    {
        return [
            Column::make(__('common.Title'), 'title')
                ->sortable()
                ->searchable(),


            Column::make(__('org-subscription.Join Date'), 'join_date')
                ->sortable()
                ->searchable(),

            Column::make(__('org-subscription.End Date'), 'end_date')
                ->sortable()
                ->searchable(),

            Column::make(__('org-subscription.Duration'), 'days')
                ->sortable()
                ->searchable(),

            Column::make(__('org-subscription.Plan'), 'type')
                ->sortable()
                ->format(fn($value, $row, Column $column) => $row->type == 1 ? 'Class' : 'Leaning Path')
                ->searchable(),


        ];
    }

    public function builder(): Builder
    {
        $this->emit('refreshDatatable');

        $query = OrgCourseSubscription::select('id')->where('status', 1)->latest();
        if (!empty($this->plan)) {
            $query->where('type', $this->plan);
        }
        return $query;
    }

//    public function rowView(): string
//    {
//        $this->emptyMessage = trans("common.No data available in the table");
//        return 'livewire.org-enrollment-plan.row';
//    }
//
//    public function paginationView()
//    {
//        return 'backend.partials._pagination';
//    }


    public function render()
    {

        return view('livewire.org-enrollment-plan.datatable')
            ->with([
                'columns' => $this->getColumns(),
                'rows' => $this->getRows(),
                'showSearch' => true,
            ]);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setPerPageVisibilityStatus(false);
    }

}
