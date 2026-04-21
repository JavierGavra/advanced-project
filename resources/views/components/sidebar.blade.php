<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    #logo-sidebar * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    #logo-sidebar {
        background: linear-gradient(160deg, #091413 20%, #285A48 70%);
        border-right: 1px solid rgba(255, 255, 255, 0.06);
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 500;
        color: #94a3b8;
        text-decoration: none;
        transition: background 0.18s, color 0.18s, transform 0.15s;
        position: relative;
        overflow: hidden;
    }

    .nav-item:hover {
        background: rgba(255, 255, 255, 0.07);
        color: #f1f5f9;
        transform: translateX(2px);
    }

    .nav-item.active {
        background: linear-gradient(90deg, rgba(64, 138, 113, 0.25), rgba(64, 138, 113, 0.08));
        color: #408A71;
        border: 1px solid rgba(64, 138, 113, 0.2);
    }

    .nav-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 20%;
        bottom: 20%;
        width: 3px;
        background: #408A71;
        border-radius: 0 3px 3px 0;
    }

    .nav-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: #408a712d;
    }

    .nav-item.active .nav-icon {
        background: #408a713d;
    }

    .nav-section-label {
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #47695b;
        padding: 0 12px;
        margin-bottom: 4px;
        margin-top: 20px;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 500;
        color: #f87171;
        background: transparent;
        border: none;
        cursor: pointer;
        width: 100%;
        transition: background 0.18s, transform 0.15s;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .logout-btn:hover {
        background: rgba(239, 68, 68, 0.1);
        transform: translateX(2px);
    }

    .logout-btn .nav-icon {
        background: rgba(239, 68, 68, 0.1);
    }

    .user-card {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 12px;
        padding: 10px 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #408A71;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }
</style>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">

    <div class="h-full flex flex-col px-3 py-5 overflow-y-auto">

        {{-- Brand --}}
        <a href="/" class="flex items-center gap-3 px-3 mb-6">
            <div class="w-8 h-8 rounded-lg bg-[#408A71] flex items-center justify-center flex-shrink-0 shadow-lg shadow-indigo-900/40">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75.125V18.375m0 0a1.125 1.125 0 011.125-1.125h1.5c.621 0 1.125.504 1.125 1.125M3.375 18.375v-7.5M21 18.375V4.5a.75.75 0 00-.75-.75H9.75a.75.75 0 00-.75.75v13.875M6 18.375V11.25m0 0V4.5a.75.75 0 01.75-.75h11.25" />
                </svg>
            </div>
            <span class="text-white font-semibold text-base tracking-tight">JargonCourse</span>
        </a>

        {{-- Nav --}}
        <nav class="flex-1 space-y-1">
            <p class="nav-section-label">Menu</p>
            <a href="/" class="nav-item <?php echo request()->path() == '/' ? 'active' : ''; ?>">
                <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                </span>
                Master
            </a>
            <a href="/tutorial" class="nav-item <?php echo request()->path() == '/tutorial' ? 'active' : ''; ?>">
                <span class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                </span>
                Tutorial
            </a>
        </nav>

        {{-- Bottom section --}}
        <div class="mt-4 space-y-3">

            {{-- Divider --}}
            <div class="h-px bg-white/5 mx-2"></div>

            {{-- Logout --}}
            <form action="/login/logout" method="post">
                @csrf
                <button type="submit" class="logout-btn">
                    <span class="nav-icon">
                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </span>
                    Keluar
                </button>
            </form>

            {{-- User card --}}
            <div class="user-card">
                <div class="avatar">A</div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-slate-200 truncate">Admin</p>
                    <p class="text-xs text-slate-500 truncate">admin@jargon.com</p>
                </div>
                <div class="w-2 h-2 rounded-full bg-emerald-400 flex-shrink-0"></div>
            </div>

        </div>
    </div>
</aside>