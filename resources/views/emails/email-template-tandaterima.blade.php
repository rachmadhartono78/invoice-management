<p>Kepada Yth.<br>
    Bapak/Ibu Tenant {{ $data["tenantName"] }}<br><br>

    Hal: Informasi Tanda Terima untuk No Invoice {{ $data["invoice"] }} <br><br>

    Dengan hormat, <br>
    Bersama ini Kami sampaikan tanda terima untuk No Invoice {{ $data["invoice"]}} , dengan rincian sebagai berikut: <br>
    Nama Tenant : {{$data["tenantName"]}} <br>
    Alamat Pelanggan : JL GT SUBROTO KAV 56 <br>
    Jumlah Pembayaran : Rp. {{ number_format($data["paid"] ,2,',','.') }}<br>
    Terbilang : {{ $data["terbilang"] }}<br><br><br>


    Atas perhatian yang diberikan Kami ucapkan terima kasih. <br><br>

    Hormat Kami, <br>

    PPPGSI<br></p>