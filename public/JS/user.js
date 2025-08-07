// User Profile Management JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide messages after 5 seconds
    const messages = document.querySelectorAll('.message');
    messages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => {
                message.style.display = 'none';
            }, 300);
        }, 5000);
    });

    // Form validation
    const form = document.getElementById('profileForm');
    const saveBtn = document.getElementById('saveBtn');

    if (form) {
        form.addEventListener('submit', function(e) {
            const fullname = document.getElementById('fullname').value.trim();
            const email = document.getElementById('email').value.trim();
            const mobile = document.getElementById('mobile').value.trim();

            // Reset previous error states
            clearErrors();

            let hasErrors = false;

            // Validate fullname
            if (!fullname) {
                showError('fullname', 'Họ và tên là bắt buộc');
                hasErrors = true;
            } else if (fullname.length < 2) {
                showError('fullname', 'Họ và tên phải có ít nhất 2 ký tự');
                hasErrors = true;
            }

            // Validate email
            if (!email) {
                showError('email', 'Email là bắt buộc');
                hasErrors = true;
            } else if (!isValidEmail(email)) {
                showError('email', 'Email không hợp lệ');
                hasErrors = true;
            }

            // Validate mobile (optional but if provided, must be valid)
            if (mobile && !isValidPhone(mobile)) {
                showError('mobile', 'Số điện thoại không hợp lệ');
                hasErrors = true;
            }

            if (hasErrors) {
                e.preventDefault();
                return false;
            }

            // Show loading state
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang lưu...';
        });
    }

    // Real-time validation
    const inputs = document.querySelectorAll('.form-group input, .form-group textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });

        input.addEventListener('input', function() {
            // Clear error when user starts typing
            clearFieldError(this);
        });
    });

    // Sidebar navigation
    const sidebarLinks = document.querySelectorAll('.sidebar ul li a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Remove active class from all links
            sidebarLinks.forEach(l => l.classList.remove('active'));
            // Add active class to clicked link
            this.classList.add('active');
        });
    });
});

// Helper functions
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPhone(phone) {
    // Accept Vietnamese phone numbers
    const phoneRegex = /^(\+84|84|0)[0-9]{9}$/;
    return phoneRegex.test(phone.replace(/\s/g, ''));
}

function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name || field.id;

    clearFieldError(field);

    switch (fieldName) {
        case 'fullname':
            if (!value) {
                showFieldError(field, 'Họ và tên là bắt buộc');
            } else if (value.length < 2) {
                showFieldError(field, 'Họ và tên phải có ít nhất 2 ký tự');
            }
            break;

        case 'email':
            if (!value) {
                showFieldError(field, 'Email là bắt buộc');
            } else if (!isValidEmail(value)) {
                showFieldError(field, 'Email không hợp lệ');
            }
            break;

        case 'mobile':
            if (value && !isValidPhone(value)) {
                showFieldError(field, 'Số điện thoại không hợp lệ');
            }
            break;
    }
}

function showFieldError(field, message) {
    const formGroup = field.closest('.form-group');
    const existingError = formGroup.querySelector('.field-error');
    
    if (!existingError) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.color = '#dc3545';
        errorDiv.style.fontSize = '0.875rem';
        errorDiv.style.marginTop = '0.25rem';
        errorDiv.textContent = message;
        
        formGroup.appendChild(errorDiv);
    }
    
    field.style.borderColor = '#dc3545';
}

function clearFieldError(field) {
    const formGroup = field.closest('.form-group');
    const errorDiv = formGroup.querySelector('.field-error');
    
    if (errorDiv) {
        errorDiv.remove();
    }
    
    field.style.borderColor = '#e1e5e9';
}

function clearErrors() {
    const errorDivs = document.querySelectorAll('.field-error');
    errorDivs.forEach(div => div.remove());
    
    const inputs = document.querySelectorAll('.form-group input, .form-group textarea');
    inputs.forEach(input => {
        input.style.borderColor = '#e1e5e9';
    });
}

function showError(fieldName, message) {
    const field = document.getElementById(fieldName);
    if (field) {
        showFieldError(field, message);
    }
}

// Add smooth transitions for better UX
document.addEventListener('DOMContentLoaded', function() {
    // Add transition styles dynamically
    const style = document.createElement('style');
    style.textContent = `
        .form-group input,
        .form-group textarea {
            transition: border-color 0.3s ease;
        }
        
        .message {
            transition: opacity 0.3s ease;
        }
        
        .save-btn,
        .cancel-btn {
            transition: all 0.3s ease;
        }
    `;
    document.head.appendChild(style);
}); 
