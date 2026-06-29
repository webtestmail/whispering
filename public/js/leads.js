(function () {
    const submitUrl = document.querySelector('meta[name="lead-submit-url"]')?.content;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    if (!submitUrl || !csrfToken) {
        return;
    }

    let recaptchaWidgetId = null;

    function initRecaptcha() {
        if (typeof grecaptcha === 'undefined') {
            return;
        }

        const widget = document.querySelector('.g-recaptcha');
        if (!widget || widget.dataset.rendered === '1') {
            return;
        }

        recaptchaWidgetId = grecaptcha.render(widget, {
            sitekey: widget.dataset.sitekey,
        });
        widget.dataset.rendered = '1';
    }

    function getFormData(container) {
        const formType = container.dataset.formType || 'contact';
        const data = { form_type: formType, _token: csrfToken };

        container.querySelectorAll('input[name], select[name], textarea[name]').forEach(function (field) {
            if (field.type === 'checkbox' && !field.checked) {
                return;
            }
            data[field.name] = field.value;
        });

        if (typeof grecaptcha !== 'undefined' && recaptchaWidgetId !== null && formType === 'contact') {
            data['g-recaptcha-response'] = grecaptcha.getResponse(recaptchaWidgetId);
        }

        return data;
    }

    function showSuccess(container) {
        const successEl = container.querySelector('[data-lead-success]') || container.parentElement?.querySelector('[data-lead-success]');
        const errorEl = container.querySelector('[data-lead-error]') || container.parentElement?.querySelector('[data-lead-error]');

        if (errorEl) {
            errorEl.style.display = 'none';
            errorEl.textContent = '';
        }
        if (successEl) {
            successEl.style.display = 'block';
        }

        container.querySelectorAll('input:not([type="hidden"]), select, textarea').forEach(function (field) {
            if (field.type === 'date' || field.type === 'text' || field.type === 'email' || field.type === 'tel' || field.tagName === 'TEXTAREA') {
                field.value = '';
            } else if (field.tagName === 'SELECT') {
                field.selectedIndex = 0;
            }
        });

        if (typeof grecaptcha !== 'undefined' && recaptchaWidgetId !== null) {
            grecaptcha.reset(recaptchaWidgetId);
        }
    }

    function showError(container, message) {
        const errorEl = container.querySelector('[data-lead-error]') || container.parentElement?.querySelector('[data-lead-error]');
        if (errorEl) {
            errorEl.textContent = message;
            errorEl.style.display = 'block';
        } else {
            alert(message);
        }
    }

    function submitLead(container, button) {
        const data = getFormData(container);
        const originalText = button.innerHTML;

        button.disabled = true;
        button.style.opacity = '0.7';

        fetch(submitUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(data),
        })
            .then(function (response) {
                return response.json().then(function (body) {
                    return { ok: response.ok, body: body };
                });
            })
            .then(function (result) {
                if (result.ok && result.body.success) {
                    showSuccess(container);
                } else if (result.body.errors) {
                    const messages = Object.values(result.body.errors).flat().join(' ');
                    showError(container, messages || 'Please check the form and try again.');
                } else {
                    showError(container, 'Something went wrong. Please try again.');
                }
            })
            .catch(function () {
                showError(container, 'Unable to send your message. Please try again later.');
            })
            .finally(function () {
                button.disabled = false;
                button.style.opacity = '';
                button.innerHTML = originalText;
            });
    }

    document.addEventListener('click', function (event) {
        const button = event.target.closest('[data-lead-submit]');
        if (!button) {
            return;
        }

        event.preventDefault();

        const container = button.closest('[data-lead-form]') || button.closest('#contactForm') || button.closest('#expBookForm');
        if (!container) {
            return;
        }

        const requiredFields = container.querySelectorAll('[required]');
        for (let i = 0; i < requiredFields.length; i++) {
            if (!requiredFields[i].value.trim()) {
                requiredFields[i].focus();
                showError(container, 'Please fill in all required fields.');
                return;
            }
        }

        submitLead(container, button);
    });

    document.addEventListener('submit', function (event) {
        const form = event.target.closest('.newsletter_form');
        if (!form) {
            return;
        }

        event.preventDefault();

        const emailInput = form.querySelector('input[type="email"]');
        if (!emailInput || !emailInput.value.trim()) {
            emailInput?.focus();
            return;
        }

        form.dataset.formType = 'newsletter';
        form.dataset.leadForm = '';

        const button = form.querySelector('button[type="submit"]');
        submitLead(form, button);
    });

    window.addEventListener('load', initRecaptcha);
    if (typeof grecaptcha !== 'undefined') {
        initRecaptcha();
    } else {
        window.leadRecaptchaInit = initRecaptcha;
    }
})();
