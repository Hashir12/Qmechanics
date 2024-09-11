### Step 1: 
Clone the project from github into htdocs folder
### step 2: 
Run composer install command
### step 3: 
Uncomment database credentials from .env
### step 4: 
Create `.env` file and generate encryption key
### step 5: 
Run php artisan migrate --seed
### step 6:
Run php artisan passport:keys && php artisan passport:client
### step 7: 
Run php artisan serve && npm run dev

# Working scenerio:
## Admin Side
* Only admin can register.
* Admin can create `admin` & `user`.
* Admin can disable its `admins` & `users`.
* Admin can permanently delete the `admin` & `users`.
* Admin cannot access the users page.

## User
* Only admin added users can login.
* Users can add, edit, view and delete the posts.
* Users cannot access the admin routes.

## Api
to save the post from the api we only need to send these following parameters in the request `title` `post_content`
