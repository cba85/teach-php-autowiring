<?php

namespace App\Container;

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
        if (!$this->has($name)) {
            throw new NotFoundException;
        }
        return $this->items[$name]($this);
    }

    public function __get($name)
    {
        return $this->get($name);
    }
}