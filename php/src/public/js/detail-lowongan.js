document.addEventListener("DOMContentLoaded", function () {
  var deleteLowonganBtn = document.getElementById("deleteLowonganBtn");
  var toogleLowonganBtn = document.getElementById("toogleLowonganBtn");
  var currentStatus = toogleLowonganBtn.dataset.status;

  deleteLowonganBtn.addEventListener("click", function (event) {
    if (confirm("Apakah Anda yakin ingin menghapus lowongan ini?")) {
      var xhr = new XMLHttpRequest();
      url = window.location.href;
      xhr.open("DELETE", url, true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            alert("Lowongan berhasil dihapus!");
            window.location.href = "/";
          } else {
            alert("Error deleting lowongan: " + xhr.statusText);
          }
        }
      };
      xhr.send();
    }
  });

  toogleLowonganBtn.addEventListener("click", function (event) {
    if (
      confirm(
        "Apakah Anda yakin ingin " +
          (currentStatus === "closed" ? "membuka" : "menutup") +
          " lowongan ini?"
      )
    ) {
      var xhr = new XMLHttpRequest();
      url = window.location.href;
      xhr.open("PUT", url, true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            alert("Lowongan status updated!");
            window.location.reload(); // Reload to reflect changes
          } else {
            let response = JSON.parse(xhr.responseText);
            alert("Error updating lowongan: " + response.message);
          }
        }
      };
      xhr.send();
    }
  });
});
