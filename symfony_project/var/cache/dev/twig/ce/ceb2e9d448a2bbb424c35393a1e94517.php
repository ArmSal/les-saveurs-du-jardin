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

/* admin/access/index.html.twig */
class __TwigTemplate_bc71d7912da84786250c3d8d30ba622a extends Template
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

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
            'stylesheets' => [$this, 'block_stylesheets'],
            'javascripts' => [$this, 'block_javascripts'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/access/index.html.twig"));

        $this->parent = $this->load("base.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        yield "Gestion des Accès | LSDJ";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 6
        yield "<div class=\"min-h-screen bg-slate-50 py-2 sm:py-4 px-0 sm:px-4 lg:px-8\" x-data=\"accessManager()\">
    <div class=\"max-w-7xl mx-auto\">
        
        ";
        // line 10
        yield "        <div class=\"mb-4 sm:mb-6 px-3 sm:px-0\">
            <div class=\"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3\">
                <div>
                    <h1 class=\"text-xl sm:text-2xl font-black text-slate-900 tracking-tight\">Gestion des Accès</h1>
                    <p class=\"text-xs text-slate-500 mt-0.5\">Configuration des permissions par module et rôle</p>
                </div>
            </div>
        </div>

        ";
        // line 20
        yield "        <div class=\"grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-4 mb-4 sm:mb-6 px-3 sm:px-0\">
            <div class=\"bg-white rounded-lg p-3 shadow-sm border border-slate-200\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Rôles</div>
                <div class=\"text-lg sm:text-xl font-black text-slate-800\">";
        // line 23
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["roles"]) || array_key_exists("roles", $context) ? $context["roles"] : (function () { throw new RuntimeError('Variable "roles" does not exist.', 23, $this->source); })())), "html", null, true);
        yield "</div>
            </div>
            <div class=\"bg-white rounded-lg p-3 shadow-sm border border-slate-200\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Magasins</div>
                <div class=\"text-lg sm:text-xl font-black text-slate-800\">";
        // line 27
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["magasins"]) || array_key_exists("magasins", $context) ? $context["magasins"] : (function () { throw new RuntimeError('Variable "magasins" does not exist.', 27, $this->source); })())), "html", null, true);
        yield "</div>
            </div>
            <div class=\"bg-white rounded-lg p-3 shadow-sm border border-slate-200\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Modules</div>
                <div class=\"text-lg sm:text-xl font-black text-slate-800\">";
        // line 31
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["modules"]) || array_key_exists("modules", $context) ? $context["modules"] : (function () { throw new RuntimeError('Variable "modules" does not exist.', 31, $this->source); })())), "html", null, true);
        yield "</div>
            </div>
            <div class=\"bg-white rounded-lg p-3 shadow-sm border border-slate-200\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Permissions</div>
                <div class=\"text-lg sm:text-xl font-black text-teal-600\">";
        // line 35
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["roles"]) || array_key_exists("roles", $context) ? $context["roles"] : (function () { throw new RuntimeError('Variable "roles" does not exist.', 35, $this->source); })())) * Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["modules"]) || array_key_exists("modules", $context) ? $context["modules"] : (function () { throw new RuntimeError('Variable "modules" does not exist.', 35, $this->source); })()))), "html", null, true);
        yield "</div>
            </div>
        </div>

        ";
        // line 40
        yield "        <div class=\"px-3 sm:px-0 mb-4\">
            <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 p-1 flex gap-1\">
                <button 
                    @click=\"activeTab = 'matrix'\" 
                    :class=\"{ 'bg-teal-500 text-white shadow': activeTab === 'matrix', 'text-slate-600 hover:bg-slate-100': activeTab !== 'matrix' }\"
                    class=\"flex-1 py-2 px-2 rounded-md text-[11px] font-bold uppercase tracking-wider transition-all duration-200\">
                    <span class=\"hidden sm:inline\">Matrice des Accès</span>
                    <span class=\"sm:hidden\">Accès</span>
                </button>
                <button 
                    @click=\"activeTab = 'roles'\" 
                    :class=\"{ 'bg-indigo-500 text-white shadow': activeTab === 'roles', 'text-slate-600 hover:bg-slate-100': activeTab !== 'roles' }\"
                    class=\"flex-1 py-2 px-2 rounded-md text-[11px] font-bold uppercase tracking-wider transition-all duration-200\">
                    <span class=\"hidden sm:inline\">Gestion des Rôles</span>
                    <span class=\"sm:hidden\">Rôles</span>
                </button>
                <button 
                    @click=\"activeTab = 'magasins'\" 
                    :class=\"{ 'bg-emerald-500 text-white shadow': activeTab === 'magasins', 'text-slate-600 hover:bg-slate-100': activeTab !== 'magasins' }\"
                    class=\"flex-1 py-2 px-2 rounded-md text-[11px] font-bold uppercase tracking-wider transition-all duration-200\">
                    <span class=\"hidden sm:inline\">Gestion des Magasins</span>
                    <span class=\"sm:hidden\">Magasins</span>
                </button>
            </div>
        </div>

        ";
        // line 67
        yield "        <div x-show=\"activeTab === 'matrix'\" x-collapse class=\"px-3 sm:px-0 space-y-3\">
            
            ";
        // line 70
        yield "            <div class=\"relative max-w-sm\">
                <div class=\"absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none\">
                    <svg class=\"h-4 w-4 text-slate-400\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                        <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z\"/>
                    </svg>
                </div>
                <input 
                    type=\"text\" 
                    x-model=\"moduleSearch\"
                    placeholder=\"Rechercher un module...\" 
                    class=\"w-full pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 outline-none focus:border-teal-400 focus:ring-1 focus:ring-teal-100 transition-all shadow-sm\">
            </div>

            ";
        // line 84
        yield "            <div class=\"grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-3\">
                ";
        // line 85
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["modules"]) || array_key_exists("modules", $context) ? $context["modules"] : (function () { throw new RuntimeError('Variable "modules" does not exist.', 85, $this->source); })()));
        foreach ($context['_seq'] as $context["key"] => $context["label"]) {
            // line 86
            yield "                    <div 
                        x-show=\"'";
            // line 87
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), $context["label"]), "html", null, true);
            yield " ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), $context["key"]), "html", null, true);
            yield "'.includes(moduleSearch.toLowerCase()) || moduleSearch === ''\"
                        class=\"bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden\"
                        x-data=\"{ expanded: false }\">
                        
                        ";
            // line 92
            yield "                        <button 
                            @click=\"expanded = !expanded\"
                            class=\"w-full flex items-center justify-between p-3 sm:p-4 bg-gradient-to-r from-slate-50 to-white hover:from-slate-100 hover:to-slate-50 transition-all\">
                            <div class=\"flex items-center gap-3\">
                                <div class=\"w-9 h-9 rounded-lg bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center text-white shadow-sm shrink-0\">
                                    ";
            // line 97
            if (($context["key"] == "dashboard")) {
                // line 98
                yield "                                        <svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z\"/></svg>
                                    ";
            } elseif ((            // line 99
$context["key"] == "documents")) {
                // line 100
                yield "                                        <svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\"/></svg>
                                    ";
            } elseif ((            // line 101
$context["key"] == "users")) {
                // line 102
                yield "                                        <svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z\"/></svg>
                                    ";
            } elseif ((            // line 103
$context["key"] == "agenda")) {
                // line 104
                yield "                                        <svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z\"/></svg>
                                    ";
            } elseif ((            // line 105
$context["key"] == "access_management")) {
                // line 106
                yield "                                        <svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z\"/></svg>
                                    ";
            } else {
                // line 108
                yield "                                        <svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-3-1l-2-2m0 0l-2 2m2-2v10\"/></svg>
                                    ";
            }
            // line 110
            yield "                                </div>
                                <div class=\"text-left min-w-0\">
                                    <h3 class=\"text-sm font-bold text-slate-800 truncate\">";
            // line 112
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["label"], "html", null, true);
            yield "</h3>
                                    <p class=\"text-[9px] text-slate-400 font-medium\">";
            // line 113
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["key"], "html", null, true);
            yield "</p>
                                </div>
                            </div>
                            <svg 
                                class=\"w-5 h-5 text-slate-400 transition-transform duration-200 shrink-0 ml-2\"
                                :class=\"{ 'rotate-180': expanded }\"
                                fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                                <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 9l-7 7-7-7\"/>
                            </svg>
                        </button>

                        ";
            // line 125
            yield "                        <div x-show=\"expanded\" x-collapse class=\"border-t border-slate-100\">
                            <div class=\"divide-y divide-slate-50\">
                                ";
            // line 127
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["roles"]) || array_key_exists("roles", $context) ? $context["roles"] : (function () { throw new RuntimeError('Variable "roles" does not exist.', 127, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["role"]) {
                // line 128
                yield "                                    ";
                $context["currentAccess"] = (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["matrix"] ?? null), $context["key"], [], "array", false, true, false, 128), CoreExtension::getAttribute($this->env, $this->source, $context["role"], "name", [], "any", false, false, false, 128), [], "array", true, true, false, 128) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["matrix"]) || array_key_exists("matrix", $context) ? $context["matrix"] : (function () { throw new RuntimeError('Variable "matrix" does not exist.', 128, $this->source); })()), $context["key"], [], "array", false, false, false, 128), CoreExtension::getAttribute($this->env, $this->source, $context["role"], "name", [], "any", false, false, false, 128), [], "array", false, false, false, 128)))) ? (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["matrix"]) || array_key_exists("matrix", $context) ? $context["matrix"] : (function () { throw new RuntimeError('Variable "matrix" does not exist.', 128, $this->source); })()), $context["key"], [], "array", false, false, false, 128), CoreExtension::getAttribute($this->env, $this->source, $context["role"], "name", [], "any", false, false, false, 128), [], "array", false, false, false, 128)) : ("AUCUN_ACCES"));
                // line 129
                yield "                                    ";
                // line 130
                yield "                                    ";
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["role"], "name", [], "any", false, false, false, 130) == "ROLE_DIRECTEUR")) {
                    // line 131
                    yield "                                        ";
                    $context["currentAccess"] = "ACCES_TOTAL";
                    // line 132
                    yield "                                    ";
                }
                // line 133
                yield "                                    <div class=\"p-2 sm:p-3 flex items-center justify-between gap-3 hover:bg-slate-50 transition-colors\">
                                        <div class=\"flex-1 min-w-0\">
                                            <div class=\"text-[11px] font-semibold text-slate-700 truncate\">";
                // line 135
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["role"], "label", [], "any", false, false, false, 135), "html", null, true);
                yield "</div>
                                            <div class=\"text-[9px] text-slate-400\">";
                // line 136
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["role"], "name", [], "any", false, false, false, 136), "html", null, true);
                yield "</div>
                                        </div>
                                        <div class=\"relative shrink-0\">
                                            <select
                                                ";
                // line 140
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["role"], "name", [], "any", false, false, false, 140) == "ROLE_DIRECTEUR")) {
                    yield "disabled";
                }
                // line 141
                yield "                                                onchange=\"updatePermission('";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["key"], "html", null, true);
                yield "', '";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["role"], "name", [], "any", false, false, false, 141), "html", null, true);
                yield "', this.value)\"
                                                data-original=\"";
                // line 142
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 142, $this->source); })()), "html", null, true);
                yield "\"
                                                class=\"access-select w-32 sm:w-40 text-[10px] font-bold uppercase tracking-wider border border-slate-200 rounded-md px-2 py-1.5 focus:ring-2 focus:ring-teal-100 focus:border-teal-400 outline-none cursor-pointer transition-all
                                                ";
                // line 144
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["role"], "name", [], "any", false, false, false, 144) == "ROLE_DIRECTEUR")) {
                    // line 145
                    yield "                                                    bg-emerald-50 text-emerald-600 border-emerald-200
                                                ";
                } elseif ((                // line 146
(isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 146, $this->source); })()) == "AUCUN_ACCES")) {
                    // line 147
                    yield "                                                    bg-slate-100 text-slate-500 border-slate-200
                                                ";
                } elseif ((                // line 148
(isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 148, $this->source); })()) == "ACCES_TOTAL")) {
                    // line 149
                    yield "                                                    bg-emerald-50 text-emerald-600 border-emerald-200
                                                ";
                } elseif ((                // line 150
(isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 150, $this->source); })()) == "ADMIN_MAGASIN")) {
                    // line 151
                    yield "                                                    bg-indigo-50 text-indigo-600 border-indigo-200
                                                ";
                } elseif ((                // line 152
(isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 152, $this->source); })()) == "LECTURE_TOTALE")) {
                    // line 153
                    yield "                                                    bg-sky-50 text-sky-600 border-sky-200
                                                ";
                } elseif ((                // line 154
(isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 154, $this->source); })()) == "LECTURE_MAGASIN")) {
                    // line 155
                    yield "                                                    bg-teal-50 text-teal-600 border-teal-200
                                                ";
                } elseif ((                // line 156
(isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 156, $this->source); })()) == "ACCES_PERSONNEL")) {
                    // line 157
                    yield "                                                    bg-amber-50 text-amber-600 border-amber-200
                                                ";
                } else {
                    // line 159
                    yield "                                                    bg-slate-100 text-slate-500 border-slate-200
                                                ";
                }
                // line 160
                yield "\"
                                            >
                                                ";
                // line 162
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable((isset($context["accessLevels"]) || array_key_exists("accessLevels", $context) ? $context["accessLevels"] : (function () { throw new RuntimeError('Variable "accessLevels" does not exist.', 162, $this->source); })()));
                foreach ($context['_seq'] as $context["_key"] => $context["level"]) {
                    // line 163
                    yield "                                                    ";
                    if (($context["key"] == "produits")) {
                        // line 164
                        yield "                                                    ";
                        if (CoreExtension::inFilter($context["level"], ["AUCUN_ACCES", "LECTURE_TOTALE", "ACCES_TOTAL"])) {
                            // line 165
                            yield "                                                            <option value=\"";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["level"], "html", null, true);
                            yield "\" ";
                            yield ((((isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 165, $this->source); })()) == $context["level"])) ? ("selected") : (""));
                            yield ">
                                                                ";
                            // line 166
                            if (($context["level"] == "LECTURE_TOTALE")) {
                                yield "UTILISATEUR";
                            } elseif (($context["level"] == "ACCES_TOTAL")) {
                                yield "ACCES TOTAL";
                            } else {
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::replace($context["level"], ["_" => " "]), "html", null, true);
                            }
                            // line 167
                            yield "                                                            </option>
                                                        ";
                        }
                        // line 169
                        yield "                                                    ";
                    } elseif (($context["key"] == "documents")) {
                        // line 170
                        yield "                                                        ";
                        if (CoreExtension::inFilter($context["level"], ["AUCUN_ACCES", "ACCES_TOTAL", "LECTURE_TOTALE"])) {
                            // line 171
                            yield "                                                            <option value=\"";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["level"], "html", null, true);
                            yield "\" ";
                            yield ((((isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 171, $this->source); })()) == $context["level"])) ? ("selected") : (""));
                            yield ">
                                                                ";
                            // line 172
                            if (($context["level"] == "ACCES_TOTAL")) {
                                yield "ACCES TOTAL";
                            } elseif (($context["level"] == "LECTURE_TOTALE")) {
                                yield "LECTURE TOTALE";
                            } else {
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::replace($context["level"], ["_" => " "]), "html", null, true);
                            }
                            // line 173
                            yield "                                                            </option>
                                                        ";
                        }
                        // line 175
                        yield "                                                    ";
                    } elseif (CoreExtension::inFilter($context["key"], ["access_management", "dashboard"])) {
                        // line 176
                        yield "                                                        ";
                        if (CoreExtension::inFilter($context["level"], ["AUCUN_ACCES", "ACCES_TOTAL"])) {
                            // line 177
                            yield "                                                            <option value=\"";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["level"], "html", null, true);
                            yield "\" ";
                            yield ((((isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 177, $this->source); })()) == $context["level"])) ? ("selected") : (""));
                            yield ">
                                                                ";
                            // line 178
                            if (($context["level"] == "ACCES_TOTAL")) {
                                yield "ACCES TOTAL";
                            } else {
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::replace($context["level"], ["_" => " "]), "html", null, true);
                            }
                            // line 179
                            yield "                                                            </option>
                                                        ";
                        }
                        // line 181
                        yield "                                                    ";
                    } elseif (($context["key"] == "user_observations")) {
                        // line 182
                        yield "                                                        ";
                        if (CoreExtension::inFilter($context["level"], ["AUCUN_ACCES", "ADMIN_MAGASIN", "ACCES_TOTAL"])) {
                            // line 183
                            yield "                                                            <option value=\"";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["level"], "html", null, true);
                            yield "\" ";
                            yield ((((isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 183, $this->source); })()) == $context["level"])) ? ("selected") : (""));
                            yield ">
                                                                ";
                            // line 184
                            if (($context["level"] == "ACCES_TOTAL")) {
                                yield "ACCES TOTAL";
                            } elseif (($context["level"] == "ADMIN_MAGASIN")) {
                                yield "ACCES MAGASIN";
                            } else {
                                yield "AUCUN ACCES";
                            }
                            // line 185
                            yield "                                                            </option>
                                                        ";
                        }
                        // line 187
                        yield "                                                    ";
                    } elseif (($context["key"] == "transport_logistique")) {
                        // line 188
                        yield "                                                        ";
                        if (CoreExtension::inFilter($context["level"], ["AUCUN_ACCES", "ACCES_TOTAL"])) {
                            // line 189
                            yield "                                                            <option value=\"";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["level"], "html", null, true);
                            yield "\" ";
                            yield ((((isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 189, $this->source); })()) == $context["level"])) ? ("selected") : (""));
                            yield ">
                                                                ";
                            // line 190
                            if (($context["level"] == "ACCES_TOTAL")) {
                                yield "ACCES TOTAL";
                            } else {
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::replace($context["level"], ["_" => " "]), "html", null, true);
                            }
                            // line 191
                            yield "                                                            </option>
                                                        ";
                        }
                        // line 193
                        yield "                                                    ";
                    } elseif (($context["key"] == "maintenance_suivi")) {
                        // line 194
                        yield "                                                        ";
                        if (CoreExtension::inFilter($context["level"], ["AUCUN_ACCES", "ACCES_TOTAL", "ACCES_PERSONNEL"])) {
                            // line 195
                            yield "                                                            <option value=\"";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["level"], "html", null, true);
                            yield "\" ";
                            yield ((((isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 195, $this->source); })()) == $context["level"])) ? ("selected") : (""));
                            yield ">
                                                                ";
                            // line 196
                            if (($context["level"] == "ACCES_TOTAL")) {
                                yield "ACCES TOTAL";
                            } elseif (($context["level"] == "ACCES_PERSONNEL")) {
                                yield "ACCES PERSONNEL";
                            } else {
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::replace($context["level"], ["_" => " "]), "html", null, true);
                            }
                            // line 197
                            yield "                                                            </option>
                                                        ";
                        }
                        // line 199
                        yield "                                                    ";
                    } elseif (($context["key"] == "commandes")) {
                        // line 200
                        yield "                                                        ";
                        if (CoreExtension::inFilter($context["level"], ["AUCUN_ACCES", "ACCES_TOTAL", "ADMIN_MAGASIN"])) {
                            // line 201
                            yield "                                                            <option value=\"";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["level"], "html", null, true);
                            yield "\" ";
                            yield ((((isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 201, $this->source); })()) == $context["level"])) ? ("selected") : (""));
                            yield ">
                                                                ";
                            // line 202
                            if (($context["level"] == "ACCES_TOTAL")) {
                                yield "ACCES TOTAL";
                            } elseif (($context["level"] == "ADMIN_MAGASIN")) {
                                yield "ACCES MAGASIN";
                            } else {
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::replace($context["level"], ["_" => " "]), "html", null, true);
                            }
                            // line 203
                            yield "                                                            </option>
                                                        ";
                        }
                        // line 205
                        yield "                                                    ";
                    } elseif (CoreExtension::inFilter($context["key"], ["rh_validation", "rh_documents"])) {
                        // line 206
                        yield "                                                        ";
                        if (CoreExtension::inFilter($context["level"], ["AUCUN_ACCES", "ACCES_TOTAL", "ADMIN_MAGASIN", "ACCES_PERSONNEL"])) {
                            // line 207
                            yield "                                                            <option value=\"";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["level"], "html", null, true);
                            yield "\" ";
                            yield ((((isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 207, $this->source); })()) == $context["level"])) ? ("selected") : (""));
                            yield ">
                                                                ";
                            // line 208
                            if (($context["level"] == "ACCES_TOTAL")) {
                                yield "ACCES TOTAL";
                            } elseif (($context["level"] == "ADMIN_MAGASIN")) {
                                yield "ACCES MAGASIN";
                            } elseif (($context["level"] == "ACCES_PERSONNEL")) {
                                yield "ACCES PERSONNEL";
                            } else {
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::replace($context["level"], ["_" => " "]), "html", null, true);
                            }
                            // line 209
                            yield "                                                            </option>
                                                        ";
                        }
                        // line 211
                        yield "                                                    ";
                    } elseif (($context["key"] == "rh_conge")) {
                        // line 212
                        yield "                                                        ";
                        if (CoreExtension::inFilter($context["level"], ["AUCUN_ACCES", "ACCES_TOTAL", "ADMIN_MAGASIN", "ACCES_PERSONNEL"])) {
                            // line 213
                            yield "                                                            <option value=\"";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["level"], "html", null, true);
                            yield "\" ";
                            yield ((((isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 213, $this->source); })()) == $context["level"])) ? ("selected") : (""));
                            yield ">
                                                                ";
                            // line 214
                            if (($context["level"] == "ACCES_TOTAL")) {
                                yield "ACCES TOTAL";
                            } elseif (($context["level"] == "ADMIN_MAGASIN")) {
                                yield "ACCES MAGASIN";
                            } elseif (($context["level"] == "ACCES_PERSONNEL")) {
                                yield "ACCES PERSONNEL";
                            } else {
                                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::replace($context["level"], ["_" => " "]), "html", null, true);
                            }
                            // line 215
                            yield "                                                            </option>
                                                        ";
                        }
                        // line 217
                        yield "                                                    ";
                    } elseif ((!CoreExtension::inFilter($context["key"], ["rh_validation", "rh_documents", "rh_conge"]) || !CoreExtension::inFilter($context["level"], ["LECTURE_TOTALE", "LECTURE_MAGASIN"]))) {
                        // line 218
                        yield "                                                        <option value=\"";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["level"], "html", null, true);
                        yield "\" ";
                        yield ((((isset($context["currentAccess"]) || array_key_exists("currentAccess", $context) ? $context["currentAccess"] : (function () { throw new RuntimeError('Variable "currentAccess" does not exist.', 218, $this->source); })()) == $context["level"])) ? ("selected") : (""));
                        yield ">
                                                            ";
                        // line 219
                        if (($context["level"] == "ACCES_TOTAL")) {
                            yield "ACCES TOTAL";
                        } elseif (($context["level"] == "ADMIN_MAGASIN")) {
                            yield "ACCES MAGASIN";
                        } elseif (($context["level"] == "LECTURE_TOTALE")) {
                            yield "LECTURE TOTALE";
                        } elseif (($context["level"] == "LECTURE_MAGASIN")) {
                            yield "LECTURE MAGASIN";
                        } elseif (($context["level"] == "ACCES_PERSONNEL")) {
                            yield "ACCES PERSONNEL";
                        } else {
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::replace($context["level"], ["_" => " "]), "html", null, true);
                        }
                        // line 220
                        yield "                                                        </option>
                                                    ";
                    }
                    // line 222
                    yield "                                                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['level'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 223
                yield "                                            </select>
                                        </div>
                                    </div>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['role'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 227
            yield "                            </div>
                        </div>
                    </div>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['key'], $context['label'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 231
        yield "            </div>
        </div>

        ";
        // line 235
        yield "        <div x-show=\"activeTab === 'roles'\" x-collapse class=\"px-3 sm:px-0\">
            <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden\">
                <div class=\"p-3 sm:p-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white\">
                    <div class=\"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2\">
                        <h2 class=\"text-sm font-bold text-slate-800\">Liste des Rôles</h2>
                        <button @click=\"showAddRoleModal = true\" class=\"inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg text-[11px] font-bold uppercase tracking-wider transition-all\">
                            <svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 4v16m8-8H4\"/></svg>
                            Nouveau Rôle
                        </button>
                    </div>
                </div>
                <div class=\"divide-y divide-slate-100\">
                    ";
        // line 247
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["roles"]) || array_key_exists("roles", $context) ? $context["roles"] : (function () { throw new RuntimeError('Variable "roles" does not exist.', 247, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["role"]) {
            // line 248
            yield "                        <div class=\"p-3 sm:p-4 flex items-center justify-between gap-3 hover:bg-slate-50 transition-colors\">
                            <div class=\"flex-1 min-w-0\">
                                <div class=\"flex items-center gap-2\">
                                    <span class=\"text-sm font-semibold text-slate-800\">";
            // line 251
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["role"], "label", [], "any", false, false, false, 251), "html", null, true);
            yield "</span>
                                    ";
            // line 252
            if (((CoreExtension::getAttribute($this->env, $this->source, $context["role"], "name", [], "any", false, false, false, 252) == "ROLE_DIRECTEUR") || (CoreExtension::getAttribute($this->env, $this->source, $context["role"], "name", [], "any", false, false, false, 252) == "ROLE_USER"))) {
                // line 253
                yield "                                        <span class=\"px-1.5 py-0.5 bg-slate-100 text-slate-500 rounded text-[9px] font-bold\">SYSTÈME</span>
                                    ";
            }
            // line 255
            yield "                                    ";
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["role"], "isContact", [], "any", false, false, false, 255)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 256
                yield "                                        <span class=\"px-1.5 py-0.5 bg-sky-100 text-sky-600 rounded text-[9px] font-bold\">CONTACT MAGASIN</span>
                                    ";
            }
            // line 258
            yield "                                </div>
                                <div class=\"text-[10px] text-slate-400 font-mono mt-0.5\">";
            // line 259
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["role"], "name", [], "any", false, false, false, 259), "html", null, true);
            yield "</div>
                            </div>
                            <div class=\"flex items-center gap-1\">
                                <button 
                                    @click=\"editRoleId = ";
            // line 263
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["role"], "id", [], "any", false, false, false, 263), "html", null, true);
            yield "; editRoleLabel = '";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["role"], "label", [], "any", false, false, false, 263), "html", null, true);
            yield "'; editRoleContact = ";
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["role"], "isContact", [], "any", false, false, false, 263)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("true") : ("false"));
            yield "; showEditRoleModal = true\"
                                    class=\"p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all\"
                                    title=\"Modifier\">
                                    <svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z\"/></svg>
                                </button>
                                ";
            // line 268
            if (((CoreExtension::getAttribute($this->env, $this->source, $context["role"], "name", [], "any", false, false, false, 268) != "ROLE_DIRECTEUR") && (CoreExtension::getAttribute($this->env, $this->source, $context["role"], "name", [], "any", false, false, false, 268) != "ROLE_USER"))) {
                // line 269
                yield "                                    <button 
                                        @click=\"deleteRole(";
                // line 270
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["role"], "id", [], "any", false, false, false, 270), "html", null, true);
                yield ", '";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["role"], "label", [], "any", false, false, false, 270), "html", null, true);
                yield "')\"
                                        class=\"p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all\"
                                        title=\"Supprimer\">
                                        <svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16\"/></svg>
                                    </button>
                                ";
            }
            // line 276
            yield "                            </div>
                        </div>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['role'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 279
        yield "                </div>
            </div>
        </div>

        ";
        // line 284
        yield "        <div x-show=\"activeTab === 'magasins'\" x-collapse class=\"px-3 sm:px-0\">
            <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden\">
                <div class=\"p-3 sm:p-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white\">
                    <div class=\"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2\">
                        <h2 class=\"text-sm font-bold text-slate-800\">Liste des Magasins</h2>
                        <button @click=\"showAddMagasinModal = true\" class=\"inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-[11px] font-bold uppercase tracking-wider transition-all\">
                            <svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 4v16m8-8H4\"/></svg>
                            Nouveau Magasin
                        </button>
                    </div>
                </div>
                <div class=\"divide-y divide-slate-100\">
                    ";
        // line 296
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["magasins"]) || array_key_exists("magasins", $context) ? $context["magasins"] : (function () { throw new RuntimeError('Variable "magasins" does not exist.', 296, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["magasin"]) {
            // line 297
            yield "                        <div class=\"p-3 sm:p-4 flex items-center justify-between gap-3 hover:bg-slate-50 transition-colors\">
                            <div class=\"flex-1 min-w-0\">
                                <div class=\"text-sm font-semibold text-slate-800\">";
            // line 299
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["magasin"], "nom", [], "any", false, false, false, 299), "html", null, true);
            yield "</div>
                                <div class=\"text-[10px] text-slate-400 mt-0.5\">";
            // line 300
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["magasin"], "users", [], "any", false, false, false, 300)), "html", null, true);
            yield " utilisateurs</div>
                            </div>
                            <div class=\"flex items-center gap-1\">
                                <button 
                                    @click=\"editMagasinId = ";
            // line 304
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["magasin"], "id", [], "any", false, false, false, 304), "html", null, true);
            yield "; editMagasinNom = '";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["magasin"], "nom", [], "any", false, false, false, 304), "html", null, true);
            yield "'; showEditMagasinModal = true\"
                                    class=\"p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all\"
                                    title=\"Modifier\">
                                    <svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z\"/></svg>
                                </button>
                                <button 
                                    @click=\"deleteMagasin(";
            // line 310
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["magasin"], "id", [], "any", false, false, false, 310), "html", null, true);
            yield ", '";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["magasin"], "nom", [], "any", false, false, false, 310), "html", null, true);
            yield "')\"
                                    class=\"p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all\"
                                    title=\"Supprimer\">
                                    <svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16\"/></svg>
                                </button>
                            </div>
                        </div>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['magasin'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 318
        yield "                </div>
            </div>
        </div>

        ";
        // line 323
        yield "        ";
        // line 324
        yield "        <div x-show=\"showAddRoleModal\" class=\"fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4\" x-cloak>
            <div x-show=\"showAddRoleModal\" x-transition:enter=\"transition ease-out duration-200\" x-transition:enter-start=\"opacity-0 scale-95\" x-transition:enter-end=\"opacity-100 scale-100\" x-transition:leave=\"transition ease-in duration-150\" x-transition:leave-start=\"opacity-100 scale-100\" x-transition:leave-end=\"opacity-0 scale-95\" class=\"bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden\">
                <div class=\"p-4 border-b border-slate-100\">
                    <h3 class=\"text-lg font-bold text-slate-800\">Nouveau Rôle</h3>
                </div>
                <form @submit.prevent=\"submitAddRole()\" class=\"p-4 space-y-4\">
                    <div>
                        <label class=\"block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1\">Identifiant Technique</label>
                        <input x-model=\"newRoleName\" type=\"text\" placeholder=\"Ex: MANAGER\" required class=\"w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none\">
                    </div>
                    <div>
                        <label class=\"block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1\">Nom Affiché</label>
                        <input x-model=\"newRoleLabel\" type=\"text\" placeholder=\"Ex: Manager de Magasin\" required class=\"w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none\">
                    </div>
                    <div class=\"flex items-center gap-2\">
                        <input x-model=\"newRoleContact\" type=\"checkbox\" id=\"newRoleContact\" class=\"w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 focus:ring-2 cursor-pointer\">
                        <label for=\"newRoleContact\" class=\"text-sm font-medium text-slate-700 cursor-pointer\">Afficher sur la page de contact public</label>
                    </div>
                    <div class=\"flex gap-2 pt-2\">
                        <button type=\"button\" @click=\"showAddRoleModal = false\" class=\"flex-1 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-semibold transition-colors\">Annuler</button>
                        <button type=\"submit\" class=\"flex-1 px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg text-sm font-semibold transition-colors\">Créer</button>
                    </div>
                </form>
            </div>
        </div>

        ";
        // line 351
        yield "        <div x-show=\"showEditRoleModal\" class=\"fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4\" x-cloak>
            <div x-show=\"showEditRoleModal\" x-transition:enter=\"transition ease-out duration-200\" x-transition:enter-start=\"opacity-0 scale-95\" x-transition:enter-end=\"opacity-100 scale-100\" x-transition:leave=\"transition ease-in duration-150\" x-transition:leave-start=\"opacity-100 scale-100\" x-transition:leave-end=\"opacity-0 scale-95\" class=\"bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden\">
                <div class=\"p-4 border-b border-slate-100\">
                    <h3 class=\"text-lg font-bold text-slate-800\">Modifier le Rôle</h3>
                </div>
                <form @submit.prevent=\"submitEditRole()\" class=\"p-4 space-y-4\">
                    <div>
                        <label class=\"block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1\">Nom Affiché</label>
                        <input x-model=\"editRoleLabel\" type=\"text\" required class=\"w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none\">
                    </div>
                    <div class=\"flex items-center gap-2\">
                        <input x-model=\"editRoleContact\" type=\"checkbox\" id=\"editRoleContact\" class=\"w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 focus:ring-2 cursor-pointer\">
                        <label for=\"editRoleContact\" class=\"text-sm font-medium text-slate-700 cursor-pointer\">Afficher sur la page de contact public</label>
                    </div>
                    <div class=\"flex gap-2 pt-2\">
                        <button type=\"button\" @click=\"showEditRoleModal = false\" class=\"flex-1 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-semibold transition-colors\">Annuler</button>
                        <button type=\"submit\" class=\"flex-1 px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg text-sm font-semibold transition-colors\">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>

        ";
        // line 374
        yield "        <div x-show=\"showAddMagasinModal\" class=\"fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4\" x-cloak>
            <div x-show=\"showAddMagasinModal\" x-transition:enter=\"transition ease-out duration-200\" x-transition:enter-start=\"opacity-0 scale-95\" x-transition:enter-end=\"opacity-100 scale-100\" x-transition:leave=\"transition ease-in duration-150\" x-transition:leave-start=\"opacity-100 scale-100\" x-transition:leave-end=\"opacity-0 scale-95\" class=\"bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden\">
                <div class=\"p-4 border-b border-slate-100\">
                    <h3 class=\"text-lg font-bold text-slate-800\">Nouveau Magasin</h3>
                </div>
                <form @submit.prevent=\"submitAddMagasin()\" class=\"p-4 space-y-4\">
                    <div>
                        <label class=\"block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1\">Nom du Magasin</label>
                        <input x-model=\"newMagasinNom\" type=\"text\" placeholder=\"Ex: Paris Montparnasse\" required class=\"w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 outline-none\">
                    </div>
                    <div class=\"flex gap-2 pt-2\">
                        <button type=\"button\" @click=\"showAddMagasinModal = false\" class=\"flex-1 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-semibold transition-colors\">Annuler</button>
                        <button type=\"submit\" class=\"flex-1 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-semibold transition-colors\">Créer</button>
                    </div>
                </form>
            </div>
        </div>

        ";
        // line 393
        yield "        <div x-show=\"showEditMagasinModal\" class=\"fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4\" x-cloak>
            <div x-show=\"showEditMagasinModal\" x-transition:enter=\"transition ease-out duration-200\" x-transition:enter-start=\"opacity-0 scale-95\" x-transition:enter-end=\"opacity-100 scale-100\" x-transition:leave=\"transition ease-in duration-150\" x-transition:leave-start=\"opacity-100 scale-100\" x-transition:leave-end=\"opacity-0 scale-95\" class=\"bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden\">
                <div class=\"p-4 border-b border-slate-100\">
                    <h3 class=\"text-lg font-bold text-slate-800\">Modifier le Magasin</h3>
                </div>
                <form @submit.prevent=\"submitEditMagasin()\" class=\"p-4 space-y-4\">
                    <div>
                        <label class=\"block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1\">Nom du Magasin</label>
                        <input x-model=\"editMagasinNom\" type=\"text\" required class=\"w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 outline-none\">
                    </div>
                    <div class=\"flex gap-2 pt-2\">
                        <button type=\"button\" @click=\"showEditMagasinModal = false\" class=\"flex-1 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-semibold transition-colors\">Annuler</button>
                        <button type=\"submit\" class=\"flex-1 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-semibold transition-colors\">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 415
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_stylesheets(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 416
        yield from $this->yieldParentBlock("stylesheets", $context, $blocks);
        yield "
<style>
    [x-cloak] { display: none !important; }
</style>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 422
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_javascripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        // line 423
        yield from $this->yieldParentBlock("javascripts", $context, $blocks);
        yield "
<script defer src=\"https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js\"></script>
<script>
    function accessManager() {
        return {
            activeTab: 'matrix',
            moduleSearch: '',
            showAddRoleModal: false,
            showEditRoleModal: false,
            showAddMagasinModal: false,
            showEditMagasinModal: false,
            newRoleName: '',
            newRoleLabel: '',
            newRoleContact: false,
            editRoleId: null,
            editRoleLabel: '',
            editRoleContact: false,
            newMagasinNom: '',
            editMagasinId: null,
            editMagasinNom: '',

            async submitAddRole() {
                try {
                    const response = await fetch('";
        // line 446
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_access_role_add");
        yield "', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ 
                            name: this.newRoleName, 
                            label: this.newRoleLabel,
                            isContact: this.newRoleContact
                        })
                    });
                    if (response.ok) {
                        showToast('Rôle créé avec succès', 'success');
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        const data = await response.json();
                        showToast(data.error || 'Erreur lors de la création', 'error');
                    }
                } catch (e) {
                    showToast('Erreur réseau', 'error');
                }
            },

            async submitEditRole() {
                try {
                    const response = await fetch(`";
        // line 469
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_access_role_edit", ["id" => "ROLE_ID"]);
        yield "`.replace('ROLE_ID', this.editRoleId), {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ 
                            label: this.editRoleLabel,
                            isContact: this.editRoleContact
                        })
                    });
                    if (response.ok) {
                        showToast('Rôle mis à jour', 'success');
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        showToast('Erreur lors de la mise à jour', 'error');
                    }
                } catch (e) {
                    showToast('Erreur réseau', 'error');
                }
            },

            async deleteRole(id, label) {
                if (!confirm(`Supprimer le rôle \"\${label}\" ?`)) return;
                try {
                    const response = await fetch(`";
        // line 491
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_access_role_delete", ["id" => "ROLE_ID"]);
        yield "`.replace('ROLE_ID', id), {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' }
                    });
                    if (response.ok) {
                        showToast('Rôle supprimé', 'success');
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        const data = await response.json();
                        showToast(data.error || 'Erreur', 'error');
                    }
                } catch (e) {
                    showToast('Erreur réseau', 'error');
                }
            },

            async submitAddMagasin() {
                try {
                    const response = await fetch('";
        // line 509
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_access_magasin_add");
        yield "', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ nom: this.newMagasinNom })
                    });
                    if (response.ok) {
                        showToast('Magasin créé avec succès', 'success');
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        const data = await response.json();
                        showToast(data.error || 'Erreur lors de la création', 'error');
                    }
                } catch (e) {
                    showToast('Erreur réseau', 'error');
                }
            },

            async submitEditMagasin() {
                try {
                    const response = await fetch(`";
        // line 528
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_access_magasin_edit", ["id" => "MAGASIN_ID"]);
        yield "`.replace('MAGASIN_ID', this.editMagasinId), {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ nom: this.editMagasinNom })
                    });
                    if (response.ok) {
                        showToast('Magasin mis à jour', 'success');
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        showToast('Erreur lors de la mise à jour', 'error');
                    }
                } catch (e) {
                    showToast('Erreur réseau', 'error');
                }
            },

            async deleteMagasin(id, nom) {
                if (!confirm(`Supprimer le magasin \"\${nom}\" ?`)) return;
                try {
                    const response = await fetch(`";
        // line 547
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_access_magasin_delete", ["id" => "MAGASIN_ID"]);
        yield "`.replace('MAGASIN_ID', id), {
                        method: 'POST'
                    });
                    if (response.ok) {
                        showToast('Magasin supprimé', 'success');
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        const data = await response.json();
                        showToast(data.error || 'Erreur', 'error');
                    }
                } catch (e) {
                    showToast('Erreur réseau', 'error');
                }
            }
        }
    }

    async function updatePermission(moduleKey, roleName, accessLevel) {
        const select = event.target;
        const original = select.dataset.original;
        
        try {
            const response = await fetch('";
        // line 569
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_access_update");
        yield "', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ moduleKey, roleName, accessLevel })
            });

            if (response.ok) {
                showToast('Permission mise à jour', 'success');
                select.dataset.original = accessLevel;
                updateSelectStyle(select, accessLevel);
            } else {
                const data = await response.json();
                showToast(data.error || 'Erreur', 'error');
                select.value = original;
            }
        } catch (e) {
            showToast('Erreur réseau', 'error');
            select.value = original;
        }
    }

    function updateSelectStyle(select, level) {
        const classes = {
            'AUCUN_ACCES': 'bg-slate-100 text-slate-500 border-slate-200',
            'ACCES_TOTAL': 'bg-emerald-50 text-emerald-600 border-emerald-200',
            'ADMIN_MAGASIN': 'bg-indigo-50 text-indigo-600 border-indigo-200',
            'LECTURE_TOTALE': 'bg-sky-50 text-sky-600 border-sky-200',
            'LECTURE_MAGASIN': 'bg-teal-50 text-teal-600 border-teal-200',
            'ACCES_PERSONNEL': 'bg-amber-50 text-amber-600 border-amber-200'
        };
        select.className = select.className.replace(/bg-\\w+-50 text-\\w+-600 border-\\w+-200|bg-slate-100 text-slate-500 border-slate-200/, classes[level] || classes['AUCUN_ACCES']);
    }
