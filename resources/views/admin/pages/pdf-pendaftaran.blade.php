<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Cetak Pendaftaran</title>
	<link rel="stylesheet" href="/adminlte/css/adminlte.min.css">
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/dist/css/pdf-pendaftaran.css">
</head>
<body>
<div class="container-fluid">
    
    <div class="row" id="print-element">
        <div class="col-12 d-flex justify-content-center">
            <img src="/dist/img/kop.png" alt="kop surat" width="90%">
        </div>
        <div class="col-12 d-flex justify-content-center font-weight-bold h5 mt-3 mb-3 underline big">
            KEPUTUSAN PANITIA PPDB
        </div>
        <div class="col-12 d-flex justify-content-center font-weight-bold h5 mt-2 big">
            PANITIA PPDB SMK MUHAMMADIYAH BLIGO
        </div>
        <div class="col-12 d-flex justify-content-center font-weight-bold h5 mb-3 big">
            TAHUN PELAJARAN 2023/2024
        </div>
        <div class="col-12 d-flex justify-content-center flex-wrap">
            <div class="small d-flex justify-content-start flex-wrap cw">
                <div class="w-left font-weight-bold">
                    1. Menimbang
                </div>
                <div class="font-weight-bold w-colon">:</div>
                <div class="w-right">
                    <ol class="list-top">
                        <li>Kebijakan Panitia PPDB SMK MUHAMMADIYAH BLIGO dalam hubungannya dengan proyeksi daya tampung sekolah tahun pelajaran 2022/2023.</li>
                        <li>Hasil rapat tim verifikasi panitia PPDB SMK MUHAMMADIYAH BLIGO tahun pelajaran 2022/2023.</li>
                    </ol>
                </div>

                <div class="w-left font-weight-bold">
                    2. Mengingat
                </div>
                <div class="w-colon font-weight-bold">:</div>
                <div class="w-right d-flex flex-column">
                    <ol class="list-top">
                        <li>Petunjuk  Teknis  Penerimaan  Peserta   Didik  Baru (PPDB)  tahun pelajaran 2022/2023.</li>
                    </ol>
                </div>
                <div class="w-left mt-2 font-weight-bold">
                    3. Memutuskan
                </div>
                <div class="w-colon mt-2 font-weight-bold">:</div>
                <div class="w-100 d-flex justify-content-center mt-2">
                    <div class="d-flex justify-content-start font-weight-bold text-uppercase flex-wrap big w-center">
                        <div class="w-left">NAMA</div>
                        <div class="w-colon">:</div>
                        <div class="w-right pl-left border-bottom-dotted border-top-dotted">{{ $data->nama_lengkap }}</div>

                        <div class="w-left">Tanggal Lahir</div>
                        <div class="w-colon">:</div>
                        <div class="w-right pl-left border-bottom-dotted">{{ $data->tanggal_lahir }}</div>

                        <div class="w-left">KODE</div>
                        <div class="w-colon">:</div>
                        <div class="w-right pl-left border-bottom-dotted">{{ $data->jurusan->kode }}</div>

                        <div class="w-left">JALUR</div>
                        <div class="w-colon">:</div>
                        <div class="w-right pl-left border-bottom-dotted">{{ ModelHelper::getJalur($data->jalur_pendaftaran) }}</div>
                    </div>
                </div>
                <div class="w-left mt-3 font-weight-bold">
                    4. Menetapkan
                </div>
                <div class="w-colon mt-3 font-weight-bold">:</div>
                <div class="w-right d-flex flex-column mt-3">
                    <div class="text-uppercase w-100 font-weight-bold text-ket pl-left">
                        <span class="line-through">tidak diterima</span> / diterima / <span class="line-through">cadangan</span>
                    </div>
                    <div class="mt-3 pl-left">
                        Sebagai Peserta Didik Baru Kelas X SMK Muhammadiyah Bligo Tahun Pelajaran 2022/2023
                    </div>
                    <div class="pl-left text-left">
                        Di Kompetensi Keahlian : <span class="font-weight-bold">{{$data->jurusan->jurusan}}</span> 
                    </div>
                </div>

                <div class="w-100 mt-3 font-weight-bold">
                    Dengan Ketentuan :
                </div>
                <div class="w-100" style="line-height:28px">
                    <ol class="list-bottom">
                        <li>
                            Bagi Calon Peserta Didik Baru yang dinyatakan DITERIMA dapat melakukan Daftar Ulang pada hari Senin-Jumat pukul 08.00 s/d 13.00 WIB di SMK Muhammadiyah Bligo.
                        </li>
                        <li>
                            Bagi Calon Peserta Didik Baru jalur bintang kelas dan jalur umum yang DITERIMA  diwajibkan melakukan Daftar Ulang dengan melunasi biaya Daftar Ulang sebesar Rp 500.000,- (Lima ratus ribu rupiah), berlaku untuk semua kompetensi keahlian. Bagi pendaftar jalur BidikMisi, biaya daftar ulang merujuk pada ketentuan dari sekolah yang sudah dipublikasikan.
                        </li>
                        <li>
                            Apabila saat akan melakukan Daftar Ulang ternyata kompetensi keahlian yang dipilih kuotanya sudah penuh maka Calon Peserta Didik Baru tidak bisa melanjutkan pada kompetensi keahlian yang dipilih. Oleh karena itu, diharapkan semua Calon Peserta Didik Baru untuk segera melakukan Daftar Ulang setelah dinyatakan diterima.
                        </li>
                        <li>
                            Surat Keputusan ini sebagai bukti bahwa Calon Peserta Didik telah melakukan pendaftaran, mengisi formulir dan menyerahkan berkas pendaftaran. Apabila di kemudian hari Calon Peserta Didik melanggar aturan sebagai berikut :
                            <ol type="a">
                                <li>
                                    Calon Peserta Putra : bertato, bertindik, mengedarkan dan menggunakan Narkoba
                                </li>
                                <li>
                                    Calon Peserta Putri	: bertato, mengedarkan dan menggunakan Narkoba, hamil di luar nikah
                                </li>
                            </ol>
                            Maka surat keputusan ini tidak berlaku (calon peserta didik baru dianggap mengundurkan diri) dan tidak mendapatkan pengembalian biaya yang telah disetorkan pada pihak sekolah.
                        </li>
                        <li>
                            Apabila Calon Peserta Didik Baru mengundurkan diri karena diterima di sekolah lain maka tidak mendapatkan pengembalian biaya yang telah disetorkan pada pihak sekolah.
                        </li>
                        <li>
                            Bagi Calon Peserta Didik Baru yang sudah melakukan daftar ulang, harap memperhatikan informasi melalui facebook SMK Muhamamdiyah Bligo, IG @smkmuhbligo_ig dan WA PPDB SMK Muhammadiyah Bligo.
                        </li>
                        <li>
                            Segala Keputusan ini tidak bisa diganggu gugat.
                        </li>
                        <li>
                            Apabila ada hal yang belum diputuskan dalam Surat Keputusan ini maka akan diatur di kemudian hari.
                        </li>
                    </ol>
                </div>
                        
                <div class="w-100 d-flex justify-content-end">
                    <img src="/dist/img/kepsek.png" alt="tanda tangan" width="25%">
                </div>
                <div class="w-100 d-flex justify-content-center">
                    <img src="/dist/img/footer.png" alt="footer surat" width="100%">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.onload = () => window.print()
</script>
</body>
</html>