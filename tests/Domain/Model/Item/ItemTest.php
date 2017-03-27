<?php
declare(strict_types=1);

namespace Milosa\TaskList\Tests\Domain\Model\Item;

use Milosa\TaskList\Domain\Model\Item\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testCanCreateItem()
    {
        $this->assertItem('title', 'description');
        $this->assertItem('other_title', 'other_description');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreatingItemWithEmptyTitleThrowsException()
    {
        Item::create('', 'test');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreatingItemWithEmptyDescriptionThrowsException()
    {
        Item::create('test', '');
    }

    private function assertItem(string $title, string $description): void
    {
        $item = Item::create($title, $description);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertSame($title, $item->title());
        $this->assertSame($description, $item->description());
    }
}
