<?php
//JOIN
$query = mysqli_query($koneksi, "SELECT categories.name, portofolios. * FROM portofolios JOIN categories ON categories.id = portofolios.id_category ORDER BY portofolios.id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

function changeIsActive($isActive)
{
    switch ($isActive) {
        case '1':
            $title = "<span class='badge bg-primary'>Publish</span>";
            break;

        default:
            $title = "<span class='badge bg-warning'>Draft</span>";
            break;
    }

    return $title;
}

?>


<div class="pagetitle">
    <h1>Data Portofolio</h1>

</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Portofolio</h5>
                    <div class="mb-3" align="right">
                        <a href="?page=tambah-portofolio" class="btn btn-primary">Tambah</a>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Kategori</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php foreach ($rows as $key => $row): ?>
                                <tr>
                                    <td><?php echo $key += 1 ?></td>
                                    <td><img width="100" src="uploads/<?php echo $row['image'] ?>" alt=""></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo changeIsActive($row['is_active']) ?></td>
                                    <td>
                                        <a href="?page=tambah-portofolio&edit=<?php echo $row['id'] ?>"
                                            class="btn btn-sm btn-success">Edit</a>
                                        <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"
                                            href="?page=tambah-portofolio&delete=<?php echo $row['id'] ?>"
                                            class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>


                    </table>
                </div>
            </div>

        </div>

    </div>

</section>