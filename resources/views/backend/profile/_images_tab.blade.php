<div class="tab-pane fade" id="images_tab">
    <div class="row">
        <div class="col-12">

            <h3>{{__('profile.images')}}</h3>
            <hr>

            <form action="{{route('users.photo.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <x-upload-file
                            name="profile_picture"
                            type="image"
                            media_id="{{$user->image_media?->media_id??0}}"
                            label="{{ __('common.Image') }}"
                            note="{{__('student.Recommended size')}} (330x400)"
                        />


                    </div>
                    <div class="col-md-6">
                        <x-upload-file
                            name="cover_photo"
                            type="image"
                            media_id="{{$user->userInfo->cover_photo_media?->media_id??0}}"
                            label="{{ __('profile.select_cover_photo') }}"
                            note="{{__('student.Recommended size')}} (1920x500)"
                        />


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
