<!doctype html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('logo-paud.png') }} " type="image/x-icon" />
	<style>
		body {
			margin: 0;
			padding: 0;
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
			font-family: 'Poppins', sans-serif;
		}

		.card {
			background: #fff;
			padding: 2rem;
			border-radius: 12px;
			box-shadow: 0 15px 30px rgba(0,0,0,0.1);
			width: 100%;
			max-width: 400px;
		}

		.card-title {
			text-align: center;
			font-size: 1.8rem;
			font-weight: 600;
			margin-bottom: 1.5rem;
			color: #333;
		}

		.form-group {
			margin-bottom: 1rem;
		}

		.form-label {
			display: block;
			margin-bottom: 0.5rem;
			color: #555;
			font-size: 0.9rem;
		}

		.form-control {
			width: 95%;
			padding: 0.75rem;
			border: 1px solid #ccc;
			border-radius: 8px;
			font-size: 0.95rem;
		}

		.form-control.is-invalid {
			border-color: #e74c3c;
			background-color: #fceae9;
		}

		.invalid-feedback {
			color: #e74c3c;
			font-size: 0.85rem;
			margin-top: 0.3rem;
		}

		.btn {
			width: 100%;
			padding: 0.75rem;
			border: none;
			border-radius: 8px;
			background-color: #4facfe;
			color: #fff;
			font-size: 1rem;
			font-weight: 600;
			cursor: pointer;
			transition: background 0.3s ease;
		}

		.btn:hover {
			background-color: #00c6ff;
		}
	</style>
</head>
<body>
	<form class="card" action="{{ route('login') }}" method="post">
		@csrf
		<div class="card-title">
            <img src="{{ asset('logo-paud.png') }}" alt="Logo" style="height: 80px; margin-right: 10px;">
            <div>Selamat Datang</div>
        </div>

		<div class="form-group">
			<label class="form-label">Email</label>
			<input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Masukkan email" value="{{ old('email') }}">
			@if($errors->has('email'))
				<div class="invalid-feedback">{{ $errors->first('email') }}</div>
			@endif
		</div>

		<div class="form-group">
			<label class="form-label">Password</label>
			<input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Masukkan password">
			@if($errors->has('password'))
				<div class="invalid-feedback">{{ $errors->first('password') }}</div>
			@endif
		</div>

		<button type="submit" class="btn">Masuk</button>
	</form>
</body>
</html>
