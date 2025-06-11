<nav x-data="{ open: false, showDataAsetSubmenu: false }" class="bg-gray-900 h-screen fixed top-0 left-0 w-64 border-r border-gray-800">
    <div class="flex justify-between items-center p-6">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-white" />
        </a>
        <!-- Hamburger (untuk mobile) -->
        <div class="sm:hidden">
            <button @click="open = !open" class="text-white p-2 rounded-md focus:outline-none">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="space-y-6 pt-6 sm:block">
        <!-- Dashboard Link -->
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-gray-300 py-2 px-4 rounded-md">
            {{ __('Dashboard') }}
        </x-nav-link>

        <!-- Data Aset Dropdown -->
        <div>
            <button @click="showDataAsetSubmenu = !showDataAsetSubmenu" class="w-full text-left text-white hover:text-gray-300 py-2 px-4 rounded-md">
                <x-nav-link href="{{ route('aset.index') }}" :active="request()->routeIs('aset.index')" class="text-white hover:text-gray-300 py-2 px-4 rounded-md inline-block">
                    Data Aset
                </x-nav-link>
                <svg class="h-4 w-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path :class="{'transform rotate-180': showDataAsetSubmenu}" class="transition-transform" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="showDataAsetSubmenu" x-collapse class="pl-4 space-y-2">
                <x-nav-link href="{{ route('transaksi.masuk') }}" :active="request()->routeIs('transaksi.masuk')" class="text-white hover:text-gray-300 py-2 px-4 rounded-md">
                    Data Aset Masuk
                </x-nav-link>
                <x-nav-link href="{{ route('transaksi.keluar') }}" :active="request()->routeIs('transaksi.keluar')" class="text-white hover:text-gray-300 py-2 px-4 rounded-md">
                    Data Aset Keluar
                </x-nav-link>
            </div>
            
            <!-- History Link: Tambahkan ke dalam submenu dropdown agar sejenis dengan Data Aset -->
            <x-nav-link :href="route('history.index')" :active="request()->routeIs('history.index')" class="w-full text-left text-white hover:text-gray-300 py-2 px-4 rounded-md">
                {{ __('History') }}
            </x-nav-link>
        </div>

        <!-- Profile and Logout -->
        <div class="mt-auto">
            <x-dropdown align="left" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-900 hover:text-gray-300 focus:outline-none transition">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="ml-64 bg-gray-100 min-h-screen p-6">
    @yield('content')
</div>
