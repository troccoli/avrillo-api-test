# Assumptions

I had to made a few assumptions on how the API should work. I will be happy to discuss them and the
reasons behind.

# Setting up the app

First of all, clone the repository and `cd` into it

```shell
git clone https://github.com/troccoli/avrillo-test.git
cd avrillo-test
```

I am using Docker, and Laravel Sail, for development so the next step would be to spin up the containers.

```shell
./vendor/bin/sail up -d
```

Now I recommend creating an alias for Sail with the following command. Note that this will create the alias
for the current shell session only.
```shell
alias sail=./vendor/bin/sail
```

Now set the environment. For this test I have not changed any default, so we only need to generate a new application key.
 ```shell
sail composer install
cp .env.example .env
sail artisan key:generate
```

Now let's build the database. Again, as I haven't change anything in the default environment we are going to use MySQL,
which has already been spun up in a container
```shell
sail artisan migrate
```

## Running the tests

This is as simple as
```shell
sail test
```

## Testing the APIs

You can also test the API in your client of choice, like for example Postman or even curl.

The APIs need an authenticated user, via the `X-API-Token` header. To create a user you can use the `app:create-api-user`
artisan command. The command will output the token to be used for authentication.

# API documentation

I have also written some documentation for the API, using OpenAPI v3 standard, and the Redocly CLI tool.
It can be accessed on 'http://localhost/openapi.html'.
