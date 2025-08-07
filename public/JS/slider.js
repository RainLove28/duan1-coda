// Slider banner
let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides((slideIndex += n));
}

// Hiển thị slide hiện tại
function showSlides(n) {
  let i;
  const slides = document.getElementsByClassName("mySlides");

  if (n > slides.length) {
    slideIndex = 1;
  }
  if (n < 1) {
    slideIndex = slides.length;
  }

  // Ẩn tất cả các slide
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }

  // Hiện slide tương ứng
  slides[slideIndex - 1].style.display = "block";
}

// Tự động chuyển slide mỗi 5 giây (nếu muốn)
setInterval(() => {
  plusSlides(1);
}, 3000);
