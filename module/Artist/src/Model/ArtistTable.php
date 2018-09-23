<?php
namespace Artist\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class ArtistTable
{
    private $tableGateway;


    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getArtist($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveArtist(Artist $artist)
    {
        $data = [
            'name' => $artist->name,
            'bio'  => $artist->bio,
        ];

        $id = (int) $artist->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getArtist($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update artist with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteArtist($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
