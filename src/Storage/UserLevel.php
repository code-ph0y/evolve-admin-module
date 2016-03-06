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
     * Make an entity
     *
     * @param  array $user_level_data
     * @return mixed
     */
    public function makeEntity(array $user_level_data)
    {
        return new UserLevelEntity($user_level_data);
    }

    /**
     * Get a user level entity by its id
     *
     * @param $user_level_id
     * @return mixed
     * @throws \Exception
     */
    public function getById($user_level_id)
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
     * Delete a user level by id
     *
     * @param  integer $id
     * @return mixed
     */
    public function deleteById($id)
    {
        return $this->ds->delete($this->meta_data['table'], array($this->meta_data['primary'] => $id));
    }

    /**
     * Create a user level record
     *
     * @param  array $user_level
     * @return integer
     */
    public function create(array $user_level)
    {
        return $this->ds->insert($this->meta_data['table'], $user_level);
    }


    /**
     * Update a user level record
     *
     * @param  int $id
     * @param  array $user_level
     * @return integer
     */
    public function update($id, array $user_level)
    {
        return $this->ds->update(
            $this->meta_data['table'],
            $user_level,
            array($this->meta_data['primary'] => $id)
        );
    }

    /**
     * Convert array to entities
     *
     * @param  array $rows
     * @return mixed
     */
    public function rowsToEntities(array $rows)
    {
        $ent = array();
        foreach ($rows as $r) {
            $ent[] = new UserLevelEntity($r);
        }
        return $ent;
    }
}
