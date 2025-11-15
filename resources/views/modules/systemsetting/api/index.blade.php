@extends('backend.master')

@section('mainContent')

    {!! generateBreadcrumb() !!}


    <section class="mb-20 student-details">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="row">
                    <div class="col-lg-12">

                       @include('systemsetting::api.partials._nav')

                        <!-- Tab panes -->
                        <div class="tab-content">

                            @include('systemsetting::api.partials._lms_key')
                            @include('systemsetting::api.partials._google_map')
                            @include('systemsetting::api.partials._google_fonts')
                            @include('systemsetting::api.partials._fixer')
                            @include('systemsetting::api.partials._exchangeer')
                            @include('systemsetting::api.partials._fcm')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        $(document).on("click", "#confirmBtn", function (e) {
            e.preventDefault();
            let key = $('#inputKey').val();
            $('#appKeyUpdateInput').val(key);
            $('#AppKeyModal').modal('show');
        });

        $(document).on("click", "#generateNewKey", function (e) {

            let key = $('#inputKey');
            let possible = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

            let generate_key = '';
            for (let i = 0; i < 64; i++) {
                generate_key += possible.charAt(Math.floor(Math.random() * possible.length));
            }

            key.val(generate_key)
        });


    </script>
@endpush

