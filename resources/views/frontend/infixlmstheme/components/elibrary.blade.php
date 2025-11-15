<div class="main_content_iner main_content_padding">
    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-12">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{ __('elibrary.Ebook List') }}</h3>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="table-responsive">
                                    <table class="table custom_table3 mb-0">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('common.SL') }}</th>
                                            <th scope="col">{{ __('common.Name') }}</th>
                                            <th scope="col">{{ __('cpd.Created Date') }}</th>
                                            <th scope="col">{{ __('elibrary.Author Name') }}</th>
                                            <th scope="col">{{ __('elibrary.Publisher Name') }}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @if (isset($ebooks))
                                            @forelse ($ebooks as $key => $ebook)
                                                <tr>
                                                    <td scope="row">{{ $key + 1 }}</td>
                                                    <td>{{ $ebook->name }}</td>
                                                    <td>{{ showDate($ebook->created_at) }}</td>
                                                    <td>{{ $ebook->author_name }} </td>
                                                    <td>{{ $ebook->publisher_name }} </td>

                                                    <td>
                                                        @if($ebook->file)
                                                            <a href="{{ route('e-library.file', [$ebook->id]) }}"
                                                               class="link_value theme_btn small_btn4">{{ __('elibrary.Book View') }}</a>
                                                        @endif
                                                    </td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-center"
                                                        colspan="6">{{__('common.No data available in the table')}}</td>
                                                </tr>
                                            @endforelse
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
