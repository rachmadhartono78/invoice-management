<p>Kepada Yth.<br>
    Bapak/Ibu Tenant {{ $data["tenantName"] }}<br><br>

    Hal: Informasi Tagihan bulan {{ $data["month"] }} {{ $data["year"] }} <br><br>

    Dengan hormat, <br>
    Bersama ini Kami sampaikan informasi tagihan bulan {{ $data["month"]}} {{ $data["year"] }}, dengan rincian sebagai berikut: <br>
    Nama Tenant : {{$data["tenantName"]}} <br>
    Alamat Pelanggan : JL GT SUBROTO KAV 56 <br>
    Jumlah Luasan : <br>
    Jumlah Tagihan : Rp. {{ number_format($data["total"] ,2,',','.') }}<br>
    Terbilang : {{ $data["terbilang"] }}<br><br><br>


    Atas perhatian yang diberikan Kami ucapkan terima kasih. <br><br>

    Hormat Kami, <br>

    PPPGSI<br></p>