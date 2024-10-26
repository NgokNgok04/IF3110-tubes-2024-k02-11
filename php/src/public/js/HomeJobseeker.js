let debounceTimer;
let currPage = 1;

function debounceSearch() {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(function () {
    const searchInput = document.getElementById("searchInput").value; // Get the search input value
    const locations = [
      ...document.querySelectorAll('input[name="locations[]"]:checked'),
    ].map((checkbox) => checkbox.value); // Get the checked locations
    const statuses = [
      ...document.querySelectorAll('input[name="statuses[]"]:checked'),
    ].map((checkbox) => checkbox.value); // Get the checked statuses
    const jobtypes = [
      ...document.querySelectorAll('input[name="jobtypes[]"]:checked'),
    ].map((checkbox) => checkbox.value); // Get the checked jobtypes
    const sort = document.getElementById("sort-by").value; // Get the selected sort option
    console.log(sort);
    const locationQuery =
      locations.length > 0
        ? `&locations[]=${locations.join("&locations[]=")}`
        : ""; // Create the query string for locations
    const statusQuery =
      statuses.length > 0 ? `&statuses[]=${statuses.join("&statuses[]=")}` : ""; // Create the query string for statuses
    const jobtypeQuery =
      jobtypes.length > 0 ? `&jobtypes[]=${jobtypes.join("&jobtypes[]=")}` : ""; // Create the query string for jobtypes

    //url to be displayed in the browser
    const url = `/?search=${encodeURIComponent(
      searchInput
    )}${locationQuery}${statusQuery}${jobtypeQuery}&sort=${encodeURIComponent(
      sort
    )}&page=${encodeURIComponent(currPage)}`;
    //update the url in the browser without refreshing the page
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
    xhr.open("GET", url, true); // Send a GET request to the server

    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest"); // Set the X-Requested-With header to XMLHttpRequest
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // If the request is successful
        const parser = new DOMParser();
        const doc = parser.parseFromString(xhr.responseText, "text/html");
        const newList = doc.querySelector(".list-vacancy");
        const newPagination = doc.querySelector(".pagination");

        //update the list and pagination with the new content
        //if not do it, user can't interact with the new content
        if (newList) {
          const existingList = document.querySelector(".list-vacancy");
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
        //after updating the list, reattach listeners so user can interact with the new content
        attachJobCardListeners();
        attachPaginationListeners();
      }
    };
    xhr.send();
  }, 300);
}

// Prevent form submission on "Enter" key button (not best practice, but it works)
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
      currPage = parseInt(this.getAttribute("data-page")); // Update current page with the new page number
      debounceSearch();
    });
  });
}

//attach listner for the first time
attachPaginationListeners();
function attachJobCardListeners() {
  document.querySelectorAll(".job-card").forEach((button, index) => {
    button.addEventListener("click", () => openModal(index));
  });
  // Attach close button listeners for each modal
  document.querySelectorAll(".close-modal").forEach((button) => {
    button.addEventListener("click", () => closeModal());
  });
}

//this code below is for the modal of each job card
function openModal(index) {
  const modal = document.getElementById("myModal");
  const modalContent = document.getElementById("modalContent");
  const bgOverlay = document.getElementById("modalOverlay");

  modal.classList.remove("display-none");
  modalContent.classList.remove("display-none");
  bgOverlay.classList.remove("display-none");

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

  let lowongan_id = document
    .getElementById(`job-companyid-${index}`)
    .innerText.trim();

  document
    .getElementById("button-apply")
    .addEventListener("click", function () {
      window.location.href = `/detail-lowongan/${lowongan_id}`;
    });

  document.getElementById("close-modal").addEventListener("click", function () {
    closeModal();
  });
}

function closeModal() {
  const modal = document.getElementById("myModal");
  const modalContent = document.getElementById("modalContent");
  const bgOverlay = document.getElementById("modalOverlay");

  modal.classList.add("display-none");
  modalContent.classList.add("display-none");
  bgOverlay.classList.add("display-none");
}

function submitFiltersForm() {
  document.getElementById("filters-form").submit();
}

document.addEventListener("DOMContentLoaded", function () {
  attachJobCardListeners();

  const closeModals = document.getElementById("close-modal");
  closeModals.addEventListener("click", closeModal);
});
