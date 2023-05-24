<?php

class Song extends DB
{
    function getSongJoin()
    {
        $query = "SELECT * FROM song JOIN album ON song.album_id=album.album_id JOIN artist ON song.artist_id=artist.artist_id ORDER BY song.song_id";

        return $this->execute($query);
    }

    function getSong()
    {
        $query = "SELECT * FROM song";
        return $this->execute($query);
    }

    function getSongById($id)
    {
        $query = "SELECT * FROM song JOIN album ON song.album_id=album.album_id JOIN artist ON song.artist_id=artist.artist_id WHERE song_id=$id";
        return $this->execute($query);
    }

    function searchSong($keyword)
    {
        $query = "SELECT * FROM song JOIN album ON song.album_id=album.album_id JOIN artist ON song.artist_id=artist.artist_id WHERE song_name LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function filterAsc(){
        $query = "SELECT * FROM song JOIN album ON song.album_id=album.album_id JOIN artist ON song.artist_id=artist.artist_id ORDER BY song_name ASC";
        return $this->execute($query);
    }

    function filterDesc(){
        $query = "SELECT * FROM song JOIN album ON song.album_id=album.album_id JOIN artist ON song.artist_id=artist.artist_id ORDER BY song_name DESC";
        return $this->execute($query);
    }  

    function addData($data, $file)
    {  
        $temp = $file['song_pic']['tmp_name'];
        $filename = $file['song_pic']['name'];

        $folder = "assets/images/".$filename;
        move_uploaded_file($temp, $folder);
        
        $name = $data['name'];
        $year = $data['year'];
        $album = $data['album'];
        $artist = $data['artist'];

        $query = "INSERT INTO song VALUES('', '$filename', '$name', '$year', '$artist', '$album')";
        return $this->executeAffected($query);
    }

    function updateData($id, $data, $file, $image)
    {
        $temp = $file['song_pic']['tmp_name'];
        $filename = $file['song_pic']['name'];

        if(empty($filename)){
            $filename = $image;
        }

        $folder = "assets/images/".$filename;
        move_uploaded_file($temp, $folder);
        
        $name = $data['name'];
        $year = $data['year'];
        $album = $data['album'];
        $artist = $data['artist'];
        
        $query = "UPDATE song SET song_pic='$filename', song_name='$name', song_year='$year', artist_id='$artist', album_id='$album' WHERE song_id=$id";
        return $this->executeAffected($query);
    }

    function deleteData($id)
    {
        $query = "DELETE FROM song WHERE song_id=$id";
        return $this->executeAffected($query);
    }
}
