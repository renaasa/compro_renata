<?php
//query untuk edit 
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $query = mysqli_query($koneksi, "SELECT * FROM about WHERE id ='$id'");
    $rowEdit = mysqli_fetch_assoc($query);
    $title = "Edit Tentang Blog";
} else {
    $title = "Tambah Tentang Blog";
}

//query untuk menghapus about
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $queryGambar = mysqli_query($koneksi, "SELECT id, image FROM about WHERE id='$id'");
    $rowGambar = mysqli_fetch_assoc($queryGambar);
    $image_name = $rowGambar['image'];
    unlink("uploads/" . $image_name);
    $delete = mysqli_query($koneksi, "DELETE FROM about WHERE id='$id'");
    if ($delete) {
        header("location:?page=about&tambah=berhasil");
    }
}

if (isset($_POST['simpan'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $is_active = $_POST['is_active'];
    $writer = $_SESSION['name'];

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

        $update = mysqli_query($koneksi, "UPDATE about SET title='$title', content='$content', is_active='$is_active', image='$image_name' WHERE id='$id'");
        if ($update) {
            header("location:?page=about&ubah=berhasil");
        }
    } else {

        $insert = mysqli_query($koneksi, "INSERT INTO about (title, content, is_active, image)
        VALUES('$title', '$content', '$is_active', '$image_name')");
        if ($insert) {
            header("location:?page=about&tambah=berhasil");
        }
    }
}

$queryCategories = mysqli_query($koneksi, "SELECT * FROM categories ORDER BY id DESC");
$rowCategories   = mysqli_fetch_all($queryCategories, MYSQLI_ASSOC);

?>


<div class="pagetitle">
    <h1><?php echo $title ?></h1>

</div><!-- End Page Title -->

<section class="section">
    <form action="" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-8">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $title ?></h5>
                        <div class="mb-3">
                            <label for="" class="form-label">Gambar</label>
                            <input type="file" name="image" required>
                            <small class="text-muted">)* Size : 1920 * 1080</small>
                        </div>
                        <div class="mb-3">
                            <label for="">Kategori</label>
                            <select name="id_category" id="" class="form-control">
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($rowCategories as $rowCategory): ?>
                                    <option value="<?php echo $rowCategory['id'] ?>"><?php echo $rowCategory['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Judul</label>
                            <input type="text" class="form-control" name="title" placeholder="Masukkan judul blog"
                                required value="<?php echo ($id) ? $rowEdit['title'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Isi</label>
                            <textarea name="content" id="summernote" class="form-control"><?php echo ($id) ? $rowEdit['content'] : '' ?></textarea>
                        </div>
                        
                    </div>
                </div>
                
            </div>
            <div class="col-sm-4">
                
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $title ?></h5>
                            <div class="mb-3">
                                <label for="" class="form-label">Status</label>
                                <select name="is_active" id="" class="form-control">
                                    <option <?php echo ($id) ? $rowEdit['is_active'] == 1 ? 'selected' : '' : '' ?> value="1">Publish</option>
                                    <option <?php echo ($id) ? $rowEdit['is_active'] == 0 ? 'selected' : '' : '' ?> value="0">Draft</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                                <a href="?page=about" class="text-muted">Kembali</a>
                            </div>
                    </div>
                </div>
                
            </div>
        </div>
        
    </form>
</section>