</script>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "admin/access/index.html.twig";
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
        return array (  1104 => 569,  1079 => 547,  1057 => 528,  1035 => 509,  1014 => 491,  989 => 469,  963 => 446,  937 => 423,  927 => 422,  914 => 416,  904 => 415,  876 => 393,  856 => 374,  832 => 351,  804 => 324,  802 => 323,  796 => 318,  780 => 310,  769 => 304,  762 => 300,  758 => 299,  754 => 297,  750 => 296,  736 => 284,  730 => 279,  722 => 276,  711 => 270,  708 => 269,  706 => 268,  694 => 263,  687 => 259,  684 => 258,  680 => 256,  677 => 255,  673 => 253,  671 => 252,  667 => 251,  662 => 248,  658 => 247,  644 => 235,  639 => 231,  630 => 227,  621 => 223,  615 => 222,  611 => 220,  597 => 219,  590 => 218,  587 => 217,  583 => 215,  573 => 214,  566 => 213,  563 => 212,  560 => 211,  556 => 209,  546 => 208,  539 => 207,  536 => 206,  533 => 205,  529 => 203,  521 => 202,  514 => 201,  511 => 200,  508 => 199,  504 => 197,  496 => 196,  489 => 195,  486 => 194,  483 => 193,  479 => 191,  473 => 190,  466 => 189,  463 => 188,  460 => 187,  456 => 185,  448 => 184,  441 => 183,  438 => 182,  435 => 181,  431 => 179,  425 => 178,  418 => 177,  415 => 176,  412 => 175,  408 => 173,  400 => 172,  393 => 171,  390 => 170,  387 => 169,  383 => 167,  375 => 166,  368 => 165,  365 => 164,  362 => 163,  358 => 162,  354 => 160,  350 => 159,  346 => 157,  344 => 156,  341 => 155,  339 => 154,  336 => 153,  334 => 152,  331 => 151,  329 => 150,  326 => 149,  324 => 148,  321 => 147,  319 => 146,  316 => 145,  314 => 144,  309 => 142,  302 => 141,  298 => 140,  291 => 136,  287 => 135,  283 => 133,  280 => 132,  277 => 131,  274 => 130,  272 => 129,  269 => 128,  265 => 127,  261 => 125,  247 => 113,  243 => 112,  239 => 110,  235 => 108,  231 => 106,  229 => 105,  226 => 104,  224 => 103,  221 => 102,  219 => 101,  216 => 100,  214 => 99,  211 => 98,  209 => 97,  202 => 92,  193 => 87,  190 => 86,  186 => 85,  183 => 84,  168 => 70,  164 => 67,  136 => 40,  129 => 35,  122 => 31,  115 => 27,  108 => 23,  103 => 20,  92 => 10,  87 => 6,  77 => 5,  60 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Gestion des Accès | LSDJ{% endblock %}

{% block body %}
<div class=\"min-h-screen bg-slate-50 py-2 sm:py-4 px-0 sm:px-4 lg:px-8\" x-data=\"accessManager()\">
    <div class=\"max-w-7xl mx-auto\">
        
        {# Header #}
        <div class=\"mb-4 sm:mb-6 px-3 sm:px-0\">
            <div class=\"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3\">
                <div>
                    <h1 class=\"text-xl sm:text-2xl font-black text-slate-900 tracking-tight\">Gestion des Accès</h1>
                    <p class=\"text-xs text-slate-500 mt-0.5\">Configuration des permissions par module et rôle</p>
                </div>
            </div>
        </div>

        {# Quick Stats Cards - Mobile optimized #}
        <div class=\"grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-4 mb-4 sm:mb-6 px-3 sm:px-0\">
            <div class=\"bg-white rounded-lg p-3 shadow-sm border border-slate-200\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Rôles</div>
                <div class=\"text-lg sm:text-xl font-black text-slate-800\">{{ roles|length }}</div>
            </div>
            <div class=\"bg-white rounded-lg p-3 shadow-sm border border-slate-200\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Magasins</div>
                <div class=\"text-lg sm:text-xl font-black text-slate-800\">{{ magasins|length }}</div>
            </div>
            <div class=\"bg-white rounded-lg p-3 shadow-sm border border-slate-200\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Modules</div>
                <div class=\"text-lg sm:text-xl font-black text-slate-800\">{{ modules|length }}</div>
            </div>
            <div class=\"bg-white rounded-lg p-3 shadow-sm border border-slate-200\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Permissions</div>
                <div class=\"text-lg sm:text-xl font-black text-teal-600\">{{ roles|length * modules|length }}</div>
            </div>
        </div>

        {# Tab Navigation - Mobile optimized #}
        <div class=\"px-3 sm:px-0 mb-4\">
            <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 p-1 flex gap-1\">
                <button 
                    @click=\"activeTab = 'matrix'\" 
                    :class=\"{ 'bg-teal-500 text-white shadow': activeTab === 'matrix', 'text-slate-600 hover:bg-slate-100': activeTab !== 'matrix' }\"
                    class=\"flex-1 py-2 px-2 rounded-md text-[11px] font-bold uppercase tracking-wider transition-all duration-200\">
                    <span class=\"hidden sm:inline\">Matrice des Accès</span>
                    <span class=\"sm:hidden\">Accès</span>
                </button>
                <button 
                    @click=\"activeTab = 'roles'\" 
                    :class=\"{ 'bg-indigo-500 text-white shadow': activeTab === 'roles', 'text-slate-600 hover:bg-slate-100': activeTab !== 'roles' }\"
                    class=\"flex-1 py-2 px-2 rounded-md text-[11px] font-bold uppercase tracking-wider transition-all duration-200\">
                    <span class=\"hidden sm:inline\">Gestion des Rôles</span>
                    <span class=\"sm:hidden\">Rôles</span>
                </button>
                <button 
                    @click=\"activeTab = 'magasins'\" 
                    :class=\"{ 'bg-emerald-500 text-white shadow': activeTab === 'magasins', 'text-slate-600 hover:bg-slate-100': activeTab !== 'magasins' }\"
                    class=\"flex-1 py-2 px-2 rounded-md text-[11px] font-bold uppercase tracking-wider transition-all duration-200\">
                    <span class=\"hidden sm:inline\">Gestion des Magasins</span>
                    <span class=\"sm:hidden\">Magasins</span>
                </button>
            </div>
        </div>

        {# Access Matrix Tab #}
        <div x-show=\"activeTab === 'matrix'\" x-collapse class=\"px-3 sm:px-0 space-y-3\">
            
            {# Search Filter #}
            <div class=\"relative max-w-sm\">
                <div class=\"absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none\">
                    <svg class=\"h-4 w-4 text-slate-400\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                        <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z\"/>
                    </svg>
                </div>
                <input 
                    type=\"text\" 
                    x-model=\"moduleSearch\"
                    placeholder=\"Rechercher un module...\" 
                    class=\"w-full pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 outline-none focus:border-teal-400 focus:ring-1 focus:ring-teal-100 transition-all shadow-sm\">
            </div>

            {# Module Cards #}
            <div class=\"grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-3\">
                {% for key, label in modules %}
                    <div 
                        x-show=\"'{{ label|lower }} {{ key|lower }}'.includes(moduleSearch.toLowerCase()) || moduleSearch === ''\"
                        class=\"bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden\"
                        x-data=\"{ expanded: false }\">
                        
                        {# Module Header #}
                        <button 
                            @click=\"expanded = !expanded\"
                            class=\"w-full flex items-center justify-between p-3 sm:p-4 bg-gradient-to-r from-slate-50 to-white hover:from-slate-100 hover:to-slate-50 transition-all\">
                            <div class=\"flex items-center gap-3\">
                                <div class=\"w-9 h-9 rounded-lg bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center text-white shadow-sm shrink-0\">
                                    {% if key == 'dashboard' %}
                                        <svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z\"/></svg>
                                    {% elseif key == 'documents' %}
                                        <svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\"/></svg>
                                    {% elseif key == 'users' %}
                                        <svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z\"/></svg>
                                    {% elseif key == 'agenda' %}
                                        <svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z\"/></svg>
                                    {% elseif key == 'access_management' %}
                                        <svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z\"/></svg>
                                    {% else %}
                                        <svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-3-1l-2-2m0 0l-2 2m2-2v10\"/></svg>
                                    {% endif %}
                                </div>
                                <div class=\"text-left min-w-0\">
                                    <h3 class=\"text-sm font-bold text-slate-800 truncate\">{{ label }}</h3>
                                    <p class=\"text-[9px] text-slate-400 font-medium\">{{ key }}</p>
                                </div>
                            </div>
                            <svg 
                                class=\"w-5 h-5 text-slate-400 transition-transform duration-200 shrink-0 ml-2\"
                                :class=\"{ 'rotate-180': expanded }\"
                                fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                                <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 9l-7 7-7-7\"/>
                            </svg>
                        </button>

                        {# Role Permissions List #}
                        <div x-show=\"expanded\" x-collapse class=\"border-t border-slate-100\">
                            <div class=\"divide-y divide-slate-50\">
                                {% for role in roles %}
                                    {% set currentAccess = matrix[key][role.name] ?? 'AUCUN_ACCES' %}
                                    {# ROLE_DIRECTEUR always has ACCES_TOTAL #}
                                    {% if role.name == 'ROLE_DIRECTEUR' %}
                                        {% set currentAccess = 'ACCES_TOTAL' %}
                                    {% endif %}
                                    <div class=\"p-2 sm:p-3 flex items-center justify-between gap-3 hover:bg-slate-50 transition-colors\">
                                        <div class=\"flex-1 min-w-0\">
                                            <div class=\"text-[11px] font-semibold text-slate-700 truncate\">{{ role.label }}</div>
                                            <div class=\"text-[9px] text-slate-400\">{{ role.name }}</div>
                                        </div>
                                        <div class=\"relative shrink-0\">
                                            <select
                                                {% if role.name == 'ROLE_DIRECTEUR' %}disabled{% endif %}
                                                onchange=\"updatePermission('{{ key }}', '{{ role.name }}', this.value)\"
                                                data-original=\"{{ currentAccess }}\"
                                                class=\"access-select w-32 sm:w-40 text-[10px] font-bold uppercase tracking-wider border border-slate-200 rounded-md px-2 py-1.5 focus:ring-2 focus:ring-teal-100 focus:border-teal-400 outline-none cursor-pointer transition-all
                                                {% if role.name == 'ROLE_DIRECTEUR' %}
                                                    bg-emerald-50 text-emerald-600 border-emerald-200
                                                {% elseif currentAccess == 'AUCUN_ACCES' %}
                                                    bg-slate-100 text-slate-500 border-slate-200
                                                {% elseif currentAccess == 'ACCES_TOTAL' %}
                                                    bg-emerald-50 text-emerald-600 border-emerald-200
                                                {% elseif currentAccess == 'ADMIN_MAGASIN' %}
                                                    bg-indigo-50 text-indigo-600 border-indigo-200
                                                {% elseif currentAccess == 'LECTURE_TOTALE' %}
                                                    bg-sky-50 text-sky-600 border-sky-200
                                                {% elseif currentAccess == 'LECTURE_MAGASIN' %}
                                                    bg-teal-50 text-teal-600 border-teal-200
                                                {% elseif currentAccess == 'ACCES_PERSONNEL' %}
                                                    bg-amber-50 text-amber-600 border-amber-200
                                                {% else %}
                                                    bg-slate-100 text-slate-500 border-slate-200
                                                {% endif %}\"
                                            >
                                                {% for level in accessLevels %}
                                                    {% if key == 'produits' %}
                                                    {% if level in ['AUCUN_ACCES', 'LECTURE_TOTALE', 'ACCES_TOTAL'] %}
                                                            <option value=\"{{ level }}\" {{ currentAccess == level ? 'selected' : '' }}>
                                                                {% if level == 'LECTURE_TOTALE' %}UTILISATEUR{% elseif level == 'ACCES_TOTAL' %}ACCES TOTAL{% else %}{{ level|replace({'_': ' '}) }}{% endif %}
                                                            </option>
                                                        {% endif %}
                                                    {% elseif key == 'documents' %}
                                                        {% if level in ['AUCUN_ACCES', 'ACCES_TOTAL', 'LECTURE_TOTALE'] %}
                                                            <option value=\"{{ level }}\" {{ currentAccess == level ? 'selected' : '' }}>
                                                                {% if level == 'ACCES_TOTAL' %}ACCES TOTAL{% elseif level == 'LECTURE_TOTALE' %}LECTURE TOTALE{% else %}{{ level|replace({'_': ' '}) }}{% endif %}
                                                            </option>
                                                        {% endif %}
                                                    {% elseif key in ['access_management', 'dashboard'] %}
                                                        {% if level in ['AUCUN_ACCES', 'ACCES_TOTAL'] %}
                                                            <option value=\"{{ level }}\" {{ currentAccess == level ? 'selected' : '' }}>
                                                                {% if level == 'ACCES_TOTAL' %}ACCES TOTAL{% else %}{{ level|replace({'_': ' '}) }}{% endif %}
                                                            </option>
                                                        {% endif %}
                                                    {% elseif key == 'user_observations' %}
                                                        {% if level in ['AUCUN_ACCES', 'ADMIN_MAGASIN', 'ACCES_TOTAL'] %}
                                                            <option value=\"{{ level }}\" {{ currentAccess == level ? 'selected' : '' }}>
                                                                {% if level == 'ACCES_TOTAL' %}ACCES TOTAL{% elseif level == 'ADMIN_MAGASIN' %}ACCES MAGASIN{% else %}AUCUN ACCES{% endif %}
                                                            </option>
                                                        {% endif %}
                                                    {% elseif key == 'transport_logistique' %}
                                                        {% if level in ['AUCUN_ACCES', 'ACCES_TOTAL'] %}
                                                            <option value=\"{{ level }}\" {{ currentAccess == level ? 'selected' : '' }}>
                                                                {% if level == 'ACCES_TOTAL' %}ACCES TOTAL{% else %}{{ level|replace({'_': ' '}) }}{% endif %}
                                                            </option>
                                                        {% endif %}
                                                    {% elseif key == 'maintenance_suivi' %}
                                                        {% if level in ['AUCUN_ACCES', 'ACCES_TOTAL', 'ACCES_PERSONNEL'] %}
                                                            <option value=\"{{ level }}\" {{ currentAccess == level ? 'selected' : '' }}>
                                                                {% if level == 'ACCES_TOTAL' %}ACCES TOTAL{% elseif level == 'ACCES_PERSONNEL' %}ACCES PERSONNEL{% else %}{{ level|replace({'_': ' '}) }}{% endif %}
                                                            </option>
                                                        {% endif %}
                                                    {% elseif key == 'commandes' %}
                                                        {% if level in ['AUCUN_ACCES', 'ACCES_TOTAL', 'ADMIN_MAGASIN'] %}
                                                            <option value=\"{{ level }}\" {{ currentAccess == level ? 'selected' : '' }}>
                                                                {% if level == 'ACCES_TOTAL' %}ACCES TOTAL{% elseif level == 'ADMIN_MAGASIN' %}ACCES MAGASIN{% else %}{{ level|replace({'_': ' '}) }}{% endif %}
                                                            </option>
                                                        {% endif %}
                                                    {% elseif key in ['rh_validation', 'rh_documents'] %}
                                                        {% if level in ['AUCUN_ACCES', 'ACCES_TOTAL', 'ADMIN_MAGASIN', 'ACCES_PERSONNEL'] %}
                                                            <option value=\"{{ level }}\" {{ currentAccess == level ? 'selected' : '' }}>
                                                                {% if level == 'ACCES_TOTAL' %}ACCES TOTAL{% elseif level == 'ADMIN_MAGASIN' %}ACCES MAGASIN{% elseif level == 'ACCES_PERSONNEL' %}ACCES PERSONNEL{% else %}{{ level|replace({'_': ' '}) }}{% endif %}
                                                            </option>
                                                        {% endif %}
                                                    {% elseif key == 'rh_conge' %}
                                                        {% if level in ['AUCUN_ACCES', 'ACCES_TOTAL', 'ADMIN_MAGASIN', 'ACCES_PERSONNEL'] %}
                                                            <option value=\"{{ level }}\" {{ currentAccess == level ? 'selected' : '' }}>
                                                                {% if level == 'ACCES_TOTAL' %}ACCES TOTAL{% elseif level == 'ADMIN_MAGASIN' %}ACCES MAGASIN{% elseif level == 'ACCES_PERSONNEL' %}ACCES PERSONNEL{% else %}{{ level|replace({'_': ' '}) }}{% endif %}
                                                            </option>
                                                        {% endif %}
                                                    {% elseif key not in ['rh_validation', 'rh_documents', 'rh_conge'] or level not in ['LECTURE_TOTALE', 'LECTURE_MAGASIN'] %}
                                                        <option value=\"{{ level }}\" {{ currentAccess == level ? 'selected' : '' }}>
                                                            {% if level == 'ACCES_TOTAL' %}ACCES TOTAL{% elseif level == 'ADMIN_MAGASIN' %}ACCES MAGASIN{% elseif level == 'LECTURE_TOTALE' %}LECTURE TOTALE{% elseif level == 'LECTURE_MAGASIN' %}LECTURE MAGASIN{% elseif level == 'ACCES_PERSONNEL' %}ACCES PERSONNEL{% else %}{{ level|replace({'_': ' '}) }}{% endif %}
                                                        </option>
                                                    {% endif %}
                                                {% endfor %}
                                            </select>
                                        </div>
                                    </div>
                                {% endfor %}
                            </div>
                        </div>
                    </div>
                {% endfor %}
            </div>
        </div>

        {# Roles Management Tab #}
        <div x-show=\"activeTab === 'roles'\" x-collapse class=\"px-3 sm:px-0\">
            <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden\">
                <div class=\"p-3 sm:p-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white\">
                    <div class=\"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2\">
                        <h2 class=\"text-sm font-bold text-slate-800\">Liste des Rôles</h2>
                        <button @click=\"showAddRoleModal = true\" class=\"inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg text-[11px] font-bold uppercase tracking-wider transition-all\">
                            <svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 4v16m8-8H4\"/></svg>
                            Nouveau Rôle
                        </button>
                    </div>
                </div>
                <div class=\"divide-y divide-slate-100\">
                    {% for role in roles %}
                        <div class=\"p-3 sm:p-4 flex items-center justify-between gap-3 hover:bg-slate-50 transition-colors\">
                            <div class=\"flex-1 min-w-0\">
                                <div class=\"flex items-center gap-2\">
                                    <span class=\"text-sm font-semibold text-slate-800\">{{ role.label }}</span>
                                    {% if role.name == 'ROLE_DIRECTEUR' or role.name == 'ROLE_USER' %}
                                        <span class=\"px-1.5 py-0.5 bg-slate-100 text-slate-500 rounded text-[9px] font-bold\">SYSTÈME</span>
                                    {% endif %}
                                    {% if role.isContact %}
                                        <span class=\"px-1.5 py-0.5 bg-sky-100 text-sky-600 rounded text-[9px] font-bold\">CONTACT MAGASIN</span>
                                    {% endif %}
                                </div>
                                <div class=\"text-[10px] text-slate-400 font-mono mt-0.5\">{{ role.name }}</div>
                            </div>
                            <div class=\"flex items-center gap-1\">
                                <button 
                                    @click=\"editRoleId = {{ role.id }}; editRoleLabel = '{{ role.label }}'; editRoleContact = {{ role.isContact ? 'true' : 'false' }}; showEditRoleModal = true\"
                                    class=\"p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all\"
                                    title=\"Modifier\">
                                    <svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z\"/></svg>
                                </button>
                                {% if role.name != 'ROLE_DIRECTEUR' and role.name != 'ROLE_USER' %}
                                    <button 
                                        @click=\"deleteRole({{ role.id }}, '{{ role.label }}')\"
                                        class=\"p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all\"
                                        title=\"Supprimer\">
                                        <svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16\"/></svg>
                                    </button>
                                {% endif %}
                            </div>
                        </div>
                    {% endfor %}
                </div>
            </div>
        </div>

        {# Magasins Management Tab #}
        <div x-show=\"activeTab === 'magasins'\" x-collapse class=\"px-3 sm:px-0\">
            <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden\">
                <div class=\"p-3 sm:p-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white\">
                    <div class=\"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2\">
                        <h2 class=\"text-sm font-bold text-slate-800\">Liste des Magasins</h2>
                        <button @click=\"showAddMagasinModal = true\" class=\"inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-[11px] font-bold uppercase tracking-wider transition-all\">
                            <svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 4v16m8-8H4\"/></svg>
                            Nouveau Magasin
                        </button>
                    </div>
                </div>
                <div class=\"divide-y divide-slate-100\">
                    {% for magasin in magasins %}
                        <div class=\"p-3 sm:p-4 flex items-center justify-between gap-3 hover:bg-slate-50 transition-colors\">
                            <div class=\"flex-1 min-w-0\">
                                <div class=\"text-sm font-semibold text-slate-800\">{{ magasin.nom }}</div>
                                <div class=\"text-[10px] text-slate-400 mt-0.5\">{{ magasin.users|length }} utilisateurs</div>
                            </div>
                            <div class=\"flex items-center gap-1\">
                                <button 
                                    @click=\"editMagasinId = {{ magasin.id }}; editMagasinNom = '{{ magasin.nom }}'; showEditMagasinModal = true\"
                                    class=\"p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all\"
                                    title=\"Modifier\">
                                    <svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z\"/></svg>
                                </button>
                                <button 
                                    @click=\"deleteMagasin({{ magasin.id }}, '{{ magasin.nom }}')\"
                                    class=\"p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all\"
                                    title=\"Supprimer\">
                                    <svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16\"/></svg>
                                </button>
                            </div>
                        </div>
                    {% endfor %}
                </div>
            </div>
        </div>

        {# Modals #}
        {# Add Role Modal #}
        <div x-show=\"showAddRoleModal\" class=\"fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4\" x-cloak>
            <div x-show=\"showAddRoleModal\" x-transition:enter=\"transition ease-out duration-200\" x-transition:enter-start=\"opacity-0 scale-95\" x-transition:enter-end=\"opacity-100 scale-100\" x-transition:leave=\"transition ease-in duration-150\" x-transition:leave-start=\"opacity-100 scale-100\" x-transition:leave-end=\"opacity-0 scale-95\" class=\"bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden\">
                <div class=\"p-4 border-b border-slate-100\">
                    <h3 class=\"text-lg font-bold text-slate-800\">Nouveau Rôle</h3>
                </div>
                <form @submit.prevent=\"submitAddRole()\" class=\"p-4 space-y-4\">
                    <div>
                        <label class=\"block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1\">Identifiant Technique</label>
                        <input x-model=\"newRoleName\" type=\"text\" placeholder=\"Ex: MANAGER\" required class=\"w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none\">
                    </div>
                    <div>
                        <label class=\"block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1\">Nom Affiché</label>
                        <input x-model=\"newRoleLabel\" type=\"text\" placeholder=\"Ex: Manager de Magasin\" required class=\"w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none\">
                    </div>
                    <div class=\"flex items-center gap-2\">
                        <input x-model=\"newRoleContact\" type=\"checkbox\" id=\"newRoleContact\" class=\"w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 focus:ring-2 cursor-pointer\">
                        <label for=\"newRoleContact\" class=\"text-sm font-medium text-slate-700 cursor-pointer\">Afficher sur la page de contact public</label>
                    </div>
                    <div class=\"flex gap-2 pt-2\">
                        <button type=\"button\" @click=\"showAddRoleModal = false\" class=\"flex-1 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-semibold transition-colors\">Annuler</button>
                        <button type=\"submit\" class=\"flex-1 px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg text-sm font-semibold transition-colors\">Créer</button>
                    </div>
                </form>
            </div>
        </div>

        {# Edit Role Modal #}
        <div x-show=\"showEditRoleModal\" class=\"fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4\" x-cloak>
            <div x-show=\"showEditRoleModal\" x-transition:enter=\"transition ease-out duration-200\" x-transition:enter-start=\"opacity-0 scale-95\" x-transition:enter-end=\"opacity-100 scale-100\" x-transition:leave=\"transition ease-in duration-150\" x-transition:leave-start=\"opacity-100 scale-100\" x-transition:leave-end=\"opacity-0 scale-95\" class=\"bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden\">
                <div class=\"p-4 border-b border-slate-100\">
                    <h3 class=\"text-lg font-bold text-slate-800\">Modifier le Rôle</h3>
                </div>
                <form @submit.prevent=\"submitEditRole()\" class=\"p-4 space-y-4\">
                    <div>
                        <label class=\"block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1\">Nom Affiché</label>
                        <input x-model=\"editRoleLabel\" type=\"text\" required class=\"w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none\">
                    </div>
                    <div class=\"flex items-center gap-2\">
                        <input x-model=\"editRoleContact\" type=\"checkbox\" id=\"editRoleContact\" class=\"w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 focus:ring-2 cursor-pointer\">
                        <label for=\"editRoleContact\" class=\"text-sm font-medium text-slate-700 cursor-pointer\">Afficher sur la page de contact public</label>
                    </div>
                    <div class=\"flex gap-2 pt-2\">
                        <button type=\"button\" @click=\"showEditRoleModal = false\" class=\"flex-1 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-semibold transition-colors\">Annuler</button>
                        <button type=\"submit\" class=\"flex-1 px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg text-sm font-semibold transition-colors\">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>

        {# Add Magasin Modal #}
        <div x-show=\"showAddMagasinModal\" class=\"fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4\" x-cloak>
            <div x-show=\"showAddMagasinModal\" x-transition:enter=\"transition ease-out duration-200\" x-transition:enter-start=\"opacity-0 scale-95\" x-transition:enter-end=\"opacity-100 scale-100\" x-transition:leave=\"transition ease-in duration-150\" x-transition:leave-start=\"opacity-100 scale-100\" x-transition:leave-end=\"opacity-0 scale-95\" class=\"bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden\">
                <div class=\"p-4 border-b border-slate-100\">
                    <h3 class=\"text-lg font-bold text-slate-800\">Nouveau Magasin</h3>
                </div>
                <form @submit.prevent=\"submitAddMagasin()\" class=\"p-4 space-y-4\">
                    <div>
                        <label class=\"block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1\">Nom du Magasin</label>
                        <input x-model=\"newMagasinNom\" type=\"text\" placeholder=\"Ex: Paris Montparnasse\" required class=\"w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 outline-none\">
                    </div>
                    <div class=\"flex gap-2 pt-2\">
                        <button type=\"button\" @click=\"showAddMagasinModal = false\" class=\"flex-1 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-semibold transition-colors\">Annuler</button>
                        <button type=\"submit\" class=\"flex-1 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-semibold transition-colors\">Créer</button>
                    </div>
                </form>
            </div>
        </div>

        {# Edit Magasin Modal #}
        <div x-show=\"showEditMagasinModal\" class=\"fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4\" x-cloak>
            <div x-show=\"showEditMagasinModal\" x-transition:enter=\"transition ease-out duration-200\" x-transition:enter-start=\"opacity-0 scale-95\" x-transition:enter-end=\"opacity-100 scale-100\" x-transition:leave=\"transition ease-in duration-150\" x-transition:leave-start=\"opacity-100 scale-100\" x-transition:leave-end=\"opacity-0 scale-95\" class=\"bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden\">
                <div class=\"p-4 border-b border-slate-100\">
                    <h3 class=\"text-lg font-bold text-slate-800\">Modifier le Magasin</h3>
                </div>
                <form @submit.prevent=\"submitEditMagasin()\" class=\"p-4 space-y-4\">
                    <div>
                        <label class=\"block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1\">Nom du Magasin</label>
                        <input x-model=\"editMagasinNom\" type=\"text\" required class=\"w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-100 focus:border-emerald-400 outline-none\">
                    </div>
                    <div class=\"flex gap-2 pt-2\">
                        <button type=\"button\" @click=\"showEditMagasinModal = false\" class=\"flex-1 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-semibold transition-colors\">Annuler</button>
                        <button type=\"submit\" class=\"flex-1 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-semibold transition-colors\">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
{% endblock %}

{% block stylesheets %}
{{ parent() }}
<style>
    [x-cloak] { display: none !important; }
</style>
{% endblock %}

{% block javascripts %}
{{ parent() }}
<script defer src=\"https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js\"></script>
<script>
    function accessManager() {
        return {
            activeTab: 'matrix',
            moduleSearch: '',
            showAddRoleModal: false,
            showEditRoleModal: false,
            showAddMagasinModal: false,
            showEditMagasinModal: false,
            newRoleName: '',
            newRoleLabel: '',
            newRoleContact: false,
            editRoleId: null,
            editRoleLabel: '',
            editRoleContact: false,
            newMagasinNom: '',
            editMagasinId: null,
            editMagasinNom: '',

            async submitAddRole() {
                try {
                    const response = await fetch('{{ path('admin_access_role_add') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ 
                            name: this.newRoleName, 
                            label: this.newRoleLabel,
                            isContact: this.newRoleContact
                        })
                    });
                    if (response.ok) {
                        showToast('Rôle créé avec succès', 'success');
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        const data = await response.json();
                        showToast(data.error || 'Erreur lors de la création', 'error');
                    }
                } catch (e) {
                    showToast('Erreur réseau', 'error');
                }
            },

            async submitEditRole() {
                try {
                    const response = await fetch(`{{ path('admin_access_role_edit', {id: 'ROLE_ID'}) }}`.replace('ROLE_ID', this.editRoleId), {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ 
                            label: this.editRoleLabel,
                            isContact: this.editRoleContact
                        })
                    });
                    if (response.ok) {
                        showToast('Rôle mis à jour', 'success');
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        showToast('Erreur lors de la mise à jour', 'error');
                    }
                } catch (e) {
                    showToast('Erreur réseau', 'error');
                }
            },

            async deleteRole(id, label) {
                if (!confirm(`Supprimer le rôle \"\${label}\" ?`)) return;
                try {
                    const response = await fetch(`{{ path('admin_access_role_delete', {id: 'ROLE_ID'}) }}`.replace('ROLE_ID', id), {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' }
                    });
                    if (response.ok) {
                        showToast('Rôle supprimé', 'success');
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        const data = await response.json();
                        showToast(data.error || 'Erreur', 'error');
                    }
                } catch (e) {
                    showToast('Erreur réseau', 'error');
                }
            },

            async submitAddMagasin() {
                try {
                    const response = await fetch('{{ path('admin_access_magasin_add') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ nom: this.newMagasinNom })
                    });
                    if (response.ok) {
                        showToast('Magasin créé avec succès', 'success');
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        const data = await response.json();
                        showToast(data.error || 'Erreur lors de la création', 'error');
                    }
                } catch (e) {
                    showToast('Erreur réseau', 'error');
                }
            },

            async submitEditMagasin() {
                try {
                    const response = await fetch(`{{ path('admin_access_magasin_edit', {id: 'MAGASIN_ID'}) }}`.replace('MAGASIN_ID', this.editMagasinId), {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ nom: this.editMagasinNom })
                    });
                    if (response.ok) {
                        showToast('Magasin mis à jour', 'success');
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        showToast('Erreur lors de la mise à jour', 'error');
                    }
                } catch (e) {
                    showToast('Erreur réseau', 'error');
                }
            },

            async deleteMagasin(id, nom) {
                if (!confirm(`Supprimer le magasin \"\${nom}\" ?`)) return;
                try {
                    const response = await fetch(`{{ path('admin_access_magasin_delete', {id: 'MAGASIN_ID'}) }}`.replace('MAGASIN_ID', id), {
                        method: 'POST'
                    });
                    if (response.ok) {
                        showToast('Magasin supprimé', 'success');
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        const data = await response.json();
                        showToast(data.error || 'Erreur', 'error');
                    }
                } catch (e) {
                    showToast('Erreur réseau', 'error');
                }
            }
        }
    }

    async function updatePermission(moduleKey, roleName, accessLevel) {
        const select = event.target;
        const original = select.dataset.original;
        
        try {
            const response = await fetch('{{ path('admin_access_update') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ moduleKey, roleName, accessLevel })
            });

            if (response.ok) {
                showToast('Permission mise à jour', 'success');
                select.dataset.original = accessLevel;
                updateSelectStyle(select, accessLevel);
            } else {
                const data = await response.json();
                showToast(data.error || 'Erreur', 'error');
                select.value = original;
            }
        } catch (e) {
            showToast('Erreur réseau', 'error');
            select.value = original;
        }
    }

    function updateSelectStyle(select, level) {
        const classes = {
            'AUCUN_ACCES': 'bg-slate-100 text-slate-500 border-slate-200',
            'ACCES_TOTAL': 'bg-emerald-50 text-emerald-600 border-emerald-200',
            'ADMIN_MAGASIN': 'bg-indigo-50 text-indigo-600 border-indigo-200',
            'LECTURE_TOTALE': 'bg-sky-50 text-sky-600 border-sky-200',
            'LECTURE_MAGASIN': 'bg-teal-50 text-teal-600 border-teal-200',
            'ACCES_PERSONNEL': 'bg-amber-50 text-amber-600 border-amber-200'
        };
        select.className = select.className.replace(/bg-\\w+-50 text-\\w+-600 border-\\w+-200|bg-slate-100 text-slate-500 border-slate-200/, classes[level] || classes['AUCUN_ACCES']);
    }
</script>
{% endblock %}
", "admin/access/index.html.twig", "/var/www/html/templates/admin/access/index.html.twig");
    }
}
