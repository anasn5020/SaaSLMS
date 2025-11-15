@foreach($result as $cat)
    <li>
        <label class="primary_checkbox d-flex">
            <input type="checkbox" value="{{$cat->id}}"
                   class="category" {{in_array($cat->id,explode(',',$result))?'checked':''}}>
            <span class="checkmark mr_15"></span>
            <span class="label_name">{{$cat->title}}</span>
        </label>
    </li>
@endforeach
