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
        if (xhr.readyState === 4 && xhr.status === 200) {
          console.log(xhr.responseText);
          // window.location.reload();
        }
      };

      xhr.send(JSON.stringify(data));
    };
  }
});
