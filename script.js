// status buka/tutup
window.onload = function () {
  var statusElement = document.getElementById("status");
  var statusToko = document.getElementById("openclose");
  var currentTime = new Date();
  var currentHour = currentTime.getHours();

  if (currentHour >= 0 && currentHour < 24) {
    // Misalnya buka dari jam 9 pagi hingga 8 malam
    statusElement.textContent = "Buka";
    statusToko.style.backgroundColor = "green";
    // Mengambil semua elemen belanja dengan ID yang sesuai
    const cardBelanjaElements = document.querySelectorAll(
      "[id^=card-belanja-]"
    );

    // Menampilkan semua elemen belanja
    cardBelanjaElements.forEach((element) => {
      element.style.display = "block";
    });
  } else {
    statusElement.textContent = "Tutup";
    statusToko.style.backgroundColor = "red";
    // Mengambil semua elemen belanja dengan ID yang sesuai
    const cardBelanjaElements = document.querySelectorAll(
      "[id^=card-belanja-]"
    );

    // Menampilkan semua elemen belanja
    cardBelanjaElements.forEach((element) => {
      element.style.display = "none";
    });
  }
};

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

// klik keranjang penawaran spesial
document.addEventListener("DOMContentLoaded", function () {
  const keranjangBelanja = document.querySelectorAll(
    "[id^=keranjang-belanja-]"
  );
  keranjangBelanja.forEach(function (keranjang) {
    keranjang.onclick = function (e) {
      const productID = keranjang.id.split("-")[2];
      const cartItem = document.querySelector("#cart-item-" + productID);
      const cancel = document.querySelector("#cancel-" + productID);
      e.target.style.display = "none";
      cancel.classList.toggle("active");
      cartItem.classList.toggle("active");
      e.preventDefault();
    };
  });
});

// klik cancel(x)
document.addEventListener("DOMContentLoaded", function () {
  const buttonCancel = document.querySelectorAll("[id^=cancel-]");
  buttonCancel.forEach(function (cancel) {
    cancel.onclick = function (e) {
      const productID = cancel.id.split("-")[1];
      const cartItem = document.querySelector("#cart-item-" + productID);
      const keranjang = document.querySelector(
        "#keranjang-belanja-" + productID
      );
      const productNameElement = document
        .getElementById("cart-item-" + productID)
        .querySelector(".item-detail h3");
      const productNameWords = productNameElement.innerText.split(" ");
      const productName = productNameWords.join(" ");
      const jumlahProduk = document.getElementById("jumlah_" + productName);

      cancel.classList.toggle("active");
      cartItem.classList.toggle("active");
      if (jumlahProduk) {
        jumlahProduk.value = "0"; // Set nilai jumlah produk menjadi 0 jika elemen ditemukan
      }
      keranjang.style.display = "flex";
      total();
      e.preventDefault();
    };
  });
});

// Klik Mata Modal Box
// Modal Box 1
// const itemDetailModal1 = document.querySelector("#item-detail-modal-1");
// const itemDetailButton1 = document.querySelector(".item-detail-button-1");

// itemDetailButton1.onclick = (e) => {
//   itemDetailModal1.style.display = "flex";
//   e.preventDefault();
// };

// // Modal Box 2
// const itemDetailModal2 = document.querySelector("#item-detail-modal-2");
// const itemDetailButton2 = document.querySelector(".item-detail-button-2");

// itemDetailButton2.onclick = (e) => {
//   itemDetailModal2.style.display = "flex";
//   e.preventDefault();
// };

// // Modal 3
// const itemDetailModal3 = document.querySelector("#item-detail-modal-3");
// const itemDetailButton3 = document.querySelector(".item-detail-button-3");

// itemDetailButton3.onclick = (e) => {
//   itemDetailModal3.style.display = "flex";
//   e.preventDefault();
// };

// // Modal Box 4
// const itemDetailModal4 = document.querySelector("#item-detail-modal-4");
// const itemDetailButton4 = document.querySelector(".item-detail-button-4");

// itemDetailButton4.onclick = (e) => {
//   itemDetailModal4.style.display = "flex";
//   e.preventDefault();
// };

// // Klik tombol close modal
// // Modal Box 1
// document.querySelector(".modal-1 .close-icon").onclick = (e) => {
//   itemDetailModal1.style.display = "none";
//   e.preventDefault();
// };

// // Modal Box 2
// document.querySelector(".modal-2 .close-icon").onclick = (e) => {
//   itemDetailModal2.style.display = "none";
//   e.preventDefault();
// };

// // Modal Box 3
// document.querySelector(".modal-3 .close-icon").onclick = (e) => {
//   itemDetailModal3.style.display = "none";
//   e.preventDefault();
// };

// // Modal Box 4
// document.querySelector(".modal-4 .close-icon").onclick = (e) => {
//   itemDetailModal4.style.display = "none";
//   e.preventDefault();
// };

