<div>
    @if (session('success'))
        <div class="alert alert-success bg-green-600 text-white rounded-md p-4 mb-4 animate-fade-out">
            <div class="flex items-center">
                <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger bg-red-600 text-white rounded-md p-4 mb-4 animate-fade-out">
            <div class="flex items-center">
                <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                        fill="none" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9l-6 6m0-6l6 6" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning bg-orange-500 text-white rounded-md p-4 mb-4 animate-fade-out">
            <div class="flex items-center">
                <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                        fill="none" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01" />
                </svg>
                <span>{{ session('warning') }}</span>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger bg-red-600 text-white rounded-md p-4 mb-4 animate-fade-out">
            <div class="flex items-center">
                <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                        fill="none" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9l-6 6m0-6l6 6" />
                </svg>
                <span>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p><br>
                    @endforeach
                </span>
            </div>
        </div>
    @endif

    <style>
        .animate-fade-out {
            opacity: 1;
        }

        @keyframes fadeOut {

            0%,
            70% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }
    </style>

    <script>
        document.querySelectorAll('.alert').forEach(alert => {
            // Set animation after a short delay to ensure it's applied
            setTimeout(() => {
                alert.style.animation = "fadeOut 3s ease-in-out 7s forwards";
            }, 100);

            // Remove the alert completely after the full animation
            setTimeout(() => {
                alert.remove();
            }, 10000); // 7s visibility + 3s fade out
        });
    </script>
</div>
