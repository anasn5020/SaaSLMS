<div class="tab-pane fade" id="social_tab">
    <div class="row">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center">
                <h3>{{__('profile.social_and_contact')}}</h3>
            </div>
            <hr>
            <form action="{{route('users.social_info.update')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="facebook">{{__('common.Facebook URL')}} </label>
                            <input class="primary_input_field" name="facebook" id="facebook"
                                   value="{{@$user->facebook}}" placeholder="-" type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="twitter">{{__('common.Twitter URL')}} </label>
                            <input class="primary_input_field" name="twitter" id="twitter"
                                   value="{{@$user->twitter}}" placeholder="-" type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="linkedin">{{__('common.LinkedIn URL')}} </label>
                            <input class="primary_input_field" name="linkedin" id="linkedin"
                                   value="{{@$user->linkedin}}" placeholder="-" type="text">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="instagram">{{__('common.Instagram URL')}} </label>
                            <input class="primary_input_field" name="instagram" id="instagram"
                                   value="{{@$user->instagram}}" placeholder="-" type="text">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 d-flex align-items-center">
                        <div class="">
                            <h4 class="text-nowrap">{{__('profile.Instant_messaging')}}</h4>
                        </div>
                        <div class="custom-hr">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 mt-repeater no-extra-space">

                        <div data-repeater-list="instant_messaging">
                            @foreach($instant_messages as $i_msg)
                                <div data-repeater-item class="mt-repeater-item">

                                    <div class="mt-repeater-row">

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="service"> {{__('profile.service')}} </label>
                                                    <input name="service" value="{{$i_msg->service}}"
                                                           class="primary_input_field service" placeholder="Ex: Skype"
                                                           type="text">
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="username"> {{__('profile.username')}}  </label>
                                                    <input name="username" value="{{$i_msg->username}}"
                                                           class="primary_input_field username" placeholder="Ex: jon"
                                                           type="text">
                                                </div>
                                            </div>


                                            <div class="col-lg-1">
                                                <div class="position-relative form-group ">
                                                    <a href="javascript:void(0);" data-repeater-delete
                                                       class="primary-btn small icon-only fix-gr-bg mt-35  mt-repeater-delete">
                                                        <i class="fas fa-trash m-0"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div data-repeater-item class="mt-repeater-item">

                                <div class="mt-repeater-row">

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="service"> {{__('profile.service')}} </label>
                                                <input name="service" class="primary_input_field service"
                                                       placeholder="Ex: Skype" type="text">
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="username"> {{__('profile.username')}}  </label>
                                                <input name="username" class="primary_input_field username"
                                                       placeholder="Ex: jon" type="text">
                                            </div>


                                        </div>


                                        <div class="col-lg-1">
                                            <div class="position-relative form-group ">
                                                <a href="javascript:void(0);" data-repeater-delete
                                                   class="primary-btn small icon-only fix-gr-bg mt-35  mt-repeater-delete">
                                                    <i class="fas fa-trash m-0"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <a href="javascript:void(0);" data-repeater-create
                                   class="primary-btn radius_30px  fix-gr-bg mt-repeater-add "><i
                                        class="fa fa-plus"></i>{{__('common.Add More')}}</a>
                            </div>
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
