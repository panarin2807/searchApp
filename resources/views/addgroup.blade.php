<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="{{ route('storeTest') }}" method="post">
        @csrf
        <label>แก้ไขกลุ่มโครงงาน id : <input type="text" name="project_id" value="{{ $project->id }}"></label><br>
        <label>ชื่อ : {{ $project->name_th }}</label><br>
        @foreach ($groups as $item)
            <input type="checkbox" name="groups[]" value="{{ $item->id }}" @foreach ($project->groups as $group)  @if ($group->id==$item->id)
            checked @endif
        @endforeach>
        <label>{{ $item->name }}</label><br>
        @endforeach
        <button type="submit">บันทึก</button>
    </form>
</body>

</html>
