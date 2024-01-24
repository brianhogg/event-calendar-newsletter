<?php

require_once __DIR__ . '/vendor/tareq1988/wp-php-cs-fixer/loader.php';

$finder = PhpCsFixer\Finder::create()
    ->exclude( 'node_modules' )
    ->exclude( 'vendors' )
    ->in( __DIR__ )
;

$rules = WeDevs\Fixer\Fixer::rules();
$rules['binary_operator_spaces'] = [
    'operators' => [
        '=>' => 'single_space',
    ],
];
$rules['no_alternative_syntax'] = ['fix_non_monolithic_code' => false];
$rules['curly_braces_position'] = [
    'functions_opening_brace' => 'same_line',
    'classes_opening_brace' => 'same_line',
];

$config = (new PhpCsFixer\Config())
    ->registerCustomFixers( [
        new WeDevs\Fixer\SpaceInsideParenthesisFixer(),
        new WeDevs\Fixer\BlankLineAfterClassOpeningFixer(),
    ] )
    ->setRiskyAllowed( true )
    ->setUsingCache( false )
    ->setRules( $rules )
    ->setFinder( $finder )
;

return $config;
