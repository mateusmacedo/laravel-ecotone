/* eslint-disable no-undef */
db = db.getSiblingDB('laravel_startkit_api')
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