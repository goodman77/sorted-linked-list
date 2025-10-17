<?php

declare(strict_types=1);

namespace SortedLinkedList\tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use SortedLinkedList\SortedLinkedList;

class SortedLinkedListTest extends TestCase
{
    public function testAdd()
    {
        $list = new SortedLinkedList();
        $list->add(7);
        $list->add(5);
        $list->add(1);
        $this->assertSame([1, 5, 7], $list->toArray());
    }

    public function testDelete()
    {
        $list = new SortedLinkedList();
        $list->add(5);
        $list->add(3);
        $list->delete(5);
        $this->assertSame([3], $list->toArray());
    }

    public function testAddStringsInOrder(): void
    {
        $list = new SortedLinkedList();
        $list->add('php');
        $list->add('is');
        $list->add('cool');

        $this->assertSame(['cool', 'is', 'php'], $list->toArray());
    }

    public function testTypeSafety()
    {
        $this->expectException(InvalidArgumentException::class);
        $list = new SortedLinkedList();
        $list->add(1);
        $list->add("testing");
    }

    public function testDeleteNonExistentValue(): void
    {
        $list = new SortedLinkedList();
        $list->add(1);
        $result = $list->delete(44);
        $this->assertFalse($result);
        $this->assertSame([1], $list->toArray());
    }

    public function testCountAndIteration(): void
    {
        $list = new SortedLinkedList();
        $list->add(3);
        $list->add(2);
        $this->assertSame(2, $list->count());

        $values = [];
        foreach ($list as $val) {
            $values[] = $val;
        }
        $this->assertSame([2, 3], $values);
    }
}
