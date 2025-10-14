<?php
/**
 * Template Name: Signup Page
 */

// Handle registration form submission
if (isset($_POST['dcg_signup_submit'])) {
    // Verify nonce
    if (!isset($_POST['dcg_signup_nonce']) || !wp_verify_nonce($_POST['dcg_signup_nonce'], 'dcg_signup_action')) {
        $signup_error = 'Security check failed. Please try again.';
    } else {
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate
        if (empty($username) || empty($email) || empty($password)) {
            $signup_error = 'All fields are required.';
        } elseif ($password !== $confirm_password) {
            $signup_error = 'Passwords do not match.';
        } elseif (strlen($password) < 8) {
            $signup_error = 'Password must be at least 8 characters.';
        } elseif (username_exists($username)) {
            $signup_error = 'Username already exists. Please choose another.';
        } elseif (email_exists($email)) {
            $signup_error = 'Email already registered. Please use another email or login.';
        } elseif (!is_email($email)) {
            $signup_error = 'Please enter a valid email address.';
        } else {
            // Create user
            $user_id = wp_create_user($username, $password, $email);

            if (is_wp_error($user_id)) {
                $signup_error = $user_id->get_error_message();
            } else {
                // Success - redirect to login
                wp_redirect(home_url('/login?registered=success'));
                exit;
            }
        }
    }
}

// Redirect if already logged in
if (is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
}

get_header();
?>

<main class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Create Account</h1>
                <p class="auth-subtitle">Join our creative code community</p>
            </div>

            <?php
            // Display error messages
            if (isset($signup_error)) {
                echo '<div class="auth-error">' . esc_html($signup_error) . '</div>';
            }
            ?>

            <form class="auth-form" method="post" action="">
                <?php wp_nonce_field('dcg_signup_action', 'dcg_signup_nonce'); ?>

                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input 
                        type="text" 
                        name="username" 
                        id="username" 
                        class="form-input" 
                        placeholder="Choose a username"
                        value="<?php echo isset($_POST['username']) ? esc_attr($_POST['username']) : ''; ?>"
                        required
                        pattern="[a-zA-Z0-9_]+"
                        title="Username can only contain letters, numbers, and underscores"
                    >
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-input" 
                        placeholder="Enter your email"
                        value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-input" 
                        placeholder="Create a strong password"
                        required
                        minlength="8"
                    >
                    <small class="form-hint">Minimum 8 characters</small>
                </div>

                <div class="form-group">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input 
                        type="password" 
                        name="confirm_password" 
                        id="confirm_password" 
                        class="form-input" 
                        placeholder="Confirm your password"
                        required
                        minlength="8"
                    >
                </div>

                <div class="form-group-inline">
                    <label class="checkbox-label">
                        <input type="checkbox" name="terms" required>
                        <span>I agree to the Terms of Service</span>
                    </label>
                </div>

                <button type="submit" name="dcg_signup_submit" class="auth-button">Create Account</button>
            </form>

            <div class="auth-footer">
                <p>Already have an account? <a href="<?php echo esc_url(home_url('/login')); ?>" class="auth-link-primary">Sign in</a></p>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
