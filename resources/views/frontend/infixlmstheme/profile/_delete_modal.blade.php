<div class="modal fade" id="deleteModal" tabindex="-1"
     role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    {{__('common.Delete')}}</h5>
                <button type="button" class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="text-center">

                    <h3>{{__('common.Are you sure to delete ?')}} </h3>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{__('common.Cancel')}}
                </button>
                <a href="#" class="link_value theme_btn small_btn4" id="delete_confirm_btn"
                   type="button">{{__('common.Delete')}}</a>

            </div>

        </div>
    </div>
</div>


{{--<div class="modal fade" id="deleteModal" tabindex="-1"--}}
{{--     role="dialog" aria-labelledby="exampleModalCenterTitle"--}}
{{--     aria-hidden="true">--}}
{{--    <div class="modal-dialog modal-dialog-centered" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h5 class="modal-title" id="exampleModalLongTitle">--}}
{{--                    {{__('common.Delete')}}</h5>--}}
{{--                <button type="button" class="btn-close" --}}
{{--                        data-bs-dismiss="modal"--}}
{{--                        aria-label="Close">--}}
{{--                    <span aria-hidden="true">&times;</span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <form action="{{route('log.out.device')}}"--}}
{{--                  method="post">@csrf--}}
{{--                <div class="modal-body">--}}
{{--                    <input type="hidden" name="id"--}}
{{--                           value="{{$login->id}}">--}}
{{--                    <div class="col-12">--}}
{{--                        <div--}}
{{--                            class="input-group custom_group_field mb_25">--}}
{{--                            <div class="input-group-prepend">--}}
{{--                                                                            <span class="input-group-text"--}}
{{--                                                                                  id="basic-addon4">--}}
{{--                                                                                <!-- svg -->--}}
{{--                                                                                <svg xmlns="http://www.w3.org/2000/svg"--}}
{{--                                                                                     width="10.697" height="14.039"--}}
{{--                                                                                     viewBox="0 0 10.697 14.039">--}}
{{--                                                                                <path id="Path_46" data-name="Path 46"--}}
{{--                                                                                      d="M9.348,11.7A1.337,1.337,0,1,0,8.011,10.36,1.341,1.341,0,0,0,9.348,11.7ZM13.36,5.68h-.669V4.343a3.343,3.343,0,0,0-6.685,0h1.27a2.072,2.072,0,0,1,4.145,0V5.68H5.337A1.341,1.341,0,0,0,4,7.017V13.7a1.341,1.341,0,0,0,1.337,1.337H13.36A1.341,1.341,0,0,0,14.7,13.7V7.017A1.341,1.341,0,0,0,13.36,5.68Zm0,8.022H5.337V7.017H13.36Z"--}}
{{--                                                                                      transform="translate(-4 -1)"--}}
{{--                                                                                      fill="#687083"/>--}}
{{--                                                                                </svg>--}}
{{--                                                                                <!-- svg -->--}}
{{--                                                                            </span>--}}
{{--                            </div>--}}
{{--                            <input type="password" name="password"--}}
{{--                                   class="form-control"--}}
{{--                                   placeholder="{{__('common.Enter Password')}}"--}}
{{--                                   aria-label="password"--}}
{{--                                   aria-describedby="basic-addon4">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary"--}}
{{--                            data-bs-dismiss="modal">{{__('common.Close')}}--}}
{{--                    </button>--}}
{{--                    <button type="submit"--}}
{{--                            class="link_value theme_btn small_btn4">{{__('frontend.LogOut')}}</button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
