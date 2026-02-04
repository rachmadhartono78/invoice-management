<p>Kepada Yth.<br>
    Bapak/Ibu Vendor {{ $data["vendorName"] }}<br><br>

    Hal: Informasi Purchase Order {{ $data["about"] }} <br><br>

    Dengan hormat, <br>
    Bersama ini Kami kirimkan purchase order dengan nomor : {{ $data["po_number"] }}, dengan rincian sebagai berikut: <br>
    Nama Vendor : {{$data["vendorName"]}} <br>
    Alamat Pelanggan : JL GT SUBROTO KAV 56 <br>
    Nilai Purchase Order : Rp. {{ number_format($data["grand_total"] ,2,',','.') }}<br>
    Terbilang : {{ $data["terbilang"] }}<br><br><br>


    Atas perhatian yang diberikan Kami ucapkan terima kasih. <br><br>

    Hormat Kami, <br>

    PPPGSI<br></p>