<div class="col-md-12 col-12">
    <div class="card">
        {{-- <div class="card-header text-center">ค้นหา</div> --}}
        <div class="card-body">
            <div class="form-group row">
                <form method="get" action="{{ url('search') }}" class="container">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>ค้นหาจาก</label>
                            <select name="column[]"
                                class="selectpicker form-control @error('column') is-invalid @enderror"
                                title="เลือก Field ที่ต้องการค้นหา" data-selected-text-format="count > 3"
                                data-live-search="true" multiple data-actions-box="true">
                                @foreach ($fields as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            @error('column')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-8">
                            <label>Keyword</label>
                            <input name="keyword" value="{{ old('keyword') }}" type="text"
                                class="form-control @error('keyword') is-invalid @enderror" placeholder="คำค้นหา">
                            @error('keyword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>หมวดหมู่</label>
                            <select name="group[]"
                                class="selectpicker form-control @error('group') is-invalid @enderror"
                                title="เลือกหมวดหมู่" data-selected-text-format="count > 3" data-size="5" data-live-search="true"
                                multiple data-actions-box="true">
                                @foreach ($groups as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('group')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>หลักสูตร</label>
                            <select name="curr[]" class="selectpicker form-control @error('curr') is-invalid @enderror"
                                title="เลือกหลักสูตร" data-selected-text-format="count > 3" data-size="5" data-live-search="true"
                                multiple data-actions-box="true">
                                @foreach ($currs as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('curr')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label>ปีเริ่มต้น</label>
                            <input id="startYear" value="{{ old('start') }}" name="start"
                                class="form-control @error('start') is-invalid @enderror" autocomplete="off"/>
                            @error('start')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label>ปีสิ้นสุด</label>
                            <input id="endYear" name="end" value="{{ old('end') }}"
                                class="form-control @error('end') is-invalid @enderror" autocomplete="off"/>
                            @error('end')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <center><button type="submit" class="btn btn-success">SEARCH</button></center>
                </form>
            </div>
        </div>
    </div>
</div>
