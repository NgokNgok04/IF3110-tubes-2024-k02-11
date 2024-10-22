let debounceTimer;

function debounceSearch() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(function() {
        const searchInput = document.getElementById('searchInput').value;

        // Gather all checked locations
        const locations = [...document.querySelectorAll('input[name="locations[]"]:checked')].map(checkbox => checkbox.value);

        // Gather all checked statuses
        const statuses = [...document.querySelectorAll('input[name="statuses[]"]:checked')].map(checkbox => checkbox.value);

        const sort = document.getElementById('sort-by').value;
        const page = currPage; // Pass the current page to AJAX

        // Prepare URL with encoded parameters
        const locationQuery = locations.length > 0 ? `&locations[]=${locations.join('&locations[]=')}` : '';
        const statusQuery = statuses.length > 0 ? `&statuses[]=${statuses.join('&statuses[]=')}` : '';

        const url = `/?search=${encodeURIComponent(searchInput)}${locationQuery}${statusQuery}&sort=${encodeURIComponent(sort)}&page=${encodeURIComponent(page)}`;

        // AJAX to server
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); 
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(xhr.responseText, 'text/html');
                const newList = doc.querySelector('.list-vacancy');

                if (newList) {
                    document.querySelector('.list-vacancy').innerHTML = newList.innerHTML;
                    attachJobCardListeners();
                }
            }
        };
        xhr.send();
    }, 300);   
}




function attachJobCardListeners() {
  document.querySelectorAll(".job-card").forEach((button, index) => {
    button.addEventListener("click", () => openModal(index));
  });

  // Attach close button listeners for each modal
  document.querySelectorAll(".close-modal").forEach((button) => {
    button.addEventListener("click", () => closeModal());
  });

}

function openModal(index) {
  const modal = document.getElementById("myModal");
  const modalContent = document.getElementById("modalContent");
  const bgOverlay = document.getElementById("modalOverlay");

  modal.classList.remove("display-none");
  modalContent.classList.remove("display-none");
  bgOverlay.classList.remove("display-none");

  document.getElementById("modal-title").innerText = document.getElementById(`job-title-${index}`).innerText;
  document.getElementById("modal-company").innerText = document.getElementById(`job-company-${index}`).innerText;
  document.getElementById("modal-location").innerText = document.getElementById(`job-location-${index}`).innerText;
  document.getElementById("modal-type").innerText = document.getElementById(`job-type-${index}`).innerText;
  document.getElementById("modal-status").innerText = document.getElementById(`job-status-${index}`).innerText;
  document.getElementById("modal-desc").innerText = document.getElementById(`job-desc-${index}`).innerText;

  let lowongan_id = document.getElementById(`job-companyid-${index}`).innerText;

  document.getElementById("button-apply").addEventListener("click", function () {
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
  document.getElementById('filters-form').submit();
}

document.addEventListener("DOMContentLoaded", function () {
  attachJobCardListeners();

  const closeModals = document.getElementById("close-modal");
  closeModals.addEventListener("click", closeModal);
});
