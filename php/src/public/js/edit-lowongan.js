document.addEventListener("DOMContentLoaded", function () {
  const quill = new Quill("#description-container", {
    theme: "snow",
  });

  // hidden input
  const savedDescription = document.getElementById("description").value;

  if (savedDescription) {
    quill.root.innerHTML = savedDescription;
  }

  // event listener untuk form
  document.getElementById("edit-lowongan-form").onsubmit = function (event) {
    const description = quill.root.innerHTML;
    document.getElementById("description").value = description;

    // attachment extension validation
    const attachments = document.getElementById("attachments").files;
    const allowedTypes = ["image/jpeg", "image/png"];

    for (let i = 0; i < attachments.length; i++) {
      if (!allowedTypes.includes(attachments[i].type)) {
        showErrorToast(
          "Invalid file type: " +
            attachments[i].name +
            ". Please upload images only (JPG, JPEG, PNG)."
        );
        event.preventDefault();
      }
    }

    return true;
  };

  // Event listener untuk setiap tombol hapus
  document.querySelectorAll(".remove-attachment").forEach((button) => {
    button.addEventListener("click", function () {
      const attachmentId = this.dataset.id;
      const filePath = this.previousElementSibling.src;

      const relativeFilePath = new URL(filePath).pathname;

      const xhr = new XMLHttpRequest();
      const url = window.location.href + "/delete";
      xhr.open("POST", url, true);
      xhr.setRequestHeader("Content-Type", "application/json");

      xhr.onload = function () {
        const response = JSON.parse(xhr.responseText);
        if (xhr.status === 200) {
          showSuccessToast(response.message);
          this.closest(".attachment-container").remove();
        } else {
          showErrorToast(response.message);
        }
      }.bind(this);

      const requestData = JSON.stringify({
        attachment_id: attachmentId,
        file_path: relativeFilePath,
      });

      xhr.send(requestData);
    });
  });
});
