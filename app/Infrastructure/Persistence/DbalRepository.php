<?php
namespace App\Infrastructure\Persistence;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Ecotone\Messaging\Conversion\MediaType;
use Ecotone\Messaging\Gateway\Converter\Serializer;
use Ecotone\Modelling\Annotation\Repository;
use Ecotone\Modelling\StandardRepository;

/**
 * @Repository()
 */
class DbalRepository implements StandardRepository
{
    const TABLE_NAME = "aggregate";
    const CONNECTION_DSN = 'sqlite:////tmp/db.sqlite';

    private Connection $connection; // 1

    private Serializer $serializer; // 2

    public function __construct(Serializer $serializer)
    {
        $this->connection = DriverManager::getConnection(array('url' => self::CONNECTION_DSN));
        $this->serializer = $serializer;
    }

    public function canHandle(string $aggregateClassName): bool
    {
        return true;
    }

    public function findBy(string $aggregateClassName, array $identifiers): ?object
    {
        $this->createSharedTableIfNeeded(); // 3

        $record = $this->connection->executeQuery(<<<SQL
    SELECT * FROM aggregate WHERE id = :id AND class = :class
SQL, ["id" => $this->getFirstId($identifiers), "class" => $aggregateClassName])->fetch(\PDO::FETCH_ASSOC);

        if (!$record) {
            return null;
        }

        // 4
        return $this->serializer->convertToPHP($record["data"], MediaType::APPLICATION_JSON, $aggregateClassName);
    }

    public function save(array $identifiers, object $aggregate, array $metadata, ?int $expectedVersion): void
    {
        $this->createSharedTableIfNeeded();

        $aggregateClass = get_class($aggregate);
        // 5
        $data = $this->serializer->convertFromPHP($aggregate, MediaType::APPLICATION_JSON);

        if ($this->findBy($aggregateClass, $identifiers)) {
            $this->connection->update(self::TABLE_NAME,
                ["data" => $data],
                ["id" => $this->getFirstId($identifiers), "class" => $aggregateClass]
            );

            return;
        }

        $this->connection->insert(self::TABLE_NAME, [
            "id" => $this->getFirstId($identifiers),
            "class" => $aggregateClass,
            "data" => $data
        ]);
    }

    private function createSharedTableIfNeeded(): void
    {
        $hasTable = $this->connection->executeQuery(<<<SQL
SELECT name FROM sqlite_master WHERE name=:tableName
SQL, ["tableName" => self::TABLE_NAME])->fetchColumn();

        if (!$hasTable) {
            $this->connection->executeUpdate(<<<SQL
CREATE TABLE aggregate (
    id VARCHAR(255),
    class VARCHAR(255),
    data TEXT,
    PRIMARY KEY (id, class)
)
SQL
            );
        }
    }

    /**
     * @param array $identifiers
     * @return mixed
     */
    private function getFirstId(array $identifiers)
    {
        return array_values($identifiers)[0];
    }
}