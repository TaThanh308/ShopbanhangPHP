<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
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

        .btn-link {
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        .text-danger {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Đăng ký</h2>

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Tên</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Xác nhận mật khẩu</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit">Đăng ký</button>
            <a href="{{ route('login') }}" class="btn-link">Đã có tài khoản? Đăng nhập</a>
        </form>
    </div>
</body>
</html>
