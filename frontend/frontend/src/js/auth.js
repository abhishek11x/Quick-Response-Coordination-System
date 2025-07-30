document.addEventListener('DOMContentLoaded', function() {
    // Handle login form submission
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const rememberMe = document.getElementById('remember-me')?.checked;

            try {
                const response = await fetch('./handlers/login_handler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email,
                        password,
                    }),
                });

                const data = await response.json();
                console.log('Login response:', data);
                
                if (data.error) {
                    throw new Error(data.error);
                }

                // Store user data
                const userData = data.user;
                if (rememberMe) {
                    localStorage.setItem('user', JSON.stringify(userData));
                } else {
                    sessionStorage.setItem('user', JSON.stringify(userData));
                }

                // Redirect to dashboard
                window.location.href = 'dashboard.html';
            } catch (error) {
                console.error('Login failed:', error);
                alert(error.message || 'Login failed. Please try again.');
            }
        });
    }

    // Handle signup form submission
    const signupForm = document.getElementById('signupForm');
    if (signupForm) {
        signupForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const firstName = document.getElementById('firstName').value;
            const lastName = document.getElementById('lastName').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            console.log('Attempting signup with:', { firstName, lastName, email });

            // Basic validation
            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                return;
            }

            try {
                console.log('Sending signup request...');
                const response = await fetch('./handlers/signup_handler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        firstName,
                        lastName,
                        email,
                        password,
                    }),
                });

                console.log('Response status:', response.status);
                console.log('Response headers:', [...response.headers.entries()]);

                const responseText = await response.text();
                console.log('Raw response:', responseText);

                let data;
                try {
                    data = JSON.parse(responseText);
                } catch (e) {
                    console.error('Failed to parse JSON:', e);
                    throw new Error('Server returned invalid JSON');
                }

                console.log('Parsed response:', data);

                if (data.error) {
                    throw new Error(data.error);
                }

                // Store user data
                sessionStorage.setItem('user', JSON.stringify(data.user));

                // Redirect to dashboard
                window.location.href = 'dashboard.html';
            } catch (error) {
                console.error('Signup failed:', error);
                alert(error.message || 'Signup failed. Please try again.');
            }
        });
    }
});