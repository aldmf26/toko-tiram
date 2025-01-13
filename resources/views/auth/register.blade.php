<x-guest-layout>
    <div id="auth-left">
        <div class="auth-logo">
            <a href="index.html"><img src="{{ asset('/images/logo/logo.png') }}" alt="Logo"></a>
        </div>
        <h1 class="auth-title">Sign Up</h1>
        <p class="auth-subtitle mb-5">Input your data to register to our website.</p>

        <form action="" method="POST">
            @csrf
            <div class="form-group position-relative has-icon-left mb-4">
                <input type="text" class="form-control form-control-xl" name="name" placeholder="Fullname">
                <div class="form-control-icon">
                    <i class="bi bi-person"></i>
                </div>
            </div>
            <div class="form-group position-relative has-icon-left mb-4">
                <input type="email" class="form-control form-control-xl" name="email" placeholder="Email">
                <div class="form-control-icon">
                    <i class="bi bi-envelope"></i>
                </div>
            </div>
            <div class="form-group position-relative has-icon-left mb-4">
                <input type="password" class="form-control form-control-xl" name="password" placeholder="Password">
                <div class="form-control-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
            </div>
            <div class="form-group position-relative has-icon-left mb-4">
                <input type="password" class="form-control form-control-xl" name="password_confirmation" placeholder="Confirm Password">
                <div class="form-control-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
            </div>
          
            <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign Up</button>
        </form>
        <div class="text-center mt-5 text-lg fs-4">
            <p class='text-gray-600'>Already have an account? <a href="{{ route('login') }}"
                    class="font-bold">Log
                    in</a>.</p>
        </div>
    </div>
</x-guest-layout>
