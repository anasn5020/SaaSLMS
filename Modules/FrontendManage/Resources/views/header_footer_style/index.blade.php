@php
    $styles=[
     ['id'=>1,'name'=>'Style 1'],
     ['id'=>2,'name'=>'Style 2'],
//     ['id'=>3,'name'=>'Style 3'],
//     ['id'=>4,'name'=>'Style 4'],
//     ['id'=>5,'name'=>'Style 5'],
//     ['id'=>6,'name'=>'Style 6'],
    ];

    $selectedHeader =(int)Settings('header_style');
    $selectedFooter =(int)Settings('footer_style');
if (!$selectedFooter){
    $selectedFooter=1;
}
if (!$selectedHeader){
    $selectedHeader=1;
}
@endphp
@extends('backend.master')
@section('mainContent')
    @push('styles')

    @endpush
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row row-gap-3">
                <div class="col-lg-12" id="">
                    <form action="{{route('frontend.header-footer-style.index')}}" method="post">
                        @csrf
                        <div class="white-box student-details header-menu">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>{{__('frontend.Header Style')}}</h2>
                                    @foreach ($styles as $style)
                                        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                            <div class="primary_checkbox footer_style_select_checkbox d-flex  gap-3">

                                                <label class="primary_checkbox d-flex">
                                                    <input type="radio" name="header"
                                                           id="header{{$style['id']}}"
                                                           {{$style['id']==$selectedHeader? 'checked':''}} class="headerCheck"
                                                           data-preview="{{asset('public/header-footer/header'.$style['id'].'.jpg')}}"
                                                           value="{{$style['id']}}">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label for="header{{$style['id']}}">{{$style['name']}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                    <h2>{{__('frontend.Footer Style')}}</h2>
                                    @foreach ($styles as $style)
                                        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                            <div class="primary_checkbox footer_style_select_checkbox d-flex  gap-3">

                                                <label class="primary_checkbox d-flex">
                                                    <input type="radio" name="footer"
                                                           id="footer{{$style['id']}}"
                                                           data-preview="{{asset('public/header-footer/footer'.$style['id'].'.jpg')}}"
                                                           {{$style['id']==$selectedFooter? 'checked':''}} class="footerCheck"
                                                           value="{{$style['id']}}">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label for="footer{{$style['id']}}">{{$style['name']}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <h2>{{__('frontend.Preview')}}</h2>
                                    <img src="{{asset('public/header-footer/header'.$selectedHeader.'.jpg')}}"
                                         class="w-100 headerPreview" alt="">
                                    <br><br>
                                    <img src="{{asset('public/header-footer/footer'.$selectedFooter.'.jpg')}}"
                                         class="w-100 footerPreview" alt="">
                                </div>
                            </div>


                            <div class="row mt-3">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <div class="text-center">

                                        <button
                                            class="primary-btn semi_large2  fix-gr-bg"
                                            id="save_button_parent" type="submit"><i
                                                class="ti-check"></i> {{__('common.Submit')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>

    </section>
    @push('scripts')
        <script>
            $(document).ready(function () {
                // $('.checkmark').trigger('click')
            })
            $(document).on('click', '.headerCheck', function () {
                let preview = $(this).data('preview');
                console.log(preview)
                $('.headerPreview').attr('src', preview);
            });
            $(document).on('click', '.footerCheck', function () {
                let preview = $(this).data('preview');
                console.log(preview)
                $('.footerPreview').attr('src', preview);
            });
        </script>
    @endpush
@endsection
