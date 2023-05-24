<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Album.php');
include('classes/Artist.php');
include('classes/Song.php');
include('classes/Template.php');

// buat instance song
$listSong = new Song($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listSong->open();
// tampilkan data song
$listSong->getSongJoin();

if (isset($_POST['btn-search'])) {
    // metode mencari data song berdasarkan keyword
    $listSong->searchSong($_POST['search']);
}
else if(isset($_POST['btn-asc'])){
    // metode mengurutkan data secara ascending
    $listSong->filterAsc();    
}
else if(isset($_POST['btn-desc'])){
    // metode mengurutkan data secara descending
    $listSong->filterDesc();    
}
else if(isset($_POST['btn-default'])){
    // metode menampilkan data tanpa filter
    $listSong->getSongJoin();    
}

$data = null;

// ambil data song
// gabungkan dgn tag html
// untuk di passing ke skin/template
while ($row = $listSong->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 song-thumbnail">
        <a href="detail.php?id=' . $row['song_id'] . '">
            <div class="row justify-content-center">
                <img src="assets/images/' . $row['song_pic'] . '" class="card-img-top" alt="' . $row['song_id'] . '">
            </div>
            <div class="card-body">
                <p class="card-text song-name my-0">' . $row['song_name'] . '</p>
                <p class="card-text album-name">' . $row['album_name'] . '</p>
                <p class="card-text artist-name my-0">' . $row['artist_name'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}
// tutup koneksi
$listSong->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_SONG', $data);
$home->write();
