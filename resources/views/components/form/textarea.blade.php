<div>
    <label for="{{ $model }}" class="mb-2">{{ $label.':' }} {!! isset($required) ? '<span class="text-danger">*</span>' : '' !!}</label>
    <textarea
        id="{{ $model }}"
        name="{{ $model }}"
        class="form-control @error($model) is-invalid @enderror"
        rows="{{ $rows ?? '2' }}"
        {!! isset($placeholder) ? "placeholder=\"$placeholder...\"" : '' !!}
        {!! isset($required) ? 'required="required"' : '' !!}
        {!! isset($readonly) ? 'readonly="readonly"' : '' !!}
        {!! isset($disabled) ? 'disabled="disabled"' : '' !!}
    >{!!  old($model, $slot) !!}</textarea>
    @error($model)<span class="font-italic text-danger">{{ $message }}</span>@enderror
</div>
