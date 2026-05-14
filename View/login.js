document.addEventListener('DOMContentLoaded', () => {
    const card = document.getElementById('card');
    const wrapper = document.querySelector('.glass-wrapper');
    const form = document.getElementById('loginForm');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const togglePassBtn = document.getElementById('togglePass');
    const eyeIcon = document.getElementById('eyeIcon');
    const loginBtn = document.getElementById('loginBtn');
    const btnText = document.getElementById('btnText');
    const btnLoader = document.getElementById('btnLoader');
    const params = new URLSearchParams(window.location.search);
    const loginError = params.get('error');

    if (loginError === 'incorrect_password') {
        passwordInput.closest('.form-group').classList.add('has-error');
        showToast('Login Failed', 'Incorrect password. Please try again.');
    }

    if (loginError === 'user_not_found') {
        usernameInput.closest('.form-group').classList.add('has-error');
        showToast('Login Failed', 'User not found.');
    }

    // 1. Toggle Password Visibility
    togglePassBtn.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        
        if (isPassword) {
            eyeIcon.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                <line x1="1" y1="1" x2="23" y2="23"></line>
            `;
        } else {
            eyeIcon.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            `;
        }
    });

    // 2. Clear errors on input
    const clearError = (inputId) => {
        document.getElementById(inputId).closest('.form-group').classList.remove('has-error');
    };
    usernameInput.addEventListener('input', () => clearError('username'));
    passwordInput.addEventListener('input', () => clearError('password'));

    // 3. Form Validation & Submission
    form.addEventListener('submit', (e) => {
        let isValid = true;

        // Simple validation
        if (!usernameInput.value.trim()) {
            usernameInput.closest('.form-group').classList.add('has-error');
            isValid = false;
        }
        if (!passwordInput.value) {
            passwordInput.closest('.form-group').classList.add('has-error');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            return;
        }

        btnText.style.display = 'none';
        btnLoader.style.display = 'block';
        loginBtn.style.opacity = '0.8';
    });
});

// 4. Custom Toast Notification System
function showToast(title, message) {
    const toastBox = document.getElementById('toastBox');
    
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        <div>
            <div style="font-weight: 600; font-size: 0.95rem; margin-bottom: 2px;">${title}</div>
            <div style="font-size: 0.85rem; color: var(--text-muted);">${message}</div>
        </div>
    `;
    
    toastBox.appendChild(toast);

    // Animate in
    requestAnimationFrame(() => {
        toast.classList.add('show');
    });

    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 400); // wait for CSS transition
    }, 3000);
}
