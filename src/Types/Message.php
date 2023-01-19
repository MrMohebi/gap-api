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
    static protected array $requiredParams = ['message_id', 'date', 'type'];

    /**
     * {@inheritdoc}
     *
     * @var array
     */
    static protected array $map = [
        'message_id' => true,
        'date' => true,
        'forward_sender_name' => true,
        'text' => true,
    ];
}