<?php
namespace Concept\EventDispatcher\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Concept\EventDispatcher\EventBusInterface;
use Concept\EventDispatcher\Listener\ListenerFactoryInterface;
use Concept\Http\App\Config\AppConfigInterface;
use Psr\Http\Server\MiddlewareInterface;

class EventBusMiddleware implements MiddlewareInterface
{

    public function __construct(
        private AppConfigInterface $appConfig, 
        private EventBusInterface $eventBus, 
        private ListenerFactoryInterface $listenerFactory,
        
    )
    {}

    /**
     * {@inheritDoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->aggregateListeners();

        /**
        * Very first event: init event. may be used to bootstrap other listeners
        */
        $this->getEventBus()->dispatch(\Concept\EventDispatcher\Event\Init\EventInit::class);

        return $handler->handle($request);
    }

    /**
     * Get the event bus instance
     * 
     * @return EventBusInterface
     */
    protected function getEventBus(): EventBusInterface
    {
        return $this->eventBus;
    }

    /**
     * Get the listener factory
     * 
     * @return ListenerFactoryInterface
     */
    protected function getListenerFactory(): ListenerFactoryInterface
    {
        return $this->listenerFactory;
    }

    
    /**
     * Aggregates and registers event listeners defined in the application configuration.
     *
     * This method traverses the event bus configuration tree and, for each configured
     * event and listener, prepares a lazy-loading listener closure that:
     * - Defers instantiation of the actual listener until the event is dispatched.
     * - Injects per-listener configuration if the created listener implements
     *   \Concept\Config\Contract\ConfigurableInterface (via setConfig()).
     * - Invokes the instantiated listener with the dispatched event instance.
     *
     * Configuration layout (dot-notation):
     * - Base node: EventBusInterface::CONFIG_NODE . '.' . EventBusInterface::CONFIG_NODE_LISTENERS
     * - Listener node: "<base>.<eventServiceId>.<listenerServiceId>"
     * - Supported per-listener options:
     *   - priority (int, optional; default: 0) — registration priority (higher runs earlier)
     *
     * Processing steps:
     * 1) Read the listeners map from configuration.
     * 2) For each eventServiceId/listenerServiceId pair:
     *    - Build the listener's configuration node path.
     *    - Fetch the listener-specific configuration (including priority).
     *    - Create a lazy listener closure that:
     *        a) Uses getListenerFactory()->create($listenerServiceId) to obtain the listener.
     *        b) Optionally injects configuration if supported.
     *        c) Calls the listener with the event.
     *    - Register the closure on the EventBus with the computed priority.
     *
     * Notes:
     * - The actual listener object is created only when its event is dispatched.
     * - Re-invoking this method without safeguards may register duplicates if the
     *   underlying EventBus does not prevent multiple identical registrations.
     *
     * Use \Concept\Singularity\Contract\Lifecycle\SharedInterface for listeners implementations to ensure single invocation.
     *
     * @return void
     *
     * @see EventBusInterface
     * @see \Concept\Config\Contract\ConfigurableInterface
     *
     * @throws \Throwable If configuration access, listener creation, configuration injection,
     *                    or event bus registration fails in the underlying implementations.
     */
    protected function aggregateListeners(): void
    {
        $listeners = $this->appConfig->get(
            EventBusInterface::CONFIG_NODE . '.' . EventBusInterface::CONFIG_NODE_LISTENERS
        ) ?? [];

        foreach ($listeners as $eventServiceId => $listeners) {
            foreach ($listeners as $listenerServiceId => $listenerConfig) {
                /**
                 * Build the configuration node path for the listener
                 */
                $configNode = sprintf(
                    '%s.%s.%s.%s',
                    EventBusInterface::CONFIG_NODE,
                    EventBusInterface::CONFIG_NODE_LISTENERS,
                    $eventServiceId,
                    $listenerServiceId
                );

                /**
                 * Grab the listener configuration
                 */
                $listenerConfig = $this->appConfig->node($configNode);

                $priority = (int) ($listenerConfig->get('priority') ?? 0);

                $listenerFactory = $this->getListenerFactory();

                /**
                 * Lazy load the listener
                 */
                $listener = function($event) use ($listenerServiceId, $listenerFactory, $listenerConfig,) {
                    $listener = $listenerFactory->create($listenerServiceId);

                    if ($listener instanceof \Concept\Config\Contract\ConfigurableInterface) {
                        $listener->setConfig($listenerConfig);
                    }

                    return $listener($event);
                };

                /**
                 * Register the listener with the event bus (with priority)
                 */
                $this->getEventBus()->register($eventServiceId, $listener, $priority);
            }
        }
    }

}