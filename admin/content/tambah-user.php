<?php
//query untuk edit 
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE id ='$id'");
    $rowEdit = mysqli_fetch_assoc($query);
    $title = "Edit User";
} else {
    $title = "Tambah User";
}
//query untuk menghapus user
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");
    if ($delete) {
        header("location:?page=user&tambah=berhasil");
    }
}

if (isset($_POST['simpan'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = ($_POST['password']) ? $_POST['password'] : $rowEdit['password'];

    //ini query update
    if ($id) {

        $update = mysqli_query($koneksi, "UPDATE users SET name='$name', email='$email', password='$password' WHERE id='$id'");
        if ($update) {
            header("location:?page=user&ubah=berhasil");
        }
    } else {

        $insert = mysqli_query($koneksi, "INSERT INTO users (name, email, password)
        VALUES('$name', '$email', '$password')");
        if ($insert) {
            header("location:?page=user&tambah=berhasil");
        }
    }
}

?>


<div class="pagetitle">
    <h1><?php echo $title ?></h1>

</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $title ?></h5>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan nama anda"
                                required value="<?php echo ($id) ? $rowEdit['name'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Masukkan email anda"
                                required value="<?php echo ($id) ? $rowEdit['email'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="">Password</label>
                            <input type="text" class="form-control" name="password" placeholder="Masukkan password anda"
                                <?php echo (!$id) ? 'required' : '' ?>>
                            <small>)*Isi Password jika ingin mengubah password</small>

                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                            <a href="?page=user" class="text-muted">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>

</section>