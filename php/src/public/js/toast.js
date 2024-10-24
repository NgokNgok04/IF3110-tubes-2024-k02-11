document.addEventListener("DOMContentLoaded", function () {
  const errorToast = document.getElementById("error-toast");
  const errorMessage = document.getElementById("error-message-content");

  const sessionDataElement = document.getElementById("session-data");
  const message = sessionDataElement.getAttribute("data-error-message");
  if (errorToast && message) {
    errorMessage.innerText = message;
    setTimeout(() => {
      errorToast.style.marginTop = "70px";
      errorToast.classList.remove("hide");
      setTimeout(() => {
        errorToast.classList.add("hide");
      }, 5000);
    }, 500);
  }
});
