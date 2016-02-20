<?php
namespace AdminModule\Storage;

use AdminModule\Storage\Base as BaseStorage;
use AdminModule\Entity\UserLevel as UserLevelEntity;

class UserLevel extends BaseStorage
{
    protected $meta_data = array(
        'conn'      => 'main',
        'table'     => 'user_level',
        'primary'   => 'id',
        'fetchMode' => \PDO::FETCH_ASSOC
    );

    /**
     * Get a blank user enitity
     *
     * @return mixed
     */
    public function getBlankEntity()
    {
        return new UserLevelEntity();
    }

    /**
     * Get a user level entity by its id
     *
     * @param $user_level_id
     * @return mixed
     * @throws \Exception
     */
    public function getByID($user_level_id)
    {
        $row = $this->ds->createQueryBuilder()
            ->select('ul.*')
            ->from($this->meta_data['table'], 'ul')
            ->andWhere('ul.id = :user_level_id')->setParameter(':user_level_id', $user_level_id)
            ->execute()
            ->fetch($this->meta_data['fetchMode']);

        if ($row === false) {
            throw new \Exception('Unable to obtain user level row for id: ' . $user_id);
        }

        return new UserLevelEntity($row);
    }

    public function getAll()
    {
        $rows = $this->ds->createQueryBuilder()
            ->select('ul.*')
            ->from($this->meta_data['table'], 'ul')
            ->execute()
            ->fetchAll($this->meta_data['fetchMode']);

        $entities = $this->rowsToEntities($rows);

        return $entities;
    }

    /**
     * Delete a user by their ID
     *
     * @param  integer $userID
     * @return mixed
     */
    public function deleteByID($id)
    {
        return $this->delete(array($this->meta_data['primary'] => $id));
    }

    /**
     * Create a user record
     *
     * @param  UserEntity $user
     * @return integer
     */
    public function create(UserEntity $user)
    {
        return $this->ds->insert($this->meta_data['table'], $user->toInsertArray());
    }

    public function rowsToEntities($rows)
    {
        $ent = array();
        foreach ($rows as $r) {
            $ent[] = new UserLevelEntity($r);
        }
        return $ent;
    }
}
