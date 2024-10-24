document.addEventListener('DOMContentLoaded', function() {
    const successToast = document.getElementById("success-toast");
    const successMessage = document.getElementById("success-message-content");
    const message = "<?php echo $successMessage; ?>";
    if (successToast && message) {
        successMessage.innerText = message;
        setTimeout(() => {
            successToast.style.marginTop = "70px"; 
            successToast.classList.remove("hide");
            setTimeout(() => {
                successToast.classList.add("hide");
            }, 5000);
        }, 500); 
    }
});
