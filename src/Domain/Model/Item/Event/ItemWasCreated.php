<?php
declare(strict_types=1);

namespace Milosa\TaskList\Domain\Model\Item\Event;


use Prooph\EventSourcing\AggregateChanged;

class ItemWasCreated extends AggregateChanged
{
    /**
     * @var string
     */
    private $itemId;
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    public static function withData(string $title, string $description): ItemWasCreated
    {
        $event = self::occur('1', [
            'title' => $title,
            'description' => $description
        ]);

        $event->itemId = '1';
        $event->title = $title;
        $event->description = $description;

        return $event;
    }

    /**
     * @return string
     */
    public function itemId(): string
    {
        return $this->itemId;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }
}