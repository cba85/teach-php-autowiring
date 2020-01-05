<?php

namespace App\Container;

use ReflectionClass;
use App\Container\Exceptions\NotFoundException;

class Container
{
    protected $items = [];

    public function set($name, callable $closure)
    {
        $this->items{$name} = $closure;
    }

    public function share($name, callable $closure)
    {
        $this->items{$name} = function() use ($closure) {
            static $resolved;

            if (!$resolved) {
                $resolved = $closure($this);
            }

            return $resolved;
        };
    }

    public function has($name)
    {
        return isset($this->items[$name]);
    }

    public function get($name)
    {
        if ($this->has($name)) {
            return $this->items[$name]($this);
        }

        return $this->autowire($name);
    }

    public function autowire($name)
    {
        if (!class_exists($name)) {
            throw new NotFoundException;
        }

        $reflector = $this->getReflector($name);

        if (!$reflector->isInstantiable()) {
            throw new NotFoundException;
        }

        if ($constructor = $reflector->getConstructor()) {
            return $reflector->newInstanceArgs(
                $this->getReflectorConstructorDependencies($constructor)
            );
        }

        return new $name();
    }

    protected function getReflectorConstructorDependencies($constructor)
    {
        return array_map(function ($dependency) {
            return $this->resolveReflectedDependency($dependency);
        }, $constructor->getParameters());
    }

    protected function resolveReflectedDependency($dependency)
    {
        if (is_null($dependency->getClass())) {
            throw new NotFoundException;
        }

        return $this->get($dependency->getClass()->getName());
    }

    protected function getReflector($class)
    {
        return new ReflectionClass($class);
    }

    public function __get($name)
    {
        return $this->get($name);
    }
}