# The Integrated Theatre System

### DDD

##### Domain

- Entity?
- FinderInterface

##### Application

- Model?
- RepositoryInterface

##### Infrastructure

- ConcreteFinder
- ConcreteRepository

##### Framework

- Controller

### Schema Planning

```dbml
// Use DBML to define your database structure
// Docs: https://dbml.dbdiagram.io/docs

/* PEOPLE */
Table users {
  id string [primary key]
  email varchar [unique, not null]
  password varchar [not null]
  created_at timestamp
  updated_at timestamp
}

Table people {
  id string [primary key]
  user_id string [null, ref: - users.id]
  name string [null]
  start_year string
  end_year string
  created_at timestamp
  updated_at timestamp
}

Table roles {
  id string [primary key]
  name string [not null]
  position role_type [not null] // cast or crew
  created_at timestamp
  updated_at timestamp
}

Enum role_type {
  cast
  crew
}

/* SHOWS */
Table shows {
  id string [primary key]
  name string
  description text [null]
  year string [null]
  season string [null]
  created_at timestamp
  updated_at timestamp
}

Table show_cast {
  id string [primary key]
  show_id string [not null, ref: > shows.id]
  person_id string [not null, ref: > people.id]
  role_name string
  notes string [null]
}

Table show_crew {
  id string [primary key]
  show_id string [not null, ref: > shows.id]
  person_id string [not null, ref: > people.id]
  role_id string [not null, ref: > roles.id]
  notes string [null]
}

/* PERFORMANCES */
Table performances {
  id string [primary key]
  show_id string [not null, ref: > shows.id]
  show_start string [null]
  location string // TODO: make this a table?
  capacity int [note: 'positive int']
}

Table tickets {
  id string [primary key]
  performance_id string [not null, ref: > performances.id]
  status ticket_status
  cost_pence int [null]
}

Enum ticket_status {
  available
  reserved
  bought
}

/* TRAINING */
Table training_categories {
  id string [primary key]
  name string [not null]
  created_at timestamp
  updated_at timestamp

}

Table training_items {
  id string [primary key]
  name string [not null]
  training_category_id string [not null, ref: > training_categories.id]
  dangerous boolean
  created_at timestamp
  updated_at timestamp
}

Table training_session {
  id string [primary key]
  training_item_id string [not null, ref: > training_items.id]
  occurred_at timestamp
  created_at timestamp
  updated_at timestamp
}

Table training_session_trainers {
  id string [primary key]
  training_session_id string [not null, ref: < training_session.id]
  trainer_id string [not null, ref: > people.id]

}

Table training_session_trainees {
  id string [primary key]
  training_session_id string [not null, ref: < training_session.id]
  trainee_id string [not null, ref: > people.id]
}
```
