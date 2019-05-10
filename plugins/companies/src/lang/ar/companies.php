<?php

return [

    'companies' => 'منشأت',
    'company' => 'منشأة',
    'add_new' => 'أضف منشأة جديد',
    'edit' => 'تحرير المنشأة',
    'back_to_companies' => 'العودة إلى منشأت',
    'no_records' => 'لا يوجد شركات',
    'save_company' => 'حفظ المنشأة',
    'search' => 'البحث',
    'search_companies' => 'البحث فى منشأت',
    'per_page' => 'لكل صفحة',
    'bulk_actions' => 'اختر أمر',
    'delete' => 'حذف',
    'apply' => 'حفظ',
    'page' => 'الصفحة',
    'of' => 'من',
    'order' => 'ترتيب',
    'sort_by' => 'ترتيب حسب',
    'asc' => 'تضاعدى',
    'desc' => 'تنازلى',
    'for'=>'ل',
    'actions' => 'الأمر',
    'current_points'=>'الرصيد الحالى',
    'add_points'=>'النقاط المدفوعة',
    'transactions'=>'العمليات المالية',
    'filter' => 'عرض',
    'parent_company' => 'قسم رئيسى',
    'language' => 'اللغة',
    'sure_delete' => 'هل أنت متأكد من الحذف ؟',
    'show_children' => 'عرض الأقسام الفرعية',
    'change_image' => 'تغيير الصورة',
    'logo' => 'اللوجو التجاري',
    'files' => 'المرفقات',
    'not_allowed_file' => 'ملف غير مسموح به',
    'add_sector' => "أضف قطاعات",
    'blocked' => 'حذر',
    'unblocked' => 'غير محذور',
    'status' => [
        0 => 'قيد المراجعة',
        1 => 'تم القبول',
        2 => 'تم الرفض'
    ],

    'attributes' => [
        'name' => 'إسم المنشأة',
        'transaction_id'=>'رقم العملية',
        'first_name' => 'الإسم الأول',
        'last_name' => 'الإسم الثاني',
        'user_trans'=>'المستخدم',
        'parent' => 'القسم الرئيسى',
        'created_at' => 'تاريخ الإضافة',
        'user' => 'الكاتب',
        'status' => 'الحالة',
        'block' => 'حذر',
        'block_reason' => 'سبب الحذر',
        'blocked'=>'الحذر',
        'points'=>'النقاط'
    ],
    'transaction_no_records'=>'لايوجد عمليات ',
    "events" => [
        'created' => 'تم إنشاء منشأة بنجاح',
        'updated' => 'تم حفظ المنشأة بنجاح',
        'deleted' => 'تم الحذف بنجاح',

    ],
    "permissions" => [
        "manage" => "التحكم بمنشأت",
        "transactions"=>'مشاهدة العمليات الحسابية'
    ]

];
