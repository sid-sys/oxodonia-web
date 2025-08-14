window.addEventListener('load', function () {
    setTimeout(function () {
        document.getElementById('help-popup').style.display = 'flex';
    }, 12000);
});

function closePopup() {
    document.getElementById('help-popup').style.display = 'none';
}



// Sync nice-select click with hidden <select>
document.querySelectorAll('.nice-select .option').forEach(option => {
    option.addEventListener('click', function () {
        let value = this.getAttribute('data-value');
        let select = this.closest('.form-item').querySelector('select[name="topic"]');
        let currentText = this.closest('.nice-select').querySelector('.current');

        if (select) {
            select.value = value;
            currentText.textContent = this.textContent;
        }
    });
});

// Attach to all forms
function handleFormSubmit(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        // Enforce required fields
        let fullname = form.querySelector('[name="fullname"]')?.value.trim();
        let topic = form.querySelector('[name="topic"]')?.value.trim();
        if (!fullname || !topic) {
            alert("Please fill in your name and select a topic.");
            return;
        }

        let formData = new FormData(this);

        fetch(this.action, {
            method: "POST",
            body: formData
        })
            .then(response => {
                if (response.ok) {
                    if (formId === "popup-contact-form") closePopup();
                    document.getElementById("success-popup").style.display = "flex";
                    form.reset();
                } else {
                    alert("There was an error sending your message. Please try again.");
                }
            })
            .catch(error => {
                console.error(error);
                alert("There was an error. Please try again.");
            });
    });
}

// Apply to all forms
handleFormSubmit("popup-contact-form");
handleFormSubmit("quote-form");
handleFormSubmit("ajax_contact");

function closeSuccessPopup() {
    document.getElementById("success-popup").style.display = "none";
}
