document.addEventListener("DOMContentLoaded", () => {
    
    // 1. CSRF Token ko ek baar meta tag se lein
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    /**
     * Yeh reusable function hai jo AJAX request bhejta hai.
     */
    async function handleFormSubmit(formElement, errorTextElement) {
        const actionUrl = formElement.dataset.action;
        const formData = new FormData(formElement);

        try {
            const response = await fetch(actionUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            // Server se mila response (JSON mein)
            const data = await response.json();

            // Agar response OK nahi hai (jaise 422, 500)
            if (!response.ok) {
                let errorMsg = "An unknown error occurred.";
                if (data.errors) {
                    // Yeh 422 Validation Error hai
                    errorMsg = Object.values(data.errors).map(e => e[0]).join('<br>');
                } else if (data.message) {
                    // Yeh 422/500 Error hai
                    errorMsg = data.message;
                }
                errorTextElement.style.display = 'block';
                errorTextElement.innerHTML = errorMsg;
            } else {
                // Success (200)
                if (data.status === 'success' && data.redirect_url) {
                    // Success, naye URL par redirect karein
                    window.location.href = data.redirect_url;
                } else {
                    errorTextElement.style.display = 'block';
                    errorTextElement.textContent = "Success, but no redirect URL provided.";
                }
            }
        } catch (error) {
            // Network error ya JSON parse error (e.g., 500 HTML response)
            console.error('Fetch Error:', error);
            errorTextElement.style.display = 'block';
            errorTextElement.textContent = 'A server error (500) or network error occurred. Check console.';
        }
    }

    /**
     * Naya setup function jo selectors ko sahi se dhoondhta hai.
     */
    function setupForm(formSelector) {
        // 1. Poora section select karein (e.g., ".signup")
        const formSection = document.querySelector(formSelector);
        
        if (!formSection) {
            return; // Agar section nahi mila
        }

        // 2. Section ke andar form aur error text dhoondhein
        const formElement = formSection.querySelector("form");
        const continueBtn = formSection.querySelector(".button input");
        const errorTextElement = formSection.querySelector(".error-text"); // <-- YEH HAI FIX

        if (!formElement || !continueBtn || !errorTextElement) {
            return;
        }

        formElement.onsubmit = (e) => e.preventDefault();
        
        continueBtn.onclick = () => {
            handleFormSubmit(formElement, errorTextElement);
        };
    }

    // Dono forms ko initialize karein
    setupForm(".signup");
    setupForm(".login");

});