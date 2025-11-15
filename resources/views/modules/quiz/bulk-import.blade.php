@extends('backend.master')
@section('mainContent')

    {!! generateBreadcrumb() !!}
    <div class="white-box">

        <div class="row">
            <div class="col-md-12">
                <div class="box_header">
                    <div class="main-title d-flex justify-content-between w-100 flex-column flex-sm-row gap-3">
                        <h3 class="mb-0 ">  {{ __('quiz.Bulk Import') }}</h3>

                        <div class="">
                            <a href="{{route('download-sample')}}"
                               class="primary-btn small fix-gr-bg float-start float-sm-end">
                                <span class="ti-plus pe-2"></span>
                                {{__('quiz.Sample Download')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="mb-40 student-details">
            <div class="container-fluid p-0">
                <div class="row">

                    <div class="col-lg-12">


                        <form class="form-horizontal" action="{{route('question-bank-bulk-submit')}}" method="POST"
                              enctype="multipart/form-data">

                            @csrf


                            <div class="col-md-12 p-0">

                                <div class="row ">
                                    <div class="col-md-12">

                                        <div class="row">
                                            <div class="col-xl-12">

                                                <ul>
                                                    <li>
                                                        01. {{__('quiz.You need to import Excel File. For sample you can download by clicking')}}
                                                        <b>{{__('quiz.Sample Download')}}</b></li>
                                                    <li>
                                                        02. {{__('quiz.Make sure input correct answer in right column. Use option number')}}
                                                        .
                                                        {{__('quiz.For example if')}} <b>{{__('quiz.Option 3')}}</b>
                                                        {{__('quiz.ans column enter')}} <b>3</b>.
                                                        <br>{{__('quiz. Now support multiple')}}.
                                                        {{__('quiz.Use Pipe sign')}}
                                                        <b>(|) </b>
                                                        {{__('quiz.for multiple correct ans')}}
                                                        . {{__('quiz.For example if')}} <b>{{__('quiz.Option 1')}}</b>,
                                                        <b>{{__('quiz.Option 3')}}</b> {{__('quiz.is correct then enter')}}
                                                        <b>1|3</b>
                                                    </li>
                                                    <li>
                                                        03. {{__('quiz.Option is now dynamic. so add header row prefix')}}
                                                        <b>{{__('quiz.Option')}} </b>. {{__('quiz.Example')}}
                                                        <b>{{__("quiz.Option 7")}}</b>,<b>{{__('quiz.Option 8')}}</b>

                                                    </li>
                                                    <li>04. {{__("quiz.Use Type")}}
                                                        <b>M</b>= {{__('quiz.Multiple Choice')}};
                                                        <b>S</b>={{__("quiz.Short Answer")}};
                                                        <b>L</b>={{__('quiz.Long Answer')}}
                                                    </li>
                                                </ul>

                                                <hr>
                                            </div>

                                            <div class="col-xl-6">

                                                <label class="primary_input_label"
                                                       for="groupInput">{{__('quiz.Group')}} *</label>

                                                <select {{ $errors->has('group') ? ' autofocus' : '' }}
                                                        class="primary_select{{ $errors->has('group') ? ' is-invalid' : '' }}"
                                                        name="group" id="groupInput">
                                                    <option
                                                        data-display="{{__('common.Select')}} {{__('quiz.Group')}} *"
                                                        value="">{{__('common.Select')}} {{__('quiz.Group')}}
                                                    </option>
                                                    @foreach($groups as $group)
                                                        @if(isset($bank))
                                                            <option
                                                                value="{{$group->id}}" {{$group->id == $bank->q_group_id? 'selected': ''}}>{{$group->title}}</option>
                                                        @else
                                                            <option
                                                                value="{{$group->id}}" {{old('group')!=''? (old('group') == $group->id? 'selected':''):''}} >{{$group->title}}</option>
                                                        @endif

                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="col-xl-6">

                                                <label class="primary_input_label"
                                                       for="groupInput">{{__('quiz.Excel File')}} *</label>
                                                <div class="primary_input ">
                                                    <div class="primary_file_uploader">

                                                        <label for="placeholderFileOneName" class="d-none"></label>
                                                        <input class="primary-input" type="text"
                                                               id="placeholderFileOneName"
                                                               placeholder="{{ __('quiz.Browse Excel File') }}"
                                                               readonly="">
                                                        <button class="" type="button">
                                                            <label class="primary-btn small fix-gr-bg"
                                                                   for="document_file_1">{{ __('common.Browse') }}</label>
                                                            <input type="file" class="d-none" name="excel_file"
                                                                   id="document_file_1"
                                                                   onchange="nameChange(this.value)">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-12 text-center">
                                    <button id="submitBtn" type="submit"
                                            class="primary-btn   fix-gr-bg"> {{ __('quiz.Bulk Import') }}</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
     <script src="{{asset('Modules/Quiz/Resources/assets/js/quiz.js')}}"></script>
@endpush
