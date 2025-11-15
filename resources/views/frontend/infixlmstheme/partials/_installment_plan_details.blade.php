@php

    if (Settings('installment_active') != 1) {
        return;
    }
    if (Settings('disable_installment') == 1 && auth()->user() && auth()->user()->installment_due_course != null ) {
        return;
    }

    if (auth()->user() && auth()->user()->installment_eligibility != 1) {
        return;
    }
    if ($position != Settings('installment_plan_position')){
        return;
    }


    $target = '';
    switch ($course->type) {
        case 1:
            $target = 'course';
            break;
        case 2:
            $target = 'quiz';
            break;
        case 3:
            $target = 'live_class';
            break;

        default:
            $target = 'course';
            break;
    }
    $target_type_array = [];
    switch ($target) {
        case 'course':
            $target_type_array = ['all_course', 'specific_course', 'specific_category', 'specific_instructor'];
            break;
        case 'quiz':
            $target_type_array = ['all_quiz', 'specific_quiz', 'specific_instructor'];
            break;
        case 'live_class':
            $target_type_array = ['all_live_class', 'specific_class', 'specific_instructor'];
            break;

        default:
            break;
    }

    $installment_plans = Modules\Installment\Entities\InstallmentPlan::where('status', 1)
        ->with('plan_specific_item', 'plan_specific_item.plan_specific_item_details_relation', 'features', 'paymentSteps')
        ->where('start_datetime', '<=', date('Y-m-d H:i:s'))
        ->where('status', 1)
        ->get();
@endphp
@foreach ($installment_plans as $key => $installment_plan)
    @if($installment_plan->end_datetime != null && $installment_plan->end_datetime < date('Y-m-d H:i:s'))
        @continue
    @endif

    @if ($installment_plan->plan_specific_item->target_type == 'all')
        @include(theme('partials._installment_section'), compact('installment_plan'))
    @endif
    @php
        $installment_plan_target = $installment_plan->plan_specific_item->target;
    @endphp
    @if (in_array($installment_plan_target, $target_type_array))
        @php
            $assigned_items = $installment_plan->plan_specific_item->plan_specific_item_details();
        @endphp
        @if ($installment_plan_target == 'specific_instructor')
            @if (in_array($course->user_id, $assigned_items))
                @include(theme('partials._installment_section'), compact('installment_plan'))
            @endif
        @endif

        @if ($installment_plan_target == 'specific_category')
            @if (in_array($course->category_id, $assigned_items))
                @include(theme('partials._installment_section'), compact('installment_plan'))
            @endif
        @endif

        @if ($installment_plan_target == 'specific_course')
            @if (in_array($course->id, $assigned_items))
                @include(theme('partials._installment_section'), compact('installment_plan'))
            @endif
        @endif

        @if ($installment_plan_target == 'specific_quiz')
            @if (in_array($course->id, $assigned_items))
                @include(theme('partials._installment_section'), compact('installment_plan'))
            @endif
        @endif

        @if ($installment_plan_target == 'specific_class')
            @if (in_array($course->id, $assigned_items))
                @include(theme('partials._installment_section'), compact('installment_plan'))
            @endif
        @endif
        @if (in_array($installment_plan_target, ['all_course', 'all_quiz', 'all_live_class']))
            @include(theme('partials._installment_section'), compact('installment_plan'))
        @endif
    @endif
@endforeach

