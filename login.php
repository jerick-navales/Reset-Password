<div class="login-container text-center" id="login-container">
    <!-- Login Header -->
    <div class="login-header d-flex mb-4 align-items-center">
        <img src="Include/image/loginLogo.png" alt="SEDP Logo" id="logo">
        <div class="H-side">
            <h2 class="fw-bold">SEDP</h2>
            <p>Simbag sa Pag-Asenso Inc.</p>
        </div>
    </div>
    <hr class="border border-dark border-2 opacity-50">

    <!-- Login Form -->
    <div class="login-form-container mt-4" id="login-form">
        <form action="Database/login.php" method="POST">
            <!-- Email Input Field -->
            <div class="form-floating mb-4">
                <input type="email" class="form-control" name="email" id="email" placeholder=" " required>
                <label for="email" id="email-label" class="pt-4">Email</label>
            </div>

            <!-- Password Input Field -->
            <div class="form-floating mb-4">
                <div class="input-group">
                    <input type="password" class="form-control" name="password" id="password" placeholder=" " required>
                    <label for="password" id="password-label">Password</label>
                    <span class="input-group-text" id="toggle-password" onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <!-- Error message display -->
            <div id="forgot-password-message" class="text-danger" style="display: none; font-size: 14px;"></div>

            <div class="text-right mb-3" style="font-size:12px">
                <a href="#" class="forgot-password" onclick="showForgotPasswordForm()">Forgot Password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-block rounded-pill text-white p-2 mt-4" style="background-color: #003c3c;">Login</button>
        </form>
    </div>

    <!-- Forgot Password Form -->
    <div class="forgot-password-form mt-4 d-none" id="forgot-password-form">
        <h5 class="fw-bold">Forgot your password?</h5>
        <form action="forgotPasswordHandler.php" method="POST" id="forgot-password-step-1">
            <!-- Email Input Field -->
            <div class="form-floating mb-4">
                <input type="email" class="form-control" name="email" id="email" placeholder=" " required>
                <label for="email" id="email-label" class="pt-4">Email</label>
            </div>

            <!-- Error message container -->
            <div id="email-error-message" class="text-danger" style="display: none; font-size: 14px;"></div>

            <!-- Error message for forgot password -->
            <div id="forgot-password-message" class="text-danger" style="display: none; font-size: 14px;"></div>

            <!-- Continue Button -->
            <button type="submit" name="check_email" class="btn btn-block rounded-pill text-white p-2" style="background-color: #003c3c;">Continue</button>
        </form>
    </div>
</div>

