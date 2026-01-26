<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-POIN System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="min-h-screen flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <h1 class="mt-4 text-3xl font-extrabold text-gray-900 dark:text-white">E-POIN</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Educational Point Management System</p>
            </div>

            <!-- Login Form Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden">
                <div class="px-6 py-8 sm:px-10">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Sign in to your account</h2>

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                            <p class="text-red-800 dark:text-red-200 text-sm">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $errors->first() }}
                            </p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                        @csrf

                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Email Address
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white transition"
                                placeholder="you@example.com"
                            />
                            @error('email')
                                <p class="mt-1 text-red-600 dark:text-red-400 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Password
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white transition"
                                placeholder="Enter your password"
                            />
                            @error('password')
                                <p class="mt-1 text-red-600 dark:text-red-400 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                            />
                            <label for="remember" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                Remember me
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 rounded-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i>Sign in
                        </button>
                    </form>

                    <!-- Register Link -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-semibold">
                                Register here
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Demo Accounts Section -->
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-4xl">
            @include('auth.demo-accounts')
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
            <p>&copy; 2024 E-POIN System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
