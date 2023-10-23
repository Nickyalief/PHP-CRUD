<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "crud_db";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi ke database");
}

$judul_buku = "";
$penulis = "";
$penerbit = "";
$nomor_inventaris = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "DELETE FROM siswa WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error = "Gagal melakukan delete data";
    }
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM siswa WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $judul_buku = $r1['judul_buku'];
    $penulis = $r1['penulis'];
    $penerbit = $r1['penerbit'];
    $nomor_inventaris = $r1['nomor_inventaris'];

    if (empty($penulis)) {
        $error = "Data tidak ditemukan";
    }
}

// if (isset($_POST['simpan'])) {
//     $penulis = $_POST['penulis'];
//     $judul_buku = $_POST['judul_buku'];
//     $penerbit = $_POST['penerbit'];
//     $nomor_inventaris = $_POST['nomor_inventaris'];

//     if ($penulis && $judul_buku && $penerbit && $nomor_inventaris) {
//         if ($op == 'edit') {
//             $sql1 = "UPDATE siswa SET penulis = '$penulis', judul_buku = '$judul_buku', penerbit = '$penerbit', nomor_inventaris = '$nomor_inventaris' WHERE id = '$id'";
//             $q1 = mysqli_query($koneksi, $sql1);
//             if ($q1) {
//                 $sukses = "Data berhasil diupdate";
//             } else {
//                 $error = "Data gagal diupdate";
//             }
//         } else {
//             $sql1 = "INSERT INTO siswa (penulis, judul_buku, penerbit, nomor_inventaris) VALUES ('$penulis', '$judul_buku', '$penerbit', '$nomor_inventaris')";
//             $q1 = mysqli_query($koneksi, $sql1);
//             if ($q1) {
//                 $sukses = "Berhasil memasukkan data baru";
//             } else {
//                 $error = "Gagal memasukkan data";
//             }
//         }
//     } else {
//         $error = "Silakan masukkan semua data";
//     }
// }

if (isset($_POST['simpan'])) { //untuk create atau update
    $penulis = $_POST['penulis'];
    $judul_buku = $_POST['judul_buku'];
    $penerbit = $_POST['penerbit'];
    $nomor_inventaris = $_POST['nomor_inventaris'];

    // Cek apakah data sudah ada di database
    $sql_cek = "SELECT * FROM siswa WHERE penulis = '$penulis' AND judul_buku = '$judul_buku' AND penerbit = '$penerbit' AND nomor_inventaris = '$nomor_inventaris'";
    $q_cek = mysqli_query($koneksi, $sql_cek);
    $data_cek = mysqli_fetch_array($q_cek);

    if (!$data_cek) { // Data belum ada, maka bisa disimpan
        if ($penulis && $judul_buku && $penerbit && $nomor_inventaris) {
            if ($op == 'edit') { //untuk update
                $sql1 = "UPDATE siswa SET penulis = '$penulis', judul_buku = '$judul_buku', penerbit = '$penerbit', nomor_inventaris = '$nomor_inventaris' WHERE id = '$id'";
                $q1 = mysqli_query($koneksi, $sql1);
                if ($q1) {
                    $sukses = "Data berhasil diupdate";
                } else {
                    $error = "Data gagal diupdate";
                }
            } else { //untuk insert
                $sql1 = "INSERT INTO siswa (penulis, judul_buku, penerbit, nomor_inventaris) VALUES ('$penulis', '$judul_buku', '$penerbit', '$nomor_inventaris')";
                $q1 = mysqli_query($koneksi, $sql1);
                if ($q1) {
                    $sukses = "Berhasil memasukkan data baru";
                } else {
                    $error = "Gagal memasukkan data";
                }
            }
        } else {
            $error = "Silakan masukkan semua data";
        }
    } else {
        $error = "Data sudah ada di database";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php if ($error) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <?php if ($sukses) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses; ?>
                    </div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="judul_buku" class="col-sm-2 col-form-label">Judul Buku</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="judul_buku" name="judul_buku" value="<?php echo $judul_buku; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="penulis" name="penulis" value="<?php echo $penulis; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php echo $penerbit; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nomor_inventaris" class="col-sm-2 col-form-label">Nomor Inventaris</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nomor_inventaris" name="nomor_inventaris" value="<?php echo $nomor_inventaris; ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Buku
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Judul Buku</th>
                            <th scope="col">Penulis</th>
                            <th scope="col">Penerbit</th>
                            <th scope="col">Nomor Inventaris</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2 = "SELECT * FROM siswa ORDER BY id DESC";
                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id = $r2['id'];
                            $penulis = $r2['penulis'];
                            $judul_buku = $r2['judul_buku'];
                            $penerbit = $r2['penerbit'];
                            $nomor_inventaris = $r2['nomor_inventaris'];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++; ?></th>
                                <td scope="row"><?php echo $judul_buku; ?></td>
                                <td scope="row"><?php echo $penulis; ?></td>
                                <td scope="row"><?php echo $penerbit; ?></td>
                                <td scope="row"><?php echo $nomor_inventaris; ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id; ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id; ?>" onclick="return confirm('Yakin dekk mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
