document.addEventListener("DOMContentLoaded", function () {
  let currentIndex = 0;
  function moveSlide(step) {
    const images = document.getElementById("Attachment-Image");
    const AttachmentLink = document.querySelectorAll(".attachment");

    currentIndex += step;
    if (currentIndex < 0) {
      currentIndex = AttachmentLink.length - 1;
    } else if (currentIndex >= AttachmentLink.length) {
      currentIndex = 0;
    }

    currentImage = AttachmentLink[currentIndex].innerText;
    images.src = currentImage;
  }

  const buttonPrev = document.getElementById("btn-prev");
  const buttonNext = document.getElementById("btn-next");
  const imageDefault = document.getElementById("Attachment-Image");
  const AttachmentLink = document.querySelectorAll(".attachment");
  imageDefault.src = AttachmentLink[0].innerText;

  buttonPrev.addEventListener("click", () => moveSlide(-1));
  buttonNext.addEventListener("click", () => moveSlide(1));
});
