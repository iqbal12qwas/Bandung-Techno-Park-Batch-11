<div class="create-form">
    <div class="row">
        <!-- <div class="col-lg-6">
            <div class="form-group">
                <label for="month">Month<span style="color:#ff0000">*</span></label>
                <select type="text" class="form-control form-activity" id="month" name="month" required></select>
            </div>
        </div> -->
        <div class="col-lg-12">
            <label for="method">Method<span style="color:#ff0000">*</span></label>
            <select type="text" class="form-control form-activity" id="method" name="method" required></select>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="activity">Activity<span style="color:#ff0000">*</span></label>
                <input type="text" class="form-control form-activity" id="activity" name="activity" required>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="date_start">Date Start<span style="color:#ff0000">*</span></label>
                <input type="date" class="form-control form-activity" id="date_start" name="date_start" required
                    onBlur="changeDate()">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="date_end">Date End<span style="color:#ff0000">*</span></label>
                <input type="date" class="form-control form-activity" id="date_end" name="date_end" required>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <button type="submit" class="btn btn-primary" onClick="storeData()">Submit</button>
    </div>
</div>