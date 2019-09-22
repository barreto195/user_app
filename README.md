# user_app
RESTful API Exercise

## Getting Started

### Prerequisites

This exercise requires a server that can run PHP and a MySQL connection, as well as an empty MySQL database.

### Installation

Step 1: Host the files included in this project on a server that can run PHP and MySQL.

Step 2: Create an empty MySQL database.

Step 3: Associate a MySQL user to the newly-created database with *CREATE*, *SELECT*, *INSERT*, *UPDATE*, and *DELETE* privileges.

Step 4: After selected the newly-created database, run the MySQL queries in the included **install.sql** script. You should end up with a table named *user* containing the following columns:

```
`id` INT NOT NULL AUTO_INCREMENT,
`name` VARCHAR(100) NOT NULL,
`email` VARCHAR(50) NOT NULL,
`birthdate` DATE NOT NULL,
`gender` ENUM('m','f','o') NOT NULL
```

Step 5: Edit the *config/config.php* script with the appropriate MySQL credentials, as shown in the example below:

```
// MySQL database credentials (change as necessary)
$host = 'localhost';
$user = 'test_user';
$password = 'logPT90210';
$db_name = 'user_app';
```

## Testing the API

In order to test the API included in this exercise, you will need an API client such as the one provided by [Postman](https://www.getpostman.com/).

Each operation is included in an individual file in the *api* directory. Below you will find instructions for these operations. Whenever a request results in failure, you will receive the appropriate HTTP response code and an error message in JSON format, as shown in the example below:

```
{
    "error": "This is an error message."
}
```

### Create

```
http://yourhost.com/api/create.php
```

Creates a new user via a **POST** request. The Body must be a JSON object with the following properties:

```
name - a string with a maximum length of 100 characters.
email - a string containing a valid email address with a maximum length of 50 characters.
birthdate - a date formatted as: YYYY-MM-DD
gender - a string with three possible values: 'm' (male), 'f' (female), or 'o' (other).
```

This request will return an HTTP response code **201** on success. Since the API may change some of the data as a result of sanitization, the processed data will also be returned to the client in JSON format. This includes the corresponding *id* stored in the MySQL database, which may then be used for other operations. For example:

```
{
    "id": "1",
    "name": "Marco Barreto",
    "email": "barreto195@gmail.com",
    "birthdate": "1988-08-13",
    "gender": "m"
}
```

### Update

```
http://yourhost.com/api/update.php
```

Updates an existing user via a **PUT** request. The Body must be a JSON object with the following properties:

```
id - an integer that is a unique identifier for the user being fetched and updated
name - a string with a maximum length of 100 characters.
email - a string containing a valid email address with a maximum length of 50 characters.
birthdate - a date formatted as: YYYY-MM-DD
gender - a string with three possible values: 'm' (male), 'f' (female), or 'o' (other).
```

This request will return an HTTP response code **200** on success. Since the API may change some of the data as a result of sanitization, the processed data will also be returned to the client in JSON format, as shown in the example below:

```
{
    "id": "1",
    "name": "Marco André Barreto",
    "email": "marco.barreto195@example.com",
    "birthdate": "1988-08-13",
    "gender": "m"
}
```

### Delete

```
http://yourhost.com/api/delete.php
```

Deletes an existing user via a **DELETE** request. The Body must be a JSON object with the *id* corresponding to the user to be deleted:

```
id - an integer that is a unique identifier for the user being deleted
```

This request will return an HTTP response code **204** on success.

### List

```
http://yourhost.com/api/list.php
```

Lists all of the existing users via a **GET** request.

This request will return an HTTP response code **200** on success, as well as the existing users in a JSON-formatted array, as shown in the example below:

```
[
    {
        "id": "1",
        "name": "Marco Barreto",
        "email": "barreto195@gmail.com",
        "birthdate": "1988-08-13",
        "gender": "m"
    },
    {
        "id": "2",
        "name": "Maria Albertina",
        "email": "maria.albertina@vanessa.pt",
        "birthdate": "1990-09-21",
        "gender": "f"
    }
]
```

### View

```
http://yourhost.com/api/view.php?id=someinteger
```

Returns an existing user via a **GET** request. The server expects an *id* query parameter with an integer that corresponds to the user being fetched.

This request will return an HTTP response code **200** on success, along with a JSON object containing the user data, as shown in the example below:

```
{
    "id": "1",
    "name": "Marco Barreto",
    "email": "barreto195@gmail.com",
    "birthdate": "1988-08-13",
    "gender": "m"
}
```

## Author

Marco Barreto - [barreto195](https://github.com/barreto195)
