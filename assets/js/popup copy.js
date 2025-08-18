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

document.addEventListener("DOMContentLoaded", function () {
    handleFormSubmit("popup-contact-form");
    handleFormSubmit("quote-form");
    handleFormSubmit("ajax-contact");
});

function handleFormSubmit(formId) {
    const form = document.getElementById(formId);
    if (!form) {
        console.warn(`Form with ID '${formId}' not found`);
        return;
    }

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        console.log(`Submitting form: ${formId}`);

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
                console.log("Fetch response status:", response.status);
                if (response.ok) {
                    if (formId === "popup-contact-form") closePopup();
                    document.getElementById("success-popup").style.display = "flex";
                    form.reset();
                } else {
                    alert("❌ Error sending message.");
                }
            })
            .catch(error => {
                console.error("Fetch error:", error);
                alert("❌ Network error.");
            });
    });
}

// Apply to all forms
// handleFormSubmit("popup-contact-form");
// handleFormSubmit("quote-form");
// handleFormSubmit("ajax_contact");

function closeSuccessPopup() {
    document.getElementById("success-popup").style.display = "none";
}
