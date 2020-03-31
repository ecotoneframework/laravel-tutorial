<?php
namespace App\Infrastructure\Persistence;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Ecotone\Messaging\Annotation\Interceptor\Around;
use Ecotone\Messaging\Annotation\Interceptor\MethodInterceptor;
use Ecotone\Messaging\Handler\Processor\MethodInvoker\MethodInvocation;

/**
 * @MethodInterceptor()
 */
class TransactionInterceptor
{
    private Connection $connection;

    public function __construct()
    {
        $this->connection = DriverManager::getConnection(array('url' => DbalRepository::CONNECTION_DSN));
    }

    /**
     * @Around(pointcut="Ecotone\Modelling\CommandBus")
     */
    public function transactional(MethodInvocation $methodInvocation)
    {
        echo "Start transaction\n";
        $this->connection->beginTransaction();
        try {
            $result = $methodInvocation->proceed();

            $this->connection->commit();
            echo "Commit transaction\n";
        }catch (\Throwable $exception) {
            $this->connection->rollBack();
            echo "Rollback transaction\n";

            throw $exception;
        }

        return $result;
    }
}