@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('elibrary.E-Library')}}
@endsection
@section('css')
    <style>
        .containerFilpbook {
            height: 95vh;
            width: 100%;
            /* margin: 20px auto; */
            border: 2px solid #828bb2;
            /* box-shadow: 0 0 5px #828bb2; */
        }

        .fullscreen {
            background-color: #333;
        }
    </style>
@endsection

@section('js')

    <script src="{{ asset('Modules/ELibrary/Resources/assets/filpbook/js/libs/jquery.min.js') }}"></script>
    <script src="{{ asset('Modules/ELibrary/Resources/assets/filpbook/js/libs/html2canvas.min.js') }}"></script>
    <script src="{{ asset('Modules/ELibrary/Resources/assets/filpbook/js/libs/three.min.js') }}"></script>
    <script src="{{ asset('Modules/ELibrary/Resources/assets/filpbook/js/libs/pdf.worker.js') }}"></script>
    <script src="{{ asset('Modules/ELibrary/Resources/assets/filpbook/js/libs/pdf.min.js') }}"></script>

    <script src="{{ asset('Modules/ELibrary/Resources/assets/filpbook/js/dist/3dflipbook.js') }}"></script>
    <script src="{{ asset('Modules/ELibrary/Resources/assets/filpbook/js/dist/3dflipbook.js') }}"></script>
    <script src="{{ asset('Modules/ELibrary/Resources/assets/filpbook/index.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {


            let url = $('#baseUrl').val();
            let model_id = "{{ $model->id }}";
            $.ajax({
                type: "GET",
                data: {
                    model_id: model_id
                },
                datatype: 'json',
                url: url + '/e-library/file-path/' + model_id,
                success: function (data) {
                    filpbookView(data.model.file);
                },
                error: function () {
                    toastr.error('Something wrong');
                }
            })

            function filpbookView(filePath) {
                let url = $('#baseUrl').val();
                $('#containerFilpbook').FlipBook({
                    pdf: url + '/' + filePath,
                    template: {
                        html: url +
                            '/Modules/ELibrary/Resources/assets/filpbook/templates/default-book-view.html',
                        styles: [
                            url +
                            '/Modules/ELibrary/Resources/assets/filpbook/css/short-black-book-view.css'
                        ],
                        links: [{
                            rel: 'stylesheet',
                            href: url +
                                '/public/backend/vendors/font_awesome/css/all.min.css'
                        }],
                        script: url + '/Modules/ELibrary/Resources/assets/filpbook/js/default-book-view.js',
                        sounds: {
                            startFlip: url +
                                '/Modules/ELibrary/Resources/assets/filpbook/sounds/start-flip.mp3',
                            endFlip: url + '/Modules/ELibrary/Resources/assets/filpbook/sounds/end-flip.mp3'
                        }
                    }
                });
            }

        });
    </script>
@endsection

@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="containerFilpbook" id="containerFilpbook">

                </div>
            </div>
    </section>
@endsection
