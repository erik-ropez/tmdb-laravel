<?php
/**
 * @package php-tmdb\laravel
 * @author Mark Redeman <markredeman@gmail.com>
 * @copyright (c) 2014, Mark Redeman
 */
namespace Tmdb\Laravel\Adapters;

use Symfony\Component\EventDispatcher\EventDispatcherInterface as SymfonyDispatcher;
use Illuminate\Events\Dispatcher as LaravelDispatcher;
use Symfony\Component\EventDispatcher\Event;

/**
 * This adapter provides a Laravel integration for applications
 * using the Symfony EventDispatcherInterface
 * It passes any request on to a Symfony Dispatcher and only
 * uses the Laravel Dispatcher only when dispatching events
 */
class EventDispatcherLaravel4 extends EventDispatcherAdapter
{
    /**
     * Forward all methods to the Laravel Events Dispatcher
     * @param LaravelDispatcher $laravelDispatcher
     * @param SymfonyDispatcher $symfonyDispatcher
     */
    public function __construct(LaravelDispatcher $laravelDispatcher, SymfonyDispatcher $symfonyDispatcher)
    {
        $this->laravelDispatcher = $laravelDispatcher;
        $this->symfonyDispatcher = $symfonyDispatcher;
    }

    public function getListeners($eventName = null)
    {
        return $this->symfonyDispatcher->getListeners($eventName);
    }

    public function getListenerPriority($eventName, $listener)
    {
        return $this->symfonyDispatcher->getListenerPriority($eventName, $listener);
    }

    public function hasListeners($eventName = null)
    {
        return ($this->symfonyDispatcher->hasListeners($eventName) ||
            $this->laravelDispatcher->hasListeners($eventName));
    }

    public function dispatch($eventName, Event $event = null)
    {
        $this->laravelDispatcher->dispatch($eventName, $event);
        return $this->symfonyDispatcher->dispatch($eventName, $event);
    }
}
