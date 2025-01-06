<?php

namespace App\DBAL;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class EnumType extends Type
{
    private string $name = ''; // Default value to prevent empty access
    private static array $enumValues = [];

    public static function registerEnumType(string $name, array $values): void
    {
        if (!Type::hasType($name)) {
            Type::addType($name, self::class);
        }

        self::$enumValues[$name] = $values;

        // Initialize $name for the type
        $type = Type::getType($name);
        if ($type instanceof self) {
            $type->name = $name; // Set the name
        }
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        if (empty($this->name)) {
            throw new \LogicException('Enum type name must be initialized before usage.');
        }

        $values = self::$enumValues[$this->name] ?? [];
        if (empty($values)) {
            throw new \InvalidArgumentException("No ENUM values registered for type '{$this->name}'.");
        }

        return "ENUM('" . implode("','", $values) . "')";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?string
    {
        if (empty($this->name)) {
            throw new \LogicException('Enum type name must be initialized before usage.');
        }

        $allowedValues = self::$enumValues[$this->name] ?? [];
        if ($value === null || in_array($value, $allowedValues, true)) {
            return $value;
        }

        throw new \InvalidArgumentException("Invalid ENUM value '$value' for type '{$this->name}'.");
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (empty($this->name)) {
            throw new \LogicException('Enum type name must be initialized before usage.');
        }

        $allowedValues = self::$enumValues[$this->name] ?? [];
        if ($value === null || in_array($value, $allowedValues, true)) {
            return $value;
        }

        throw new \InvalidArgumentException("Invalid ENUM value '$value' for type '{$this->name}'.");
    }

    public function getName(): string
    {
        if (empty($this->name)) {
            throw new \LogicException('Enum type name must be initialized before usage.');
        }

        return $this->name;
    }
}
