<label class="primary_checkbox" for="question{{$query->id}}">
    <input type="checkbox" name="questions[]"
           id="question{{$query->id}}" value="{{$query->id}}"
           class="common-checkbox question">
    <span class="checkmark"></span>
</label>
