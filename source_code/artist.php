<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Artist.php');
include('classes/Template.php');

$artist = new Artist($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$artist->open();
$artist->getArtist();

if (isset($_POST['btn-search'])) {
    // metode mencari data artist berdasarkan keyword
    $artist->searchArtist($_POST['search']);
}
else if(isset($_POST['btn-asc'])){
    // metode mengurutkan data secara ascending
    $artist->filterAsc();    
}
else if(isset($_POST['btn-desc'])){
    // metode mengurutkan data secara descending
    $artist->filterDesc();    
}
else if(isset($_POST['btn-default'])){
    // metode menampilkan data tanpa filter
    $artist->getArtist();    
}

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if (!empty($_POST['name'])) {
            if ($artist->addArtist($_POST) > 0) {
                echo "<script>
                    alert('Data berhasil ditambah!');
                    document.location.href = 'artist.php';
                </script>";
            } else {
                echo "<script>
                    alert('Data gagal ditambah!');
                    document.location.href = 'artist.php';
                </script>";
            }
        } else {
            echo "<script>
                alert('Data tidak boleh kosong!');
                document.location.href = 'artist.php';
            </script>";
        }
    }

    $btn = 'Submit';
    $title = 'Add';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Artist';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Artist Name</th>
<th scope="row">Action</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'artist';

while ($art = $artist->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $art['artist_name'] . '</td>
    <td style="font-size: 22px;">
        <a href="artist.php?id=' . $art['artist_id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="artist.php?hapus=' . $art['artist_id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if (!empty($_POST['name'])) {
                if ($artist->updateArtist($id, $_POST) > 0) {
                    echo "<script>
                    alert('Data berhasil diubah!');
                    document.location.href = 'artist.php';
                </script>";
                } else {
                    echo "<script>
                    alert('Data gagal diubah!');
                    document.location.href = 'artist.php';
                </script>";
                }
            }
            else {
                echo "<script>
                    alert('Data tidak boleh kosong!');
                    document.location.href = 'artist.php';
                </script>";
            }
        }

        $artist->getArtistById($id);
        $row = $artist->getResult();

        $dataUpdate = $row['artist_name'];
        $btn = 'Save';
        $title = 'Edit';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($artist->deleteArtist($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'artist.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'artist.php';
            </script>";
        }
    }
}

$artist->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();