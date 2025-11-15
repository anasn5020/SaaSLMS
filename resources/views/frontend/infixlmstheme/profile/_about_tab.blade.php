<div class="tab-pane fade" id="about_tab">
    <div class="row">
        <div class="col-12">

            <h3>{{__('common.About')}}</h3>
            <hr>
            <form action="{{route('users.about.update')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <label class="primary_label2" for="job_title">{{__('profile.job_title')}}
                        </label>
                        <input id="job_title" name="job_title" placeholder=""
                               onfocus="this.placeholder = ''"
                               onblur="this.placeholder = 'Ex: Sales Manager, Software Engineer'"
                               class="primary_input" {{$errors->first('job_title') ? 'autofocus' : ''}}
                               value="{{old('job_title')??@$user->job_title}}" type="text">
                        <span class="text-danger" role="alert">{{$errors->first('job_title')}}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 mt_20">
                        <div class="single_input mb_25">
                            <label class="primary_label2"
                                   for="">{{__('profile.short_description') }}
                            </label>
                            <textarea
                                placeholder=""
                                name="short_description"
                                class="primary_textarea gray_input short_description_field">{{old("short_description")??@$user->userInfo->short_description}}</textarea>
                            <small style="color: var(--system_primery_color)">"{{__('profile.short_description') }}
                                " {{__("profile.will be displayed at the bottom of your name on the profile cards. Keep it short (80 to 100 words)")}}
                                . <span class="short_description_character_count text-danger"></span></small>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-8 mt_20 mb-3">
                        <label class="primary_label2">{{__('profile.biography')}}</label>
                        <textarea name="about" class="primary_textarea4 mb_20"
                                  placeholder="{{__('student.Write Note here')}}"
                                  onfocus="this.placeholder = ''"
                                  onblur="this.placeholder = '{{__('student.Write Note here')}}'">
                             @if(old('about'))
                                {{old('about')}}
                            @else
                                {!! @$user->about !=""? @$user->about:old('about') !!}
                            @endif

                        </textarea>
                    </div>

                </div>

                <div class="row">

                    <div class="col-12 text-end">
                        <hr class="d-block">
                        <button class="theme_btn small_btn text-center" type="submit"><i
                                class="ti-check"></i> {{__('common.Save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
