<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'App\\Controllers\\ImageController' => $baseDir . '/app/controllers/ImageController.php',
    'App\\Controllers\\ProductController' => $baseDir . '/app/controllers/ProductController.php',
    'App\\Controllers\\UserController' => $baseDir . '/app/controllers/UserController.php',
    'App\\Http\\Kernel' => $baseDir . '/app/Http/Kernel.php',
    'App\\Middlewares\\AuthMiddleware' => $baseDir . '/app/middlewares/AuthMiddleware.php',
    'App\\Middlewares\\TestMiddleware' => $baseDir . '/app/middlewares/TestMiddleware.php',
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
    'Core\\Client\\Authentification\\AuthenticatesUsers' => $baseDir . '/core/client/auth/AuthenticatesUsersTrait.php',
    'Core\\Client\\Authentification\\createsUsers' => $baseDir . '/core/client/auth/createsUsersTrait.php',
    'Core\\Client\\Authentification\\guestsNotAllowed' => $baseDir . '/core/client/auth/guestsNotAllowed.php',
    'Core\\Client\\Authentification\\hashesPasswords' => $baseDir . '/core/client/auth/hashesPasswords.php',
    'Core\\Client\\View' => $baseDir . '/core/client/View.php',
    'Core\\Client\\ViewHelper' => $baseDir . '/core/client/ViewHelper.php',
    'Core\\Config\\Support\\InteractsWithConfig' => $baseDir . '/core/config/support/interactsWithConfig.php',
    'Core\\Config\\Support\\interactsWithAuthConfig' => $baseDir . '/core/config/support/interactsWithAuthConfigTrait.php',
    'Core\\Config\\Support\\interactsWithPathSettings' => $baseDir . '/core/config/support/interactsWithPathSettingsTrait.php',
    'Core\\Config\\Support\\interactsWithValidatorConfig' => $baseDir . '/core/config/support/interactsWithValidatorConfigTrait.php',
    'Core\\Config\\Support\\interactsWithViewDependencies' => $baseDir . '/core/config/support/interactsWithViewDependenciesTrait.php',
    'Core\\Contracts\\FacadeContract' => $baseDir . '/core/contracts/FacadeContract.php',
    'Core\\Contracts\\Hashing\\HasherContract' => $baseDir . '/core/contracts/Hashing/HasherContract.php',
    'Core\\Contracts\\Http\\CookieContract' => $baseDir . '/core/contracts/HTTP/CookieContract.php',
    'Core\\Contracts\\Http\\MiddlewareContract' => $baseDir . '/core/contracts/HTTP/MiddlewareContract.php',
    'Core\\FileSystems\\FileSystem' => $baseDir . '/core/FileSystems/FileSystem.php',
    'Core\\Foundation\\Controller' => $baseDir . '/core/Foundation/Controller.php',
    'Core\\Foundation\\Model' => $baseDir . '/core/Foundation/Model.php',
    'Core\\Foundation\\Traits\\Http\\Renderable' => $baseDir . '/core/Foundation/traits/http/RenderableTrait.php',
    'Core\\Foundation\\Traits\\Http\\canMorphContent' => $baseDir . '/core/Foundation/traits/http/canMorphContent.php',
    'Core\\Foundation\\Traits\\Http\\httpResponses' => $baseDir . '/core/Foundation/traits/http/httpResponses.php',
    'Core\\Foundation\\Traits\\Http\\responseMessages' => $baseDir . '/core/Foundation/traits/http/responseMessagesTrait.php',
    'Core\\Hashing\\AbstractHasher' => $baseDir . '/core/Hashing/AbstractHasher.php',
    'Core\\Hashing\\Argon2IdHasher' => $baseDir . '/core/Hashing/Argon2IdHasher.php',
    'Core\\Hashing\\ArgonHasher' => $baseDir . '/core/Hashing/ArgonHasher.php',
    'Core\\Hashing\\BcryptHasher' => $baseDir . '/core/Hashing/BcryptHasher.php',
    'Core\\Http\\Complements\\AbstractCookie' => $baseDir . '/core/HTTP/complements/AbstractCookie.php',
    'Core\\Http\\Complements\\BinaryFileResponse' => $baseDir . '/core/HTTP/complements/BinaryFileResponse.php',
    'Core\\Http\\Complements\\DownloadResponse' => $baseDir . '/core/HTTP/complements/DownloadResponse.php',
    'Core\\Http\\Complements\\StoredFile' => $baseDir . '/core/HTTP/complements/StoredFile.php',
    'Core\\Http\\Cookie' => $baseDir . '/core/HTTP/Cookie.php',
    'Core\\Http\\Files' => $baseDir . '/core/HTTP/Files.php',
    'Core\\Http\\HeaderHelper' => $baseDir . '/core/HTTP/HeaderHelper.php',
    'Core\\Http\\Kernel' => $baseDir . '/core/HTTP/Kernel.php',
    'Core\\Http\\Middleware\\Middleware' => $baseDir . '/core/middleware/Middleware.php',
    'Core\\Http\\Persistent' => $baseDir . '/core/HTTP/Persistent.php',
    'Core\\Http\\Request' => $baseDir . '/core/HTTP/Request.php',
    'Core\\Http\\RequestComplements\\UploadedFile' => $baseDir . '/core/HTTP/requestComplements/UploadedFile.php',
    'Core\\Http\\Response' => $baseDir . '/core/HTTP/Response.php',
    'Core\\Http\\ResponseComplements\\HeaderBag' => $baseDir . '/core/HTTP/responseComplements/headerBag.php',
    'Core\\Http\\ResponseComplements\\UrlRedirectResponse' => $baseDir . '/core/HTTP/responseComplements/UrlRedirectResponse.php',
    'Core\\Http\\ResponseComplements\\redirectResponse' => $baseDir . '/core/HTTP/responseComplements/redirectResponse.php',
    'Core\\Http\\Routing\\MethodParamBag' => $baseDir . '/core/HTTP/routing/MethodParamBag.php',
    'Core\\Http\\Routing\\RouteHandler' => $baseDir . '/core/HTTP/routing/RouteHandler.php',
    'Core\\Http\\Routing\\RouteHelper' => $baseDir . '/core/HTTP/routing/RouteHelper.php',
    'Core\\Http\\Routing\\RouteMethodParams' => $baseDir . '/core/HTTP/routing/RouteMethodParams.php',
    'Core\\Http\\Routing\\RouteParams' => $baseDir . '/core/HTTP/routing/RouteParams.php',
    'Core\\Http\\Routing\\RouteUriParams' => $baseDir . '/core/HTTP/routing/RouteUriParams.php',
    'Core\\Http\\Routing\\Router' => $baseDir . '/core/HTTP/routing/Router.php',
    'Core\\Http\\Routing\\UriParamBag' => $baseDir . '/core/HTTP/routing/UriParamBag.php',
    'Core\\Http\\Server' => $baseDir . '/core/HTTP/Server.php',
    'Core\\Http\\Traits\\Renderable' => $baseDir . '/core/Foundation/traits/RenderableTrait.php',
    'Core\\Support\\Crypto' => $baseDir . '/core/support/Crypto.php',
    'Core\\Support\\Facades\\Facade' => $baseDir . '/core/Facades/Facade.php',
    'Core\\Support\\Facades\\Flash' => $baseDir . '/core/Facades/Flash.php',
    'Core\\Support\\Facades\\Storage' => $baseDir . '/core/Facades/Storage.php',
    'Core\\Support\\Files\\HandlesImages' => $baseDir . '/core/support/Files/handlesImages.php',
    'Core\\Support\\Files\\HandlesRequestFiles' => $baseDir . '/core/support/Files/handlesRequestFiles.php',
    'Core\\Support\\Files\\handlesUploadedFiles' => $baseDir . '/core/support/Files/handlesUploadedFilesTrait.php',
    'Core\\Support\\Flash' => $baseDir . '/core/support/Flash.php',
    'Core\\Support\\Formating\\Carbon' => $baseDir . '/core/support/formating/Carbon.php',
    'Core\\Support\\Formating\\MsgParser' => $baseDir . '/core/support/formating/MsgParser.php',
    'Core\\Support\\Formating\\Str' => $baseDir . '/core/support/formating/Str.php',
    'Core\\Support\\HttpSanitizer' => $baseDir . '/core/support/HttpSanitizer.php',
    'Core\\Support\\Validation\\ErrorBag' => $baseDir . '/core/support/validation/ErrorBag.php',
    'Core\\Support\\Validation\\Validator' => $baseDir . '/core/support/validation/Validator.php',
);
