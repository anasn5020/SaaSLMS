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
                    <div class="col-lg-6">
                        <label class="primary_label2" for="facebook">{{__('common.Facebook URL')}}</label>
                        <input id="facebook" name="facebook" placeholder="{{__('common.Facebook URL')}}"
                               onfocus="this.placeholder = ''"
                               onblur="this.placeholder = '{{__('common.Facebook URL')}}'"
                               class="primary_input" {{$errors->first('facebook') ? 'autofocus' : ''}}
                               value="{{@$user->facebook}}" type="text">
                        <span class="text-danger" role="alert">{{$errors->first('facebook')}}</span>
                    </div>
                </div>

                <div class="row mt_20">
                    <div class="col-lg-6">
                        <label class="primary_label2" for="twitter">{{__('common.Twitter URL')}}</label>
                        <input id="twitter" name="twitter" placeholder="{{__('common.Twitter URL')}}"
                               onfocus="this.placeholder = ''"
                               onblur="this.placeholder = '{{__('common.Twitter URL')}}'"
                               class="primary_input" {{$errors->first('twitter') ? 'autofocus' : ''}}
                               value="{{@$user->twitter}}" type="text">
                        <span class="text-danger" role="alert">{{$errors->first('twitter')}}</span>
                    </div>
                </div>

                <div class="row mt_20">
                    <div class="col-lg-6">
                        <label class="primary_label2" for="linkedin">{{__('common.LinkedIn URL')}}</label>
                        <input id="linkedin" name="linkedin" placeholder="{{__('common.LinkedIn URL')}}"
                               onfocus="this.placeholder = ''"
                               onblur="this.placeholder = '{{__('common.LinkedIn URL')}}'"
                               class="primary_input" {{$errors->first('linkedin') ? 'autofocus' : ''}}
                               value="{{@$user->linkedin}}" type="text">
                        <span class="text-danger" role="alert">{{$errors->first('linkedin')}}</span>
                    </div>
                </div>


                <div class="row mt_20">
                    <div class="col-lg-6">
                        <label class="primary_label2" for="instagram">{{__('common.Youtube URL')}}</label>
                        <input id="youtube" name="youtube" placeholder="{{__('common.Youtube URL')}}"
                               onfocus="this.placeholder = ''"
                               onblur="this.placeholder = '{{__('common.Youtube URL')}}'"
                               class="primary_input" {{$errors->first('youtube') ? 'autofocus' : ''}}
                               value="{{@$user->youtube}}" type="text">
                        <span class="text-danger" role="alert">{{$errors->first('youtube')}}</span>
                    </div>
                </div>

                <div class="row mt_20">
                    <div class="col-lg-6">
                        <label class="primary_label2" for="instagram">{{__('common.Instagram URL')}}</label>
                        <input id="instagram" name="instagram" placeholder="{{__('common.Instagram URL')}}"
                               onfocus="this.placeholder = ''"
                               onblur="this.placeholder = '{{__('common.Instagram URL')}}'"
                               class="primary_input" {{$errors->first('instagram') ? 'autofocus' : ''}}
                               value="{{@$user->instagram}}" type="text">
                        <span class="text-danger" role="alert">{{$errors->first('instagram')}}</span>
                    </div>
                </div>


                <div class="row mt_20">
                    <div class="col-md-12 d-flex align-items-center">
                        <div class="">
                            <h4 class="text-nowrap">{{__('profile.Instant_messaging')}}</h4>
                        </div>
                        <div class="custom-hr ms-2">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 mt-repeater no-extra-space">

                        <div data-repeater-list="instant_messaging">
                            @foreach($instant_messages as $i_msg)
                                <div data-repeater-item class="mt-repeater-item">

                                    <div class="mt-repeater-row">

                                        <div class="row mt_20">
                                            <div class="col-lg-4">
                                                <label class="primary_label2" for=""> {{__('profile.service')}}</label>
                                                <input name="service" placeholder="Ex: Skype"
                                                       onfocus="this.placeholder = ''"
                                                       onblur="this.placeholder = 'Ex: Skype'"
                                                       class="primary_input service"
                                                       value="{{$i_msg->service}}" type="text">
                                            </div>

                                            <div class="col-lg-4">
                                                <label class="primary_label2" for=""> {{__('profile.username')}}</label>
                                                <input name="username" placeholder="Ex: jon"
                                                       onfocus="this.placeholder = ''"
                                                       onblur="this.placeholder = 'Ex: jon'"
                                                       class="primary_input username"
                                                       value="{{$i_msg->username}}" type="text">
                                            </div>


                                            <div class="col-lg-1">
                                                <div class="position-relative form-group ">
                                                    <a href="javascript:void(0);" data-repeater-delete
                                                       class="link_value theme_btn small_btn4 mt_32  mt-repeater-delete">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div data-repeater-item class="mt-repeater-item">

                                <div class="mt-repeater-row">

                                    <div class="row mt_20">

                                        <div class="col-lg-4">
                                            <label class="primary_label2" for=""> {{__('profile.service')}}</label>
                                            <input name="service" placeholder="Ex: Skype"
                                                   onfocus="this.placeholder = ''"
                                                   onblur="this.placeholder = 'Ex: Skype'"
                                                   class="primary_input service"
                                                   type="text">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="primary_label2" for=""> {{__('profile.username')}}</label>
                                            <input name="username" placeholder="Ex: jon"
                                                   onfocus="this.placeholder = ''"
                                                   onblur="this.placeholder = 'Ex: jon'"
                                                   class="primary_input username"
                                                   type="text">
                                        </div>


                                        <div class="col-lg-1">
                                            <div class="position-relative form-group ">
                                                <a href="javascript:void(0);" data-repeater-delete
                                                   class="link_value theme_btn small_btn4 icon-only  mt_32  mt-repeater-delete">
                                                    <i class="fas fa-trash"></i>
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
                                   class="link_value theme_btn small_btn4 radius_30px  mt-repeater-add "><i
                                        class="fa fa-plus me-1"></i>{{__('common.Add More')}}</a>
                            </div>
                        </div>
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
