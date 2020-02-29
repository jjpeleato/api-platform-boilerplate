# API Platform Boilerplate

## Project

Built with **API platform** using the following technologies: Symfony 4.4.*, Doctrine 2, Lando (Docker) and more technologies.

API Platform is a powerful but easy to use full stack framework dedicated to API-driven projects. It contains a PHP library to create fully featured APIs supporting industry-leading standards (JSON-LD, GraphQL, OpenAPI...), provides ambitious JavaScript tooling to consume those APIs in a snap (admin, PWA and mobile apps generators, hypermedia client...).

### Installing dependencies

- You have to install **Lando**: https://docs.devwithlando.io/

If Lando's tools does not work for you, there is another way. You must install the environment manually: XAMP and Composer.

For more information visit:

- XAMP: https://www.apachefriends.org/es/index.html
- Composer: https://getcomposer.org/

**Note:** If you work with Windows. To execute the commands, we recommend installing **Cygwin** http://www.cygwin.com/

**Note:** I recommend installing the following IDE for PHP Programming: Visual Studio Code (https://code.visualstudio.com/) or PHPStorm (recommended) (https://www.jetbrains.com/phpstorm/).

### Project skeleton

```
├─ bin/ # Symfony console
│  ├─ console
├─ config/ # Routes, JWT keys, Symfony bundles and configuration files.
│  ├─ jwt/
│  ├─ packages/
│  ├─ routes/
│  ├─ bootstrap.php
│  ├─ bundles.php
│  ├─ routes.yaml
│  └─ services.yaml
├─ private/ # Private directory.
│  ├─ config/
│  ├─ sql/ # SQL files for import to minimal or fake data
│  └─ .htaccess
├─ public/ # Public directory (DocumentRoot).
├─ src/ # Source directory.
│  ├─ Controller/
│  ├─ Entity/
│  ├─ Repository/
│  └─ Kernel.php
├─ templates/ # Views directory
├─ .editorconfig
├─ .env.dist # Environment Variables
├─ .gitignore
├─ .lando.yml # Lando recipe
├─ composer.json
├─ deploy.sh.dist # Shell Script for deploy to environments
├─ deploy-exclude-list.txt
├─ phpcs.xml.dist
├─ README.md
├─ script_database.sh # Clear and create fake data or minimal data
├─ script_local.sh # Clear and create fake data or minimal data
└─ script_prod.sh.sh # Commands to clean cache and update database
```

### Installing

1. If required. Open the `.lando.yml` and rename the project and proxy name.
2. Open your terminal and browse to the root location of your project.
3. Run `$lando start`.
	- The project has a `.lando.yml` file with all the environment settings.
	- The command starts the installation process when it finishes, you can see all the URLs to access.
4. Copy `.env.dist` to `.env` and edit the credentials. Example:
    - `APP_ENV=dev` Write: dev, test or prod.
    - `APP_DEBUG=true` Write: true or false.
    - `APP_SECRET=0167fb00dc2b09153cae7a8157b93a8b` Write a ramdon secret key of length 32 characters.
    - `APP_KEY=BW8Jf33j3bdRo6u3x7I4` Write a ramdon secret key of length 20 characters.
    - `CORS_ALLOW_ORIGIN=^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$` Allow URL to the CORS system. Put the correct URI.
    - `DATABASE_URL=mysql://lamp:lamp@database:3306/lamp?serverVersion=5.7` If you work with lando.
    - `JWT_PASSPHRASE=62429f38cb8270916c538e37e48a75d8` Write a ramdon passphrase key of length 32 characters.
5. Copy `deploy.sh.dist` to `deploy.sh` and edit the credentials according repository and SSH data.
    - `GIT_URI`
    - `SSH_DIRECTORY`
6. Copy `phpcs.xml.dist` to `phpcs.xml` and not edit.
6. Copy `public/humans.txt.dist` to `public/humans.txt` and edit.
7. If required. Run: `$lando composer install`.
8. Generate the SSH keys:
    - `$lando ssh` then:
        - `$mkdir -p config/jwt # For Symfony3+, no need of the -p option`
        - `$openssl genrsa -out config/jwt/private.pem -aes256 4096`
        - `$openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem`
9. Run `$ssh script_database.sh`
10. Run `$ssh script_local.sh` or `$ssh script_prod.sh`
11. End. Happy developing.

### Developing

- Open your terminal and browse to the root location of your project.
- If required. Run: `$lando composer install` then `$lando console [action]`.
    - `$lando console` List all commands.
    - `$lando console doctrine:schema:drop --force` Drops the configured database.
    - `$lando console doctrine:schema:create`  Creates the configured database.
    - `$lando console doctrine:schema:update --force` Executes (or dumps) the SQL needed to update the database schema to match the current mapping metadata.
    - `$lando console cache:clear` Clears the cache. Develop environment.
    - `$lando console cache:clear --env test` Clears the cache. Test environment.
    - `$lando console cache:clear --env prod` Clears the cache. Production environment.
- If you work with PHP CodeSniffer then `$lando composer [action]`.
	- `$lando composer cs` Runs the phpcs.
	- `$lando composer cs:fix` Runs the phpcbf.

### Deploy to environments

The present project uses a bash file called `deploy.sh`. Execute all commands to deploy in any environment. You only have to modify the git repository and server data.

1. Run `$lando ssh` then: `$sh deploy.sh`.
2. Open your terminal, you connect to PROD environment with SSH and browse to the root location of your project.
3. Run `$sh script_prod.sh`
4. If required. Run `$sh script_database.sh`

### Technologies and tools

The present project uses several technologies and tools for the automation and development process. For more information and learning visit the following links.

1. API Platform: https://api-platform.com/
2. Symfony 4: https://symfony.com/
3. Doctrine 2: https://www.doctrine-project.org/
4. Guzzle: http://docs.guzzlephp.org
5. UUID: https://github.com/ramsey/uuid
6. LexikJWTAuthenticationBundle: https://github.com/lexik/LexikJWTAuthenticationBundle
7. Git: https://git-scm.com/
8. Lando: https://docs.devwithlando.io/
9. Deployer: https://deployer.org/
10. Composer: https://getcomposer.org/
11. EditorConfig: https://editorconfig.org/
12. PHP_CodeSniffer: https://github.com/squizlabs/PHP_CodeSniffer
13. Human.txt: http://humanstxt.org/

**Note:** Thanks a lot of developers that to work on this projects.

### Clarifications

1. It is very important that if you deploy the project to publish. The **DocumentRoot** on the VirtualHost has to point to the **public/** directory.
2. It is very important that if you deploy the project to publish with **Deployer**. The **DocumentRoot** on the VirtualHost has to point to the **current/public/** directory.

## Finally

More information on the following commits. If required.

Grettings **@jjpeleato**.
