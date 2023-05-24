<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Album.php');
include('classes/Template.php');

$album = new Album($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$album->open();
$album->getAlbum();

if (isset($_POST['btn-search'])) {
    // metode mencari data album berdasarkan keyword
    $album->searchAlbum($_POST['search']);
}
else if(isset($_POST['btn-asc'])){
    // metode mengurutkan data secara ascending
    $album->filterAsc();    
}
else if(isset($_POST['btn-desc'])){
    // metode mengurutkan data secara descending
    $album->filterDesc();    
}
else if(isset($_POST['btn-default'])){
    // metode menampilkan data tanpa filter
    $album->getAlbum();    
}

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if (!empty($_POST['name'])) {
            if ($album->addAlbum($_POST) > 0) {
                echo "<script>
                    alert('Data berhasil ditambah!');
                    document.location.href = 'album.php';
                </script>";
            } else {
                echo "<script>
                    alert('Data gagal ditambah!');
                    document.location.href = 'album.php';
                </script>";
            }
        } else {
            echo "<script>
                alert('Data tidak boleh kosong!');
                document.location.href = 'album.php';
            </script>";
        }
    }

    $btn = 'Submit';
    $title = 'Add';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Album';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Album Name</th>
<th scope="row">Action</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'album';

while ($alb = $album->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $alb['album_name'] . '</td>
    <td style="font-size: 22px;">
        <a href="album.php?id=' . $alb['album_id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="album.php?hapus=' . $alb['album_id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if (!empty($_POST['name'])) {
                if ($album->updateAlbum($id, $_POST) > 0) {
                    echo "<script>
                    alert('Data berhasil diubah!');
                    document.location.href = 'album.php';
                </script>";
                } else {
                    echo "<script>
                    alert('Data gagal diubah!');
                    document.location.href = 'album.php';
                </script>";
                }
            }
            else {
                echo "<script>
                    alert('Data tidak boleh kosong!');
                    document.location.href = 'album.php';
                </script>";
            }
        }

        $album->getAlbumById($id);
        $row = $album->getResult();

        $dataUpdate = $row['album_name'];
        $btn = 'Save';
        $title = 'Edit';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($album->deleteAlbum($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'album.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'album.php';
            </script>";
        }
    }
}

$album->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();
