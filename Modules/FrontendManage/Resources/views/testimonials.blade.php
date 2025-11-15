@extends('backend.master')
@section('table')
    {{__('testimonials')}}
@endsection
@section('mainContent')
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-xxl-3">
                    <div class="white-box mb_30  student-details header-menu">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="box_header common_table_header">
                                    <div class="main-title d-md-flex w-100">
                                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">
                                            @if(!isset($edit))
                                                {{__('frontendmanage.Add New Testimonial') }}
                                            @else
                                                {{__('common.Update')}}
                                            @endif</h3>

                                        @if(isset($edit))
                                            <div class="float-end text-end">
                                                <a href="{{route('frontend.testimonials')}}"
                                                   class="primary-btn small fix-gr-bg updatebtn float-end"
                                                   title="{{__('frontendmanage.Add New Testimonial') }}">+ </a>
                                            </div>

                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!isset($edit) && permissionCheck('frontend.testimonials_store'))
                            <form
                                action="{{route('frontend.testimonials_store') }}"
                                method="POST" id="coupon-form" name="coupon-form" enctype="multipart/form-data">
                                @csrf
                                @elseif(permissionCheck('frontend.testimonials_edit') && isset($edit))
                                    <form
                                        action="{{isset($edit)?route('frontend.testimonials_update'): '' }}"
                                        method="POST" id="coupon-form" name="coupon-form" enctype="multipart/form-data">
                                        @csrf
                                        @if(isset($edit))
                                            <input type="hidden" name="id" value="{{$edit->id}}">
                                        @endif
                                        @endif


                                        <input type="hidden" name="category" value="1">

                                        @php
                                            $LanguageList = getLanguageList();
                                        @endphp
                                        <div class="row pt-0">
                                            @if(isModuleActive('FrontendMultiLang'))
                                                <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                    role="tablist">
                                                    @foreach ($LanguageList as $key => $language)
                                                        <li class="nav-item">
                                                            <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                               href="#element{{$language->code}}"
                                                               role="tab"
                                                               data-bs-toggle="tab">{{ $language->native }}  </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                        <div class="tab-content">
                                            @foreach ($LanguageList as $key => $language)
                                                <div role="tabpanel"
                                                     class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                     id="element{{$language->code}}">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{ __('frontendmanage.Body Text') }}
                                                                    <span class="required_mark">*</span> </label>
                                                                <textarea name="body[{{$language->code}}]" id=""
                                                                          cols="30" rows="10"
                                                                          {{ $errors->has('body') ? ' autofocus' : '' }}
                                                                          placeholder="{{ __('frontendmanage.Body Text') }}"
                                                                          class="primary_textarea {{ @$errors->has('body') ? ' is-invalid' : '' }}">{{isset($edit)?$edit->getTranslation('body',$language->code):''}}</textarea>
                                                                @if ($errors->has('body'))
                                                                    <span class="invalid-feedback d-block mb-10"
                                                                          role="alert">
                                                <strong>{{ @$errors->first('body') }}</strong>
                                            </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{ __('frontendmanage.Author') }}
                                                                    <span class="required_mark">*</span> </label>
                                                                <input name="author[{{$language->code}}]" id="author"
                                                                       {{ $errors->has('author') ? ' autofocus' : '' }}
                                                                       class="primary_input_field name {{ @$errors->has('author') ? ' is-invalid' : '' }}"
                                                                       placeholder="{{ __('frontendmanage.Enter Author Name') }}"
                                                                       type="text"
                                                                       value="{{isset($edit)?$edit->getTranslation('author',$language->code):''}}">
                                                                @if ($errors->has('author'))
                                                                    <span class="invalid-feedback d-block mb-10"
                                                                          role="alert">
                                                <strong>{{ @$errors->first('author') }}</strong>
                                            </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{ __('frontendmanage.Profession') }}
                                                                    <span class="required_mark">*</span> </label>
                                                                <input name="profession[{{$language->code}}]"
                                                                       id="profession"
                                                                       {{ $errors->has('profession') ? ' autofocus' : '' }}
                                                                       class="primary_input_field name {{ @$errors->has('profession') ? ' is-invalid' : '' }}"
                                                                       placeholder="{{ __('frontendmanage.Enter Profession') }}"
                                                                       type="text"
                                                                       value="{{isset($edit)?$edit->getTranslation('profession',$language->code):''}}">
                                                                @if ($errors->has('profession'))
                                                                    <span class="invalid-feedback d-block mb-10"
                                                                          role="alert">
                                                <strong>{{ @$errors->first('profession') }}</strong>
                                            </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="row">

                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="">{{ __('common.Star') }}
                                                        <span class="required_mark">*</span> </label>
                                                    <select class="primary_select mb-25" name="star" id="star">
                                                        <option value="1" @if(isset($edit))
                                                            {{$edit->star==1?'selected':''}}
                                                            @endif>
                                                            {{translatedNumber(1)}}
                                                        </option>
                                                        <option value="2" @if(isset($edit))
                                                            {{$edit->star==2?'selected':''}}
                                                            @endif>
                                                            {{translatedNumber(2)}}
                                                        </option>
                                                        <option value="3" @if(isset($edit))
                                                            {{$edit->star==3?'selected':''}}
                                                            @endif>
                                                            {{translatedNumber(3)}}
                                                        </option>
                                                        <option value="4" @if(isset($edit))
                                                            {{$edit->star==4?'selected':''}}
                                                            @endif>
                                                            {{translatedNumber(4)}}
                                                        </option>
                                                        <option value="5"
                                                                @if(isset($edit)){{$edit->star==5?'selected':''}} @else selected @endif >
                                                            {{translatedNumber(5)}}

                                                        </option>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="  mb-15">
                                                    <x-upload-file
                                                        type="image"
                                                        name="image"
                                                        required="true"
                                                        media_id="{{isset($edit)?$edit->image_media?->media_id:''}}"
                                                        label="{{ __('common.Image') }}"
                                                    />

                                                </div>
                                            </div>


                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="">{{ __('common.Status') }}
                                                        <span class="required_mark">*</span> </label>
                                                    <select
                                                        class="primary_select mb-25  {{ @$errors->has('status') ? ' is-invalid' : '' }}"
                                                        name="status" id="status" required>
                                                        <option
                                                            value="1" {{isset($edit)?($edit->status==1?'selected':''):''}}>{{__('common.Active') }}</option>
                                                        <option
                                                            value="0" {{isset($edit)?($edit->status==0?'selected':''):''}}>{{__('common.Inactive') }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            @php
                                                $disable =false;
                                                    if(!isset($edit)){
                                                        if (!permissionCheck('frontend.testimonials_store')){
                                                            $disable=true;
                                                        }
                                                        $text= __('common.Save');

                                                    }else{
                                                           if(!permissionCheck('frontend.testimonials_edit')){
                                                            $disable=true;
                                                        }
                                                           $text= __('common.Update');
                                                    }
                                            @endphp
                                            @if(!$disable)
                                                <div class="col-lg-12 text-center">
                                                    <div class="d-flex justify-content-center pt_20">
                                                        <button type="submit" class="primary-btn semi_large fix-gr-bg"
                                                                {{$disable?'disable':''}}
                                                                id="save_button_parent">
                                                            <i class="ti-check"></i>
                                                            {{$text}}
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </form>
                    </div>
                </div>
                <div class="col-xxl-9">
                    <div class="white-box">
                        <div class="box_header common_table_header">
                            <div class="main-title d-flex flex-wrap mb-0">
                                <h3 class="mb-0" id="page_title">{{__('frontendmanage.Testimonial')}} </h3>
                            </div>
                        </div>
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table">
                                <!-- table-responsive -->
                                <div class="">
                                    <table id="lms_table" class="table Crm_table_active3">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('common.SL') }}</th>
                                            <th scope="col">{{ __('frontendmanage.Body') }}</th>
                                            <th scope="col">{{ __('frontendmanage.Author') }}</th>
                                            <th scope="col">{{ __('frontendmanage.Profession') }}</th>
                                            <th scope="col">{{ __('common.Image') }}</th>
                                            <th scope="col">{{ __('frontendmanage.Date') }}</th>

                                            <th scope="col">{{ __('common.Star') }}</th>
                                            <th scope="col">{{ __('common.Status') }}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        @foreach($testimonials as $key => $item)
                                            <tr>
                                                <th>{{ translatedNumber($key+1) }}</th>
                                                <td>{{ @$item->body }}</td>
                                                <td>{{ @$item->author }}</td>
                                                <td>{{ @$item->profession }}</td>
                                                <td>
                                                    <img src="{{asset($item->image)}}" alt=""
                                                         class="img img-responsive"
                                                         style="width: auto; height:100px !important">
                                                </td>
                                                <td>{{ showDate(@$item->created_at)}}</td>

                                                <td>
                                                    @for($i=1;$i<=$item->star;$i++)
                                                        <i class="fas fa-star"></i>
                                                    @endfor
                                                </td>
                                                <td>
                                                    <label class="switch_toggle"
                                                     >
                                                        <input type="checkbox"
                                                                class="status_enable_disable"
                                                               @if (@$item->status == 1) checked
                                                               @endif value="{{ @$item->id }}">
                                                        <i class="slider round"></i>
                                                    </label>
                                                </td>
                                                <td>
                                                    <!-- shortby  -->
                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                id="dropdownMenu2" data-bs-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                            {{ __('common.Select') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                             aria-labelledby="dropdownMenu2">
                                                            @if(permissionCheck('frontend.testimonials_edit'))
                                                                <a href="{{route('frontend.testimonials_edit',@$item->id)}}"
                                                                   class="dropdown-item edit_brand">{{__('common.Edit')}}</a>
                                                            @endif
                                                            @if(permissionCheck('frontend.testimonials_delete'))
                                                                <a onclick="confirm_modal('{{route('frontend.testimonials_delete', @$item->id)}}');"
                                                                   class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
    <script type="application/javascript">


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 5,]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>
@endpush
