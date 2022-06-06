/***************************************************************************************************/
Apres avoir ajouter une base de données a notre projet dans heroku, on saisie la commande suivante
pour afficher les informations de configuration de la base de donnés
(Dans ce cas, moi j'ai choisie une base de donnée postgre sql)
Heroku Postgres
/***************************************************************************************************/
heroku pg:credentials:url --app blog-laravel-5-8-vuejs-2
(node:124094) SyntaxError Plugin: heroku: /home/kiko/.local/share/heroku/config.json: Unexpected end of JSON input
module: @oclif/config@1.18.3
task: runHook prerun
plugin: heroku
root: /snap/heroku/4092
See more details with DEBUG=*
(Use `node --trace-warnings ...` to show where the warning was created)
Connection information for default credential.
Connection info string:
   "dbname=dd2r1enai7aerj 
   host=ec2-52-206-182-219.compute-1.amazonaws.com port=5432 
   user=ipozywseotdaqd password=e638236d5383930071133b6963da5fb9cc84af02052761579b64620e7385ba56 sslmode=require"
Connection URL:
   postgres://ipozywseotdaqd:e638236d5383930071133b6963da5fb9cc84af02052761579b64620e7385ba56@ec2-52-206-182-219.compute-1.amazonaws.com:5432/dd2r1enai7aerj

/******************************************************************************************/
   heroku config:add DB_CONNECTION=pgsql --app blog-laravel-5-8-vuejs-2
   heroku config:add DB_HOST=ec2-52-206-182-219.compute-1.amazonaws.com  --app blog-laravel-5-8-vuejs-2
   heroku config:add DB_PORT=5432  --app blog-laravel-5-8-vuejs-2
   heroku config:add DB_DATABASE=dd2r1enai7aerj  --app blog-laravel-5-8-vuejs-2
   heroku config:add DB_USERNAME=ipozywseotdaqd  --app blog-laravel-5-8-vuejs-2
   heroku config:add DB_PASSWORD=e638236d5383930071133b6963da5fb9cc84af02052761579b64620e7385ba56  --app blog-laravel-5-8-vuejs-2
/******************************************************************************************/
heroku run bash : for multiple cmd
heroku run php artisan migrate : for a single cmd   