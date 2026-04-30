<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* base.html.twig */
class __TwigTemplate_5f873504e0d6f345103340f43517ea0f extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'javascripts' => [$this, 'block_javascripts'],
            'importmap' => [$this, 'block_importmap'],
            'stylesheets' => [$this, 'block_stylesheets'],
            'body_class' => [$this, 'block_body_class'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "base.html.twig"));

        // line 1
        yield "<!DOCTYPE html>
<html lang=\"fr\">
\t<head>
\t\t<meta charset=\"UTF-8\">
\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
\t\t<title>
\t\t\t";
        // line 7
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        // line 9
        yield "\t\t</title>
\t\t<link rel=\"icon\" type=\"image/svg+xml\" href=\"";
        // line 10
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("logo.svg"), "html", null, true);
        yield "\">
\t\t<link rel=\"apple-touch-icon\" href=\"";
        // line 11
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("apple-touch-icon.png"), "html", null, true);
        yield "\">
\t\t<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
\t\t<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
\t\t<link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap\" rel=\"stylesheet\">
\t\t<script src=\"https://cdn.tailwindcss.com\"></script>
\t\t<script>
\t\t\ttailwind.config = {
theme: {
extend: {
fontFamily: {
sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif']
}
}
}
}
\t\t</script>

\t\t";
        // line 28
        yield from $this->unwrap()->yieldBlock('javascripts', $context, $blocks);
        // line 32
        yield "
\t\t";
        // line 33
        yield from $this->unwrap()->yieldBlock('stylesheets', $context, $blocks);
        // line 394
        yield "


\t</head>
\t<body class=\"";
        // line 398
        yield from $this->unwrap()->yieldBlock('body_class', $context, $blocks);
        yield "\">
\t\t";
        // line 399
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 399, $this->source); })()), "request", [], "any", false, false, false, 399), "get", ["_route"], "method", false, false, false, 399) != "app_login")) {
            // line 400
            yield "\t\t\t<div id=\"main-loader\">
\t\t\t\t<div class=\"loader-content\">
\t\t\t\t\t<div class=\"loader-circle-container\">
\t\t\t\t\t\t<svg class=\"loader-svg-circle\" viewbox=\"0 0 100 100\">
\t\t\t\t\t\t\t<circle class=\"circle-bg\" cx=\"50\" cy=\"50\" r=\"45\"></circle>
\t\t\t\t\t\t\t<circle class=\"circle-draw\" cx=\"50\" cy=\"50\" r=\"45\"></circle>
\t\t\t\t\t\t</svg>
\t\t\t\t\t\t<img src=\"";
            // line 407
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("logo.svg"), "html", null, true);
            yield "\" class=\"loader-carrot-static\" alt=\"Logo\">
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"loader-text-lsdj\">
\t\t\t\t\t\t<span class=\"letter\">L</span>
\t\t\t\t\t\t<span class=\"letter\">S</span>
\t\t\t\t\t\t<span class=\"letter\">D</span>
\t\t\t\t\t\t<span class=\"letter\">J</span>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t";
        }
        // line 418
        yield "
\t\t";
        // line 419
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 419, $this->source); })()), "user", [], "any", false, false, false, 419)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 420
            yield "\t\t\t<!-- Mobile overlay -->
\t\t\t<div class=\"sidebar-overlay\" id=\"sidebarOverlay\" onclick=\"closeSidebar()\"></div>

\t\t\t<!-- Sidebar -->
\t\t\t<aside class=\"sidebar\" id=\"sidebar\">
\t\t\t\t<div class=\"sidebar-header\">
\t\t\t\t\t<a href=\"";
            // line 426
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_home");
            yield "\" class=\"sidebar-brand-icon\" id=\"sidebarBrandIcon\" style=\"text-decoration: none; color: inherit; display: flex; align-items: center; width: 100%;\">
\t\t\t\t\t\t<svg class=\"brand-square-svg\" viewbox=\"0 0 60 60\" fill=\"none\">
\t\t\t\t\t\t\t<rect class=\"brand-square-draw\" x=\"3\" y=\"3\" width=\"54\" height=\"54\" rx=\"6\"></rect>
\t\t\t\t\t\t</svg>
\t\t\t\t\t\t<div class=\"brand-inner\" id=\"brandInner\">
\t\t\t\t\t\t\t<img src=\"";
            // line 431
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("logo.svg"), "html", null, true);
            yield "\" class=\"brand-carrot\" id=\"brandCarrot\" alt=\"Logo\">
\t\t\t\t\t\t\t<span class=\"brand-lsdj\" id=\"brandLsdj\">LSDJ</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t</a>
\t\t\t\t</div>
\t\t\t\t<nav style=\"padding: 8px 0; flex: 1;\">
\t\t\t\t";
            // line 443
            yield "
\t\t\t\t";
            // line 445
            yield "\t\t\t\t<div class=\"nav-label\">";
            yield (((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_RESPONSABLE")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Management") : ("Mon Espace"));
            yield "</div>

\t\t\t\t";
            // line 448
            yield "\t\t\t\t";
            if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "dashboard")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 449
                yield "\t\t\t\t\t<a href=\"";
                yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_dashboard");
                yield "\" class=\"";
                yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 449, $this->source); })()), "request", [], "any", false, false, false, 449), "get", ["_route"], "method", false, false, false, 449) == "app_dashboard")) ? ("active") : (""));
                yield "\">
\t\t\t\t\t\t<svg width=\"18\" height=\"18\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t<path d=\"M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\"></path>
\t\t\t\t\t\t</svg>
\t\t\t\t\t\t<span class=\"sidebar-label\">Tableau de bord</span>
\t\t\t\t\t</a>
\t\t\t\t";
            }
            // line 456
            yield "
\t\t\t\t";
            // line 458
            yield "\t\t\t\t";
            if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "access_management")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 459
                yield "\t\t\t\t\t<a href=\"";
                yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_access_index");
                yield "\" class=\"";
                yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 459, $this->source); })()), "request", [], "any", false, false, false, 459), "get", ["_route"], "method", false, false, false, 459) == "admin_access_index")) ? ("active") : (""));
                yield "\">
\t\t\t\t\t\t<svg width=\"18\" height=\"18\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t<path d=\"M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z\"></path>
\t\t\t\t\t\t</svg>
\t\t\t\t\t\t<span class=\"sidebar-label\">Gestion des Accès</span>
\t\t\t\t\t</a>
\t\t\t\t";
            }
            // line 466
            yield "
\t\t\t\t";
            // line 468
            yield "\t\t\t\t";
            if ((((($this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "agenda") || $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "users")) || $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "rh_validation")) || $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "rh_conge")) || $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "rh_documents"))) {
                // line 469
                yield "\t\t\t\t\t<div class=\"nav-dropdown\">
\t\t\t\t\t\t<button class=\"nav-dropdown-trigger\" onclick=\"toggleNavDropdown(this)\">
\t\t\t\t\t\t\t<svg fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t<path d=\"M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z\"></path>
\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t<span class=\"sidebar-label\">RH</span>
\t\t\t\t\t\t\t<svg class=\"chevron\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\"><path d=\"M19 9l-7 7-7-7\"></path></svg>
\t\t\t\t\t\t</button>
\t\t\t\t\t\t<div class=\"nav-dropdown-content\">
\t\t\t\t\t\t\t";
                // line 478
                if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "agenda")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 479
                    yield "\t\t\t\t\t\t\t\t<a href=\"";
                    yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_agenda");
                    yield "\" class=\"";
                    yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 479, $this->source); })()), "request", [], "any", false, false, false, 479), "get", ["_route"], "method", false, false, false, 479) == "app_agenda")) ? ("active") : (""));
                    yield "\">";
                    yield (((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_RESPONSABLE")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Planning") : ("Mon Planning"));
                    yield "</a>
\t\t\t\t\t\t\t";
                }
                // line 481
                yield "\t\t\t\t\t\t\t";
                if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "rh_validation")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 482
                    yield "\t\t\t\t\t\t\t\t<a href=\"";
                    yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_rh_validation");
                    yield "\" class=\"";
                    yield (((is_string($_v0 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 482, $this->source); })()), "request", [], "any", false, false, false, 482), "get", ["_route"], "method", false, false, false, 482)) && is_string($_v1 = "app_rh_validation") && str_starts_with($_v0, $_v1))) ? ("active") : (""));
                    yield "\">
\t\t\t\t\t\t\t\t\t";
                    // line 483
                    yield (((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_RESPONSABLE")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Validation des Horaires") : ("Valider mes heures"));
                    yield "
\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t";
                }
                // line 486
                yield "\t\t\t\t\t\t\t";
                if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "rh_conge")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 487
                    yield "\t\t\t\t\t\t\t\t<a href=\"";
                    yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_rh_conge");
                    yield "\" class=\"";
                    yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 487, $this->source); })()), "request", [], "any", false, false, false, 487), "get", ["_route"], "method", false, false, false, 487) == "app_rh_conge")) ? ("active") : (""));
                    yield "\">Demande de congé</a>
\t\t\t\t\t\t\t";
                }
                // line 489
                yield "\t\t\t\t\t\t\t";
                if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "rh_documents")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 490
                    yield "\t\t\t\t\t\t\t\t<a href=\"";
                    yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_rh_documents");
                    yield "\" class=\"";
                    yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 490, $this->source); })()), "request", [], "any", false, false, false, 490), "get", ["_route"], "method", false, false, false, 490) == "app_rh_documents")) ? ("active") : (""));
                    yield "\">";
                    yield (((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_RESPONSABLE")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Documents RH & Contrats") : ("Mes Documents RH"));
                    yield "</a>
\t\t\t\t\t\t\t";
                }
                // line 492
                yield "\t\t\t\t\t\t\t";
                if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "users")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 493
                    yield "\t\t\t\t\t\t\t\t<a href=\"";
                    yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_users_index");
                    yield "\" class=\"";
                    yield (((is_string($_v2 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 493, $this->source); })()), "request", [], "any", false, false, false, 493), "get", ["_route"], "method", false, false, false, 493)) && is_string($_v3 = "admin_users") && str_starts_with($_v2, $_v3))) ? ("active") : (""));
                    yield "\">Gestion du personnel</a>
\t\t\t\t\t\t\t";
                }
                // line 495
                yield "\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t";
            }
            // line 498
            yield "
\t\t\t\t";
            // line 500
            yield "\t\t\t\t";
            if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "transport_logistique")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 501
                yield "\t\t\t\t\t<a href=\"";
                yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_transport_logistique");
                yield "\" class=\"";
                yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 501, $this->source); })()), "request", [], "any", false, false, false, 501), "get", ["_route"], "method", false, false, false, 501) == "app_transport_logistique")) ? ("active") : (""));
                yield "\">
\t\t\t\t\t\t<svg width=\"18\" height=\"18\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t<path d=\"M8 14h.01M16 14h.01M5 8h14M5 8a2 2 0 00-2 2v6a2 2 0 002 2h14a2 2 0 002-2v-6a2 2 0 00-2-2M5 8l1-3h12l1 3M9 14v1m6-1v1\"></path>
\t\t\t\t\t\t</svg>
\t\t\t\t\t\t<span class=\"sidebar-label\">Transport & logistique</span>
\t\t\t\t\t</a>
\t\t\t\t";
            }
            // line 508
            yield "
\t\t\t\t";
            // line 510
            yield "\t\t\t\t";
            if (($this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "maintenance_signalement") || $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "maintenance_suivi"))) {
                // line 511
                yield "\t\t\t\t\t<div class=\"nav-dropdown\">
\t\t\t\t\t\t<button class=\"nav-dropdown-trigger\" onclick=\"toggleNavDropdown(this)\">
\t\t\t\t\t\t\t<svg fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t<path d=\"M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z\"></path>
\t\t\t\t\t\t\t\t<path d=\"M15 12a3 3 0 11-6 0 3 3 0 016 0z\"></path>
\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t<span class=\"sidebar-label\">Maintenance</span>
\t\t\t\t\t\t\t<svg class=\"chevron\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\"><path d=\"M19 9l-7 7-7-7\"></path></svg>
\t\t\t\t\t\t</button>
\t\t\t\t\t\t<div class=\"nav-dropdown-content\">
\t\t\t\t\t\t\t";
                // line 521
                if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "maintenance_signalement")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 522
                    yield "\t\t\t\t\t\t\t\t<a href=\"";
                    yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_maintenance_signalement");
                    yield "\" class=\"";
                    yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 522, $this->source); })()), "request", [], "any", false, false, false, 522), "get", ["_route"], "method", false, false, false, 522) == "app_maintenance_signalement")) ? ("active") : (""));
                    yield "\">Signalement matériel</a>
