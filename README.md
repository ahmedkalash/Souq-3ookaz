# Souq-3ookaz

• Souq 3okaz is an E-commerce website for buying and selling products.<br>
• It has the main functions of an E-commerce platform.<br>
• It is composed of two subsystems  Admin subsystem and the Customer subsystem.<br>
• It is built Using: **PHP/Laravel**, **Mysql**, **[fastkart frontend templet](https://themeforest.net/item/fastkart-multipurpose-ecommerce-html-template/39085476)**, and **Filament admin panel**.<br>




### * _This project is still under development and all the information below may change._


### Requirement
    ▪ PHP 8.1
    ▪ Mysql 10.11.4
    ▪ Laravel 9.19
    ▪ Filament 3



## How to run

1. Clone the repo.
2. Copy `.en.example` file and rename it to `.env` and fill the necessary data.
3. Run `composer install`.
4. Run `php artisan migrate --seed`.
5. Run `php artisan key:generate`.
6. Run `php artisan storage:link`.
7. Run `php artisan serve`.




## Product Functions

Enlisted below are all the major functions and features
supported by the online shopping system **till now** along with the user classes.
### Customer Side
    ▪ Register
    ▪ Login
    ▪ Logout
    ▪ Email verification
    ▪ Password Rest
    ▪ Prevent too many fiald login attempts
    ▪ Authentication with google
    ▪ Supports multi-languages
    ▪ Product description page
        ▪ Product review and ratings
        ▪ Product attributes
        ▪ Product short description
        ▪ Product long description
        ▪ Related products in PDP
        ▪ Product special price if exist
    

### Admin Side
    ▪ Website settings managment
    ▪ Website translation managment
    ▪ Can perform CRUD operation for the product categoey 
    ▪ Can perform CRUD operation for the product 
    ▪ Can attach and de-attach product to/from categoey
    ▪ Can perform CRUD operation for the product Attributes
    ▪ Supports multi-languages
    ▪ Can add a special price to a product
    ▪ Can add related products to a product

    

### Some implementation details
    ▪ I used spatie media library to handel files.
    ▪ I used spatie permissions to handel roles and permissions.
    ▪ For the login, registration, password reset and email verification I did not use any package.
    ▪ Spatie Laravel translatable is used to handel model translations.
    ▪ Laravel socialite is used to authenticate with OAuth providers .
    ▪ RealRashid\SweetAlert is used to handel alerts
    ▪ Spatie Laravel translation loader and its Filament plugins is used handel static text translation 
    

### Some information about product category 
    ▪ You can add many categories , sub categories , sub sub categories and so on (unlimited levels of categories)
    ▪ Each categoey can have many chiledren and only one parent (one to many)
    ▪ Laravel-adjacency-listt package is used to handel the category hierarchy using recursive sql queries
    ▪ You can see the direct parent of the category and it's level in the hierarchy starting form level 0 as a root category
    ▪ I put some trigers on the product_categories table to detect and prevent cycels in the category tree to aviod infinite sql queries

### Next steps
    ▪ Short list of attributs