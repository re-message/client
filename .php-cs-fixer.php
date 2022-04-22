<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->append([__FILE__])
    ->exclude('vendor')
    ->notPath('src/Model/CodeMethod.php')
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
