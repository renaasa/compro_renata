<?php
//jika data setting sudah ada maka update data tersebut
//selain itu kalo blm ada maka insert data
$querySetting = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1"); //LIMIT 1 adalah data yang dimaksudkan hanya 1
$row = mysqli_fetch_assoc($querySetting);

if (isset($_POST['simpan'])) {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $facebook = $_POST['facebook'];
    $instagram = $_POST['instagram'];
    $twitter = $_POST['twitter'];
    $linkedin = $_POST['linkedin'];

    //jika gambar terupload
    if(!empty($_FILES['logo']['name'])){
        $logo = $_FILES['logo']['name'];
        $path = "uploads/";
        if(!is_dir($path)) mkdir($path);

        $logo_name = time() . "-" . basename($logo);
        $target_files = $path . $logo_name;
        if(move_uploaded_file($_FILES['logo']['tmp_name'], $target_files)){
            //jika gambarnya sudah ada maka gambar sebelumnya akan diganti oleh gambar baru
            if(!empty($row['logo'])){
                unlink($path . $row['logo']);
            }
        }
    }


    if ($row) {
        //update 
        $id_setting = $row['id'];

        $update = mysqli_query($koneksi, "UPDATE settings SET 
        email='$email',
        phone='$phone',
        logo ='$logo_name',
        address='$address', instagram='$instagram', facebook='$facebook', twitter= '$twitter',
        linkedin='$linkedin' WHERE id='$id_setting'");
        if ($update) {
            header("location:?page=setting&ubah=berhasil");
    } else {
        //insert
        $insert = mysqli_query($koneksi, "INSERT INTO settings (email, phone, logo, address, instagram, facebook, twitter, linkedin) 
        VALUES ('$email', '$phone', '$logo_name', '$address', '$instagram', '$facebook', '$twitter','$linkedin')");
        if ($insert) {
            header("location:?page=setting&tambah=berhasil");
        }
    }
}}
$querySetting = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1");

?>


<div class="pagetitle">
    <h1>Setting</h1>

</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Setting</h5>
                    <!-- Format ENCTYPE wajib digunakan kalau di form ada input file (<input type="file">). -->
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Email</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="email" name="email" id="" class="form-control"
                                    value="<?php echo isset($row['email']) ? $row['email'] : '' ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">No Telp</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="number" name="phone" id="" class="form-control"
                                    value="<?php echo isset($row['phone']) ? $row['phone'] : '' ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Address</label>
                            </div>
                            <div class="col-sm-6">
                                <textarea name="address" id=""
                                    class="form-control"><?php echo isset($row['address']) ? $row['address'] : '' ?></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Logo</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="file" name="logo" id="" class="form-control">
                                <img class="mt-2" src="uploads/<?php echo isset($row['logo']) ? $row['logo'] : '' ?> " 
                                alt="Logo" width="100">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Facebook</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="url" name="facebook" id="" class="form-control"
                                    value="<?php echo isset($row['facebook']) ? $row['facebook'] : '' ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Twitter</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="url" name="twitter" id="" class="form-control"
                                    value="<?php echo isset($row['twitter']) ? $row['twitter'] : '' ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Instagram</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="url" name="instagram" id="" class="form-control"
                                    value="<?php echo isset($row['instagram']) ? $row['instagram'] : '' ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">LinkedIn</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="url" name="linkedin" id="" class="form-control"
                                    value="<?php echo isset($row['linkedin']) ? $row['linkedin'] : '' ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-12">
                                <button class="btn btn-primary" name="simpan">Simpan</button>
                            </div>
                    </form>
                </div>
            </div>

        </div>


    </div>

</section>