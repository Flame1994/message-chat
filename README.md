# Bunq Chat
A chat application API implementation written for the Bunq interview process using Laravel.

## Requirements
There are a few things needed in order to setup this project.
- PHP
- Apache / Nginx
- SQLite
- **[Composer](https://getcomposer.org/)**
- **[Laravel](https://laravel.com/docs/5.6/installation)**

## Installation
First, clone this repository and navigate to the directory where it has been downloaded. Follow the instructions below:

- Run the Composer installation
```jshelllanguage
$ composer install
```
- Create a `.env` file
```jshelllanguage
$ cp .env.example .env 
```
- Update the `.env` file with all needed information.
- Generate a key to your `.env` file
```jshelllanguage
$ php artisan key:generate
```
- Create a file called `database.sqlite` in the `database` folder.
- Migrate the database. You can add `--seed` if you would like to seed the database with dummy data.
```jshelllanguage
$ php artisan migrate --seed
```
- If you want to seed the database after you have already migrated, run the following
```jshelllanguage
$ php artisan db:seed
```

## Implementation

### Summary
**Laravel**, which is a MVC (Model View Controller) framework is used in this implementation, alongside a **Service** and **Repository** design pattern. 

Communication through the API happens over a simple JSON based protocol over HTTP.

The implementation is using a simple SQLite database.

### Models
Using the Eloquent ORM, models can be created that map directly to database tables. Thus, we have two Models called
**User** and **Message**. Models can have relationships specified that map to database relationships. In the **Message** model
you can see two relationships `from` and `to` which link to the **User** model. These relationships make is easier to make queries 
through Eloquent and load data from the related models.

### Controllers
Controllers are responsible for controlling the flow of the application over the HTTP requests. A request with link to a function within a specified controller, which will then be passed along to a **Service**. We have two Controllers called **UserController** and **MessageController**.

### Services
The logic is written within the Services. Incoming requests, validation and responses are all handled by a Service.
The services are written in such a way that the Eloquent ORM is never used, making it available for other resources to 
work with. We have two Services called **UserService** and **MessageService**.

### Repositories
A Repository is an abstraction of the data layer and a centralised way of handling our models. 
The idea with this pattern is to have a generic abstract way for the app to work with the data 
layer without being bothered with if the implementation is towards a local database or towards an online API. 
We have two Repositories called **UserRepository** and **MessageRepository**.

## API
These are the current API routes that are available. You can view them in the `api.php` file in the `routes` folder.
```
 METHOD         URI                             Description
 --------------------------------------------------------------------------------------------------
 GET            users                           Get all users
 POST           users                           Create a user
 PUT            users                           Update a user
 GET            users/:id                       Get user by id
 DELETE         users/:id                       Delete user by id
 GET            users/:id/messages              Get all messages of user
 GET            users/:id/messages/inc          Get all incoming messages of user
 GET            users/:id/messages/inc/:from    Get all incoming messages of user from another user
 GET            users/:id/messages/out          Get all outgoing messages of user
 GET            users/:id/messages/out/:to      Get all outgoing messages of user from another user
 GET            users/:id/messages/all/:user    Get all messages between two users (in order)
 
 GET            messages                        Get all messages
 POST           messages                        Create a message
 PUT            messages                        Update a message
 GET            messages/:id                    Get message by id
 DELETE         messages/:id                    Delete message by id
```

