
@foreach($payout_data as $data)
<div class="row">
    <div class="col-md-6">
        <div class="primary_input mb-25">
            <label class="primary_input_label"
                   for="">{{$data->title}} <strong
                    class="text-danger">*</strong></label>
            <input value="{{@$payout_account_specifications[$data->id]['value']}}" required class="primary_input_field" name="specifications[{{$data->id}}]"
                   type="text"  placeholder="-" >
        </div>

    </div>
</div>
@endforeach
