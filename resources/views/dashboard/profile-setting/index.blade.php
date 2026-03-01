<x-Dashboard.main-layout title="{{ $title }}">
    <div class="col-xxl-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Profile</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Foto Profil --}}
                    <label for="avatar" class="form-label">Foto Profil</label>
                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-3">
                            {{-- Preview Avatar --}}
                            <img id="avatar-preview"
                                src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets_dashboard/images/users/user1.png') }}"
                                alt="avatar" class="rounded-circle mb-2" width="70" height="70">
                        </div>
                        <input type="file" name="avatar" id="avatar"
                            class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Username --}}
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username', Auth::user()->username) }}" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- Password Lama --}}
                    <div class="mb-3">
                        <label for="old_password" class="form-label">Password Lama</label>
                        <div class="input-group">
                            <input type="password" name="old_password" id="old_password"
                                class="form-control @error('old_password') is-invalid @enderror"
                                placeholder="Masukkan password lama">
                            <button type="button" class="btn btn-outline-secondary toggle-password"
                                data-target="old_password" tabindex="-1">
                                <i class="bx bx-show"></i>
                            </button>
                            @error('old_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Password Baru --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Kosongkan jika tidak ingin mengganti">
                            <button type="button" class="btn btn-outline-secondary toggle-password"
                                data-target="password" tabindex="-1">
                                <i class="bx bx-show"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Konfirmasi Password Baru --}}
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="Konfirmasi password baru">
                            <button type="button" class="btn btn-outline-secondary toggle-password"
                                data-target="password_confirmation" tabindex="-1">
                                <i class="bx bx-show"></i>
                            </button>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>



                    {{-- Tombol Simpan --}}
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-Dashboard.main-layout>

<script>
    document.getElementById('avatar').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            document.getElementById('avatar-preview').src = URL.createObjectURL(file);
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Tombol show/hide password
        document.querySelectorAll(".toggle-password").forEach(btn => {
            btn.addEventListener("click", function() {
                const targetId = this.getAttribute("data-target");
                const input = document.getElementById(targetId);
                const icon = this.querySelector("i");

                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("bx-show");
                    icon.classList.add("bx-hide");
                } else {
                    input.type = "password";
                    icon.classList.remove("bx-hide");
                    icon.classList.add("bx-show");
                }
            });
        });
    });
</script>
