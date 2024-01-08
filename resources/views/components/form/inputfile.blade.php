<style>
    .image-upload-one{
    grid-area: img-u-one;
    display: flex;
    }


    .image-upload-container{
    display: grid;
    grid-template-areas: 'img-u-one img-u-two img-u-three img-u-four img-u-five img-u-six';
    }
    .center {
    display:inline;
    margin: 3px;
    }

    .form-input {
    width:100px;
    padding:3px;

    }
    .form-input input {
    display:none;
    }
    .form-input label {
    display:block;
    width:105px;
    height: auto;
    background: gray;
    max-height: 105px;

    cursor:pointer;
    }

    .form-input img {
    width:105px;
    height: 105px;
    }

    .imgRemove{
    position: relative;
    bottom: 105px;
    left: 70%;
    border: none;
    font-size: 25px;
    outline: none;
    }
    .imgRemove::after{
    content: ' \21BA';
    color: black;
    font-weight: 900;
    border-radius: 8px;
    cursor: pointer;
    }

    .small{
    color: black;
    }

    @media only screen and (max-width: 700px){
    .image-upload-container{
    grid-template-areas: 'img-u-one img-u-two img-u-three'
    'img-u-four img-u-five img-u-six';
    }
    }
</style>


<div>
    <label for="{{ $model }}" class="mb-2">{{ $label.':' }} {!! isset($required) ? '<span class="text-danger">*</span>' : ''
        !!}</label>
        <p id="mensajeError" style="color: red;"></p>
    <div class="image-upload-container">
        <div class="image-upload-one">
            <div class="center">
                <div class="form-input">
                    <label for="{{ $model }}">
                        <img id="{{ $model }}preview" src="https://i.pinimg.com/originals/6d/ff/9c/6dff9cc7feaffd490fb215bb7e059312.png">
                        <button type="button" class="imgRemove" onclick="removerimagen{{ $model }}();"></button>
                    </label>
                    @if (auth()->user()->id_empresa==33)
                    <input type="file" onchange="mostrarprevisualizacion{{ $model }}(event);" class="form-control-file @error($model) is-invalid @enderror" id="{{ $model }}" name="{{ $model }}"
                    {!! isset($required) ? 'required="required"' : '' !!} {!! isset($disabled) ? 'disabled="disabled"' : '' !!} {!!
                    isset($accept) ? "accept=\" $accept\"" : '' !!}>

                    @else
                    <input type="file" onchange="mostrarprevisualizacion{{ $model }}(event);" class="form-control-file @error($model) is-invalid @enderror" id="{{ $model }}" name="{{ $model }}"
                        {!! isset($required) ? 'required="required"' : '' !!} {!! isset($disabled) ? 'disabled="disabled"' : '' !!} {!!
                        isset($accept) ? "accept=\" $accept\"" : '' !!} {!! isset($capture) ? "capture=\" $capture\"" : '' !!}>

                    @endif
                </div>
                <small class="small"> {{ trans('messages.icono') }}  &#8634;  {{ trans('messages.remover') }}  </small>
            </div>
        </div>

    </div>
    @error($model)<span class="font-italic text-danger">{{ $message }}</span>@enderror
</div>

<script>
function mostrarprevisualizacion{{ $model }}(event){
if(event.target.files.length > 0){
let src = URL.createObjectURL(event.target.files[0]);
let preview = document.getElementById("{{ $model }}preview");
preview.src = src;
preview.style.display = "block";
}
}

function removerimagen{{ $model }}() {
document.getElementById("{{ $model }}preview").src = "https://i.pinimg.com/originals/6d/ff/9c/6dff9cc7feaffd490fb215bb7e059312.png";
document.getElementById("{{ $model }}").value = null;
}
</script>
