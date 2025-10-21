<?php
// MANUAL AUTOLOADER FOR: vlucas/phpdotenv v5.6.2

// Interfaces
require_once __DIR__ . '/vlucas/phpdotenv/src/Repository/RepositoryInterface.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Repository/Adapter/ReaderInterface.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Repository/Adapter/WriterInterface.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Repository/Adapter/AdapterInterface.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Store/StoreInterface.php';

// Core classes
require_once __DIR__ . '/vlucas/phpdotenv/src/Dotenv.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Repository/RepositoryBuilder.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Repository/AdapterRepository.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Repository/Adapter/EnvConstAdapter.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Repository/Adapter/PutenvAdapter.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Repository/Adapter/ServerConstAdapter.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Repository/Adapter/MultiReader.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Repository/Adapter/MultiWriter.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Repository/Adapter/ImmutableWriter.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Store/FileStore.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Store/StoreBuilder.php';

// Parser
require_once __DIR__ . '/vlucas/phpdotenv/src/Parser/ParserInterface.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Parser/Parser.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Parser/Lines.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Parser/EntryParser.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Parser/Lexer.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Parser/Value.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Parser/Entry.php';

// Loader classes (folder-based)
require_once __DIR__ . '/vlucas/phpdotenv/src/Loader/LoaderInterface.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Loader/Loader.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Loader/Resolver.php';

// Store\File classes (new in v5.6.x)
require_once __DIR__ . '/vlucas/phpdotenv/src/Store/File/Paths.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Store/File/Reader.php';

// Utility
require_once __DIR__ . '/vlucas/phpdotenv/src/Util/Str.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Util/Regex.php';

// Validator
require_once __DIR__ . '/vlucas/phpdotenv/src/Validator.php';

// Exceptions
require_once __DIR__ . '/vlucas/phpdotenv/src/Exception/ExceptionInterface.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Exception/InvalidPathException.php';
require_once __DIR__ . '/vlucas/phpdotenv/src/Exception/ValidationException.php';

// PhpOption dependency (vlucas/phpdotenv requires phpoption/phpoption v1.8.1, from https://github.com/schmittjoh/php-option). More specifically, they are required by ServerConstAdapter
require_once __DIR__ . '/phpoption/phpoption/src/PhpOption/Option.php';
require_once __DIR__ . '/phpoption/phpoption/src/PhpOption/None.php';
require_once __DIR__ . '/phpoption/phpoption/src/PhpOption/Some.php';

// GrahamCampbell dependency (vlucas/phpdotenv requires graham-campbell/result-type v1.0.4, from https://github.com/GrahamCampbell/Result-Type). It is required by Dotenv\Util\Str
require_once __DIR__ . '/graham-campbell/result-type/src/Result.php';
require_once __DIR__ . '/graham-campbell/result-type/src/Error.php';
require_once __DIR__ . '/graham-campbell/result-type/src/Success.php';

// End of manual autoloader for vlucas/phpdotenv