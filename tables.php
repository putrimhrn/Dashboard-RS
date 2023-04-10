<html>
	<head>
		<title>Tabel Data</title>
	</head>
	<body>
		<table border="1" style="border-collapse:collapse; width:40%">
			<tr bgcolor="gray">
				<th>NAMA PASIEN</th>
				<th>JENIS KELAMIN</th>
				<th>UMUR</th>
				<th>ALAMAT</th>
				<th>ACTION</th>
			</tr>
			<?php while($row = oci_fetch_array($statement,OCI_BOTH)){ ?>
			<tr>
				<td><?php echo $row['NAMA_PASIEN']; ?></td>
				<td><?php echo $row['JENIS_KELAMIN']; ?></td>
				<td><?php echo $row['UMUR']; ?></td>
				<td><?php echo $row['ALAMAT']; ?></td>				
				<td align="center">
					<a href="index.php?modul=edit&nim=<?php echo $row['id_pasien']; ?>">Edit</a> 
					|| 
					<a href="index.php?modul=delete&nim=<?php echo $row['id_pasien']; ?>" onclick="return confirm('yakin hapus data ini ?')">Hapus</a>
				</td>
			</tr>
			<?php } ?>
		</table>
		<div style="margin-top:10px;"><a href="index.php?modul=add">Tambah Data</a></div>
	</body>
</html>