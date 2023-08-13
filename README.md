

<p align="center">
    <img title="Laravel Zero" height="100" src="https://raw.githubusercontent.com/laravel-zero/docs/master/images/logo/laravel-zero-readme.png" />
</p>

------

<h3><center>Item add and sort</center></h3>

------

## Information
This is a <bold> terminal based </bold> which takes field inputs for an ITEM (stated below).
-It takes one element input at a time. If the item name is already on the database it should give out an error, it is case sensitive and only accept strings consisting of alphanumeric characters and spaces.

-Once the first ITEM is added, the user can choose to sort or input a new ITEM.

-Sorting can be done by Name, Quantity or Price.
If sorting by Quantity, and 2 ITEMS have the same quantity, next field to check is name. 
If sorting by Price and 2 ITEMS have the same price, next field to be checked is the name. 
It should output the list of sorted items in this manner:

| **Id** 	| **Name**  | **Quantity** | **Price** |
|----------	|------------------	|------------------	|------------------	|
| 1      	| Item     	| 0 	| 00.00 |


And the sorting time it took for the algorithm to sort it out. (system time used)

------

## Setup Instructions

# Getting started

## Installation

Please check the official laravel-zero installation guide for server requirements before you start. [Official Documentation](https://laravel-zero.com/docs/introduction)
 

Clone the repository

    https://github.com/vinaysavner/laravel-zero-item-add-search-example.git

Switch to the repo folder

    cd laravel-zero-item-add-search-example

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

You will then need to run the app:rename command to rename your project:

    php application app:rename <your-app-name>

Run the database migrations (**Set the database connection in .env before migrating**)

    php <your-app-name> migrate

Run the app to check the app details
  
    php <your-app-name> 

You can now access the app by terminal

**Command list**

    git clone https://github.com/vinaysavner/laravel-zero-item-add-search-example.git
    cd laravel-zero-item-add-search-example
    composer install
    cp .env.example .env
    php application app:rename <your-app-name>
    php <your-app-name> 
    
**Make sure you set the correct database connection information before running the migrations**

    php <your-app-name> migrate

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing App

Run the laravel-zero app

    php <your-app-name>

Run the laravel-zero command for item app

    php <your-app-name> item:run
