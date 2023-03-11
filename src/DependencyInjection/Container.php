<?php

namespace App\DependencyInjection;

use Exception;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;

class Container {

    private array $bindings = [];

    /**
     * Note that this function passes $this which is an instance
     * of Container, to the function stored in $bindings. This is 
     * calling the function that gets the object for us!
     * 
     * Attempts to find an explicit binding, falls back to autowiring.
     *
     * @param string $fqcn A fully qualified class name
     * @return mixed
     */
    public function get(string $fqcn): mixed {
        if (isset($this->bindings[$fqcn])) {
            return $this->bindings[$fqcn]($this);
        } else {
            return $this->resolve($fqcn);
        }
    }

    /**
     * Create a binding between the $fqcn and the callable $instance.
     * This stores them in an associative array: [$fqcn => $instance]
     *
     * @param string $fqcn The fully qualified class name
     * @param callable $instance
     * @return void
     */
    public function set(string $fqcn, callable $instance): void {
        $this->bindings[$fqcn] = $instance;
    }

    /**
     * Returns true if the container has a binding for the FQCN.
     *
     * @param string $fqcn
     * @return boolean
     */
    public function has(string $fqcn): bool {
        return isset($this->bindings[$fqcn]);
    }

    /**
     * Resolve a fully qualified class name using autowiring.
     *
     * @param string $fqcn
     * @return mixed
     */
    public function resolve(string $fqcn): mixed {
        $reflectionClass = new ReflectionClass($fqcn);
        if (!$reflectionClass->isInstantiable()) {
            throw new Exception("$fqcn is not instantiable");
        }
        $constructor = $reflectionClass->getConstructor();
        $parameters = $constructor->getParameters();

        // Base case:
        // No constructor, or a constructor with no parameters
        // If class dependencies were to be modeled as a directed graph
        // this $fqcn is a node with no outgoing edges.
        if (!$constructor || empty($parameters)) {
            return new $fqcn;
        }

        // Recursive case:
        // Resolve each dependency of the object we're resolving
        $concreteDependencies = [];
        foreach($parameters as $parameter) {
            $type = $this->getType($parameter);
            if (isset($this->bindings[$type->getName()])) {
                $concreteDependencies[] = $this->bindings[$type->getName()]($this);
            } else {
                $concreteDependencies[] = $this->resolve($type->getName());
            }
        }

        // build the class now that we have the needed dependencies
        return $reflectionClass->newInstanceArgs($concreteDependencies);
    }

    /**
     * Given a ReflectionParameter, return the ReflectionNamedType if possible.
     *
     * @param ReflectionParameter $dependency
     * @return ReflectionNamedType
     */
    private function getType(ReflectionParameter $dependency): ReflectionNamedType {
        $type = $dependency->getType();
        if (!$type) {
            $name = $dependency->getName();
            throw new Exception("$name is not type hinted. Cannot resolve!");
        }
        if ($type->isBuiltin()) {
            throw new Exception("Cannot resolve built in types.");
        }
        return $type;
    }

}
