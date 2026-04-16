<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'SMS Dashboard'; ?> - SMS Gateway</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Serif:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'IBM Plex Serif', serif; }
        .sidebar-link.active {
            border-color: #f43f5e;
            color: #f43f5e;
            background: rgba(244, 63, 94, 0.05);
        }
        .outline-card {
            background: rgba(17, 24, 39, 0.7);
            border: 1px solid rgba(244, 63, 94, 0.2);
            box-shadow: 0 0 20px rgba(244, 63, 94, 0.05);
        }
        .outline-input {
            background: transparent;
            border: 1px solid rgba(75, 85, 99, 0.5);
            transition: all 0.3s ease;
        }
        .outline-input:focus {
            border-color: #f43f5e;
            box-shadow: 0 0 0 2px rgba(244, 63, 94, 0.1);
        }
        @media (max-width: 1024px) {
            .sidebar-closed { transform: translateX(-100%); }
            .content-full { margin-left: 0 !important; }
        }
    </style>
</head>
<body class="bg-gray-950 text-gray-200 min-h-screen">

    <!-- Mobile Top Bar -->
    <header class="lg:hidden bg-gray-900 border-b border-gray-800 p-4 sticky top-0 z-[60] flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-rose-500 rounded flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
            </div>
            <span class="font-bold tracking-tight">SMS Gate</span>
        </div>
        <button id="menu-toggle" class="p-2 text-gray-400 hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </header>

    <!-- Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[51] hidden lg:hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-72 bg-gray-900 border-r border-rose-500/10 flex flex-col fixed h-full z-[55] transition-transform duration-300 sidebar-closed lg:transform-none">
        <div class="p-8">
            <div class="hidden lg:flex items-center space-x-3 mb-12">
                <div class="w-10 h-10 bg-transparent border-2 border-rose-500 rounded-lg flex items-center justify-center shadow-[0_0_15px_rgba(244,63,94,0.3)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <span class="text-2xl font-bold tracking-tighter text-white">SMS Gate</span>
            </div>

            <nav class="space-y-3">
                <a href="<?php echo $url('/'); ?>" class="sidebar-link flex items-center space-x-3 p-4 rounded-xl border border-transparent transition-all <?php echo $_SERVER['REQUEST_URI'] === $url('/') ? 'active' : 'text-gray-500 hover:text-gray-300'; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    <span class="font-medium">Send SMS</span>
                </a>
                <a href="<?php echo $url('/logs'); ?>" class="sidebar-link flex items-center space-x-3 p-4 rounded-xl border border-transparent transition-all <?php echo strpos($_SERVER['REQUEST_URI'], '/logs') !== false ? 'active' : 'text-gray-500 hover:text-gray-300'; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <span class="font-medium">Message Logs</span>
                </a>
                <a href="<?php echo $url('/settings'); ?>" class="sidebar-link flex items-center space-x-3 p-4 rounded-xl border border-transparent transition-all <?php echo strpos($_SERVER['REQUEST_URI'], '/settings') !== false ? 'active' : 'text-gray-500 hover:text-gray-300'; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-medium">Settings</span>
                </a>
            </nav>
        </div>

        <div class="mt-auto p-8 border-t border-gray-800">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-500 font-bold">AD</div>
                <div>
                    <p class="text-sm font-bold text-gray-200">Admin User</p>
                    <p class="text-xs text-gray-500 font-medium">Gateway Manager</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-0 lg:ml-72 p-6 lg:p-10 transition-all duration-300">
        <header class="flex flex-col lg:flex-row lg:items-center justify-between mb-10 gap-4">
            <div>
                <h1 class="text-4xl font-bold tracking-tighter text-white"><?php echo $title; ?></h1>
                <p class="text-gray-500 mt-1">Manage your SMS gateway delivery</p>
            </div>
            <div class="flex items-center space-x-4">
                <span class="flex items-center space-x-2 text-xs font-bold uppercase tracking-widest bg-emerald-500/5 text-emerald-500 px-4 py-2 rounded border border-emerald-500/20">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    <span>System Online</span>
                </span>
            </div>
        </header>

        <div class="animate-fadeIn">
            <?php require $viewFile; ?>
        </div>
    </main>

    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const menuIcon = document.getElementById('menu-icon');

        const toggleSidebar = () => {
            sidebar.classList.toggle('sidebar-closed');
            overlay.classList.toggle('hidden');
        };

        menuToggle.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    </script>
</body>
</html>
