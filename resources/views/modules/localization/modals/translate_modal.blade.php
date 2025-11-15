<div class="white-box" id="translate_modal">
    <form class="" action="{{ route('languages.key_value_store') }}" method="post">
        @csrf
        <div class="">
            <input type="hidden" name="id" value="{{ $language->id }}">
            <input type="hidden" name="translatable_file_name" value="{{ $translatable_file_name }}">
            <div class="col-lg-12 mb-2">
                <div class="d-flex">
                    <button class="primary-btn small fix-gr-bg"><i class="ti-check"></i>{{__("common.Save")}} </button>
                </div>
            </div>
        </div>
        <div class="common_QA_section QA_section_heading_custom th_padding_l0">
            <div class="QA_table ">
                <!-- table-responsive -->
                <div class="">
                    <table class="table Crm_table_active2 pt-0 shadow_none pt-0 pb-0">
                        <thead>
                        <tr>
                            <th scope="col">{{ __('common.SL') }}</th>
                            <th scope="col" class="w-50">{{ __('setting.Key') }}</th>
                            <th scope="col" class="w-50">{{ __('setting.Value') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 1
                        @endphp
                        @foreach ($languages as $key => $value)

                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $key }}</td>
                                <td>
                                    @if( is_array($value) )
                                        <table class="table pt-0 shadow_none pt-0 pb-0">
                                            <tbody>
                                            @foreach($value as $sub_key => $sub_value)
                                                <tr>
                                                    <td width="10%">{{ $sub_key }}</td>
                                                    <td>
                                                        @if( is_array($sub_value) )
                                                            <table class="table pt-0 shadow_none pt-0 pb-0">
                                                                <tbody>
                                                                @foreach($sub_value as $sub_sub_key => $sub_sub_value)
                                                                    <tr>
                                                                        <td>{{ $sub_sub_key }}</td>
                                                                        <td>
                                                                            <div class="col-lg-12">
                                                                                <input type="text" class="form-control"
                                                                                       style="width:100%"
                                                                                       name="key[{{ $key }}][{{ $sub_key }}][{{ $sub_sub_key }}]"
                                                                                       @isset($sub_sub_value)
                                                                                           value="{{ $sub_sub_value }}"
                                                                                    @endisset>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        @else

                                                            <div class="col-lg-12">
                                                                <input type="text" class="form-control"
                                                                       style="width:100%"
                                                                       name="key[{{ $key }}][{{ $sub_key }}]"
                                                                       @isset($sub_value)
                                                                           value="{{ $sub_value }}"
                                                                    @endisset>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control" style="width:100%"
                                                   name="key[{{ $key }}]" @isset($value)
                                                       value="{{ $value }}"
                                                @endisset>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @php
                                $i++
                            @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
