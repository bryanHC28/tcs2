<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div>
    <label for="{{ $model }}" class="mb-2">{{ $label.':' }} {!! isset($required) ? '<span class="text-danger">*</span>' : '' !!}</label>
    <input
        type="{{ isset($type) ? $type : 'text' }}"
        class="form-control @error($model) is-invalid @enderror"
        id="{{ $model }}"
        name="{{ $model }}"
        value="{{ old($model, isset($value) ? $value : '') }}"
        {!! isset($placeholder) ? "placeholder=\"$placeholder...\"" : '' !!}
        {!! isset($required) ? 'required="required"' : '' !!}
        {!! isset($readonly) ? 'readonly="readonly"' : '' !!}
        {!! isset($disabled) ? 'disabled="disabled"' : '' !!}
        {!! isset($accept) ? "accept=\"$accept\"" : '' !!}
        {!! isset($min) ? "min=\"$min\"" : '' !!}
    >
    @error($model)<span class="font-italic text-danger">{{ $message }}</span>@enderror

    <style>
        #{{ $model }}:enabled {
            color: black;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        input[type="date"]::-webkit-calendar-picker-indicator{
            cursor: pointer;
            background: transparent;
            color: transparent;
            position: absolute;
            height: auto;
            width: auto;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }
    </style>
</div>
