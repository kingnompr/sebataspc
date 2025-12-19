@extends('account.layout')

@section('title', 'Edit Profil')

@section('content')
    <!-- Edit Profile Form -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Edit Profil</h2>

        @if(session('status'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('account.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Profile Photo -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                <div class="flex items-center gap-4">
                    @if($user->profile_photo_path)
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" class="size-20 rounded-full object-cover" id="profilePreview">
                    @else
                        <div class="size-20 rounded-full bg-blue-100 flex items-center justify-center text-3xl font-bold text-primary" id="profilePreview">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="hidden" onchange="previewImage(this)">
                        <label for="profile_photo" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <span class="material-symbols-outlined text-lg">upload</span>
                            Unggah Foto
                        </label>
                        <p class="text-xs text-gray-500 mt-1">JPG, PNG atau GIF. Maksimal 2MB.</p>
                    </div>
                </div>
            </div>

            <!-- Username -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Pengguna</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name', $user->name) }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                >
            </div>

            <!-- Email (Read-only) -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    value="{{ $user->email }}"
                    disabled
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500"
                >
                <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah</p>
            </div>

            <!-- Change Password Section -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ubah Password</h3>
                <p class="text-sm text-gray-600 mb-4">Kosongkan jika tidak ingin mengubah password</p>

                <div class="space-y-4">
                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                        <input 
                            type="password" 
                            name="current_password" 
                            id="current_password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        >
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        >
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        >
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-6 border-t border-gray-200">
                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 font-medium">
                    Simpan Perubahan
                </button>
                <a href="{{ route('account.overview') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                const preview = document.getElementById('profilePreview');
                
                reader.onload = function(e) {
                    // Create img element if preview is a div
                    if (preview.tagName === 'DIV') {
                        preview.outerHTML = `<img src="${e.target.result}" alt="Preview" class="size-20 rounded-full object-cover" id="profilePreview">`;
                    } else {
                        preview.src = e.target.result;
                    }
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
