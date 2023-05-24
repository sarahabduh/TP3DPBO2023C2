<?php

class Album extends DB
{
    function getAlbum()
    {
        $query = "SELECT * FROM album";
        return $this->execute($query);
    }

    function getAlbumById($id)
    {
        $query = "SELECT * FROM album WHERE album_id=$id";
        return $this->execute($query);
    }

    function addAlbum($data)
    {
        $name = $data['name'];
        $query = "INSERT INTO album VALUES('', '$name')";
        return $this->executeAffected($query);
    }

    function updateAlbum($id, $data)
    {
        $name = $data['name'];
        $query = "UPDATE album SET album_name='$name' WHERE album_id=$id";
        return $this->executeAffected($query);
    }

    function deleteAlbum($id)
    {
        $query = "DELETE FROM album WHERE album_id=$id";
        return $this->executeAffected($query);
    }

    function searchAlbum($keyword)
    {
        $query = "SELECT * FROM album WHERE album_name LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function filterAsc(){
        $query = "SELECT * FROM album ORDER BY album_name ASC";
        return $this->execute($query);
    }

    function filterDesc(){
        $query = "SELECT * FROM album ORDER BY album_name DESC";
        return $this->execute($query);
    }
}
