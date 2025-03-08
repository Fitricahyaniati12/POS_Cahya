<!DOCTYPE html>
<html>
<head>
    <title>Tambah User</title>
</head>
<body>
    <h1>Form Tambah Data User</h1>
    <a href="{{ route('user') }}">Kembali</a>
    <form method="POST" action="{{ route('user.tambah_simpan') }}">
        @csrf
        <label>Username:</label>
        <input type="text" name="username" placeholder="Masukkan Username" required><br>

        <label>Nama:</label>
        <input type="text" name="nama" placeholder="Masukkan Nama" required><br>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Masukkan Password" required><br>

        <label>ID Level:</label>
        <input type="text" name="level_id" placeholder="Masukkan Level ID" required><br>

        <input type="submit" value="Simpan">
    </form>
</body>
</html>
