<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Welcome to the Admin Panel</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <h4 class="font-medium mb-2">Projects</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Manage your portfolio projects</p>
                            <a href="#" class="text-blue-600 dark:text-blue-400 text-sm mt-2 inline-block">Manage
                                →</a>
                        </div>

                        <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <h4 class="font-medium mb-2">Services</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Update your service offerings</p>
                            <a href="#" class="text-blue-600 dark:text-blue-400 text-sm mt-2 inline-block">Manage
                                →</a>
                        </div>

                        <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <h4 class="font-medium mb-2">About</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Edit your profile information</p>
                            <a href="#" class="text-blue-600 dark:text-blue-400 text-sm mt-2 inline-block">Manage
                                →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
