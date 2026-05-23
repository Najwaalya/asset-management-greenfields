<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Asset Management</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen relative flex items-center justify-center">

    <!-- BACKGROUND IMAGE FULL -->
    <img src="{{ asset('images/greenfields.jpg') }}"
         class="absolute inset-0 w-full h-full object-cover object-[center_top]">

    <!-- DARK + GREEN OVERLAY -->
    <div class="absolute inset-0 bg-gradient-to-br from-black/60 via-green-900/40 to-black/70"></div>

    <!-- LOGIN CARD -->
    <div class="relative w-full max-w-md px-6">

        <div class="bg-green-600/20 backdrop-blur-xl border border-white/20 shadow-2xl rounded-2xl overflow-hidden">

            <!-- HEADER -->
            <div class="text-center px-6 pt-8 pb-4">

                <img src="{{ asset('images/Greenfields-logo.png') }}"
                     class="w-28 h-28 mx-auto mb-3 rounded-full bg-white/10 p-2 shadow-lg">

                <h1 class="text-2xl font-bold text-white">
                    Asset Management
                </h1>

                <p class="text-green-100 text-sm mt-1">
                    PT Greenfields System
                </p>
            </div>

            <!-- FORM -->
            <div class="p-8">

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- EMAIL -->
                    <input type="email" name="email"
                           placeholder="Email"
                           class="w-full px-4 py-3 rounded-lg bg-white/90 text-gray-900
                                  border border-white/20 focus:ring-2 focus:ring-green-400 outline-none">

                    <!-- PASSWORD -->
                    <input type="password" name="password"
                           placeholder="Password"
                           class="w-full px-4 py-3 rounded-lg bg-white/90 text-gray-900
                                  border border-white/20 focus:ring-2 focus:ring-green-400 outline-none">

                    <!-- BUTTON -->
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg shadow-lg transition">
                        Login
                    </button>

                </form>

            </div>

        </div>
    </div>

</body>
</html>