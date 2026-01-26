<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-POIN') - Platform Manajemen Poin Siswa</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS - Animate On Scroll -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />

    <!-- Additional Styles -->
    <style>
        * {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Card hover effect */
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Pulse animation */
        @keyframes pulse-custom {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .pulse-custom {
            animation: pulse-custom 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Sidebar smooth animation */
        .sidebar-toggle {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Hover effect untuk menu items */
        .menu-item {
            position: relative;
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            padding-left: 1.5rem;
        }

        .menu-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 0 3px 3px 0;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .menu-item.active::before,
        .menu-item:hover::before {
            opacity: 1;
        }

        /* Badge animation */
        @keyframes badge-pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            }
            70% {
                box-shadow: 0 0 0 8px rgba(239, 68, 68, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }

        .badge-pulse {
            animation: badge-pulse 2s infinite;
        }

        /* Fade in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        /* Loading skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .float {
            animation: float 3s ease-in-out infinite;
        }

        /* Glass morphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="flex items-center justify-between px-3 sm:px-4 md:px-6 py-3 sm:py-4 w-full">
            <!-- Logo & Brand -->
            <div class="flex items-center gap-3 cursor-pointer hover:scale-105 transition-transform">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                    <span class="text-white text-xl font-bold">📊</span>
                </div>
                <div class="hidden sm:block">
                    <h1 class="text-xl font-bold gradient-text">E-POIN</h1>
                    <p class="text-xs text-gray-500">Manajemen Poin Siswa</p>
                </div>
            </div>

            <!-- Right Section: Notifications & Profile -->
            <div class="flex items-center gap-6">
                <!-- Notifikasi Bell -->
                <div class="relative group">
                    <button class="relative p-2 text-gray-600 hover:text-gray-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if(Auth::user()->notifikasis()->unread()->count() > 0)
                            <span class="absolute top-1 right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold leading-none text-white bg-red-600 rounded-full badge-pulse">
                                {{ Auth::user()->notifikasis()->unread()->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- Notification Dropdown -->
                    <div class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 max-h-96 overflow-y-auto">
                        <div class="p-4 border-b border-gray-200">
                            <h3 class="font-semibold text-gray-900">Notifikasi</h3>
                        </div>
                        
                        @forelse(Auth::user()->notifikasis()->unread()->latest()->limit(5)->get() as $notif)
                            <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                <p class="text-sm font-medium text-gray-900">{{ $notif->judul }}</p>
                                <p class="text-xs text-gray-600 mt-1">{{ $notif->deskripsi }}</p>
                                <p class="text-xs text-gray-400 mt-2">{{ $notif->created_at->diffForHumans() }}</p>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500 text-sm">
                                Tidak ada notifikasi baru
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- User Profile Dropdown -->
                <div class="relative group">
                    <button class="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors px-3 py-2 rounded-lg hover:bg-gray-100">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full ring-2 ring-blue-500">
                        <span class="text-sm font-medium hidden sm:inline">{{ Str::limit(Auth::user()->name, 15) }}</span>
                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                        <div class="p-4 border-b border-gray-200">
                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-600">{{ Auth::user()->email }}</p>
                        </div>

                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors flex items-center gap-2">
                            <i class="fas fa-user-circle text-blue-600"></i>
                            <span>👤 Profil Saya</span>
                        </a>

                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors flex items-center gap-2 border-b border-gray-200">
                            <i class="fas fa-cog text-blue-600"></i>
                            <span>⚙️ Pengaturan</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 transition-colors flex items-center gap-2 rounded-b-lg">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>🚪 Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="flex w-full">
        <!-- Sidebar -->
        <aside id="sidebar" class="hidden lg:block w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white min-h-[calc(100vh-5rem)] fixed left-0 top-20 shadow-xl">
            <nav class="p-6 space-y-2 overflow-y-auto max-h-[calc(100vh-5rem)]">
                @if(Auth::user()->role === 'guru')
                    @include('layouts._sidebar-guru')
                @elseif(Auth::user()->role === 'siswa')
                    @include('layouts._sidebar-siswa')
                @elseif(Auth::user()->role === 'admin')
                    @include('layouts._sidebar-admin')
                @endif
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="w-full lg:ml-64 px-2 sm:px-3 md:px-4 py-2 overflow-x-hidden overflow-y-auto">
            <!-- Breadcrumb -->
            @if(isset($breadcrumbs))
                <div class="mb-6 text-sm fade-in" data-aos="fade-down">
                    <nav class="flex" aria-label="Breadcrumb">
                        @foreach($breadcrumbs as $label => $url)
                            @if($loop->last)
                                <span class="text-gray-600 font-medium">{{ $label }}</span>
                            @else
                                <a href="{{ $url }}" class="text-blue-600 hover:text-blue-800 transition-colors">{{ $label }}</a>
                                <span class="text-gray-400 mx-2">/</span>
                            @endif
                        @endforeach
                    </nav>
                </div>
            @endif

            <!-- Flash Messages -->
            @if($message = Session::get('success'))
                <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-700 rounded-lg shadow-md fade-in" role="alert" data-aos="fade-down">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-green-600"></i>
                        <div>
                            <p class="font-bold">Sukses!</p>
                            <p>{{ $message }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($message = Session::get('error'))
                <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-700 rounded-lg shadow-md fade-in" role="alert" data-aos="fade-down">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-red-600"></i>
                        <div>
                            <p class="font-bold">Error!</p>
                            <p>{{ $message }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>

    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden opacity-0 invisible transition-opacity"></div>

    <!-- Scripts -->
    @stack('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        // Sidebar toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
            overlay.classList.toggle('invisible');
            overlay.classList.toggle('opacity-0');
        });

        document.getElementById('sidebarOverlay')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.add('hidden');
            document.getElementById('sidebarOverlay').classList.add('invisible');
            document.getElementById('sidebarOverlay').classList.add('opacity-0');
        });

        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>

