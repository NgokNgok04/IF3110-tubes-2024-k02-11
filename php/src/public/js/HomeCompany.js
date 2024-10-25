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

let currentIndexGlobal = -1;
function openModal(index) {
  currentIndexGlobal = index;
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
  const AttachmentModal = document.querySelectorAll(`.attachment-${index}`);
  document.getElementById(`btn-prev-${index}`).classList.remove("display-none");
  document.getElementById(`btn-next-${index}`).classList.remove("display-none");
  console.log(AttachmentModal);
  document.getElementById("Attachment-Image").src =
    AttachmentModal[0].innerText;
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
  document
    .getElementById(`btn-prev-${currentIndexGlobal}`)
    .classList.add("display-none");
  document
    .getElementById(`btn-next-${currentIndexGlobal}`)
    .classList.add("display-none");
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

  const addLowongan = document.getElementById("addLowongan");
  addLowongan.addEventListener("click", () => {
    window.location.href = `/tambah-lowongan`;
  });
  let currentIndex = 0;

  function moveSlide(step, index) {
    const images = document.getElementById("Attachment-Image");
    console.log("INDEXX : ", index);
    const AttachmentLink = document.querySelectorAll(`.attachment-${index}`);

    console.log("ATTACHMENT LINK", AttachmentLink);
    currentIndex += step;
    console.log("CURRENT INDEX BEFORE:", currentIndex);
    if (currentIndex < 0) {
      currentIndex = AttachmentLink.length - 1;
    } else if (currentIndex >= AttachmentLink.length) {
      currentIndex = 0;
    }

    console.log("CURRENT INDEX :", currentIndex);
    currentImage = AttachmentLink[currentIndex].innerText;
    console.log("CURRENT IMAGE :", currentIndex);
    console.log(currentImage);
    images.src = currentImage;
  }

  document.querySelectorAll(".job-card").forEach((_, index) => {
    const carouselBtnPrev = document.getElementById(`btn-prev-${index}`);
    const carouselBtnNext = document.getElementById(`btn-next-${index}`);
    carouselBtnPrev.addEventListener("click", () => {
      moveSlide(-1, index);
    });
    carouselBtnNext.addEventListener("click", () => {
      moveSlide(1, index);
    });
  });

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
        const response = JSON.parse(xhr.responseText);
        if (xhr.status === 200) {
          showSuccessToast(response.message);
          document.getElementById("job-isOpen-" + index).innerText =
            selectElement.value;
        } else {
          showErrorToast(response.message);
        }
      }
    };

    xhr.send(formData);
  });
});
