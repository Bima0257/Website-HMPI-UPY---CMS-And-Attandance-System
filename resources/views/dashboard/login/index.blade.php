<x-Dashboard.layout-auth title="{{ $title }}">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="card auth-card">
                        <div class="card-body px-3 py-5">
                            <div class="mx-auto mb-4 text-center auth-logo">
                                <img src="{{ $abouts->large_logo ? asset('storage/' . $abouts->large_logo) : asset('assets_dashboard/images/logo-dark.png') }}"
                                    height="40" alt="large logo" class="mb-2">
                            </div>

                            <h2 class="fw-bold text-center fs-18">Login</h2>

                            <!-- Alert Messages -->
                            <div class="mb-3">
                                @if (session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show text-center"
                                        role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                @if (session()->has('loginError'))
                                    <div class="alert alert-danger alert-dismissible fade show text-center"
                                        role="alert">
                                        {{ session('loginError') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>

                            <div class="px-4">
                                <form action="/login" class="authentication-form" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" id="username" name="username"
                                            class="form-control @error('username') is-invalid @enderror"
                                            value="{{ old('username') }}" placeholder="Enter your username"
                                            autocomplete="off" required>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password">Password</label>
                                        <div class="input-group">
                                            <input type="password" id="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Enter your password" required>
                                            <span class="input-group-text"
                                                onclick="togglePasswordVisibility('password', 'toggleIcon')"
                                                style="cursor: pointer;">
                                                <iconify-icon icon="iconamoon:eye" width="15" height="15"
                                                    id="toggleIcon" class="text-muted"></iconify-icon>
                                            </span>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-1 text-center d-grid">
                                        <button class="btn btn-primary" type="submit">Login</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
    </div>

</x-Dashboard.layout-auth>

<script>
    function togglePasswordVisibility(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        const isHidden = passwordInput.type === 'password';

        // Toggle input type
        passwordInput.type = isHidden ? 'text' : 'password';

        // Ganti ikon
        icon.setAttribute('icon', isHidden ? 'iconamoon:eye-off' : 'iconamoon:eye');

        // Ganti warna
        icon.classList.remove('text-primary', 'text-muted');
        icon.classList.add(isHidden ? 'text-primary' : 'text-muted');
    }
</script>
