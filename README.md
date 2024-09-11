#Step 1:
Clone the project from github into htdocs folder

#step 2:
run `composer update` command

#step 3:
run `php artisan migrate --seed`

#step 4:
run `php artisan passport:keys` && `php artisan passport:client`

#step 5:
run `php artisan serve` && `npm run dev`

to save the post from the api we only need to send these following parameters in the request
title
post_content
