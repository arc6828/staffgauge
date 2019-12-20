<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
    <label for="address" class="control-label">{{ 'Address' }}</label>
    <input class="form-control" name="address" type="text" id="address" value="{{ isset($location->address) ? $location->address : ''}}" required>
    {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('latitude') ? 'has-error' : ''}}">
    <label for="latitude" class="control-label">{{ 'Latitude' }}</label>
    <input class="form-control" name="latitude" type="text" id="latitude" value="{{ isset($location->latitude) ? $location->latitude : ''}}" required>
    {!! $errors->first('latitude', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('longitude') ? 'has-error' : ''}}">
    <label for="longitude" class="control-label">{{ 'Longitude' }}</label>
    <input class="form-control" name="longitude" type="text" id="longitude" value="{{ isset($location->longitude) ? $location->longitude : ''}}"  required>
    {!! $errors->first('longitude', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('typegroup') ? 'has-error' : ''}}">
    <label for="typegroup" class="control-label">{{ 'TypeGroup' }}</label>
    <input class="form-control" name="typegroup" type="text" id="typegroup" value="{{ isset($location->typegroup) ? $location->typegroup : ''}}"  required>
    {!! $errors->first('typegroup', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('lineid') ? 'has-error' : ''}}">
    <label for="lineid" class="control-label">{{ 'LineId' }}</label>
    <input class="form-control" name="lineid" type="text" id="lineid" value="{{ isset($location->lineid) ? $location->lineid : ''}}"  required>
    {!! $errors->first('lineid', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>