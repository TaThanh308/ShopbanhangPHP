@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Sửa Danh Mục</h1>

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Tên Danh Mục</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
        </form>
    </div>
@endsection
