<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Update Password</h4>
            <p class="text-muted mb-4">
                Ensure your account is using a long, random password to stay secure.
            </p>

             @if (session('status') === 'password-updated')
                    <span class="text-success ms-2">
                        Password Change
                    </span>
                @endif

            <form action="{{ route('password.update') }}" method="POST" class="forms-sample">
                @csrf
                @method('PUT')

                {{-- Current Password --}}
                <div class="form-group mb-3">
                    <label for="current_password">Current Password</label>
                    <input
                        type="password"
                        name="current_password"
                        id="current_password"
                        class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                        autocomplete="current-password"
                    >
                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- New Password --}}
                <div class="form-group mb-3">
                    <label for="password">New Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                        autocomplete="new-password"
                    >
                    @error('password', 'updatePassword')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="form-group mb-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                        autocomplete="new-password"
                    >
                    @error('password_confirmation', 'updatePassword')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary me-2">
                    Save
                </button>

                @if (session('status') === 'password-updated')
                    <span class="text-success ms-2">
                        Saved.
                    </span>
                @endif

            </form>

        </div>
    </div>
</div>