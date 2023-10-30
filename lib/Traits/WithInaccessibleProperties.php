<?php

namespace PHPNomad\Tests\Traits;

use ReflectionException;
use ReflectionProperty;

trait WithInaccessibleProperties
{
    /**
     * Gets a property that is otherwise inaccessible.
     *
     * @param object $object
     * @param string $property
     * @return ReflectionProperty
     * @throws ReflectionException
     */
    protected function getProtectedProperty(object $object, string $property): ReflectionProperty
    {
        $reflection = new \ReflectionClass($object);

        return $reflection->getProperty($property);
    }

    /**
     * Sets the value of an inaccessible property.
     *
     * @param object $object
     * @param string $property
     * @param mixed $value
     * @return void
     * @throws ReflectionException
     */
    protected function setProtectedProperty(object $object, string $property, mixed $value): void
    {
        $reflection_property = self::getProtectedProperty($object, $property);
        $reflection_property->setAccessible(true);

        $reflection_property->setValue($object, $value);
    }

    /**
     * Gets a property that is otherwise inaccessible.
     *
     * @param object $object
     * @param string $property
     * @return mixed
     * @throws ReflectionException
     */
    protected function getProtectedPropertyValue(object $object, string $property)
    {
        return $this->getProtectedProperty($object,$property)->getValue($object);
    }
}
