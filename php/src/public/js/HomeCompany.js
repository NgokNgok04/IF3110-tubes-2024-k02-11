let debounceTimer;
let currPage = 1;

function debounceSearch() {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(function () {
    const searchInput = document.getElementById('searchInput').value;
    const locations = [...document.querySelectorAll('input[name="locations[]"]:checked')].map(checkbox => checkbox.value);
    const statuses = [...document.querySelectorAll('input[name="statuses[]"]:checked')].map(checkbox => checkbox.value);
    const sort = document.getElementById('sort-by').value;

    const locationQuery = locations.length > 0 ? `&locations[]=${locations.join('&locations[]=')}` : '';
    const statusQuery = statuses.length > 0 ? `&statuses[]=${statuses.join('&statuses[]=')}` : '';

    const url = `/?search=${encodeURIComponent(searchInput)}${locationQuery}${statusQuery}&sort=${encodeURIComponent(sort)}&page=${encodeURIComponent(currPage)}`;

    window.history.pushState({ search: searchInput, locations, statuses, sort, page: currPage }, '', url);

    const xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(xhr.responseText, 'text/html');
        const newList = doc.querySelector('.job-lists');
        const newPagination = doc.querySelector('.pagination');

        if (newList) {
          const existingList = document.querySelector('.job-lists');
          if (existingList) {
            existingList.innerHTML = newList.innerHTML;
          }
        }

        if (newPagination) {
          const existingPagination = document.querySelector('.pagination');
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

document.getElementById('filters-form').addEventListener('submit', function (event) {
  event.preventDefault();
});

function attachPaginationListeners() {
  const paginationLinks = document.querySelectorAll('.pagination a');
  paginationLinks.forEach(link => {
    link.addEventListener('click', function (event) {
      event.preventDefault();
      currPage = parseInt(this.getAttribute('data-page'));
      debounceSearch();
    });
  });
}

attachPaginationListeners();

function attachJobCardListeners() {
  document.querySelectorAll(".job-card").forEach((button, index) => {
    button.addEventListener("click", () => openModal(index));
  });
  document.querySelectorAll(".close-modal").forEach((button) => {
    button.addEventListener("click", () => closeModal());
  });
}

function openModal(index) {
  const modal = document.getElementById('myModal');
  const modalBg = document.getElementById('modalOverlay');
  const modalViewBtn = document.getElementById("modal-view");
  const modalEditBtn = document.getElementById("modal-edit");
  const modalDeleteForm = document.getElementById("modal-delete");

  modal.classList.remove("display-none");
  modalBg.classList.remove("display-none");

  document.getElementById("modal-title").innerText = document.getElementById(`job-title-${index}`).innerText;
  document.getElementById("modal-company").innerText = document.getElementById(`job-company-${index}`).innerText;
  document.getElementById("modal-location").innerText = document.getElementById(`job-location-${index}`).innerText;
  document.getElementById("modal-type").innerText = document.getElementById(`job-type-${index}`).innerText;
  document.getElementById("modal-status").innerText = document.getElementById(`job-status-${index}`).innerText;
  document.getElementById("modal-desc").innerText = document.getElementById(`job-desc-${index}`).innerText;
  document.getElementById("modal-select").value = document.getElementById(`job-isOpen-${index}`).innerText;

  modalViewBtn.href = `/detail-lowongan/${document.getElementById(`job-companyid-${index}`).innerText}`;
  modalEditBtn.href = `/detail-lowongan/edit/${document.getElementById(`job-companyid-${index}`).innerText}`;
  modalDeleteForm.action = `/detail-lowongan/delete/${document.getElementById(`job-companyid-${index}`).innerText}`;
}

function closeModal() {
  const modal = document.getElementById('myModal');
  const modalBg = document.getElementById('modalOverlay');
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

// Attach initial event listeners
attachPaginationListeners();
attachJobCardListeners();
