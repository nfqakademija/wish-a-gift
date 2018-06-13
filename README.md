# WISH A GIFT

# Table of Contents
- [Project Description](#Project_Description)
- [Requirements](#Requirements)
- [How to Run Dev Environment](#How_to_Run_Dev_Environment)
- [Development Help Tools](#Development_Help_Tools)
- [Team Members](#Team_Members)

# Project Description

The tempo of modern life is too fast to waste the time organizing a party.  **Wish a Gift**  is an application which helps you to easily  organize your party, create a gift lists, share them with friends and get the desired presents. If you know best what you really want, you can create a list of gifts and share it with your friends in just few clicks!

 **Wish a Gift**  was developed to make your life easier!

# Requirements
```
 - docker: >=18.x-ce
 - docker-compose: >=1.20.1
```

# How to Run dev environment
```
 $ git clone <project>
 $ cd path/to/<project>
 $ composer install 
 $ php bin/console doctrine:database:create
 $ php bin/console doctrine:schema:update --force
 $ php bin/console yarn install
```
  

For loading sample data
```
 $ php bin/console doctrine:fixtures:load
```
  
Open: [http://127.0.0.1:8000/](http://127.0.0.1:8000/)


# Development help tools

#### Check coding convention PSR-2:
```
 $ docker-compose exec -T prod.php.symfony vendor/bin/phpcs -p --colors --standard=PSR2 --extensions=php ./src
```

#### Fix coding style, where possible, according to PSR-2:
``` 
 $ docker-compose exec -T prod.php.symfony vendor/bin/phpcbf -p --colors --standard=PSR2 --extensions=php ./src
```


#### Travis continuous integration: 
``` 
 Generate strong random values for TRAVIS_APP_SECRET and TRAVIS_PROD_DB_PASS and add to travis-ci.com settings
```


# Team Members
#### Mentor:
- Aistis Stramkauskas
#### Developers:
- Nerijus Juras
- Olga Zyk
