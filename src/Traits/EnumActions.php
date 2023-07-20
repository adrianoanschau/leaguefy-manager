<?php

namespace Leaguefy\LeaguefyManager\Traits;

use BackedEnum;

trait EnumActions
{
    /** Return the enum's value when it's $invoked(). */
    public function __invoke()
    {
        return $this instanceof BackedEnum ? $this->value : $this->name;
    }

    /** Return the enum's value or name when it's called ::STATICALLY(). */
    public static function __callStatic($name, $args)
    {
        $cases = static::cases();

        foreach ($cases as $case) {
            if ($case->name === $name) {
                return $case instanceof BackedEnum ? $case->value : $case->name;
            }
        }

        throw new Exceptions\UndefinedCaseError(static::class, $name);
    }

    /** Get an array of case names. */
    public static function names(): array
    {
        return array_column(static::cases(), 'name');
    }

    /** Get an array of case values. */
    public static function values(): array
    {
        $cases = static::cases();

        return isset($cases[0]) && $cases[0] instanceof BackedEnum
            ? array_column($cases, 'value')
            : array_column($cases, 'name');
    }

    /** Get an associative array of [case name => case value]. */
    public static function options(): array
    {
        $cases = static::cases();

        return isset($cases[0]) && $cases[0] instanceof BackedEnum
            ? array_column($cases, 'value', 'name')
            : array_column($cases, 'name');
    }
}
