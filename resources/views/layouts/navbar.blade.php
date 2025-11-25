<nav x-data="{ open: false }" class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <div class="bg-gradient-to-br from-indigo-600 to-purple-600 text-white p-1.5 rounded-lg shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-xl bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300">
                            {{ config('app.name') }}
                        </span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden sm:ml-10 sm:flex sm:space-x-8">
                    <a href="{{ url('/') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200 {{ request()->is('/') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                        Home
                    </a>
                    <a href="{{ url('/dollar-request-form') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200 {{ request()->is('dollar-request-form') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                        Dollar Request
                    </a>
                </div>
            </div>

            <!-- CTA Button -->
            <div class="hidden sm:flex sm:items-center">
                <a href="{{ url('/dollar-request-form') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 hover:shadow-md">
                    New Request
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ url('/') }}" 
               class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200 {{ request()->is('/') ? 'border-indigo-500 text-indigo-700 bg-indigo-50 dark:bg-indigo-900/20 dark:text-indigo-300' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                Home
            </a>
            <a href="{{ url('/dollar-request-form') }}" 
               class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200 {{ request()->is('dollar-request-form') ? 'border-indigo-500 text-indigo-700 bg-indigo-50 dark:bg-indigo-900/20 dark:text-indigo-300' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                Dollar Request
            </a>
        </div>
    </div>
</nav>
