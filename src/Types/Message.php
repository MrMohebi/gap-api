<?php

namespace GapBot\Types;

use GapBot\BaseType;
use GapBot\TypeInterface;

class Message extends BaseType implements TypeInterface
{
    /**
     * {@inheritdoc}
     *
     * @var array
     */
    static protected array $requiredParams = ['chat_id', 'type'];

    /**
     * {@inheritdoc}
     *
     * @var array
     */
    static protected array $map = [
        'chat_id' => true,
        'type' => true,
        'text' => true,
    ];
}