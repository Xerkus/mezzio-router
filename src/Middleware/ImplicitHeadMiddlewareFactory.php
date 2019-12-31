<?php

/**
 * @see       https://github.com/mezzio/mezzio-router for the canonical source repository
 * @copyright https://github.com/mezzio/mezzio-router/blob/master/COPYRIGHT.md
 * @license   https://github.com/mezzio/mezzio-router/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Mezzio\Router\Middleware;

use Mezzio\Router\Exception\MissingDependencyException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Create and return an ImplicitHeadMiddleware instance.
 *
 * This factory depends on two other services:
 *
 * - Psr\Http\Message\ResponseInterface, which should resolve to a callable
 *   that will produce an empty Psr\Http\Message\ResponseInterface instance.
 * - Psr\Http\Message\StreamInterface, which should resolve to a callable
 *   that will produce an empty Psr\Http\Message\StreamInterface instance.
 */
class ImplicitHeadMiddlewareFactory
{
    /**
     * @throws MissingDependencyException if either the Psr\Http\Message\ResponseInterface
     *     or Psr\Http\Message\StreamInterface services are missing.
     */
    public function __invoke(ContainerInterface $container) : ImplicitHeadMiddleware
    {
        if (! $container->has(ResponseInterface::class)) {
            throw MissingDependencyException::dependencyForService(
                ResponseInterface::class,
                ImplicitHeadMiddleware::class
            );
        }

        if (! $container->has(StreamInterface::class)) {
            throw MissingDependencyException::dependencyForService(
                StreamInterface::class,
                ImplicitHeadMiddleware::class
            );
        }

        return new ImplicitHeadMiddleware(
            $container->get(ResponseInterface::class),
            $container->get(StreamInterface::class)
        );
    }
}
