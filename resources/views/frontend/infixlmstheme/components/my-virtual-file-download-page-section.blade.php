<div class="main_content_iner main_content_padding">
    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-12">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{__('product.Virtual Files')}}</h3>
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
                                            <th scope="col">{{__('common.SL')}}</th>
                                            <th scope="col">{{__('common.Total Courses')}}
                                                / {{ __('product.Products') }}</th>
                                            <th scope="col">{{__('common.Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($packages))
                                            @foreach ($packages as $key=> $product)
                                                <tr>
                                                    <td scope="row">{{$key+1}}</td>
                                                    <td>{{@$product->course->title}}</td>
                                                    <td>
                                                        @if ($product->course->product?->soft_file)
                                                            <a href="@if (isset($product->course->product?->soft_file)) {{ route('downloadVirtualFile', [$product->course->slug]) }} @else javascript:void(0) @endif"
                                                               class="link_value theme_btn small_btn4">{{__('product.Download')}}</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
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
