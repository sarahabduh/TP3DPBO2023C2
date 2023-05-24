<?php

class Artist extends DB
{
    function getArtist()
    {
        $query = "SELECT * FROM artist";
        return $this->execute($query);
    }

    function getArtistById($id)
    {
        $query = "SELECT * FROM artist WHERE artist_id=$id";
        return $this->execute($query);
    }

    function addArtist($data)
    {
        $name = $data['name'];
        $query = "INSERT INTO artist VALUES('', '$name')";
        return $this->executeAffected($query);
    }

    function updateArtist($id, $data)
    {
        $name = $data['name'];
        $query = "UPDATE artist SET artist_name='$name' WHERE artist_id=$id";
        return $this->executeAffected($query);
    }

    function deleteArtist($id)
    {
        $query = "DELETE FROM artist WHERE artist_id=$id";
        return $this->executeAffected($query);
    }

    function searchArtist($keyword)
    {
        $query = "SELECT * FROM artist WHERE artist_name LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function filterAsc(){
        $query = "SELECT * FROM artist ORDER BY artist_name ASC";
        return $this->execute($query);
    }

    function filterDesc(){
        $query = "SELECT * FROM artist ORDER BY artist_name DESC";
        return $this->execute($query);
    }
}
