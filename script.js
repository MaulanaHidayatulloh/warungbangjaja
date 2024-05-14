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

// Klik tombol sampah shopping cart
document.addEventListener("DOMContentLoaded", function () {
  // Mendapatkan semua elemen tombol "Hapus" berdasarkan id produk
  const removeButtons = document.querySelectorAll("[id^=remove-item-]");

  // Menambahkan event listener untuk setiap tombol "Hapus"
  removeButtons.forEach(function (removebutton) {
    removebutton.onclick = function (e) {
      const productID = removebutton.id.split("-")[2];
      const productNameElement = document
        .getElementById("cart-item-" + productID)
        .querySelector(".item-detail h3");
      const productNameWords = productNameElement.innerText.split(" ");
      const productName = productNameWords.join(" ");
      const cartItem = document.querySelector("#cart-item-" + productID);
      const jumlahProduk = document.getElementById("jumlah_" + productID);
      const cardBelanja = document.querySelector("#card-belanja-" + productID);
      const informasi = document.querySelector("#informasi-" + productID);
      const cancel = document.querySelector("#cancel-" + productID);
      const keranjang = document.querySelector(
        "#keranjang-belanja-" + productID
      );
      const Total = document.getElementById("total_harga");

      cartItem.classList.toggle("active");
      if (jumlahProduk) {
        jumlahProduk.value = "0"; // Set nilai jumlah produk menjadi 0 jika elemen ditemukan
      }
      if (keranjang) {
        keranjang.style.display = "flex";
        cancel.classList.toggle("active");
      }
      if (cardBelanja) {
        cardBelanja.style.display = "block";
        informasi.classList.toggle("active");
      }
      total();
      Total.value = 0;
      e.preventDefault();
    };
  });
});

// Beras
// document.getElementById("remove-item-1").onclick = (e) => {
//   cartItem1.classList.toggle("active");
//   document.getElementById("jumlah_beras").value = "0";
//   total();
//   cardBelanja1.style.display = "inline-block";
//   informasi1.classList.toggle("active");
//   e.preventDefault();
// };

// // Minyak
// document.getElementById("remove-item-2").onclick = (e) => {
//   cartItem2.classList.toggle("active");
//   document.getElementById("jumlah_minyak").value = "0";
//   total();
//   cardBelanja2.classList.toggle("active");
//   informasi2.classList.toggle("active");
//   e.preventDefault();
// };

// // Gula
// document.getElementById("remove-item-3").onclick = (e) => {
//   cartItem3.classList.toggle("active");
//   document.getElementById("jumlah_gula").value = "0";
//   total();
//   cardBelanja3.classList.toggle("active");
//   informasi3.classList.toggle("active");
//   e.preventDefault();
// };

// // Susu
// document.getElementById("remove-item-4").onclick = (e) => {
//   cartItem4.classList.toggle("active");
//   document.getElementById("jumlah_susu").value = "0";
//   total();
//   cardBelanja4.classList.toggle("active");
//   informasi4.classList.toggle("active");
//   e.preventDefault();
// };

// // Telur
// document.getElementById("remove-item-5").onclick = (e) => {
//   cartItem5.classList.toggle("active");
//   document.getElementById("jumlah_telur").value = "0";
//   total();
//   cardBelanja5.classList.toggle("active");
//   informasi5.classList.toggle("active");
//   e.preventDefault();
// };

// // Garam
// document.getElementById("remove-item-6").onclick = (e) => {
//   cartItem6.classList.toggle("active");
//   document.getElementById("jumlah_garam").value = "0";
//   total();
//   cardBelanja6.classList.toggle("active");
//   informasi6.classList.toggle("active");
//   e.preventDefault();
// };

