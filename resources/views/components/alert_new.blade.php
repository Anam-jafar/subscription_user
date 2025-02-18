<div>
    <!-- Success Alert -->
    @if (session('success'))
        <div id="successAlert"
            class="fixed top-24 right-8 bg-green-600 text-white rounded-md p-4 mb-4 flex items-center animate-fade-in-out">
            <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Error Alert -->
    @if (session('error'))
        <div id="errorAlert"
            class="fixed top-8 right-4 bg-red-600 text-white rounded-md p-4 mb-4 flex items-center animate-fade-in-out">
            <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9l-6 6m0-6l6 6" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Warning Alert -->
    @if (session('warning'))
        <div id="warningAlert"
            class="fixed top-8 right-4 bg-orange-500 text-white rounded-md p-4 mb-4 flex items-center animate-fade-in-out">
            <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01" />
            </svg>
            <span>{{ session('warning') }}</span>
        </div>
    @endif
</div>

<style>
    .animate-fade-in-out {
        animation: fadeInOut 5s ease-in-out;
        opacity: 0;
    }

    @keyframes fadeInOut {
        0% {
            opacity: 0;
        }

        10% {
            opacity: 1;
        }

        90% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }
</style>

<script>
    // Remove alerts after animation completes
    document.querySelectorAll('[id$="Alert"]').forEach(alert => {
        setTimeout(() => {
            alert.remove();
        }, 5000);
    });
</script>
