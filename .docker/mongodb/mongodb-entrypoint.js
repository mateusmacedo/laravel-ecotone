/* eslint-disable no-undef */
db = db.getSiblingDB('admin')
db.createUser({
  user: 'laravel_startkit_api',
  pwd: 'Secret*123',
  roles: [
    {
      role: 'dbOwner',
      db: 'laravel_startkit_api'
    }
  ]
})