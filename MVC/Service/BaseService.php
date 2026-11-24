<?php
declare(strict_types=1);

abstract class BaseService
{
    protected function validateRequiredText(string $value, string $fieldName): string
    {
        $value = trim($value);

        if ($value === '') {
            throw new InvalidArgumentException("Le champ {$fieldName} est obligatoire.");
        }

        return $value;
    }
}