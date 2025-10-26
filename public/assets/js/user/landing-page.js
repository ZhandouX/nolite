// === Sidebar Toggle ===
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");
const menuBtn = document.getElementById("menuBtn");
const closeSidebar = document.getElementById("closeSidebar");
const backToTopButton = document.getElementById("backToTop");

menuBtn.addEventListener("click", () => {
  sidebar.classList.add("active");
  overlay.classList.add("active");
});

closeSidebar.addEventListener("click", () => {
  sidebar.classList.remove("active");
  overlay.classList.remove("active");
});

overlay.addEventListener("click", () => {
  sidebar.classList.remove("active");
  overlay.classList.remove("active");
});

// === Dropdown Sidebar ===
document.querySelectorAll(".dropdown-toggle").forEach((toggle) => {
  toggle.addEventListener("click", function (e) {
    e.preventDefault();
    this.parentElement.classList.toggle("open");
  });
});

// === Simple Search Filter ===
const searchInput = document.querySelector(".search-bar input");

if (searchInput) {
  searchInput.addEventListener("input", function () {
    const value = this.value.toLowerCase();
    allProducts.forEach((prod) => {
      const text = prod.innerText.toLowerCase();
      prod.style.display = text.includes(value) ? "block" : "none";
    });
  });
}

// === Inisialisasi Lucide Icon ===
if (typeof lucide !== "undefined") {
  lucide.createIcons();
}

// === Hero Slider ===
let slides = document.querySelectorAll(".slide");
let currentSlide = 0;

function changeSlide() {
  slides[currentSlide].classList.remove("active");
  currentSlide = (currentSlide + 1) % slides.length;
  slides[currentSlide].classList.add("active");
}

// IMAGES SLIDER
setInterval(changeSlide, 4000);

function openDetail(productName) {
  alert("Buka detail produk: " + productName);
}

// === Footer Payment Toggle ===
function toggleFooterPayment() {
  const logosMobile = document.getElementById("footerLogosMobile");
  const icon = document.getElementById("footerIcon");

  logosMobile.classList.toggle("hidden");
  icon.classList.toggle("rotate-180");
}

window.addEventListener("scroll", () => {
  if (window.pageYOffset > 300) {
    backToTopButton.classList.remove("hidden");
    backToTopButton.classList.add("flex");
  } else {
    backToTopButton.classList.add("hidden");
    backToTopButton.classList.remove("flex");
  }
});

backToTopButton.addEventListener("click", () => {
  window.scrollTo({ top: 0, behavior: "smooth" });
});

if (typeof lucide !== "undefined") {
  lucide.createIcons();
}