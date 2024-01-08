<select class="form-control" name="area" id="exampleFormControlSelect1">
    <div id="areas-div">
 @foreach ($areas as $area)
     <option value="{{$area->area_descripcion}}">{{$area->area_descripcion}}</option>
 @endforeach
    </div>
 </select>