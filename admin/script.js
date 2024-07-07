let selectedProducts = [];

function addProduct() {
  const productId = document.getElementById("product_id").value;
  const productQty = document.getElementById("product_qty").value;
  selectedProducts.push({ id: productId, qty: productQty });
  document.getElementById("product_id").value = "";
  document.getElementById("product_qty").value = "";
  displaySelectedProducts();
}

function displaySelectedProducts() {
  const selectedProductsDiv = document.getElementById("selectedProducts");
  selectedProductsDiv.innerHTML = "<h2>Produk yang Dipilih:</h2>";
  selectedProducts.forEach((product) => {
    selectedProductsDiv.innerHTML +=
      "<p>ID Produk: " + product.id + " ~~~~~ Jumlah: " + product.qty + "</p>";
  });
}

function checkout() {
  // Kirim data produk yang dipilih ke server untuk pembuatan struk belanjaan
  fetch("checkout.php", {
    method: "POST",
    body: JSON.stringify(selectedProducts),
  })
    .then((response) => response.text())
    .then((data) => {
      // Tampilkan struk belanjaan
      document.getElementById("receipt").style.display = "block";
      document.getElementById("receipt").innerHTML = data;
    });
}
