@foreach($payout_data as $data)

    <div class="row mt_20">
        <div class="col-lg-6">
            <label class="primary_label2" for="">{{$data->title}}
                <span class="required_mark">*</span></label>
            <input name="specifications[{{$data->id}}]" placeholder="-"
                   onfocus="this.placeholder = ''"
                   onblur="this.placeholder = ''"
                   class="primary_input"
                   value="{{@$payout_account_specifications[$data->id]['value']}}" type="text">

        </div>
    </div>
@endforeach
