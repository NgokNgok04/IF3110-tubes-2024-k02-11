document.addEventListener("DOMContentLoaded", function () {
  const logoButton = document.getElementById("logo");
  logoButton.addEventListener("click", function (event) {
    window.location.href = "/";
  });

  const navbarHome1 = document.getElementById("nav-home-1");
  if (navbarHome1) {
    navbarHome1.addEventListener("click", function (event) {
      window.location.href = "/";
    });
  }
  const navbarHome2 = document.getElementById("nav-home-2");
  if (navbarHome2) {
    navbarHome2.addEventListener("click", function (event) {
      window.location.href = "/";
    });
  }

  const navbarRiwayat = document.getElementById("nav-lowongan");
  if (navbarRiwayat) {
    navbarRiwayat.addEventListener("click", function (event) {
      window.location.href = "/riwayat";
    });
  }

  const navbarLogout1 = document.getElementById("nav-logout-1");
  if (navbarLogout1) {
    navbarLogout1.addEventListener("click", function (event) {
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "/logout", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            // Redirect to login page after successful logout
            window.location.href = "/login";
          } else {
            console.error("Logout failed");
          }
        }
      };
      // Send the request
      xhr.send();
    });
  }
  const navbarLogout2 = document.getElementById("nav-logout-2");
  if (navbarLogout2) {
    navbarLogout2.addEventListener("click", function (event) {
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "/logout", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            // Redirect to login page after successful logout
            window.location.href = "/login";
          } else {
            console.error("Logout failed");
          }
        }
      };
      // Send the request
      xhr.send();
    });
  }
  const navbarComProfile = document.getElementById("nav-com-profile");
  if (navbarComProfile) {
    navbarComProfile.addEventListener("click", function (event) {
      window.location.href = "/profil";
    });
  }
});
