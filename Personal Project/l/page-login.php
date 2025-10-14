<?php
/**
 * Template Name: Login Page
 */

// Handle login form submission
if (isset($_POST['dcg_login_submit'])) {
    // Verify nonce
    if (!isset($_POST['dcg_login_nonce']) || !wp_verify_nonce($_POST['dcg_login_nonce'], 'dcg_login_action')) {
        $login_error = 'Security check failed. Please try again.';
    } else {
        $username = sanitize_text_field($_POST['username']);
        $password = $_POST['password'];
        $remember = isset($_POST['rememberme']);

        if (empty($username) || empty($password)) {
            $login_error = 'Please enter both username and password.';
        } else {
            $creds = array(
                'user_login'    => $username,
                'user_password' => $password,
                'remember'      => $remember
            );

            $user = wp_signon($creds, false);

            if (is_wp_error($user)) {
                $login_error = 'Invalid username or password. Please try again.';
            } else {
                // Login successful - redirect to home
                wp_redirect(home_url());
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
                <h1 class="auth-title">Welcome Back</h1>
                <p class="auth-subtitle">Sign in to your account to continue</p>
            </div>

            <?php
            // Display error messages
            if (isset($login_error)) {
                echo '<div class="auth-error">' . esc_html($login_error) . '</div>';
            }
            if (isset($_GET['registered']) && $_GET['registered'] === 'success') {
                echo '<div class="auth-success">Registration successful! Please log in.</div>';
            }
            if (isset($_GET['logout']) && $_GET['logout'] === 'success') {
                echo '<div class="auth-success">You have been logged out successfully.</div>';
            }
            ?>

            <form class="auth-form" method="post" action="">
                <?php wp_nonce_field('dcg_login_action', 'dcg_login_nonce'); ?>
                
                <div class="form-group">
                    <label for="username" class="form-label">Username or Email</label>
                    <input 
                        type="text" 
                        name="username" 
                        id="username" 
                        class="form-input" 
                        placeholder="Enter your username or email"
                        value="<?php echo isset($_POST['username']) ? esc_attr($_POST['username']) : ''; ?>"
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
                        placeholder="Enter your password"
                        required
                    >
                </div>

                <div class="form-group-inline">
                    <label class="checkbox-label">
                        <input type="checkbox" name="rememberme" value="1">
                        <span>Remember me</span>
                    </label>
                    <a href="<?php echo wp_lostpassword_url(); ?>" class="auth-link">Forgot password?</a>
                </div>
                
                <button type="submit" name="dcg_login_submit" class="auth-button">Sign In</button>
            </form>

            <div class="auth-footer">
                <p>Don't have an account? <a href="<?php echo esc_url(home_url('/signup')); ?>" class="auth-link-primary">Sign up</a></p>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
