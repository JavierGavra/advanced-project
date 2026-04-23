<nav class="fixed top-0 left-0 right-0 z-40 bg-gray-800 border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Brand --}}
            <a href="/master" class="flex items-center gap-3 shrink-0">
                <div class="w-8 h-8 rounded-lg bg-[#408A71] flex items-center justify-center shadow-lg shadow-black/30">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75.125V18.375m0 0a1.125 1.125 0 011.125-1.125h1.5c.621 0 1.125.504 1.125 1.125M3.375 18.375v-7.5M21 18.375V4.5a.75.75 0 00-.75-.75H9.75a.75.75 0 00-.75.75v13.875M6 18.375V11.25m0 0V4.5a.75.75 0 01.75-.75h11.25" />
                    </svg>
                </div>
                <span class="text-white font-semibold text-base tracking-tight">JargonCourse</span>
            </a>

            {{-- Right side --}}
            <div class="flex items-center gap-3">

                {{-- User pill --}}
                <div class="hidden sm:flex items-center gap-2.5 bg-white/5 border border-white/7 rounded-xl px-3 py-1.5">
                    <div class="w-6 h-6 rounded-md bg-[#408A71] flex items-center justify-center text-xs font-bold text-white shrink-0">
                        A
                    </div>
                    <div class="leading-tight">
                        <p class="text-xs font-semibold text-slate-200">{{ Session::get('user_email') }}</p>
                    </div>
                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 shrink-0"></div>
                </div>

                {{-- Logout --}}
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-red-400
                                   hover:bg-red-500/10 hover:text-red-300 transition-all duration-150 border border-transparent
                                   hover:border-red-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>

                {{-- Mobile hamburger --}}
                <button type="button" onclick="toggleMobileMenu()"
                    class="sm:hidden flex items-center justify-center w-9 h-9 rounded-lg text-slate-400
                               hover:bg-white/7 hover:text-slate-200 transition-colors duration-150">
                    <svg id="icon-open" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden sm:hidden border-t border-white/5 bg-gray-800 px-4 pb-4 pt-2 space-y-1">
        <div class="flex items-center gap-2.5 px-3 py-2.5 mt-2 border-t border-white/5 pt-3">
            <div class="w-6 h-6 rounded-md bg-[#408A71] flex items-center justify-center text-xs font-bold text-white">A</div>
            <div>
                <p class="text-xs font-semibold text-slate-200">Admin</p>
                <p class="text-xs text-slate-500">admin@jargon.com</p>
            </div>
            <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 ml-auto"></div>
        </div>
    </div>
</nav>

{{-- Spacer so content doesn't hide under fixed navbar --}}
<div class="h-16"></div>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const open = document.getElementById('icon-open');
        const close = document.getElementById('icon-close');
        const hidden = menu.classList.contains('hidden');
        menu.classList.toggle('hidden', !hidden);
        open.classList.toggle('hidden', hidden);
        close.classList.toggle('hidden', !hidden);
    }
</script>