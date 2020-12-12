<?php

return [
    'subscription' => [
        'invoice_check' => 1,
        'onboarding' => 2,
        'supplier_verification' => 3,
        'detector_records' => 4,
        'safepay' => 5
    ],
    'menu' => [
        'onboarding' => true,
        'check-invoice' => true,
        'safepay' => true,
        'enterprise' => true,
        'detector' => true,
    ],
    'seo' => [
        'home_page' => [
            'title' => 'SafePay, Check Invoice and fraud detection',
            'description' => 'Is that invoice safe to pay? Is it falsified? Is the account number really to the supplier or will you lose money? We can help you detecting this and we also prevent suppliers that are not approved getting paid.',
            'keywords' => 'safe payment, check invoice, safe pay, check an invoice, document fraud, invoice fraud, supplier verification, safe payments, false invoice, malware, ransomware',
            'author' => 'DeepCheck'
        ],
        'about_us_page' => [
            'title' => 'About Us',
            'description' => 'Is that invoice safe to pay? Is it falsified? Is the account number really to the supplier or will you lose money? We can help you detecting this and we also prevent suppliers that are not approved getting paid.',
            'keywords' => 'safe payment, check invoice, safe pay, check an invoice, document fraud, invoice fraud, supplier verification, safe payments, false invoice, malware, ransomware',
            'author' => 'DeepCheck'
        ],
        'safe_pay_page' => [
            'title' => 'SafePay',
            'description' => 'Is that invoice safe to pay? Is it falsified? Is the account number really to the supplier or will you lose money? We can help you detecting this and we also prevent suppliers that are not approved getting paid.',
            'keywords' => 'safe payment, check invoice, safe pay, check an invoice, document fraud, invoice fraud, supplier verification, safe payments, false invoice, malware, ransomware',
            'author' => 'DeepCheck'
        ],
        'check_invoice_page' => [
            'title' => 'Document, Invoice and Supplier Check',
            'description' => 'Is that invoice safe to pay? Is it falsified? Is the account number really to the supplier or will you lose money? We can help you detecting this and we also prevent suppliers that are not approved getting paid.',
            'keywords' => 'safe payment, check invoice, safe pay, check an invoice, document fraud, invoice fraud, supplier verification, safe payments, false invoice, malware, ransomware',
            'author' => 'DeepCheck'
        ],
        'internal_fraud_page' => [
            'title' => 'Internal Fraud Check',
            'description' => 'Is that invoice safe to pay? Is it falsified? Is the account number really to the supplier or will you lose money? We can help you detecting this and we also prevent suppliers that are not approved getting paid.',
            'keywords' => 'safe payment, check invoice, safe pay, check an invoice, document fraud, invoice fraud, supplier verification, safe payments, false invoice, malware, ransomware',
            'author' => 'DeepCheck'
        ],
        'identity_check_page' => [
            'title' => 'Onboarding',
            'description' => 'Is that invoice safe to pay? Is it falsified? Is the account number really to the supplier or will you lose money? We can help you detecting this and we also prevent suppliers that are not approved getting paid.',
            'keywords' => 'safe payment, check invoice, safe pay, check an invoice, document fraud, invoice fraud, supplier verification, safe payments, false invoice, malware, ransomware',
            'author' => 'DeepCheck'
        ],
        'technology_page' => [
            'title' => 'Technology',
            'description' => 'Is that invoice safe to pay? Is it falsified? Is the account number really to the supplier or will you lose money? We can help you detecting this and we also prevent suppliers that are not approved getting paid.',
            'keywords' => 'safe payment, check invoice, safe pay, check an invoice, document fraud, invoice fraud, supplier verification, safe payments, false invoice, malware, ransomware',
            'author' => 'DeepCheck'
        ],
        'terms_and_condition_page' => [
            'title' => 'Terms And Condition',
            'description' => 'Is that invoice safe to pay? Is it falsified? Is the account number really to the supplier or will you lose money? We can help you detecting this and we also prevent suppliers that are not approved getting paid.',
            'keywords' => 'safe payment, check invoice, safe pay, check an invoice, document fraud, invoice fraud, supplier verification, safe payments, false invoice, malware, ransomware',
            'author' => 'DeepCheck'
        ],
        'privacy_policy_page' => [
            'title' => 'Privacy Policy',
            'description' => 'Is that invoice safe to pay? Is it falsified? Is the account number really to the supplier or will you lose money? We can help you detecting this and we also prevent suppliers that are not approved getting paid.',
            'keywords' => 'safe payment, check invoice, safe pay, check an invoice, document fraud, invoice fraud, supplier verification, safe payments, false invoice, malware, ransomware',
            'author' => 'DeepCheck'
        ]
    ],
    'maintenance' => false,
    'mautic' => [
        'segment' => [
            'login' => 94,
            'signup' => 26,
            'upload-invoice' => 38,
            'dashboard' => 83,
            'setting' => 93,
            'invoice' => 84,
            'supplier' => 85,
            'detector' => 86,
            'detector-check-accounting' => 87,
            'safepay' => 88,
            'enterprise' => 89,
            'onboarding' => 90,
            'onboarding-invite-customer' => 91
        ],
        'stages' => [            
            'notLoggedIn' => 24,
            'firstTimeLogin' => 25,
            'registered' => 3,
        ]
    ]
];
