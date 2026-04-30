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

/* dashboard/index.html.twig */
class __TwigTemplate_1eb32276d9128871ceef59cc5bda69d4 extends Template
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
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "dashboard/index.html.twig"));

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

        yield "Tableau de Bord | LSDJ";
        
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
        yield "<div class=\"min-h-screen bg-slate-50 py-2 sm:py-4 px-0 sm:px-4 lg:px-8\" x-data=\"dashboardManager()\">
    <div class=\"max-w-7xl mx-auto\">
        
        ";
        // line 10
        yield "        <div class=\"mb-4 sm:mb-6 px-3 sm:px-0\">
            <div class=\"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3\">
                <div>
                    <h1 class=\"text-xl sm:text-2xl font-black text-slate-900 tracking-tight\">Tableau de Bord</h1>
                    <p class=\"text-xs text-slate-500 mt-0.5 flex items-center gap-2\">
                        <span class=\"w-2 h-2 bg-emerald-500 rounded-full animate-pulse\"></span>
                        <span>En direct • ";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "d/m/Y H:i"), "html", null, true);
        yield "</span>
                    </p>
                </div>
                <div class=\"flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0 no-scrollbar\">
                    ";
        // line 20
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["shortcuts"]) || array_key_exists("shortcuts", $context) ? $context["shortcuts"] : (function () { throw new RuntimeError('Variable "shortcuts" does not exist.', 20, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["shortcut"]) {
            // line 21
            yield "                        <a href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["shortcut"], "url", [], "any", false, false, false, 21), "html", null, true);
            yield "\" target=\"_blank\" class=\"flex-shrink-0 w-10 h-10 bg-white border border-slate-200 rounded-xl overflow-hidden flex items-center justify-center ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["shortcut"], "colorClass", [], "any", true, true, false, 21)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["shortcut"], "colorClass", [], "any", false, false, false, 21), "text-slate-600")) : ("text-slate-600")), "html", null, true);
            yield " hover:bg-slate-50 transition-all duration-300 hover:scale-110 hover:shadow-md shadow-sm z-10 hover:z-20 relative\" title=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["shortcut"], "label", [], "any", false, false, false, 21), "html", null, true);
            yield "\">
                            ";
            // line 22
            if (Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["shortcut"], "icon", [], "any", false, false, false, 22))) {
                // line 23
                yield "                                <svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1\"></path></svg>
                            ";
            } elseif ((Twig\Extension\CoreExtension::slice($this->env->getCharset(), Twig\Extension\CoreExtension::trim(CoreExtension::getAttribute($this->env, $this->source,             // line 24
$context["shortcut"], "icon", [], "any", false, false, false, 24)), 0, 4) == "<svg")) {
                // line 25
                yield "                                ";
                yield CoreExtension::getAttribute($this->env, $this->source, $context["shortcut"], "icon", [], "any", false, false, false, 25);
                yield "
                            ";
            } elseif ((Twig\Extension\CoreExtension::slice($this->env->getCharset(), Twig\Extension\CoreExtension::trim(CoreExtension::getAttribute($this->env, $this->source,             // line 26
$context["shortcut"], "icon", [], "any", false, false, false, 26)), 0, 4) == "http")) {
                // line 27
                yield "                                <img src=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["shortcut"], "icon", [], "any", false, false, false, 27), "html", null, true);
                yield "\" alt=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["shortcut"], "label", [], "any", false, false, false, 27), "html", null, true);
                yield "\" class=\"w-full h-full object-cover\">
                            ";
            } else {
                // line 29
                yield "                                <img src=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_media_shortcut", ["filename" => CoreExtension::getAttribute($this->env, $this->source, $context["shortcut"], "icon", [], "any", false, false, false, 29)]), "html", null, true);
                yield "\" alt=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["shortcut"], "label", [], "any", false, false, false, 29), "html", null, true);
                yield "\" class=\"w-full h-full object-cover\">
                            ";
            }
            // line 31
            yield "                        </a>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['shortcut'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 33
        yield "                    ";
        if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_EDIT", "shortcuts")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 34
            yield "                        <a href=\"";
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_shortcuts_index");
            yield "\" class=\"flex-shrink-0 w-10 h-10 bg-indigo-600 border border-indigo-600 rounded-xl overflow-hidden flex items-center justify-center text-white hover:bg-indigo-700 transition-all duration-300 hover:scale-110 hover:shadow-md shadow-sm z-10 hover:z-20 relative\">
                            <svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" viewBox=\"0 0 24 24\"><path d=\"M12 4v16m8-8H4\"></path></svg>
                        </a>
                    ";
        }
        // line 38
        yield "                </div>
            </div>
        </div>

        ";
        // line 43
        yield "        <div class=\"grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2 sm:gap-4 mb-4 sm:mb-6 px-3 sm:px-0\">
            <div class=\"bg-white rounded-lg p-3 shadow-sm border border-slate-200\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Commandes</div>
                <div class=\"text-lg sm:text-xl font-black text-indigo-600\">";
        // line 46
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["activeOrdersCount"]) || array_key_exists("activeOrdersCount", $context) ? $context["activeOrdersCount"] : (function () { throw new RuntimeError('Variable "activeOrdersCount" does not exist.', 46, $this->source); })()), "html", null, true);
        yield "</div>
                <div class=\"text-[9px] text-slate-400\">En traitement</div>
            </div>
            <div class=\"bg-white rounded-lg p-3 shadow-sm border border-slate-200\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Catalogue</div>
                <div class=\"text-lg sm:text-xl font-black text-amber-600\">";
        // line 51
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["totalProducts"]) || array_key_exists("totalProducts", $context) ? $context["totalProducts"] : (function () { throw new RuntimeError('Variable "totalProducts" does not exist.', 51, $this->source); })()), "html", null, true);
        yield "</div>
                <div class=\"text-[9px] text-slate-400\">Articles</div>
            </div>
            <div class=\"bg-white rounded-lg p-3 shadow-sm border border-slate-200\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Staff</div>
                <div class=\"text-lg sm:text-xl font-black text-cyan-600\">";
        // line 56
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["workingCount"]) || array_key_exists("workingCount", $context) ? $context["workingCount"] : (function () { throw new RuntimeError('Variable "workingCount" does not exist.', 56, $this->source); })()), "html", null, true);
        yield "<span class=\"text-sm text-slate-300\">/";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["totalUsers"]) || array_key_exists("totalUsers", $context) ? $context["totalUsers"] : (function () { throw new RuntimeError('Variable "totalUsers" does not exist.', 56, $this->source); })()), "html", null, true);
        yield "</span></div>
                <div class=\"text-[9px] text-slate-400\">Présents</div>
            </div>
            <div class=\"bg-white rounded-lg p-3 shadow-sm border border-slate-200\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Magasins</div>
                <div class=\"text-lg sm:text-xl font-black text-emerald-600\">";
        // line 61
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["magasins"]) || array_key_exists("magasins", $context) ? $context["magasins"] : (function () { throw new RuntimeError('Variable "magasins" does not exist.', 61, $this->source); })())), "html", null, true);
        yield "</div>
                <div class=\"text-[9px] text-slate-400\">Actifs</div>
            </div>
            ";
        // line 65
        yield "            <div class=\"col-span-2 sm:col-span-1 bg-white rounded-lg p-3 shadow-sm border border-slate-200 flex flex-col\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Congé</div>
                <div class=\"text-lg sm:text-xl font-black text-rose-600\">";
        // line 67
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["upcomingApproved"]) || array_key_exists("upcomingApproved", $context) ? $context["upcomingApproved"] : (function () { throw new RuntimeError('Variable "upcomingApproved" does not exist.', 67, $this->source); })())), "html", null, true);
        yield "</div>
                <div class=\"text-[9px] text-slate-400 mb-1\">À venir</div>
                ";
        // line 70
        yield "                <div class=\"flex-1 overflow-y-auto max-h-24 mt-1 space-y-1 pr-1\">
                    ";
        // line 71
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["upcomingApproved"]) || array_key_exists("upcomingApproved", $context) ? $context["upcomingApproved"] : (function () { throw new RuntimeError('Variable "upcomingApproved" does not exist.', 71, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["conge"]) {
            // line 72
            yield "                        <div class=\"text-[9px] text-slate-700 border-l-2 border-rose-400 pl-1.5 py-0.5 hover:bg-slate-50 rounded-r truncate\" title=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["conge"], "user", [], "any", false, false, false, 72), "prenom", [], "any", false, false, false, 72), "html", null, true);
            yield " ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["conge"], "user", [], "any", false, false, false, 72), "nom", [], "any", false, false, false, 72), "html", null, true);
            yield ": ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["conge"], "startDate", [], "any", false, false, false, 72), "d/m"), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["conge"], "endDate", [], "any", false, false, false, 72), "d/m"), "html", null, true);
            yield "\">
                            <span class=\"font-bold\">";
            // line 73
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["conge"], "user", [], "any", false, false, false, 73), "prenom", [], "any", false, false, false, 73), "html", null, true);
            yield " ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["conge"], "user", [], "any", false, false, false, 73), "nom", [], "any", false, false, false, 73), "html", null, true);
            yield "</span>: ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["conge"], "startDate", [], "any", false, false, false, 73), "d/m"), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["conge"], "endDate", [], "any", false, false, false, 73), "d/m"), "html", null, true);
            yield "
                        </div>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['conge'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 76
        yield "                </div>
            </div>
        </div>

        ";
        // line 81
        yield "        <div class=\"px-3 sm:px-0 mb-4\">
            <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 p-1 flex gap-1 overflow-x-auto\">
                <button 
                    @click=\"activeTab = 'overview'\" 
                    :class=\"{ 'bg-indigo-500 text-white shadow': activeTab === 'overview', 'text-slate-600 hover:bg-slate-100': activeTab !== 'overview' }\"
                    class=\"flex-1 py-2 px-3 rounded-md text-[11px] font-bold uppercase tracking-wider transition-all duration-200 whitespace-nowrap\">
                    Vue d'ensemble
                </button>
                <button 
                    @click=\"activeTab = 'orders'\" 
                    :class=\"{ 'bg-indigo-500 text-white shadow': activeTab === 'orders', 'text-slate-600 hover:bg-slate-100': activeTab !== 'orders' }\"
                    class=\"flex-1 py-2 px-3 rounded-md text-[11px] font-bold uppercase tracking-wider transition-all duration-200 whitespace-nowrap\">
                    Commandes
                </button>
                ";
        // line 95
        if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "agenda")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 96
            yield "                <button 
                    @click=\"activeTab = 'reports'\" 
                    :class=\"{ 'bg-indigo-500 text-white shadow': activeTab === 'reports', 'text-slate-600 hover:bg-slate-100': activeTab !== 'reports' }\"
                    class=\"flex-1 py-2 px-3 rounded-md text-[11px] font-bold uppercase tracking-wider transition-all duration-200 whitespace-nowrap\">
                    Rapports
                </button>
                ";
        }
        // line 103
        yield "            </div>
        </div>

        ";
        // line 107
        yield "        <div x-show=\"activeTab === 'overview'\" x-collapse class=\"px-3 sm:px-0 space-y-4\">
            <div class=\"grid grid-cols-1 lg:grid-cols-3 gap-4\">
                ";
        // line 110
        yield "                <div class=\"lg:col-span-2 grid grid-cols-2 sm:grid-cols-4 gap-3\">
                    <a href=\"";
        // line 111
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_commandes_index");
        yield "\" class=\"group bg-white border border-slate-200 p-4 rounded-lg shadow-sm hover:border-indigo-300 hover:shadow-md transition-all text-center\">
                        <div class=\"w-10 h-10 bg-indigo-50 rounded-lg mx-auto mb-2 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform\">
                            <svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2\"></path></svg>
                        </div>
                        <div class=\"text-[10px] font-bold text-slate-800 uppercase\">Commandes</div>
                    </a>
                    <a href=\"";
        // line 117
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_produit_new");
        yield "\" class=\"group bg-white border border-slate-200 p-4 rounded-lg shadow-sm hover:border-emerald-300 hover:shadow-md transition-all text-center\">
                        <div class=\"w-10 h-10 bg-emerald-50 rounded-lg mx-auto mb-2 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform\">
                            <svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M12 4v16m8-8H4\"></path></svg>
                        </div>
                        <div class=\"text-[10px] font-bold text-slate-800 uppercase\">Nouveau Produit</div>
                    </a>
                    <a href=\"";
        // line 123
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_users_index");
        yield "\" class=\"group bg-white border border-slate-200 p-4 rounded-lg shadow-sm hover:border-amber-300 hover:shadow-md transition-all text-center\">
                        <div class=\"w-10 h-10 bg-amber-50 rounded-lg mx-auto mb-2 flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform\">
                            <svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z\"></path></svg>
                        </div>
                        <div class=\"text-[10px] font-bold text-slate-800 uppercase\">Utilisateurs</div>
                    </a>
                    <a href=\"";
        // line 129
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_rh_conge");
        yield "\" class=\"group bg-white border border-slate-200 p-4 rounded-lg shadow-sm hover:border-rose-300 hover:shadow-md transition-all text-center\">
                        <div class=\"w-10 h-10 bg-rose-50 rounded-lg mx-auto mb-2 flex items-center justify-center text-rose-600 group-hover:scale-110 transition-transform\">
                            <svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z\"></path></svg>
                        </div>
                        <div class=\"text-[10px] font-bold text-slate-800 uppercase\">Congés</div>
                    </a>
                </div>

                ";
        // line 138
        yield "                <div class=\"bg-indigo-600 rounded-lg p-4 shadow-md text-white relative overflow-hidden\">
                    <div class=\"absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl\"></div>
                    <div class=\"relative z-10\">
                        <h2 class=\"text-[11px] font-black uppercase tracking-wider mb-3 opacity-90\">État du Système</h2>
                        <div class=\"space-y-2\">
                            <div class=\"flex justify-between items-center bg-white/10 rounded-lg p-2\">
                                <span class=\"text-[10px] font-bold uppercase\">Infrastructure</span>
                                <span class=\"flex items-center gap-1 text-[9px] font-bold\"><span class=\"w-1.5 h-1.5 bg-emerald-400 rounded-full\"></span>OK</span>
                            </div>
                            <div class=\"flex justify-between items-center bg-white/10 rounded-lg p-2\">
                                <span class=\"text-[10px] font-bold uppercase\">Serveur</span>
                                <span class=\"flex items-center gap-1 text-[9px] font-bold\"><span class=\"w-1.5 h-1.5 bg-emerald-400 rounded-full\"></span>OK</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            ";
        // line 157
        yield "            <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden\">
                <div class=\"px-4 py-3 border-b border-slate-100 flex justify-between items-center\">
                    <h2 class=\"text-sm font-bold text-slate-800 uppercase tracking-wider\">Dernières Commandes</h2>
                    <a href=\"";
        // line 160
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_commandes_index");
        yield "\" class=\"text-[10px] font-bold text-indigo-600 uppercase tracking-wider hover:text-indigo-800\">Tout voir</a>
                </div>
                <div class=\"divide-y divide-slate-100 lg:hidden\">
                    ";
        // line 163
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["recentOrders"]) || array_key_exists("recentOrders", $context) ? $context["recentOrders"] : (function () { throw new RuntimeError('Variable "recentOrders" does not exist.', 163, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["order"]) {
            // line 164
            yield "                        <div class=\"p-3 flex items-center justify-between hover:bg-slate-50 transition-colors\">
                            <div class=\"min-w-0 pr-3\">
                                <div class=\"font-bold text-slate-900 text-xs truncate\">";
            // line 166
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["order"], "user", [], "any", false, false, false, 166), "nom", [], "any", false, false, false, 166), "html", null, true);
            yield " ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["order"], "user", [], "any", false, false, false, 166), "prenom", [], "any", false, false, false, 166), "html", null, true);
            yield "</div>
                                <div class=\"flex items-center gap-2 mt-0.5\">
                                    <span class=\"text-[9px] font-bold text-slate-400 font-mono\">#";
            // line 168
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["order"], "slug", [], "any", false, false, false, 168), 0, 8)), "html", null, true);
            yield "</span>
                                    <span class=\"text-[9px] text-slate-400\">";
            // line 169
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["order"], "createdAt", [], "any", false, false, false, 169), "d/m"), "html", null, true);
            yield "</span>
                                </div>
                                <div class=\"mt-1.5\">
                                    <span class=\"px-2 py-0.5 rounded text-[9px] font-bold uppercase ";
            // line 172
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["order"], "status", [], "any", false, false, false, 172) == "PENDING")) {
                yield "bg-amber-50 text-amber-600";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source, $context["order"], "status", [], "any", false, false, false, 172) == "CONFIRMED")) {
                yield "bg-emerald-50 text-emerald-600";
            } else {
                yield "bg-slate-100 text-slate-600";
            }
            yield "\">
                                        ";
            // line 173
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["order"], "status", [], "any", false, false, false, 173)), "html", null, true);
            yield "
                                    </span>
                                </div>
                            </div>
                            <a href=\"";
            // line 177
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_commandes_show", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["order"], "id", [], "any", false, false, false, 177)]), "html", null, true);
            yield "\" class=\"flex-shrink-0 w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-all\">
                                <svg width=\"14\" height=\"14\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" viewBox=\"0 0 24 24\"><path d=\"M9 5l7 7-7 7\"></path></svg>
                            </a>
                        </div>
                    ";
            $context['_iterated'] = true;
        }
        // line 181
        if (!$context['_iterated']) {
            // line 182
            yield "                        <div class=\"p-6 text-center text-slate-400 text-xs font-medium\">Aucune commande récente</div>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['order'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 184
        yield "                </div>
                ";
        // line 186
        yield "                <div class=\"hidden lg:block overflow-x-auto\">
                    <table class=\"w-full text-left\">
                        <thead class=\"bg-slate-50\">
                            <tr>
                                <th class=\"px-4 py-2 text-[10px] font-bold text-slate-500 uppercase tracking-wider\">Client</th>
                                <th class=\"px-4 py-2 text-[10px] font-bold text-slate-500 uppercase tracking-wider\">Date</th>
                                <th class=\"px-4 py-2 text-[10px] font-bold text-slate-500 uppercase tracking-wider\">Statut</th>
                                <th class=\"px-4 py-2 text-right text-[10px] font-bold text-slate-500 uppercase tracking-wider\">Action</th>
                            </tr>
                        </thead>
                        <tbody class=\"divide-y divide-slate-100\">
                            ";
        // line 197
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["recentOrders"]) || array_key_exists("recentOrders", $context) ? $context["recentOrders"] : (function () { throw new RuntimeError('Variable "recentOrders" does not exist.', 197, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["order"]) {
            // line 198
            yield "                                <tr class=\"hover:bg-slate-50 transition-colors\">
                                    <td class=\"px-4 py-3\">
                                        <div class=\"font-bold text-slate-900 text-xs\">";
            // line 200
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["order"], "user", [], "any", false, false, false, 200), "nom", [], "any", false, false, false, 200), "html", null, true);
            yield " ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["order"], "user", [], "any", false, false, false, 200), "prenom", [], "any", false, false, false, 200), "html", null, true);
            yield "</div>
                                        <div class=\"text-[9px] text-slate-400 font-mono\">#";
            // line 201
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["order"], "slug", [], "any", false, false, false, 201), 0, 8)), "html", null, true);
            yield "</div>
                                    </td>
                                    <td class=\"px-4 py-3 text-xs text-slate-500\">";
            // line 203
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["order"], "createdAt", [], "any", false, false, false, 203), "d M Y"), "html", null, true);
            yield "</td>
                                    <td class=\"px-4 py-3\">
                                        <span class=\"px-2 py-0.5 rounded text-[9px] font-bold uppercase ";
            // line 205
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["order"], "status", [], "any", false, false, false, 205) == "PENDING")) {
                yield "bg-amber-50 text-amber-600";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source, $context["order"], "status", [], "any", false, false, false, 205) == "CONFIRMED")) {
                yield "bg-emerald-50 text-emerald-600";
            } else {
                yield "bg-slate-100 text-slate-600";
            }
            yield "\">
                                            ";
            // line 206
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["order"], "status", [], "any", false, false, false, 206)), "html", null, true);
            yield "
                                        </span>
                                    </td>
                                    <td class=\"px-4 py-3 text-right\">
                                        <a href=\"";
            // line 210
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_commandes_show", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["order"], "id", [], "any", false, false, false, 210)]), "html", null, true);
            yield "\" class=\"inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-600 hover:text-white transition-all\">
                                            <svg width=\"14\" height=\"14\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" viewBox=\"0 0 24 24\"><path d=\"M9 5l7 7-7 7\"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['order'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 216
        yield "                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        ";
        // line 223
        yield "        <div x-show=\"activeTab === 'orders'\" x-collapse class=\"px-3 sm:px-0\">
            <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden\">
                <div class=\"px-4 py-3 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white\">
                    <h2 class=\"text-sm font-bold text-slate-800 uppercase tracking-wider\">Gestion des Commandes</h2>
                </div>
                <div class=\"p-4 space-y-3\">
                    <a href=\"";
        // line 229
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("admin_commandes_index");
        yield "\" class=\"flex items-center justify-between p-3 bg-slate-50 rounded-lg hover:bg-indigo-50 transition-colors group\">
                        <div class=\"flex items-center gap-3\">
                            <div class=\"w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600\">
                                <svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2\"></path></svg>
                            </div>
                            <div>
                                <div class=\"text-sm font-bold text-slate-800\">Liste des Commandes</div>
                                <div class=\"text-[10px] text-slate-500\">";
        // line 236
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["activeOrdersCount"]) || array_key_exists("activeOrdersCount", $context) ? $context["activeOrdersCount"] : (function () { throw new RuntimeError('Variable "activeOrdersCount" does not exist.', 236, $this->source); })()), "html", null, true);
        yield " commandes actives</div>
                            </div>
                        </div>
                        <svg width=\"16\" height=\"16\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\" class=\"text-slate-400 group-hover:text-indigo-600\"><path d=\"M9 5l7 7-7 7\"></path></svg>
                    </a>
                </div>
            </div>
        </div>
        ";
        // line 244
        if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("MODULE_VIEW", "agenda")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 245
            yield "        <div x-show=\"activeTab === 'reports'\" x-collapse class=\"px-3 sm:px-0\">
            <div class=\"grid grid-cols-1 lg:grid-cols-3 gap-3\">
                ";
            // line 248
            yield "                <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden\" x-data=\"{ expanded: false }\">
                    <button @click=\"expanded = !expanded\" class=\"w-full flex items-center justify-between p-3 bg-gradient-to-r from-slate-50 to-white hover:from-slate-100 transition-all\">
                        <div class=\"flex items-center gap-2\">
                            <div class=\"w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600 shrink-0\">
                                <svg width=\"16\" height=\"16\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z\"></path></svg>
                            </div>
                            <div class=\"text-left min-w-0\">
                                <div class=\"text-xs font-bold text-slate-800 truncate\">Rapport Mensuel</div>
                                <div class=\"text-[9px] text-slate-500\">Global par Magasin</div>
                            </div>
                        </div>
                        <svg :class=\"{ 'rotate-180': expanded }\" class=\"w-4 h-4 text-slate-400 transition-transform shrink-0\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M19 9l-7 7-7-7\"></path></svg>
                    </button>
                    <div x-show=\"expanded\" x-collapse class=\"p-3 bg-slate-50/50 border-t border-slate-100 space-y-2\">
                        <div class=\"grid grid-cols-2 gap-2\">
                            <div>
                                <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Magasin</label>
                                <select id=\"reportMagasin\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200 focus:ring-1 focus:ring-indigo-100 focus:border-indigo-400 outline-none\">
                                    <option value=\"\">Tous les magasins</option>
                                    ";
            // line 267
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["magasins"]) || array_key_exists("magasins", $context) ? $context["magasins"] : (function () { throw new RuntimeError('Variable "magasins" does not exist.', 267, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["mag"]) {
                // line 268
                yield "                                        <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["mag"], "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["mag"], "html", null, true);
                yield "</option>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['mag'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 270
            yield "                                </select>
                            </div>
                            <div>
                                <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Employé</label>
                                <select id=\"reportUser\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200 focus:ring-1 focus:ring-indigo-100 focus:border-indigo-400 outline-none\">
                                    <option value=\"\">Tous les employés</option>
                                    ";
            // line 276
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(((array_key_exists("employees", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["employees"]) || array_key_exists("employees", $context) ? $context["employees"] : (function () { throw new RuntimeError('Variable "employees" does not exist.', 276, $this->source); })()), [])) : ([])));
            foreach ($context['_seq'] as $context["_key"] => $context["emp"]) {
                // line 277
                yield "                                        <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["emp"], "id", [], "any", false, false, false, 277), "html", null, true);
                yield "\" data-magasin=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["emp"], "magasin", [], "any", false, false, false, 277), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["emp"], "prenom", [], "any", false, false, false, 277), "html", null, true);
                yield " ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["emp"], "nom", [], "any", false, false, false, 277), "html", null, true);
                yield "</option>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['emp'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 279
            yield "                                </select>
                            </div>
                        </div>
                        <div>
                            <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Mois</label>
                            <input type=\"month\" id=\"reportMonth\" value=\"";
            // line 284
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y-m"), "html", null, true);
            yield "\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200 focus:ring-1 focus:ring-indigo-100 focus:border-indigo-400 outline-none\">
                        </div>
                        <button onclick=\"exportMonthlyPdf()\" class=\"w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded font-bold text-[10px] uppercase tracking-wider transition-all flex items-center justify-center gap-1\">
                            <svg width=\"12\" height=\"12\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M12 11v6m0 0l-3-3m3 3l3-3m-9 4h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z\"></path></svg>
                            Générer
                        </button>
                    </div>
                </div>

                ";
            // line 294
            yield "                <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden\" x-data=\"{ expanded: false }\">
                    <button @click=\"expanded = !expanded\" class=\"w-full flex items-center justify-between p-3 bg-gradient-to-r from-slate-50 to-white hover:from-slate-100 transition-all\">
                        <div class=\"flex items-center gap-2\">
                            <div class=\"w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center text-amber-600 shrink-0\">
                                <svg width=\"16\" height=\"16\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z\"></path></svg>
                            </div>
                            <div class=\"text-left min-w-0\">
                                <div class=\"text-xs font-bold text-slate-800 truncate\">Validation Horaire</div>
                                <div class=\"text-[9px] text-slate-500\">Rapport des Signatures</div>
                            </div>
                        </div>
                        <svg :class=\"{ 'rotate-180': expanded }\" class=\"w-4 h-4 text-slate-400 transition-transform shrink-0\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M19 9l-7 7-7-7\"></path></svg>
                    </button>
                    <div x-show=\"expanded\" x-collapse class=\"p-3 bg-slate-50/50 border-t border-slate-100 space-y-2\">
                        <div class=\"grid grid-cols-2 gap-2\">
                            <div>
                                <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Magasin</label>
                                <select id=\"valMagasin\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200\">
                                    <option value=\"all\">Tous les magasins</option>
                                    ";
            // line 313
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(((array_key_exists("magasins", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["magasins"]) || array_key_exists("magasins", $context) ? $context["magasins"] : (function () { throw new RuntimeError('Variable "magasins" does not exist.', 313, $this->source); })()), [])) : ([])));
            foreach ($context['_seq'] as $context["_key"] => $context["mag"]) {
                // line 314
                yield "                                        <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["mag"], "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["mag"], "html", null, true);
                yield "</option>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['mag'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 316
            yield "                                </select>
                            </div>
                            <div>
                                <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Employé</label>
                                <select id=\"valUser\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200\">
                                    <option value=\"all\">Tous les employés</option>
                                    ";
            // line 322
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(((array_key_exists("employees", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["employees"]) || array_key_exists("employees", $context) ? $context["employees"] : (function () { throw new RuntimeError('Variable "employees" does not exist.', 322, $this->source); })()), [])) : ([])));
            foreach ($context['_seq'] as $context["_key"] => $context["emp"]) {
                // line 323
                yield "                                        <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["emp"], "id", [], "any", false, false, false, 323), "html", null, true);
                yield "\" data-magasin=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["emp"], "magasin", [], "any", false, false, false, 323), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["emp"], "prenom", [], "any", false, false, false, 323), "html", null, true);
                yield " ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["emp"], "nom", [], "any", false, false, false, 323), "html", null, true);
                yield "</option>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['emp'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 325
            yield "                                </select>
                            </div>
                        </div>
                        <div>
                            <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Mois</label>
                            <input type=\"month\" id=\"valMonthInput\" value=\"";
            // line 330
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y-m"), "html", null, true);
            yield "\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200 focus:ring-1 focus:ring-amber-100 focus:border-amber-400 outline-none\">
                        </div>
                        <button onclick=\"generateMonthlyValidationReport(this)\" class=\"w-full bg-amber-600 hover:bg-amber-700 text-white py-2 rounded font-bold text-[10px] uppercase tracking-wider transition-all flex items-center justify-center gap-1\">
                            <svg width=\"12\" height=\"12\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z\"></path></svg>
                            Générer
                        </button>
                    </div>
                </div>

                ";
            // line 340
            yield "                <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden\" x-data=\"{ expanded: false }\">
                    <button @click=\"expanded = !expanded\" class=\"w-full flex items-center justify-between p-3 bg-gradient-to-r from-slate-50 to-white hover:from-slate-100 transition-all\">
                        <div class=\"flex items-center gap-2\">
                            <div class=\"w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center text-rose-600 shrink-0\">
                                <svg width=\"16\" height=\"16\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z\"></path></svg>
                            </div>
                            <div class=\"text-left min-w-0\">
                                <div class=\"text-xs font-bold text-slate-800 truncate\">Rapports Congés</div>
                                <div class=\"text-[9px] text-slate-500\">Attestation</div>
                            </div>
                        </div>
                        <svg :class=\"{ 'rotate-180': expanded }\" class=\"w-4 h-4 text-slate-400 transition-transform shrink-0\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M19 9l-7 7-7-7\"></path></svg>
                    </button>
                    <div x-show=\"expanded\" x-collapse class=\"p-3 bg-slate-50/50 border-t border-slate-100 space-y-2\">
                        <div class=\"grid grid-cols-2 gap-2\">
                            <div>
                                <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Magasin</label>
                                <select id=\"conge-magasin\" onchange=\"loadCongeEmployees()\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200 focus:ring-1 focus:ring-rose-100 focus:border-rose-400 outline-none\">
                                    <option value=\"\">— Choisir —</option>
                                    ";
            // line 359
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(((array_key_exists("magasins", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["magasins"]) || array_key_exists("magasins", $context) ? $context["magasins"] : (function () { throw new RuntimeError('Variable "magasins" does not exist.', 359, $this->source); })()), [])) : ([])));
            foreach ($context['_seq'] as $context["_key"] => $context["mag"]) {
                // line 360
                yield "                                        <option value=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["mag"], "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["mag"], "html", null, true);
                yield "</option>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['mag'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 362
            yield "                                </select>
                            </div>
                            <div>
                                <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Employé</label>
                                <select id=\"conge-employe\" onchange=\"loadCongeList()\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200 focus:ring-1 focus:ring-rose-100 focus:border-rose-400 outline-none\" disabled>
                                    <option value=\"\">— Choisir —</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Dossier</label>
                            <select id=\"conge-dossier\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200 focus:ring-1 focus:ring-rose-100 focus:border-rose-400 outline-none\" disabled>
                                <option value=\"\">— Choisir —</option>
                            </select>
                        </div>
                        <button id=\"btn-conge-pdf\" onclick=\"openCongePdf()\" class=\"w-full bg-rose-600 hover:bg-rose-700 text-white py-2 rounded font-bold text-[10px] uppercase tracking-wider transition-all flex items-center justify-center gap-1\">
                            <svg width=\"12\" height=\"12\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z\"></path></svg>
                            Générer
                        </button>
                    </div>
                </div>
            </div>
        </div>
        ";
        }
        // line 386
        yield "
    </div>
