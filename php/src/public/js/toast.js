// document.addEventListener("DOMContentLoaded", function () {
//   const errorToast = document.getElementById("error-toast");
//   const errorMessage = document.getElementById("error-message-content");

//   const sessionDataElement = document.getElementById("session-data");
//   const message = sessionDataElement.getAttribute("data-error-message");
//   if (errorToast && message) {
//     errorMessage.innerText = message;
//     setTimeout(() => {
//       errorToast.style.marginTop = "70px";
//       errorToast.classList.remove("hide");
//       setTimeout(() => {
//         errorToast.classList.add("hide");
//       }, 5000);
//     }, 500);
//   }
// });

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
