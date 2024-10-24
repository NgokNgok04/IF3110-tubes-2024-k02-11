let debounceTimer;
let currPage = 1;

function debounceSearch() {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(function () {
    const searchInput = document.getElementById("searchInput").value;
    const locations = [
      ...document.querySelectorAll('input[name="locations[]"]:checked'),
    ].map((checkbox) => checkbox.value);
    const statuses = [
      ...document.querySelectorAll('input[name="statuses[]"]:checked'),
    ].map((checkbox) => checkbox.value);
    const jobtypes = [
      ...document.querySelectorAll('input[name="jobtypes[]"]:checked'),
    ].map((checkbox) => checkbox.value);
    console.log(jobtypes);
    const sort = document.getElementById("sort-by").value;

    const locationQuery =
      locations.length > 0
        ? `&locations[]=${locations.join("&locations[]=")}`
        : "";
    const statusQuery =
      statuses.length > 0 ? `&statuses[]=${statuses.join("&statuses[]=")}` : "";
    const jobtypeQuery =
      jobtypes.length > 0 ? `&jobtypes[]=${jobtypes.join("&jobtypes[]=")}` : "";

    const url = `/?search=${encodeURIComponent(
      searchInput
    )}${locationQuery}${statusQuery}${jobtypeQuery}&sort=${encodeURIComponent(
      sort
    )}&page=${encodeURIComponent(currPage)}`;

    window.history.pushState(
      {
        search: searchInput,
        locations,
        statuses,
        jobtypes,
        sort,
        page: currPage,
      },
      "",
      url
    );

    const xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(xhr.responseText, "text/html");
        const newList = doc.querySelector(".job-lists");
        const newPagination = doc.querySelector(".pagination");

        if (newList) {
          const existingList = document.querySelector(".job-lists");
          if (existingList) {
            existingList.innerHTML = newList.innerHTML;
          }
        }

        if (newPagination) {
          const existingPagination = document.querySelector(".pagination");
          if (existingPagination) {
            existingPagination.innerHTML = newPagination.innerHTML;
          }
        }

        attachJobCardListeners();
        attachPaginationListeners();
      }
    };
    xhr.send();
  }, 300);
}

document
  .getElementById("filters-form")
  .addEventListener("submit", function (event) {
    event.preventDefault();
  });

function attachPaginationListeners() {
  const paginationLinks = document.querySelectorAll(".pagination a");
  paginationLinks.forEach((link) => {
    link.addEventListener("click", function (event) {
      event.preventDefault();
      currPage = parseInt(this.getAttribute("data-page"));
      debounceSearch();
    });
  });
}

//initial attach
attachPaginationListeners();
attachJobCardListeners();

function attachJobCardListeners() {
  document.querySelectorAll(".job-card").forEach((button, index) => {
    button.addEventListener("click", () => openModal(index));
  });
  document.querySelectorAll(".close-modal").forEach((button) => {
    button.addEventListener("click", () => closeModal());
  });
}

function openModal(index) {
  const modal = document.getElementById("myModal");
  const modalBg = document.getElementById("modalOverlay");
  const modalViewBtn = document.getElementById("modal-view");
  const modalEditBtn = document.getElementById("modal-edit");
  const modalDeleteForm = document.getElementById("modal-delete");
  const modalSelectForm = document.getElementById("modal-select");

  const job_id = document
    .getElementById(`job-companyid-${index}`)
    .innerText.trim();

  modal.classList.remove("display-none");
  modalBg.classList.remove("display-none");

  document.getElementById("modal-title").innerText = document
    .getElementById(`job-title-${index}`)
    .innerText.trim();
  document.getElementById("modal-company").innerText = document
    .getElementById(`job-company-${index}`)
    .innerText.trim();
  document.getElementById("modal-location").innerText = document
    .getElementById(`job-location-${index}`)
    .innerText.trim();
  document.getElementById("modal-type").innerText = document
    .getElementById(`job-type-${index}`)
    .innerText.trim();
  document.getElementById("modal-status").innerText = document
    .getElementById(`job-status-${index}`)
    .innerText.trim();
  document.getElementById("modal-desc").innerHTML = document.getElementById(
    `job-desc-${index}`
  ).innerHTML;
  modalSelectForm.value = document
    .getElementById(`job-isOpen-${index}`)
    .innerText.trim();
  modalSelectForm.setAttribute("data-job-id", job_id);
  modalSelectForm.setAttribute("index", index);

  modalViewBtn.href = `/detail-lowongan/` + job_id;
  modalEditBtn.href = `/edit-lowongan/` + job_id;
  modalDeleteForm.action = `/detail-lowongan/delete/` + job_id;
  modalDeleteForm.method = "post";
}

function closeModal() {
  const modal = document.getElementById("myModal");
  const modalBg = document.getElementById("modalOverlay");
  modal.classList.add("display-none");
  modalBg.classList.add("display-none");
}

function moveSearchSection() {
  const searchSection = document.querySelector(".search-section");
  const mainContent = document.querySelector(".main-content");
  const main = document.querySelector("main");

  if (window.innerWidth <= 1000) {
    if (!mainContent.contains(searchSection)) {
      mainContent.appendChild(searchSection);
    }
  } else {
    if (mainContent.contains(searchSection)) {
      main.appendChild(searchSection);
    }
  }
}

window.addEventListener("load", moveSearchSection);
window.addEventListener("resize", moveSearchSection);
document.addEventListener("DOMContentLoaded", moveSearchSection);
document.addEventListener("DOMContentLoaded", function () {
  attachJobCardListeners();

  const closeModals = document.getElementById("close-modal");
  closeModals.addEventListener("click", closeModal);
});

document.addEventListener("DOMContentLoaded", function () {
  const selectElement = document.getElementById("modal-select");

  selectElement.addEventListener("change", function () {
    const form = document.getElementById("update-status-form");
    const formData = new FormData(form);
    const jobId = selectElement.getAttribute("data-job-id");
    const index = selectElement.getAttribute("index");

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/detail-lowongan/update/" + jobId, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    // Handle the response
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          alert(response.message); // Show success or error message
          document.getElementById("job-isOpen-" + index).innerText =
            selectElement.value;
        } else {
          alert("Error updating status");
        }
      }
    };

    // Send the form data
    console.log(form);
    xhr.send(formData);
  });
});
