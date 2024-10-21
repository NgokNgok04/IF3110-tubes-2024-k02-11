document.addEventListener("DOMContentLoaded", function () {
  // Inisialisasi Quill editor
  const quill = new Quill("#description-container", {
    theme: "snow",
  });

  // Ambil konten deskripsi yang tersimpan dari hidden input
  const savedDescription = document.getElementById("description").value;

  // Set konten Quill dengan deskripsi yang tersimpan (jika ada)
  if (savedDescription) {
    quill.root.innerHTML = savedDescription;
  }

  // Ketika formulir disubmit
  document.getElementById("edit-lowongan-form").onsubmit = function (e) {
    e.preventDefault(); // Mencegah pengiriman formulir secara default

    // Mengambil nilai deskripsi dari Quill
    const description = quill.root.innerHTML;
    document.getElementById("description").value = description; // Set nilai ke input hidden

    // Mengambil data formulir
    const formData = new FormData(this);

    // Mengirim data menggunakan XMLHttpRequest
    const xhr = new XMLHttpRequest();
    xhr.open("POST", window.location.href, true); // Menggunakan URL halaman saat ini

    // Menangani respon dari server
    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
        // Menangani respon sukses
        alert("Job updated successfully!");
        // Redirect atau reload halaman setelah update
        // window.location.reload(); // Uncomment jika ingin reload halaman
      } else {
        // Menangani kesalahan
        alert(
          "An error occurred while updating the job. Status: " + xhr.status
        );
      }
    };

    xhr.onerror = function () {
      alert("Request failed. There was an error during the transaction.");
    };

    // Mengirim data
    xhr.send(formData);
  };
});
