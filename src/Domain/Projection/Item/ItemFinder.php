<?php

declare(strict_types=1);

namespace Milosa\TaskList\Domain\Projection\Item;

use Doctrine\DBAL\Connection;


class ItemFinder
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->connection->setFetchMode(\PDO::FETCH_OBJ);
    }

    public function findAll(): array
    {
        return $this->connection->fetchAll(sprintf('SELECT * FROM %s', 'read_item'));
    }

}