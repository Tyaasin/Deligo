function showMenuForCustomer() {
  const menu = JSON.parse(localStorage.getItem('menu')) || [];
  const list = document.getElementById('menu-list');
  list.innerHTML = '';
  menu.forEach((item) => {
    list.innerHTML += `
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="${item.gambar}" class="card-img-top" alt="${item.nama}" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">${item.nama}</h5>
            <p class="card-text">Rp ${item.harga}</p>
            <button class="btn btn-primary" onclick="pesanMenu('${item.nama}')">Pesan</button>
          </div>
        </div>
      </div>`;
  });
}
