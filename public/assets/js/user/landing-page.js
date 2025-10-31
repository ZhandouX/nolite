// === Sidebar Toggle (Tailwind Version) ===
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");
const menuBtn = document.getElementById("menuBtn");
const closeSidebar = document.getElementById("closeSidebar");
const backToTopButton = document.getElementById("backToTop");

if (menuBtn && sidebar && overlay) {
  menuBtn.addEventListener("click", () => {
    // Sidebar muncul
    sidebar.classList.remove("-translate-x-full");
    sidebar.classList.add("translate-x-0");

    // Overlay aktif
    overlay.classList.remove("opacity-0", "pointer-events-none");
    overlay.classList.add("opacity-100", "pointer-events-auto");
  });

  closeSidebar.addEventListener("click", () => {
    // Sidebar sembunyi
    sidebar.classList.remove("translate-x-0");
    sidebar.classList.add("-translate-x-full");

    // Overlay nonaktif
    overlay.classList.remove("opacity-100", "pointer-events-auto");
    overlay.classList.add("opacity-0", "pointer-events-none");
  });

  overlay.addEventListener("click", () => {
    sidebar.classList.remove("translate-x-0");
    sidebar.classList.add("-translate-x-full");
    overlay.classList.remove("opacity-100", "pointer-events-auto");
    overlay.classList.add("opacity-0", "pointer-events-none");
  });
}

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

// === Back To Top Button ===
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

// === Re-initialize Lucide (safe call) ===
if (typeof lucide !== "undefined") {
  lucide.createIcons();
}
