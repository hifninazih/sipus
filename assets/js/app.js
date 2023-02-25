/* Konfirmasi Sebelum Hapus */
var elems = document.getElementsByClassName('confirm');
var confirmIt = function (e) {
    if (!confirm('Apakah yakin akan dihapus?')) e.preventDefault();
};

for (let i = 0, l = elems.length; i < l; i++) {
    elems[i].addEventListener('click', confirmIt, false);
}

/* Konfirmasi Sebelum Kembalikan Buku */
var element = document.getElementsByClassName('confirm-kembali');
var confirm_kembali = function (e) {
    if (!confirm('Apakah yakin buku sudah dikembalikan?')) e.preventDefault();
};

for (let i = 0, l = element.length; i < l; i++) {
    element[i].addEventListener('click', confirm_kembali, false);
}

/* Konfirmasi Sebelum Kembalikan Buku */
var element = document.getElementsByClassName('confirm-batal');
var confirm_batal = function (e) {
    if (!confirm('Apakah yakin buku batal dikembalikan?')) e.preventDefault();
};

for (let i = 0, l = element.length; i < l; i++) {
    element[i].addEventListener('click', confirm_batal, false);
}

// Sidebar Aktif
 const sidebar = document.getElementsByClassName('sidebar');
 // console.log(sidebar);
 // console.log(page);
 // console.log(isset);
 sidebar[0].classList.add('active');
 for(var i = 0; i < sidebar.length; i++){
    if(sidebar[i].classList.contains(page)){
        sidebar[i].classList.add('active');
    }else{
        sidebar[i].classList.remove('active');
    }
 }

const menu = document.querySelector('.menu-toggle input');
const slide = document.querySelector('.sidebarr');

menu.addEventListener('click', function(){
    slide.classList.toggle('slide');
    console.log('ok');
});