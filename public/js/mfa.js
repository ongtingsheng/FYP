document.addEventListener("DOMContentLoaded", function () {
    const inputs = document.querySelectorAll(".pin-input");
    const form = document.getElementById("mfa-form");

    inputs.forEach((input, index) => {
        input.addEventListener("input", (e) => {
            const value = e.target.value;

            // If non-numeric, show error and clear input
            if (!/^\d$/.test(value)) {
                e.target.value = "";
                showError("Only numbers are allowed!");
                return;
            }

            // Move to next input if valid digit entered
            if (index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        input.addEventListener("keydown", (e) => {
            // Allow backspace to move to the previous input
            if (e.key === "Backspace" && !e.target.value && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });

    // Form validation before submission
    form.addEventListener("submit", function (e) {
        let isValid = true;

        inputs.forEach(input => {
            if (input.value === "") {
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            showError("Please fill in all PIN fields.");
        }
    });

    // Resend PIN (Placeholder action)
    // document.getElementById("resend-link").addEventListener("click", function (e) {
    //     e.preventDefault();
    //     alert("New PIN sent to your email!");
    // });

    // Show error message
    function showError(message) {
        let errorDiv = document.getElementById("error-message");

        if (!errorDiv) {
            errorDiv = document.createElement("p");
            errorDiv.id = "error-message";
            errorDiv.classList.add("error-message");
            form.appendChild(errorDiv);
        }

        errorDiv.textContent = message;
        errorDiv.style.display = "block";

        // Remove error message after 3 seconds
        setTimeout(() => {
            errorDiv.style.display = "none";
        }, 3000);
    }
});
