document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    if (!loginForm) return;

    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(loginForm);

        try {
            const res = await fetch('<?= site_url("auth/ajax_login") ?>'.replace('<?= site_url("auth/ajax_login") ?>','auth/ajax_login'), {
                method: 'POST',
                body: formData
            });
            const text = await res.text();
            if (text.trim() === 'OK') {
                window.location.href = '/';
            } else {
                let errBox = document.getElementById('loginError');
                if (errBox) {
                    errBox.textContent = text;
                    errBox.classList.remove('d-none');
                } else {
                    alert(text);
                }
            }
        } catch (err) {
            let errBox = document.getElementById('loginError');
            if (errBox) {
                errBox.textContent = 'Network error. Please try again.';
                errBox.classList.remove('d-none');
            } else {
                alert('Network error. Please try again.');
            }
        }
    });
});
