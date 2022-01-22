<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
return $config
    ->setRules(
        [
            '@Symfony' => true,
            '@PSR2' => true,
            '@PhpCsFixer' => true,
            '@DoctrineAnnotation' => true,
            'ordered_class_elements' => false,
            'no_superfluous_phpdoc_tags' => false,
            'strict_param' => true,
            'array_syntax' => ['syntax' => 'short'],
            'concat_space' => ['spacing' => 'one'],
            'php_unit_test_case_static_method_calls' => ['call_type' => 'self']
        ]
    )
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;
