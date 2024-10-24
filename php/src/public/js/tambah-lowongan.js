// Initialize Quill editor
const quill = new Quill("#description-container", {
  theme: "snow",
});

// Submit handler for form
document
  .getElementById("lowongan-form")
  .addEventListener("submit", function (event) {
    const descriptionHTML = quill.root.innerHTML;
    document.getElementById("description").value = descriptionHTML;

    // Validate image
    const attachments = document.getElementById("attachments").files;
    for (let i = 0; i < attachments.length; i++) {
      const file = attachments[i];
      if (!file.type.startsWith("image/")) {
        showErrorToast(
          "Error type: " + attachments[i] + "Please upload only image files."
        );
        event.preventDefault();
      }
    }

    return true;
  });

document.addEventListener("DOMContentLoaded", function () {
  errorMessage = document
    .getElementById("session-data")
    .getAttribute("data-error-message");

  if (errorMessage && errorMessage.trim() != "" && errorMessage != null) {
    showErrorToast(errorMessage);
  }
});