\t\t\t\t\t\t\t";
                }
                // line 524
                yield "\t\t\t\t\t\t\t";
                if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "maintenance_suivi")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 525
                    yield "\t\t\t\t\t\t\t\t<a href=\"";
                    yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_maintenance_suivi");
                    yield "\" class=\"";
                    yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 525, $this->source); })()), "request", [], "any", false, false, false, 525), "get", ["_route"], "method", false, false, false, 525) == "app_maintenance_suivi")) ? ("active") : (""));
                    yield "\">Suivi intervention</a>
\t\t\t\t\t\t\t";
                }
                // line 527
                yield "\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t";
            }
            // line 530
            yield "
\t\t\t\t";
            // line 532
            yield "\t\t\t\t";
            if (($this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "produits") || $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "commandes"))) {
                // line 533
                yield "\t\t\t\t\t<div class=\"nav-dropdown\">
\t\t\t\t\t\t<button class=\"nav-dropdown-trigger\" onclick=\"toggleNavDropdown(this)\">
\t\t\t\t\t\t\t<svg fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t<path d=\"M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z\"></path>
\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t<span class=\"sidebar-label\">Commandes</span>
\t\t\t\t\t\t\t<svg class=\"chevron\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\"><path d=\"M19 9l-7 7-7-7\"></path></svg>
\t\t\t\t\t\t</button>
\t\t\t\t\t\t<div class=\"nav-dropdown-content\">
\t\t\t\t\t\t\t";
                // line 542
                if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "produits")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 543
                    yield "\t\t\t\t\t\t\t\t<a href=\"";
                    yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_produit_index");
                    yield "\" class=\"";
                    yield (((is_string($_v4 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 543, $this->source); })()), "request", [], "any", false, false, false, 543), "get", ["_route"], "method", false, false, false, 543)) && is_string($_v5 = "app_produit") && str_starts_with($_v4, $_v5))) ? ("active") : (""));
                    yield "\">Catégorie Produits</a>
\t\t\t\t\t\t\t";
                }
                // line 545
                yield "\t\t\t\t\t\t\t";
                if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "commandes")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 546
                    yield "\t\t\t\t\t\t\t\t<a href=\"";
                    yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_commandes_index");
                    yield "\" class=\"";
                    yield (((is_string($_v6 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 546, $this->source); })()), "request", [], "any", false, false, false, 546), "get", ["_route"], "method", false, false, false, 546)) && is_string($_v7 = "admin_commandes") && str_starts_with($_v6, $_v7))) ? ("active") : (""));
                    yield "\">Gestion Commandes</a>
\t\t\t\t\t\t\t";
                }
                // line 548
                yield "\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t";
            }
            // line 551
            yield "
\t\t\t\t";
            // line 553
            yield "\t\t\t\t";
            if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "documents")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 554
                yield "\t\t\t\t<a href=\"";
                yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_document_index");
                yield "\" class=\"";
                yield (((is_string($_v8 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 554, $this->source); })()), "request", [], "any", false, false, false, 554), "get", ["_route"], "method", false, false, false, 554)) && is_string($_v9 = "app_document") && str_starts_with($_v8, $_v9))) ? ("active") : (""));
                yield "\">
\t\t\t\t\t<svg width=\"18\" height=\"18\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z\"/>
\t\t\t\t\t</svg>
\t\t\t\t\t<span class=\"sidebar-label\">Documents Généraux</span>
\t\t\t\t</a>
\t\t\t\t";
            }
            // line 561
            yield "
\t\t\t\t";
            // line 563
            yield "\t\t\t\t<div class=\"nav-label mt-4\">Informations</div>
\t\t\t\t<div class=\"nav-dropdown\">
\t\t\t\t\t<button class=\"nav-dropdown-trigger\" onclick=\"toggleNavDropdown(this)\">
\t\t\t\t\t\t<svg fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t<path d=\"M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z\"></path>
\t\t\t\t\t\t</svg>
\t\t\t\t\t\t<span class=\"sidebar-label\">Contact Utile</span>
\t\t\t\t\t\t<svg class=\"chevron\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\"><path d=\"M19 9l-7 7-7-7\"></path></svg>
\t\t\t\t\t</button>
\t\t\t\t\t<div class=\"nav-dropdown-content\">
\t\t\t\t\t\t<a href=\"";
            // line 573
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_contact_olivet");
            yield "\" class=\"";
            yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 573, $this->source); })()), "request", [], "any", false, false, false, 573), "get", ["_route"], "method", false, false, false, 573) == "app_contact_olivet")) ? ("active") : (""));
            yield "\">Olivet</a>
\t\t\t\t\t\t<a href=\"";
            // line 574
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_contact_st_gervais");
            yield "\" class=\"";
            yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 574, $this->source); })()), "request", [], "any", false, false, false, 574), "get", ["_route"], "method", false, false, false, 574) == "app_contact_st_gervais")) ? ("active") : (""));
            yield "\">St Gervais</a>
\t\t\t\t\t\t<a href=\"";
            // line 575
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_contact_villemandeur");
            yield "\" class=\"";
            yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 575, $this->source); })()), "request", [], "any", false, false, false, 575), "get", ["_route"], "method", false, false, false, 575) == "app_contact_villemandeur")) ? ("active") : (""));
            yield "\">Villemandeur</a>
\t\t\t\t\t\t<a href=\"";
            // line 576
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_contact_noyers");
            yield "\" class=\"";
            yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 576, $this->source); })()), "request", [], "any", false, false, false, 576), "get", ["_route"], "method", false, false, false, 576) == "app_contact_noyers")) ? ("active") : (""));
            yield "\">Noyers</a>
\t\t\t\t\t\t<a href=\"";
            // line 577
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_contact_saran");
            yield "\" class=\"";
            yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 577, $this->source); })()), "request", [], "any", false, false, false, 577), "get", ["_route"], "method", false, false, false, 577) == "app_contact_saran")) ? ("active") : (""));
            yield "\">Saran</a>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</nav>
\t\t\t</aside>
\t\t";
        }
        // line 583
        yield "
\t\t<div class=\"main-content\" ";
        // line 584
        if ((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 584, $this->source); })()), "user", [], "any", false, false, false, 584)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " style=\"margin-left: 0 !important;\" ";
        }
        yield ">
\t\t\t";
        // line 585
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 585, $this->source); })()), "user", [], "any", false, false, false, 585)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 586
            yield "\t\t\t\t<header
\t\t\t\t\tclass=\"top-bar\">
\t\t\t\t\t<!-- Left: Hamburger + Brand -->
\t\t\t\t\t<div style=\"display:flex; align-items:center; gap:10px; min-width:0; flex:1;\">
\t\t\t\t\t\t<button class=\"hamburger-btn\" id=\"hamburgerBtn\" onclick=\"toggleSidebar()\" aria-label=\"Menu\">
\t\t\t\t\t\t\t<svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M4 6h16M4 12h16M4 18h16\"/>
\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t</button>
\t\t\t\t\t\t";
            // line 595
            if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_USER")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 596
                yield "\t\t\t\t\t\t\t<a href=\"";
                yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_home");
                yield "\" class=\"top-bar-brand hover:text-indigo-600 transition-colors\">LES SAVEURS DU JARDIN</a>
\t\t\t\t\t\t";
            }
            // line 598
            yield "\t\t\t\t\t</div>

\t\t\t\t\t<!-- Right: Cart + User -->
\t\t\t\t\t<div style=\"display:flex; align-items:center; gap:10px; flex-shrink:0;\">
\t\t\t\t\t\t";
            // line 602
            if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_USER")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 603
                yield "\t\t\t\t\t\t\t";
                // line 604
                yield "\t\t\t\t\t\t\t<div class=\"dropdown\" id=\"notifDropdown\" style=\"position:relative;\">
\t\t\t\t\t\t\t\t<button type=\"button\" class=\"relative inline-flex items-center p-2 text-slate-500 hover:text-indigo-600 transition-colors bg-transparent border-0 cursor-pointer\" id=\"notifDropdownTrigger\" onclick=\"toggleNotifDropdown(event)\" aria-label=\"Notifications\">
\t\t\t\t\t\t\t\t\t<svg width=\"22\" height=\"22\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.2\" viewBox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t\t\t<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0\" />
\t\t\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t\t\t";
                // line 609
                if ((((array_key_exists("unreadNotificationsCount", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["unreadNotificationsCount"]) || array_key_exists("unreadNotificationsCount", $context) ? $context["unreadNotificationsCount"] : (function () { throw new RuntimeError('Variable "unreadNotificationsCount" does not exist.', 609, $this->source); })()), 0)) : (0)) > 0)) {
                    // line 610
                    yield "                                        <span class=\"absolute top-0 right-[-2px] flex h-4 w-4\" id=\"global-notif-badge\">
                                            <span class=\"animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75\"></span>
                                            <span class=\"relative inline-flex rounded-full h-4 w-4 bg-rose-600 text-[10px] font-black text-white items-center justify-center shadow-lg border-2 border-white\" id=\"global-notif-count\">
                                                ";
                    // line 613
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["unreadNotificationsCount"]) || array_key_exists("unreadNotificationsCount", $context) ? $context["unreadNotificationsCount"] : (function () { throw new RuntimeError('Variable "unreadNotificationsCount" does not exist.', 613, $this->source); })()), "html", null, true);
                    yield "
                                            </span>
                                        </span>
\t\t\t\t\t\t\t\t\t";
                }
                // line 617
                yield "\t\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t\t\t<div class=\"notifications-dropdown\" id=\"notifDropdownContent\">
\t\t\t\t\t\t\t\t\t<div class=\"notif-header\">
\t\t\t\t\t\t\t\t\t\t<span class=\"text-[10px] font-black uppercase tracking-widest text-slate-400\">Notifications</span>
\t\t\t\t\t\t\t\t\t\t";
                // line 621
                if ((((array_key_exists("unreadNotificationsCount", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["unreadNotificationsCount"]) || array_key_exists("unreadNotificationsCount", $context) ? $context["unreadNotificationsCount"] : (function () { throw new RuntimeError('Variable "unreadNotificationsCount" does not exist.', 621, $this->source); })()), 0)) : (0)) > 0)) {
                    // line 622
                    yield "\t\t\t\t\t\t\t\t\t\t\t<button onclick=\"markAllNotificationsAsRead(event)\" class=\"text-[10px] font-black text-indigo-600 uppercase tracking-widest bg-transparent border-0 cursor-pointer hover:text-slate-900 transition-colors\">Tout marquer</button>
\t\t\t\t\t\t\t\t\t\t";
                }
                // line 624
                yield "\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t<div class=\"notif-list\" id=\"notif-list-container\">
\t\t\t\t\t\t\t\t\t\t";
                // line 626
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(((array_key_exists("notifications", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["notifications"]) || array_key_exists("notifications", $context) ? $context["notifications"] : (function () { throw new RuntimeError('Variable "notifications" does not exist.', 626, $this->source); })()), [])) : ([])));
                $context['_iterated'] = false;
                foreach ($context['_seq'] as $context["_key"] => $context["notif"]) {
                    // line 627
                    yield "\t\t\t\t\t\t\t\t\t\t\t<a href=\"";
                    yield ((CoreExtension::getAttribute($this->env, $this->source, $context["notif"], "link", [], "any", false, false, false, 627)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["notif"], "link", [], "any", false, false, false, 627), "html", null, true)) : ("#"));
                    yield "\" 
                                               id=\"notif-item-";
                    // line 628
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["notif"], "id", [], "any", false, false, false, 628), "html", null, true);
                    yield "\"
                                               onclick=\"handleNotifClick('";
                    // line 629
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["notif"], "id", [], "any", false, false, false, 629), "html", null, true);
                    yield "', event)\"
                                               class=\"notif-item ";
                    // line 630
                    yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["notif"], "isRead", [], "any", false, false, false, 630)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("") : ("unread"));
                    yield "\">
\t\t\t\t\t\t\t\t\t\t\t\t";
                    // line 631
                    if ((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, $context["notif"], "isRead", [], "any", false, false, false, 631)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        // line 632
                        yield "\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"notif-dot-indicator\"></div>
\t\t\t\t\t\t\t\t\t\t\t\t";
                    } else {
                        // line 634
                        yield "                                                    <div class=\"w-[6px] flex-shrink-0\"></div>
\t\t\t\t\t\t\t\t\t\t\t\t";
                    }
                    // line 636
                    yield "\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"notif-body\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"notif-title\">";
                    // line 637
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["notif"], "title", [], "any", false, false, false, 637), "html", null, true);
                    yield "</div>
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"notif-content\">";
                    // line 638
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["notif"], "content", [], "any", false, false, false, 638), "html", null, true);
                    yield "</div>
