<?php
/**
 * @package php-tmdb\laravel
 * @author Mark Redeman <markredeman@gmail.com>
 * @copyright (c) 2014, Mark Redeman
 */
namespace Tmdb\Laravel\Adapters;

use Symfony\Component\EventDispatcher\EventDispatcherInterface as SymfonyDispatcher;
use Illuminate\Contracts\Events\Dispatcher as LaravelDispatcher;

/**
 * This adapter provides a Laravel integration for applications
 * using the Symfony EventDispatcherInterface
 * It passes any request on to a Symfony Dispatcher and only
 * uses the Laravel Dispatcher only when dispatching events
 */
class EventDispatcherLaravel9 extends EventDispatcherAdapter
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

    public function getListeners(?string $eventName = null): array
    {
        return $this->symfonyDispatcher->getListeners($eventName);
    }

    public function getListenerPriority(string $eventName, callable $listener): ?int
    {
        return $this->symfonyDispatcher->getListenerPriority($eventName, $listener);
    }

    public function hasListeners(?string $eventName = null): bool
    {
        return ($this->symfonyDispatcher->hasListeners($eventName) ||
            $this->laravelDispatcher->hasListeners($eventName));
    }

    public function dispatch(object $event, ?string $eventName = null): object
    {
        $this->laravelDispatcher->dispatch($eventName, $event);
        return $this->symfonyDispatcher->dispatch($event, $eventName);
    }
}
