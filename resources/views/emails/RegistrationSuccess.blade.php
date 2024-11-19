<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrasi Berhasil</title>
</head>
<body>
    <h1>Halo, {{ $user->name }}</h1>
    <p>Terima kasih telah mendaftar. Akun Anda berhasil dibuat.</p>
    <p>Email: {{ $user->email }}</p>
</body>
</html>