\t\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"notif-time\">";
                    // line 639
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["notif"], "createdAt", [], "any", false, false, false, 639), "d/m H:i"), "html", null, true);
                    yield "</span>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t\t";
                    $context['_iterated'] = true;
                }
                // line 642
                if (!$context['_iterated']) {
                    // line 643
                    yield "\t\t\t\t\t\t\t\t\t\t\t<div class=\"notif-empty\">
                                                <div class=\"text-3xl mb-2 opacity-20\">🔔</div>
                                                <div class=\"text-[10px] font-black uppercase tracking-widest text-slate-300\">Aucune notification</div>
                                            </div>
\t\t\t\t\t\t\t\t\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['notif'], $context['_parent'], $context['_iterated']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 648
                yield "\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t<div class=\"notif-footer\" style=\"padding: 12px; border-top: 1px solid #f8fafc;\">
\t\t\t\t\t\t\t\t\t\t<a href=\"";
                // line 650
                yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_notifications_index");
                yield "\" class=\"text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors no-underline block text-center\">Historique Complet</a>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t<a href=\"";
                // line 655
                yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_cart_index");
                yield "\" class=\"relative inline-flex items-center p-2 text-slate-500 hover:text-indigo-600 transition-colors group\" title=\"Mon Panier\">
\t\t\t\t\t\t\t\t<svg width=\"22\" height=\"22\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.2\" viewBox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t\t<path d=\"M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z\"></path>
\t\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t\t";
                // line 659
                $context["cartCount"] = $this->extensions['App\Twig\CartExtension']->getCartItemCount();
                // line 660
                yield "\t\t\t\t\t\t\t\t";
                if (((isset($context["cartCount"]) || array_key_exists("cartCount", $context) ? $context["cartCount"] : (function () { throw new RuntimeError('Variable "cartCount" does not exist.', 660, $this->source); })()) > 0)) {
                    // line 661
                    yield "\t\t\t\t\t\t\t\t\t<span class=\"absolute top-0 right-[-2px] flex h-4 w-4\">
\t\t\t\t\t\t\t\t\t\t<span class=\"animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75\"></span>
\t\t\t\t\t\t\t\t\t\t<span class=\"relative inline-flex rounded-full h-4 w-4 bg-rose-600 text-[10px] font-black text-white items-center justify-center shadow-lg border-2 border-white\">
\t\t\t\t\t\t\t\t\t\t\t";
                    // line 664
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["cartCount"]) || array_key_exists("cartCount", $context) ? $context["cartCount"] : (function () { throw new RuntimeError('Variable "cartCount" does not exist.', 664, $this->source); })()), "html", null, true);
                    yield "
\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t";
                }
                // line 668
                yield "\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t";
            }
            // line 670
            yield "
\t\t\t\t\t\t<div class=\"dropdown\" id=\"userDropdown\">
\t\t\t\t\t\t\t<button type=\"button\" class=\"dropdown-trigger\" id=\"userDropdownTrigger\" onclick=\"toggleUserDropdown(event)\" aria-expanded=\"false\" aria-haspopup=\"true\">
\t\t\t\t\t\t\t\t";
            // line 673
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 673, $this->source); })()), "user", [], "any", false, false, false, 673), "photo", [], "any", false, false, false, 673)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 674
                yield "\t\t\t\t\t\t\t\t\t<div style=\"width:30px; height:30px; border-radius:50%; border:2px solid var(--primary); overflow:hidden; flex-shrink:0;\">
\t\t\t\t\t\t\t\t\t\t<img src=\"";
                // line 675
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_media_user", ["filename" => CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 675, $this->source); })()), "user", [], "any", false, false, false, 675), "photo", [], "any", false, false, false, 675)]), "html", null, true);
                yield "\" style=\"width:100%; height:100%; object-fit:cover;\">
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t";
            } else {
                // line 678
                yield "\t\t\t\t\t\t\t\t\t<div style=\"width:30px; height:30px; background:var(--primary); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:13px; border-radius:50%; flex-shrink:0;\">
\t\t\t\t\t\t\t\t\t\t";
                // line 679
                yield ((Twig\Extension\CoreExtension::upper($this->env->getCharset(), Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 679, $this->source); })()), "user", [], "any", false, false, false, 679), "prenom", [], "any", false, false, false, 679), 0, 1))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 679, $this->source); })()), "user", [], "any", false, false, false, 679), "prenom", [], "any", false, false, false, 679), 0, 1)), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 679, $this->source); })()), "user", [], "any", false, false, false, 679), "userIdentifier", [], "any", false, false, false, 679), 0, 1)), "html", null, true)));
                yield "
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t";
            }
            // line 682
            yield "\t\t\t\t\t\t\t\t<span style=\"font-size:13px; font-weight:700; color:var(--dark); max-width:90px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; display:none;\" class=\"user-name-label\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 682, $this->source); })()), "user", [], "any", false, false, false, 682), "prenom", [], "any", false, false, false, 682), "html", null, true);
            yield "</span>
\t\t\t\t\t\t\t\t<svg width=\"12\" height=\"12\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" viewbox=\"0 0 24 24\" id=\"dropdownChevron\" style=\"transition:transform 0.2s; flex-shrink:0;\">
\t\t\t\t\t\t\t\t\t<path d=\"M19 9l-7 7-7-7\"></path>
\t\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t\t<div class=\"dropdown-content\" id=\"userDropdownContent\" style=\"display:none;\">
\t\t\t\t\t\t\t\t<div style=\"padding:12px 16px; border-bottom:1px solid var(--border);\">
\t\t\t\t\t\t\t\t\t<div style=\"font-size:11px; font-weight:800; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.1em;\">Compte</div>
\t\t\t\t\t\t\t\t\t<div style=\"font-size:13px; font-weight:600; color:var(--dark); margin-top:2px;\">";
            // line 690
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 690, $this->source); })()), "user", [], "any", false, false, false, 690), "prenom", [], "any", false, false, false, 690), "html", null, true);
            yield "
\t\t\t\t\t\t\t\t\t\t";
            // line 691
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 691, $this->source); })()), "user", [], "any", false, false, false, 691), "nom", [], "any", false, false, false, 691), "html", null, true);
            yield "</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t";
            // line 693
            if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_USER")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 694
                yield "\t\t\t\t\t\t\t\t\t<a href=\"";
                yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_commande_my");
                yield "\">
\t\t\t\t\t\t\t\t\t\t<svg width=\"16\" height=\"16\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t\t\t\t<path d=\"M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z\"></path>
\t\t\t\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t\t\t\tSuivi Commandes
\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t";
            }
            // line 701
            yield "\t\t\t\t\t\t\t\t<a href=\"";
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_settings");
            yield "\">
\t\t\t\t\t\t\t\t\t<svg width=\"16\" height=\"16\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t\t\t<path d=\"M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z\"></path>
\t\t\t\t\t\t\t\t\t\t<path d=\"M15 12a3 3 0 11-6 0 3 3 0 016 0z\"></path>
\t\t\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t\t\tParamètres
\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t<div class=\"dropdown-divider\"></div>
\t\t\t\t\t\t\t\t<a href=\"";
            // line 709
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_logout");
            yield "\" style=\"color:#ef4444;\">
\t\t\t\t\t\t\t\t\t<svg width=\"16\" height=\"16\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t\t\t<path d=\"M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1\"></path>
\t\t\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t\t\tDéconnexion
\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</header>
\t\t\t";
        }
        // line 720
        yield "
\t\t\t<main class=\"";
        // line 721
        yield (((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 721, $this->source); })()), "user", [], "any", false, false, false, 721)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("auth-layout") : ("page-wrapper"));
        yield "\">
\t\t\t\t";
        // line 722
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 722, $this->source); })()), "user", [], "any", false, false, false, 722)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 723
            yield "\t\t\t\t\t";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 723, $this->source); })()), "flashes", ["success"], "method", false, false, false, 723));
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 724
                yield "\t\t\t\t\t\t<div class=\"alert\">
\t\t\t\t\t\t\t<svg width=\"18\" height=\"18\" fill=\"currentColor\" viewbox=\"0 0 20 20\">
\t\t\t\t\t\t\t\t<path fill-rule=\"evenodd\" d=\"M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z\" clip-rule=\"evenodd\"></path>
\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t";
                // line 728
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
                yield "
\t\t\t\t\t\t</div>
\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 731
            yield "\t\t\t\t\t";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 731, $this->source); })()), "flashes", ["error"], "method", false, false, false, 731));
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 732
                yield "\t\t\t\t\t\t<div class=\"alert alert-error\">
\t\t\t\t\t\t\t<svg width=\"18\" height=\"18\" fill=\"currentColor\" viewbox=\"0 0 20 20\">
\t\t\t\t\t\t\t\t<path fill-rule=\"evenodd\" d=\"M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z\" clip-rule=\"evenodd\"></path>
\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t";
                // line 736
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
                yield "
\t\t\t\t\t\t</div>
\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 739
            yield "\t\t\t\t";
        }
        // line 740
        yield "
\t\t\t\t";
        // line 741
        yield from $this->unwrap()->yieldBlock('body', $context, $blocks);
        // line 742
        yield "\t\t\t</main>
\t\t</div>

\t\t<div id=\"global-toast-container\"></div>

\t\t<script>
\t\t\twindow.showToast = function(message, type = 'success') {
\t\t\t\tconst container = document.getElementById('global-toast-container');
\t\t\t\tconst toast = document.createElement('div');
\t\t\t\ttoast.className = `global-toast global-toast-\${type}`;
\t\t\t\t
\t\t\t\tconst icon = type === 'success' 
\t\t\t\t\t? '<svg width=\"20\" height=\"20\" fill=\"currentColor\" viewBox=\"0 0 20 20\"><path fill-rule=\"evenodd\" d=\"M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z\" clip-rule=\"evenodd\"></path></svg>'
\t\t\t\t\t: '<svg width=\"20\" height=\"20\" fill=\"currentColor\" viewBox=\"0 0 20 20\"><path fill-rule=\"evenodd\" d=\"M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z\" clip-rule=\"evenodd\"></path></svg>';

\t\t\t\ttoast.innerHTML = `
\t\t\t\t\t<div class=\"shrink-0\">\${icon}</div>
\t\t\t\t\t<div class=\"text-sm font-bold flex-1\">\${message}</div>
\t\t\t\t`;
\t\t\t\t
\t\t\t\tcontainer.appendChild(toast);
\t\t\t\t
\t\t\t\t// Force reflow
\t\t\t\ttoast.offsetHeight;
\t\t\t\ttoast.classList.add('show');
\t\t\t\t
\t\t\t\tsetTimeout(() => {
\t\t\t\t\ttoast.classList.remove('show');
\t\t\t\t\tsetTimeout(() => toast.remove(), 400);
\t\t\t\t}, 4000);
\t\t\t};
\t\t</script>
\t\t<script src=\"";
        // line 774
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/base.js"), "html", null, true);
        yield "\"></script>
\t\t<script src=\"";
        // line 775
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/modal.js"), "html", null, true);
        yield "\"></script>
\t</body>
</html>

";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 7
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        yield "Plateforme LSDJ
\t\t\t";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 28
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_javascripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        // line 29
        yield "            ";
        yield from $this->unwrap()->yieldBlock('importmap', $context, $blocks);
        // line 30
        yield "\t\t\t";
        yield $this->env->getRuntime('Symfony\Bridge\Twig\Extension\ImportMapRuntime')->importmap("app");
        yield "
\t\t";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 29
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_importmap(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "importmap"));

        yield $this->env->getRuntime('Symfony\Bridge\Twig\Extension\ImportMapRuntime')->importmap("app");
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 33
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_stylesheets(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 34
        yield "\t\t\t<link rel=\"stylesheet\" href=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/base.css"), "html", null, true);
        yield "?v=";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "U"), "html", null, true);
        yield "\">
\t\t\t<style>
\t\t\t\t/* Loader Styles */
\t\t\t\t@import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&display=swap');

