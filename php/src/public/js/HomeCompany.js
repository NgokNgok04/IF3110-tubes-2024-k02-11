document.addEventListener("DOMContentLoaded", function () {
  function moveSearchSection() {
    const searchSection = document.querySelector(".search-section");
    const mainContent = document.querySelector(".main-content");
    const main = document.querySelector("main"); // The parent container

    if (window.innerWidth <= 1000) {
      // Move search-section into main-content if not already inside
      if (!mainContent.contains(searchSection)) {
        mainContent.appendChild(searchSection);
      }
    } else {
      // Move search-section back outside of main-content when screen is large
      if (mainContent.contains(searchSection)) {
        main.appendChild(searchSection);
      }
    }
  }

  const modal = document.getElementById(`myModal`);
  const modalBg = document.getElementById(`modalOverlay`);
  const modalSelect = document.getElementById(`modal-select`);
  const modalViewBtn = document.getElementById("modal-view");
  const modalEditBtn = document.getElementById("modal-edit");
  const modalDeleteForm = document.getElementById("modal-delete");
  function openModal(index) {
    // const companyName = document.getElementById('')
    modal.classList.remove("display-none");
    // modalContent.classList.remove("display-none");
    modalBg.classList.remove("display-none");

    document.getElementById("modal-title").innerText = document.getElementById(
      `job-title-${index}`
    ).innerText;
    document.getElementById("modal-company").innerText =
      document.getElementById(`job-company-${index}`).innerText;
    document.getElementById("modal-location").innerText =
      document.getElementById(`job-location-${index}`).innerText;
    document.getElementById("modal-type").innerText = document.getElementById(
      `job-type-${index}`
    ).innerText;
    document.getElementById("modal-status").innerText = document.getElementById(
      `job-status-${index}`
    ).innerText;
    document.getElementById("modal-desc").innerText = document.getElementById(
      `job-desc-${index}`
    ).innerText;
    modalSelect.value = document.getElementById(
      `job-isOpen-${index}`
    ).innerText;
    modalViewBtn.href =
      "/detail-lowongan/" +
      document.getElementById(`job-companyid-${index}`).innerText;
    modalEditBtn.href =
      "/detail-lowongan/edit/" +
      document.getElementById(`job-companyid-${index}`).innerText;
    modalDeleteForm.action =
      "/detail-lowongan/delete/" +
      document.getElementById(`job-companyid-${index}`).innerText;
  }

  function closeModal() {
    console.log("wahyudi");
    modal.classList.add("display-none");
    modalBg.classList.add("display-none");
  }

  document.querySelectorAll(".job-card").forEach((button, index) => {
    button.addEventListener("click", () => openModal(index));
  });

  const closeModals = document.getElementById("close-modal");
  closeModals.addEventListener("click", () => closeModal());
  // Run the function when the page loads and when the window is resized
  window.addEventListener("load", moveSearchSection);
  window.addEventListener("resize", moveSearchSection);
});

function submitFiltersForm() {
  document.getElementById("filters-form").submit();
}
