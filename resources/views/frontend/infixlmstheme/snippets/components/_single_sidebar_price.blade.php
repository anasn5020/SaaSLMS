<ul class="Check_sidebar">
    <li>
        <label class="primary_checkbox d-flex">
            <input type="checkbox" class="price"
                   value="paid" {{in_array("paid",explode(',',request('price')))?'checked':''}}>
            <span class="checkmark mr_15"></span>
            <span class="label_name">{{__('frontend.Paid')}}</span>
        </label>
    </li>
    <li>
        <label class="primary_checkbox d-flex">
            <input type="checkbox" class="price"
                   value="free" {{in_array("free",explode(',',request('price')))?'checked':''}}>
            <span class="checkmark mr_15"></span>
            <span class="label_name">{{__('frontend.Free')}}</span>
        </label>
    </li>
</ul>