// // Klik Diluar Tombol
// window.onclick = (e) => {
//   if (e.target === itemDetailModal1) {
//     itemDetailModal1.style.display = "none";
//   }

//   if (e.target === itemDetailModal2) {
//     itemDetailModal2.style.display = "none";
//   }

//   if (e.target === itemDetailModal3) {
//     itemDetailModal3.style.display = "none";
//   }

//   if (e.target === itemDetailModal4) {
//     itemDetailModal4.style.display = "none";
//   }
// };

// Alert
// klik tombol close alert
document.querySelector(".alert .close").onclick = (e) => {
  Alert.classList.remove("active");
  e.preventDefault();
};

// isi Shopping-Cart
// ketika tombol belanja diklik

document.addEventListener("DOMContentLoaded", function () {
  // JavaScript untuk menangani klik tombol Belanja
  const cardBelanjaElements = document.querySelectorAll("[id^=card-belanja-]");
  cardBelanjaElements.forEach(function (cardBelanjaElement) {
    cardBelanjaElement.onclick = function (e) {
      const productID = cardBelanjaElement.id.split("-")[2];
      const cartItem = document.querySelector("#cart-item-" + productID);
      const informasi = document.querySelector("#informasi-" + productID);
      e.target.style.display = "none";
      informasi.classList.toggle("active");
      cartItem.classList.toggle("active");
      e.preventDefault();
    };
  });
});

// Beras
// const cartItem1 = document.querySelector(".cart-item-1");
// const informasi1 = document.querySelector("#informasi-1");
// const cardBelanja1 = document.querySelector("#card-belanja-1");

// document.querySelector("#card-belanja-1").onclick = (e) => {
//   cartItem1.classList.toggle("active");
//   // cardBelanja1.classList.toggle("active");
//   cardBelanja1.style.display = "none";
//   informasi1.classList.toggle("active");
//   e.preventDefault();
// };

// // Minyak
// const cartItem2 = document.querySelector(".cart-item-2");
// const informasi2 = document.querySelector("#informasi-2");
// const cardBelanja2 = document.querySelector("#card-belanja-2");

// document.querySelector("#card-belanja-2").onclick = (e) => {
//   cartItem2.classList.toggle("active");
//   cardBelanja2.classList.toggle("active");
//   informasi2.classList.toggle("active");
//   e.preventDefault();
// };

// // Gula
// const cartItem3 = document.querySelector(".cart-item-3");
// const informasi3 = document.querySelector("#informasi-3");
// const cardBelanja3 = document.querySelector("#card-belanja-3");

// document.querySelector("#card-belanja-3").onclick = (e) => {
//   cartItem3.classList.toggle("active");
//   cardBelanja3.classList.toggle("active");
//   informasi3.classList.toggle("active");
//   e.preventDefault();
// };

// // Susu
// const cartItem4 = document.querySelector(".cart-item-4");
// const informasi4 = document.querySelector("#informasi-4");
// const cardBelanja4 = document.querySelector("#card-belanja-4");

// document.querySelector("#card-belanja-4").onclick = (e) => {
//   cartItem4.classList.toggle("active");
//   cardBelanja4.classList.toggle("active");
//   informasi4.classList.toggle("active");
//   e.preventDefault();
// };

// // Telur
// const cartItem5 = document.querySelector(".cart-item-5");
// const informasi5 = document.querySelector("#informasi-5");
// const cardBelanja5 = document.querySelector("#card-belanja-5");

// document.querySelector("#card-belanja-5").onclick = (e) => {
//   cartItem5.classList.toggle("active");
//   cardBelanja5.classList.toggle("active");
//   informasi5.classList.toggle("active");
//   e.preventDefault();
// };

// // Garam
// const cartItem6 = document.querySelector(".cart-item-6");
// const informasi6 = document.querySelector("#informasi-6");
// const cardBelanja6 = document.querySelector("#card-belanja-6");

// document.querySelector("#card-belanja-6").onclick = (e) => {
//   cartItem6.classList.toggle("active");
//   cardBelanja6.classList.toggle("active");
//   informasi6.classList.toggle("active");
//   e.preventDefault();
// };