// Total Harga
function total() {
  let total_ = 0;
  let total_harga = 0;
  let item_ids = [];

  // Loop untuk setiap item dalam keranjang
  document.querySelectorAll(".cart-item-1").forEach((item) => {
    let id = item.id.split("-")[2];
    let hargaElem = document.getElementById("harga_" + id);
    let stockElem = document.getElementById("stock_" + id);
    let jumlahElem = document.getElementById("jumlah_" + id);

    if (hargaElem && stockElem && jumlahElem) {
      // Periksa keberadaan elemen
      let harga = parseFloat(hargaElem.getAttribute("value"));
      let stock = parseInt(stockElem.getAttribute("value"));
      let jumlah = parseInt(jumlahElem.value);
      let pengiriman = parseInt(10000);

      // Memperbarui total harga
      total_ += harga * jumlah;
      total_harga = total_ + pengiriman;

      // Jika jumlah pembelian tidak 0, tambahkan ke list item
      if (jumlah > 0) {
        item_ids.push({
          id: id,
          price: harga, // Tambahkan harga
          quantity: jumlah,
        });
      }
    }
  });

  // Update tampilan total harga
  document.getElementById("total_harga").value = total_harga;

  // Kirim data ke server untuk penyimpanan
  if (item_ids.length > 0) {
    console.log("Item yang akan dibeli:", item_ids); // Debug: Tampilkan item yang akan dibeli
    fetch("placeOrder.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        items: item_ids,
        total_harga: total_harga, // Kirim total harga ke server
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          console.log("Order berhasil ditambahkan/updated ke database.");

          let snapToken = data.snapToken; // Ambil snapToken dari respons

          // Tambahkan order ke database
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
                // Redirect to Midtrans Payment Page
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
          console.error(
            "Gagal menambahkan/updated order ke database:",
            data.message
          );
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }
}

//  Tampilkan total harga tanpa pemisah ribuan
//  document.getElementById("total_harga").value = totalHarga;

// function total() {
//   var beras = 12000 * parseInt(document.getElementById("jumlah_beras").value);
//   var minyak = 20000 * parseInt(document.getElementById("jumlah_minyak").value);
//   var gula = 10000 * parseInt(document.getElementById("jumlah_gula").value);
//   var susu = 13000 * parseInt(document.getElementById("jumlah_susu").value);
//   var telur = 29000 * parseInt(document.getElementById("jumlah_telur").value);
//   var garam = 3000 * parseInt(document.getElementById("jumlah_garam").value);
//   var grand_total = beras + minyak + gula + susu + telur + garam;
//   document.getElementById("total_harga").value = grand_total;
// }

// Batas Maksimal jumlah pembelian sesuai stock
// Beras
// const Stok_beras = document.getElementById("stock_beras").value;
// const Pembelian_beras = document.getElementById("jumlah_beras");
// // Mengatur atribut "max" pada input pembelian sesuai dengan nilai stok
// Pembelian_beras.setAttribute("max", Stok_beras);
// // Menambahkan event listener untuk memastikan nilai pembelian tidak melebihi stok saat input berubah
// Pembelian_beras.addEventListener("input", function () {
//   const PembelianBeras = parseInt(Pembelian_beras.value);

//   if (PembelianBeras > Stok_beras) {
//     Pembelian_beras.value = Stok_beras;
//   }
// });

// // Minyak
// const Stok_minyak = document.getElementById("stock_minyak").value;
// const Pembelian_minyak = document.getElementById("jumlah_minyak");
// // Mengatur atribut "max" pada input pembelian sesuai dengan nilai stok
// Pembelian_minyak.setAttribute("max", Stok_minyak);
// // Menambahkan event listener untuk memastikan nilai pembelian tidak melebihi stok saat input berubah
// Pembelian_minyak.addEventListener("input", function () {
//   const PembelianMinyak = parseInt(Pembelian_minyak.value);

//   if (PembelianMinyak > Stok_minyak) {
//     Pembelian_minyak.value = Stok_minyak;
//   }
// });

// // Gula
// const Stok_gula = document.getElementById("stock_gula").value;
// const Pembelian_gula = document.getElementById("jumlah_gula");
// // Mengatur atribut "max" pada input pembelian sesuai dengan nilai stok
// Pembelian_gula.setAttribute("max", Stok_gula);
// // Menambahkan event listener untuk memastikan nilai pembelian tidak melebihi stok saat input berubah
// Pembelian_gula.addEventListener("input", function () {
//   const PembelianGula = parseInt(Pembelian_gula.value);

//   if (PembelianGula > Stok_gula) {
//     Pembelian_gula.value = Stok_gula;
//   }
// });

// // Susu
// const Stok_susu = document.getElementById("stock_susu").value;
// const Pembelian_susu = document.getElementById("jumlah_susu");
// // Mengatur atribut "max" pada input pembelian sesuai dengan nilai stok
// Pembelian_susu.setAttribute("max", Stok_susu);
// // Menambahkan event listener untuk memastikan nilai pembelian tidak melebihi stok saat input berubah
// Pembelian_susu.addEventListener("input", function () {
//   const PembelianSusu = parseInt(Pembelian_susu.value);

//   if (PembelianSusu > Stok_susu) {
//     Pembelian_susu.value = Stok_susu;
//   }
// });

// // telur
// const Stok_telur = document.getElementById("stock_telur").value;
// const Pembelian_telur = document.getElementById("jumlah_telur");
// // Mengatur atribut "max" pada input pembelian sesuai dengan nilai stok
// Pembelian_telur.setAttribute("max", Stok_telur);
// // Menambahkan event listener untuk memastikan nilai pembelian tidak melebihi stok saat input berubah
// Pembelian_telur.addEventListener("input", function () {
//   const PembelianTelur = parseInt(Pembelian_telur.value);

//   if (PembelianTelur > Stok_telur) {
//     Pembelian_telur.value = Stok_telur;
//   }
// });

// // Garam
// const Stok_garam = document.getElementById("stock_garam").value;
// const Pembelian_garam = document.getElementById("jumlah_garam");
// // Mengatur atribut "max" pada input pembelian sesuai dengan nilai stok
// Pembelian_garam.setAttribute("max", Stok_garam);
// // Menambahkan event listener untuk memastikan nilai pembelian tidak melebihi stok saat input berubah
// Pembelian_garam.addEventListener("input", function () {
//   const PembelianGaram = parseInt(Pembelian_garam.value);

//   if (PembelianGaram > Stok_garam) {
//     Pembelian_garam.value = Stok_garam;
//   }
// });

// form Validation dan kirim data
const checkoutButton = document.querySelector(".checkout_button");

checkoutButton.addEventListener("click", async function (e) {
  e.preventDefault();

  // Memanggil fungsi total() untuk menghitung total harga dan memperbarui item_ids
  total();
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
