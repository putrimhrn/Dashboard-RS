<?php
	$koneksi = oci_connect('TB BASDAT','220902','localhost/xe') or die('connection failed !');
	if(!empty($koneksi)){
		// echo "koneksi sukses !<br /><br />";
		if(isset($_GET['modul'])){			
			switch($_GET['modul']){
				case 'getdata':
					$statement = oci_parse($koneksi,"select id_pasien,nama_pasien,jenis_kelamin,umur, alamat, keluhan from pasien") or die('statement error');
					oci_execute($statement) or die('execute error');
                    include 'data_pasien.php';
                    break;
				case 'filter':
					$cari = $_POST['cari'];
					print_r($cari);
					$statement = oci_parse($koneksi,"select id_pasien,nama_pasien,jenis_kelamin,umur, alamat, keluhan from pasien where id_pasien like '%$cari%'") or die('statement error');
					oci_execute($statement) or die('execute error');
					include 'data_pasien.php';
				case 'getdata-pembayaran':
					$statement = oci_parse($koneksi,"select id_pembayaran, tanggal_pembayaran, biaya_pembayaran, nama_pasien, nama_obat from struk_pembayaran s left join pasien p on s.pasien_id_pasien = p.id_pasien left join memuat m on s.id_pembayaran = m.struk_pembayaran_id left join obat o on m.obat_id_obat = o.id_obat") or die('statement error');
					oci_execute($statement) or die('execute error');
                    include 'pembayaran.php';		
                    break;
				case 'filter-pembayaran':
					$cari = $_POST['cari'];
					print_r($cari);
					$statement = oci_parse($koneksi,"select id_pembayaran, tanggal_pembayaran, biaya_pembayaran, nama_pasien, nama_obat from struk_pembayaran s left join pasien p on s.pasien_id_pasien = p.id_pasien left join memuat m on s.id_pembayaran = m.struk_pembayaran_id left join obat o on m.obat_id_obat = o.id_obat where id_pembayaran like '%$cari%'") or die('statement error');
					oci_execute($statement) or die('execute error');
					include 'pembayaran.php';		
					// header('location:index.php?modul=getdata-pembayaran');
					// exit(0);
                    break;										
				case 'add':
					$ID_PASIEN = "";
					$NAMA_PASIEN = "";
					$JENIS_KELAMIN = "";
					$UMUR = "";
					$ALAMAT = "";
					$KELUHAN = "";
					$status = "BARU";
					include 'registrasi.php';
					break;
				case 'add-pembayaran':
					$ID_PEMBAYARAN = "";
					$TANGGAL_PEMBAYARAN = "";
					$BIAYA_PEMBAYARAN = "";
					$PASIEN_ID_PASIEN = "";
					$OBAT_ID_OBAT ="";
					$STRUK_PEMBAYARAN_ID="";
					$status = "BARU";
					include 'insert-pembayaran.php';
					break;
				case 'add-obat':
					$ID_OBAT = "";
					$NAMA_OBAT = "";
					$TAHUN_PRODUKSI = "";
					$MASA_BERLAKU = "";
					$status = "BARU";
					include 'obat.php';
					break;
				case 'edit':
					$statement = oci_parse($koneksi,"select id_pasien,nama_pasien,jenis_kelamin,umur, alamat, keluhan from pasien where id_pasien = '".$_GET['id_pasien']."'") or die('statement error');
					oci_execute($statement) or die('execute error');
					while($row = oci_fetch_array($statement)){
						$ID_PASIEN = $row['ID_PASIEN'];
						$NAMA_PASIEN = $row['NAMA_PASIEN'];
						$JENIS_KELAMIN = $row['JENIS_KELAMIN'];
						$UMUR = $row['UMUR'];
						$ALAMAT = $row['ALAMAT'];
						$KELUHAN = $row['KELUHAN'];						
					}
					print_r($statement);
					$status = "LAMA";
					include 'form.php';
					break;
				case 'save':
					if($_POST){
						if($_POST['status'] == "BARU"){
							$statement = oci_parse($koneksi,"insert into pasien (id_pasien,nama_pasien,jenis_kelamin,umur,alamat,keluhan) values ('".$_POST['ID_PASIEN']."','".$_POST['NAMA_PASIEN']."','".$_POST['JENIS_KELAMIN']."','".$_POST['UMUR']."','".$_POST['ALAMAT']."','".$_POST['KELUHAN']."')") or die('statement error');
						}else{
							$statement = oci_parse($koneksi,"update pasien set nama_pasien = '".$_POST['NAMA_PASIEN']."', jenis_kelamin = '".$_POST['JENIS_KELAMIN']."', umur = '".$_POST['UMUR']."', alamat = '".$_POST['ALAMAT']."', keluhan = '".$_POST['KELUHAN']."' where id_pasien = '".$_POST['ID_PASIEN']."'") or die('statement error');
						}
						$res = oci_execute($statement) or die('execute error');
						if($res){
							header('location:index.php?modul=getdata');
							exit(0);
						}else{
							echo "<h2>Hapus data gagal !!</h2>";
						}
					}else{
						echo "<h2>No Action Here !</h2>";
					}					
					break;
				case 'edit-pembayaran':
					$statement = oci_parse($koneksi,"select id_pembayaran, tanggal_pembayaran, biaya_pembayaran, pasien_id_pasien from struk_pembayaran where id_pembayaran = '".$_GET['id_pembayaran']."'") or die('statement error');
					oci_execute($statement) or die('execute error');
					while($row = oci_fetch_array($statement)){
						$ID_PEMBAYARAN = $row['ID_PEMBAYARAN'];
						$TANGGAL_PEMBAYARAN = $row['TANGGAL_PEMBAYARAN'];
						$BIAYA_PEMBAYARAN = $row['BIAYA_PEMBAYARAN'];
						$PASIEN_ID_PASIEN = $row['PASIEN_ID_PASIEN'];
					}
					print_r($statement);
					$status = "LAMA";
					include 'InputPembayaran.php';
					break;
				case 'save-pembayaran':
					if($_POST){
						print_r($_POST['status']);
						if($_POST['status'] == "BARU"){
							$statement = oci_parse($koneksi,"insert into struk_pembayaran (id_pembayaran, tanggal_pembayaran, biaya_pembayaran, pasien_id_pasien) values ('".$_POST['ID_PEMBAYARAN']."','".$_POST['TANGGAL_PEMBAYARAN']."','".$_POST['BIAYA_PEMBAYARAN']."','".$_POST['PASIEN_ID_PASIEN']."')") or die('statement error');
							$statement1 = oci_parse($koneksi,"insert into memuat (obat_id_obat, struk_pembayaran_id) values ('".$_POST['OBAT_ID_OBAT']."','".$_POST['ID_PEMBAYARAN']."')");
						}else{
							$statement = oci_parse($koneksi,"update struk_pembayaran set id_pembayaran = '".$_POST['ID_PEMBAYARAN']."',tanggal_pembayaran='".$_POST['TANGGAL_PEMBAYARAN']."',biaya_pembayaran='".$_POST['BIAYA_PEMBAYARAN']."',pasien_id_pasien='".$_POST['PASIEN_ID_PASIEN']."' where id_pembayaran = '".$_POST['ID_PEMBAYARAN']."'") or die('statement error');
						}
						if ($_POST['status'] == "BARU") {
							$res = oci_execute($statement) or die('execute error');
							$res1 = oci_execute($statement1) or die('execute error');
							if($res&&$res1){
								header('location:index.php?modul=getdata-pembayaran');
								exit(0);
							}else{
								echo "<h2>Hapus data gagal !!</h2>";
							}							
						}else{
						$res = oci_execute($statement) or die('execute error');
						if($res){
							header('location:index.php?modul=getdata-pembayaran');
							exit(0);
						}else{
							echo "<h2>Hapus data gagal !!</h2>";
						}
					}
					}else{
						echo "<h2>No Action Here !</h2>";
					}					
					break;	
				case 'delete-pembayaran':
					$statement = oci_parse($koneksi,"delete from struk_pembayaran where id_pembayaran = '".$_GET['id_pembayaran']."'") or die('statement error');
					$res = oci_execute($statement) or die('execute error');
					if($res){
						header('location:indexPembayaran.php?modul=getdata');
					}else{
						echo "<h2>Hapus data gagal !!</h2>";
					}
					break;	
				case 'save-obat':
					if($_POST){
						print_r($_POST['status']);
						if($_POST['status'] == "BARU"){
							$statement = oci_parse($koneksi,"insert into obat (id_obat, nama_obat, tahun_produksi, masa_berlaku ) values ('".$_POST['ID_OBAT']."','".$_POST['NAMA_OBAT']."',TO_DATE('".$_POST['TAHUN_PRODUKSI']."', 'yyyy/mm/dd hh24:mi:ss'),TO_DATE('".$_POST['MASA_BERLAKU']."', 'yyyy/mm/dd hh24:mi:ss'))") or die('statement error');
						}else{
							$statement = oci_parse($koneksi,"update obat set id_obat = '".$_POST['ID_OBAT']."',nama_obat='".$_POST['NAMA_OBAT']."',tahun_produksi='".$_POST['TAHUN_PRODUKSI']."',masa_berlaku='".$_POST['MASA_BERLAKU']."' where id_obat = '".$_POST['ID_OBAT']."'") or die('statement error');
						}
						$res = oci_execute($statement) or die('execute error');
						if($res){
							header('location:index.php?modul=getdata-pembayaran');
							exit(0);
						}else{
							echo "<h2>Hapus data gagal !!</h2>";
						}
					}else{
						echo "<h2>No Action Here !</h2>";
					}					
					break;					
				case 'delete':
					$statement = oci_parse($koneksi,"delete from pasien where id_pasien = '".$_GET['id_pasien']."'") or die('statement error');
					$res = oci_execute($statement) or die('execute error');
					if($res){
						header('location:index.php?modul=getdata');
					}else{
						echo "<h2>Hapus data gagal !!</h2>";
					}
					break;
				
				default :
				$statement = oci_parse($koneksi,"select id_pasien,nama_pasien,jenis_kelamin,umur, alamat, keluhan from pasien") or die('statement error');
					oci_execute($statement) or die('execute error');
					include 'tables.php';
					break;
			}
		}else{
			$statement = oci_parse($koneksi,"select id_pasien,nama_pasien,jenis_kelamin,umur, alamat, keluhan from pasien") or die('statement error');
			oci_execute($statement) or die('execute error');
			include 'data_pasien.php';
		}
		if(isset($statement)){
			oci_free_statement($statement);
		}
		oci_close($koneksi);
	}else{
		echo "koneksi gagal !<br />";
	}
?>