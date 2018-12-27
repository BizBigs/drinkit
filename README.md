
# FIRST STEP

Install Docker on your PC :
    - https://hub.docker.com/editions/community/docker-ce-desktop-windows

    During installation, don't forget to share the drive you will work on. It can be done later in Docker -> Settings -> Shared Drives.

# 2 : Set your environment variables 

    - in .env file, set all your wanted environment variables.

# 3 : Play the docker-compose.yml 

    - Make sure to be in your working folder root (must be the docker-compose.yml file)
    - Run 'docker-compose build' -> This will create/download all your images for you containers. 
        (here only php image is created, others are downloaded from Docker Hub, all images are available here : https://hub.docker.com/).
        This may take a moment, go get a coffee :)
    - Run 'docker-compose up -d' -> This will create all containers thanks to the images previously created/downloaded.
        . '-d' option is to make your terminal available and keep the command running background
    - Run 'docker-compose ps' to see if all containers are up.
                        
                        Name                   Command               State                 Ports
                    -------------------------------------------------------------------------------------------
                    maildev          bin/maildev --web 80 --smtp 25   Up      25/tcp, 0.0.0.0:8001->80/tcp
                    mysql            docker-entrypoint.sh --def ...   Up      0.0.0.0:3306->3306/tcp, 33060/tcp
                    nginx            nginx -g daemon off;             Up      0.0.0.0:80->80/tcp
                    php              docker-php-entrypoint php-fpm    Up      9000/tcp
                    sf4_phpmyadmin   /run.sh supervisord -n -j  ...   Up      0.0.0.0:8080->80/tcp, 9000/tcp

# 4 : Install dependencies for Symfony 

    2 ways are possible, from the container or from your host :
        
        From your container :
            If you don't have php or composer installed on your host, just connect to your php container :
                - docker exec -it -u root ${PHP_CONTAINER_NAME} bash
                - go to your working directory (you should be there as soon as you connect in the container)
                - go to apps/${CONTAINER_SYMFONY_APP_NAME}
                - run 'php bin/composer.phar install' (this will install all dependencies for the symfony project)

        From your host :
            Same steps if you have php or composer installed :D
                If you have php, run 'php bin/composer.phar install' in the directory you have the composer.json file (apps/${CONTAINER_SYMFONY_APP_NAME}).
                If you have composer, run 'composer install'
                If you have both, chose your way :D

        The thing is, when you do it from the container, this will automatically add dependencies in your host
            ... and it's conversely, thanks to this line in our docker_compose.yml :

                volumes:
                - './apps/drinkit:/usr/src/app/drinkit:rw' 

                The container will listen every change you make on the files you have in those specific directories.
                Very usefull because it allows you to develop and test your code without rebuilding your images every time you make a change.

# 5 : Test it 
    
    If the 4 previous steps were done correctly you can go check http://localhost and you should have the Home Page.

# 6 : phpMyADMIN 

    If you just go on http://localhost:8080 you will get to phpmyadmin front page but you won't be able to connect to your Databases.
    You need to configure an adminstrator user in mysql container:

        - Run 'docker exec -it ${mysql_container_name} bash' to connect to mysql container
        - Run 'mysql -u root'
        Then add your admistrator :
            mysql> CREATE USER '${ADMIN_NAME}'@'localhost' IDENTIFIED BY '${ADMIN_PWD}';
            mysql> GRANT ALL PRIVILEGES ON *.* TO '${ADMIN_NAME}'@'localhost'
                ->     WITH GRANT OPTION;
            mysql> CREATE USER '${ADMIN_NAME}'@'%' IDENTIFIED BY '${ADMIN_PWD}';
            mysql> GRANT ALL PRIVILEGES ON *.* TO '${ADMIN_NAME}'@'%'
                ->     WITH GRANT OPTION;

        Replace all ${ ... } by your chosen adminstrator name and password.

# ENJOY ! :D 