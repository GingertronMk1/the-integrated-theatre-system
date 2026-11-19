---
paths:
  - 'app/**'
---

# App

## Start model queries explicitly
Start Eloquent model queries with Model::query() before calling query builder methods, for example User::query()->find($id).
