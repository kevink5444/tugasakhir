// JavaScript untuk halaman dashboard

// Fungsi untuk menampilkan pesan selamat datang saat halaman dimuat
function welcomeMessage() {
    alert('Selamat datang di Dashboard Sistem Informasi Penggajian dan Absensi Karyawan!');
}

// Fungsi untuk menampilkan detail karyawan saat nama karyawan diklik
function showEmployeeDetails(employeeId) {
    // Misalnya, Anda dapat menggunakan AJAX untuk mengambil detail karyawan dari server
    // dan menampilkannya dalam sebuah popup atau modul
    alert('Anda mengklik karyawan dengan ID ' + employeeId);
}

// Panggil fungsi pesan selamat datang saat halaman dimuat
window.onload = function() {
    welcomeMessage();
};

// Anda dapat menambahkan fungsi-fungsi tambahan di sini sesuai kebutuhan Anda
