<footer class="flex absolute bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Left Section -->
            <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                <div class="w-6 h-6 rounded bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                    <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Logo" class="w-3 h-3">
                </div>
                <span class="text-sm font-medium">Nolite Aspiciens</span>
            </div>

            <!-- Center Section - Optional for additional links -->
            <div class="hidden sm:flex items-center space-x-6 text-sm text-gray-500 dark:text-gray-400">
                <!-- Add footer links here if needed -->
                <!-- <a href="#" class="hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Support</a> -->
            </div>

            <!-- Right Section -->
            <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                <span>&copy; {{ date('Y') }}. All Rights Reserved.</span>
                
                <!-- Optional: Theme toggle or additional icons -->
                <!-- <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </button> -->
            </div>
        </div>

        <!-- Mobile Center Links -->
        <div class="sm:hidden flex justify-center mt-4 space-x-4 text-xs text-gray-500 dark:text-gray-400">
            <!-- Mobile footer links here if needed -->
            <!-- <a href="#" class="hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Privacy</a>
            <a href="#" class="hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Terms</a>
            <a href="#" class="hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Help</a> -->
        </div>
    </div>
</footer>