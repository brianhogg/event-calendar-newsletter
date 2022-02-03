<?php

require_once __DIR__ . '/vendor/tareq1988/wp-php-cs-fixer/loader.php';

$finder = PhpCsFixer\Finder::create()
    ->exclude( 'node_modules' )
    ->exclude( 'vendors' )
    ->in( __DIR__ )
;

$rules = WeDevs\Fixer\Fixer::rules();
$rules['array_syntax'] = array( 'syntax' => 'long' );
$rules['binary_operator_spaces'] = array(
    'align_double_arrow' => false,
    'align_equals' => false,
);

$config = PhpCsFixer\Config::create()
    ->registerCustomFixers( array(
        new WeDevs\Fixer\SpaceInsideParenthesisFixer(),
        new WeDevs\Fixer\BlankLineAfterClassOpeningFixer(),
    ) )
    ->setRiskyAllowed( true )
    ->setUsingCache( false )
    ->setRules( $rules )
    ->setFinder( $finder )
;

return $config;
