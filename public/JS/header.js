// ===Slider products===
  function updateSlider(container) {
    const slideTrack = container.querySelector(".slide-track");
    const products = container.querySelectorAll(".product");
    const itemsPerSlide = 4;
    const currentSlide = container.currentSlide || 0;

    if (products.length === 0) return;

    const style = getComputedStyle(products[0]);
    const slideWidth = products[0].offsetWidth;
    const marginLeft = parseInt(style.marginLeft);
    const marginRight = parseInt(style.marginRight);
    const totalWidth = slideWidth + marginLeft + marginRight;

    slideTrack.style.transform = `translateX(-${currentSlide * totalWidth * itemsPerSlide}px)`;
  }

  function nextSlide(btn) {
    const container = btn.closest(".slider-container");
    const products = container.querySelectorAll(".product");
    const itemsPerSlide = 4;
    const maxSlide = Math.ceil(products.length / itemsPerSlide) - 1;

    container.currentSlide = container.currentSlide || 0;
    container.currentSlide = Math.min(container.currentSlide + 1, maxSlide);

    updateSlider(container);
  }

  function prevSlide(btn) {
    const container = btn.closest(".slider-container");

    container.currentSlide = container.currentSlide || 0;
    container.currentSlide = Math.max(container.currentSlide - 1, 0);

    updateSlider(container);
  }

  window.addEventListener("resize", () => {
    document.querySelectorAll(".slider-container").forEach(container => updateSlider(container));
  });

  // Xử lý cuộn trang
const navbar = document.getElementById('navbar');
const container = document.querySelector('.Container-fluid');
let lastScrollTop = 0;

function updateMargin() {
  if (navbar.style.top === "0px" || navbar.style.top === "") {
    container.style.marginTop = navbar.offsetHeight + "px";
  } else {
    container.style.marginTop = "0px";
  }
}
window.addEventListener('scroll', function () {
  const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
  if (currentScroll > lastScrollTop) {
    navbar.style.top = "-200px";
  } else {
    navbar.style.top = "0";
  }
  lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
  updateMargin();
});
window.addEventListener('DOMContentLoaded', updateMargin);
window.addEventListener('resize', updateMargin);

  // Hiển thị pure-item khi hover vào title-san-pham (menu cha)
  document.querySelectorAll('.title-san-pham').forEach(item => { // Lặp qua từng menu cha
    const pureItem = item.querySelector('.pure-item'); // Lấy menu con tương ứng
    item.addEventListener('mouseenter', () => { // Khi hover vào menu cha
      if (pureItem) {
        pureItem.style.display = 'flex'; // Hiện menu con
        // Luôn active li đầu và hiện sản phẩm đầu tiên
        const lis = pureItem.querySelectorAll('.pure-item-left ul li'); // Lấy tất cả mục bên trái
        const rights = pureItem.querySelectorAll('.pure-item-right'); // Lấy tất cả phần sản phẩm bên phải
        lis.forEach(l => l.classList.remove('active')); // Bỏ active tất cả li
        rights.forEach(r => r.style.display = 'none'); // Ẩn tất cả sản phẩm bên phải
        const firstLi = pureItem.querySelector('.pure-item-left ul li:first-child'); // Lấy li đầu tiên
        const firstRight = pureItem.querySelector('.pure-item-right.right-1'); // Lấy sản phẩm đầu tiên
        if (firstLi) firstLi.classList.add('active'); // Active li đầu tiên
        if (firstRight) firstRight.style.display = 'grid'; // Hiện sản phẩm đầu tiên
      }
    });
    item.addEventListener('mouseleave', () => { // Khi rời chuột khỏi menu cha
      if (pureItem) pureItem.style.display = 'none'; // Ẩn menu con
    });
  });

  // Xử lý hover bên trong pure-item (menu con)
  document.querySelectorAll('.pure-item').forEach(menu => { // Lặp qua từng menu con
    const lis = menu.querySelectorAll('.pure-item-left ul li'); // Lấy tất cả mục bên trái
    const rights = menu.querySelectorAll('.pure-item-right'); // Lấy tất cả phần sản phẩm bên phải

    // Xử lý hover từng li bên trái
    lis.forEach((li, idx) => { // Lặp qua từng li bên trái
      li.addEventListener('mouseenter', function () { // Khi hover vào từng li
        rights.forEach(r => r.style.display = 'none'); // Ẩn tất cả sản phẩm bên phải
        const right = menu.querySelector('.pure-item-right.right-' + (idx + 1)); // Lấy sản phẩm tương ứng
        if (right) right.style.display = 'grid'; // Hiện sản phẩm tương ứng
        lis.forEach(l => l.classList.remove('active')); // Bỏ active tất cả li
        li.classList.add('active'); // Active li đang hover
      });
    });
  });