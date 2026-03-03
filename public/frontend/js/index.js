const hamburger = document.querySelector(".hamburger");
const mobileMenu = document.querySelector(".mobileMenu-overlay");
const closeMenu = document.querySelector(".closeMenu");

hamburger?.addEventListener("click", () => {
  mobileMenu.classList.add("active");
  document.body.style.overflow = "hidden";
});
closeMenu?.addEventListener("click", () => {
  mobileMenu.classList.remove("active");
  document.body.style.overflow = "auto";
});

const langButtons = document.querySelectorAll(".lang-btn");

// Butona klikləndikdə parent-ə active toggle et
langButtons.forEach((btn) => {
  btn?.addEventListener("click", (e) => {
    e.stopPropagation(); // kənara klik eventini dayandır
    const parent = btn.closest(".language");

    // digərlərindən active sil
    document.querySelectorAll(".language.active").forEach((item) => {
      if (item !== parent) item.classList.remove("active");
    });

    // kliklənən element üçün toggle
    parent.classList.toggle("active");
  });
});

// Kənara kliklənəndə hamısından active sil
document.addEventListener("click", (e) => {
  if (!e.target.closest(".language")) {
    document
      .querySelectorAll(".language.active")
      .forEach((item) => item.classList.remove("active"));
  }
});

document.querySelectorAll(".menu-drop-btn").forEach((btn) => {
  btn.addEventListener("click", function () {
    const parentMenu = this.closest(".link-menu");
    const isAlreadyOpen = parentMenu.classList.contains("active");

    // Bütün menyuları bağla
    document.querySelectorAll(".link-menu").forEach((menu) => {
      menu.classList.remove("active");
    });

    // Əgər bağlı idisə, aç
    if (!isAlreadyOpen) {
      parentMenu.classList.add("active");
    }
  });
});

// Xaricdə kliklənəndə bağla
document.addEventListener("click", function (e) {
  if (!e.target.closest(".link-menu")) {
    document.querySelectorAll(".link-menu").forEach((menu) => {
      menu.classList.remove("active");
    });
  }
});

const portfolioItemBtns = document.querySelectorAll(".portfolioItemBtn");
const homePortfolioItems = document.querySelectorAll(".home-portfolio-item");

document.addEventListener("DOMContentLoaded", () => {
  if (homePortfolioItems.length > 0) {
    homePortfolioItems[0].classList.add("active");
  }
});

portfolioItemBtns.forEach((btn) => {
  btn?.addEventListener("click", () => {
    homePortfolioItems.forEach((item) => item.classList.remove("active"));
    btn.parentElement.classList.add("active");
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const share = document.querySelector(".share");
  const shareBtn = share?.querySelector(".share-btn");
  const shareList = share?.querySelector(".shareList");

  // Toggle
  shareBtn?.addEventListener("click", () => {
    shareList.classList.toggle("active");
  });

  // Kənara klik
  document.addEventListener("click", (e) => {
    if (!share?.contains(e.target)) {
      shareList?.classList.remove("active");
    }
  });

  // ESC ilə bağlansın
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      shareList?.classList.remove("active");
    }
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const counter = document.querySelector(".counter");
  if (!counter) return;

  const decreaseBtn = counter.querySelector(".decrease");
  const increaseBtn = counter.querySelector(".increase");
  const valueEl = counter.querySelector(".counter-value");

  if (!decreaseBtn || !increaseBtn || !valueEl) return;

  const MIN_VALUE = 1;

  let value = parseInt(valueEl.textContent) || MIN_VALUE;

  const updateUI = () => {
    valueEl.textContent = value;
    decreaseBtn.disabled = value <= MIN_VALUE;
  };

  decreaseBtn.addEventListener("click", () => {
    if (value > MIN_VALUE) {
      value--;
      updateUI();
    }
  });

  increaseBtn.addEventListener("click", () => {
    value++;
    updateUI();
  });

  updateUI();
});

var partnerSlide = new Swiper(".partners-slide", {
  slidesPerView: "auto",
  speed: 1600,
  loop: true,
  spaceBetween: 24,
  autoplay: {
    delay: 2500,
  },
});
var homeBlogSlide = new Swiper(".home-blog-slide", {
  slidesPerView: "auto",
  speed: 1600,
  loop: true,
  spaceBetween: 20,
  autoplay: {
    delay: 2500,
  },
});
var serviceDetailImage = new Swiper(".service-detail-image-slide", {
  slidesPerView: "auto",
  speed: 1600,
  loop: true,
  spaceBetween: 20,
  // autoplay: {
  //   delay: 2500,
  // },
  pagination: {
    el: ".swiper-pagination",
  },
});

var reviewSlide = new Swiper(".review-slide", {
  slidesPerView: "auto",
  speed: 1600,
  spaceBetween: 20,
  loop: true,
  centeredSlides: true,
  autoplay: {
    delay: 2500,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

var mobileWhyUsSlide = new Swiper(".mobile-why-us-slide", {
  slidesPerView: "auto",
  speed: 1600,
  loop: true,
  spaceBetween: 20,
  autoplay: {
    delay: 2500,
  },
});

const whyUsWrapper = document.querySelector(".why-us-wrapper");

var whyUsImageSlide = new Swiper(".why-us-images-slide", {
  effect: "fade",
  fadeEffect: { crossFade: true },
  loop: false,
  slidesPerView: 1,
  allowTouchMove: false,
  speed: 1600,
});

var whyContentSlide = new Swiper(".why-us-content-slide", {
  direction: "vertical",
  slidesPerView: 1,
  speed: 1600,
  loop: false,
  allowTouchMove: false,
  mousewheel: false,
  pagination: {
    el: ".swiper-pagination",
    type: "fraction",
  },
  thumbs: {
    swiper: whyUsImageSlide,
  },
});

if (whyUsWrapper) {
  function updateLineIndicator(index, total) {
    const progress = total <= 1 ? 100 : (index / (total - 1)) * 70;
    const track = document.querySelector(".line-track");
    if (track) {
      track.style.setProperty("--line-progress", progress + "%");
    }
  }

  document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll(
      ".why-us-content-slide .swiper-slide",
    );
    whyUsWrapper.style.height = slides.length * 100 + "vh";
    updateLineIndicator(0, slides.length);
  });

  window.addEventListener("scroll", () => {
    const totalSlides = whyContentSlide.slides.length;
    const wrapperTop =
      whyUsWrapper.getBoundingClientRect().top + window.scrollY;
    const scrollZone = whyUsWrapper.offsetHeight - window.innerHeight;
    const scrolled = window.scrollY - wrapperTop;

    if (scrolled < 0 || scrolled > scrollZone) return;

    const progress = scrolled / scrollZone;
    const targetIndex = Math.round(progress * (totalSlides - 1));

    if (whyContentSlide.activeIndex !== targetIndex) {
      whyContentSlide.slideTo(targetIndex);
      updateLineIndicator(targetIndex, totalSlides);
    }
  });
}
