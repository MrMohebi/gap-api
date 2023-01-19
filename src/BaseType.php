<?php

namespace GapBot;


abstract class BaseType
{
    /**
     * Array of required data params for type
     *
     * @var array
     */
    protected static array $requiredParams = [];

    /**
     * Map of input data
     *
     * @var array
     */
    protected static array $map = [];

    /**
     * Validate input data
     *
     * @param array $data
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public static function validate(array $data): bool
    {
        if (count(array_intersect_key(array_flip(static::$requiredParams), $data)) === count(static::$requiredParams)) {
            return true;
        }

        throw new InvalidArgumentException();
    }

    public function map($data): void
    {
        foreach (static::$map as $key => $item) {
            if (isset($data[$key]) && (!is_array($data[$key]) || (is_array($data[$key]) && !empty($data[$key])))) {
                $method = 'set' . self::toCamelCase($key);
                if ($item === true) {
                    $this->$method($data[$key]);
                } else {
                    $this->$method($item::fromResponse($data[$key]));
                }
            }
        }
    }

    protected static function toCamelCase($str): array|string
    {
        return str_replace(" ", "", ucwords(str_replace("_", " ", $str)));
    }

    public function toJson($inner = false): bool|array|string
    {
        $output = [];

        foreach (static::$map as $key => $item) {
            $property = lcfirst(self::toCamelCase($key));
            if (!is_null($this->$property)) {
                if (is_array($this->$property)) {
                    $output[$key] = array_map(
                        function ($v) {
                            return is_object($v) ? $v->toJson(true) : $v;
                        },
                        $this->$property
                    );
                } else {
                    $output[$key] = $item === true ? $this->$property : $this->$property->toJson(true);
                }
            }
        }

        return $inner === false ? json_encode($output) : $output;
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function fromResponse($data): bool|static
    {
        if ($data === true) {
            return true;
        }

        self::validate($data);
        $instance = new static();
        $instance->map($data);

        return $instance;
    }
}