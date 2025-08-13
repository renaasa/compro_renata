<?php
//query untuk edit 
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $query = mysqli_query($koneksi, "SELECT * FROM clients WHERE id ='$id'");
    $rowEdit = mysqli_fetch_assoc($query);
    $title = "Edit Tentang Clients";
} else {
    $title = "Tambah Tentang Clients";
}

//query untuk menghapus clients
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $queryGambar = mysqli_query($koneksi, "SELECT id, image FROM clients WHERE id='$id'");
    $rowGambar = mysqli_fetch_assoc($queryGambar);
    $image_name = $rowGambar['image'];
    unlink("uploads/" . $image_name);
    $delete = mysqli_query($koneksi, "DELETE FROM clients WHERE id='$id'");
    if ($delete) {
        header("location:?page=clients&tambah=berhasil");
    }
}

if (isset($_POST['simpan'])) {
    $name = $_POST['name'];
    $is_active = $_POST['is_active'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $type_mime = mime_content_type($tmp_name);

        $ext_allowed = ["image/png", "image/jpg", "image/jpeg"];
        if (in_array($type_mime, $ext_allowed)) {
            $path = "uploads/";
            if (!is_dir($path)) mkdir($path);

            $image_name = time() . "-" . basename($image);
            $target_files = $path . $image_name;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_files)) {
                //jika gambarnya sudah ada maka gambar sebelumnya akan diganti oleh gambar baru
                if (!empty($row['image'])) {
                    unlink($path . $row['image']);
                }
            }
        } else {
            echo "file can't be uploaded";
            die;
        }
    }

    //ini query update
    if ($id) {

        $update = mysqli_query($koneksi, "UPDATE clients SET name='$name', is_active='$is_active', image='$image_name' WHERE id='$id'");
        if ($update) {
            header("location:?page=clients&ubah=berhasil");
        }
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO clients (name, is_active, image)
        VALUES('$name', '$is_active', '$image_name')");
        if ($insert) {
            header("location:?page=clients&tambah=berhasil");
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
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="">Gambar</label>
                            <input type="file"
                                name="image" required>
                            <small class="text-muted">)* Size : 1920 * 1080</small>
                        </div>
                        <div class="mb-3">
                            <label for="">Judul</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan judul client"
                                required value="<?php echo ($id) ? $rowEdit['name'] : '' ?>">
                        </div>
                        <!-- <div class="mb-3">
                            <label for="">Isi</label>
                            <textarea name="content" id="summernote" class="form-control"><?php echo ($id) ? $rowEdit['content'] : '' ?></textarea>
                        </div> -->
                        <div class="mb-3">
                            <label for="">Is Active</label>
                            <select name="is_active" id="" class="form-control">
                                <option <?php echo ($id) ? $rowEdit['is_active'] == 1 ? 'selected' : '' : '' ?> value="1">Publish</option>
                                <option <?php echo ($id) ? $rowEdit['is_active'] == 0 ? 'selected' : '' : '' ?> value="0">Draft</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                            <a href="?page=clients" class="text-muted">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>

</section>