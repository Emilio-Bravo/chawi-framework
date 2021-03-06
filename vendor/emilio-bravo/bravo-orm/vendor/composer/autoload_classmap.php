<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Bravo\\ORM\\BravoORM' => $baseDir . '/src/ORM/BravoORM.php',
    'Bravo\\ORM\\DB' => $baseDir . '/src/Database/DB.php',
    'Bravo\\ORM\\DataHandler' => $baseDir . '/src/helpers/DataHandler.php',
    'Bravo\\ORM\\DataNotFoundException' => $baseDir . '/src/exceptions/dataNotFoundException.php',
    'Bravo\\ORM\\ENV\\DatabseEnv' => $baseDir . '/src/env/DatabaseEnv.php',
    'Bravo\\ORM\\ExceptionInterface' => $baseDir . '/src/interfaces/ExceptionInterface.php',
    'Bravo\\ORM\\Model' => $baseDir . '/src/test/model.php',
    'Bravo\\ORM\\Query' => $baseDir . '/src/Database/query.php',
    'Bravo\\ORM\\QueryFormater' => $baseDir . '/src/helpers/QueryFormater.php',
    'Bravo\\ORM\\QueryHandler' => $baseDir . '/src/Database/queryHanlder.php',
    'Bravo\\ORM\\countsResults' => $baseDir . '/src/traits/countsResultsTrait.php',
    'Bravo\\ORM\\handlesExceptions' => $baseDir . '/src/traits/handlesExceptionsTrait.php',
    'Bravo\\ORM\\inputSanitizer' => $baseDir . '/src/helpers/inputSanitizer.php',
    'Bravo\\ORM\\logicQuerys' => $baseDir . '/src/interfaces/logicQuerysInterface.php',
    'Bravo\\ORM\\noConnectionException' => $baseDir . '/src/exceptions/noConnectionException.php',
    'Bravo\\ORM\\statementException' => $baseDir . '/src/exceptions/statementException.php',
    'Bravo\\ORM\\supportsCRUD' => $baseDir . '/src/interfaces/supportsCRUDInterface.php',
    'Bravo\\ORM\\verifyiesData' => $baseDir . '/src/traits/veryfiesDataTrait.php',
    'Composer\\InstalledVersions' => $vendorDir . '/composer/InstalledVersions.php',
);
