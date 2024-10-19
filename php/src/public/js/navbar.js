document.addEventListener("DOMContentLoaded", function () {
  const logoButton = document.getElementById("logo");
  logoButton.addEventListener("click", function (event) {
    window.location.href = "http://localhost:8000";
  });
});
