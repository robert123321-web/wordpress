// Handle URL parameters for messages
document.addEventListener("DOMContentLoaded", () => {
  const urlParams = new URLSearchParams(window.location.search)
  const messageContainer = document.getElementById("message-container")

  if (!messageContainer) return

  // Error messages
  const errorMessages = {
    empty_fields: "All fields are required.",
    invalid_credentials: "Invalid username or password.",
    password_mismatch: "Passwords do not match.",
    password_short: "Password must be at least 8 characters.",
    invalid_email: "Please enter a valid email address.",
    username_exists: "Username already exists.",
    email_exists: "Email already registered.",
    registration_failed: "Registration failed. Please try again.",
  }

  // Success messages
  const successMessages = {
    registered: "Registration successful! Please log in.",
  }

  // Check for error
  const error = urlParams.get("error")
  if (error && errorMessages[error]) {
    showMessage(errorMessages[error], "error")
  }

  // Check for success
  const success = urlParams.get("success")
  if (success && successMessages[success]) {
    showMessage(successMessages[success], "success")
  }

  // Form validation for signup
  const signupForm = document.getElementById("signupForm")
  if (signupForm) {
    signupForm.addEventListener("submit", (e) => {
      const password = document.getElementById("password").value
      const confirmPassword = document.getElementById("confirm_password").value

      if (password !== confirmPassword) {
        e.preventDefault()
        showMessage("Passwords do not match.", "error")
        return false
      }

      if (password.length < 8) {
        e.preventDefault()
        showMessage("Password must be at least 8 characters.", "error")
        return false
      }
    })
  }

  // Form validation for login
  const loginForm = document.getElementById("loginForm")
  if (loginForm) {
    loginForm.addEventListener("submit", (e) => {
      const username = document.getElementById("username").value.trim()
      const password = document.getElementById("password").value

      if (!username || !password) {
        e.preventDefault()
        showMessage("Please enter both username and password.", "error")
        return false
      }
    })
  }
})

function showMessage(message, type) {
  const messageContainer = document.getElementById("message-container")
  if (!messageContainer) return

  const className = type === "error" ? "auth-error" : "auth-success"
  messageContainer.innerHTML = `<div class="${className}">${message}</div>`
}
