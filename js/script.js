// ==========================================
// 1. NAVBAR SCROLL EFFECT
// ==========================================
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('nav.navbar');
    if (navbar) {
        if (window.scrollY > 30) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    }
});

// ==========================================
// 2. DARK MODE / LIGHT MODE TOGGLE
// ==========================================
function initThemeToggle() {
    const themeToggleBtn = document.getElementById('themeToggle');
    const htmlElement = document.documentElement;
    
    // Load saved theme from localStorage
    const savedTheme = localStorage.getItem('theme') || 'light';
    htmlElement.setAttribute('data-bs-theme', savedTheme);
    updateThemeButton(savedTheme);
    
    // Toggle theme on button click
    themeToggleBtn.addEventListener('click', function() {
        const currentTheme = htmlElement.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        htmlElement.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeButton(newTheme);
    });
}

function updateThemeButton(theme) {
    const themeToggleBtn = document.getElementById('themeToggle');
    const icon = themeToggleBtn.querySelector('i');
    
    if (theme === 'dark') {
        themeToggleBtn.innerHTML = '<i class="bi bi-brightness-high"></i> Light Mode';
        themeToggleBtn.classList.add('btn-warning');
        themeToggleBtn.classList.remove('btn-dark');
    } else {
        themeToggleBtn.innerHTML = '<i class="bi bi-moon"></i> Dark Mode';
        themeToggleBtn.classList.add('btn-dark');
        themeToggleBtn.classList.remove('btn-warning');
    }
}

// ==========================================
// 3. SERVICE PAGE - DYNAMIC FILTERING
// ==========================================
function initServiceFilter() {
    const filterInput = document.getElementById('serviceFilter');
    const serviceCards = document.querySelectorAll('.service-card');
    
    if (!filterInput) return;
    
    filterInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        serviceCards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const content = card.querySelector('.card-text').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || content.includes(searchTerm)) {
                card.parentElement.style.display = 'block';
            } else {
                card.parentElement.style.display = 'none';
            }
        });
    });
}

// ==========================================
// 4. CONTACT FORM VALIDATION
// ==========================================
function initFormValidation() {
    const contactForm = document.getElementById('contactForm');
    const validationMessage = document.getElementById('validationMessage');
    
    if (!contactForm) return;
    
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form values
        const nameInput = document.getElementById('nameInput');
        const emailInput = document.getElementById('emailInput');
        const messageInput = document.getElementById('messageInput');
        
        const name = nameInput ? nameInput.value.trim() : '';
        const email = emailInput ? emailInput.value.trim() : '';
        const message = messageInput ? messageInput.value.trim() : '';
        
        // Validation logic
        let errors = [];
        
        // Check empty fields
        if (!name) {
            errors.push('Vārds ir obligāts.');
        }
        if (!email) {
            errors.push('E-pasts ir obligāts.');
        }
        if (!message) {
            errors.push('Ziņojums ir obligāts.');
        }
        
        // Validate email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email && !emailRegex.test(email)) {
            errors.push('Lūdzu, ievadiet derīgu e-pasta adresi.');
        }
        
        // Check minimum message length
        if (message && message.length < 10) {
            errors.push('Ziņojumam jābūt vismaz 10 rakstzīmes garumā.');
        }
        
        // Display validation messages
        if (errors.length > 0) {
            displayValidationError(errors, validationMessage);
        } else {
            displayValidationSuccess(validationMessage);
            // Optional: Reset form
            setTimeout(() => {
                contactForm.reset();
                validationMessage.innerHTML = '';
            }, 2000);
        }
    });
}

function displayValidationError(errors, container) {
    let errorHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    errorHTML += '<strong>Lūdzu, labojiet šādas kļūdas:</strong><ul style="margin-bottom: 0; margin-top: 10px;">';
    
    errors.forEach(error => {
        errorHTML += `<li>${error}</li>`;
    });
    
    errorHTML += '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    
    container.innerHTML = errorHTML;
}

function displayValidationSuccess(container) {
    const successHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    const message = 'Paldies! Jūsu ziņojums ir nosūtīts veiksmīgi.';
    container.innerHTML = successHTML + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}

// ==========================================
// 5. DYNAMIC FOOTER WITH CURRENT YEAR
// ==========================================
function initDynamicFooter() {
    const yearElement = document.getElementById('year');
    if (yearElement) {
        yearElement.textContent = new Date().getFullYear();
    }
    
    // Add hover effect to footer
    const footer = document.querySelector('footer');
    if (footer) {
        footer.addEventListener('mouseenter', function() {
            this.classList.add('footer-hover');
        });
        
        footer.addEventListener('mouseleave', function() {
            this.classList.remove('footer-hover');
        });
    }
}

// ==========================================
// INITIALIZE ALL FEATURES ON PAGE LOAD
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    initThemeToggle();
    initServiceFilter();
    initFormValidation();
    initDynamicFooter();
});
