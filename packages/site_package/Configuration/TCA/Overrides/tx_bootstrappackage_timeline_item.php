<?php
defined('TYPO3') or die('Access denied.');
call_user_func(function () {
    $GLOBALS['TCA']['tt_content']['columns']['tx_bootstrappackage_timeline_item']['config']['foreign_sortby'] = 'sorting';
    $GLOBALS['TCA']['tx_bootstrappackage_timeline_item']['columns']['date']['config']['required'] = FALSE;

    // Add some fields to fe_users table to show TCA fields definitions
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
        'tx_bootstrappackage_timeline_item',
        [
            'subheader' => [
                'exclude' => 0,
                'label' => 'Subheader',
                'config' => [
                    'type' => 'input',
                    'size' => 50,
                    'eval' => 'trim'
                ],
            ],
        ]
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_bootstrappackage_timeline_item',
        'subheader',
        '',
        'after:header'
    );
});
