@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Tạo Danh Mục Mới</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tên Danh Mục</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Tạo Mới</button>
    </form>
</div>
@endsection
