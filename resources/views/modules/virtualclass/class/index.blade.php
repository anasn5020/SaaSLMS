@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/class.css')}}"/>
@endpush
@php
    $table_name='courses';
@endphp
@section('table')
    {{$table_name}}
@stop
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                {{--                @include('virtualclass::class.partials._meeting_form')--}}
                @include('virtualclass::class.partials._meeting_list')
            </div>
        </div>
    </section>
    @include('virtualclass::class.partials._meeting_delete_modal')

@endsection
@push('scripts')
    <script src="{{ asset('/') }}/Modules/Membership/Resources/assets/js/app.js"></script>
    <script>
        $(document).ready(function () {
            let status = false;
            divHideSHow(status);

            $(document).on('click', '#all_level_member', function () {
                let status = $(this).is(':checked');

                divHideSHow(status);
            });

            function divHideSHow(status) {

                if (status == true) {
                    $('#membership_level_div').addClass('d-none');
                    $('#membership_level_member_div').addClass('d-none');
                } else {
                    $('#membership_level_div').removeClass('d-none');
                    $('#membership_level_member_div').removeClass('d-none');
                }
            }
        })
    </script>
    @php
        $url = route('getAllVirtualClassData');
    @endphp

    <script>
        dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.ajax = '{!! $url !!}';
        dataTableOptions.columns = [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'title', name: 'title'},
                @if(isModuleActive('Org'))
            {
                data: 'required_type', name: 'courses.required_type'
            },
                @endif
            {
                data: 'category_name', name: 'category.name'
            },
            {data: 'subCategory', name: 'subCategory.name', orderable: false},
            {data: 'language', name: 'language.name'},
            {data: 'duration', name: 'duration'},
                @if(showEcommerce())
            {
                data: 'fees', name: 'fees'
            },
                @endif
            {
                data: 'total_class', name: 'total_class'
            },
            {data: 'start_date', name: 'start_date'},
            {data: 'end_date', name: 'end_date'},
            {data: 'time', name: 'time'},
            {data: 'host', name: 'host'},
            {data: 'level', name: 'level'},
            {data: 'scope', name: 'scope'},
            {data: 'status', name: 'status', orderable: false},
            {data: 'action', name: 'action', orderable: false},
        ];
        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,11,12,13]);

        let table = $('#lms_table').DataTable(dataTableOptions);


        $(document).on('click', '.deleteClass', function () {
            let id = $(this).data('id');
            $('#classDeleteId').val(id);
            $("#deleteClass").modal('show');
        });
    </script>

    <script src="{{asset('/')}}/Modules/CourseSetting/Resources/assets/js/course.js"></script>
    <script src="{{asset('public/backend/js/zoom.js')}}"></script>

    {{--  @if (isset($editdata))
          @if (old('is_recurring', $editdata->is_recurring) == 1)
              <script>
                  $(".recurrence-section-hide").show();
              </script>
          @else

              <script>
                  $(".recurrence-section-hide").hide();
                  $(".day_hide").hide();
              </script>
          @endif
      @elseif(old('is_recurring') == 1)
          <script>
              $(".recurrence-section-hide").show();
          </script>
      @else
          <script>
              $(".recurrence-section-hide").hide();
              $(".day_hide").hide();
          </script>
      @endif
      @if (isset($editdata))
          <script>
              $(".default-settings").show();
          </script>
      @else
          <script>
              $(".default-settings").hide();
          </script>
      @endif
  --}}
    <script>

        $(document).on('click', '.is_recurring', function () {
            let recurrence_section = $('.recurrence_section');
            if ($("input[name='is_recurring']:checked").val() == 0) {
                recurrence_section.addClass('d-none');
            } else {
                recurrence_section.removeClass('d-none');
            }
        })
        $(document).on('change', '#recurring_type', function () {
            let type = $(this).val();
            let day_hide = $(".day_hide");
            if (type != 2) {
                day_hide.addClass('d-none');
            } else {
                day_hide.removeClass('d-none');
            }

        })
    </script>

@endpush
