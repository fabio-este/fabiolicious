<?php
defined('TYPO3') or die('Access denied.');
call_user_func(function () {

    // Add some fields to fe_users table to show TCA fields definitions
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
        'tx_bootstrappackage_card_group_item',
        [
            'price' => [
                'exclude' => 0,
                'label' => 'Price',
                'config' => [
                    'type' => 'input',
                    'size' => 50,
                    'eval' => 'trim'
                ],
            ],
        ]
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_bootstrappackage_card_group_item',
        'price',
        '',
        'after:link_title'
    );
});
