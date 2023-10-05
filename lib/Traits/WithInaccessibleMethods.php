<?php

namespace Phoenix\Tests\Traits;

use ReflectionClass;
use ReflectionException;

trait WithInaccessibleMethods
{
    /**
     * @throws ReflectionException
     */
    protected function callInaccessibleMethod(object $object, string $method_name, mixed ...$args): mixed
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($method_name);
        /** @noinspection PhpExpressionResultUnusedInspection */
        $method->setAccessible(true);

        return $method->invokeArgs($object, $args);
    }
}
