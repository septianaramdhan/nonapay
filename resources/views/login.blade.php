<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Nonapay</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #3E2C1C; /* Coklat tua */
      font-family: 'Poppins', sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .card {
      border: none;
      border-radius: 20px;
      background-color: #fff;
      box-shadow: 0 4px 15px rgba(0,0,0,0.25);
      padding: 35px 30px;
      width: 370px;
      text-align: center;
    }

    .logo {
      width: 100px;
      height: auto;
      display: block;
      margin: 0 auto 10px auto;
    }

    h4 {
      color: #C9A646; /* Warna emas */
      font-weight: 600;
      margin-bottom: 30px;
    }

    label {
      font-weight: 500;
      color: #3E2C1C;
      text-align: left;
      display: block;
    }

    .form-control {
      border-radius: 10px;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      font-size: 14px;
    }

    .btn-gold {
      background-color: #C9A646;
      border: none;
      color: #fff;
      font-weight: bold;
      letter-spacing: 0.5px;
      border-radius: 10px;
      padding: 12px;
      transition: all 0.3s ease;
    }

    .btn-gold:hover {
      background-color: #b7963d;
    }

    .alert {
      font-size: 13px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <div class="card">
    <img src="{{ asset('nonapay-removebg-preview.png') }}" alt="Nonapay Logo" class="logo">
    <h4>LOGIN</h4>

    @if($errors->any())
      <div class="alert alert-danger p-2">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login.form') }}" method="POST">
      @csrf
      <div class="form-group text-start">
        <label>Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
      </div>

      <div class="form-group text-start">
        <label>Password</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
      </div>

      <button type="submit" class="btn btn-gold w-100 mt-2">Masuk</button>
    </form>
  </div>
</body>
</html>
