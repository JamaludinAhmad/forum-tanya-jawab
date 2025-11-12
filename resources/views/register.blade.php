<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    @vite('resources/css/app.css')
</head>
<body class="flex items-center justify-center min-h-screen p-4">
  <!-- Kontainer utama login card -->
  <div class="w-full max-w-xs bg-white rounded-xl shadow-2xl overflow-hidden transition-all duration-300">
    <div class="p-6">
      <!-- Judul dan Subjudul -->
      <div class="text-center mb-6">
        <!-- SVG Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
        </svg>
        
        <p class="mt-1 text-xl text-gray-600">
                Silakan buat akun Anda.
        </p>
      </div>

      <!-- Formulir Register -->
      <form method="POST" action={{ route('registerUser') }}>
        @csrf
        <div class="mb-3">
          <label for="name" class="block text-xs font-medium text-gray-700 mb-1">name</label>
          <input type="name" id="name" name="name" required class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="username">
        </div>
        
        <div class="mb-3">
          <label for="email" class="block text-xs font-medium text-gray-700 mb-1">Email</label>
          <input type="email" id="email" name="email" required class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="nama@contoh.com">
        </div>
        <!-- Field Alamat Email -->

        <!-- Field Kata Sandi -->
        <div class="mb-4">
          <label for="password" class="block text-xs font-medium text-gray-700 mb-1">Kata Sandi</label>
          <input type="password" id="password" name="password" required class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Minimal 8 karakter">
        </div>

        <div class="mb-4">
          <label for="password_confirmation" class="block text-xs font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
          <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Minimal 8 karakter">
        </div>
        <!-- Tombol Masuk -->
        <button type="submit" class="w-full py-1.5 px-3 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition duration-150">Buat Akun</button>
        <div class="mt-4 text-center">
          <p class="text-xs text-gray-600">
            Sudah Punya akun?
            <a href={{ route("login") }} class="font-medium text-indigo-600 hover:text-indigo-500" onclick="showFeedback('Halaman Pendaftaran belum tersedia.')">
                    Masuk
            </a>
          </p>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
