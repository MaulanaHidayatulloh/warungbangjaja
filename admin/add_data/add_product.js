function submitForm(event) {
  event.preventDefault(); // Mencegah perilaku bawaan formulir
  const formData = new FormData(document.getElementById("addProductForm"));

  // Kirim data formulir menggunakan fetch API
  fetch("add_product.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.text(); // Mengembalikan teks respons
    })
    .then((data) => {
      if (data === "ID sudah ada") {
        alert("ID sudah ada dalam database. Harap masukkan ID yang berbeda.");
      } else {
        alert("Produk berhasil ditambahkan!");
        document.getElementById("addProductForm").reset(); // Mengatur ulang formulir setelah penambahan berhasil
      }
    })
    .catch((error) => {
      console.error("Terjadi kesalahan!", error);
      alert("Gagal menambahkan produk");
    });
}
