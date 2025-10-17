<?php

declare(strict_types=1);

namespace SortedLinkedList;

/**
 * Node class for SortedLinkedList.
 * Represents a single element in a linked list.
 * Holds a value mixed any type not inforced to (int|string) and a reference to the next node.
 */
class Node
{
    public mixed $value;
    public ?Node $next = null;

    public function __construct(mixed $value)
    {
        $this->value = $value;
    }
}
