# The Integrated Theatre System

## DDD

### Domain

- Entity (aka write model)
- RepositoryInterface

#### Per Noback

- Entities
- Value Objects
- Domain Events
- Write model repository interfaces
- Domain services

### Application

- Model (aka read model)
- FinderInterface
- Command DTOs (Commands), and Command Handlers

#### Per Noback

- Application services/command handlers, and command DTOs
- View model repository interfaces and view model DTOs

### Infrastructure

- ConcreteFinder
- ConcreteRepository

### Framework

- Controller

