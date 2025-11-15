<form action="{{ route('validateGenerateSubmit') }}" method="post">
    @csrf
    <input type="text" name="field" value="{{ $field ?? '' }}" placeholder="Field">
    <input type="text" name="rules" value="{{ $rules ?? '' }}" placeholder="rules">
    <input type="submit" value="Submit">
</form>

@if(isset($arr) and count($arr))

    @foreach($arr as $key => $value)
        '{{ $key }}' => '{{$value}}', <br>
    @endforeach
@endif
