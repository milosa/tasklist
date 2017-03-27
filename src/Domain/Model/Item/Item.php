<?php
declare(strict_types=1);

namespace Milosa\TaskList\Domain\Model\Item;

use Milosa\TaskList\Domain\Model\Item\Event\ItemWasCreated;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

class Item extends AggregateRoot
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    public static function create(string $title, string $description): Item
    {
        if(empty($title))
        {
            throw new \InvalidArgumentException("Title cannot be empty");
        }

        if(empty($description))
        {
            throw new \InvalidArgumentException("Description cannot be empty");
        }

        $self = new self();
        $self->recordThat(ItemWasCreated::withData($title, $description));

        return $self;
    }

    public function title() : string
    {
        return $this->title;
    }

    public function description() : string
    {
        return $this->description;
    }

    protected function whenItemWasCreated(ItemWasCreated $event): void
    {
        $this->createEventPublished = true;
        $this->title = $event->title();
        $this->description = $event->description();
    }

    /**
     * @return string representation of the unique identifier of the aggregate root
     */
    protected function aggregateId(): string
    {
        // TODO: Implement aggregateId() method.
    }

    /**
     * Apply given event
     */
    protected function apply(AggregateChanged $e): void
    {
        $handler = $this->determineEventHandlerMethodFor($e);

        if (! method_exists($this, $handler)) {
            throw new \RuntimeException(sprintf(
                'Missing event handler method %s for aggregate root %s',
                $handler,
                get_class($this)
            ));
        }

        $this->{$handler}($e);
    }

    protected function determineEventHandlerMethodFor(AggregateChanged $e): string
    {
        return 'when' . implode(array_slice(explode('\\', get_class($e)), -1));
    }
}
