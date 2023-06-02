//Toggle class active untuk hamburger menu
const navbarNav = document.querySelector(".navbar-nav");

//Ketika hamburger menu di klik
document.querySelector("#hamburger-menu").onclick = (e) => {
  navbarNav.classList.toggle("active");
  e.preventDefault();
};

// Toggle class active untuk search form
const searchForm = document.querySelector(".search-form");
const searchBox = document.querySelector("#search-box");

document.querySelector("#search-button").onclick = (e) => {
  searchForm.classList.toggle("active");
  searchBox.focus();
  e.preventDefault();
};

// Toggle class active untuk shopping cart
const shoppingCart = document.querySelector(".shopping-cart");
document.querySelector("#shopping-cart-button").onclick = (e) => {
  shoppingCart.classList.toggle("active");
  e.preventDefault();
};

// Klik di luar elemen hamburger menu, shopping cart, search form
const hm = document.querySelector("#hamburger-menu");
const sb = document.querySelector("#search-button");
const sc = document.querySelector("#shopping-cart-button");

document.addEventListener("click", function (e) {
  if (!hm.contains(e.target) && !navbarNav.contains(e.target)) {
    navbarNav.classList.remove("active");
  }

  if (!sb.contains(e.target) && !searchForm.contains(e.target)) {
    searchForm.classList.remove("active");
  }

  if (!sc.contains(e.target) && !shoppingCart.contains(e.target)) {
    shoppingCart.classList.remove("active");
  }
});

// Klik Mata Modal Box
// Modal Box 1
const itemDetailModal1 = document.querySelector("#item-detail-modal-1");
const itemDetailButton1 = document.querySelector(".item-detail-button-1");

itemDetailButton1.onclick = (e) => {
  itemDetailModal1.style.display = "flex";
  e.preventDefault();
};

// Modal Box 2
const itemDetailModal2 = document.querySelector("#item-detail-modal-2");
const itemDetailButton2 = document.querySelector(".item-detail-button-2");

itemDetailButton2.onclick = (e) => {
  itemDetailModal2.style.display = "flex";
  e.preventDefault();
};

// Modal 3
const itemDetailModal3 = document.querySelector("#item-detail-modal-3");
const itemDetailButton3 = document.querySelector(".item-detail-button-3");

itemDetailButton3.onclick = (e) => {
  itemDetailModal3.style.display = "flex";
  e.preventDefault();
};

// Modal Box 4
const itemDetailModal4 = document.querySelector("#item-detail-modal-4");
const itemDetailButton4 = document.querySelector(".item-detail-button-4");

itemDetailButton4.onclick = (e) => {
  itemDetailModal4.style.display = "flex";
  e.preventDefault();
};

// Klik tombol close modal
// Modal Box 1
document.querySelector(".modal-1 .close-icon").onclick = (e) => {
  itemDetailModal1.style.display = "none";
  e.preventDefault();
};

// Modal Box 2
document.querySelector(".modal-2 .close-icon").onclick = (e) => {
  itemDetailModal2.style.display = "none";
  e.preventDefault();
};

// Modal Box 3
document.querySelector(".modal-3 .close-icon").onclick = (e) => {
  itemDetailModal3.style.display = "none";
  e.preventDefault();
};

// Modal Box 4
document.querySelector(".modal-4 .close-icon").onclick = (e) => {
  itemDetailModal4.style.display = "none";
  e.preventDefault();
};

// Klik Diluar Tombol
window.onclick = (e) => {
  if (e.target === itemDetailModal1) {
    itemDetailModal1.style.display = "none";
  }

  if (e.target === itemDetailModal2) {
    itemDetailModal2.style.display = "none";
  }

  if (e.target === itemDetailModal3) {
    itemDetailModal3.style.display = "none";
  }

  if (e.target === itemDetailModal4) {
    itemDetailModal4.style.display = "none";
  }
};

// Alert
// klik tombol close alert
document.querySelector(".alert .close").onclick = (e) => {
  Alert.classList.remove("active");
  e.preventDefault();
};
