import './bootstrap';

const applyStaggerDelays = () => {
    document.querySelectorAll('[data-stagger]').forEach((node) => {
        const rawValue = Number(node.getAttribute('data-stagger'));
        const step = Number.isFinite(rawValue) ? rawValue : 1;
        node.style.setProperty('--stagger-index', String(step));
    });
};

const setupPasswordToggles = () => {
    document.querySelectorAll('[data-toggle-password]').forEach((button) => {
        const targetId = button.getAttribute('data-toggle-password');
        const input = targetId ? document.getElementById(targetId) : null;

        if (!input) {
            return;
        }

        button.addEventListener('click', () => {
            const isPassword = input.getAttribute('type') === 'password';
            input.setAttribute('type', isPassword ? 'text' : 'password');
            button.textContent = isPassword ? 'Ocultar' : 'Mostrar';
        });
    });
};

const setupSubmitState = () => {
    document.querySelectorAll('.auth-form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                form.classList.remove('auth-shake');
                void form.offsetWidth;
                form.classList.add('auth-shake');
                return;
            }

            const submitButton = form.querySelector('button[type="submit"]');
            if (!submitButton) {
                return;
            }

            const loadingText = submitButton.getAttribute('data-loading-text');
            if (loadingText) {
                submitButton.dataset.originalText = submitButton.textContent ?? '';
                submitButton.textContent = loadingText;
            }

            submitButton.disabled = true;
            submitButton.setAttribute('aria-busy', 'true');
        });
    });
};

applyStaggerDelays();
setupPasswordToggles();
setupSubmitState();
