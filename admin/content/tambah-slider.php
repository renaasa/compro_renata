<?php
//query untuk edit 
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $query = mysqli_query($koneksi, "SELECT * FROM sliders WHERE id ='$id'");
    $rowEdit = mysqli_fetch_assoc($query);
    $title = "Edit Slider";
} else {
    $title = "Tambah slider";
}

//query untuk menghapus slider
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $queryGambar = mysqli_query($koneksi, "SELECT id, image FROM sliders WHERE id='$id'");
    $rowGambar = mysqli_fetch_assoc($queryGambar);
    $image_name = $rowGambar['image'];
    unlink("uploads/" . $image_name);
    $delete = mysqli_query($koneksi, "DELETE FROM sliders WHERE id='$id'");
    if ($delete) {
        header("location:?page=slider&tambah=berhasil");
    }
}

if (isset($_POST['simpan'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

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

        $update = mysqli_query($koneksi, "UPDATE sliders SET title='$title', description='$description', image='$image_name' WHERE id='$id'");
        if ($update) {
            header("location:?page=slider&ubah=berhasil");
        }
    } else {

        $insert = mysqli_query($koneksi, "INSERT INTO sliders (title, description, image)
        VALUES('$title', '$description', '$image_name')");
        if ($insert) {
            header("location:?page=slider&tambah=berhasil");
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
                            <small class="text-muted">)* Size : 1920 * 1088</small>
                        </div>
                        <div class="mb-3">
                            <label for="">Judul</label>
                            <input type="text" class="form-control" name="title" placeholder="Masukkan judul slider"
                                required value="<?php echo ($id) ? $rowEdit['title'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="">Isi</label>
                            <textarea name="description" id="" class="form-control"><?php echo ($id) ? $rowEdit['description'] : '' ?></textarea>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                            <a href="?page=slider" class="text-muted">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>

</section>