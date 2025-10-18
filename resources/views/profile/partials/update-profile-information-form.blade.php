<section class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
    <header class="mb-6">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-user-pen text-blue-600"></i>
            Profile Information
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Update your account's profile information and email address.
        </p>
    </header>

    <!-- Form kirim verifikasi -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Form Update -->
    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input id="name" name="name" type="text"
                value="{{ old('name', $user->name) }}"
                required autofocus autocomplete="name"
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none placeholder-gray-400"
                placeholder="Enter your full name">
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input id="email" name="email" type="email"
                value="{{ old('email', $user->email) }}"
                required autocomplete="username"
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none placeholder-gray-400"
                placeholder="Enter your email">
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 text-sm text-gray-600">
                    Your email address is unverified.
                    <button form="send-verification"
                        class="underline text-blue-600 hover:text-blue-800 transition font-medium">
                        Click here to re-send verification email
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-green-600 font-medium">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Submit -->
        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 active:bg-blue-800 transition">
                Save Changes
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2500)"
                   class="text-sm text-green-600 font-medium">
                    <i class="fa-solid fa-circle-check mr-1"></i> Saved successfully
                </p>
            @endif
        </div>
    </form>
</section>
