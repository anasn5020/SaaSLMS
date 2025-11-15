<div class="QA_section QA_section_heading_custom check_box_table  pt-20">
    <div class="QA_table ">
        <form action="{{route('setCourseDripContent')}}" method="post">
            <input type="hidden" name="course_id" value="{{$course->id}}">
            @csrf
            <table class="table  pt-0">
                <thead>
                <tr>
                    <th>{{__('common.Name')}}</th>
                    <th></th>
                    <th>{{__('common.Specific Date')}}/{{__('common.Days After Enrollment')}}</th>
                </tr>
                </thead>

                <tbody>
                @if(count($chapters)==0)
                    <tr>
                        <td colspan="3"
                            class="text-center">{{__('courses.No Data Found')}}</td>
                    </tr>
                @endif
                @php
                    $i=0;
                @endphp
                @foreach($chapters as $key1 => $chapter)

                    @foreach ($chapter->lessons as $key => $lesson)

                        <input type="hidden" name="lesson_id[]"
                               value="{{@$lesson->id}}">
                        <tr>
                            <td>
                                @if ($lesson->is_quiz==1)

                                    <span> <i class="ti-check-box"></i>   {{$key+1}}. {{@$lesson['quiz'][0]['title']}} </span>

                                @else

                                    <span> <i class="ti-control-play"></i>  {{$key+1}}. {{$lesson['name']}} [{{MinuteFormat($lesson['duration'])}}] </span>
                                @endif
                            </td>
                            <td>
                                <div class="row">


                                    <div class="form-check p-1">

                                        <label class="primary_checkbox d-flex mr-12 "
                                               for="select_drip_{{$i}}1">
                                            <input
                                                class="form-check-input  common-radio drip_type"
                                                type="radio"
                                                name="drip_type[{{$i}}]"
                                                id="select_drip_{{$i}}1"
                                                value="1"
                                                @if(!empty($lesson->unlock_date))checked @endif>

                                            <span class="checkmark"></span>

                                            <span class="ms-2">{{__('common.Date')}}</span>
                                        </label>
                                    </div>
                                    <div class="form-check  p-1">

                                        <label class="primary_checkbox d-flex mr-12 "
                                               for="select_drip_{{$i}}2">
                                            <input
                                                class="form-check-input common-radio drip_type"
                                                type="radio"
                                                name="drip_type[{{$i}}]"
                                                id="select_drip_{{$i}}2"
                                                @if(empty($lesson->unlock_date))checked
                                                @endif
                                                value="2">
                                            <span class="checkmark"></span>
                                            <span class="ms-2">  {{__('common.Days')}} </span>
                                        </label>
                                    </div>

                                </div>
                            </td>

                            <td>
                                <input type="text"
                                       class="primary_input_field primary-input date form-control dripDate {{!empty($lesson->unlock_date)?'':'d-none'}}"
                                       placeholder="{{__('common.Select Date')}}"
                                       readonly
                                       name="lesson_date[]"
                                       value="{{@$lesson->unlock_date!=""?date('m/d/Y',strtotime($lesson->unlock_date)):""}}">

                                <input type="number" min="1" max="365"
                                       class="form-control dripDays {{empty($lesson->unlock_date)?'':'d-none'}}"
                                       placeholder="{{__('common.Days')}}"
                                       name="lesson_day[]"
                                       value="{{@$lesson['unlock_days']}}">
                            </td>

                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach

                @endforeach
                </tbody>
            </table>

            <div class="row">
                @if(count($chapters)!=0)

                    <div class="col-12 mt-3 d-flex justify-content-center align-content-center">
                        <button class="primary-btn fix-gr-bg" type="submit"
                                data-bs-toggle="tooltip">
                            <i class="ti-check"></i>
                            {{__('common.Save')}}
                        </button>

                    </div>
                @endif
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        {{--        document on ready--}}
        $(document).ready(function () {
            $('.drip_type').on('change', function () {
                let type = $(this).val();
                let row = $(this).closest('tr');
                if (type == 1) {
                    row.find('.dripDate').removeClass('d-none');
                    row.find('.dripDays').addClass('d-none');
                } else {
                    row.find('.dripDate').addClass('d-none');
                    row.find('.dripDays').removeClass('d-none');
                }
            });
        })
    </script>
@endpush
