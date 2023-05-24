<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Album.php');
include('classes/Artist.php');
include('classes/Song.php');
include('classes/Template.php');

$song = new Song($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$album = new Album($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$artist = new Artist($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

$song->open();
$album->open();
$artist->open();

$album_options = "";
$artist_options = "";
$selected = "";
$existing_img = "";
$view = new Template('templates/skinform.html');

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($song->addData($_POST, $_FILES) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'index.php';
            </script>";
        }
    }

    $album->getAlbum();
    while ($alb = $album->getResult()) {
        $album_options .= "<option value=" . $alb['album_id'] . ">" . $alb['album_name'] . "</option>";
    }

    $artist->getArtist();
    while ($art = $artist->getResult()) {
        $artist_options .= "<option value=" . $art['artist_id'] . ">" . $art['artist_name'] . "</option>";
    }

    $btn = 'Submit';
    $action = 'Add';
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $song->getSongById($id);
        $row = $song->getResult();
        $picToUpdate = $row['song_pic'];
        $nameToUpdate = $row['song_name'];
        $yearToUpdate = $row['song_year'];
        $albumToUpdate = $row['album_id'];
        $artistToUpdate = $row['artist_id'];

        if (isset($_POST['submit'])) {
            if ($song->updateData($id, $_POST, $_FILES, $picToUpdate) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'index.php';
            </script>";
            }
        }

        $btn = 'Save';
        $action = 'Edit';

        $view->replace('DATA_VAL_NAME', $nameToUpdate);
        $view->replace('DATA_VAL_YEAR', $yearToUpdate);
        
        $album->getAlbum();
        while ($alb = $album->getResult()) {
            $selected = ($albumToUpdate == $alb['album_id'] ? 'selected' : '');
            $album_options .= "<option value=" . $alb['album_id'] . " " . $selected .">" . $alb['album_name'] . "</option>";
        }

        $artist->getArtist();
        while ($art = $artist->getResult()) {
            $selected = ($artistToUpdate == $art['artist_id'] ? 'selected' : '');
            $artist_options .= "<option value=" . $art['artist_id'] . " " . $selected .">" . $art['artist_name'] . "</option>";
        }

        $existing_img .= '<div class="col mb-3">
            <img src="assets/images/' . $picToUpdate . '" width="124" height="124">
        </div>';
    }
}

$song->close();
$album->close();
$artist->close();

$view->replace('DATA_ACTION', $action);
$view->replace('DATA_ARTIST_OPTIONS', $artist_options);
$view->replace('DATA_EXISTING_IMG', $existing_img);
$view->replace('DATA_ALBUM_OPTIONS', $album_options);
$view->replace('DATA_BUTTON', $btn);
$view->write();
