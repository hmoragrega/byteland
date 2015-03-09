# Byteland

## Development environment ##

You can start a test environment box for virtualbox with vagrant
By default nginx will listen at http:

http://127.0.0.1:8890/

If you have the port **8890** in use, change it in the file *VagrantFile* 

*Please be patient can take up to 10 minutes*

## Project dependencies ##

To install the project dependencies use composer

```
composer install
```

This project depends on php >= 5.5 and full Symfony2 > 2.6

# DB Model design #

It is available for viewing with **MySQL workbench** at *resources/byteland.db.model.mwb*
The generated SQL can be found at *vagrant/puppet/data/byteland.dev.sql*, it is loaded with vagrant

## Run tests ##

To run the tests use the following commands

*SpecBDD tests:*
```
bin/phpspec run src/Byteland/DomainBundle/Entity
bin/phpspec run src/Byteland/DomainBundle/Exception
bin/phpspec run src/Byteland/DomainBundle/Repository
bin/phpspec run src/Byteland/DomainBundle/Manager
bin/phpspec run src/Byteland/ApiBundle/Controller
```

*PHPUnit tests*
```
bin/phpunit src/Byteland/DomainBundle
```

## Test API using swagger ##

You can access swagger on the path: */swagger/index.html* and load the swagger schema file on path */api/v1/swagger*
With the predefined vagrant values this url will be [here](http://127.0.0.1:8890/swagger/index.html?url=http://127.0.0.1:8890/api/v1/swagger)

**NOTE:** Seems that there is a problem with PATCH methods, you can't set parameters so you will need another tool for testing patch requests. I suggest Postman for Chrome