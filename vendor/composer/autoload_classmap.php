<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'App\\Controllers\\ProductController' => $baseDir . '/app/controllers/ProductController.php',
    'App\\Controllers\\UserController' => $baseDir . '/app/controllers/UserController.php',
    'App\\Models\\Product' => $baseDir . '/app/models/Product.php',
    'App\\Models\\User' => $baseDir . '/app/models/User.php',
    'Bravo\\ORM\\BravoORM' => $vendorDir . '/emilio-bravo/bravo-orm/src/ORM/BravoORM.php',
    'Bravo\\ORM\\DB' => $vendorDir . '/emilio-bravo/bravo-orm/src/Database/DB.php',
    'Bravo\\ORM\\DataHandler' => $vendorDir . '/emilio-bravo/bravo-orm/src/helpers/DataHandler.php',
    'Bravo\\ORM\\DataNotFoundException' => $vendorDir . '/emilio-bravo/bravo-orm/src/exceptions/dataNotFoundException.php',
    'Bravo\\ORM\\ENV\\DatabseEnv' => $vendorDir . '/emilio-bravo/bravo-orm/src/env/DatabaseEnv.php',
    'Bravo\\ORM\\ExceptionInterface' => $vendorDir . '/emilio-bravo/bravo-orm/src/interfaces/ExceptionInterface.php',
    'Bravo\\ORM\\Model' => $vendorDir . '/emilio-bravo/bravo-orm/src/test/model.php',
    'Bravo\\ORM\\Query' => $vendorDir . '/emilio-bravo/bravo-orm/src/Database/query.php',
    'Bravo\\ORM\\QueryFormater' => $vendorDir . '/emilio-bravo/bravo-orm/src/helpers/QueryFormater.php',
    'Bravo\\ORM\\QueryHandler' => $vendorDir . '/emilio-bravo/bravo-orm/src/Database/queryHanlder.php',
    'Bravo\\ORM\\countsResults' => $vendorDir . '/emilio-bravo/bravo-orm/src/traits/countsResultsTrait.php',
    'Bravo\\ORM\\handlesExceptions' => $vendorDir . '/emilio-bravo/bravo-orm/src/traits/handlesExceptionsTrait.php',
    'Bravo\\ORM\\inputSanitizer' => $vendorDir . '/emilio-bravo/bravo-orm/src/helpers/inputSanitizer.php',
    'Bravo\\ORM\\logicQuerys' => $vendorDir . '/emilio-bravo/bravo-orm/src/interfaces/logicQuerysInterface.php',
    'Bravo\\ORM\\noConnectionException' => $vendorDir . '/emilio-bravo/bravo-orm/src/exceptions/noConnectionException.php',
    'Bravo\\ORM\\statementException' => $vendorDir . '/emilio-bravo/bravo-orm/src/exceptions/statementException.php',
    'Bravo\\ORM\\supportsCRUD' => $vendorDir . '/emilio-bravo/bravo-orm/src/interfaces/supportsCRUDInterface.php',
    'Bravo\\ORM\\verifyiesData' => $vendorDir . '/emilio-bravo/bravo-orm/src/traits/veryfiesDataTrait.php',
    'Composer\\InstalledVersions' => $vendorDir . '/composer/InstalledVersions.php',
    'Core\\Client\\Authentification\\Auth' => $baseDir . '/core/client/auth/Auth.php',
    'Core\\Client\\Authentification\\guestsNotAllowed' => $baseDir . '/core/client/auth/guestsNotAllowed.php',
    'Core\\Client\\View' => $baseDir . '/core/client/View.php',
    'Core\\Client\\ViewHelper' => $baseDir . '/core/client/ViewHelper.php',
    'Core\\FileSystems\\Storage' => $baseDir . '/core/FileSystems/Storage.php',
    'Core\\Foundation\\Controller' => $baseDir . '/core/Foundation/Controller.php',
    'Core\\Foundation\\Model' => $baseDir . '/core/Foundation/Model.php',
    'Core\\Foundation\\Traits\\Http\\Renderable' => $baseDir . '/core/Foundation/traits/http/RenderableTrait.php',
    'Core\\Foundation\\Traits\\Http\\canMorphContent' => $baseDir . '/core/Foundation/traits/http/canMorphContent.php',
    'Core\\Foundation\\Traits\\Http\\httpResponses' => $baseDir . '/core/Foundation/traits/http/httpResponses.php',
    'Core\\Foundation\\Traits\\Http\\responseMessages' => $baseDir . '/core/Foundation/traits/http/responseMessagesTrait.php',
    'Core\\Http\\Persistent' => $baseDir . '/core/HTTP/Persistent.php',
    'Core\\Http\\Request' => $baseDir . '/core/HTTP/Request.php',
    'Core\\Http\\Response' => $baseDir . '/core/HTTP/Response.php',
    'Core\\Http\\Router' => $baseDir . '/core/HTTP/Router.php',
    'Core\\Http\\Traits\\Renderable' => $baseDir . '/core/Foundation/traits/RenderableTrait.php',
    'Core\\Http\\Traits\\responseMessages' => $baseDir . '/core/Foundation/traits/responseMessagesTrait.php',
    'Core\\Support\\Crypto' => $baseDir . '/core/support/Crypto.php',
    'Core\\Support\\Files\\HandlesImages' => $baseDir . '/core/support/Files/handlesImages.php',
    'Core\\Support\\Files\\HandlesRequestFiles' => $baseDir . '/core/support/Files/handlesRequestFiles.php',
    'Core\\Support\\Files\\handlesUploadedFiles' => $baseDir . '/core/support/Files/handlesUploadedFilesTrait.php',
    'Core\\Support\\Flash' => $baseDir . '/core/support/Flash.php',
    'Core\\Support\\HttpSanitizer' => $baseDir . '/core/support/HttpSanitizer.php',
    'Core\\Support\\Validator' => $baseDir . '/core/support/Validator.php',
);
