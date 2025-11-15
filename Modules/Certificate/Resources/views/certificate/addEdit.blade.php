<div class="col-lg-4" id="certificateForm">

    <form
        @if (isset($certificate))
            class="form-horizontal certificateForm" method="POST"
        action="{{ route('certificate.update', $certificate->id) }}" enctype="multipart/form-data"
        id="question_bank">

        @else
            @if (permissionCheck('certificate.create'))
                class="form-horizontal certificateForm" method="POST" action="{{ route('certificate.store') }}"
                enctype="multipart/form-data" id="question_bank">
            @endif
        @endif
        @csrf
        @method('POST')
        <input type="hidden" name="certificate_id" id="certificate_id"
               value="{{ isset($certificate) ? $certificate->id : '' }}">
        <input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">
        <div class="white-box p-0">
            <div class="add-visitor certificate">
                <div class="row p-3">
                    <div class="col-xl-12">
                        <div class="primary_input">
                            <label class="primary_input_label"
                                   for="">{{ __('certificate.Background Image') }} <strong
                                    class="text-danger">*</strong>
                                <small>(<strong>{{ __('certificate.Max Limit:1MB') }}</strong>)</small>
                            </label>
                            <div class="primary_file_uploader">
                                <input class="primary-input x filePlaceholder" type="text"
                                       placeholder="{{ isset($certificate) && $certificate->image ? showPicName($certificate->image) : __('certificate.Browse Image file') }}"
                                       readonly="" {{ $errors->has('image') ? ' autofocus' : '' }}>
                                <button class="" type="button">
                                    <label class="primary-btn small fix-gr-bg"
                                           for="bgImage">{{ __('common.Browse') }}</label>
                                    <input type="file" onchange="setBgImage()" id="bgImage"
                                           class="d-none fileUpload" name="image">
                                </button>
                            </div>
                            <small>
                                ({{ __('certificate.Recommend Size 1300x910 px') }})
                            </small>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-0 p-3">
                    <div class="col-md-12">
                        <label class="primary_input_label" for="">
                            {{ __('certificate.Show Title') }}</label>
                    </div>
                    <div class="col-md-6 mb-25">
                        <label for="show_title_yes" class="primary_checkbox d-flex mr-12">
                            <input onclick="getNew()" type="radio" class="common-checkbox show_title"
                                   name="show_title" id="show_title_yes" checked value="1"
                                {{ isset($certificate) && $certificate->show_title == 1 ? 'checked' : '' }}>
                            <span class="checkmark me-2"></span> {{ __('certificate.Yes') }}</label>
                    </div>
                    <div class="col-md-6 mb-25">
                        <label for="show_title_no" class="primary_checkbox d-flex mr-12">
                            <input onclick="getNew()" type="radio" class="common-checkbox show_title"
                                   name="show_title" id="show_title_no" value="0"
                                {{ isset($certificate) && $certificate->show_title != 1 ? 'checked' : '' }}>

                            <span class="checkmark me-2"></span> {{ __('certificate.No') }}</label>
                    </div>
                </div>
                <div class="row mt-0 p-3">

                    <div class="col-lg-12">

                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Title') }} </label>
                            <input type="text" {{ $errors->has('title') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Title') }}"
                                   class="primary_input_field title change-input {{ $errors->has('title') ? ' is-invalid' : '' }}"
                                   name="title" id="title"
                                   value="{{ isset($certificate) ? $certificate->title : (old('title') != '' ? old('title') : '') }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('title'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('title') }}</strong></span>
                            @endif

                        </div>


                    </div>
                </div>
                <div class="row mt-0 p-3">


                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position X') }} </label>
                            <input type="number" required
                                   {{ $errors->has('title_position_x') ? ' autofocus' : '' }}
                                   placeholder="{{ __('certificate.Position Y') }}" id="title_position_x"
                                   class="primary_input_field change-input title_position_x {{ $errors->has('position_x_title') ? ' is-invalid' : '' }}"
                                   name="title_position_x"
                                   value="{{ isset($certificate) ? $certificate->title_position_x : (old('title_position_x') != '' ? old('title_position_x') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('title_position_x'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('title_position_x') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position Y') }} </label>
                            <input type="number" required
                                   {{ $errors->has('title_position_y') ? ' autofocus' : '' }}
                                   placeholder="{{ __('certificate.Position X') }}" id="title_position_y"
                                   class="primary_input_field title_position_y change-input {{ $errors->has('title_position_y') ? ' is-invalid' : '' }}"
                                   name="title_position_y"
                                   value="{{ isset($certificate) ? $certificate->title_position_y : (old('title_position_y') != '' ? old('title_position_y') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('title_position_y'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('title_position_y') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-0 p-3">
                    <div class="col-md-12">
                        <div class="input-effect">
                            <label
                                class="primary_input_label mt-1"> {{ __('certificate.Font Family') }} </label>
                            <select class="primary_select title_font_family" onchange="getNew()"
                                    id="title_font_family" name="title_font_family">
                                @foreach ($font_list as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ isset($certificate) ? ($certificate->title_font_family == $key ? 'selected' : '') : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('title_font_family'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('title_font_family') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Font Size') }} </label>
                            <input type="number" required placeholder="{{ __('certificate.Font Size') }}"
                                   class="primary_input_field title_font_size change-input {{ $errors->has('title_font_size') ? ' is-invalid' : '' }}"
                                   name="title_font_size" id="title_font_size"
                                   {{ $errors->has('title_font_size') ? ' autofocus' : '' }}
                                   value="{{ isset($certificate) ? $certificate->title_font_size : (old('title_font_size') != '' ? old('title_font_size') : 30) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('title_font_size'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('title_font_size') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Font Color') }} </label>
                            <input type="color" required
                                   class="primary_input_field change-input title_font_color {{ $errors->has('title_font_color') ? ' is-invalid' : '' }}"
                                   name="title_font_color" id="title_font_color"
                                   {{ $errors->has('title_font_color') ? ' autofocus' : '' }}
                                   value="{{ isset($certificate) ? $certificate->title_font_color : (old('title_font_color') != '' ? old('title_font_color') : '#383CC1') }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('title_font_color'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('title_font_color') }}</strong></span>
                            @endif
                        </div>

                    </div>
                </div>

                @if (isModuleActive('Org'))
                    <hr>
                    <div class="row mt-0 p-3">
                        <div class="col-md-12">
                            <label class="primary_input_label" for="">
                                {{ __('certificate.Show Org Chart Name') }}</label>
                        </div>
                        <div class="col-md-6 mb-25">
                            <label for="show_org_chart_yes" class="primary_checkbox d-flex mr-12">
                                <input onclick="getNew()" type="radio" class="common-checkbox show_org_chart"
                                       name="show_org_chart" id="show_org_chart_yes" checked value="1"
                                    {{ isset($certificate) && $certificate->show_org_chart == 1 ? 'checked' : '' }}>
                                <span class="checkmark me-2"></span> {{ __('certificate.Yes') }}</label>
                        </div>
                        <div class="col-md-6 mb-25">
                            <label for="show_org_chart_no" class="primary_checkbox d-flex mr-12">
                                <input onclick="getNew()" type="radio" class="common-checkbox show_org_chart"
                                       name="show_org_chart" id="show_org_chart_no" value="0"
                                    {{ isset($certificate) && $certificate->show_org_chart != 1 ? 'checked' : '' }}>

                                <span class="checkmark me-2"></span> {{ __('certificate.No') }}</label>
                        </div>
                    </div>

                    <div class="row mt-0 p-3">


                        <div class="col-lg-6">
                            <div class="input-effect">
                                <label
                                    class="primary_input_label mt-1"> {{ __('certificate.Position X') }} </label>
                                <input type="number" required placeholder="{{ __('certificate.Position Y') }}"
                                       id="org_chart_x"
                                       class="primary_input_field change-input org_chart_x {{ $errors->has('position_x_title') ? ' is-invalid' : '' }}"
                                       name="org_chart_x"
                                       value="{{ isset($certificate) ? $certificate->org_chart_x : (old('org_chart_x') != '' ? old('org_chart_x') : 0) }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-effect">
                                <label
                                    class="primary_input_label mt-1"> {{ __('certificate.Position Y') }} </label>
                                <input type="number" required placeholder="{{ __('certificate.Position X') }}"
                                       id="org_chart_y"
                                       class="primary_input_field org_chart_y change-input {{ $errors->has('org_chart_y') ? ' is-invalid' : '' }}"
                                       name="org_chart_y"
                                       value="{{ isset($certificate) ? $certificate->org_chart_y : (old('org_chart_y') != '' ? old('org_chart_y') : 0) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-0 p-3">
                        <div class="col-md-12">
                            <div class="input-effect">
                                <label
                                    class="primary_input_label mt-1"> {{ __('certificate.Font Family') }} </label>
                                <select class="primary_select title_font_family" onchange="getNew()"
                                        id="org_chart_font_family" name="org_chart_font_family">
                                    @foreach ($font_list as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ isset($certificate) ? ($certificate->org_chart_font_family == $key ? 'selected' : '') : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-0 p-3">
                        <div class="col-lg-6">
                            <div class="input-effect">
                                <label
                                    class="primary_input_label mt-1"> {{ __('certificate.Font Size') }} </label>
                                <input type="number" required placeholder="{{ __('certificate.Font Size') }}"
                                       class="primary_input_field org_chart_font_size change-input {{ $errors->has('org_chart_font_size') ? ' is-invalid' : '' }}"
                                       name="org_chart_font_size" id="org_chart_font_size"
                                       {{ $errors->has('org_chart_font_size') ? ' autofocus' : '' }}
                                       value="{{ isset($certificate) ? $certificate->org_chart_font_size : (old('org_chart_font_size') != '' ? old('org_chart_font_size') : 20) }}">

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-effect">
                                <label
                                    class="primary_input_label mt-1"> {{ __('certificate.Font Color') }} </label>
                                <input type="color" required
                                       class="primary_input_field change-input org_chart_font_color {{ $errors->has('org_chart_font_color') ? ' is-invalid' : '' }}"
                                       name="org_chart_font_color" id="org_chart_font_color"
                                       {{ $errors->has('org_chart_font_color') ? ' autofocus' : '' }}
                                       value="{{ isset($certificate) ? $certificate->org_chart_font_color : (old('org_chart_font_color') != '' ? old('org_chart_font_color') : '#383CC1') }}">
                                <span class="focus-border textarea"></span>
                                @if ($errors->has('org_chart_font_color'))
                                    <span
                                        class="error text-danger"><strong>{{ $errors->first('org_chart_font_color') }}</strong></span>
                                @endif
                            </div>

                        </div>
                    </div>
                @endif
                <hr>
                @if (isModuleActive('CPD') || isModuleActive('Membership'))
                    <div class="row mt-0 p-3">
                        <div class="col-lg-12">
                            <div class="input-effect">
                                <label
                                    class="primary_input_label mt-1"> {{ __('certificate.Certificate Type') }} </label>

                                <ul>
                                    <li class="mt-2"><label class="primary_checkbox d-flex mr-12">
                                            <input type="radio" class="courseCheckbox certificateType"
                                                   id="courseCheckbox"
                                                   name="type"
                                                   value="course" {{ isset($certificate) ? ($certificate->type == null || $certificate->type=='course' ) ? 'checked':'':'checked' }}>
                                            <span class="checkmark me-2"></span> {{ __('courses.Course') }}
                                        </label></li>
                                    @if (isModuleActive('CPD'))
                                        <li class="mt-2"><label class="primary_checkbox d-flex mr-12">
                                                <input type="radio" class="cpdCheckbox certificateType"
                                                       id="cpdCheckbox"
                                                       name="type"
                                                       value="cpd" {{ isset($certificate) ? $certificate->type == 'cpd' ? 'checked':'':'' }}>
                                                <span class="checkmark me-2"></span> {{ __('cpd.CPD') }}
                                            </label></li>
                                    @endif
                                    @if (isModuleActive('Membership'))
                                        <li class="mt-2"><label class="primary_checkbox d-flex mr-12">
                                                <input type="radio" class="membershipCheckbox certificateType"
                                                       id="membershipCheckbox" name="type" value="membership"
                                                    {{ isset($certificate) ? $certificate->type == 'membership' ? 'checked':'':'' }} >
                                                <span class="checkmark me-2"></span>
                                                {{ __('membership.Membership') }}
                                            </label></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row mt-0 p-3">
                    <div class="col-lg-12">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Body') }} </label>
                            <textarea
                                {{ $errors->has('body') ? ' autofocus' : '' }} placeholder="{{ __('certificate.Body') }}"
                                class=" change-input form-control {{ $errors->has('body') ? ' is-invalid' : '' }}"
                                id="body" rows="5"
                                name="body">{{ isset($certificate) ? $certificate->body : (old('body') != '' ? old('body') : '') }}</textarea>
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('body'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('body') }}</strong></span>
                            @endif
                        </div>
                        <a href="javascript:void(0)" class="" id="forCourse">[name] [course] [instructor]</a>
                        <a href="javascript:void(0)" class="d-none" id="forCpd">[name] [cpd]</a>
                        <a href="javascript:void(0)" class="d-none" id="forMembership">[name] [plan][level]</a>
                    </div>
                </div>
                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position X') }} </label>
                            <input type="number" {{ $errors->has('x_portion') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Position X') }}"
                                   class="primary_input_field change-input body_position_x {{ $errors->has('body_position_x') ? ' is-invalid' : '' }}"
                                   name="body_position_x" id="body_position_x"
                                   value="{{ isset($certificate) ? $certificate->body_position_x : (old('body_position_x') != '' ? old('body_position_x') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('body_position_x'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('body_position_x') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position Y') }} </label>
                            <input type="number" {{ $errors->has('y_portion') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Position X') }}"
                                   class="primary_input_field body_position_y change-input {{ $errors->has('body_position_y') ? ' is-invalid' : '' }}"
                                   name="body_position_y" id="body_position_y"
                                   value="{{ isset($certificate) ? $certificate->body_position_y : (old('body_position_y') != '' ? old('body_position_y') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('body_position_y'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('body_position_y') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-0 p-3">
                    <div class="col-md-7">
                        <div class="input-effect">
                            <label
                                class="primary_input_label mt-1"> {{ __('certificate.Font Family') }} </label>
                            <select class="primary_select body_font_family" onchange="getNew()"
                                    id="body_font_family" name="body_font_family">
                                @foreach ($font_list as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ isset($certificate) ? ($certificate->body_font_family == $key ? 'selected' : '') : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('body_font_family'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('body_font_family') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Max Length') }} </label>
                            <input type="number" min="1"
                                   class="primary_input_field change-input body_max_len {{ $errors->has('body_max_len') ? ' is-invalid' : '' }}"
                                   name="body_max_len" id="body_max_len"
                                   {{ $errors->has('body_max_len') ? ' autofocus' : '' }}
                                   value="{{ isset($certificate) ? $certificate->body_max_len : (old('body_max_len') != '' ? old('body_max_len') : 80) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('body_max_len'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('body_max_len') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Font Size') }} </label>
                            <input type="number" required placeholder="{{ __('certificate.Font Size') }}"
                                   class="primary_input_field change-input body_font_size {{ $errors->has('body_font_size') ? ' is-invalid' : '' }}"
                                   name="body_font_size" id="body_font_size"
                                   {{ $errors->has('body_font_size') ? ' autofocus' : '' }}
                                   value="{{ isset($certificate) ? $certificate->body_font_size : (old('body_font_size') != '' ? old('body_font_size') : 25) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('body_font_size'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('body_font_size') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Font Color') }} </label>
                            <input type="color" required
                                   class="primary_input_field change-input body_font_color {{ $errors->has('body_font_color') ? ' is-invalid' : '' }}"
                                   name="body_font_color" id="body_font_color"
                                   {{ $errors->has('body_font_color') ? ' autofocus' : '' }}
                                   value="{{ isset($certificate) ? $certificate->body_font_color : (old('body_font_color') != '' ? old('body_font_color') : '#383CC1') }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('body_font_color'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('body_font_color') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>


                <hr>
                <div class="row mt-0 p-3">
                    <div class="col-md-12">
                        <label class="primary_input_label" for="">
                            {{ __('certificate.Student Name') }}</label>
                    </div>
                    <div class="col-md-6 mb-25">
                        <label for="yes2" class="primary_checkbox d-flex mr-12">
                            <input onclick="getNew()" type="radio" checked class="common-checkbox name"
                                   name="name" id="yes2" value="1"
                                {{ isset($certificate) && $certificate->name == 1 ? 'checked' : '' }}>
                            <span class="checkmark me-2"></span> {{ __('certificate.Yes') }}
                        </label>
                    </div>
                    <div class="col-md-6 mb-25">
                        <label for="no2" class="primary_checkbox d-flex mr-12">
                            <input onclick="getNew()" type="radio" class="common-checkbox name" name="name"
                                   id="no2" value="0"
                                {{ isset($certificate) && $certificate->name != 1 ? 'checked' : '' }}>
                            <span class="checkmark me-2"></span> {{ __('certificate.No') }}</label>
                    </div>
                </div>

                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position X') }} </label>
                            <input type="number" {{ $errors->has('name_position_x') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Position X') }}"
                                   class="primary_input_field change-input date_position_x {{ $errors->has('name_position_x') ? ' is-invalid' : '' }}"
                                   name="name_position_x" id="name_position_x"
                                   value="{{ isset($certificate) ? $certificate->name_position_x : (old('name_position_x') != '' ? old('name_position_x') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('name_position_x'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('name_position_x') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position Y') }} </label>
                            <input type="number" {{ $errors->has('name_position_y') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Position Y') }}"
                                   class="primary_input_field  change-input  name_position_y {{ $errors->has('name_position_y') ? ' is-invalid' : '' }}"
                                   name="name_position_y" id="name_position_y"
                                   value="{{ isset($certificate) ? $certificate->name_position_y : (old('name_position_y') != '' ? old('name_position_y') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('name_position_y'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('name_position_y') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mt-0 p-3">
                    <div class="col-md-12">
                        <div class="input-effect">
                            <label
                                class="primary_input_label mt-1"> {{ __('certificate.Font Family') }} </label>
                            <select class="primary_select name_font_family" onchange="getNew()"
                                    id="name_font_family" name="name_font_family">
                                @foreach ($font_list as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ isset($certificate) ? ($certificate->name_font_family == $key ? 'selected' : '') : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('name_font_family'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('name_font_family') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Font Size') }} </label>
                            <input type="number" required placeholder="{{ __('certificate.Font Size') }}"
                                   class="primary_input_field name_font_size change-input {{ $errors->has('name_font_size') ? ' is-invalid' : '' }}"
                                   name="name_font_size" id="name_font_size"
                                   {{ $errors->has('name_font_size') ? ' autofocus' : '' }}
                                   value="{{ isset($certificate) ? $certificate->name_font_size : (old('name_font_size') != '' ? old('name_font_size') : 50) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('name_font_size'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('name_font_size') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Font Color') }} </label>
                            <input type="color" required
                                   class="primary_input_field change-input name_font_color  {{ $errors->has('name_font_color') ? ' is-invalid' : '' }}"
                                   name="name_font_color" id="name_font_color"
                                   {{ $errors->has('font_color') ? ' autofocus' : '' }}
                                   value="{{ isset($certificate) ? $certificate->name_font_color : (old('name_font_color') != '' ? old('name_font_color') : '#383CC1') }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('name_font_color'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('name_font_color') }}</strong></span>
                            @endif
                        </div>

                    </div>
                </div>
                <hr>

                <div class="row mt-0 p-3">
                    <div class="col-md-12 ">
                        <label class="primary_input_label" for="">
                            {{ __('certificate.Student Image') }}</label>
                    </div>
                    <div class="col-md-6 mb-25">
                        <label for="yes" class="primary_checkbox d-flex mr-12">
                            <input onclick="getNew()" type="radio" class="common-checkbox profile"
                                   name="profile" id="yes" checked value="1"
                                {{ isset($certificate) && $certificate->profile == 1 ? 'checked' : '' }}>
                            <span class="checkmark me-2"></span> {{ __('certificate.Yes') }}</label>
                    </div>
                    <div class="col-md-6 mb-25">
                        <label for="no" class="primary_checkbox d-flex mr-12">
                            <input onclick="getNew()" type="radio" class="common-checkbox profile"
                                   name="profile" id="no" value="0"
                                {{ isset($certificate) && $certificate->profile != 1 ? 'checked' : '' }}>

                            <span class="checkmark me-2"></span> {{ __('certificate.No') }}</label>
                    </div>
                </div>
                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position X') }} </label>
                            <input type="number" {{ $errors->has('profile_x') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Position X') }}"
                                   class="primary_input_field change-input profile_x {{ $errors->has('profile_x') ? ' is-invalid' : '' }}"
                                   name="profile_x" id="profile_x"
                                   value="{{ isset($certificate) ? $certificate->profile_x : (old('profile_x') != '' ? old('profile_x') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('profile_x'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('profile_x') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position Y') }} </label>
                            <input type="number" {{ $errors->has('y_portion') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Position Y') }}"
                                   class="primary_input_field  change-input  profile_y {{ $errors->has('profile_y') ? ' is-invalid' : '' }}"
                                   name="profile_y" id="profile_y"
                                   value="{{ isset($certificate) ? $certificate->profile_y : (old('profile_y') != '' ? old('profile_y') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('profile_y'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('profile_y') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label
                                class="primary_input_label mt-1"> {{ __('certificate.Image Height') }} </label>
                            <input type="number" required {{ $errors->has('image_height') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Image Height') }}"
                                   class="primary_input_field change-input profile_height {{ $errors->has('profile_height') ? ' is-invalid' : '' }}"
                                   name="profile_height" id="profile_height"
                                   value="{{ isset($certificate) ? $certificate->profile_height : (old('profile_height') != '' ? old('profile_height') : 120) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('profile_height'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('profile_height') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label
                                class="primary_input_label mt-1"> {{ __('certificate.Image Weight') }} </label>
                            <input type="number" required
                                   {{ $errors->has('profile_weight') ? ' autofocus' : '' }}
                                   placeholder="{{ __('certificate.Image Weight') }}" id="profile_weight"
                                   class="primary_input_field change-input profile_weight {{ $errors->has('profile_weight') ? ' is-invalid' : '' }}"
                                   name="profile_weight"
                                   value="{{ isset($certificate) ? $certificate->profile_weight : (old('profile_weight') != '' ? old('profile_weight') : 120) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('profile_weight'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('profile_weight') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>


                {{-- Start QR Section --}}
                <hr>
                <div class="row mt-0 p-3">
                    <div class="col-md-12">
                        <label class="primary_input_label" for="">
                            {{ __('certificate.Show QR') }}</label>
                    </div>
                    <div class="col-md-6 mb-25">
                        <label for="qr_yes" class="primary_checkbox d-flex mr-12">
                            <input onclick="getNew()" type="radio" class="common-checkbox qr" name="qr"
                                   id="qr_yes" checked value="1"
                                {{ isset($certificate) && $certificate->qr == 1 ? 'checked' : '' }}>
                            <span class="checkmark me-2"></span> {{ __('certificate.Yes') }}</label>
                    </div>
                    <div class="col-md-6 mb-25">
                        <label for="qr_no" class="primary_checkbox d-flex mr-12">
                            <input onclick="getNew()" type="radio" class="common-checkbox qr" name="qr"
                                   id="qr_no" value="0"
                                {{ isset($certificate) && $certificate->qr != 1 ? 'checked' : '' }}>

                            <span class="checkmark me-2"></span> {{ __('certificate.No') }}</label>
                    </div>
                </div>

                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position X') }} </label>
                            <input type="number" {{ $errors->has('qr_x') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Position X') }}"
                                   class="primary_input_field change-input qr_x {{ $errors->has('qr_x') ? ' is-invalid' : '' }}"
                                   name="qr_x" id="qr_x"
                                   value="{{ isset($certificate) ? $certificate->qr_x : (old('qr_x') != '' ? old('qr_x') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('qr_x'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('qr_x') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position Y') }} </label>
                            <input type="number" {{ $errors->has('qr_y') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Position Y') }}"
                                   class="primary_input_field  change-input  qr_y {{ $errors->has('qr_y') ? ' is-invalid' : '' }}"
                                   name="qr_y" id="qr_y"
                                   value="{{ isset($certificate) ? $certificate->qr_y : (old('qr_y') != '' ? old('qr_y') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('qr_y'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('qr_y') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label
                                class="primary_input_label mt-1"> {{ __('certificate.Image Height') }} </label>
                            <input type="number" required {{ $errors->has('qr_height') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Image Height') }}"
                                   class="primary_input_field change-input qr_height {{ $errors->has('qr_height') ? ' is-invalid' : '' }}"
                                   name="qr_height" id="qr_height"
                                   value="{{ isset($certificate) ? $certificate->qr_height : (old('qr_height') != '' ? old('qr_height') : 120) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('qr_height'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('qr_height') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label
                                class="primary_input_label mt-1"> {{ __('certificate.Image Weight') }} </label>
                            <input type="number" required {{ $errors->has('qr_weight') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Image Weight') }}" id="qr_weight"
                                   class="primary_input_field change-input qr_weight {{ $errors->has('qr_weight') ? ' is-invalid' : '' }}"
                                   name="qr_weight"
                                   value="{{ isset($certificate) ? $certificate->qr_weight : (old('qr_weight') != '' ? old('qr_weight') : 120) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('qr_weight'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('qr_weight') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Start Certificate Number Section --}}
                <hr>
                <div class="row mt-0 p-3">
                    <div class="col-md-12">
                        <label class="primary_input_label" for="">
                            {{ __('certificate.Certificate Number Show') }}</label>
                    </div>
                    <div class="col-md-6 mb-25">
                        <label for="yes12" class="primary_checkbox d-flex mr-12">
                            <input onclick="getNew()" type="radio" checked
                                   class="common-checkbox certificate_no" name="certificate_no" id="yes12"
                                   value="1"
                                {{ isset($certificate) && $certificate->certificate_no == 1 ? 'checked' : '' }}>
                            <span class="checkmark me-2"></span> {{ __('certificate.Yes') }}</label>
                    </div>
                    <div class="col-md-6 mb-25">
                        <label for="no12" class="primary_checkbox d-flex mr-12">
                            <input onclick="getNew()" type="radio" class="common-checkbox certificate_no"
                                   name="certificate_no" id="no12" value="0"
                                {{ isset($certificate) && $certificate->certificate_no != 1 ? 'checked' : '' }}>
                            <span class="checkmark me-2"></span> {{ __('certificate.No') }}</label>
                    </div>
                </div>

                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position X') }} </label>
                            <input type="number" {{ $errors->has('profile_x') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Position X') }}"
                                   class="primary_input_field change-input certificate_no_position_x {{ $errors->has('certificate_no_position_x') ? ' is-invalid' : '' }}"
                                   name="certificate_no_position_x" id="certificate_no_position_x"
                                   value="{{ isset($certificate) ? $certificate->certificate_no_position_x : (old('certificate_no_position_x') != '' ? old('certificate_no_position_x') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('certificate_no_position_x'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('certificate_no_position_x') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position Y') }} </label>
                            <input type="number" {{ $errors->has('y_portion') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Position Y') }}"
                                   class="primary_input_field  change-input  certificate_no_position_y {{ $errors->has('certificate_no_position_y') ? ' is-invalid' : '' }}"
                                   name="certificate_no_position_y" id="certificate_no_position_y"
                                   value="{{ isset($certificate) ? $certificate->certificate_no_position_y : (old('certificate_no_position_y') != '' ? old('certificate_no_position_y') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('certificate_no_position_y'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('certificate_no_position_y') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label
                                class="primary_input_label mt-1"> {{ __('certificate.Certificate Pre Text') }} </label>
                            <input type="text"
                                   {{ $errors->has('certificate_number_prefix') ? ' autofocus' : '' }}
                                   placeholder="{{ __('certificate.Certificate Pre Text') }}"
                                   class="primary_input_field  change-input  certificate_number_prefix {{ $errors->has('certificate_number_prefix') ? ' is-invalid' : '' }}"
                                   name="certificate_number_prefix" id="certificate_number_prefix"
                                   value="{{ isset($certificate) ? $certificate->certificate_number_prefix : (old('certificate_number_prefix') != '' ? old('certificate_number_prefix') : '') }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('certificate_number_prefix'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('certificate_number_prefix') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-effect">
                            <label
                                class="primary_input_label mt-1"> {{ __('certificate.Font Family') }} </label>
                            <select class="primary_select certificate_no_font_family" onchange="getNew()"
                                    id="certificate_no_font_family" name="certificate_no_font_family">
                                @foreach ($font_list as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ isset($certificate) ? ($certificate->certificate_no_font_family == $key ? 'selected' : '') : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('certificate_no_font_family'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('certificate_no_font_family') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Font Size') }} </label>
                            <input type="number" required placeholder="{{ __('certificate.Font Size') }}"
                                   class="primary_input_field certificate_no_font_size change-input {{ $errors->has('certificate_no_font_size') ? ' is-invalid' : '' }}"
                                   name="certificate_no_font_size" id="certificate_no_font_size"
                                   {{ $errors->has('certificate_no_font_size') ? ' autofocus' : '' }}
                                   value="{{ isset($certificate) ? $certificate->certificate_no_font_size : (old('certificate_no_font_size') != '' ? old('certificate_no_font_size') : 25) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('certificate_no_font_size'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('certificate_no_font_size') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Font Color') }} </label>
                            <input type="color" required
                                   class="primary_input_field change-input certificate_no_font_color  {{ $errors->has('certificate_no_font_color') ? ' is-invalid' : '' }}"
                                   name="certificate_no_font_color" id="certificate_no_font_color"
                                   {{ $errors->has('font_color') ? ' autofocus' : '' }}
                                   value="{{ isset($certificate) ? $certificate->certificate_no_font_color : (old('certificate_no_font_color') != '' ? old('certificate_no_font_color') : '#383CC1') }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('certificate_no_font_color'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('certificate_no_font_color') }}</strong></span>
                            @endif
                        </div>

                    </div>
                </div>

                <hr>
                <div class="row mt-0 p-3">
                    <div class="col-md-12">
                        <label class="primary_input_label" for="">
                            {{ __('certificate.Date Show') }}</label>
                    </div>
                    <div class="col-md-6 mb-25">
                        <label for="yes1" class="primary_checkbox d-flex mr-12">
                            <input onclick="getNew()" type="radio" checked class="common-checkbox date"
                                   name="date" id="yes1" value="1"
                                {{ isset($certificate) && $certificate->date == 1 ? 'checked' : '' }}>
                            <span class="checkmark me-2"></span> {{ __('certificate.Yes') }}</label>
                    </div>
                    <div class="col-md-6 mb-25">
                        <label for="no1" class="primary_checkbox d-flex mr-12">
                            <input onclick="getNew()" type="radio" class="common-checkbox date" name="date"
                                   id="no1" value="0"
                                {{ isset($certificate) && $certificate->date != 1 ? 'checked' : '' }}>
                            <span class="checkmark me-2"></span> {{ __('certificate.No') }}</label>
                    </div>
                </div>

                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position X') }} </label>
                            <input type="number" {{ $errors->has('profile_x') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Position X') }}"
                                   class="primary_input_field change-input date_position_x {{ $errors->has('date_position_x') ? ' is-invalid' : '' }}"
                                   name="date_position_x" id="date_position_x"
                                   value="{{ isset($certificate) ? $certificate->date_position_x : (old('date_position_x') != '' ? old('date_position_x') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('date_position_x'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('date_position_x') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position Y') }} </label>
                            <input type="number" {{ $errors->has('y_portion') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Position Y') }}"
                                   class="primary_input_field  change-input  date_position_y {{ $errors->has('date_position_y') ? ' is-invalid' : '' }}"
                                   name="date_position_y" id="date_position_y"
                                   value="{{ isset($certificate) ? $certificate->date_position_y : (old('date_position_y') != '' ? old('date_position_y') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('date_position_y'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('date_position_y') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mt-0 p-3">
                    <div class="col-md-12">
                        <div class="input-effect">
                            <label
                                class="primary_input_label mt-1"> {{ __('certificate.Font Family') }} </label>
                            <select class="primary_select date_font_family" onchange="getNew()"
                                    id="date_font_family" name="date_font_family">
                                @foreach ($font_list as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ isset($certificate) ? ($certificate->date_font_family == $key ? 'selected' : '') : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('date_font_family'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('date_font_family') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Font Size') }} </label>
                            <input type="number" required placeholder="{{ __('certificate.Font Size') }}"
                                   class="primary_input_field date_font_size change-input {{ $errors->has('date_font_size') ? ' is-invalid' : '' }}"
                                   name="date_font_size" id="date_font_size"
                                   {{ $errors->has('date_font_size') ? ' autofocus' : '' }}
                                   value="{{ isset($certificate) ? $certificate->date_font_size : (old('date_font_size') != '' ? old('date_font_size') : 25) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('date_font_size'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('date_font_size') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Font Color') }} </label>
                            <input type="color" required
                                   class="primary_input_field change-input date_font_color  {{ $errors->has('date_font_color') ? ' is-invalid' : '' }}"
                                   name="date_font_color" id="date_font_color"
                                   {{ $errors->has('font_color') ? ' autofocus' : '' }}
                                   value="{{ isset($certificate) ? $certificate->date_font_color : (old('date_font_color') != '' ? old('date_font_color') : '#383CC1') }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('date_font_color'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('date_font_color') }}</strong></span>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="row mt-0 p-3">
                    <div class="col-md-12">
                        <div class="input-effect">
                            <label
                                class="primary_input_label mt-1"> {{ __('certificate.Date Format') }} </label>
                            <select class="primary_select date_format" onchange="getNew()" id="date_format"
                                    name="date_format">
                                @foreach ($formats as $key => $format)
                                    <option value="{{ $format->id }}"
                                        {{ isset($certificate) ? ($certificate->date_format == $format->id ? 'selected' : '') : '' }}>
                                        {{ $format->normal_view }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('date_format'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('date_format') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row mt-0 p-3">

                    <div class="col-xl-12">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">{{ __('certificate.Signature') }}
                                <small>(<strong>{{ __('certificate.Max Limit:500KB') }}</strong>)</small>
                            </label>
                            <div class="primary_file_uploader">
                                <input class="primary-input filePlaceholder change-input" type="text"
                                       placeholder="{{ isset($certificate) && $certificate->signature ? showPicName($certificate->signature) : __('certificate.Browse Image file') }}"
                                       readonly="" {{ $errors->has('image') ? ' autofocus' : '' }}>
                                <button class="" type="button">
                                    <label class="primary-btn small fix-gr-bg"
                                           for="signatureImage">{{ __('common.Browse') }}</label>
                                    <input type="file" id="signatureImage" onchange="setSigImage()"
                                           class="d-none fileUpload" name="signature">
                                </button>
                            </div>
                            <small>
                                ({{ __('certificate.Recommend Size 170x100 px') }})
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position X') }} </label>
                            <input type="number" {{ $errors->has('signature_position_x') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Position X') }}"
                                   class="primary_input_field change-input signature_position_x {{ $errors->has('signature_position_x') ? ' is-invalid' : '' }}"
                                   name="signature_position_x" id="signature_position_x"
                                   value="{{ isset($certificate) ? $certificate->signature_position_x : (old('signature_position_x') != '' ? old('signature_position_x') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('signature_position_x'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('signature_position_x') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position Y') }} </label>
                            <input type="number" {{ $errors->has('signature_position_y') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Position Y') }}"
                                   class="primary_input_field  change-input  signature_position_y {{ $errors->has('signature_position_y') ? ' is-invalid' : '' }}"
                                   name="signature_position_y" id="signature_position_y"
                                   value="{{ isset($certificate) ? $certificate->signature_position_y : (old('signature_position_y') != '' ? old('signature_position_y') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('profile_y'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('signature_position_y') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label
                                class="primary_input_label mt-1"> {{ __('certificate.Image Height') }} </label>
                            <input type="number" required
                                   {{ $errors->has('signature_height') ? ' autofocus' : '' }}
                                   placeholder="{{ __('certificate.Image Height') }}"
                                   class="primary_input_field change-input signature_height {{ $errors->has('signature_height') ? ' is-invalid' : '' }}"
                                   name="signature_height" id="signature_height"
                                   value="{{ isset($certificate) ? $certificate->signature_height : (old('signature_height') != '' ? old('signature_height') : 100) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('signature_height'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('signature_height') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label
                                class="primary_input_label mt-1"> {{ __('certificate.Image Weight') }} </label>
                            <input type="number" required
                                   {{ $errors->has('signature_weight') ? ' autofocus' : '' }}
                                   placeholder="{{ __('certificate.Image Weight') }}"
                                   class="primary_input_field change-input signature_weight {{ $errors->has('signature_weight') ? ' is-invalid' : '' }}"
                                   name="signature_weight" id="signature_weight"
                                   value="{{ isset($certificate) ? $certificate->signature_weight : (old('signature_weight') != '' ? old('signature_weight') : 200) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('signature_weight'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('signature_weight') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-0 p-3">
                    <div class="col-lg-12">

                        <div class="input-effect">
                            <label
                                class="primary_input_label mt-1"> {{ __('certificate.Footer') }} {{ __('certificate.Title') }} </label>
                            <input type="text" {{ $errors->has('signature_text') ? ' autofocus' : '' }}
                            placeholder="{{ __('certificate.Title') }}"
                                   class="primary_input_field signature_text change-input {{ $errors->has('signature_text') ? ' is-invalid' : '' }}"
                                   name="signature_text" id="signature_text"
                                   value="{{ isset($certificate) ? $certificate->signature_text : (old('signature_text') != '' ? old('signature_text') : 'Administrator') }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('signature_text'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('signature_text') }}</strong></span>
                            @endif

                        </div>


                    </div>
                </div>
                <div class="row mt-0 p-3">


                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position X') }} </label>
                            <input type="number" required
                                   {{ $errors->has('signature_text_position_x') ? ' autofocus' : '' }}
                                   placeholder="{{ __('certificate.Position Y') }}"
                                   id="signature_text_position_x"
                                   class="primary_input_field change-input signature_text_position_x {{ $errors->has('signature_text_position_x') ? ' is-invalid' : '' }}"
                                   name="signature_text_position_x"
                                   value="{{ isset($certificate) ? $certificate->signature_text_position_x : (old('signature_text_position_x') != '' ? old('signature_text_position_x') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('signature_text_position_x'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('signature_text_position_x') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Position Y') }} </label>
                            <input type="number" required
                                   {{ $errors->has('signature_text_position_y') ? ' autofocus' : '' }}
                                   placeholder="{{ __('certificate.Position X') }}"
                                   id="signature_text_position_y"
                                   class="primary_input_field signature_text_position_y change-input {{ $errors->has('signature_text_position_y') ? ' is-invalid' : '' }}"
                                   name="signature_text_position_y"
                                   value="{{ isset($certificate) ? $certificate->signature_text_position_y : (old('signature_text_position_y') != '' ? old('signature_text_position_y') : 0) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('signature_text_position_y'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('signature_text_position_y') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-0 p-3">
                    <div class="col-md-12">
                        <div class="input-effect">
                            <label
                                class="primary_input_label mt-1"> {{ __('certificate.Font Family') }} </label>
                            <select class="primary_select signature_text_font_family"
                                    id="signature_text_font_family" onchange="getNew()"
                                    name="signature_text_font_family">
                                @foreach ($font_list as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ isset($certificate) ? ($certificate->signature_text_font_family == $key ? 'selected' : '') : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('signature_text_font_family'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('signature_text_font_family') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mt-0 p-3">
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Font Size') }} </label>
                            <input type="number" required id="signature_text_font_size"
                                   placeholder="{{ __('certificate.Font Size') }}"
                                   class="primary_input_field signature_text_font_size change-input {{ $errors->has('signature_text_font_size') ? ' is-invalid' : '' }}"
                                   name="signature_text_font_size"
                                   {{ $errors->has('signature_text_font_size') ? ' autofocus' : '' }}
                                   value="{{ isset($certificate) ? $certificate->signature_text_font_size : (old('signature_text_font_size') != '' ? old('signature_text_font_size') : 30) }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('signature_text_font_size'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('signature_text_font_size') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{ __('certificate.Font Color') }} </label>
                            <input type="color" required id="signature_text_font_color"
                                   class="primary_input_field change-input signature_text_font_color {{ $errors->has('signature_text_font_color') ? ' is-invalid' : '' }}"
                                   name="signature_text_font_color"
                                   {{ $errors->has('signature_text_font_color') ? ' autofocus' : '' }}
                                   value="{{ isset($certificate) ? $certificate->signature_text_font_color : (old('signature_text_font_color') != '' ? old('signature_text_font_color') : '#383CC1') }}">
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('signature_text_font_color'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('signature_text_font_color') }}</strong></span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <div class="row mx-0   pb-30">
                <div class="col-lg-12 px-3 text-center">

                    <button type="submit" class="primary-btn fix-gr-bg" data-bs-toggle="tooltip">
                        <i class="ti-check"></i>
                        @if (isset($certificate))
                            {{ __('common.Update') }}
                        @else
                            {{ __('common.Save') }}
                        @endif
                        {{ __('certificate.Certificate') }}
                    </button>
                </div>
            </div>

        </div>

        <input type="hidden" id="makeURL" value="{{ route('certificate.make') }}">
        <input type="hidden" id="uploadURL" value="{{ route('certificate.upload') }}">
        <input type="hidden" id="bgImageInput" value="">
        <input type="hidden" id="sigImageInput" value="">
        <input type="hidden" id="org_module" value="{{ isModuleActive('Org') ? 1 : 0 }}">
    </form>

</div>
