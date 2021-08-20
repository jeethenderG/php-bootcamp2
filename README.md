# php-bootcamp2

Readme For day3_1/mobile-app:

The following routes have been set-up:

port and ip : when u start the server in your local terminal ( u will get this)
By Deafult port :8000 and IP: 127.0.0.1

Routes:

POST : path : 127.0.0.1:8000/api/users/create

       request ("json")
               : {"name":"xxxx","email":"xxxx@gmail.com","phone":a ten digit integer}
       reponse (json) 
               :  {
                     "id": X,
                     "name": "xxxx",
                     "email": "xxxx@gmail.com",
                     "phone": a ten digit number
                  }
 
GET : path : 127.0.0.1:8000/api/users/

       request body : empty (not required)
       response : Fetches all the users.
       
GET : path : 127.0.0.1:8000/api/users/search/name/{name}

       reponse (json) 
               :  {
                     "id": X,
                     "name": "xxxx",
                     "email": "xxxx@domain.com",
                     "phone": a ten digit number
                  }
                  
       
GET : path : 127.0.0.1:8000/api/users/search/email/{email}

       reponse (json) 
               :  {
                     "id": X,
                     "name": "xxxx",
                     "email": "xxxx@domain.com",
                     "phone": a ten digit number
                  }
       
GET : path : 127.0.0.1:8000/api/users/search/phone/{phone}

       Note : Phone number must be 10digit
       reponse (json) 
               :  {
                     "id": X,
                     "name": "xxxx",
                     "email": "xxxx@domain.com",
                     "phone": a ten digit number
                  }
DELETE : path : 127.0.0.1:8000/api/users/delete/name/{name}

       reponse (json) (on success)
               :  {
                     User is deleted
                  }
DELETE : path : 127.0.0.1:8000/api/users/delete/email/{email}

       reponse (json) (on success)
               :  {
                     User is deleted
                  }
DELETE : path : 127.0.0.1:8000/api/users/delete/phone/{phone}
       
       Note : Phone number must be 10digit
       reponse (json) (on success)
               :  {
                     User is deleted
                  }
PATCH : path : 127.0.0.1:8000/api/users/update/{id}

       request ("json")
               : not required
       reponse (json) (on success)
               :  fetches User By Id.
               
To run using local system uding local databse make sure you have php, laravel, and mysql change the database connection details in .env file. 
In .env file :

      Make necessary changes of database like : Username,password.

Then run the following in your terminal:

Run :
   ```
   1. php artisan migrate             : (to migrate all the required tables, this is one time)
      php artisan migrate:refresh     :If you want to refresh tables Use : 
   2. php artisan serve               :(laravel server will start and you can start using the aplication)
   ```         
       
