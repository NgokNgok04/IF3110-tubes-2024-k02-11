document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("myModal");
  const modalContent = document.getElementById("modalContent");
  const bgOverlay = document.getElementById("modalOverlay");
  function openModal(index) {
    // const companyName = document.getElementById('')
    modal.classList.remove("display-none");
    modalContent.classList.remove("display-none");
    bgOverlay.classList.remove("display-none");

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

    let lowongan_id = document.getElementById(
      `job-companyid-${index}`
    ).innerText;

    document
      .getElementById("button-apply")
      .addEventListener("click", function () {
        window.location.href = `/detail-lowongan/${lowongan_id}`;
      });
  }

  function closeModal() {
    console.log("wahyudi");
    modal.classList.add("display-none");
    modalContent.classList.add("display-none");
    bgOverlay.classList.add("display-none");
  }

  document.querySelectorAll(".job-card").forEach((button, index) => {
    button.addEventListener("click", () => openModal(index));
  });

  const closeModals = document.getElementById("close-modal");
  closeModals.addEventListener("click", () => closeModal());
});

{
  /* <a href="/detail-lowongan/<?php echo $lowongan['lowongan_id']; ?>" method="GET" class="btn">Apply Now</a> */
}


//no need apply button again 
function submitFiltersForm() {
  document.getElementById('filters-form').submit();
}