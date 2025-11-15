@extends('backend.master')


@section('mainContent')
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">


        <div class="white_box mb_30  student-details header-menu">
            <div class="white_box_tittle list_header">
                <h4>{{__('common.Edit')}} {{__('common.Question')}}/{{__('common.Answer')}}</h4>
            </div>
            <div class="col-lg-12">
                <form action="{{route('qa.questions.edit',$question->id)}}" method="POST">
                    @csrf

                    <div class="col-xl-12">
                        <div class="primary_input mb-35">
                            <label class="primary_input_label d-flex"
                                   for="">{{__('common.Text')}}
                            </label>
                            <textarea class="lms_summernote"
                                      name="text"
                                      id="addRequirements" cols="30"
                                      rows="10">{!! old('text',$question->text) !!}</textarea>
                        </div>

                    </div>
                    <div class="col-lg-12 text-center pt_15">
                        <div class="d-flex justify-content-center">
                            <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"
                                    type="submit"><i
                                    class="ti-check"></i> {{__('common.Update') }}
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>

@endsection
