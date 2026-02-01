<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Register</title>
</head>
<body>

<div class="form-card">

    <img src="{{ asset('image/logo_loka.png') }}" alt="Logo">

    <form action="/proses-register" method="POST">
        @csrf

        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>

        <button type="submit">Daftar</button>

        <div class="line"></div>

        <div class="small-text">
            Sudah punya akun? <a href="/login">Masuk</a>
        </div>

    </form>
</div>

</body>
</html>
