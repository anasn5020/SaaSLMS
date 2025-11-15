@extends('backend.master')

@push('styles')
    <style>
        .UppyDragDrop {
            height: 500px;
        }

        .uppy-Dashboard-inner {
            width: 100% !important;
            height: 500px !important;
        }

        .uppy-Dashboard-AddFiles-info {
            display: none !important;
        }
    </style>
@endpush
@section('mainContent')
    {{generateBreadcrumb()}}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="mt-15 mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('setting.File Upload') }}</h4>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <form action="{{route('setting.media-manager.store')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="UppyDragDrop"></div>
                                        <div class="for-ProgressBar"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>

        let strings = {
            uploading: '{{__('setting.uploading')}}',
            cancelUpload: '{{__('setting.Cancel upload')}}',
            chooseFiles: '{{__('setting.Choose files')}}',
            addedNumFiles: '{{__('setting.Added')}} %{numFiles} {{__('setting.files')}}',
            addingMoreFiles: '{{__('setting.Adding more files')}}',
            done: '{{__('setting.Done')}}',
            complete: '{{__('setting.Complete')}}',
            addMore: '{{__('setting.Add more')}}',
            uploadComplete: '{{__('setting.Upload complete')}}',
            browseFiles: '{{__('setting.Browse Files')}}',
            dropPasteFiles: '{{__('setting.Drop files here')}} {{__('common.Or')}}  %{browseFiles}',

        };

        window.addEventListener('DOMContentLoaded', function () {
            'use strict';
            var uppy = new Uppy.Core({
                debug: true,
                autoProceed: true,
                restrictions: {
                    maxFileSize: {{getMaxUploadFileSize()}},
                    maxNumberOfFiles: 20,
                    minNumberOfFiles: 1,
                    // allowedFileTypes: ['image/*']
                }
            });
            uppy.use(Uppy.Dashboard, {
                inline: true,
                locale: {
                    strings: strings,
                },
                target: '.UppyDragDrop'
            });
            uppy.use(Uppy.ProgressBar, {
                target: '.for-ProgressBar',
                hideAfterFinish: true,
                locale: {
                    strings: strings,
                },
            });
            let store_url = '{{route('setting.media-manager.store')}}';
            let token = '{{csrf_token()}}';
            uppy.use(Uppy.XHRUpload, {
                endpoint: store_url,
                formData: true,
                fieldName: 'file',
                headers: {
                    'X-CSRF-TOKEN': token,
                },
            });

            uppy.on('upload-success', function (response) {

            });

            window.uppy = uppy;
        });
    </script>
@endpush
