<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8690bab61c5c73dbf30b1f5c2a28e2cb
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Core\\' => 5,
        ),
        'B' => 
        array (
            'Bravo\\ORM\\ENV\\' => 14,
            'Bravo\\ORM\\' => 10,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'Bravo\\ORM\\ENV\\' => 
        array (
            0 => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/env',
        ),
        'Bravo\\ORM\\' => 
        array (
            0 => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'App\\Controllers\\ProductController' => __DIR__ . '/../..' . '/app/controllers/ProductController.php',
        'App\\Controllers\\UserController' => __DIR__ . '/../..' . '/app/controllers/UserController.php',
        'App\\Models\\Product' => __DIR__ . '/../..' . '/app/models/Product.php',
        'App\\Models\\User' => __DIR__ . '/../..' . '/app/models/User.php',
        'Bravo\\ORM\\BravoORM' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/ORM/BravoORM.php',
        'Bravo\\ORM\\DB' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/Database/DB.php',
        'Bravo\\ORM\\DataHandler' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/helpers/DataHandler.php',
        'Bravo\\ORM\\DataNotFoundException' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/exceptions/dataNotFoundException.php',
        'Bravo\\ORM\\ENV\\DatabseEnv' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/env/DatabaseEnv.php',
        'Bravo\\ORM\\ExceptionInterface' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/interfaces/ExceptionInterface.php',
        'Bravo\\ORM\\Model' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/test/model.php',
        'Bravo\\ORM\\Query' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/Database/query.php',
        'Bravo\\ORM\\QueryFormater' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/helpers/QueryFormater.php',
        'Bravo\\ORM\\QueryHandler' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/Database/queryHanlder.php',
        'Bravo\\ORM\\countsResults' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/traits/countsResultsTrait.php',
        'Bravo\\ORM\\handlesExceptions' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/traits/handlesExceptionsTrait.php',
        'Bravo\\ORM\\inputSanitizer' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/helpers/inputSanitizer.php',
        'Bravo\\ORM\\logicQuerys' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/interfaces/logicQuerysInterface.php',
        'Bravo\\ORM\\noConnectionException' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/exceptions/noConnectionException.php',
        'Bravo\\ORM\\statementException' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/exceptions/statementException.php',
        'Bravo\\ORM\\supportsCRUD' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/interfaces/supportsCRUDInterface.php',
        'Bravo\\ORM\\verifyiesData' => __DIR__ . '/..' . '/emilio-bravo/bravo-orm/src/traits/veryfiesDataTrait.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Core\\Client\\Authentification\\Auth' => __DIR__ . '/../..' . '/core/client/auth/Auth.php',
        'Core\\Client\\Authentification\\guestsNotAllowed' => __DIR__ . '/../..' . '/core/client/auth/guestsNotAllowed.php',
        'Core\\Client\\View' => __DIR__ . '/../..' . '/core/client/View.php',
        'Core\\Client\\ViewHelper' => __DIR__ . '/../..' . '/core/client/ViewHelper.php',
        'Core\\FileSystems\\Storage' => __DIR__ . '/../..' . '/core/FileSystems/Storage.php',
        'Core\\Foundation\\Controller' => __DIR__ . '/../..' . '/core/Foundation/Controller.php',
        'Core\\Foundation\\Model' => __DIR__ . '/../..' . '/core/Foundation/Model.php',
        'Core\\Foundation\\Traits\\Http\\Renderable' => __DIR__ . '/../..' . '/core/Foundation/traits/http/RenderableTrait.php',
        'Core\\Foundation\\Traits\\Http\\canMorphContent' => __DIR__ . '/../..' . '/core/Foundation/traits/http/canMorphContent.php',
        'Core\\Foundation\\Traits\\Http\\httpResponses' => __DIR__ . '/../..' . '/core/Foundation/traits/http/httpResponses.php',
        'Core\\Foundation\\Traits\\Http\\responseMessages' => __DIR__ . '/../..' . '/core/Foundation/traits/http/responseMessagesTrait.php',
        'Core\\Http\\Persistent' => __DIR__ . '/../..' . '/core/HTTP/Persistent.php',
        'Core\\Http\\Request' => __DIR__ . '/../..' . '/core/HTTP/Request.php',
        'Core\\Http\\Response' => __DIR__ . '/../..' . '/core/HTTP/Response.php',
        'Core\\Http\\ResponseComplements\\redirectResponse' => __DIR__ . '/../..' . '/core/HTTP/responseComplements/redirectResponse.php',
        'Core\\Http\\Router' => __DIR__ . '/../..' . '/core/HTTP/Router.php',
        'Core\\Http\\Traits\\Renderable' => __DIR__ . '/../..' . '/core/Foundation/traits/RenderableTrait.php',
        'Core\\Http\\Traits\\responseMessages' => __DIR__ . '/../..' . '/core/Foundation/traits/responseMessagesTrait.php',
        'Core\\Support\\Crypto' => __DIR__ . '/../..' . '/core/support/Crypto.php',
        'Core\\Support\\Files\\HandlesImages' => __DIR__ . '/../..' . '/core/support/Files/handlesImages.php',
        'Core\\Support\\Files\\HandlesRequestFiles' => __DIR__ . '/../..' . '/core/support/Files/handlesRequestFiles.php',
        'Core\\Support\\Files\\handlesUploadedFiles' => __DIR__ . '/../..' . '/core/support/Files/handlesUploadedFilesTrait.php',
        'Core\\Support\\Flash' => __DIR__ . '/../..' . '/core/support/Flash.php',
        'Core\\Support\\HttpSanitizer' => __DIR__ . '/../..' . '/core/support/HttpSanitizer.php',
        'Core\\Support\\Validator' => __DIR__ . '/../..' . '/core/support/Validator.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8690bab61c5c73dbf30b1f5c2a28e2cb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8690bab61c5c73dbf30b1f5c2a28e2cb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8690bab61c5c73dbf30b1f5c2a28e2cb::$classMap;

        }, null, ClassLoader::class);
    }
}
