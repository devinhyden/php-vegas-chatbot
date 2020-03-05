<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHPVegas ChatBot Demo</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/ui@latest/dist/tailwind-ui.min.css">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.0.1/dist/alpine.js" defer></script>
</head>
<body>

<div>
    <nav x-data="{ open: false }" @keydown.window.escape="open = false" class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="/"><img class="h-8" src="/logo.png" alt=""/></a>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline">
                            <a href="/"
                               class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 focus:outline-none focus:text-white focus:bg-gray-700">Dashboard</a>
                            <a href="#"
                               class="ml-4 px-3 py-2 rounded-md text-sm font-medium  text-white bg-gray-900 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Tickets</a>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <div @click.away="open = false" class="ml-3 relative" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open"
                                        class="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none focus:shadow-solid">
                                    <img class="h-8 w-8 rounded-full"
                                         src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                         alt=""/>
                                </button>
                            </div>
                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg">
                                <div class="py-1 rounded-md bg-white shadow-xs">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your
                                        Profile</a>
                                    <a href="#"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign
                                        out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="-mr-2 flex md:hidden">
                    <button @click="open = !open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                                  stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div :class="{'block': open, 'hidden': !open}" class="hidden md:hidden">
            <div class="px-2 pt-2 pb-3 sm:px-3">
                <a href="#"
                   class="block px-3 py-2 rounded-md text-base font-medium text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700">Dashboard</a>
                <a href="#"
                   class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Tickets</a>
                <a href="#"
                   class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Projects</a>
                <a href="#"
                   class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Calendar</a>
                <a href="#"
                   class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Reports</a>
            </div>
            <div class="pt-4 pb-3 border-t border-gray-700">
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full"
                             src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                             alt=""/>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium leading-none text-white">Tom Cook</div>
                        <div class="mt-1 text-sm font-medium leading-none text-gray-400">tom@example.com</div>
                    </div>
                </div>
                <div class="mt-3 px-2">
                    <a href="#"
                       class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Your
                        Profile</a>
                    <a href="#"
                       class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Settings</a>
                    <a href="#"
                       class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700">Sign
                        out</a>
                </div>
            </div>
        </div>
    </nav>
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <h2 class="text-lg leading-6 font-semibold text-gray-900">
                Tickets
            </h2>
        </div>
    </header>
    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-4 sm:px-0">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg w-2/3 mx-auto">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                        <div class="flex mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Ticket Information
                                </h3>
                                <div
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $ticket->status }}
                                </div>
                            </div>
                            <div class="w-1/3">
                                <div class="flex justify-end">
                                    <div class="max-w-2xl text-sm leading-5 text-gray-500 px-4 ">
                                        <dd class="text-sm leading-5 font-medium text-gray-500">
                                            Created
                                        </dd>
                                        <dt class="mt-1 text-sm leading-5 text-gray-900">
                                            {{ $ticket->created_at->diffForHumans() }}
                                        </dt>
                                    </div>
                                    <div class="max-w-2xl text-sm leading-5 text-gray-500 px-4">
                                        <dd class="text-sm leading-5 font-medium text-gray-500">
                                            Updated
                                        </dd>
                                        <dt class="mt-1 text-sm leading-5 text-gray-900">
                                            {{ $ticket->updated_at->diffForHumans() }}
                                        </dt>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="px-4 py-5 sm:px-6">
                        <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dd class="text-sm leading-5 font-medium text-gray-500">
                                    Name
                                </dd>
                                <dt class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ $ticket->name }}
                                </dt>
                            </div>
                            <div class="sm:col-span-1">
                                <dd class="text-sm leading-5 font-medium text-gray-500">
                                    Email
                                </dd>
                                <dt class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ $ticket->email }}
                                </dt>
                            </div>
                            <div class="sm:col-span-2">
                                <dd class="text-sm leading-5 font-medium text-gray-500">
                                    Summary
                                </dd>
                                <dt class="mt-1 text-sm leading-5 text-gray-900">
                                    {{ $ticket->summary }}
                                </dt>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>


</body>
</html>
