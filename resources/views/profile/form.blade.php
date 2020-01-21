<div class="form-group {{ $errors->has('role') ? 'has-error' : ''}}">
    <label for="role" class="control-label">{{ 'Role' }}</label>
    <input class="form-control" name="role" type="text" id="role" value="{{ isset($profile->role) ? $profile->role : ''}}" >
    {!! $errors->first('role', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_id" class="control-label">{{ 'UserId' }}</label>
    <input class="form-control" name="user_id" type="number" id="user_id" value="{{ isset($profile->user_id) ? $profile->user_id : ''}}" >
    {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('lineid') ? 'has-error' : ''}}">
    <label for="lineid" class="control-label">{{ 'LineId' }}</label>
    <input class="form-control" name="lineid" type="number" id="lineid" value="{{ isset($profile->lineid) ? $profile->lineid : ''}}" >
    {!! $errors->first('lineid', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('photo') ? 'has-error' : ''}}">
    <label for="photo" class="control-label">{{ 'Photo' }}</label>
    <input class="form-control" name="photo" type="file" id="photo" value="{{ isset($profile->photo) ? $profile->photo : ''}}" >
    {!! $errors->first('photo', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
