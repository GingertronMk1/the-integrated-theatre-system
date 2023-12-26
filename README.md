# The Integrated Theatre System

### DDD

##### Domain

- Entity?
  - This is the version with the most primitive types, used for creation and editing
  - Effectively the write model
- FinderInterface

##### Application

- Model?
  - This is the version with all the relations and that
  - Effectively the read model
- RepositoryInterface

##### Infrastructure

- ConcreteFinder
- ConcreteRepository

##### Framework

- Controller

