<?php
/**
 * @package php-tmdb\laravel
 * @author Mark Redeman <markredeman@gmail.com>
 * @copyright (c) 2014, Mark Redeman
 */
namespace Tmdb\Laravel\Adapters;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as SymfonyDispatcher;

/**
 * This adapter provides a Laravel integration for applications
 * using the Symfony EventDispatcherInterface
 * It passes any request on to a Symfony Dispatcher and only
 * uses the Laravel Dispatcher when dispatching events
 */
abstract class EventDispatcherAdapter implements SymfonyDispatcher
{

    /**
     * The Laravel Events Dispatcher
     * @var \Illuminate\Contracts\Events\Dispatcher or \Illuminate\Events\Dispatcher
     */
    protected $laravelDispatcher;

    /**
     * The Symfony Event Dispatcher
     * @var  \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $symfonyDispatcher;

    /**
     * Adds an event listener that listens on the specified events.
     *
     * @param string   $eventName The event to listen on
     * @param callable $listener  The listener
     * @param int      $priority  The higher this value, the earlier an event
     *                            listener will be triggered in the chain (defaults to 0)
     *
     * @api
     */
    public function addListener($eventName, $listener, $priority = 0)
    {
        $this->symfonyDispatcher->addListener($eventName, $listener, $priority);
    }

    /**
     * Adds an event subscriber.
     *
     * The subscriber is asked for all the events he is
     * interested in and added as a listener for these events.
     *
     * @param EventSubscriberInterface $subscriber The subscriber.
     *
     * @api
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->symfonyDispatcher->addSubscriber($subscriber);
    }

    /**
     * Removes an event listener from the specified events.
     *
     * @param string   $eventName The event to remove a listener from
     * @param callable $listenerToBeRemoved The listener to remove
     */
    public function removeListener($eventName, $listenerToBeRemoved)
    {
        $this->symfonyDispatcher->removeListener($eventName, $listenerToBeRemoved);
    }

    /**
     * Removes an event subscriber.
     *
     * @param EventSubscriberInterface $subscriber The subscriber
     */
    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->symfonyDispatcher->removeSubscriber($subscriber);
    }
}