</div>

";
        // line 391
        yield "<div id=\"missing-signers-modal\" class=\"fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4\">
    <div class=\"bg-white rounded-xl w-full max-w-md overflow-hidden shadow-xl\">
        <div class=\"bg-rose-500 p-4 text-white\">
            <div class=\"flex items-center justify-between\">
                <div class=\"flex items-center gap-3\">
                    <div class=\"w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center\">
                        <svg width=\"24\" height=\"24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z\"></path></svg>
                    </div>
                    <div>
                        <h3 class=\"text-lg font-bold\">Signatures Manquantes</h3>
                        <p class=\"text-xs opacity-80\">Le rapport ne peut pas être généré</p>
                    </div>
                </div>
                <button onclick=\"closeMissingSignersModal()\" class=\"p-1 hover:bg-white/20 rounded-lg\">
                    <svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M6 18L18 6M6 6l12 12\"></path></svg>
                </button>
            </div>
        </div>
        <div class=\"p-4 max-h-60 overflow-y-auto\">
            <p class=\"text-[10px] font-bold text-slate-400 uppercase mb-3\">Employés n'ayant pas signé :</p>
            <div id=\"missing-signers-list\" class=\"space-y-2\"></div>
        </div>
        <div class=\"p-4 border-t border-slate-100\">
            <button onclick=\"closeMissingSignersModal()\" class=\"w-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold py-2.5 rounded-lg text-xs uppercase tracking-wider transition-colors\">
                Compris
            </button>
        </div>
    </div>
