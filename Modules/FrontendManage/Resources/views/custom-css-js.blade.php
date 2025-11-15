@extends('backend.master')
@push('styles')
    <link href="{{asset('public/backend/css/cloudEdit.min.css')}}" rel="stylesheet">
@endpush
@section('mainContent')

    {!! generateBreadcrumb() !!}

    @php
        $tooltip = "";
      $isDemo =config('app.demo_mode');
         if($isDemo){
            $tooltip =trans('common.For the demo version, you cannot change this');
        }
    @endphp
    <section class="mb-20 student-details">
        <div class="container p-0">
            <div class="white-box">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs no-bottom-border justify-content-start mt-sm-md-20 mb-20 ms-0"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" href="#cssSection" role="tab"
                                   data-bs-toggle="tab" id="1"
                                   aria-selected="true">{{__('frontendmanage.CSS')}}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link  show" href="#jsSection" role="tab"
                                   data-bs-toggle="tab" id="2"
                                   aria-selected="true">{{__('frontendmanage.JS')}}</a>
                            </li>


                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active show"
                                 id="cssSection">
                                <div class="">
                                    <div class="add-visitor">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-35">
                                                    <div class="tab-content">
                                                        <div class="window css">
                                                            <pre id="css"> {!! $css !!} </pre>
                                                            <span class="windowLabel" id="cssLabel">CSS</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row  ">
                                            <div class="col-lg-12 d-flex justify-content-center align-content-center text-center tooltip-wrapper" data-title=""
                                                 data-original-title="" title="">
                                                <button
                                                    class="primary-btn fix-gr-bg tooltip-wrapper  text-nowrap"
                                                    type="button"
                                                    id="{{!$isDemo?'cssSectionBtn':''}}" data-bs-toggle="tooltip"
                                                    title="{{$tooltip}}"
                                                >
                                                    <i class="ti-check"></i>
                                                    {{__('common.Update')}} </button>
                                            </div>


                                        </div>

                                    </div>
                                </div>

                            </div>


                            <div role="tabpanel" class="tab-pane   fade"
                                 id="jsSection">
                                <div class="">
                                    <div class="add-visitor">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-35">
                                                    <div class="tab-content">
                                                        <div class="window js">
                                                            <pre id="js">{!! $js !!}</pre>
                                                            <span class="windowLabel"
                                                                  id="jsLabel">JavaScript/jQuery</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row  ">
                                            <div class="col-lg-12 d-flex justify-content-center align-content-center text-center tooltip-wrapper" data-title=""
                                                 data-original-title="" title="">
                                                <button
                                                    class="primary-btn fix-gr-bg tooltip-wrapper  text-nowrap"
                                                    type="button"
                                                    id="{{!$isDemo?'jsSectionBtn':''}}" data-bs-toggle="tooltip"
                                                    title="{{$tooltip}}"
                                                >
                                                    <i class="ti-check"></i>
                                                    {{__('common.Update')}} </button>
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{asset('public/backend/js/ace/ace.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('public/backend/js/cloudEdit.js')}}" type="text/javascript" charset="utf-8"></script>
    <script>
        let js_btn = '#jsSectionBtn';
        let css_btn = '#cssSectionBtn';

        $(document).on('click', js_btn, function (event) {
            event.preventDefault();

            let demoMode = $('#demoMode').val();
            if (demoMode == 1) {
                toastr.warning("For the demo version, you cannot change this", "Warning");
                return false;
            }

            updateFile('js', js_btn)

        });
        $(document).on('click', css_btn, function (event) {
            event.preventDefault();

            let demoMode = $('#demoMode').val();
            if (demoMode == 1) {
                toastr.warning("For the demo version, you cannot change this", "Warning");
                return false;
            }

            updateFile('css', css_btn)

        });

        function updateFile(type, btn) {
            $(btn).prop('disabled', true);
            $(btn).text('{{trans('common.Updating')}}');
            let data = '';

            if (type == 'css') {
                data = cssField.getValue();
            } else if (type == 'js') {
                data = jsField.getValue();
            }

            let formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('data', data);
            formData.append('type', type);
            $.ajax({
                url: "{{ route('frontend.customJsCss') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    toastr.success('{{__('common.Operation successful')}}')
                    $(btn).text('{{__('common.Update')}}');
                    $(btn).prop('disabled', false);
                },
                error: function (response) {
                    toastr.error('{{__('common.Something Went Wrong')}}')
                    $(btn).text('{{__('common.Update')}}');
                    $(btn).prop('disabled', false);
                }
            });
        }
    </script>
@endpush
