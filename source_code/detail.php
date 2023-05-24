<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Album.php');
include('classes/Artist.php');
include('classes/Song.php');
include('classes/Template.php');

$song = new Song($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$song->open();

$data = nulL;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $song->getSongById($id);
        $row = $song->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail ' . $row['song_name'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['song_pic'] . '" class="img-thumbnail" alt="' . $row['song_pic'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Name</td>
                                    <td>:</td>
                                    <td>' . $row['song_name'] . '</td>
                                </tr>
                                <tr>
                                    <td>Year Released</td>
                                    <td>:</td>
                                    <td>' . $row['song_year'] . '</td>
                                </tr>
                                <tr>
                                    <td>Album</td>
                                    <td>:</td>
                                    <td>' . $row['album_name'] . '</td>
                                </tr>
                                <tr>
                                    <td>Artist</td>
                                    <td>:</td>
                                    <td>' . $row['artist_name'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="form.php?id=' . $row['song_id'] . '"><button type="button" class="btn btn-success text-white">Edit Data</button></a>
                <a href="detail.php?hapus=' . $row['song_id'] .'"><button type="button" class="btn btn-danger">Delete Data</button></a>
            </div>';
    }
}


if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    if($id > 0){
        if($song->deleteData($id) > 0){
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'index.php';
            </script>";
        } else{
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'index.php';
            </script>";
        }
    }
}

$song->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_SONG_DETAIL', $data);
$detail->write();
