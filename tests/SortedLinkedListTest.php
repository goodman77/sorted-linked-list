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
        $list->add(10);
        $list->add(3);
        $list->add(1);
        $this->assertSame([1, 3, 10], $list->toArray());
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
        $list->add('PHP');
        $list->add('Javascript');
        $list->add('MySql');

        $this->assertSame(['Javascript', 'MySql', 'PHP'], $list->toArray());
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

    public function testClear(): void
    {
        $list = new SortedLinkedList();
        $list->add(10);
        $list->add(20);
        $list->add(5);

        $list->clear();

        $this->assertSame([], $list->toArray());
    }

    public function testToString(): void
    {
        $list = new SortedLinkedList();
        $list->add(9);
        $list->add(4);
        $list->add(3);

        $this->assertSame("3 -> 4 -> 9", $list->__toString());
    }

    public function testExists(): void
    {
        $list = new SortedLinkedList();
        $list->add(7);
        $list->add(6);
        $list->add(1);

        $list->delete(7);

        $this->assertFalse($list->exists(7));
        $this->assertTrue($list->exists(6));
    }

    public function testFirstAndLast(): void
    {
        $list = new SortedLinkedList();
        $list->add(15);
        $list->add(4);
        $list->add(20);

        $this->assertSame(4, $list->first());
        $this->assertSame(20, $list->last());
    }
}
