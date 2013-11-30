<?php

class AlbumTable
{
    public function saveAlbum(Album $album)
    {
        $data = array(
            'artist' => $album->artist,
            'title' => $album->title
        );
        
        $id = (int) $album->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->getLastInsertValue(); // Add this line
        } else {
            if ($this->getAlbum($id)) {
                $this->tableGateway->update($data, array(
                    'id' => $id
                ));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
        
        return $id; // Add Return
    }
}