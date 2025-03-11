# Dependency Injection Container Example

This is a small example implementing a (not feature complete) dependency injection container. Just for learning purposes.

Lots of applications will end up with class dependencies such as:

```
$orderService = new OrderService(
    new PaymentService(
        new SecurityClient()
    ), 
    new CustomerEngagementService()
);
```

This can become quite cumbersome.

Solution? A dependency injection container!

Register explicit mappings in the container such that the keys are Fully Qualified Class Names (FQCNs), and the values are functions returning an object of the FQCN:
```
$container = new DependencyInjectionContainer();

// OrderService needs a PaymentService and CustomerEngagementService. It can be instantiated 4th.
$container->set(OrderService::class, function(DependencyInjectionContainer $c) {
    return new OrderService($c->get(PaymentService::class), $c->get(CustomerEngagementService::class));
});

// PaymentService requires a SecurityClient. Instantiated 3rd.
$container->set(PaymentService::class, function(DependencyInjectionContainer $c) {
    return new PaymentService($c->get(SecurityClient::class));
});

// Order of classes with no dependencies does not matter.

// SecurityClient has no dependencies. It can be instantiated 2nd. 
$container->set(SecurityClient::class, function(DependencyInjectionContainer $c) {
    return new SecurityClient();
});

// CustomerEngagementService has no dependencies it can be instantiated 1st.
$container->set(CustomerEngagementService::class, function(DependencyInjectionContainer $c) {
    return new CustomerEngagementService();
});

$orderService = $container->get(OrderService::class);
```

Or better yet, use reflection to implement autowiring, and we end up with:

```
$container = new DependencyInjectionContainer();
$orderService = $container->get(OrderService::class);
```


Running PHPUnit tests:
```
./vendor/bin/phpunit tests/OrderServiceTest.php
```
