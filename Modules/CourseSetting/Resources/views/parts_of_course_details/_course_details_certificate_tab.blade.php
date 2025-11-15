<div class="main-title">
    <h3>{{__('subscription.Assign')}} {{__('certificate.Certificate')}}</h3>
</div>
<div class="">

    <div class="white-box">

        <form action="{{route('AdminUpdateCourseCertificate')}}" method="post">
            @csrf
            <input type="hidden" name="course_id" value="{{@$course->id}}">
            <div class="row">
                <div class="col-xl-6 ">
                    <select class="primary_select edit_category_id"
                            data-course_id="{{@$course->id}}"
                            name="certificate" id="course">
                        <option
                            data-display="{{__('common.Select')}} {{__('certificate.Certificate')}}"
                            value="">{{__('common.Select')}} {{__('certificate.Certificate')}} </option>
                        @foreach($certificates as $certificate)
                            <option value="{{$certificate->id}}"
                                    @if(isModuleActive('CertificatePro') && Settings('use_certificate_template') == 'pro')
                                        @if ($certificate->id==$course->pro_certificate_id) selected @endif>{{@$certificate->title}}
                                @else
                                    @if ($certificate->id==$course->certificate_id)
                                        selected
                                    @endif>{{@$certificate->title}}
                                @endif

                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-12 text-center pt_15">
                <div class="d-flex justify-content-center">
                    <button class="primary-btn semi_large2  fix-gr-bg"
                            id="save_button_parent" type="submit">
                        <i class="ti-check"></i>{{__('common.Save')}} {{__('certificate.Certificate')}}
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
