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
(function () {
    function handleFormSubmit(formId) {
        const form = document.getElementById(formId);
        if (!form) {
            console.warn(`Form with ID '${formId}' not found`);
            return;
        }

        form.addEventListener("submit", function (e) {
            e.preventDefault(); // stop normal submit
            console.log(`Intercepted submit for: ${formId}`);

            let fullname = form.querySelector('[name="fullname"]')?.value.trim();
            let topic = form.querySelector('[name="topic"]')?.value.trim();

            if (!fullname || !topic) {
                alert("Please fill in your name and select a topic.");
                return;
            }

            let formData = new FormData(form);

            fetch(form.action, {
                method: "POST",
                body: formData
            })
                .then(response => {
                    if (response.ok) {
                        // ✅ Only close the popup for the popup form, not for ajax-contact
                        if (formId === "popup-contact-form") closePopup();
                        // header("Location: /index.html");
                        // document.getElementById("success-popup").style.display = "flex"; // ✅ green tick popup
                        form.reset();
                    } else {
                        alert("❌ There was an error sending your message.");
                    }
                })
                .catch(error => {
                    console.error("Fetch error:", error);
                    alert("❌ Network error.");
                });
        });
    }

    // Attach handlers to all forms
    handleFormSubmit("popup-contact-form");
    handleFormSubmit("quote-form");
    handleFormSubmit("ajax-contact"); // ✅ contact page form now works
})();

function closeSuccessPopup() {
    document.getElementById("success-popup").style.display = "none";
}
