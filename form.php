<html>
	<head>
		<title>Tabel Data</title>
	</head>
	<body>
		<table border="0" style="width:25%">
		<form method="POST" action="index.php?modul=save">
			<tr>
				<td><input type="hidden" name="ID_PASIEN" value="<?php echo $ID_PASIEN; ?>" style="width:30%;" <?php if($status=="LAMA"){ echo "readonly"; } ?>></td>
			</tr>
			<tr>
				<td>NAMA PASIEN : </td>
				<td><input type="text" name="NAMA_PASIEN" value="<?php echo $NAMA_PASIEN; ?>" style="width:80%;"></td>
			</tr>
			<tr>
				<td>JENIS KELAMIN :</td>
				<td><input type="text" name="JENIS_KELAMIN" value="<?php echo $JENIS_KELAMIN; ?>" style="width:100%;"></td>
			</tr>
			<tr>
				<td>UMUR : </td>
				<td><input type="text" name="UMUR" value="<?php echo $UMUR; ?>" style="width:30%;" <?php if($status=="LAMA"){ echo "readonly"; } ?>></td>
			</tr>
			<tr>
				<td>ALAMAT : </td>
				<td><input type="text" name="ALAMAT" value="<?php echo $ALAMAT; ?>" style="width:80%;"></td>
			</tr>
			<tr>
				<td>KELUHAN :</td>
				<td><input type="text" name="KELUHAN" value="<?php echo $KELUHAN; ?>" style="width:100%;"></td>
			</tr>			
			<tr>
				<td><input type="hidden" name="status" value="<?php echo $status; ?>"></td>
				<td><input type="submit" value="Simpan" name="btnSimpan"></td>
			</tr>
			<tr>
				<td></td>
				<td><a href="index.php?modul=getdata">Kembali ke halaman index</a></td>
			</tr>
		</form>
		</table>
	</body>
</html>