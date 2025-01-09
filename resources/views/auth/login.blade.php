<style>
 body {
    font-family: 'Roboto', sans-serif;
    background-color: #f0f4f8;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-image: linear-gradient(to bottom right, #e0eafc, #cfdef3);
}

.container {
    width: 100%;
    max-width: 400px;
    padding: 40px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h2 {
    font-size: 2.5rem;
    color: #333333;
    margin-bottom: 30px;
    font-weight: 600;
}

.form-group {
    margin-bottom: 20px;
    text-align: left;
}

.form-group label {
    font-weight: 500;
    color: #555555;
    margin-bottom: 8px;
    display: inline-block;
}

.form-group input {
    width: 100%;
    padding: 15px;
    font-size: 1rem;
    border: 1px solid #dddddd;
    border-radius: 5px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-group input:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    outline: none;
}

button {
    width: 100%;
    padding: 15px;
    font-size: 1.1rem;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s, transform 0.2s;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
}

a {
    margin-top: 20px;
    color: #007bff;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
}

a:hover {
    text-decoration: underline;
}

.alert {
    background-color: #28a745;
    color: white;
    padding: 15px;
    border-radius: 5px;
    font-size: 0.9rem;
    margin-bottom: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.alert-danger {
    background-color: #dc3545;
}

@media (max-width: 480px) {
    .container {
        padding: 20px;
    }

    h2 {
        font-size: 2rem;
    }

    button {
        font-size: 1rem;
    }
}


</style>

@section('content')
<div class="container">
    <h2>Đăng nhập</h2>
      {{-- Hiển thị thông báo thành công --}}
      @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert">{{ session('error') }}</div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Đăng nhập</button>
        <a href="{{ route('register') }}">Tạo tài khoản mới</a>
    </form>
</div>

