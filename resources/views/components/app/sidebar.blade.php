<div class="min-w-fit">
    <!-- Sidebar backdrop (mobile only) -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="flex lg:!flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-[100dvh] overflow-y-scroll lg:overflow-y-auto no-scrollbar
        lg:w-64 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-white dark:bg-gray-800 p-4 transition-all duration-200 ease-in-out {{ $variant === 'v2' ? 'border-r border-gray-200 dark:border-gray-700/60' : 'rounded-r-2xl shadow-sm' }}"
        :class="sidebarOpen ? 'max-lg:translate-x-0' : 'max-lg:-translate-x-64'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false">

        <!-- Sidebar header -->
        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <!-- Expand button (always visible on small screens) -->
            <button class="text-gray-500 hover:text-gray-400 lg:hidden" @click.stop="sidebarOpen = !sidebarOpen"
                aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Expand sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a class="block" href="{{ route('dashboard') }}">
                khepri
            </a>
        </div>

        <!-- Links -->
        <div class="space-y-8">
            <!-- Pages group -->
            <div>

                <ul class="mt-3">
                    <!-- Add the Post, Categories, and Archive sections -->
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0">
                        <a class="block text-gray-800 dark:text-gray-100 p-2 rounded-sm truncate transition hover:text-gray-900 dark:hover:text-white
                            {{ request()->routeIs('posts.index') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            href="{{ route('posts.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M3.75 1A2.75 2.75 0 0 0 1 3.75v8.5A2.75 2.75 0 0 0 3.75 15h8.5A2.75 2.75 0 0 0 15 12.25v-8.5A2.75 2.75 0 0 0 12.25 1h-8.5ZM2.5 3.75c0-.69.56-1.25 1.25-1.25h8.5c.69 0 1.25.56 1.25 1.25v8.5c0 .69-.56 1.25-1.25 1.25h-8.5c-.69 0-1.25-.56-1.25-1.25v-8.5Z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-4 description lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Posts</span>
                            </div>
                        </a>
                    </li>

                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0">
                        <a class="block text-gray-800 dark:text-gray-100 p-2 rounded-sm truncate transition hover:text-gray-900 dark:hover:text-white
                            {{ request()->routeIs('categories.index') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            href="{{ route('categories.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M8 0C5.79 0 4 1.79 4 4s1.79 4 4 4 4-1.79 4-4S10.21 0 8 0zM2 8v8c0 1.11.9 2 2 2h8c1.1 0 2-.89 2-2V8c0-1.11-.9-2-2-2H4c-1.1 0-2 .89-2 2zm4 0h4v8H6V8z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-4 description lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Categories</span>
                            </div>
                        </a>
                    </li>

                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0">
                        <a class="block text-gray-800 dark:text-gray-100 p-2 rounded-sm truncate transition hover:text-gray-900 dark:hover:text-white
                            {{ request()->routeIs('posts.archive') ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            href="{{ route('posts.archive') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M14 2H2c-1.11 0-2 .89-2 2v8c0 1.11.89 2 2 2h12c1.11 0 2-.89 2-2V4c0-1.11-.89-2-2-2zM4 4h8v1H4V4zm0 2h8v1H4V6zm8 6H4v-1h8v1zm2-2H2V5h12v5z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-4 description lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Archive</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
