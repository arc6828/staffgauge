<div class="form-group {{ $errors->has('photo') ? 'has-error' : ''}}">
    <label for="photo" class="control-label">{{ 'Photo' }}</label>
    <input class="form-control" name="photo" type="file" id="photo" value="{{ isset($ocr->photo) ? $ocr->photo : ''}}" required>
    {!! $errors->first('photo', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
    <label for="content" class="control-label">{{ 'Extract Data' }}</label>
    <textarea class="form-control" rows="5" name="content" type="textarea" id="content" {{ $formMode === 'edit' ? '' : 'readonly' }}>{{ isset($ocr->content) ? $ocr->content : ''}}</textarea>
    {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Level' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ isset($ocr->title) ? $ocr->title : ''}}"  {{ $formMode === 'edit' ? '' : 'readonly' }}>
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
