<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Kerah Biru</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/Icon.png') }}" />


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('css/public.css') }}">

</head>

<body style="font-family:'Montserrat', sans-serif; background:#f1f5fb">

    <div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
        <div class="card shadow border-0 p-4" style="max-width: 420px; width:100%;">

            <div class="text-center mb-3">
                <img src="{{ asset('images/Icon.png') }}" height="65" class="mb-2">
                <h3 class="fw-bold" style="color:#052c62;">Admin Kerah Biru</h3>
                <p class="text-muted small">Masuk ke Dashboard Admin</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-diamond-fill me-1"></i>{{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill me-1"></i>{{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf


                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="usernameInput" name="username" placeholder="Username"
                        required>
                    <label for="usernameInput">
                        <i class="bi bi-person-circle me-1"></i> Username
                    </label>
                    @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                </div>


                <div class="form-floating mb-4 position-relative">
                    <input type="password" class="form-control" id="passwordInput" name="password"
                        placeholder="Password" required>
                    <label for="passwordInput">
                        <i class="bi bi-shield-lock-fill me-1"></i> Password
                    </label>


                    <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer"
                        onclick="togglePassword()" style="cursor:pointer;">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </span>

                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button class="btn btn-navy w-100 rounded-pill fw-semibold py-2">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </button>
            </form>


            <div class="text-center mt-2">
                <a href="{{ route('worker.register.form') }}" class="small text-decoration-none fw-semibold"
                    style="color:#052c62;">
                    <i class="bi bi-person-plus-fill me-1"></i>Daftar sebagai Mitra
                </a>
            </div>

        </div>
    </div>


    <script>
        function togglePassword() {
            const password = document.getElementById("passwordInput");
            const icon = document.getElementById("toggleIcon");

            if (password.type === "password") {
                password.type = "text";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            } else {
                password.type = "password";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>