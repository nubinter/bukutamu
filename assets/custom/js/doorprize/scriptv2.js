"use strict";

const btnMulai = document.getElementById("btnMulai");
const btnBerhenti = document.getElementById("btnBerhenti");
const lblNama = document.getElementById("lblNama");
const pemenangList = document.getElementById("pemenangList");
let onProcess = false; // Flag menandai apakah proses acak sedang berlangsung

const pemenang = [];

const acakNama = () => {
  const idx = Math.floor(Math.random() * nama.length);
  return idx;
};

const ubahLabelNama = () => {
  const idx = acakNama();
  const namaPemenang = nama[idx];
  lblNama.innerHTML = namaPemenang;

  if (onProcess === true) {
    setTimeout("ubahLabelNama()", 50);
  } else {
    console.log(idx, namaPemenang);
    // Masukkan nama pemenang ke array
    pemenang.push(namaPemenang);
    // Remove nama dari array yang sudah dipilih agar tidak muncul lagi
    nama.splice(idx, 1);
    // Tampilkan pemenang
    tampilkanPemenang(namaPemenang);
  }
};

const tampilkanPemenang = (nama) => {
  // for (let i = 0; i < pemenang.length; i++) {
  //   const li = document.createElement("li");
  //   // li.classList.add("list-group-item");
  //   li.appendChild(document.createTextNode(pemenang[i]));
  //   pemenangList.appendChild(li);
  // }

  const li = document.createElement("li");
  li.classList.add("list-group-item");
  li.appendChild(document.createTextNode(nama));
  pemenangList.appendChild(li);
};

const mulai = () => {
  // 1. Ubah btn mulai menjadi hidden
  btnMulai.classList.add("hidden");
  // 2. Remove class hidden dari btn berhenti
  btnBerhenti.classList.remove("hidden");
  // 3. Tampilkan nama pertama
  const idx = acakNama();
  lblNama.innerHTML = nama[idx];
  // 4. Ubah flag menjadi true
  onProcess = true;
  setTimeout("ubahLabelNama()", 50);
  return false;
};

const berhenti = () => {
  onProcess = false;
  // 1. Ubah btn berhenti menjadi hidden
  btnBerhenti.classList.add("hidden");
  // 2. Remove class hidden dari btn mulai
  btnMulai.classList.remove("hidden");
  console.log(nama);
  return false;
};
