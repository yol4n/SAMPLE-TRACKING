// Elemen DOM
const formInput = document.getElementById("form-input");
const btnTambah = document.getElementById("btn-tambah");
const tbodySample = document.getElementById("tbody-sample");
const btnPencarian = document.getElementById("btn-pencarian");
const inputPencarian = document.getElementById("input-pencarian");

// Variabel Global untuk Status Edit
let isEditMode = false;
let editId = null;

// Fungsi untuk menampilkan daftar sample
function tampilkanDaftarSample(data) {
  tbodySample.innerHTML = ""; // Bersihkan isi tabel
  data.forEach((sample) => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${sample.nama_sampel}</td>
      <td>${sample.kode_sampel}</td>
      <td>${sample.tanggal_input}</td>
      <td>${sample.tangga}</td>
      <td>${sample.refco}</td>
      <td>${sample.rak}</td>
      <td>${sample.kode_rak}</td>
      <td>
        <button class="btn-edit" data-id="${sample.id}">Edit</button>
        <button class="btn-hapus" data-id="${sample.id}">Hapus</button>
      </td>
    `;
    tbodySample.appendChild(row);
  });

  // Tambahkan event listener untuk tombol Edit dan Hapus
  document.querySelectorAll(".btn-edit").forEach((button) =>
    button.addEventListener("click", handleEdit)
  );
  document.querySelectorAll(".btn-hapus").forEach((button) =>
    button.addEventListener("click", handleHapus)
  );
}

// Fetch data dari server
async function ambilDataSample() {
  try {
    const response = await fetch("server.php?action=get");
    if (!response.ok) throw new Error("Gagal mengambil data dari server.");
    const data = await response.json();
    tampilkanDaftarSample(data);
  } catch (error) {
    alert("Error: " + error.message);
  }
}

// Fungsi Tambah/Update Data
btnTambah.addEventListener("click", async (e) => {
  e.preventDefault();
  const formData = new FormData(formInput);

  let url = "server.php?action=add";
  if (isEditMode) {
    url = "server.php?action=update";
    formData.append("id", editId);
  }

  try {
    const response = await fetch(url, {
      method: "POST",
      body: formData,
    });

    if (response.ok) {
      alert(isEditMode ? "Data berhasil diupdate!" : "Data berhasil ditambahkan!");
      ambilDataSample(); // Refresh data
      formInput.reset(); // Reset form
      btnTambah.textContent = "Tambah"; // Kembalikan tombol
      isEditMode = false;
      editId = null;
    } else {
      throw new Error("Proses gagal!");
    }
  } catch (error) {
    alert("Error: " + error.message);
  }
});

// Fungsi Hapus Data
async function handleHapus(e) {
  const id = e.target.dataset.id;
  const confirmHapus = confirm("Apakah Anda yakin ingin menghapus data ini?");
  if (!confirmHapus) return;

  try {
    const response = await fetch(`server.php?action=delete&id=${id}`, {
      method: "GET",
    });

    if (response.ok) {
      alert("Data berhasil dihapus!");
      ambilDataSample(); // Refresh data
    } else {
      throw new Error("Gagal menghapus data!");
    }
  } catch (error) {
    alert("Error: " + error.message);
  }
}

// Fungsi Edit Data
async function handleEdit(e) {
  const id = e.target.dataset.id;

  try {
    const response = await fetch(`server.php?action=get&id=${id}`);
    if (!response.ok) throw new Error("Gagal mengambil data untuk edit.");
    const sample = await response.json();

    // Isi form dengan data yang akan diedit
    document.getElementById("tanggal-input").value = sample.tanggal_input;
    document.getElementById("refco").value = sample.refco;
    document.getElementById("tangga").value = sample.tangga;
    document.getElementById("rak").value = sample.rak;
    document.getElementById("kode-rak").value = sample.kode_rak;
    document.getElementById("kode-sampel").value = sample.kode_sampel;
    document.getElementById("nama-sample").value = sample.nama_sampel;

    // Ubah tombol Tambah menjadi Update
    btnTambah.textContent = "Update";
    isEditMode = true;
    editId = id;
  } catch (error) {
    alert("Error: " + error.message);
  }
}

// Fungsi Pencarian
btnPencarian.addEventListener("click", async () => {
  const keyword = inputPencarian.value.trim();
  if (!keyword) {
    alert("Masukkan kata kunci pencarian!");
    return;
  }

  try {
    const response = await fetch(`server.php?action=search&keyword=${keyword}`);
    if (!response.ok) throw new Error("Gagal melakukan pencarian.");
    const data = await response.json();
    tampilkanDaftarSample(data);
  } catch (error) {
    alert("Error: " + error.message);
  }
});

// Muat data awal
document.addEventListener("DOMContentLoaded", ambilDataSample);
