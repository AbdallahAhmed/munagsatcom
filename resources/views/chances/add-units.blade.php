<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label
                            for="input-number">{{ trans("chances::units.unit") }}</label>
                    <select name="units[]" class="form-control chosen-select chosen-rtl">
                        @if($units)
                            @foreach($units as $unit)
                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                            @endforeach
                        @else
                            <option value="">{{ trans("chances::units.no_records") }}</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label
                            for="input-number">{{ trans("chances::chances.attributes.quantity") }}</label>
                    <input name="units_quantity[]" type="text"
                           value=""
                           class="form-control" id="input-name"
                           placeholder="{{ trans("chances::chances.attributes.quantity") }}">
                </div>
            </div>
        </div>
    </div>
    <button id="add-unit" class="btn btn-primary"><i class="fa fa-plus"></i></button>
</div>