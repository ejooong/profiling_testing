<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Paksa - NasDem Bojonegoro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-sign-out-alt text-red-600 text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Logout Paksa</h1>
            <p class="text-gray-600 mt-2">Sesi Anda akan diakhiri sepenuhnya.</p>
        </div>
        
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Anda akan logout dari semua sesi aktif. Gunakan ini jika mengalami masalah login.
                    </p>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('force-logout') }}">
            @csrf
            <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold py-3 px-4 rounded-lg hover:from-red-700 hover:to-red-800 transition duration-300 shadow-lg hover:shadow-xl flex items-center justify-center">
                <i class="fas fa-power-off mr-2"></i> Logout Sekarang
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <a href="/" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                <i class="fas fa-home mr-1"></i> Kembali ke Beranda
            </a>
        </div>
        
        <div class="mt-8 pt-6 border-t border-gray-200 text-center text-xs text-gray-500">
            <p>NasDem Bojonegoro &copy; {{ date('Y') }}</p>
        </div>
    </div>
    
    <script>
        // Auto logout setelah 5 detik
        setTimeout(function() {
            document.querySelector('form').submit();
        }, 5000);
        
        // Hitung mundur
        let countdown = 5;
        const countdownElement = document.createElement('p');
        countdownElement.className = 'text-sm text-gray-600 mt-4 text-center';
        countdownElement.innerHTML = `Otomatis logout dalam <span class="font-bold">${countdown}</span> detik...`;
        document.querySelector('.max-w-md').appendChild(countdownElement);
        
        const countdownInterval = setInterval(function() {
            countdown--;
            countdownElement.innerHTML = `Otomatis logout dalam <span class="font-bold">${countdown}</span> detik...`;
            
            if (countdown <= 0) {
                clearInterval(countdownInterval);
            }
        }, 1000);
    </script>
</body>
</html>