\t\t\t\t#main-loader {
\t\t\t\t\tposition: fixed;
\t\t\t\t\tinset: 0;
\t\t\t\t\tz-index: 9999;
\t\t\t\t\tbackground: #fff;
\t\t\t\t\tdisplay: flex;
\t\t\t\t\talign-items: center;
\t\t\t\t\tjustify-content: center;
\t\t\t\t\ttransition: opacity 0.6s ease-in-out, visibility 0.6s;
\t\t\t\t}
\t\t\t\t#main-loader.fade-out {
\t\t\t\t\topacity: 0;
\t\t\t\t\tvisibility: hidden;
\t\t\t\t}
\t\t\t\t.loader-content {
\t\t\t\t\tdisplay: flex;
\t\t\t\t\tflex-direction: column;
\t\t\t\t\talign-items: center;
\t\t\t\t\tgap: 2px; /* Very small margin under the circle */
\t\t\t\t}
\t\t\t\t.loader-circle-container {
\t\t\t\t\tposition: relative;
\t\t\t\t\twidth: 120px;
\t\t\t\t\theight: 120px;
\t\t\t\t\tdisplay: flex;
\t\t\t\t\talign-items: center;
\t\t\t\t\tjustify-content: center;
\t\t\t\t}
\t\t\t\t.loader-svg-circle {
\t\t\t\t\tposition: absolute;
\t\t\t\t\twidth: 100%;
\t\t\t\t\theight: 100%;
\t\t\t\t\ttransform: rotate(-90deg); /* Start from top */
\t\t\t\t}
\t\t\t\t.circle-bg {
\t\t\t\t\tfill: none;
\t\t\t\t\tstroke: #f1f5f9;
\t\t\t\t\tstroke-width: 4;
\t\t\t\t}
\t\t\t\t.circle-draw {
\t\t\t\t\tfill: none;
\t\t\t\t\tstroke: #a9df51;
\t\t\t\t\tstroke-width: 4;
\t\t\t\t\tstroke-linecap: round;
\t\t\t\t\tstroke-dasharray: 283; /* 2 * PI * 45 */
\t\t\t\t\tstroke-dashoffset: 283;
\t\t\t\t\tanimation: drawCircleCounterClockwise 0.45s ease-out forwards; /* Reduced by 70% */
\t\t\t\t\ttransform-origin: center;
\t\t\t\t\ttransform: scaleY(-1); /* Flips for counterclockwise */
\t\t\t\t}
\t\t\t\t.loader-carrot-static {
\t\t\t\t\twidth: 55px;
\t\t\t\t\theight: auto;
\t\t\t\t\tz-index: 2;
\t\t\t\t\ttransform: translateX(-4px); /* Shifted slightly left */
\t\t\t\t}
\t\t\t\t.loader-text-lsdj {
\t\t\t\t\tdisplay: flex;
\t\t\t\t\tjustify-content: center;
\t\t\t\t\tgap: 8px;
\t\t\t\t\twidth: 100%;
\t\t\t\t\tmargin-right: -0.05em; /* Compensate for letter-spacing on the last letter */
\t\t\t\t}
\t\t\t\t.letter {
\t\t\t\t\tfont-size: 28px;
\t\t\t\t\tfont-weight: 900;
\t\t\t\t\tcolor: #234954;
\t\t\t\t\tletter-spacing: 0.05em;
\t\t\t\t\topacity: 0;
\t\t\t\t\ttransform: translateY(10px);
\t\t\t\t\tanimation: letterAppear 0.2s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; /* Faster appearance */
\t\t\t\t}
\t\t\t\t.letter:nth-child(1) {
\t\t\t\t\tanimation-delay: 0s;
\t\t\t\t}
\t\t\t\t.letter:nth-child(2) {
\t\t\t\t\tanimation-delay: 0.05s;
\t\t\t\t}
\t\t\t\t.letter:nth-child(3) {
\t\t\t\t\tanimation-delay: 0.10s;
\t\t\t\t}
\t\t\t\t.letter:nth-child(4) {
\t\t\t\t\tanimation-delay: 0.15s;
\t\t\t\t}

\t\t\t\t@keyframes drawCircleCounterClockwise {
\t\t\t\t\t0% {
\t\t\t\t\t\tstroke-dashoffset: 283;
\t\t\t\t\t}
\t\t\t\t\t100% {
\t\t\t\t\t\tstroke-dashoffset: 0;
\t\t\t\t\t}
\t\t\t\t}
\t\t\t\t@keyframes letterAppear {
\t\t\t\t\tto {
\t\t\t\t\t\topacity: 1;
\t\t\t\t\t\ttransform: translateY(0);
\t\t\t\t\t}
\t\t\t\t}

\t\t\t\t/* Sidebar brand icon */
\t\t\t\t.sidebar-brand-icon {
\t\t\t\t\tposition: relative;
\t\t\t\t\twidth: 68px;
\t\t\t\t\theight: 68px;
\t\t\t\t\tdisplay: flex;
\t\t\t\t\talign-items: center;
\t\t\t\t\tjustify-content: center;
\t\t\t\t\tcursor: pointer;
\t\t\t\t\tpadding: 6px;
\t\t\t\t}
\t\t\t\t.brand-square-svg {
\t\t\t\t\tposition: absolute;
\t\t\t\t\ttop: 0;
\t\t\t\t\tleft: 0;
\t\t\t\t\twidth: 100%;
\t\t\t\t\theight: 100%;
\t\t\t\t}
\t\t\t\t.brand-square-draw {
\t\t\t\t\tstroke: #a9df51;
\t\t\t\t\tstroke-width: 2.5;
\t\t\t\t\tstroke-linecap: round;
\t\t\t\t\tstroke-linejoin: round;
\t\t\t\t\tfill: none;
\t\t\t\t\tstroke-dasharray: 216;
\t\t\t\t\tstroke-dashoffset: 216;
\t\t\t\t\tanimation: drawSquare 3s ease-in-out infinite;
\t\t\t\t}
\t\t\t\t.brand-inner {
\t\t\t\t\tposition: relative;
\t\t\t\t\tz-index: 2;
\t\t\t\t\tdisplay: flex;
\t\t\t\t\talign-items: center;
\t\t\t\t\tjustify-content: center;
\t\t\t\t\twidth: 100%;
\t\t\t\t\theight: 100%;
\t\t\t\t}
\t\t\t\t.brand-carrot {
\t\t\t\t\twidth: 28px;
\t\t\t\t\theight: auto;
\t\t\t\t\tposition: absolute;
\t\t\t\t\ttransition: opacity 0.8s ease, transform 0.8s ease;
\t\t\t\t\topacity: 1;
\t\t\t\t\ttransform: scale(1);
\t\t\t\t}
\t\t\t\t.brand-carrot.hidden {
\t\t\t\t\topacity: 0;
\t\t\t\t\ttransform: scale(0.8);
\t\t\t\t}
\t\t\t\t.brand-lsdj {
\t\t\t\t\tposition: absolute;
\t\t\t\t\tfont-size: 18px;
\t\t\t\t\tfont-weight: 900;
\t\t\t\t\tcolor: #a9df51;
\t\t\t\t\ttransform: rotate(-45deg) scale(0.8);
\t\t\t\t\tletter-spacing: 0.05em;
\t\t\t\t\ttransition: opacity 0.8s ease, transform 0.8s ease;
\t\t\t\t\topacity: 0;
\t\t\t\t}
\t\t\t\t.brand-lsdj.visible {
\t\t\t\t\topacity: 1;
\t\t\t\t\ttransform: rotate(-45deg) scale(1);
\t\t\t\t}
\t\t\t\t@keyframes drawSquare {
\t\t\t\t\t0% {
\t\t\t\t\t\tstroke-dashoffset: 216;
\t\t\t\t\t} /* Empty */
\t\t\t\t\t50% {
\t\t\t\t\t\tstroke-dashoffset: 0;
\t\t\t\t\t} /* Fully drawn (1.5s) */
\t\t\t\t\t100% {
\t\t\t\t\t\tstroke-dashoffset: -216;
\t\t\t\t\t}; /* Undrawn (1.5s) */
\t\t\t\t}

\t\t\t\t/* Notification Styles */
\t\t\t\t.notifications-dropdown {
\t\t\t\t\tposition: absolute;
\t\t\t\t\ttop: calc(100% + 12px);
\t\t\t\t\tright: -80px;
\t\t\t\t\twidth: 360px;
\t\t\t\t\tbackground: #fff;
\t\t\t\t\tborder: 1px solid #eef2f6;
\t\t\t\t\tborder-radius: 12px;
\t\t\t\t\tbox-shadow: 0 20px 25px -5px rgba(0,0,0,0.05), 0 8px 10px -6px rgba(0,0,0,0.05);
\t\t\t\t\tz-index: 1000;
\t\t\t\t\tdisplay: none;
\t\t\t\t\tflex-direction: column;
\t\t\t\t\toverflow: hidden;
\t\t\t\t\ttransform-origin: top right;
\t\t\t\t\tanimation: dropdownAppear 0.2s cubic-bezier(0.16, 1, 0.3, 1);
\t\t\t\t}
\t\t\t\t@keyframes dropdownAppear {
\t\t\t\t\tfrom { opacity: 0; transform: scale(0.95) translateY(-10px); }
\t\t\t\t\tto { opacity: 1; transform: scale(1) translateY(0); }
\t\t\t\t}
\t\t\t\t.notifications-dropdown.open {
\t\t\t\t\tdisplay: flex;
\t\t\t\t}
\t\t\t\t.notif-header {
\t\t\t\t\tpadding: 16px 20px;
\t\t\t\t\tborder-bottom: 1px solid #f1f5f9;
\t\t\t\t\tdisplay: flex;
\t\t\t\t\talign-items: center;
\t\t\t\t\tjustify-content: space-between;
\t\t\t\t\tbackground: #fff;
\t\t\t\t}
\t\t\t\t.notif-list {
\t\t\t\t\tmax-height: 480px;
\t\t\t\t\toverflow-y: auto;
\t\t\t\t}
\t\t\t\t.notif-item {
\t\t\t\t\tpadding: 14px 20px;
\t\t\t\t\tborder-bottom: 1px solid #f8fafc;
\t\t\t\t\tdisplay: flex;
\t\t\t\t\tgap: 12px;
\t\t\t\t\ttransition: all 0.2s;
\t\t\t\t\ttext-decoration: none;
\t\t\t\t\tcolor: inherit;
\t\t\t\t\tposition: relative;
\t\t\t\t}
\t\t\t\t.notif-item:hover {
\t\t\t\t\tbackground: #f8fafc;
\t\t\t\t}
\t\t\t\t.notif-item.unread {
\t\t\t\t\tbackground: #fff;
\t\t\t\t}
\t\t\t\t.notif-item.unread::before {
\t\t\t\t\tcontent: '';
\t\t\t\t\tposition: absolute;
\t\t\t\t\tleft: 0;
\t\t\t\t\ttop: 0;
\t\t\t\t\tbottom: 0;
\t\t\t\t\twidth: 3px;
\t\t\t\t\tbackground: #4f46e5;
\t\t\t\t}
\t\t\t\t.notif-dot-indicator {
\t\t\t\t\twidth: 6px;
\t\t\t\t\theight: 6px;
\t\t\t\t\tborder-radius: 50%;
\t\t\t\t\tbackground: #4f46e5;
\t\t\t\t\tmargin-top: 6px;
\t\t\t\t\tflex-shrink: 0;
\t\t\t\t}
\t\t\t\t.notif-body {
\t\t\t\t\tflex: 1;
\t\t\t\t\tmin-width: 0;
\t\t\t\t}
\t\t\t\t.notif-title {
\t\t\t\t\tfont-size: 13px;
\t\t\t\t\tfont-weight: 800;
\t\t\t\t\tcolor: #1e293b;
\t\t\t\t\tmargin-bottom: 2px;
\t\t\t\t}
\t\t\t\t.notif-content {
\t\t\t\t\tfont-size: 12px;
\t\t\t\t\tcolor: #64748b;
\t\t\t\t\tline-height: 1.5;
\t\t\t\t}
\t\t\t\t.notif-time {
\t\t\t\t\tfont-size: 10px;
\t\t\t\t\tcolor: #94a3b8;
\t\t\t\t\tmargin-top: 6px;
\t\t\t\t\tfont-weight: 600;
\t\t\t\t\tdisplay: block;
\t\t\t\t}
\t\t\t\t.notif-empty {
\t\t\t\t\tpadding: 30px 16px;
\t\t\t\t\ttext-align: center;
\t\t\t\t\tcolor: var(--text-muted);
\t\t\t\t\tfont-size: 13px;
\t\t\t\t}
\t\t\t\t.notif-footer {
\t\t\t\t\tpadding: 10px;
\t\t\t\t\ttext-align: center;
\t\t\t\t\tborder-top: 1px solid var(--border);
\t\t\t\t\tbackground: var(--bg-main);
\t\t\t\t}
\t\t\t\t.notif-footer a {
\t\t\t\t\tfont-size: 12px;
\t\t\t\t\tfont-weight: 600;
\t\t\t\t\tcolor: var(--primary);
\t\t\t\t\ttext-decoration: none;
\t\t\t\t}
\t\t\t\t.unread-badge {
\t\t\t\t\tposition: absolute;
\t\t\t\t\ttop: -5px;
\t\t\t\t\tright: -5px;
\t\t\t\t\tbackground: #ef4444;
\t\t\t\t\tcolor: #fff;
\t\t\t\t\tfont-size: 10px;
\t\t\t\t\tfont-weight: 800;
\t\t\t\t\tmin-width: 16px;
\t\t\t\t\theight: 16px;
\t\t\t\t\tborder-radius: 8px;
\t\t\t\t\tdisplay: flex;
\t\t\t\t\talign-items: center;
\t\t\t\t\tjustify-content: center;
\t\t\t\t\tpadding: 0 4px;
\t\t\t\t\tborder: 2px solid #fff;
\t\t\t\t}
\t\t\t\t/* Global Toast Container */
\t\t\t\t#global-toast-container {
\t\t\t\t\tposition: fixed;
\t\t\t\t\ttop: 24px;
\t\t\t\t\tright: 24px;
\t\t\t\t\tz-index: 10000;
\t\t\t\t\tdisplay: flex;
\t\t\t\t\tflex-direction: column;
\t\t\t\t\tgap: 12px;
\t\t\t\t\tpointer-events: none;
\t\t\t\t}

