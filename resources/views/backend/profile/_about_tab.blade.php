<div class="tab-pane fade" id="about_tab">
    <div class="row">
        <div class="col-12">

            <h3>{{__('common.About')}}</h3>
            <hr>
            <form action="{{route('users.about.update')}}" method="POST">
                @csrf
                <div class="row">
                    @if(isModuleActive('Appointment'))
                        <div class="col-md-8">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="headline">
                                    {{ __('appointment.Specialist') }}
                                </label>
                                <input class="primary_input_field" name="headline" id="headline"
                                       type="text" value="{{old('headline')??@$user->headline}}"
                                       placeholder="IT Export" {{$errors->first('headline') ? 'autofocus' : ''}}>
                            </div>

                        </div>
                    @else
                        <div class="col-md-8">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="job_title">{{__('profile.job_title')}} </label>
                                <input class="primary_input_field" name="job_title" id="job_title"
                                       type="text" value="{{old('job_title')??@$user->job_title}}"
                                       placeholder="Ex: Sales Manager, Software Engineer" {{$errors->first('job_title') ? 'autofocus' : ''}}>
                            </div>

                        </div>
                    @endif
                </div>

                <div class="row">

                    <div class="col-md-8">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label d-flex"
                                   for="">{{__('profile.short_description') }}
                            </label>
                            <textarea id="my-textarea" class="primary_input_field short_description_field"
                                      name="short_description" style="height: 100px"
                                      rows="2">{{old("short_description")??@$user->userInfo->short_description}}</textarea>
                            <small class="required_mark_theme">"{{__('profile.short_description') }}
                                " {{__('profile.will be displayed at the bottom of your name on the profile cards. Keep it short (80 to 100 words)')}}
                                . <span class="short_description_character_count text-danger"></span></small>
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="about">{{__('profile.biography')}} </label>
                            <textarea class="lms_summernote primary_textarea4 mb-25" name="about"
                                      id="about" cols="30"
                                      rows="10">
                              {!!old('about',$user->about)!!}
                            </textarea>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-12 text-end">
                        <hr class="d-block">
                        <button class="primary-btn fix-gr-bg" type="submit"><i
                                class="ti-check"></i> {{__('common.Save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

