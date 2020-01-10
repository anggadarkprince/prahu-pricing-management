<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset='utf-8'>
	<title>Quotation</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900">
	<style>
		@page {
			margin: 25px 35px;
		}

		* {
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
		}

		body {
			margin: 5px;
			background: none;
			font-family: Roboto, sans-serif;
			font-weight: normal;
			font-size: 11px;
		}

		hr {
			height: 0;
			-webkit-box-sizing: content-box;
			-moz-box-sizing: content-box;
			box-sizing: content-box;
			margin-top: 10px;
			margin-bottom: 10px;
			border: 0;
			border-top: 1px solid #ddd;
		}

		p {
			margin: 0;
			font-family: Roboto, sans-serif;
		}

		.subtitle {
			font-size: 10px;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			vertical-align: middle;
		}

		table th {
			font-family: Roboto, sans-serif;
			font-weight: 600;
		}

		table.table {
			width: 100%;
			border-collapse: collapse;
			border: 1px solid #000;
		}

		table.table td,
		table.table th {
			vertical-align: middle;
			border: 1px solid #000;
			padding: 3px 6px;
			line-height: 1;
		}

		table td {
			line-height: 0.9;
		}

		.text-center {
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="text-center">
		<img src="<?= FCPATH . 'assets/dist/img/layouts/logo-header.png' ?>" style="width: 240px;">
		<p><strong>Solusi Kirim Kontainer Mudah, Aman, Murah</strong></p>
		<p class="subtitle">Telp 031-7482307 / 0811-3457863 , Email cs.prahu@gmail.com / www.prahu-hub.com</p>
		<hr style="border-bottom: 1px solid #000; margin-top: 5px; margin-bottom: 5px">
		<h3 style="margin-top: 0; margin-bottom: 0">PENAWARAN HARGA PENGIRIMAN BARANG</h3>
	</div>
	<div>
		<p>Kami yang bertandatangan di bawah ini:</p>
		<table>
			<tr>
				<td style="width: 20px">I</td>
				<td style="width: 70px">Nama</td>
				<td style="width: 20px">:</td>
				<td><?= $quotation['customer'] ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Mewakili</td>
				<td>:</td>
				<td><?= if_empty($quotation['company'], '-') ?></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="3">selanjutnya disebut sebagai <strong>"PIHAK PERTAMA"</strong></td>
			</tr>
			<tr>
				<td colspan="4"></td>
			</tr>
			<tr>
				<td>II</td>
				<td>Nama</td>
				<td>:</td>
				<td><?= $quotation['marketing'] ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Jabatan</td>
				<td>:</td>
				<td>Marketing</td>
			</tr>
			<tr>
				<td></td>
				<td>Mewakili</td>
				<td>:</td>
				<td>PT. APLIKASI TEPAT GUNA (PRAHU-HUB)</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="3">selanjutnya disebut sebagai <strong>"PIHAK KEDUA"</strong></td>
			</tr>
		</table>

		<p style="margin-bottom: 10px">
			Dengan ini para pihak setuju membuat perjanjian pengangkatan barang dengan syarat dan ketentuan
			sebagai berikut :
		</p>

		<p style="margin-bottom: 7px"><strong>A. &nbsp; DETAIL PENGIRIMAN</strong></p>
		<table class="table" style="margin-bottom: 10px; margin-left: 16px">
			<tr>
				<th style="width: 25%"></th>
				<th style="width: 75%">DETAIL</th>
			</tr>
			<tr>
				<td>Incoterm/Rute</td>
				<td><?= $quotation['service'] ?></td>
			</tr>
			<tr>
				<td>Rute</td>
				<td><?= $quotation['port_from'] ?> - <?= $quotation['port_to'] ?></td>
			</tr>
			<tr>
				<td>Pelayaran</td>
				<td>
					<?php $noShippingLine = true; ?>
					<?php foreach($quotationComponents as $quotationComponent): ?>
						<?php if($quotationComponent['type'] == 'SHIPPING LINE'): ?>
							<?php $noShippingLine = false ?>
							<?= $quotationComponent['vendor'] ?>
						<?php endif ?>
					<?php endforeach ?>
					<?php if($noShippingLine): ?>
						-
					<?php endif ?>
				</td>
			</tr>
			<tr>
				<td>Kuantitas</td>
				<td><?= $quotation['container_size'] ?>' <?= $quotation['container_type'] ?></td>
			</tr>
			<tr>
				<td>Alamat door muat</td>
				<td><?= if_empty($quotation['location_from'], '-') ?></td>
			</tr>
			<tr>
				<td>Alamat door bongkar</td>
				<td><?= if_empty($quotation['location_to'], '-') ?></td>
			</tr>
			<tr>
				<td>Barang dan packing</td>
				<td><?= if_empty($quotation['loading_category'], '-') ?></td>
			</tr>
			<tr>
				<td>Harga</td>
				<td>Rp. <?= numerical($quotation['total_price_after_tax']) ?></td>
			</tr>
			<tr>
				<td>Harga SUDAH termasuk</td>
				<td>
					<?= implode(', ', array_column($quotationSubComponents, 'sub_component')) ?>
				</td>
			</tr>
			<tr>
				<td>Harga TIDAK termasuk</td>
				<td>
					<?= implode(', ', $quotationExcludes) ?>
				</td>
			</tr>
			<tr>
				<td>Perkiraan tgl muat</td>
				<td><?= format_date($quotation['loading_date'], 'd F Y') ?></td>
			</tr>
		</table>

		<p style="margin-bottom: 5px"><strong>B. &nbsp; KETENTUAN UMUM</strong></p>
		<ol style="padding-left: 35px; margin-top: 0">
			<li>Harga tidak mengikat sampai dengan diterimanya tanda jadi.</li>
			<li>PARA PIHAK sepakat untuk menggunakan platform Prahu-hub sebagai perangkat control.</li>
			<li>Ketentuan pembayaran :
				<ul style="padding-left: 17px">
					<li><?= numerical($quotation['payment_percent']) ?>% - <?= $quotation['payment_type'] ?></li>
				</ul>
			</li>
			<li>Denda dan Sanksi :
				<ul style="padding-left: 17px">
					<li>PIHAK PERTAMA berjanji untuk membayar penuh dan tepat waktu sesuai point 3 (tiga) di atas.</li>
					<li>
						Apabila PIHAK PERTAMA terlambat melakukan pembayaran setelah 30 (tiga puluh) hari sejak barang
						diterima dan tagihan telah diserahkan kepada PIHAK PERTAMA, maka setelah 5 (lima) hari,
						PIHAK KEDUA akan mengenakan denda sebesar 2% (dua persen) per bulan, dihitung setiap hari
						saat keterlambatan dan dibayar secara langsung selambat-lambatnya pada saat pelunasan.
					</li>
				</ul>
			</li>
			<li>Pembatasan tanggung jawab:
				<ul style="padding-left: 17px">
					<li>
						PIHAK PERTAMA menjamin bahwa barang tersebut bukan barang curian, barang berbahaya
						mudah terbakar/ apapun yang bertentangan dengan peraturan yang berlaku di Republik Indonesia
					</li>
					<li>PIHAK KEDUA tidak bertanggung jawab atas asal usul, kondisi dan kualitas barang</li>
					<li>PIHAK KEDUA tidak bertanggung jawab atas adanya biaya retur barang</li>
					<li>
						PIHAK KEDUA tidak menerima segala bentuk klaim barang jika kondisi segel kontainer masih dalam
						keadaan baik/utuh
					</li>
					<li>
						PIHAK KEDUA tidak bertanggung jawab atas perubahan jadwal atau keterlambatan yang diakibatkan
						faktor lain di luar kendali Pihak Kedua
					</li>
				</ul>
			</li>
			<li>Perselisihan:
				<ul style="padding-left: 17px">
					<li>
						Apabila ada perselisihan, akan diselesaikan secara kekeluargaan, dan bila dalam 90 (sembilan puluh hari)
						perselisihan tersebut tidak terselesaikan, maka para pihak sepakat untuk menyelesaikan
						perselisihan tersebut di Pengadilan Negeri Surabaya.
					</li>
				</ul>
			</li>
		</ol>

		<p>Demikian surat perjanjian ini dibuat secara sadar dan tanpa paksaan.</p>
		<p style="margin-bottom: 20px">Surat perjanjian ini ditandatangani pada tanggal <?= format_date($quotation['created_at'], 'd F Y') ?> dan digunakan sebagai bukti pemesanan di Prahu-Hub.</p>

		<table>
			<tr>
				<td>
					<p>PIHAK PERTAMA,</p>
					<p><strong><?= $quotation['company'] ?></strong></p>
					<br>
					<br>
					<br>
					<br>
					<p>(<?= $quotation['customer'] ?>)</p>
				</td>
				<td>
					<p>PIHAK KEDUA,</p>
					<p><strong>PT.APLIKASI TEPAT GUNA</strong></p>
					<br>
					<br>
					<br>
					<br>
					<p>(<?= $quotation['marketing'] ?>)</p>
				</td>
			</tr>
		</table>
	</div>

</body>

</html>
