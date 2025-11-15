@props([
    'has_label'=>true,
    'label' => __('common.Image File'), 'message',
    'multiple' =>'false',
    'type' =>'',
    'name' =>'image',
    'note'=>'',
    'required'=>'false',
    'media_id'=>null
    ])


<div class="primary_input single-uploader">
    @if($has_label)
        <label class="primary_input_label"
               for="">{{$label}} @if($required=='true')
                <span class="required_mark"> *</span>
            @endif
        </label>
    @endif
    <div class="primary_file_uploader" data-bs-toggle="infixUploader"
         data-multiple="{{$multiple}}" data-type="{{$type}}"
         data-name="{{$name}}">
        <input class="primary-input file_amount" type="text"
               id="file_{{$name}}"
               placeholder="{{trans('common.Browse') }}"
               readonly="">
        <button class="" type="button">
            <label class="primary-btn small fix-gr-bg"
                   for="file_{{$name}}"
            >{{__('common.Browse') }} </label>
            <input type="hidden"
                   class="selected_files"
                   value="{{@$media_id}}">
        </button>
    </div>
    <div class="product_image_all_div">
        @if(@$media_id)
            <input type="hidden" name="{{$name}}" class="" value="{{@$media_id}}">
        @endif
    </div>
    @if(!empty($note))
        <p class="image_size">{{$note}}</p>
    @endif
</div>
