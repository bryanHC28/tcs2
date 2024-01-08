

<select class="form-control" name="subcategoria" id="exampleFormControlSelect1">
   <div id="subcategoria-div">
    @foreach ($subcategorias as $subcategoria)
    <option value="{{$subcategoria->descripcion_subcategoria}}">{{$subcategoria->descripcion_subcategoria}}</option>
@endforeach
   </div>
</select>