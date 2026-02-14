<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Profile Information</h4>
            <p class="text-muted mb-4">
                Update your account's profile information and email address.
            </p>

            @if (session('status') === 'profile-updated')
                    <span class="text-success ms-2">
                        Profile Updated
                    </span>
                @endif

            {{-- Email Verification Form --}}
            <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
                @csrf
            </form>

            {{-- Profile Update Form --}}
            <form action="{{ route('profile.update') }}" method="POST" class="forms-sample">
                @csrf
                @method('PATCH')

                {{-- Name --}}
                <div class="form-group mb-3">
                    <label for="name">Firm Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}"
                        required
                        autofocus
                    >
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}"
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Email Verification --}}
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="alert alert-warning">
                        Your email address is unverified.
                        <button
                            type="submit"
                            form="send-verification"
                            class="btn btn-link p-0 align-baseline"
                        >
                            Click here to re-send the verification email.
                        </button>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success">
                            A new verification link has been sent to your email address.
                        </div>
                    @endif
                @endif

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary me-2">
                    Save
                </button>

                

            </form>

        </div>
    </div>
</div>