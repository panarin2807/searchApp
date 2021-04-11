<div class="form-group row">
    <label class="col-md-2 col-form-label text-md-right">Name</label>
    <div class="col-md-8">
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
            value="{{ $group->name ?? old('name') }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label text-md-right">Detail</label>
    <div class="col-md-8">
        <textarea name="detail" class="form-control @error('detail') is-invalid @enderror" style="resize:none;"
            rows="5">{{ $group->detail ?? old('detail') }}</textarea>
        @error('detail')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row justify-content-center">
    <button class="btn btn-primary" type="submit">บันทึก</button>
    <a href="{{ route('admin.group.index') }}" class="btn btn-secondary ml-2">ยกเลิก</a>
</div>
