<div class="edit-form">
    <div class="row">
        <div class="col-lg-12">
            <label for="method">Method<span style="color:#ff0000">*</span></label>
            <select type="text" class="form-control form-activity" id="method" name="method" required>
                @foreach($data_method as $item)
                <option value="{{ $item->id }}" {{ $item->id == $data->id_methods ? 'selected' : '' }}>
                    {{ $item->name }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="activity">Activity<span style="color:#ff0000">*</span></label>
                <input type="text" class="form-control form-activity" id="activity" name="activity"
                    value="{{ $data->activity }}" required>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="date_start">Date Start<span style="color:#ff0000">*</span></label>
                <input type="date" class="form-control form-activity" id="date_start" name="date_start"
                    value="{{ $data->date_start }}" required onBlur="changeDate()">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="date_end">Date End<span style="color:#ff0000">*</span></label>
                <input type="date" class="form-control form-activity" id="date_end" name="date_end"
                    value="{{ $data->date_end }}" required>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <button type="submit" class="btn btn-primary" onClick="update({{ $data->id }})">Update</button>
    </div>
</div>