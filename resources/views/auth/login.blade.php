<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Login</title>
</head>
<body>

<div class="form-card">

    <img src="{{ asset('image/logo_loka.png') }}" alt="Logo">

    <form action="/proses-login" method="POST">
        @csrf

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Masuk</button>

        <div class="small-text">
            <a href="#">Lupa password?</a>
        </div>

        <div class="line"></div>

        <div class="small-text">
            Belum punya akun? <a href="/register">Daftar</a>
        </div>

    </form>
</div>

</body>
</html>
