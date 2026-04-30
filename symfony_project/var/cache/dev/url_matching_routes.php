<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/produits/categories' => [[['_route' => 'app_produit_category_index', '_controller' => 'App\\Controller\\ProduitController::categoryIndex'], null, ['GET' => 0], null, false, false, null]],
        '/produits/categories/new' => [[['_route' => 'app_produit_category_new', '_controller' => 'App\\Controller\\ProduitController::categoryNew'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/admin/access' => [[['_route' => 'admin_access_index', '_controller' => 'App\\Controller\\Admin\\AccessAdminController::index'], null, null, null, false, false, null]],
        '/admin/access/update' => [[['_route' => 'admin_access_update', '_controller' => 'App\\Controller\\Admin\\AccessAdminController::update'], null, ['POST' => 0], null, false, false, null]],
        '/admin/access/role/add' => [[['_route' => 'admin_access_role_add', '_controller' => 'App\\Controller\\Admin\\AccessAdminController::addRole'], null, ['POST' => 0], null, false, false, null]],
        '/admin/access/magasin/add' => [[['_route' => 'admin_access_magasin_add', '_controller' => 'App\\Controller\\Admin\\AccessAdminController::addMagasin'], null, ['POST' => 0], null, false, false, null]],
        '/admin/commandes' => [[['_route' => 'admin_commandes_index', '_controller' => 'App\\Controller\\Admin\\CommandeAdminController::index'], null, null, null, false, false, null]],
        '/admin/commandes/ajax' => [[['_route' => 'admin_commandes_ajax', '_controller' => 'App\\Controller\\Admin\\CommandeAdminController::ajax'], null, ['GET' => 0], null, false, false, null]],
        '/admin/shortcuts' => [[['_route' => 'admin_shortcuts_index', '_controller' => 'App\\Controller\\Admin\\ShortcutController::index'], null, null, null, true, false, null]],
        '/admin/shortcuts/new' => [[['_route' => 'admin_shortcuts_new', '_controller' => 'App\\Controller\\Admin\\ShortcutController::new'], null, ['POST' => 0], null, false, false, null]],
        '/admin/users' => [[['_route' => 'admin_users_index', '_controller' => 'App\\Controller\\Admin\\UserAdminController::index'], null, null, null, false, false, null]],
        '/admin/users/new' => [[['_route' => 'admin_users_new', '_controller' => 'App\\Controller\\Admin\\UserAdminController::new'], null, null, null, false, false, null]],
        '/agenda' => [[['_route' => 'app_agenda', '_controller' => 'App\\Controller\\AgendaController::index'], null, null, null, false, false, null]],
        '/agenda/export/pdf' => [[['_route' => 'app_agenda_export_pdf', '_controller' => 'App\\Controller\\AgendaController::exportPdf'], null, ['GET' => 0], null, false, false, null]],
        '/agenda/export/detailed-report' => [[['_route' => 'app_agenda_export_detailed_report', '_controller' => 'App\\Controller\\AgendaController::exportDetailedReport'], null, ['GET' => 0], null, false, false, null]],
        '/agenda/export/calendar' => [[['_route' => 'app_agenda_export_calendar', '_controller' => 'App\\Controller\\AgendaController::exportCalendarPdf'], null, ['GET' => 0], null, false, false, null]],
        '/agenda/api/events' => [[['_route' => 'app_agenda_api_events', '_controller' => 'App\\Controller\\AgendaController::getEvents'], null, ['GET' => 0], null, false, false, null]],
        '/agenda/api/save' => [[['_route' => 'app_agenda_api_save', '_controller' => 'App\\Controller\\AgendaController::saveEvent'], null, ['POST' => 0], null, false, false, null]],
        '/agenda/api/duplicate-week' => [[['_route' => 'app_agenda_api_duplicate_week', '_controller' => 'App\\Controller\\AgendaController::duplicateWeek'], null, ['POST' => 0], null, false, false, null]],
        '/agenda/api/week-lock/status' => [[['_route' => 'app_agenda_api_week_lock_status', '_controller' => 'App\\Controller\\AgendaController::getWeekLockStatus'], null, ['GET' => 0], null, false, false, null]],
        '/agenda/api/week-lock/toggle' => [[['_route' => 'app_agenda_api_week_lock_toggle', '_controller' => 'App\\Controller\\AgendaController::toggleWeekLock'], null, ['POST' => 0], null, false, false, null]],
        '/cart' => [[['_route' => 'app_cart_index', '_controller' => 'App\\Controller\\CartController::index'], null, null, null, false, false, null]],
        '/cart/checkout' => [[['_route' => 'app_cart_checkout', '_controller' => 'App\\Controller\\CartController::checkout'], null, ['POST' => 0], null, false, false, null]],
        '/commande/new' => [[['_route' => 'app_commande_new', '_controller' => 'App\\Controller\\CommandeController::new'], null, null, null, false, false, null]],
        '/commande/my' => [[['_route' => 'app_commande_my', '_controller' => 'App\\Controller\\CommandeController::my'], null, null, null, false, false, null]],
        '/dashboard' => [[['_route' => 'app_dashboard', '_controller' => 'App\\Controller\\DashboardController::index'], null, null, null, false, false, null]],
        '/documents' => [[['_route' => 'app_document_index', '_controller' => 'App\\Controller\\DocumentController::index'], null, ['GET' => 0], null, true, false, null]],
        '/documents/admin/new' => [[['_route' => 'app_document_new', '_controller' => 'App\\Controller\\DocumentController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/admin/document-folder/new' => [[['_route' => 'app_document_folder_new', '_controller' => 'App\\Controller\\DocumentFolderController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/home' => [[['_route' => 'app_home', '_controller' => 'App\\Controller\\HomeController::index'], null, null, null, false, false, null]],
        '/maintenance/signalement' => [[['_route' => 'app_maintenance_signalement', '_controller' => 'App\\Controller\\MaintenanceController::signalement'], null, ['GET' => 0], null, false, false, null]],
        '/maintenance/suivi' => [[['_route' => 'app_maintenance_suivi', '_controller' => 'App\\Controller\\MaintenanceController::suivi'], null, ['GET' => 0], null, false, false, null]],
        '/maintenance/suivi/new' => [[['_route' => 'app_maintenance_suivi_new', '_controller' => 'App\\Controller\\MaintenanceController::suiviNew'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/notifications' => [[['_route' => 'app_notifications_index', '_controller' => 'App\\Controller\\NotificationController::index'], null, null, null, false, false, null]],
        '/notifications/mark-all-read' => [[['_route' => 'app_notification_mark_all_read', '_controller' => 'App\\Controller\\NotificationController::markAllRead'], null, ['POST' => 0], null, false, false, null]],
        '/rh/documents' => [[['_route' => 'app_rh_documents', '_controller' => 'App\\Controller\\PortalDocumentController::index'], null, null, null, false, false, null]],
        '/rh/documents/save-director-signature' => [[['_route' => 'app_rh_document_save_director_signature', '_controller' => 'App\\Controller\\PortalDocumentController::saveDirectorSignature'], null, ['POST' => 0], null, false, false, null]],
        '/rh/documents/send' => [[['_route' => 'app_rh_document_send', '_controller' => 'App\\Controller\\PortalDocumentController::sendDocument'], null, ['POST' => 0], null, false, false, null]],
        '/rh/documents/fix-python-env' => [[['_route' => 'app_rh_document_fix_python_env', '_controller' => 'App\\Controller\\PortalDocumentController::fixPythonEnv'], null, null, null, false, false, null]],
        '/produits' => [[['_route' => 'app_produit_index', '_controller' => 'App\\Controller\\ProduitController::index'], null, ['GET' => 0], null, false, false, null]],
        '/produits/new' => [[['_route' => 'app_produit_new', '_controller' => 'App\\Controller\\ProduitController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/rh/conge' => [[['_route' => 'app_rh_conge', '_controller' => 'App\\Controller\\RHController::congeDashboard'], null, null, null, false, false, null]],
        '/rh/conge/ask' => [[['_route' => 'app_rh_conge_ask', '_controller' => 'App\\Controller\\RHController::askConge'], null, ['POST' => 0], null, false, false, null]],
        '/rh/report/check' => [[['_route' => 'app_rh_report_check', '_controller' => 'App\\Controller\\RHController::checkReport'], null, ['POST' => 0], null, false, false, null]],
        '/rh/report/generate' => [[['_route' => 'app_rh_report_generate', '_controller' => 'App\\Controller\\RHController::generateReport'], null, null, null, false, false, null]],
        '/rh/valider-mes-heures' => [[['_route' => 'app_rh_validation', '_controller' => 'App\\Controller\\RHController::validateHours'], null, null, null, false, false, null]],
        '/rh/validation/toggle-unlock' => [[['_route' => 'app_rh_validation_unlock', '_controller' => 'App\\Controller\\RHController::toggleUnlockSignature'], null, ['POST' => 0], null, false, false, null]],
        '/rh/valider-mes-heures/sign' => [[['_route' => 'app_rh_validation_sign', '_controller' => 'App\\Controller\\RHController::signHours'], null, ['POST' => 0], null, false, false, null]],
        '/notifications/mark-as-read' => [[['_route' => 'app_notifications_mark_read', '_controller' => 'App\\Controller\\RHController::markNotificationsRead'], null, ['POST' => 0], null, false, false, null]],
        '/rh/validation/reset' => [[['_route' => 'app_rh_validation_reset', '_controller' => 'App\\Controller\\RHController::resetValidationSignature'], null, ['POST' => 0], null, false, false, null]],
        '/rh/validation/api/hours' => [[['_route' => 'app_rh_validation_api_hours', '_controller' => 'App\\Controller\\RHController::getEmployeeHoursApi'], null, ['GET' => 0], null, false, false, null]],
        '/rh/validation/remind' => [[['_route' => 'app_rh_validation_remind', '_controller' => 'App\\Controller\\RHController::remindEmployeeSignature'], null, ['POST' => 0], null, false, false, null]],
        '/rh/validation/missing-list' => [[['_route' => 'app_rh_validation_missing_list', '_controller' => 'App\\Controller\\RHController::missingListSignature'], null, ['GET' => 0], null, false, false, null]],
        '/rh/conge/api/employees' => [[['_route' => 'app_rh_conge_api_employees', '_controller' => 'App\\Controller\\RHController::congeApiEmployees'], null, null, null, false, false, null]],
        '/rh/conge/api/list' => [[['_route' => 'app_rh_conge_api_list', '_controller' => 'App\\Controller\\RHController::congeApiList'], null, null, null, false, false, null]],
        '/rh/conge/rapports' => [[['_route' => 'app_rh_conge_print_tool', '_controller' => 'App\\Controller\\RHController::congePrintTool'], null, null, null, false, false, null]],
        '/register' => [[['_route' => 'app_register', '_controller' => 'App\\Controller\\RegistrationController::register'], null, null, null, false, false, null]],
        '/' => [[['_route' => 'app_login', '_controller' => 'App\\Controller\\SecurityController::login'], null, null, null, false, false, null]],
        '/logout' => [[['_route' => 'app_logout', '_controller' => 'App\\Controller\\SecurityController::logout'], null, null, null, false, false, null]],
        '/settings' => [[['_route' => 'app_settings', '_controller' => 'App\\Controller\\SettingsController::index'], null, null, null, false, false, null]],
        '/contact/olivet' => [[['_route' => 'app_contact_olivet', '_controller' => 'App\\Controller\\StaticPageController::olivet'], null, null, null, false, false, null]],
        '/contact/st-gervais' => [[['_route' => 'app_contact_st_gervais', '_controller' => 'App\\Controller\\StaticPageController::stGervais'], null, null, null, false, false, null]],
        '/contact/villemandeur' => [[['_route' => 'app_contact_villemandeur', '_controller' => 'App\\Controller\\StaticPageController::villemandeur'], null, null, null, false, false, null]],
        '/contact/saran' => [[['_route' => 'app_contact_saran', '_controller' => 'App\\Controller\\StaticPageController::saran'], null, null, null, false, false, null]],
        '/contact/noyers' => [[['_route' => 'app_contact_noyers', '_controller' => 'App\\Controller\\StaticPageController::noyers'], null, null, null, false, false, null]],
        '/transport-logistique' => [[['_route' => 'app_transport_logistique', '_controller' => 'App\\Controller\\TransportLogistiqueController::index'], null, ['GET' => 0], null, false, false, null]],
        '/transport-logistique/new' => [[['_route' => 'app_transport_logistique_new', '_controller' => 'App\\Controller\\TransportLogistiqueController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/transport-logistique/report' => [[['_route' => 'app_transport_logistique_report', '_controller' => 'App\\Controller\\TransportLogistiqueController::reportPdf'], null, ['GET' => 0], null, false, false, null]],
        '/transport-logistique/camions' => [[['_route' => 'app_transport_logistique_camion_index', '_controller' => 'App\\Controller\\TransportLogistiqueController::camionIndex'], null, ['GET' => 0], null, false, false, null]],
        '/transport-logistique/camions/new' => [[['_route' => 'app_transport_logistique_camion_new', '_controller' => 'App\\Controller\\TransportLogistiqueController::camionNew'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/user-observations' => [[['_route' => 'app_user_observations_index', '_controller' => 'App\\Controller\\UserObservationController::index'], null, ['GET' => 0], null, true, false, null]],
        '/user-observations/update' => [[['_route' => 'app_user_observations_update', '_controller' => 'App\\Controller\\UserObservationController::update'], null, ['POST' => 0], null, false, false, null]],
        '/user-observations/lock' => [[['_route' => 'app_user_observations_lock', '_controller' => 'App\\Controller\\UserObservationController::toggleLock'], null, ['POST' => 0], null, false, false, null]],
        '/user-observations/check-lock' => [[['_route' => 'app_user_observations_check_lock', '_controller' => 'App\\Controller\\UserObservationController::checkLock'], null, ['GET' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/produits/(?'
                    .'|categories/([^/]++)/(?'
                        .'|edit(*:47)'
                        .'|delete(*:60)'
                    .')'
                    .'|([^/]++)(?'
                        .'|/(?'
                            .'|edit(*:87)'
                            .'|delete(*:100)'
                        .')'
                        .'|(*:109)'
                    .')'
                .')'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:147)'
                .'|/a(?'
                    .'|dmin/(?'
                        .'|access/(?'
                            .'|role/(?'
                                .'|edit/([^/]++)(*:199)'
                                .'|delete/([^/]++)(*:222)'
                            .')'
                            .'|magasin/(?'
                                .'|edit/([^/]++)(*:255)'
                                .'|delete/([^/]++)(*:278)'
                            .')'
                        .')'
                        .'|commandes/([^/]++)(?'
                            .'|(*:309)'
                            .'|/(?'
                                .'|update\\-item/([^/]++)(*:342)'
                                .'|receipt(*:357)'
                            .')'
                        .')'
                        .'|shortcuts/(?'
                            .'|edit/([^/]++)(*:393)'
                            .'|delete/([^/]++)(*:416)'
                        .')'
                        .'|users/([^/]++)/(?'
                            .'|edit(*:447)'
                            .'|delete(*:461)'
                            .'|activate(*:477)'
                        .')'
                        .'|document\\-folder/([^/]++)(?'
                            .'|/edit(*:519)'
                            .'|(*:527)'
                        .')'
                    .')'
                    .'|genda/api/(?'
                        .'|delete/([^/]++)(*:565)'
                        .'|u(?'
                            .'|pdate/([^/]++)(*:591)'
                            .'|ser\\-color/([^/]++)(*:618)'
                        .')'
                    .')'
                .')'
                .'|/c(?'
                    .'|art/(?'
                        .'|add/([^/]++)(*:653)'
                        .'|remove/([^/]++)(*:676)'
                        .'|update/([^/]++)(*:699)'
                    .')'
                    .'|ommande/([^/]++)(*:724)'
                .')'
                .'|/documents/(?'
                    .'|admin/([^/]++)(?'
                        .'|/edit(*:769)'
                        .'|(*:777)'
                    .')'
                    .'|download/([^/]++)(*:803)'
                .')'
                .'|/m(?'
                    .'|aintenance/suivi/([^/]++)(?'
                        .'|(*:845)'
                        .'|/(?'
                            .'|edit(*:861)'
                            .'|approve(*:876)'
                            .'|delete(*:890)'
                        .')'
                    .')'
                    .'|edia/(?'
                        .'|user/([^/]++)(*:921)'
                        .'|product/([^/]++)(*:945)'
                        .'|shortcut/([^/]++)(*:970)'
                    .')'
                .')'
                .'|/notifications/mark\\-read/([^/]++)(*:1014)'
                .'|/rh/(?'
                    .'|documents/(?'
                        .'|s(?'
                            .'|tream/([^/]++)(*:1061)'
                            .'|ign/([^/]++)(*:1082)'
                        .')'
                        .'|delete/([^/]++)(*:1107)'
                    .')'
                    .'|conge/(?'
                        .'|admin\\-action/([^/]++)(*:1148)'
                        .'|employee\\-action/([^/]++)(*:1182)'
                        .'|pdf/([^/]++)(*:1203)'
                    .')'
                    .'|valider\\-mes\\-heures/download/([^/]++)(*:1251)'
                .')'
                .'|/transport\\-logistique/(?'
                    .'|([^/]++)/(?'
                        .'|edit(*:1303)'
                        .'|delete(*:1318)'
                    .')'
                    .'|camions/([^/]++)/(?'
                        .'|edit(*:1352)'
                        .'|delete(*:1367)'
                    .')'
                .')'
                .'|/user\\-observations/delete/([^/]++)(*:1413)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        47 => [[['_route' => 'app_produit_category_edit', '_controller' => 'App\\Controller\\ProduitController::categoryEdit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        60 => [[['_route' => 'app_produit_category_delete', '_controller' => 'App\\Controller\\ProduitController::categoryDelete'], ['id'], ['POST' => 0], null, false, false, null]],
        87 => [[['_route' => 'app_produit_edit', '_controller' => 'App\\Controller\\ProduitController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        100 => [[['_route' => 'app_produit_delete', '_controller' => 'App\\Controller\\ProduitController::delete'], ['id'], ['POST' => 0], null, false, false, null]],
        109 => [[['_route' => 'app_produit_show', '_controller' => 'App\\Controller\\ProduitController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        147 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        199 => [[['_route' => 'admin_access_role_edit', '_controller' => 'App\\Controller\\Admin\\AccessAdminController::editRole'], ['id'], ['POST' => 0], null, false, true, null]],
        222 => [[['_route' => 'admin_access_role_delete', '_controller' => 'App\\Controller\\Admin\\AccessAdminController::deleteRole'], ['id'], ['POST' => 0, 'DELETE' => 1], null, false, true, null]],
        255 => [[['_route' => 'admin_access_magasin_edit', '_controller' => 'App\\Controller\\Admin\\AccessAdminController::editMagasin'], ['id'], ['POST' => 0], null, false, true, null]],
        278 => [[['_route' => 'admin_access_magasin_delete', '_controller' => 'App\\Controller\\Admin\\AccessAdminController::deleteMagasin'], ['id'], ['POST' => 0, 'DELETE' => 1], null, false, true, null]],
        309 => [[['_route' => 'admin_commandes_show', '_controller' => 'App\\Controller\\Admin\\CommandeAdminController::show'], ['id'], null, null, false, true, null]],
        342 => [[['_route' => 'admin_commandes_update_item', '_controller' => 'App\\Controller\\Admin\\CommandeAdminController::updateItem'], ['id', 'itemId'], ['POST' => 0], null, false, true, null]],
        357 => [[['_route' => 'admin_commandes_receipt', '_controller' => 'App\\Controller\\Admin\\CommandeAdminController::receipt'], ['id'], null, null, false, false, null]],
        393 => [[['_route' => 'admin_shortcuts_edit', '_controller' => 'App\\Controller\\Admin\\ShortcutController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, true, null]],
        416 => [[['_route' => 'admin_shortcuts_delete', '_controller' => 'App\\Controller\\Admin\\ShortcutController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        447 => [[['_route' => 'admin_users_edit', '_controller' => 'App\\Controller\\Admin\\UserAdminController::edit'], ['id'], null, null, false, false, null]],
        461 => [[['_route' => 'admin_users_delete', '_controller' => 'App\\Controller\\Admin\\UserAdminController::delete'], ['id'], ['POST' => 0], null, false, false, null]],
        477 => [[['_route' => 'admin_users_activate', '_controller' => 'App\\Controller\\Admin\\UserAdminController::activate'], ['id'], ['POST' => 0], null, false, false, null]],
        519 => [[['_route' => 'app_document_folder_edit', '_controller' => 'App\\Controller\\DocumentFolderController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        527 => [[['_route' => 'app_document_folder_delete', '_controller' => 'App\\Controller\\DocumentFolderController::delete'], ['id'], ['POST' => 0, 'DELETE' => 1], null, false, true, null]],
        565 => [[['_route' => 'app_agenda_api_delete', '_controller' => 'App\\Controller\\AgendaController::deleteEvent'], ['id'], ['DELETE' => 0], null, false, true, null]],
        591 => [[['_route' => 'app_agenda_api_update', '_controller' => 'App\\Controller\\AgendaController::updateEvent'], ['id'], ['POST' => 0], null, false, true, null]],
        618 => [[['_route' => 'app_agenda_api_user_color', '_controller' => 'App\\Controller\\AgendaController::updateUserColor'], ['id'], ['POST' => 0], null, false, true, null]],
        653 => [[['_route' => 'app_cart_add', '_controller' => 'App\\Controller\\CartController::add'], ['id'], ['POST' => 0], null, false, true, null]],
        676 => [[['_route' => 'app_cart_remove', '_controller' => 'App\\Controller\\CartController::remove'], ['id'], ['POST' => 0], null, false, true, null]],
        699 => [[['_route' => 'app_cart_update', '_controller' => 'App\\Controller\\CartController::update'], ['id'], ['POST' => 0], null, false, true, null]],
        724 => [[['_route' => 'app_commande_show', '_controller' => 'App\\Controller\\CommandeController::show'], ['id'], null, null, false, true, null]],
        769 => [[['_route' => 'app_document_edit', '_controller' => 'App\\Controller\\DocumentController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        777 => [[['_route' => 'app_document_delete', '_controller' => 'App\\Controller\\DocumentController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        803 => [[['_route' => 'app_document_download', '_controller' => 'App\\Controller\\DocumentController::download'], ['id'], ['GET' => 0], null, false, true, null]],
        845 => [[['_route' => 'app_maintenance_suivi_show', '_controller' => 'App\\Controller\\MaintenanceController::suiviShow'], ['id'], ['GET' => 0], null, false, true, null]],
        861 => [[['_route' => 'app_maintenance_suivi_edit', '_controller' => 'App\\Controller\\MaintenanceController::suiviEdit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        876 => [[['_route' => 'app_maintenance_suivi_approve', '_controller' => 'App\\Controller\\MaintenanceController::suiviApprove'], ['id'], ['GET' => 0], null, false, false, null]],
        890 => [[['_route' => 'app_maintenance_suivi_delete', '_controller' => 'App\\Controller\\MaintenanceController::suiviDelete'], ['id'], ['GET' => 0], null, false, false, null]],
        921 => [[['_route' => 'app_media_user', '_controller' => 'App\\Controller\\MediaController::serveUserPhoto'], ['filename'], null, null, false, true, null]],
        945 => [[['_route' => 'app_media_product', '_controller' => 'App\\Controller\\MediaController::serveProductImage'], ['filename'], null, null, false, true, null]],
        970 => [[['_route' => 'app_media_shortcut', '_controller' => 'App\\Controller\\MediaController::serveShortcutIcon'], ['filename'], null, null, false, true, null]],
        1014 => [[['_route' => 'app_notification_mark_single_read', '_controller' => 'App\\Controller\\NotificationController::markSingleRead'], ['id'], ['POST' => 0], null, false, true, null]],
        1061 => [[['_route' => 'app_rh_document_stream', '_controller' => 'App\\Controller\\PortalDocumentController::streamDocument'], ['id'], null, null, false, true, null]],
        1082 => [[['_route' => 'app_rh_document_sign', '_controller' => 'App\\Controller\\PortalDocumentController::sign'], ['id'], ['POST' => 0], null, false, true, null]],
        1107 => [[['_route' => 'app_rh_document_delete', '_controller' => 'App\\Controller\\PortalDocumentController::deleteDocument'], ['id'], ['POST' => 0], null, false, true, null]],
        1148 => [[['_route' => 'app_rh_conge_admin_action', '_controller' => 'App\\Controller\\RHController::adminCongeAction'], ['id'], ['POST' => 0], null, false, true, null]],
        1182 => [[['_route' => 'app_rh_conge_employee_action', '_controller' => 'App\\Controller\\RHController::employeeCongeAction'], ['id'], ['POST' => 0], null, false, true, null]],
        1203 => [[['_route' => 'app_rh_conge_pdf', '_controller' => 'App\\Controller\\RHController::congeGeneratePdf'], ['id'], null, null, false, true, null]],
        1251 => [[['_route' => 'app_rh_validation_download', '_controller' => 'App\\Controller\\RHController::downloadPdf'], ['id'], null, null, false, true, null]],
        1303 => [[['_route' => 'app_transport_logistique_edit', '_controller' => 'App\\Controller\\TransportLogistiqueController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        1318 => [[['_route' => 'app_transport_logistique_delete', '_controller' => 'App\\Controller\\TransportLogistiqueController::delete'], ['id'], ['POST' => 0], null, false, false, null]],
        1352 => [[['_route' => 'app_transport_logistique_camion_edit', '_controller' => 'App\\Controller\\TransportLogistiqueController::camionEdit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        1367 => [[['_route' => 'app_transport_logistique_camion_delete', '_controller' => 'App\\Controller\\TransportLogistiqueController::camionDelete'], ['id'], ['GET' => 0], null, false, false, null]],
        1413 => [
            [['_route' => 'app_user_observations_delete', '_controller' => 'App\\Controller\\UserObservationController::delete'], ['id'], ['POST' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
