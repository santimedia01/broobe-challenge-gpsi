<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="h-full bg-white"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Inicio') - Broobe Challenge</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <!-- Styles -->
    @vite('resources/css/app.css')

    @vite('resources/js/app.js')

    @csrf
</head>
<body class="h-full">
    <div>
        <div id="sidebar-menu-mobile" class="fixed flex z-50 top-0 left-0 h-full w-full bg-gray-200 transform transition-transform duration-300 -translate-x-full" role="dialog" aria-modal="true">
            <!--
              Off-canvas menu backdrop, show/hide based on off-canvas menu state.
            -->
            <div id="sidebar-menu-mobile-bg" class="fixed inset-0 bg-gray-900/80 opacity-0 transition-opacity duration-300"></div>

            <div class="fixed inset-0 flex">
                <!--
                  Off-canvas menu, show/hide based on off-canvas menu state.
                -->
                <div class="relative mr-16 flex w-full max-w-xs flex-1">
                    <div id="sidebar-menu-close" class="absolute left-full top-0 flex w-16 justify-center pt-5">
                        <button type="button" class="-m-2.5 p-2.5">
                            <span class="sr-only">Close Menu</span>
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    @include('components.layouts.main.sidebar')
                </div>
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
            @include('components.layouts.main.sidebar')
        </div>

        <div class="lg:pl-72">
            <div class="sticky top-0 z-30 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-4">
                <button id="sidebar-menu-open-button" type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
                    <span class="sr-only">Open Menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </button>

                <!-- Separator -->
                <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true"></div>

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6 z-30">
                    <div class="flex items-center gap-x-2 lg:gap-x-4 @isRoute("metrics.run", "hidden lg:flex")">
                        {{--
                            <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10"></div>
                        --}}
                        <div class="relative">
                            <a href="{{ route('metrics.run') }}" type="submit" class="flex items-center rounded-md bg-indigo-50 px-2.5 py-1.5 text-sm font-semibold text-indigo-600 shadow-sm hover:bg-indigo-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span class="ml-2 my-auto">
                                    New Metric
                                </span>
                            </a>
                        </div>
                    </div>
                    <form class="relative flex flex-1 h-full" action="{{ route('metrics.history') }}" method="GET">
                        <label for="search-field" class="sr-only">Search Metrics...</label>
                        <svg class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400"
                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <input id="search-field"
                               class="block h-full w-full border-0 py-0 pl-8 pr-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 text-xs sm:text-sm"
                               placeholder="Search Metrics..." type="search" name="query">
                    </form>
                </div>
            </div>

            <main class="py-4 lg:py-6 lg:px-3">
                <div class="px-4 sm:px-6 lg:px-3">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    {{--<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" defer></script>--}}

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById("sidebar-menu-mobile");
            const backdrop = document.getElementById("sidebar-menu-mobile-bg");
            const openButton = document.getElementById("sidebar-menu-open-button");
            const closeButton = document.getElementById("sidebar-menu-close");

            const isSidebarOpen = () => sidebar.classList.contains('translate-x-0');

            const toggleSidebar = () => {
                sidebar.classList.toggle('-translate-x-full');
                sidebar.classList.toggle('translate-x-0');

                backdrop.classList.toggle('opacity-0');
                backdrop.classList.toggle('opacity-100');
            };

            // Abrir Menú
            openButton.addEventListener("click", () => toggleSidebar());

            // Cerrar Menú
            closeButton.addEventListener("click", () => toggleSidebar());
            backdrop.addEventListener("click", () => toggleSidebar());

            window.addEventListener("keydown", (e) => {
                if (e.key === "Escape") {
                    if (isSidebarOpen()) toggleSidebar();
                }
            });
        })
    </script>

    @stack('final-body-scripts')
</body>
</html>
