@extends('backend.master')
@push('styles')
@endpush
@section('mainContent')
    {!! generateBreadcrumb() !!}


    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="media_box box_shadow_white p-0">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form action="" method="GET"
                                              class=" row">
                                            <div class="col-md-3">
                                                <h4 class="flex-fill mt-4">{{__('common.All')}} {{__('common.Files')}} </h4>
                                            </div>
                                            <div class=" col-md-9 p-0 float-end">
                                                <div
                                                    class=" d-flex align-content-center justify-content-md-end flex-wrap filter-elements">
                                                    <div class="primary_input m-2 ">
                                                        <select class="primary_select changeOrder" name="sort"
                                                                id="status">
                                                            <option value="newest"
                                                                    @if(request('sort')== 'newest') selected @endif>{{ __('common.Sort by newest') }}</option>
                                                            <option value="oldest"
                                                                    @if(request('sort')== 'oldest') selected @endif>{{ __('common.Sort by oldest') }}</option>
                                                            <option value="smallest"
                                                                    @if(request('sort')== 'smallest') selected @endif>{{ __('common.Sort by smallest') }}</option>
                                                            <option value="biggest"
                                                                    @if(request('sort')== 'biggest') selected @endif>{{ __('common.Sort by biggest') }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="primary_input  m-2">
                                                        <input class="primary_input_field bg-white"
                                                               name="search" placeholder="{{__('common.Search')}}"
                                                               type="text"
                                                               value="{{request('search')}}">
                                                    </div>
                                                    <button
                                                        class="primary-btn  m-2  fix-gr-bg cusrve_30px w_160 text-nowrap">
                                                        <i
                                                            class="ti-search"></i>{{__('common.Search')}} </button>
                                                </div>

                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="infixlms_file_wrapper row">
                                    @forelse($files as $file)
                                        <div class="col-xxl-3 col-xl-4 col-sm-6">
                                            <div class="infixlms_file_box">
                                                <div class="form-check d-none bulk_delete_checkbox float-end">
                                                    <label class="primary_checkbox d-flex">
                                                        <input type="checkbox" name="bulk_select[]"
                                                               class="attr_checkbox"
                                                               value="{{$file->id}}">
                                                        <span class="checkmark mr_10"></span>
                                                    </label>
                                                </div>
                                                <div class="infixlms_file_body">
                                                    <div class="img-box position-relative">
                                                        <div class="gallery_action position-absolute">
                                                            <a data-value="{{$file}}" class="details_info"
                                                               data-bs-toggle="tooltip" title="Info"><i
                                                                    class="ti-info-alt"></i></a>

                                                            <a href="{{$file->storage=='local'?asset($file->file_name):$file->file_name}}"
                                                               download data-bs-toggle="tooltip" title="Download"><i
                                                                    class="ti-download"></i></a>
                                                            <a href="{{$file->storage=='local'?asset($file->file_name):$file->file_name}}"
                                                               class="copy_link" data-bs-toggle="tooltip"
                                                               title="Copy Link"><i
                                                                    class="ti-layers"></i></a>
                                                            <a data-url="{{route('setting.media-manager.delete', $file->id)}}"
                                                               class="delete_file" data-bs-toggle="tooltip"
                                                               title="Delete"><i
                                                                    class="ti-trash"></i></a>
                                                        </div>
                                                        <img
                                                            src="{{$file->storage=='local'?showPreview($file->file_name,$file->type):$file->file_name}}"
                                                            alt="">
                                                    </div>
                                                    <div class="infixlms_file_content-box">
                                                        <div class="file-content-wrapper">
                                                            <h5>{{$file->original_name}}</h5>
                                                            <p>{{$file->size}} {{__('common.KB')}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <h3 class="">{{trans('common.No files found')}}</h3>
                                    @endforelse

                                </div>
                                <div class="row">
                                    <div class="col-lg-12">

                                        {{ $files->appends(Request::all())->onEachSide(1)->links('setting::storage.partials.paginate') }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('backend.partials.delete_modal')
            @include('setting::storage.partials._info_modal')
            @endsection
            @push('scripts')
                <script>
                    $(document).ready(function () {
                        $(document).on('change', '.changeOrder', function (event) {
                            event.preventDefault();
                            $(this).closest('form').submit();
                        });
                        $(document).on('click', '.delete_file', function (event) {
                            event.preventDefault();
                            let url = $(this).data('url');
                            confirm_modal(url);
                        });
                        $(document).on('click', '#delete_link', function () {
                            $('.preloader').removeClass('d-none');
                            $('#confirm-delete').modal('hide');
                        });
                        $(document).on('click', '.details_info', function (event) {
                            event.preventDefault();
                            let data = $(this).data('value');
                            if (data) {
                                $('#show_name').text(data.original_name);
                                $('#show_extension').text(data.extension);
                                $('#show_size').text(data.size + ' kb');
                                $('#show_storage').text(data.storage);
                                $('#single_image_div').removeClass('d-none');
                                var imag = data.file_name;
                                if (data.type == 'image') {
                                    if (data.storage == 'local') {
                                        $('#show_path').text('{{url('')}}' + '/' + data.file_name);
                                        var image_path = "{{asset( '/')}}" + "/" + imag;
                                        document.getElementById('view_image').src = image_path;
                                    } else {
                                        $('#show_path').text(data.file_name);
                                        document.getElementById('view_image').src = imag;
                                    }
                                } else {
                                    if (data.storage == 'local') {
                                        $('#show_path').text('{{url('')}}' + '/' + data.file_name);
                                    } else {
                                        $('#show_path').text(data.file_name);
                                    }
                                    document.getElementById('view_image').src = "{{asset( '/')}}" + "public/preview/" + data.type + ".png";
                                }

                                $('#item_show').modal('show');
                                z
                            }
                        });

                        $('.copy_link').click(function (e) {
                            e.preventDefault();
                            var copyText = $(this).attr('href');

                            document.addEventListener('copy', function (e) {
                                e.clipboardData.setData('text/plain', copyText);
                                e.preventDefault();
                            }, true);

                            document.execCommand('copy');
                            toastr.success('{{__('frontend.Link copied to clipboard')}}');
                        });

                        $('#bulk_select').click(function (e) {
                            e.preventDefault();
                            $('.bulk_delete_checkbox').removeClass('d-none');
                        });

                        $('input[type="checkbox"]').change(function () {
                            var arr = $.map($('input:checkbox:checked'), function (e, i) {
                                return +e.value;
                            });
                            if (arr.length > 0) {
                                $('#bulk_delete').removeClass('d-none');
                                $('#bulk_select').addClass('d-none');
                            }
                            if (arr.length == 0) {
                                $('#bulk_delete').addClass('d-none');
                                $('#bulk_select').removeClass('d-none');
                                $('.bulk_delete_checkbox').addClass('d-none');
                            }
                        });
                    });
                </script>
    @endpush