document.addEventListener("DOMContentLoaded", function () {
  // Mendapatkan semua elemen tombol "Hapus" berdasarkan id produk
  const removeButtons = document.querySelectorAll("[id^=remove-item-]");

  // Menambahkan event listener untuk setiap tombol "Hapus"
  removeButtons.forEach(function (removeButton) {
    removeButton.onclick = function (e) {
      e.preventDefault();

      const productID = removeButton.id.split("-")[2];
      const cartItem = document.querySelector("#cart-item-" + productID);
      const jumlahProduk = document.getElementById("jumlah_" + productID);
      const cardBelanja = document.querySelector("#card-belanja-" + productID);
      const informasi = document.querySelector("#informasi-" + productID);
      const cancel = document.querySelector("#cancel-" + productID);
      const keranjang = document.querySelector(
        "#keranjang-belanja-" + productID
      );

      if (cartItem) {
        // cartItem.remove(); // Menghapus elemen item dari DOM
        updateTotal(); // Memperbarui total harga setelah item dihapus
        cartItem.classList.toggle("active");
      }

      // Set nilai jumlah produk menjadi 0 jika elemen ditemukan
      if (jumlahProduk) {
        jumlahProduk.value = "0";
      }

      // Menampilkan kembali keranjang belanja, cancel, dan informasi jika ada
      if (keranjang) {
        keranjang.style.display = "flex";
      }

      if (cancel) {
        cancel.classList.toggle("active"); // Tambahkan kelas active pada cancel
      }

      if (cardBelanja) {
        cardBelanja.style.display = "block";
      }

      if (informasi) {
        informasi.classList.toggle("active"); // Tambahkan kelas active pada informasi
      }
      updateTotal(); // Memastikan total harga terupdate setelah perubahan
    };
  });

  // Event listener untuk input jumlah barang
  document.querySelectorAll(".jumlah").forEach((input) => {
    input.addEventListener("input", updateTotal);
  });

  // Event listener untuk tombol checkout
  document
    .querySelector(".checkout_button")
    .addEventListener("click", async function (e) {
      e.preventDefault();

      let total_harga = parseFloat(
        document.getElementById("total_harga").value
      );
      let item_ids = [];

      document.querySelectorAll(".cart-item-1").forEach((item) => {
        let id = item.id.split("-")[2];
        let hargaElem = document.getElementById("harga_" + id);
        let jumlahElem = document.getElementById("jumlah_" + id);

        if (hargaElem && jumlahElem) {
          let harga = parseFloat(hargaElem.getAttribute("value"));
          let jumlah = parseInt(jumlahElem.value);

          if (jumlah > 0) {
            item_ids.push({
              id: id,
              price: harga,
              quantity: jumlah,
            });
          }
        }
      });

      if (item_ids.length > 0) {
        try {
          const response = await fetch("placeOrder.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              items: item_ids,
              total_harga: total_harga,
            }),
          });

          const data = await response.json();
          if (data.success) {
            let snapToken = data.snapToken;

            fetch("add_order.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
              },
              body: JSON.stringify({
                items: item_ids,
              }),
            })
              .then((response) => response.json())
              .then((data) => {
                if (data.success) {
                  window.snap.pay(snapToken, {
                    onSuccess: function (result) {
                      console.log("Payment successful!", result);
                    },
                    onPending: function (result) {
                      console.log("Payment pending.", result);
                    },
                    onError: function (result) {
                      console.log("Payment error.", result);
                    },
                    onClose: function () {
                      console.log("Payment closed without success.");
                    },
                  });
                } else {
                  console.error(
                    "Gagal menambahkan/updated order ke database:",
                    data.message
                  );
                }
              })
              .catch((error) => {
                console.error("Error:", error);
              });
          } else {
            console.error("Gagal mendapatkan token pembayaran:", data.message);
          }
        } catch (err) {
          console.error("Error:", err.message);
        }
      }
    });
});

function updateTotal() {
  let total_ = 0;
  let pengiriman = 10000;

  // Loop untuk setiap item dalam keranjang
  document.querySelectorAll(".cart-item-1").forEach((item) => {
    let id = item.id.split("-")[2];
    let hargaElem = document.getElementById("harga_" + id);
    let jumlahElem = document.getElementById("jumlah_" + id);

    if (hargaElem && jumlahElem) {
      let harga = parseFloat(hargaElem.getAttribute("value"));
      let jumlah = parseInt(jumlahElem.value);

      total_ += harga * jumlah;
    }
  });

  let total_harga = total_ + pengiriman;
  document.getElementById("total_harga").value = total_harga;
}

//  Tampilkan total harga tanpa pemisah ribuan
//  document.getElementById("total_harga").value = totalHarga;

// form Validation dan kirim data
const checkoutButton = document.querySelector(".checkout_button");

checkoutButton.addEventListener("click", async function (e) {
  e.preventDefault();

  // Memanggil fungsi total() untuk menghitung total harga dan memperbarui item_ids
  updateTotal();
  const totalHarga = parseFloat(document.getElementById("total_harga").value);

  // Minta token pembayaran dari Midtrans
  try {
    const response = await fetch("placeOrder.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        total_harga: totalHarga, // Kirim total harga ke server
      }),
    });

    const data = await response.json();
    if (data.success) {
      // Token pembayaran berhasil diperoleh, tampilkan halaman pembayaran Midtrans
      window.snap.pay(data.snapToken);
    } else {
      console.error("Gagal mendapatkan token pembayaran:", data.message);
    }
  } catch (err) {
    console.error("Error:", err.message);
  }
});
