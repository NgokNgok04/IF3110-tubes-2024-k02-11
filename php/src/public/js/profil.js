document
  .getElementById("profile-form")
  .addEventListener("submit", function (event) {
    const companyName = document.getElementById("company-name");
    const lokasi = document.getElementById("lokasi");
    const about = document.getElementById("about");

    let isValid = true;
    let errorMessage = "";

    if (!companyName) {
      isValid = false;
      errorMessage += "Company name is required.\n";
    }

    if (!lokasi) {
      isValid = false;
      errorMessage += "Location is required.\n";
    }

    if (!about) {
      isValid = false;
      errorMessage += "About is required.\n";
    }

    if (!isValid) {
      event.preventDefault();
      alert(errorMessage);
      return false;
    }

    return true;
  });
