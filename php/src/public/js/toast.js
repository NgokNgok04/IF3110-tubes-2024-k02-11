function showSuccessToast(message) {
  const successToast = document.getElementById("success-toast");
  const successMessage = document.getElementById("success-message-content");
  if (successToast && successMessage) {
    successMessage.innerText = message;
    successToast.style.marginTop = "70px";
    successToast.classList.remove("hide");
    setTimeout(() => {
      successToast.classList.add("hide");
    }, 5000);
  }
}

function showErrorToast(message) {
  const errorToast = document.getElementById("error-toast");
  const errorMessage = document.getElementById("error-message-content");

  if (errorToast && errorMessage) {
    errorMessage.innerText = message;
    errorToast.style.marginTop = "70px";
    errorToast.classList.remove("hide");
    setTimeout(() => {
      errorToast.classList.add("hide");
    }, 5000);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  successMessage = document
    .getElementById("session-data")
    .getAttribute("data-success-message");

  if (successMessage && successMessage.trim() != "" && successMessage != null) {
    showSuccessToast(successMessage);
  }

  errorMessage = document
    .getElementById("session-data")
    .getAttribute("data-error-message");

  if (errorMessage && errorMessage.trim() != "" && errorMessage != null) {
    showErrorToast(errorMessage);
  }
});
