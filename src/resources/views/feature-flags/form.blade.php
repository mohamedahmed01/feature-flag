<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $featureFlag->name ?? '') }}" required>
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" id="description" name="description">{{ old('description', $featureFlag->description ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="enabled">Enabled</label>
    <select class="form-control" id="enabled" name="enabled">
        <option value="1" {{ (old('enabled', $featureFlag->enabled ?? '') == 1) ? 'selected' : '' }}>Yes</option>
        <option value="0" {{ (old('enabled', $featureFlag->enabled ?? '') == 0) ? 'selected' : '' }}>No</option>
    </select>
</div>

<div class="form-group">
    <label for="audience">Audience</label>
    <input type="text" class="form-control" id="audience" name="audience" value="{{ old('audience', json_encode($featureFlag->audience ?? '')) }}">
</div>

<div class="form-group">
    <label for="percentage">Percentage</label>
    <input type="number" class="form-control" id="percentage" name="percentage" value="{{ old('percentage', $featureFlag->percentage ?? '') }}" required>
</div>

<div class="form-group">
    <label for="finish_date">Finish Date</label>
    <input type="date" class="form-control" id="finish_date" name="finish_date" value="{{ old('finish_date', $featureFlag->finish_date ?? '') }}">
</div>
