<?php

declare(strict_types=1);

namespace SortedLinkedList;

use Countable;
use IteratorAggregate;
use Traversable;
use InvalidArgumentException;

/**
 * SortedLinkedList
 *
 * A single linked list that automatically keeps its elements sorted once they are inserted.
 * Can store either integers or strings, but not both in the same list.
 *
 * Implements Countable and IteratorAggregate.
 */
class SortedLinkedList implements IteratorAggregate, Countable
{
    /** @var Node|null */
    private ?Node $head = null;

    /** @var string|null */
    private ?string $type = null;

    /** @var int number of element in the linkedList */
    private int $count = 0;


    /**
     * Add a value into the list in sorted order.
     *
     * @param mixed int|string $value Value to insert
     * @throws InvalidArgumentException If value type is invalid or does not match int or string
     */
    public function add(mixed $value): void
    {
        $this->validateType($value); // valdate the type

        $newNode = new Node($value); // create a new node

        // Add at head if list is empty or value is smaller than current head
        if (null === $this->head || $this->compare($value, $this->head->value) < 0) {
            $newNode->next = $this->head;
            $this->head = $newNode;
        } else {
            // Otherwise, find the correct addition point
            $current = $this->head;
            while (null !== $current->next && $this->compare($current->next->value, $value) <= 0) {
                $current = $current->next;
            }
            // Add new node in its sorted position
            $newNode->next = $current->next;
            $current->next = $newNode;
        }

        $this->count++; // increment count since added a new value
    }

    /**
     * Compare two values for sorting.
     *
     * @param int|string $newValue
     * @param int|string $existingValue
     * @return int -1 if $newValue < $existingValue, 0 if equal, 1 if $newValue > $existingValue
     */
    private function compare(mixed $newValue, mixed $existingValue): int
    {
        return $newValue <=> $existingValue; // spaceship operator
    }

    /**
     * Count the number of elements in the list.
     *
     * @return int Total number of elements
     */
    public function count(): int
    {
        return $this->count;
    }

    /**
     * Validate the type of a value before insertion.
     *
     * @param mixed $value Value to validate
     * @throws InvalidArgumentException If value is not int|string or mixes types
     */
    private function validateType(mixed $value): void
    {
        $valueType = gettype($value); // get the type

        // Allow only integer or string
        if (!in_array($valueType, ['integer', 'string'], true)) {
            throw new InvalidArgumentException("Only int or string values are allowed.");
        }

        // Set list type on first insertion
        if (null === $this->type) {
            $this->type = $valueType;
        } elseif ($this->type !== $valueType) {
            throw new InvalidArgumentException("Cannot mix {$this->type} with {$valueType}.");
        }
    }

    /**
     * Delete a value from the list.
     *
     * @param mixed $value Value to remove
     * @return bool true if deleted, false if not found
     */
    public function delete(mixed $value): bool
    {
        // empty list
        if (null === $this->head) return false;

        // If head contains the value
        if ($this->head->value === $value) {
            $this->head = $this->head->next;
            $this->count--;
            return true;
        }

        // Traverse the list to find the value
        $current = $this->head;
        while (null !== $current->next && $current->next->value !== $value) {
            $current = $current->next;
        }

        // delete the node if found
        if (null !== $current->next) {
            $current->next = $current->next->next;
            $this->count--;
            return true;
        }

        return false; // not found
    }

    /**
     * Convert the linked list into a plain PHP array.
     * useful to see values in the linked list
     * @return array Array of all node values in sorted order
     */
    public function toArray(): array
    {
        $toArray = [];
        $current = $this->head;
        while (null !== $current) {
            $toArray[] = $current->value;
            $current = $current->next;
        }
        return $toArray;
    }

    /**
     * Convert the linked list into a plain stringv with arrows
     *
     * @return array string with arrow seperation
     */
    public function __toString(): string
    {
        return implode(' -> ', $this->toArray());
    }

    /**
     * Get an iterator for the list to allow foreach iteration.
     *
     * @return Traversable Yields each node value in sorted order
     */
    public function getIterator(): Traversable
    {
        $current = $this->head;
        while (null !== $current) {
            yield $current->value;
            $current = $current->next;
        }
    }

    /**
     * clear the linked list 
     */
    public function clear()
    {
        $this->head = null;
        $this->type = null;
        $this->count = 0;
    }

    /**
     * Check if a certain value is foundin the linked list
     * @param mixed $value value to be found
     * 
     * @return bool true if found, false if not
     */
    public function exists(mixed $value): bool
    {
        $current = $this->head;
        while (null !== $current) {
            if ($current->value === $value) {
                return true;
            }
            $current = $current->next;
        }

        return false;
    }

    /**
     * Find the first element of the linked list
     * 
     * @return mixed value of the head otherwise null
     */
    public function first(): mixed
    {
        return null !== $this->head ? $this->head->value : null;
    }

    /**
     * Find the last element of the linked list
     * 
     * @return mixed value of the head otherwise null
     */
    public function last(): mixed
    {
        $current = $this->head;

        if (null === $current) return null;

        while (null !== $current->next) {
            $current = $current->next;
        }

        return $current->value;
    }
}
