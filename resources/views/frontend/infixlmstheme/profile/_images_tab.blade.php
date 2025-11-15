<div class="tab-pane fade" id="images_tab">
    <div class="row">
        <div class="col-12">

            <h3>{{__('profile.images')}}</h3>
            <hr>

            <form action="{{route('users.photo.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="profile-image-div text-center">
                            <p> {{__('common.Recommend size')}} (300 x 300) px</p>
                            <label for="profile_picture"
                                   class="profile-photo mx-auto cursor-pointer position-relative overflow-hidden mt-3 mt-md-4">
                                <img id="profile_picture_show" class="h-100 object-fit-cover w-100"
                                     src="{{getProfileImage(@$user->image,$user->name)}}" alt="Profile Photo">
                                <input type="file" class="d-none" name="profile_picture" id="profile_picture"
                                       accept=".png, .jpg, .jpeg">
                                <span
                                    class="overlay d-flex align-items-center justify-content-center fs-2 w-100 h-100 position-absolute top-0 left-0 bg-black bg-opacity-50 text-white"><i
                                        class="fa fa-camera"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="profile-image-div text-center w-100">
                            <p> {{__('common.Recommend size')}} (1920 x 500) px</p>
                            <label for="cover_photo"
                                   class="cover-photo position-relative overflow-hidden mt-3 mt-md-4 rounded-2">
                                <img id="cover_photo_show" class="h-100 object-fit-cover w-100"
                                     src="{{@$user->userInfo->cover_photo? showImage(@$user->userInfo->cover_photo):showImage(null,'cover_photo')}}"
                                     alt="Cover Photo">
                                <input type="file" class="d-none" name="cover_photo" id="cover_photo"
                                       accept=".png, .jpg, .jpeg">
                                <span
                                    class="overlay d-flex align-items-center justify-content-center fs-2 w-100 h-100 position-absolute top-0 left-0 bg-black bg-opacity-50 text-white"><i
                                        class="fa fa-camera"></i></span>
                            </label>

                            {{-- <button class="pointer-event link_value theme_btn small_btn4 mt_20" type="button">
                                <label class="currentColor fix-gr-bg cursor-pointer for_student mb-0" for="cover_photo">
                                    <i class="fas fa-arrow-up"></i> {{__('profile.select_cover_photo')}}
                                </label>
                                <input type="file" class="d-none" name="cover_photo" id="cover_photo">
                            </button> --}}
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
