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
  document.getElementById("edit-lowongan-form").onsubmit = function (e) {
    e.preventDefault();

    const description = quill.root.innerHTML;
    document.getElementById("description").value = description;

    // attachment extension validation
    const attachments = document.getElementById("attachments").files;
    const allowedTypes = ["image/jpeg", "image/png"];
    let valid = true;

    for (let i = 0; i < attachments.length; i++) {
      if (!allowedTypes.includes(attachments[i].type)) {
        alert(
          "Invalid file type: " +
            attachments[i].name +
            ". Please upload images only (JPG, JPEG, PNG)."
        );
        valid = false;
        break;
      }
    }

    if (!valid) return;

    // form
    const formData = new FormData(this);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", window.location.href, true);

    // Menangani respon dari server
    xhr.onload = function () {
      const response = JSON.parse(xhr.responseText);
      if (xhr.status >= 200 && xhr.status < 300) {
        alert("Job updated successfully!");
        window.location.reload();
      } else {
        alert(
          "An error occurred while updating the job. Status: " +
            xhr.status +
            response.message
        );
      }
    };

    xhr.onerror = function () {
      alert("Request failed. There was an error during the transaction.");
    };

    xhr.send(formData);
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
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          alert(response.message);
          this.closest(".attachment-container").remove();
        } else {
          const response = JSON.parse(xhr.responseText);
          alert(response.message);
        }
      }.bind(this);

      const requestData = JSON.stringify({
        attachment_id: attachmentId,
        file_path: relativeFilePath,
      });
      console.log(requestData);
      xhr.send(requestData);
    });
  });
});
