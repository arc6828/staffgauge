<div class="form-group {{ $errors->has('json') ? 'has-error' : ''}}">
    <label for="json" class="control-label">{{ 'Json' }}</label>
    <textarea class="form-control" rows="5" name="json" type="textarea" id="json" >{{ isset($mylogocr->json) ? $mylogocr->json : ''}}</textarea>
    {!! $errors->first('json', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
