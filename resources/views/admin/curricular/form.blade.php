<div class="form-group row">
    <label class="col-md-2 col-form-label text-md-right">Name</label>
    <div class="col-md-8">
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
            value="{{ $curr->name ?? old('name') }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row justify-content-center">
    <button class="btn btn-primary" type="submit">บันทึก</button>
    <a href="{{ route('admin.curr.index') }}" class="btn btn-secondary ml-2">ยกเลิก</a>
</div>
