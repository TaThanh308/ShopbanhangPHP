@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Danh mục</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Thêm Danh Mục Mới</a>
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($categories->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Sửa</a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Không có danh mục nào.</p>
        @endif
    </div>
@endsection