</div>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 422
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_stylesheets(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 423
        yield from $this->yieldParentBlock("stylesheets", $context, $blocks);
        yield "
<style>
    [x-cloak] { display: none !important; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 431
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_javascripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        // line 432
        yield from $this->yieldParentBlock("javascripts", $context, $blocks);
        yield "
<script defer src=\"https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js\"></script>
<script>
    function dashboardManager() {
        return {
            activeTab: 'overview',
        }
    }

    function generateMonthlyValidationReport(btn) {
        const monthFull = document.getElementById('valMonthInput').value;
        if (!monthFull) {
            alert('Veuillez sélectionner un mois.');
            return;
        }
        const [year, month] = monthFull.split('-');
        const mag = document.getElementById('valMagasin').value;
        const emp = document.getElementById('valUser').value;
        const originalContent = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<svg class=\"animate-spin h-4 w-4 text-white\" viewBox=\"0 0 24 24\"><circle class=\"opacity-25\" cx=\"12\" cy=\"12\" r=\"10\" stroke=\"currentColor\" stroke-width=\"4\"></circle><path class=\"opacity-75\" fill=\"currentColor\" d=\"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z\"></path></svg>';

        fetch('";
        // line 455
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_rh_report_check");
        yield "', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ month: parseInt(month), year: parseInt(year), magasin: mag, user_id: emp === 'all' ? null : emp })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                let url = '";
        // line 463
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_rh_report_generate");
        yield "?month=' + parseInt(month) + '&year=' + year;
                if (mag !== 'all') url += '&magasin=' + encodeURIComponent(mag);
                if (emp !== 'all') url += '&user_id=' + emp;
                window.open(url, '_blank');
            } else {
                const listStr = data.missing.map(name => `<div class=\"p-3 bg-rose-50 text-rose-700 rounded-lg font-bold text-xs flex items-center gap-2\"><span class=\"w-2 h-2 bg-rose-400 rounded-full\"></span>\${name}</div>`).join('');
                document.getElementById('missing-signers-list').innerHTML = listStr;
                document.getElementById('missing-signers-modal').classList.remove('hidden');
                document.getElementById('missing-signers-modal').classList.add('flex');
            }
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalContent;
        });
    }

    function closeMissingSignersModal() {
        document.getElementById('missing-signers-modal').classList.add('hidden');
        document.getElementById('missing-signers-modal').classList.remove('flex');
    }

    function exportMonthlyPdf() {
        const month = document.getElementById('reportMonth').value;
        const magasin = document.getElementById('reportMagasin').value;
        const userId = document.getElementById('reportUser').value;
        if (!month) return;
        let url = '";
        // line 490
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_agenda_export_pdf");
        yield "?month=' + month;
        if (magasin) url += '&magasin=' + magasin;
        if (userId) url += '&user_id=' + userId;
        window.open(url, '_blank');
    }

    function loadCongeEmployees() {
        const mag = document.getElementById('conge-magasin').value;
        const empSel = document.getElementById('conge-employe');
        const dossSel = document.getElementById('conge-dossier');

        empSel.innerHTML = '<option value=\"\">— Chargement... —</option>';
        empSel.disabled = true;
        dossSel.innerHTML = '<option value=\"\">— Sélectionnez un employé —</option>';
        dossSel.disabled = true;

        if (!mag) { empSel.innerHTML = '<option value=\"\">— Sélectionnez un magasin —</option>'; return; }

        fetch('/rh/conge/api/employees?magasin=' + encodeURIComponent(mag))
            .then(r => r.json())
            .then(data => {
                empSel.innerHTML = '<option value=\"\">— Choisir un employé —</option>';
                data.forEach(emp => {
                    const o = document.createElement('option');
                    o.value = emp.id;
                    o.textContent = emp.prenom + ' ' + emp.nom;
                    empSel.appendChild(o);
                });
                empSel.disabled = false;
            });
    }

    function loadCongeList() {
        const userId = document.getElementById('conge-employe').value;
        const dossSel = document.getElementById('conge-dossier');

        dossSel.innerHTML = '<option value=\"\">— Chargement... —</option>';
        dossSel.disabled = true;

        if (!userId) return;

        fetch('/rh/conge/api/list?user_id=' + userId)
            .then(r => r.json())
            .then(data => {
                dossSel.innerHTML = '<option value=\"\">— Choisir un dossier —</option>';
                data.forEach(c => {
                    const o = document.createElement('option');
                    o.value = c.id;
                    const statusLabel = c.status === 'APPROVED' ? '✓ Validé' : c.status === 'REJECTED' ? '✕ Refusé' : '⏳ En attente';
                    o.textContent = c.startDate + ' → ' + c.endDate + ' · ' + c.type + ' · ' + statusLabel;
                    dossSel.appendChild(o);
                });
                dossSel.disabled = false;
            });
    }

    function openCongePdf() {
        const id = document.getElementById('conge-dossier').value;
        if (!id) { alert('Veuillez sélectionner un dossier de congé.'); return; }
        window.open('/rh/conge/pdf/' + id, '_blank');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const magSelect = document.getElementById('valMagasin');
        const empSelect = document.getElementById('valUser');
        if (magSelect && empSelect) {
            magSelect.addEventListener('change', function() {
                const selectedMag = this.value;
                const options = empSelect.querySelectorAll('option');
                options.forEach(opt => {
                    if (opt.value === 'all') { opt.style.display = 'block'; }
                    else {
                        const empMag = opt.getAttribute('data-magasin');
                        if (selectedMag === 'all' || empMag === selectedMag) { opt.style.display = 'block'; }
                        else { opt.style.display = 'none'; }
                    }
                });
            });
        }

        // Rapport Mensuel cascading filter
        const reportMagSelect = document.getElementById('reportMagasin');
        const reportUserSelect = document.getElementById('reportUser');
        if (reportMagSelect && reportUserSelect) {
            reportMagSelect.addEventListener('change', function() {
                const selectedMag = this.value;
                const options = reportUserSelect.querySelectorAll('option');
                options.forEach(opt => {
                    if (opt.value === '') { opt.style.display = 'block'; }
                    else {
                        const empMag = opt.getAttribute('data-magasin');
                        if (selectedMag === '' || empMag === selectedMag) { opt.style.display = 'block'; }
                        else { opt.style.display = 'none'; }
                    }
                });
                reportUserSelect.value = '';
            });
        }
    });
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
        return "dashboard/index.html.twig";
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
        return array (  911 => 490,  881 => 463,  870 => 455,  844 => 432,  834 => 431,  819 => 423,  809 => 422,  772 => 391,  766 => 386,  740 => 362,  729 => 360,  725 => 359,  704 => 340,  692 => 330,  685 => 325,  670 => 323,  666 => 322,  658 => 316,  647 => 314,  643 => 313,  622 => 294,  610 => 284,  603 => 279,  588 => 277,  584 => 276,  576 => 270,  565 => 268,  561 => 267,  540 => 248,  536 => 245,  534 => 244,  523 => 236,  513 => 229,  505 => 223,  497 => 216,  485 => 210,  478 => 206,  468 => 205,  463 => 203,  458 => 201,  452 => 200,  448 => 198,  444 => 197,  431 => 186,  428 => 184,  421 => 182,  419 => 181,  410 => 177,  403 => 173,  393 => 172,  387 => 169,  383 => 168,  376 => 166,  372 => 164,  367 => 163,  361 => 160,  356 => 157,  336 => 138,  325 => 129,  316 => 123,  307 => 117,  298 => 111,  295 => 110,  291 => 107,  286 => 103,  277 => 96,  275 => 95,  259 => 81,  253 => 76,  238 => 73,  227 => 72,  223 => 71,  220 => 70,  215 => 67,  211 => 65,  205 => 61,  195 => 56,  187 => 51,  179 => 46,  174 => 43,  168 => 38,  160 => 34,  157 => 33,  150 => 31,  142 => 29,  134 => 27,  132 => 26,  127 => 25,  125 => 24,  122 => 23,  120 => 22,  111 => 21,  107 => 20,  100 => 16,  92 => 10,  87 => 6,  77 => 5,  60 => 3,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Tableau de Bord | LSDJ{% endblock %}

{% block body %}
<div class=\"min-h-screen bg-slate-50 py-2 sm:py-4 px-0 sm:px-4 lg:px-8\" x-data=\"dashboardManager()\">
    <div class=\"max-w-7xl mx-auto\">
        
        {# Header #}
        <div class=\"mb-4 sm:mb-6 px-3 sm:px-0\">
            <div class=\"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3\">
                <div>
                    <h1 class=\"text-xl sm:text-2xl font-black text-slate-900 tracking-tight\">Tableau de Bord</h1>
                    <p class=\"text-xs text-slate-500 mt-0.5 flex items-center gap-2\">
                        <span class=\"w-2 h-2 bg-emerald-500 rounded-full animate-pulse\"></span>
                        <span>En direct • {{ \"now\"|date(\"d/m/Y H:i\") }}</span>
                    </p>
                </div>
                <div class=\"flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0 no-scrollbar\">
                    {% for shortcut in shortcuts %}
                        <a href=\"{{ shortcut.url }}\" target=\"_blank\" class=\"flex-shrink-0 w-10 h-10 bg-white border border-slate-200 rounded-xl overflow-hidden flex items-center justify-center {{ shortcut.colorClass|default('text-slate-600') }} hover:bg-slate-50 transition-all duration-300 hover:scale-110 hover:shadow-md shadow-sm z-10 hover:z-20 relative\" title=\"{{ shortcut.label }}\">
                            {% if shortcut.icon is empty %}
                                <svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1\"></path></svg>
                            {% elseif shortcut.icon|trim|slice(0, 4) == '<svg' %}
                                {{ shortcut.icon|raw }}
                            {% elseif shortcut.icon|trim|slice(0, 4) == 'http' %}
                                <img src=\"{{ shortcut.icon }}\" alt=\"{{ shortcut.label }}\" class=\"w-full h-full object-cover\">
                            {% else %}
                                <img src=\"{{ path('app_media_shortcut', {filename: shortcut.icon}) }}\" alt=\"{{ shortcut.label }}\" class=\"w-full h-full object-cover\">
                            {% endif %}
                        </a>
                    {% endfor %}
                    {% if is_granted('MODULE_EDIT', 'shortcuts') %}
                        <a href=\"{{ path('admin_shortcuts_index') }}\" class=\"flex-shrink-0 w-10 h-10 bg-indigo-600 border border-indigo-600 rounded-xl overflow-hidden flex items-center justify-center text-white hover:bg-indigo-700 transition-all duration-300 hover:scale-110 hover:shadow-md shadow-sm z-10 hover:z-20 relative\">
                            <svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" viewBox=\"0 0 24 24\"><path d=\"M12 4v16m8-8H4\"></path></svg>
                        </a>
                    {% endif %}
                </div>
            </div>
        </div>

        {# Stats Cards #}
        <div class=\"grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2 sm:gap-4 mb-4 sm:mb-6 px-3 sm:px-0\">
            <div class=\"bg-white rounded-lg p-3 shadow-sm border border-slate-200\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Commandes</div>
                <div class=\"text-lg sm:text-xl font-black text-indigo-600\">{{ activeOrdersCount }}</div>
                <div class=\"text-[9px] text-slate-400\">En traitement</div>
            </div>
            <div class=\"bg-white rounded-lg p-3 shadow-sm border border-slate-200\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Catalogue</div>
                <div class=\"text-lg sm:text-xl font-black text-amber-600\">{{ totalProducts }}</div>
                <div class=\"text-[9px] text-slate-400\">Articles</div>
            </div>
            <div class=\"bg-white rounded-lg p-3 shadow-sm border border-slate-200\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Staff</div>
                <div class=\"text-lg sm:text-xl font-black text-cyan-600\">{{ workingCount }}<span class=\"text-sm text-slate-300\">/{{ totalUsers }}</span></div>
                <div class=\"text-[9px] text-slate-400\">Présents</div>
            </div>
            <div class=\"bg-white rounded-lg p-3 shadow-sm border border-slate-200\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Magasins</div>
                <div class=\"text-lg sm:text-xl font-black text-emerald-600\">{{ magasins|length }}</div>
                <div class=\"text-[9px] text-slate-400\">Actifs</div>
            </div>
            {# Congé - shows upcoming approved congés with scrollbar #}
            <div class=\"col-span-2 sm:col-span-1 bg-white rounded-lg p-3 shadow-sm border border-slate-200 flex flex-col\">
                <div class=\"text-[10px] font-bold text-slate-400 uppercase tracking-wider\">Congé</div>
                <div class=\"text-lg sm:text-xl font-black text-rose-600\">{{ upcomingApproved|length }}</div>
                <div class=\"text-[9px] text-slate-400 mb-1\">À venir</div>
                {# Scrollable list of upcoming approved congés #}
                <div class=\"flex-1 overflow-y-auto max-h-24 mt-1 space-y-1 pr-1\">
                    {% for conge in upcomingApproved %}
                        <div class=\"text-[9px] text-slate-700 border-l-2 border-rose-400 pl-1.5 py-0.5 hover:bg-slate-50 rounded-r truncate\" title=\"{{ conge.user.prenom }} {{ conge.user.nom }}: {{ conge.startDate|date('d/m') }} - {{ conge.endDate|date('d/m') }}\">
                            <span class=\"font-bold\">{{ conge.user.prenom }} {{ conge.user.nom }}</span>: {{ conge.startDate|date('d/m') }} - {{ conge.endDate|date('d/m') }}
                        </div>
                    {% endfor %}
                </div>
            </div>
        </div>

        {# Tab Navigation #}
        <div class=\"px-3 sm:px-0 mb-4\">
            <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 p-1 flex gap-1 overflow-x-auto\">
                <button 
                    @click=\"activeTab = 'overview'\" 
                    :class=\"{ 'bg-indigo-500 text-white shadow': activeTab === 'overview', 'text-slate-600 hover:bg-slate-100': activeTab !== 'overview' }\"
                    class=\"flex-1 py-2 px-3 rounded-md text-[11px] font-bold uppercase tracking-wider transition-all duration-200 whitespace-nowrap\">
                    Vue d'ensemble
                </button>
                <button 
                    @click=\"activeTab = 'orders'\" 
                    :class=\"{ 'bg-indigo-500 text-white shadow': activeTab === 'orders', 'text-slate-600 hover:bg-slate-100': activeTab !== 'orders' }\"
                    class=\"flex-1 py-2 px-3 rounded-md text-[11px] font-bold uppercase tracking-wider transition-all duration-200 whitespace-nowrap\">
                    Commandes
                </button>
                {% if is_granted('MODULE_VIEW', 'agenda') %}
                <button 
                    @click=\"activeTab = 'reports'\" 
                    :class=\"{ 'bg-indigo-500 text-white shadow': activeTab === 'reports', 'text-slate-600 hover:bg-slate-100': activeTab !== 'reports' }\"
                    class=\"flex-1 py-2 px-3 rounded-md text-[11px] font-bold uppercase tracking-wider transition-all duration-200 whitespace-nowrap\">
                    Rapports
                </button>
                {% endif %}
            </div>
        </div>

        {# Overview Tab #}
        <div x-show=\"activeTab === 'overview'\" x-collapse class=\"px-3 sm:px-0 space-y-4\">
            <div class=\"grid grid-cols-1 lg:grid-cols-3 gap-4\">
                {# Quick Actions #}
                <div class=\"lg:col-span-2 grid grid-cols-2 sm:grid-cols-4 gap-3\">
                    <a href=\"{{ path('admin_commandes_index') }}\" class=\"group bg-white border border-slate-200 p-4 rounded-lg shadow-sm hover:border-indigo-300 hover:shadow-md transition-all text-center\">
                        <div class=\"w-10 h-10 bg-indigo-50 rounded-lg mx-auto mb-2 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform\">
                            <svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2\"></path></svg>
                        </div>
                        <div class=\"text-[10px] font-bold text-slate-800 uppercase\">Commandes</div>
                    </a>
                    <a href=\"{{ path('app_produit_new') }}\" class=\"group bg-white border border-slate-200 p-4 rounded-lg shadow-sm hover:border-emerald-300 hover:shadow-md transition-all text-center\">
                        <div class=\"w-10 h-10 bg-emerald-50 rounded-lg mx-auto mb-2 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform\">
                            <svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M12 4v16m8-8H4\"></path></svg>
                        </div>
                        <div class=\"text-[10px] font-bold text-slate-800 uppercase\">Nouveau Produit</div>
                    </a>
                    <a href=\"{{ path('admin_users_index') }}\" class=\"group bg-white border border-slate-200 p-4 rounded-lg shadow-sm hover:border-amber-300 hover:shadow-md transition-all text-center\">
                        <div class=\"w-10 h-10 bg-amber-50 rounded-lg mx-auto mb-2 flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform\">
                            <svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z\"></path></svg>
                        </div>
                        <div class=\"text-[10px] font-bold text-slate-800 uppercase\">Utilisateurs</div>
                    </a>
                    <a href=\"{{ path('app_rh_conge') }}\" class=\"group bg-white border border-slate-200 p-4 rounded-lg shadow-sm hover:border-rose-300 hover:shadow-md transition-all text-center\">
                        <div class=\"w-10 h-10 bg-rose-50 rounded-lg mx-auto mb-2 flex items-center justify-center text-rose-600 group-hover:scale-110 transition-transform\">
                            <svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z\"></path></svg>
                        </div>
                        <div class=\"text-[10px] font-bold text-slate-800 uppercase\">Congés</div>
                    </a>
                </div>

                {# System Status #}
                <div class=\"bg-indigo-600 rounded-lg p-4 shadow-md text-white relative overflow-hidden\">
                    <div class=\"absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl\"></div>
                    <div class=\"relative z-10\">
                        <h2 class=\"text-[11px] font-black uppercase tracking-wider mb-3 opacity-90\">État du Système</h2>
                        <div class=\"space-y-2\">
                            <div class=\"flex justify-between items-center bg-white/10 rounded-lg p-2\">
                                <span class=\"text-[10px] font-bold uppercase\">Infrastructure</span>
                                <span class=\"flex items-center gap-1 text-[9px] font-bold\"><span class=\"w-1.5 h-1.5 bg-emerald-400 rounded-full\"></span>OK</span>
                            </div>
                            <div class=\"flex justify-between items-center bg-white/10 rounded-lg p-2\">
                                <span class=\"text-[10px] font-bold uppercase\">Serveur</span>
                                <span class=\"flex items-center gap-1 text-[9px] font-bold\"><span class=\"w-1.5 h-1.5 bg-emerald-400 rounded-full\"></span>OK</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {# Recent Orders - Mobile List #}
            <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden\">
                <div class=\"px-4 py-3 border-b border-slate-100 flex justify-between items-center\">
                    <h2 class=\"text-sm font-bold text-slate-800 uppercase tracking-wider\">Dernières Commandes</h2>
                    <a href=\"{{ path('admin_commandes_index') }}\" class=\"text-[10px] font-bold text-indigo-600 uppercase tracking-wider hover:text-indigo-800\">Tout voir</a>
                </div>
                <div class=\"divide-y divide-slate-100 lg:hidden\">
                    {% for order in recentOrders %}
                        <div class=\"p-3 flex items-center justify-between hover:bg-slate-50 transition-colors\">
                            <div class=\"min-w-0 pr-3\">
                                <div class=\"font-bold text-slate-900 text-xs truncate\">{{ order.user.nom }} {{ order.user.prenom }}</div>
                                <div class=\"flex items-center gap-2 mt-0.5\">
                                    <span class=\"text-[9px] font-bold text-slate-400 font-mono\">#{{ order.slug|slice(0,8)|upper }}</span>
                                    <span class=\"text-[9px] text-slate-400\">{{ order.createdAt|date('d/m') }}</span>
                                </div>
                                <div class=\"mt-1.5\">
                                    <span class=\"px-2 py-0.5 rounded text-[9px] font-bold uppercase {% if order.status == 'PENDING' %}bg-amber-50 text-amber-600{% elseif order.status == 'CONFIRMED' %}bg-emerald-50 text-emerald-600{% else %}bg-slate-100 text-slate-600{% endif %}\">
                                        {{ order.status|upper }}
                                    </span>
                                </div>
                            </div>
                            <a href=\"{{ path('admin_commandes_show', {id: order.id}) }}\" class=\"flex-shrink-0 w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-all\">
                                <svg width=\"14\" height=\"14\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" viewBox=\"0 0 24 24\"><path d=\"M9 5l7 7-7 7\"></path></svg>
                            </a>
                        </div>
                    {% else %}
                        <div class=\"p-6 text-center text-slate-400 text-xs font-medium\">Aucune commande récente</div>
                    {% endfor %}
                </div>
                {# Desktop Table #}
                <div class=\"hidden lg:block overflow-x-auto\">
                    <table class=\"w-full text-left\">
                        <thead class=\"bg-slate-50\">
                            <tr>
                                <th class=\"px-4 py-2 text-[10px] font-bold text-slate-500 uppercase tracking-wider\">Client</th>
                                <th class=\"px-4 py-2 text-[10px] font-bold text-slate-500 uppercase tracking-wider\">Date</th>
                                <th class=\"px-4 py-2 text-[10px] font-bold text-slate-500 uppercase tracking-wider\">Statut</th>
                                <th class=\"px-4 py-2 text-right text-[10px] font-bold text-slate-500 uppercase tracking-wider\">Action</th>
                            </tr>
                        </thead>
                        <tbody class=\"divide-y divide-slate-100\">
                            {% for order in recentOrders %}
                                <tr class=\"hover:bg-slate-50 transition-colors\">
                                    <td class=\"px-4 py-3\">
                                        <div class=\"font-bold text-slate-900 text-xs\">{{ order.user.nom }} {{ order.user.prenom }}</div>
                                        <div class=\"text-[9px] text-slate-400 font-mono\">#{{ order.slug|slice(0,8)|upper }}</div>
                                    </td>
                                    <td class=\"px-4 py-3 text-xs text-slate-500\">{{ order.createdAt|date('d M Y') }}</td>
                                    <td class=\"px-4 py-3\">
                                        <span class=\"px-2 py-0.5 rounded text-[9px] font-bold uppercase {% if order.status == 'PENDING' %}bg-amber-50 text-amber-600{% elseif order.status == 'CONFIRMED' %}bg-emerald-50 text-emerald-600{% else %}bg-slate-100 text-slate-600{% endif %}\">
                                            {{ order.status|upper }}
                                        </span>
                                    </td>
                                    <td class=\"px-4 py-3 text-right\">
                                        <a href=\"{{ path('admin_commandes_show', {id: order.id}) }}\" class=\"inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-600 hover:text-white transition-all\">
                                            <svg width=\"14\" height=\"14\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" viewBox=\"0 0 24 24\"><path d=\"M9 5l7 7-7 7\"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {# Orders Tab #}
        <div x-show=\"activeTab === 'orders'\" x-collapse class=\"px-3 sm:px-0\">
            <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden\">
                <div class=\"px-4 py-3 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white\">
                    <h2 class=\"text-sm font-bold text-slate-800 uppercase tracking-wider\">Gestion des Commandes</h2>
                </div>
                <div class=\"p-4 space-y-3\">
                    <a href=\"{{ path('admin_commandes_index') }}\" class=\"flex items-center justify-between p-3 bg-slate-50 rounded-lg hover:bg-indigo-50 transition-colors group\">
                        <div class=\"flex items-center gap-3\">
                            <div class=\"w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600\">
                                <svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2\"></path></svg>
                            </div>
                            <div>
                                <div class=\"text-sm font-bold text-slate-800\">Liste des Commandes</div>
                                <div class=\"text-[10px] text-slate-500\">{{ activeOrdersCount }} commandes actives</div>
                            </div>
                        </div>
                        <svg width=\"16\" height=\"16\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\" class=\"text-slate-400 group-hover:text-indigo-600\"><path d=\"M9 5l7 7-7 7\"></path></svg>
                    </a>
                </div>
            </div>
        </div>
        {% if is_granted('MODULE_VIEW', 'agenda') %}
        <div x-show=\"activeTab === 'reports'\" x-collapse class=\"px-3 sm:px-0\">
            <div class=\"grid grid-cols-1 lg:grid-cols-3 gap-3\">
                {# Rapport Mensuel #}
                <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden\" x-data=\"{ expanded: false }\">
                    <button @click=\"expanded = !expanded\" class=\"w-full flex items-center justify-between p-3 bg-gradient-to-r from-slate-50 to-white hover:from-slate-100 transition-all\">
                        <div class=\"flex items-center gap-2\">
                            <div class=\"w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600 shrink-0\">
                                <svg width=\"16\" height=\"16\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z\"></path></svg>
                            </div>
                            <div class=\"text-left min-w-0\">
                                <div class=\"text-xs font-bold text-slate-800 truncate\">Rapport Mensuel</div>
                                <div class=\"text-[9px] text-slate-500\">Global par Magasin</div>
                            </div>
                        </div>
                        <svg :class=\"{ 'rotate-180': expanded }\" class=\"w-4 h-4 text-slate-400 transition-transform shrink-0\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M19 9l-7 7-7-7\"></path></svg>
                    </button>
                    <div x-show=\"expanded\" x-collapse class=\"p-3 bg-slate-50/50 border-t border-slate-100 space-y-2\">
                        <div class=\"grid grid-cols-2 gap-2\">
                            <div>
                                <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Magasin</label>
                                <select id=\"reportMagasin\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200 focus:ring-1 focus:ring-indigo-100 focus:border-indigo-400 outline-none\">
                                    <option value=\"\">Tous les magasins</option>
                                    {% for mag in magasins %}
                                        <option value=\"{{ mag }}\">{{ mag }}</option>
                                    {% endfor %}
                                </select>
                            </div>
                            <div>
                                <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Employé</label>
                                <select id=\"reportUser\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200 focus:ring-1 focus:ring-indigo-100 focus:border-indigo-400 outline-none\">
                                    <option value=\"\">Tous les employés</option>
                                    {% for emp in employees|default([]) %}
                                        <option value=\"{{ emp.id }}\" data-magasin=\"{{ emp.magasin }}\">{{ emp.prenom }} {{ emp.nom }}</option>
                                    {% endfor %}
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Mois</label>
                            <input type=\"month\" id=\"reportMonth\" value=\"{{ \"now\"|date(\"Y-m\") }}\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200 focus:ring-1 focus:ring-indigo-100 focus:border-indigo-400 outline-none\">
                        </div>
                        <button onclick=\"exportMonthlyPdf()\" class=\"w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded font-bold text-[10px] uppercase tracking-wider transition-all flex items-center justify-center gap-1\">
                            <svg width=\"12\" height=\"12\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M12 11v6m0 0l-3-3m3 3l3-3m-9 4h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z\"></path></svg>
                            Générer
                        </button>
                    </div>
                </div>

                {# Validation Horaire #}
                <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden\" x-data=\"{ expanded: false }\">
                    <button @click=\"expanded = !expanded\" class=\"w-full flex items-center justify-between p-3 bg-gradient-to-r from-slate-50 to-white hover:from-slate-100 transition-all\">
                        <div class=\"flex items-center gap-2\">
                            <div class=\"w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center text-amber-600 shrink-0\">
                                <svg width=\"16\" height=\"16\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z\"></path></svg>
                            </div>
                            <div class=\"text-left min-w-0\">
                                <div class=\"text-xs font-bold text-slate-800 truncate\">Validation Horaire</div>
                                <div class=\"text-[9px] text-slate-500\">Rapport des Signatures</div>
                            </div>
                        </div>
                        <svg :class=\"{ 'rotate-180': expanded }\" class=\"w-4 h-4 text-slate-400 transition-transform shrink-0\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M19 9l-7 7-7-7\"></path></svg>
                    </button>
                    <div x-show=\"expanded\" x-collapse class=\"p-3 bg-slate-50/50 border-t border-slate-100 space-y-2\">
                        <div class=\"grid grid-cols-2 gap-2\">
                            <div>
                                <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Magasin</label>
                                <select id=\"valMagasin\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200\">
                                    <option value=\"all\">Tous les magasins</option>
                                    {% for mag in magasins|default([]) %}
                                        <option value=\"{{ mag }}\">{{ mag }}</option>
                                    {% endfor %}
                                </select>
                            </div>
                            <div>
                                <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Employé</label>
                                <select id=\"valUser\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200\">
                                    <option value=\"all\">Tous les employés</option>
                                    {% for emp in employees|default([]) %}
                                        <option value=\"{{ emp.id }}\" data-magasin=\"{{ emp.magasin }}\">{{ emp.prenom }} {{ emp.nom }}</option>
                                    {% endfor %}
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Mois</label>
                            <input type=\"month\" id=\"valMonthInput\" value=\"{{ \"now\"|date(\"Y-m\") }}\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200 focus:ring-1 focus:ring-amber-100 focus:border-amber-400 outline-none\">
                        </div>
                        <button onclick=\"generateMonthlyValidationReport(this)\" class=\"w-full bg-amber-600 hover:bg-amber-700 text-white py-2 rounded font-bold text-[10px] uppercase tracking-wider transition-all flex items-center justify-center gap-1\">
                            <svg width=\"12\" height=\"12\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z\"></path></svg>
                            Générer
                        </button>
                    </div>
                </div>

                {# Rapports Congés #}
                <div class=\"bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden\" x-data=\"{ expanded: false }\">
                    <button @click=\"expanded = !expanded\" class=\"w-full flex items-center justify-between p-3 bg-gradient-to-r from-slate-50 to-white hover:from-slate-100 transition-all\">
                        <div class=\"flex items-center gap-2\">
                            <div class=\"w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center text-rose-600 shrink-0\">
                                <svg width=\"16\" height=\"16\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z\"></path></svg>
                            </div>
                            <div class=\"text-left min-w-0\">
                                <div class=\"text-xs font-bold text-slate-800 truncate\">Rapports Congés</div>
                                <div class=\"text-[9px] text-slate-500\">Attestation</div>
                            </div>
                        </div>
                        <svg :class=\"{ 'rotate-180': expanded }\" class=\"w-4 h-4 text-slate-400 transition-transform shrink-0\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M19 9l-7 7-7-7\"></path></svg>
                    </button>
                    <div x-show=\"expanded\" x-collapse class=\"p-3 bg-slate-50/50 border-t border-slate-100 space-y-2\">
                        <div class=\"grid grid-cols-2 gap-2\">
                            <div>
                                <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Magasin</label>
                                <select id=\"conge-magasin\" onchange=\"loadCongeEmployees()\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200 focus:ring-1 focus:ring-rose-100 focus:border-rose-400 outline-none\">
                                    <option value=\"\">— Choisir —</option>
                                    {% for mag in magasins|default([]) %}
                                        <option value=\"{{ mag }}\">{{ mag }}</option>
                                    {% endfor %}
                                </select>
                            </div>
                            <div>
                                <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Employé</label>
                                <select id=\"conge-employe\" onchange=\"loadCongeList()\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200 focus:ring-1 focus:ring-rose-100 focus:border-rose-400 outline-none\" disabled>
                                    <option value=\"\">— Choisir —</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class=\"block text-[9px] font-bold text-slate-500 uppercase mb-1\">Dossier</label>
                            <select id=\"conge-dossier\" class=\"w-full text-[11px] font-bold text-slate-800 bg-white px-2 py-1.5 rounded border border-slate-200 focus:ring-1 focus:ring-rose-100 focus:border-rose-400 outline-none\" disabled>
                                <option value=\"\">— Choisir —</option>
                            </select>
                        </div>
                        <button id=\"btn-conge-pdf\" onclick=\"openCongePdf()\" class=\"w-full bg-rose-600 hover:bg-rose-700 text-white py-2 rounded font-bold text-[10px] uppercase tracking-wider transition-all flex items-center justify-center gap-1\">
                            <svg width=\"12\" height=\"12\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z\"></path></svg>
                            Générer
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {% endif %}

    </div>
</div>

{# Missing Signers Modal #}
<div id=\"missing-signers-modal\" class=\"fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4\">
    <div class=\"bg-white rounded-xl w-full max-w-md overflow-hidden shadow-xl\">
        <div class=\"bg-rose-500 p-4 text-white\">
            <div class=\"flex items-center justify-between\">
                <div class=\"flex items-center gap-3\">
                    <div class=\"w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center\">
                        <svg width=\"24\" height=\"24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z\"></path></svg>
                    </div>
                    <div>
                        <h3 class=\"text-lg font-bold\">Signatures Manquantes</h3>
                        <p class=\"text-xs opacity-80\">Le rapport ne peut pas être généré</p>
                    </div>
                </div>
                <button onclick=\"closeMissingSignersModal()\" class=\"p-1 hover:bg-white/20 rounded-lg\">
                    <svg width=\"20\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path d=\"M6 18L18 6M6 6l12 12\"></path></svg>
                </button>
            </div>
        </div>
        <div class=\"p-4 max-h-60 overflow-y-auto\">
            <p class=\"text-[10px] font-bold text-slate-400 uppercase mb-3\">Employés n'ayant pas signé :</p>
            <div id=\"missing-signers-list\" class=\"space-y-2\"></div>
        </div>
        <div class=\"p-4 border-t border-slate-100\">
            <button onclick=\"closeMissingSignersModal()\" class=\"w-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold py-2.5 rounded-lg text-xs uppercase tracking-wider transition-colors\">
                Compris
            </button>
        </div>
    </div>
</div>
{% endblock %}

{% block stylesheets %}
{{ parent() }}
<style>
    [x-cloak] { display: none !important; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
{% endblock %}

{% block javascripts %}
{{ parent() }}
<script defer src=\"https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js\"></script>
<script>
    function dashboardManager() {
        return {
            activeTab: 'overview',
        }
    }

    function generateMonthlyValidationReport(btn) {
        const monthFull = document.getElementById('valMonthInput').value;
        if (!monthFull) {
            alert('Veuillez sélectionner un mois.');
            return;
        }
        const [year, month] = monthFull.split('-');
        const mag = document.getElementById('valMagasin').value;
        const emp = document.getElementById('valUser').value;
        const originalContent = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<svg class=\"animate-spin h-4 w-4 text-white\" viewBox=\"0 0 24 24\"><circle class=\"opacity-25\" cx=\"12\" cy=\"12\" r=\"10\" stroke=\"currentColor\" stroke-width=\"4\"></circle><path class=\"opacity-75\" fill=\"currentColor\" d=\"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z\"></path></svg>';

        fetch('{{ path(\"app_rh_report_check\") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ month: parseInt(month), year: parseInt(year), magasin: mag, user_id: emp === 'all' ? null : emp })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                let url = '{{ path(\"app_rh_report_generate\") }}?month=' + parseInt(month) + '&year=' + year;
                if (mag !== 'all') url += '&magasin=' + encodeURIComponent(mag);
                if (emp !== 'all') url += '&user_id=' + emp;
                window.open(url, '_blank');
            } else {
                const listStr = data.missing.map(name => `<div class=\"p-3 bg-rose-50 text-rose-700 rounded-lg font-bold text-xs flex items-center gap-2\"><span class=\"w-2 h-2 bg-rose-400 rounded-full\"></span>\${name}</div>`).join('');
                document.getElementById('missing-signers-list').innerHTML = listStr;
                document.getElementById('missing-signers-modal').classList.remove('hidden');
                document.getElementById('missing-signers-modal').classList.add('flex');
            }
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalContent;
        });
    }

    function closeMissingSignersModal() {
        document.getElementById('missing-signers-modal').classList.add('hidden');
        document.getElementById('missing-signers-modal').classList.remove('flex');
    }

    function exportMonthlyPdf() {
        const month = document.getElementById('reportMonth').value;
        const magasin = document.getElementById('reportMagasin').value;
        const userId = document.getElementById('reportUser').value;
        if (!month) return;
        let url = '{{ path(\"app_agenda_export_pdf\") }}?month=' + month;
        if (magasin) url += '&magasin=' + magasin;
        if (userId) url += '&user_id=' + userId;
        window.open(url, '_blank');
    }

    function loadCongeEmployees() {
        const mag = document.getElementById('conge-magasin').value;
        const empSel = document.getElementById('conge-employe');
        const dossSel = document.getElementById('conge-dossier');

        empSel.innerHTML = '<option value=\"\">— Chargement... —</option>';
        empSel.disabled = true;
        dossSel.innerHTML = '<option value=\"\">— Sélectionnez un employé —</option>';
        dossSel.disabled = true;

        if (!mag) { empSel.innerHTML = '<option value=\"\">— Sélectionnez un magasin —</option>'; return; }

        fetch('/rh/conge/api/employees?magasin=' + encodeURIComponent(mag))
            .then(r => r.json())
            .then(data => {
                empSel.innerHTML = '<option value=\"\">— Choisir un employé —</option>';
                data.forEach(emp => {
                    const o = document.createElement('option');
                    o.value = emp.id;
                    o.textContent = emp.prenom + ' ' + emp.nom;
                    empSel.appendChild(o);
                });
                empSel.disabled = false;
            });
    }

    function loadCongeList() {
        const userId = document.getElementById('conge-employe').value;
        const dossSel = document.getElementById('conge-dossier');

        dossSel.innerHTML = '<option value=\"\">— Chargement... —</option>';
        dossSel.disabled = true;

        if (!userId) return;

        fetch('/rh/conge/api/list?user_id=' + userId)
            .then(r => r.json())
            .then(data => {
                dossSel.innerHTML = '<option value=\"\">— Choisir un dossier —</option>';
                data.forEach(c => {
                    const o = document.createElement('option');
                    o.value = c.id;
                    const statusLabel = c.status === 'APPROVED' ? '✓ Validé' : c.status === 'REJECTED' ? '✕ Refusé' : '⏳ En attente';
                    o.textContent = c.startDate + ' → ' + c.endDate + ' · ' + c.type + ' · ' + statusLabel;
                    dossSel.appendChild(o);
                });
                dossSel.disabled = false;
            });
    }

    function openCongePdf() {
        const id = document.getElementById('conge-dossier').value;
        if (!id) { alert('Veuillez sélectionner un dossier de congé.'); return; }
        window.open('/rh/conge/pdf/' + id, '_blank');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const magSelect = document.getElementById('valMagasin');
        const empSelect = document.getElementById('valUser');
        if (magSelect && empSelect) {
            magSelect.addEventListener('change', function() {
                const selectedMag = this.value;
                const options = empSelect.querySelectorAll('option');
                options.forEach(opt => {
                    if (opt.value === 'all') { opt.style.display = 'block'; }
                    else {
                        const empMag = opt.getAttribute('data-magasin');
                        if (selectedMag === 'all' || empMag === selectedMag) { opt.style.display = 'block'; }
                        else { opt.style.display = 'none'; }
                    }
                });
            });
        }

        // Rapport Mensuel cascading filter
        const reportMagSelect = document.getElementById('reportMagasin');
        const reportUserSelect = document.getElementById('reportUser');
        if (reportMagSelect && reportUserSelect) {
            reportMagSelect.addEventListener('change', function() {
                const selectedMag = this.value;
                const options = reportUserSelect.querySelectorAll('option');
                options.forEach(opt => {
                    if (opt.value === '') { opt.style.display = 'block'; }
                    else {
                        const empMag = opt.getAttribute('data-magasin');
                        if (selectedMag === '' || empMag === selectedMag) { opt.style.display = 'block'; }
                        else { opt.style.display = 'none'; }
                    }
                });
                reportUserSelect.value = '';
            });
        }
    });
</script>
{% endblock %}

", "dashboard/index.html.twig", "/var/www/html/templates/dashboard/index.html.twig");
    }
}
