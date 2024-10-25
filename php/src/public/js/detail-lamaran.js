document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("proses-lamaran-form");
  const statusReasonContainer = document.getElementById(
    "status-reason-container"
  );

  // Hanya inisialisasi Quill jika status-reason-container ada
  if (statusReasonContainer) {
    const quill = new Quill("#status-reason-container", {
      theme: "snow",
    });

    // Ketika form disubmit
    form.onsubmit = function (event) {
      event.preventDefault();

      const statusReasonContent = quill.root.innerHTML;
      document.getElementById("status-reason").value = statusReasonContent;

      const formData = new FormData(form);

      const data = {};
      formData.forEach((value, key) => {
        data[key] = value;
      });

      const xhr = new XMLHttpRequest();
      xhr.open("PUT", window.location.href, true);
      xhr.setRequestHeader("Content-Type", "application/json");

      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          const response = JSON.parse(xhr.responseText);
          closeModal();
          if (xhr.status === 200) {
            // Mengupdate Reason di halaman
            const newReasonElement = document.createElement("div");
            newReasonElement.innerHTML = statusReasonContent;
            const reasonLabelElement = document.createElement("p");
            reasonLabelElement.className = "lamaran-reason";
            reasonLabelElement.textContent = "Reason";
            const lamaranReasonContainer = document.querySelector(
              ".lamaran-reason-container"
            );
            lamaranReasonContainer.appendChild(reasonLabelElement);
            lamaranReasonContainer.appendChild(newReasonElement);

            // Update status dan hilangkan tombol
            const lamaranStatusText = document.querySelector(
              ".lamaran-status-btn p"
            );
            lamaranStatusText.textContent = ": " + data["status"]; // Ganti dengan status yang sesuai

            // Hapus tombol jika status sudah berubah
            const changeButton = document.getElementById("change-button");
            if (changeButton) {
              changeButton.remove();
            }

            showSuccessToast(response.message);
          } else {
            showErrorToast(response.message);
          }
        }
      };

      xhr.send(JSON.stringify(data));
    };
  }

  const modal = document.getElementById("myModal");
  const modalBg = document.getElementById("modalOverlay");

  function openModal() {
    modal.classList.remove("display-none");
    modalBg.classList.remove("display-none");
  }
  function closeModal() {
    modal.classList.add("display-none");
    modalBg.classList.add("display-none");
  }

  const changeButton = document.getElementById("change-button");
  if (changeButton) {
    changeButton.addEventListener("click", openModal);
  }

  const closeButton = document.getElementById("close-modal");
  if (closeButton) {
    closeButton.addEventListener("click", closeModal);
  }
});