\t\t\t\t.global-toast {
\t\t\t\t\tpointer-events: auto;
\t\t\t\t\tmin-width: 320px;
\t\t\t\t\tmax-width: 420px;
\t\t\t\t\tpadding: 16px;
\t\t\t\t\tborder-radius: 12px;
\t\t\t\t\tbackground: #ffffff;
\t\t\t\t\tbox-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
\t\t\t\t\tborder: 1px solid var(--border);
\t\t\t\t\tdisplay: flex;
\t\t\t\t\talign-items: center;
\t\t\t\t\tgap: 12px;
\t\t\t\t\ttransform: translateX(40px);
\t\t\t\t\topacity: 0;
\t\t\t\t\ttransition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
\t\t\t\t}

\t\t\t\t.global-toast.show {
\t\t\t\t\ttransform: translateX(0);
\t\t\t\t\topacity: 1;
\t\t\t\t}

\t\t\t\t.global-toast-success { color: #065f46; background: #ecfdf5; border-color: #a7f3d0; }
\t\t\t\t.global-toast-error { color: #991b1b; background: #fef2f2; border-color: #fecaca; }

\t\t\t\t/* Access Level Badges & Tokens */
\t\t\t\t.badge-access-aucun { color: #64748b; background: #f1f5f9; border: 1px solid #e2e8f0; }
\t\t\t\t.badge-access-total { color: #065f46; background: #ecfdf5; border: 1px solid #a7f3d0; }
\t\t\t\t.badge-access-admin { color: #4338ca; background: #eef2ff; border: 1px solid #c7d2fe; }
\t\t\t\t.badge-access-lecture-totale { color: #0369a1; background: #f0f9ff; border: 1px solid #bae6fd; }
\t\t\t\t.badge-access-lecture-magasin { color: #0f766e; background: #f0fdfa; border: 1px solid #99f6e4; }
\t\t\t\t.badge-access-personnel { color: #92400e; background: #fffbeb; border: 1px solid #fde68a; }

\t\t\t\t.access-select {
\t\t\t\t\ttransition: all 0.3s ease;
\t\t\t\t\ttext-transform: uppercase;
\t\t\t\t\tletter-spacing: 0.05em;
\t\t\t\t\tfont-weight: 800;
\t\t\t\t\tfont-size: 10px;
\t\t\t\t}
\t\t\t</style>
\t\t";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 398
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body_class(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body_class"));

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 741
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "base.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  1293 => 741,  1277 => 398,  906 => 34,  896 => 33,  879 => 29,  868 => 30,  865 => 29,  855 => 28,  837 => 7,  824 => 775,  820 => 774,  786 => 742,  784 => 741,  781 => 740,  778 => 739,  769 => 736,  763 => 732,  758 => 731,  749 => 728,  743 => 724,  738 => 723,  736 => 722,  732 => 721,  729 => 720,  715 => 709,  703 => 701,  692 => 694,  690 => 693,  685 => 691,  681 => 690,  669 => 682,  663 => 679,  660 => 678,  654 => 675,  651 => 674,  649 => 673,  644 => 670,  640 => 668,  633 => 664,  628 => 661,  625 => 660,  623 => 659,  616 => 655,  608 => 650,  604 => 648,  594 => 643,  592 => 642,  584 => 639,  580 => 638,  576 => 637,  573 => 636,  569 => 634,  565 => 632,  563 => 631,  559 => 630,  555 => 629,  551 => 628,  546 => 627,  541 => 626,  537 => 624,  533 => 622,  531 => 621,  525 => 617,  518 => 613,  513 => 610,  511 => 609,  504 => 604,  502 => 603,  500 => 602,  494 => 598,  488 => 596,  486 => 595,  475 => 586,  473 => 585,  467 => 584,  464 => 583,  453 => 577,  447 => 576,  441 => 575,  435 => 574,  429 => 573,  417 => 563,  414 => 561,  401 => 554,  398 => 553,  395 => 551,  390 => 548,  382 => 546,  379 => 545,  371 => 543,  369 => 542,  358 => 533,  355 => 532,  352 => 530,  347 => 527,  339 => 525,  336 => 524,  328 => 522,  326 => 521,  314 => 511,  311 => 510,  308 => 508,  295 => 501,  292 => 500,  289 => 498,  284 => 495,  276 => 493,  273 => 492,  263 => 490,  260 => 489,  252 => 487,  249 => 486,  243 => 483,  236 => 482,  233 => 481,  223 => 479,  221 => 478,  210 => 469,  207 => 468,  204 => 466,  191 => 459,  188 => 458,  185 => 456,  172 => 449,  169 => 448,  163 => 445,  160 => 443,  151 => 431,  143 => 426,  135 => 420,  133 => 419,  130 => 418,  116 => 407,  107 => 400,  105 => 399,  101 => 398,  95 => 394,  93 => 33,  90 => 32,  88 => 28,  68 => 11,  64 => 10,  61 => 9,  59 => 7,  51 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"fr\">
\t<head>
\t\t<meta charset=\"UTF-8\">
\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
\t\t<title>
\t\t\t{% block title %}Plateforme LSDJ
\t\t\t{% endblock %}
\t\t</title>
\t\t<link rel=\"icon\" type=\"image/svg+xml\" href=\"{{ asset('logo.svg') }}\">
\t\t<link rel=\"apple-touch-icon\" href=\"{{ asset('apple-touch-icon.png') }}\">
\t\t<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
\t\t<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
\t\t<link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap\" rel=\"stylesheet\">
\t\t<script src=\"https://cdn.tailwindcss.com\"></script>
\t\t<script>
\t\t\ttailwind.config = {
theme: {
extend: {
fontFamily: {
sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif']
}
}
}
}
\t\t</script>

\t\t{% block javascripts %}
            {% block importmap %}{{ importmap('app') }}{% endblock %}
\t\t\t{{ importmap('app') }}
\t\t{% endblock %}

\t\t{% block stylesheets %}
\t\t\t<link rel=\"stylesheet\" href=\"{{ asset('css/base.css') }}?v={{ 'now'|date('U') }}\">
\t\t\t<style>
\t\t\t\t/* Loader Styles */
\t\t\t\t@import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&display=swap');

\t\t\t\t#main-loader {
\t\t\t\t\tposition: fixed;
\t\t\t\t\tinset: 0;
\t\t\t\t\tz-index: 9999;
\t\t\t\t\tbackground: #fff;
\t\t\t\t\tdisplay: flex;
\t\t\t\t\talign-items: center;
\t\t\t\t\tjustify-content: center;
\t\t\t\t\ttransition: opacity 0.6s ease-in-out, visibility 0.6s;
\t\t\t\t}
\t\t\t\t#main-loader.fade-out {
\t\t\t\t\topacity: 0;
\t\t\t\t\tvisibility: hidden;
\t\t\t\t}
\t\t\t\t.loader-content {
\t\t\t\t\tdisplay: flex;
\t\t\t\t\tflex-direction: column;
\t\t\t\t\talign-items: center;
\t\t\t\t\tgap: 2px; /* Very small margin under the circle */
\t\t\t\t}
\t\t\t\t.loader-circle-container {
\t\t\t\t\tposition: relative;
\t\t\t\t\twidth: 120px;
\t\t\t\t\theight: 120px;
\t\t\t\t\tdisplay: flex;
\t\t\t\t\talign-items: center;
\t\t\t\t\tjustify-content: center;
\t\t\t\t}
\t\t\t\t.loader-svg-circle {
\t\t\t\t\tposition: absolute;
\t\t\t\t\twidth: 100%;
\t\t\t\t\theight: 100%;
\t\t\t\t\ttransform: rotate(-90deg); /* Start from top */
\t\t\t\t}
\t\t\t\t.circle-bg {
\t\t\t\t\tfill: none;
\t\t\t\t\tstroke: #f1f5f9;
\t\t\t\t\tstroke-width: 4;
\t\t\t\t}
\t\t\t\t.circle-draw {
\t\t\t\t\tfill: none;
\t\t\t\t\tstroke: #a9df51;
\t\t\t\t\tstroke-width: 4;
\t\t\t\t\tstroke-linecap: round;
\t\t\t\t\tstroke-dasharray: 283; /* 2 * PI * 45 */
\t\t\t\t\tstroke-dashoffset: 283;
\t\t\t\t\tanimation: drawCircleCounterClockwise 0.45s ease-out forwards; /* Reduced by 70% */
\t\t\t\t\ttransform-origin: center;
\t\t\t\t\ttransform: scaleY(-1); /* Flips for counterclockwise */
\t\t\t\t}
\t\t\t\t.loader-carrot-static {
\t\t\t\t\twidth: 55px;
\t\t\t\t\theight: auto;
\t\t\t\t\tz-index: 2;
\t\t\t\t\ttransform: translateX(-4px); /* Shifted slightly left */
\t\t\t\t}
\t\t\t\t.loader-text-lsdj {
\t\t\t\t\tdisplay: flex;
\t\t\t\t\tjustify-content: center;
\t\t\t\t\tgap: 8px;
\t\t\t\t\twidth: 100%;
\t\t\t\t\tmargin-right: -0.05em; /* Compensate for letter-spacing on the last letter */
\t\t\t\t}
\t\t\t\t.letter {
\t\t\t\t\tfont-size: 28px;
\t\t\t\t\tfont-weight: 900;
\t\t\t\t\tcolor: #234954;
\t\t\t\t\tletter-spacing: 0.05em;
\t\t\t\t\topacity: 0;
\t\t\t\t\ttransform: translateY(10px);
\t\t\t\t\tanimation: letterAppear 0.2s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; /* Faster appearance */
\t\t\t\t}
\t\t\t\t.letter:nth-child(1) {
\t\t\t\t\tanimation-delay: 0s;
\t\t\t\t}
\t\t\t\t.letter:nth-child(2) {
\t\t\t\t\tanimation-delay: 0.05s;
\t\t\t\t}
\t\t\t\t.letter:nth-child(3) {
\t\t\t\t\tanimation-delay: 0.10s;
\t\t\t\t}
\t\t\t\t.letter:nth-child(4) {
\t\t\t\t\tanimation-delay: 0.15s;
\t\t\t\t}

\t\t\t\t@keyframes drawCircleCounterClockwise {
\t\t\t\t\t0% {
\t\t\t\t\t\tstroke-dashoffset: 283;
\t\t\t\t\t}
\t\t\t\t\t100% {
\t\t\t\t\t\tstroke-dashoffset: 0;
\t\t\t\t\t}
\t\t\t\t}
\t\t\t\t@keyframes letterAppear {
\t\t\t\t\tto {
\t\t\t\t\t\topacity: 1;
\t\t\t\t\t\ttransform: translateY(0);
\t\t\t\t\t}
\t\t\t\t}

\t\t\t\t/* Sidebar brand icon */
\t\t\t\t.sidebar-brand-icon {
\t\t\t\t\tposition: relative;
\t\t\t\t\twidth: 68px;
\t\t\t\t\theight: 68px;
\t\t\t\t\tdisplay: flex;
\t\t\t\t\talign-items: center;
\t\t\t\t\tjustify-content: center;
\t\t\t\t\tcursor: pointer;
\t\t\t\t\tpadding: 6px;
\t\t\t\t}
\t\t\t\t.brand-square-svg {
\t\t\t\t\tposition: absolute;
\t\t\t\t\ttop: 0;
\t\t\t\t\tleft: 0;
\t\t\t\t\twidth: 100%;
\t\t\t\t\theight: 100%;
\t\t\t\t}
\t\t\t\t.brand-square-draw {
\t\t\t\t\tstroke: #a9df51;
\t\t\t\t\tstroke-width: 2.5;
\t\t\t\t\tstroke-linecap: round;
\t\t\t\t\tstroke-linejoin: round;
\t\t\t\t\tfill: none;
\t\t\t\t\tstroke-dasharray: 216;
\t\t\t\t\tstroke-dashoffset: 216;
\t\t\t\t\tanimation: drawSquare 3s ease-in-out infinite;
\t\t\t\t}
\t\t\t\t.brand-inner {
\t\t\t\t\tposition: relative;
\t\t\t\t\tz-index: 2;
\t\t\t\t\tdisplay: flex;
\t\t\t\t\talign-items: center;
\t\t\t\t\tjustify-content: center;
\t\t\t\t\twidth: 100%;
\t\t\t\t\theight: 100%;
\t\t\t\t}
\t\t\t\t.brand-carrot {
\t\t\t\t\twidth: 28px;
\t\t\t\t\theight: auto;
\t\t\t\t\tposition: absolute;
\t\t\t\t\ttransition: opacity 0.8s ease, transform 0.8s ease;
\t\t\t\t\topacity: 1;
\t\t\t\t\ttransform: scale(1);
\t\t\t\t}
\t\t\t\t.brand-carrot.hidden {
\t\t\t\t\topacity: 0;
\t\t\t\t\ttransform: scale(0.8);
\t\t\t\t}
\t\t\t\t.brand-lsdj {
\t\t\t\t\tposition: absolute;
\t\t\t\t\tfont-size: 18px;
\t\t\t\t\tfont-weight: 900;
\t\t\t\t\tcolor: #a9df51;
\t\t\t\t\ttransform: rotate(-45deg) scale(0.8);
\t\t\t\t\tletter-spacing: 0.05em;
\t\t\t\t\ttransition: opacity 0.8s ease, transform 0.8s ease;
\t\t\t\t\topacity: 0;
\t\t\t\t}
\t\t\t\t.brand-lsdj.visible {
\t\t\t\t\topacity: 1;
\t\t\t\t\ttransform: rotate(-45deg) scale(1);
\t\t\t\t}
\t\t\t\t@keyframes drawSquare {
\t\t\t\t\t0% {
\t\t\t\t\t\tstroke-dashoffset: 216;
\t\t\t\t\t} /* Empty */
\t\t\t\t\t50% {
\t\t\t\t\t\tstroke-dashoffset: 0;
\t\t\t\t\t} /* Fully drawn (1.5s) */
\t\t\t\t\t100% {
\t\t\t\t\t\tstroke-dashoffset: -216;
\t\t\t\t\t}; /* Undrawn (1.5s) */
\t\t\t\t}

\t\t\t\t/* Notification Styles */
\t\t\t\t.notifications-dropdown {
\t\t\t\t\tposition: absolute;
\t\t\t\t\ttop: calc(100% + 12px);
\t\t\t\t\tright: -80px;
\t\t\t\t\twidth: 360px;
\t\t\t\t\tbackground: #fff;
\t\t\t\t\tborder: 1px solid #eef2f6;
\t\t\t\t\tborder-radius: 12px;
\t\t\t\t\tbox-shadow: 0 20px 25px -5px rgba(0,0,0,0.05), 0 8px 10px -6px rgba(0,0,0,0.05);
\t\t\t\t\tz-index: 1000;
\t\t\t\t\tdisplay: none;
\t\t\t\t\tflex-direction: column;
\t\t\t\t\toverflow: hidden;
\t\t\t\t\ttransform-origin: top right;
\t\t\t\t\tanimation: dropdownAppear 0.2s cubic-bezier(0.16, 1, 0.3, 1);
\t\t\t\t}
\t\t\t\t@keyframes dropdownAppear {
\t\t\t\t\tfrom { opacity: 0; transform: scale(0.95) translateY(-10px); }
\t\t\t\t\tto { opacity: 1; transform: scale(1) translateY(0); }
\t\t\t\t}
\t\t\t\t.notifications-dropdown.open {
\t\t\t\t\tdisplay: flex;
\t\t\t\t}
\t\t\t\t.notif-header {
\t\t\t\t\tpadding: 16px 20px;
\t\t\t\t\tborder-bottom: 1px solid #f1f5f9;
\t\t\t\t\tdisplay: flex;
\t\t\t\t\talign-items: center;
\t\t\t\t\tjustify-content: space-between;
\t\t\t\t\tbackground: #fff;
\t\t\t\t}
\t\t\t\t.notif-list {
\t\t\t\t\tmax-height: 480px;
\t\t\t\t\toverflow-y: auto;
\t\t\t\t}
\t\t\t\t.notif-item {
\t\t\t\t\tpadding: 14px 20px;
\t\t\t\t\tborder-bottom: 1px solid #f8fafc;
\t\t\t\t\tdisplay: flex;
\t\t\t\t\tgap: 12px;
\t\t\t\t\ttransition: all 0.2s;
\t\t\t\t\ttext-decoration: none;
\t\t\t\t\tcolor: inherit;
\t\t\t\t\tposition: relative;
\t\t\t\t}
\t\t\t\t.notif-item:hover {
\t\t\t\t\tbackground: #f8fafc;
\t\t\t\t}
\t\t\t\t.notif-item.unread {
\t\t\t\t\tbackground: #fff;
\t\t\t\t}
\t\t\t\t.notif-item.unread::before {
\t\t\t\t\tcontent: '';
\t\t\t\t\tposition: absolute;
\t\t\t\t\tleft: 0;
\t\t\t\t\ttop: 0;
\t\t\t\t\tbottom: 0;
\t\t\t\t\twidth: 3px;
\t\t\t\t\tbackground: #4f46e5;
\t\t\t\t}
\t\t\t\t.notif-dot-indicator {
\t\t\t\t\twidth: 6px;
\t\t\t\t\theight: 6px;
\t\t\t\t\tborder-radius: 50%;
\t\t\t\t\tbackground: #4f46e5;
\t\t\t\t\tmargin-top: 6px;
\t\t\t\t\tflex-shrink: 0;
\t\t\t\t}
\t\t\t\t.notif-body {
\t\t\t\t\tflex: 1;
\t\t\t\t\tmin-width: 0;
\t\t\t\t}
\t\t\t\t.notif-title {
\t\t\t\t\tfont-size: 13px;
\t\t\t\t\tfont-weight: 800;
\t\t\t\t\tcolor: #1e293b;
\t\t\t\t\tmargin-bottom: 2px;
\t\t\t\t}
\t\t\t\t.notif-content {
\t\t\t\t\tfont-size: 12px;
\t\t\t\t\tcolor: #64748b;
\t\t\t\t\tline-height: 1.5;
\t\t\t\t}
\t\t\t\t.notif-time {
\t\t\t\t\tfont-size: 10px;
\t\t\t\t\tcolor: #94a3b8;
\t\t\t\t\tmargin-top: 6px;
\t\t\t\t\tfont-weight: 600;
\t\t\t\t\tdisplay: block;
\t\t\t\t}
\t\t\t\t.notif-empty {
\t\t\t\t\tpadding: 30px 16px;
\t\t\t\t\ttext-align: center;
\t\t\t\t\tcolor: var(--text-muted);
\t\t\t\t\tfont-size: 13px;
\t\t\t\t}
\t\t\t\t.notif-footer {
\t\t\t\t\tpadding: 10px;
\t\t\t\t\ttext-align: center;
\t\t\t\t\tborder-top: 1px solid var(--border);
\t\t\t\t\tbackground: var(--bg-main);
\t\t\t\t}
\t\t\t\t.notif-footer a {
\t\t\t\t\tfont-size: 12px;
\t\t\t\t\tfont-weight: 600;
\t\t\t\t\tcolor: var(--primary);
\t\t\t\t\ttext-decoration: none;
\t\t\t\t}
\t\t\t\t.unread-badge {
\t\t\t\t\tposition: absolute;
\t\t\t\t\ttop: -5px;
\t\t\t\t\tright: -5px;
\t\t\t\t\tbackground: #ef4444;
\t\t\t\t\tcolor: #fff;
\t\t\t\t\tfont-size: 10px;
\t\t\t\t\tfont-weight: 800;
\t\t\t\t\tmin-width: 16px;
\t\t\t\t\theight: 16px;
\t\t\t\t\tborder-radius: 8px;
\t\t\t\t\tdisplay: flex;
\t\t\t\t\talign-items: center;
\t\t\t\t\tjustify-content: center;
\t\t\t\t\tpadding: 0 4px;
\t\t\t\t\tborder: 2px solid #fff;
\t\t\t\t}
\t\t\t\t/* Global Toast Container */
\t\t\t\t#global-toast-container {
\t\t\t\t\tposition: fixed;
\t\t\t\t\ttop: 24px;
\t\t\t\t\tright: 24px;
\t\t\t\t\tz-index: 10000;
\t\t\t\t\tdisplay: flex;
\t\t\t\t\tflex-direction: column;
\t\t\t\t\tgap: 12px;
\t\t\t\t\tpointer-events: none;
\t\t\t\t}

\t\t\t\t.global-toast {
\t\t\t\t\tpointer-events: auto;
\t\t\t\t\tmin-width: 320px;
\t\t\t\t\tmax-width: 420px;
\t\t\t\t\tpadding: 16px;
\t\t\t\t\tborder-radius: 12px;
\t\t\t\t\tbackground: #ffffff;
\t\t\t\t\tbox-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
\t\t\t\t\tborder: 1px solid var(--border);
\t\t\t\t\tdisplay: flex;
\t\t\t\t\talign-items: center;
\t\t\t\t\tgap: 12px;
\t\t\t\t\ttransform: translateX(40px);
\t\t\t\t\topacity: 0;
\t\t\t\t\ttransition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
\t\t\t\t}

\t\t\t\t.global-toast.show {
\t\t\t\t\ttransform: translateX(0);
\t\t\t\t\topacity: 1;
\t\t\t\t}

\t\t\t\t.global-toast-success { color: #065f46; background: #ecfdf5; border-color: #a7f3d0; }
\t\t\t\t.global-toast-error { color: #991b1b; background: #fef2f2; border-color: #fecaca; }

\t\t\t\t/* Access Level Badges & Tokens */
\t\t\t\t.badge-access-aucun { color: #64748b; background: #f1f5f9; border: 1px solid #e2e8f0; }
\t\t\t\t.badge-access-total { color: #065f46; background: #ecfdf5; border: 1px solid #a7f3d0; }
\t\t\t\t.badge-access-admin { color: #4338ca; background: #eef2ff; border: 1px solid #c7d2fe; }
\t\t\t\t.badge-access-lecture-totale { color: #0369a1; background: #f0f9ff; border: 1px solid #bae6fd; }
\t\t\t\t.badge-access-lecture-magasin { color: #0f766e; background: #f0fdfa; border: 1px solid #99f6e4; }
\t\t\t\t.badge-access-personnel { color: #92400e; background: #fffbeb; border: 1px solid #fde68a; }

\t\t\t\t.access-select {
\t\t\t\t\ttransition: all 0.3s ease;
\t\t\t\t\ttext-transform: uppercase;
\t\t\t\t\tletter-spacing: 0.05em;
\t\t\t\t\tfont-weight: 800;
\t\t\t\t\tfont-size: 10px;
\t\t\t\t}
\t\t\t</style>
\t\t{% endblock %}



\t</head>
\t<body class=\"{% block body_class %}{% endblock %}\">
\t\t{% if app.request.get('_route') != 'app_login' %}
\t\t\t<div id=\"main-loader\">
\t\t\t\t<div class=\"loader-content\">
\t\t\t\t\t<div class=\"loader-circle-container\">
\t\t\t\t\t\t<svg class=\"loader-svg-circle\" viewbox=\"0 0 100 100\">
\t\t\t\t\t\t\t<circle class=\"circle-bg\" cx=\"50\" cy=\"50\" r=\"45\"></circle>
\t\t\t\t\t\t\t<circle class=\"circle-draw\" cx=\"50\" cy=\"50\" r=\"45\"></circle>
\t\t\t\t\t\t</svg>
\t\t\t\t\t\t<img src=\"{{ asset('logo.svg') }}\" class=\"loader-carrot-static\" alt=\"Logo\">
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"loader-text-lsdj\">
\t\t\t\t\t\t<span class=\"letter\">L</span>
\t\t\t\t\t\t<span class=\"letter\">S</span>
\t\t\t\t\t\t<span class=\"letter\">D</span>
\t\t\t\t\t\t<span class=\"letter\">J</span>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t{% endif %}

\t\t{% if app.user %}
\t\t\t<!-- Mobile overlay -->
\t\t\t<div class=\"sidebar-overlay\" id=\"sidebarOverlay\" onclick=\"closeSidebar()\"></div>

\t\t\t<!-- Sidebar -->
\t\t\t<aside class=\"sidebar\" id=\"sidebar\">
\t\t\t\t<div class=\"sidebar-header\">
\t\t\t\t\t<a href=\"{{ path('app_home') }}\" class=\"sidebar-brand-icon\" id=\"sidebarBrandIcon\" style=\"text-decoration: none; color: inherit; display: flex; align-items: center; width: 100%;\">
\t\t\t\t\t\t<svg class=\"brand-square-svg\" viewbox=\"0 0 60 60\" fill=\"none\">
\t\t\t\t\t\t\t<rect class=\"brand-square-draw\" x=\"3\" y=\"3\" width=\"54\" height=\"54\" rx=\"6\"></rect>
\t\t\t\t\t\t</svg>
\t\t\t\t\t\t<div class=\"brand-inner\" id=\"brandInner\">
\t\t\t\t\t\t\t<img src=\"{{ asset('logo.svg') }}\" class=\"brand-carrot\" id=\"brandCarrot\" alt=\"Logo\">
\t\t\t\t\t\t\t<span class=\"brand-lsdj\" id=\"brandLsdj\">LSDJ</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t</a>
\t\t\t\t</div>
\t\t\t\t<nav style=\"padding: 8px 0; flex: 1;\">
\t\t\t\t{# ============================================================
\t\t\t\t   UNIFIED NAV — Visibility controlled ONLY by MODULE_VIEW.
\t\t\t\t   If user has AUCUN_ACCES for a module → link is hidden.
\t\t\t\t   Any other access level → link is shown.
\t\t\t\t   Role checks are only used for label personalization.
\t\t\t\t   ============================================================ #}

\t\t\t\t{# Section label adapts to user role for context #}
\t\t\t\t<div class=\"nav-label\">{{ is_granted('ROLE_RESPONSABLE') ? 'Management' : 'Mon Espace' }}</div>

\t\t\t\t{# 1. Tableau de bord — visible if user has any non-AUCUN access #}
\t\t\t\t{% if is_granted('MODULE_VIEW', 'dashboard') %}
\t\t\t\t\t<a href=\"{{ path('app_dashboard') }}\" class=\"{{ app.request.get('_route') == 'app_dashboard' ? 'active' : '' }}\">
\t\t\t\t\t\t<svg width=\"18\" height=\"18\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t<path d=\"M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\"></path>
\t\t\t\t\t\t</svg>
\t\t\t\t\t\t<span class=\"sidebar-label\">Tableau de bord</span>
\t\t\t\t\t</a>
\t\t\t\t{% endif %}

\t\t\t\t{# 2. Gestion des Accès — visible if user has any non-AUCUN access #}
\t\t\t\t{% if is_granted('MODULE_VIEW', 'access_management') %}
\t\t\t\t\t<a href=\"{{ path('admin_access_index') }}\" class=\"{{ app.request.get('_route') == 'admin_access_index' ? 'active' : '' }}\">
\t\t\t\t\t\t<svg width=\"18\" height=\"18\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t<path d=\"M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z\"></path>
\t\t\t\t\t\t</svg>
\t\t\t\t\t\t<span class=\"sidebar-label\">Gestion des Accès</span>
\t\t\t\t\t</a>
\t\t\t\t{% endif %}

\t\t\t\t{# 3. RH Dropdown — shown if user has access to at least one RH module #}
\t\t\t\t{% if is_granted('MODULE_VIEW', 'agenda') or is_granted('MODULE_VIEW', 'users') or is_granted('MODULE_VIEW', 'rh_validation') or is_granted('MODULE_VIEW', 'rh_conge') or is_granted('MODULE_VIEW', 'rh_documents') %}
\t\t\t\t\t<div class=\"nav-dropdown\">
\t\t\t\t\t\t<button class=\"nav-dropdown-trigger\" onclick=\"toggleNavDropdown(this)\">
\t\t\t\t\t\t\t<svg fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t<path d=\"M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z\"></path>
\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t<span class=\"sidebar-label\">RH</span>
\t\t\t\t\t\t\t<svg class=\"chevron\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\"><path d=\"M19 9l-7 7-7-7\"></path></svg>
\t\t\t\t\t\t</button>
\t\t\t\t\t\t<div class=\"nav-dropdown-content\">
\t\t\t\t\t\t\t{% if is_granted('MODULE_VIEW', 'agenda') %}
\t\t\t\t\t\t\t\t<a href=\"{{ path('app_agenda') }}\" class=\"{{ app.request.get('_route') == 'app_agenda' ? 'active' : '' }}\">{{ is_granted('ROLE_RESPONSABLE') ? 'Planning' : 'Mon Planning' }}</a>
\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t{% if is_granted('MODULE_VIEW', 'rh_validation') %}
\t\t\t\t\t\t\t\t<a href=\"{{ path('app_rh_validation') }}\" class=\"{{ app.request.get('_route') starts with 'app_rh_validation' ? 'active' : '' }}\">
\t\t\t\t\t\t\t\t\t{{ is_granted('ROLE_RESPONSABLE') ? 'Validation des Horaires' : 'Valider mes heures' }}
\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t{% if is_granted('MODULE_VIEW', 'rh_conge') %}
\t\t\t\t\t\t\t\t<a href=\"{{ path('app_rh_conge') }}\" class=\"{{ app.request.get('_route') == 'app_rh_conge' ? 'active' : '' }}\">Demande de congé</a>
\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t{% if is_granted('MODULE_VIEW', 'rh_documents') %}
\t\t\t\t\t\t\t\t<a href=\"{{ path('app_rh_documents') }}\" class=\"{{ app.request.get('_route') == 'app_rh_documents' ? 'active' : '' }}\">{{ is_granted('ROLE_RESPONSABLE') ? 'Documents RH & Contrats' : 'Mes Documents RH' }}</a>
\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t{% if is_granted('MODULE_VIEW', 'users') %}
\t\t\t\t\t\t\t\t<a href=\"{{ path('admin_users_index') }}\" class=\"{{ app.request.get('_route') starts with 'admin_users' ? 'active' : '' }}\">Gestion du personnel</a>
\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t{% endif %}

\t\t\t\t{# 4. Transport & Logistique #}
\t\t\t\t{% if is_granted('MODULE_VIEW', 'transport_logistique') %}
\t\t\t\t\t<a href=\"{{ path('app_transport_logistique') }}\" class=\"{{ app.request.get('_route') == 'app_transport_logistique' ? 'active' : '' }}\">
\t\t\t\t\t\t<svg width=\"18\" height=\"18\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t<path d=\"M8 14h.01M16 14h.01M5 8h14M5 8a2 2 0 00-2 2v6a2 2 0 002 2h14a2 2 0 002-2v-6a2 2 0 00-2-2M5 8l1-3h12l1 3M9 14v1m6-1v1\"></path>
\t\t\t\t\t\t</svg>
\t\t\t\t\t\t<span class=\"sidebar-label\">Transport & logistique</span>
\t\t\t\t\t</a>
\t\t\t\t{% endif %}

\t\t\t\t{# 4. Maintenance Dropdown #}
\t\t\t\t{% if is_granted('MODULE_VIEW', 'maintenance_signalement') or is_granted('MODULE_VIEW', 'maintenance_suivi') %}
\t\t\t\t\t<div class=\"nav-dropdown\">
\t\t\t\t\t\t<button class=\"nav-dropdown-trigger\" onclick=\"toggleNavDropdown(this)\">
\t\t\t\t\t\t\t<svg fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t<path d=\"M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z\"></path>
\t\t\t\t\t\t\t\t<path d=\"M15 12a3 3 0 11-6 0 3 3 0 016 0z\"></path>
\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t<span class=\"sidebar-label\">Maintenance</span>
\t\t\t\t\t\t\t<svg class=\"chevron\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\"><path d=\"M19 9l-7 7-7-7\"></path></svg>
\t\t\t\t\t\t</button>
\t\t\t\t\t\t<div class=\"nav-dropdown-content\">
\t\t\t\t\t\t\t{% if is_granted('MODULE_VIEW', 'maintenance_signalement') %}
\t\t\t\t\t\t\t\t<a href=\"{{ path('app_maintenance_signalement') }}\" class=\"{{ app.request.get('_route') == 'app_maintenance_signalement' ? 'active' : '' }}\">Signalement matériel</a>
\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t{% if is_granted('MODULE_VIEW', 'maintenance_suivi') %}
\t\t\t\t\t\t\t\t<a href=\"{{ path('app_maintenance_suivi') }}\" class=\"{{ app.request.get('_route') == 'app_maintenance_suivi' ? 'active' : '' }}\">Suivi intervention</a>
\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t{% endif %}

\t\t\t\t{# 5. Commandes Dropdown #}
\t\t\t\t{% if is_granted('MODULE_VIEW', 'produits') or is_granted('MODULE_VIEW', 'commandes') %}
\t\t\t\t\t<div class=\"nav-dropdown\">
\t\t\t\t\t\t<button class=\"nav-dropdown-trigger\" onclick=\"toggleNavDropdown(this)\">
\t\t\t\t\t\t\t<svg fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t<path d=\"M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z\"></path>
\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t<span class=\"sidebar-label\">Commandes</span>
\t\t\t\t\t\t\t<svg class=\"chevron\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\"><path d=\"M19 9l-7 7-7-7\"></path></svg>
\t\t\t\t\t\t</button>
\t\t\t\t\t\t<div class=\"nav-dropdown-content\">
\t\t\t\t\t\t\t{% if is_granted('MODULE_VIEW', 'produits') %}
\t\t\t\t\t\t\t\t<a href=\"{{ path('app_produit_index') }}\" class=\"{{ app.request.get('_route') starts with 'app_produit' ? 'active' : '' }}\">Catégorie Produits</a>
\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t{% if is_granted('MODULE_VIEW', 'commandes') %}
\t\t\t\t\t\t\t\t<a href=\"{{ path('admin_commandes_index') }}\" class=\"{{ app.request.get('_route') starts with 'admin_commandes' ? 'active' : '' }}\">Gestion Commandes</a>
\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t{% endif %}

\t\t\t\t{# 6. Documents Généraux #}
\t\t\t\t{% if is_granted('MODULE_VIEW', 'documents') %}
\t\t\t\t<a href=\"{{ path('app_document_index') }}\" class=\"{{ app.request.get('_route') starts with 'app_document' ? 'active' : '' }}\">
\t\t\t\t\t<svg width=\"18\" height=\"18\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z\"/>
\t\t\t\t\t</svg>
\t\t\t\t\t<span class=\"sidebar-label\">Documents Généraux</span>
\t\t\t\t</a>
\t\t\t\t{% endif %}

\t\t\t\t{# 7. Contact Utile — always visible for all logged-in users #}
\t\t\t\t<div class=\"nav-label mt-4\">Informations</div>
\t\t\t\t<div class=\"nav-dropdown\">
\t\t\t\t\t<button class=\"nav-dropdown-trigger\" onclick=\"toggleNavDropdown(this)\">
\t\t\t\t\t\t<svg fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t<path d=\"M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z\"></path>
\t\t\t\t\t\t</svg>
\t\t\t\t\t\t<span class=\"sidebar-label\">Contact Utile</span>
\t\t\t\t\t\t<svg class=\"chevron\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\"><path d=\"M19 9l-7 7-7-7\"></path></svg>
\t\t\t\t\t</button>
\t\t\t\t\t<div class=\"nav-dropdown-content\">
\t\t\t\t\t\t<a href=\"{{ path('app_contact_olivet') }}\" class=\"{{ app.request.get('_route') == 'app_contact_olivet' ? 'active' : '' }}\">Olivet</a>
\t\t\t\t\t\t<a href=\"{{ path('app_contact_st_gervais') }}\" class=\"{{ app.request.get('_route') == 'app_contact_st_gervais' ? 'active' : '' }}\">St Gervais</a>
\t\t\t\t\t\t<a href=\"{{ path('app_contact_villemandeur') }}\" class=\"{{ app.request.get('_route') == 'app_contact_villemandeur' ? 'active' : '' }}\">Villemandeur</a>
\t\t\t\t\t\t<a href=\"{{ path('app_contact_noyers') }}\" class=\"{{ app.request.get('_route') == 'app_contact_noyers' ? 'active' : '' }}\">Noyers</a>
\t\t\t\t\t\t<a href=\"{{ path('app_contact_saran') }}\" class=\"{{ app.request.get('_route') == 'app_contact_saran' ? 'active' : '' }}\">Saran</a>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</nav>
\t\t\t</aside>
\t\t{% endif %}

\t\t<div class=\"main-content\" {% if not app.user %} style=\"margin-left: 0 !important;\" {% endif %}>
\t\t\t{% if app.user %}
\t\t\t\t<header
\t\t\t\t\tclass=\"top-bar\">
\t\t\t\t\t<!-- Left: Hamburger + Brand -->
\t\t\t\t\t<div style=\"display:flex; align-items:center; gap:10px; min-width:0; flex:1;\">
\t\t\t\t\t\t<button class=\"hamburger-btn\" id=\"hamburgerBtn\" onclick=\"toggleSidebar()\" aria-label=\"Menu\">
\t\t\t\t\t\t\t<svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M4 6h16M4 12h16M4 18h16\"/>
\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t</button>
\t\t\t\t\t\t{% if is_granted('ROLE_USER') %}
\t\t\t\t\t\t\t<a href=\"{{ path('app_home') }}\" class=\"top-bar-brand hover:text-indigo-600 transition-colors\">LES SAVEURS DU JARDIN</a>
\t\t\t\t\t\t{% endif %}
\t\t\t\t\t</div>

\t\t\t\t\t<!-- Right: Cart + User -->
\t\t\t\t\t<div style=\"display:flex; align-items:center; gap:10px; flex-shrink:0;\">
\t\t\t\t\t\t{% if is_granted('ROLE_USER') %}
\t\t\t\t\t\t\t{# Notifications Dropdown #}
\t\t\t\t\t\t\t<div class=\"dropdown\" id=\"notifDropdown\" style=\"position:relative;\">
\t\t\t\t\t\t\t\t<button type=\"button\" class=\"relative inline-flex items-center p-2 text-slate-500 hover:text-indigo-600 transition-colors bg-transparent border-0 cursor-pointer\" id=\"notifDropdownTrigger\" onclick=\"toggleNotifDropdown(event)\" aria-label=\"Notifications\">
\t\t\t\t\t\t\t\t\t<svg width=\"22\" height=\"22\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.2\" viewBox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t\t\t<path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0\" />
\t\t\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t\t\t{% if unreadNotificationsCount|default(0) > 0 %}
                                        <span class=\"absolute top-0 right-[-2px] flex h-4 w-4\" id=\"global-notif-badge\">
                                            <span class=\"animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75\"></span>
                                            <span class=\"relative inline-flex rounded-full h-4 w-4 bg-rose-600 text-[10px] font-black text-white items-center justify-center shadow-lg border-2 border-white\" id=\"global-notif-count\">
                                                {{ unreadNotificationsCount }}
                                            </span>
                                        </span>
\t\t\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t\t\t<div class=\"notifications-dropdown\" id=\"notifDropdownContent\">
\t\t\t\t\t\t\t\t\t<div class=\"notif-header\">
\t\t\t\t\t\t\t\t\t\t<span class=\"text-[10px] font-black uppercase tracking-widest text-slate-400\">Notifications</span>
\t\t\t\t\t\t\t\t\t\t{% if unreadNotificationsCount|default(0) > 0 %}
\t\t\t\t\t\t\t\t\t\t\t<button onclick=\"markAllNotificationsAsRead(event)\" class=\"text-[10px] font-black text-indigo-600 uppercase tracking-widest bg-transparent border-0 cursor-pointer hover:text-slate-900 transition-colors\">Tout marquer</button>
\t\t\t\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t<div class=\"notif-list\" id=\"notif-list-container\">
\t\t\t\t\t\t\t\t\t\t{% for notif in notifications|default([]) %}
\t\t\t\t\t\t\t\t\t\t\t<a href=\"{{ notif.link ?: '#' }}\" 
                                               id=\"notif-item-{{ notif.id }}\"
                                               onclick=\"handleNotifClick('{{ notif.id }}', event)\"
                                               class=\"notif-item {{ notif.isRead ? '' : 'unread' }}\">
\t\t\t\t\t\t\t\t\t\t\t\t{% if not notif.isRead %}
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"notif-dot-indicator\"></div>
\t\t\t\t\t\t\t\t\t\t\t\t{% else %}
                                                    <div class=\"w-[6px] flex-shrink-0\"></div>
\t\t\t\t\t\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"notif-body\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"notif-title\">{{ notif.title }}</div>
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"notif-content\">{{ notif.content }}</div>
\t\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"notif-time\">{{ notif.createdAt|date('d/m H:i') }}</span>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t\t{% else %}
\t\t\t\t\t\t\t\t\t\t\t<div class=\"notif-empty\">
                                                <div class=\"text-3xl mb-2 opacity-20\">🔔</div>
                                                <div class=\"text-[10px] font-black uppercase tracking-widest text-slate-300\">Aucune notification</div>
                                            </div>
\t\t\t\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t<div class=\"notif-footer\" style=\"padding: 12px; border-top: 1px solid #f8fafc;\">
\t\t\t\t\t\t\t\t\t\t<a href=\"{{ path('app_notifications_index') }}\" class=\"text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors no-underline block text-center\">Historique Complet</a>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t<a href=\"{{ path('app_cart_index') }}\" class=\"relative inline-flex items-center p-2 text-slate-500 hover:text-indigo-600 transition-colors group\" title=\"Mon Panier\">
\t\t\t\t\t\t\t\t<svg width=\"22\" height=\"22\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.2\" viewBox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t\t<path d=\"M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z\"></path>
\t\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t\t{% set cartCount = cart_item_count() %}
\t\t\t\t\t\t\t\t{% if cartCount > 0 %}
\t\t\t\t\t\t\t\t\t<span class=\"absolute top-0 right-[-2px] flex h-4 w-4\">
\t\t\t\t\t\t\t\t\t\t<span class=\"animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75\"></span>
\t\t\t\t\t\t\t\t\t\t<span class=\"relative inline-flex rounded-full h-4 w-4 bg-rose-600 text-[10px] font-black text-white items-center justify-center shadow-lg border-2 border-white\">
\t\t\t\t\t\t\t\t\t\t\t{{ cartCount }}
\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t{% endif %}

\t\t\t\t\t\t<div class=\"dropdown\" id=\"userDropdown\">
\t\t\t\t\t\t\t<button type=\"button\" class=\"dropdown-trigger\" id=\"userDropdownTrigger\" onclick=\"toggleUserDropdown(event)\" aria-expanded=\"false\" aria-haspopup=\"true\">
\t\t\t\t\t\t\t\t{% if app.user.photo %}
\t\t\t\t\t\t\t\t\t<div style=\"width:30px; height:30px; border-radius:50%; border:2px solid var(--primary); overflow:hidden; flex-shrink:0;\">
\t\t\t\t\t\t\t\t\t\t<img src=\"{{ path('app_media_user', {filename: app.user.photo}) }}\" style=\"width:100%; height:100%; object-fit:cover;\">
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t{% else %}
\t\t\t\t\t\t\t\t\t<div style=\"width:30px; height:30px; background:var(--primary); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:13px; border-radius:50%; flex-shrink:0;\">
\t\t\t\t\t\t\t\t\t\t{{ app.user.prenom|slice(0,1)|upper ?: app.user.userIdentifier|slice(0,1)|upper }}
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t\t<span style=\"font-size:13px; font-weight:700; color:var(--dark); max-width:90px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; display:none;\" class=\"user-name-label\">{{ app.user.prenom }}</span>
\t\t\t\t\t\t\t\t<svg width=\"12\" height=\"12\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" viewbox=\"0 0 24 24\" id=\"dropdownChevron\" style=\"transition:transform 0.2s; flex-shrink:0;\">
\t\t\t\t\t\t\t\t\t<path d=\"M19 9l-7 7-7-7\"></path>
\t\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t\t<div class=\"dropdown-content\" id=\"userDropdownContent\" style=\"display:none;\">
\t\t\t\t\t\t\t\t<div style=\"padding:12px 16px; border-bottom:1px solid var(--border);\">
\t\t\t\t\t\t\t\t\t<div style=\"font-size:11px; font-weight:800; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.1em;\">Compte</div>
\t\t\t\t\t\t\t\t\t<div style=\"font-size:13px; font-weight:600; color:var(--dark); margin-top:2px;\">{{ app.user.prenom }}
\t\t\t\t\t\t\t\t\t\t{{ app.user.nom }}</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t{% if is_granted('ROLE_USER') %}
\t\t\t\t\t\t\t\t\t<a href=\"{{ path('app_commande_my') }}\">
\t\t\t\t\t\t\t\t\t\t<svg width=\"16\" height=\"16\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t\t\t\t<path d=\"M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z\"></path>
\t\t\t\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t\t\t\tSuivi Commandes
\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t\t<a href=\"{{ path('app_settings') }}\">
\t\t\t\t\t\t\t\t\t<svg width=\"16\" height=\"16\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t\t\t<path d=\"M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z\"></path>
\t\t\t\t\t\t\t\t\t\t<path d=\"M15 12a3 3 0 11-6 0 3 3 0 016 0z\"></path>
\t\t\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t\t\tParamètres
\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t<div class=\"dropdown-divider\"></div>
\t\t\t\t\t\t\t\t<a href=\"{{ path('app_logout') }}\" style=\"color:#ef4444;\">
\t\t\t\t\t\t\t\t\t<svg width=\"16\" height=\"16\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewbox=\"0 0 24 24\">
\t\t\t\t\t\t\t\t\t\t<path d=\"M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1\"></path>
\t\t\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t\t\tDéconnexion
\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</header>
\t\t\t{% endif %}

\t\t\t<main class=\"{{ not app.user ? 'auth-layout' : 'page-wrapper' }}\">
\t\t\t\t{% if app.user %}
\t\t\t\t\t{% for message in app.flashes('success') %}
\t\t\t\t\t\t<div class=\"alert\">
\t\t\t\t\t\t\t<svg width=\"18\" height=\"18\" fill=\"currentColor\" viewbox=\"0 0 20 20\">
\t\t\t\t\t\t\t\t<path fill-rule=\"evenodd\" d=\"M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z\" clip-rule=\"evenodd\"></path>
\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t{{ message }}
\t\t\t\t\t\t</div>
\t\t\t\t\t{% endfor %}
\t\t\t\t\t{% for message in app.flashes('error') %}
\t\t\t\t\t\t<div class=\"alert alert-error\">
\t\t\t\t\t\t\t<svg width=\"18\" height=\"18\" fill=\"currentColor\" viewbox=\"0 0 20 20\">
\t\t\t\t\t\t\t\t<path fill-rule=\"evenodd\" d=\"M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z\" clip-rule=\"evenodd\"></path>
\t\t\t\t\t\t\t</svg>
\t\t\t\t\t\t\t{{ message }}
\t\t\t\t\t\t</div>
\t\t\t\t\t{% endfor %}
\t\t\t\t{% endif %}

\t\t\t\t{% block body %}{% endblock %}
\t\t\t</main>
\t\t</div>

\t\t<div id=\"global-toast-container\"></div>

\t\t<script>
\t\t\twindow.showToast = function(message, type = 'success') {
\t\t\t\tconst container = document.getElementById('global-toast-container');
\t\t\t\tconst toast = document.createElement('div');
\t\t\t\ttoast.className = `global-toast global-toast-\${type}`;
\t\t\t\t
\t\t\t\tconst icon = type === 'success' 
\t\t\t\t\t? '<svg width=\"20\" height=\"20\" fill=\"currentColor\" viewBox=\"0 0 20 20\"><path fill-rule=\"evenodd\" d=\"M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z\" clip-rule=\"evenodd\"></path></svg>'
\t\t\t\t\t: '<svg width=\"20\" height=\"20\" fill=\"currentColor\" viewBox=\"0 0 20 20\"><path fill-rule=\"evenodd\" d=\"M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z\" clip-rule=\"evenodd\"></path></svg>';

\t\t\t\ttoast.innerHTML = `
\t\t\t\t\t<div class=\"shrink-0\">\${icon}</div>
\t\t\t\t\t<div class=\"text-sm font-bold flex-1\">\${message}</div>
\t\t\t\t`;
\t\t\t\t
\t\t\t\tcontainer.appendChild(toast);
\t\t\t\t
\t\t\t\t// Force reflow
\t\t\t\ttoast.offsetHeight;
\t\t\t\ttoast.classList.add('show');
\t\t\t\t
\t\t\t\tsetTimeout(() => {
\t\t\t\t\ttoast.classList.remove('show');
\t\t\t\t\tsetTimeout(() => toast.remove(), 400);
\t\t\t\t}, 4000);
\t\t\t};
\t\t</script>
\t\t<script src=\"{{ asset('js/base.js') }}\"></script>
\t\t<script src=\"{{ asset('js/modal.js') }}\"></script>
\t</body>
</html>

", "base.html.twig", "/var/www/html/templates/base.html.twig");
    }
}
