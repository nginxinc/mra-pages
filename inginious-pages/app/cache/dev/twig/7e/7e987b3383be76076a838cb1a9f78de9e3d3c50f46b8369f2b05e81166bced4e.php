<?php

/* /home.html.twig */
class __TwigTemplate_289d0ecc7543696a1ca19aa5640b5ea11812bb14c0476543f0d61a51f900d9aa extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_e9f3ecbcd2ca38cbe037c080dbd4715ea46801996f5a44ffdfdd749a26525db5 = $this->env->getExtension("native_profiler");
        $__internal_e9f3ecbcd2ca38cbe037c080dbd4715ea46801996f5a44ffdfdd749a26525db5->enter($__internal_e9f3ecbcd2ca38cbe037c080dbd4715ea46801996f5a44ffdfdd749a26525db5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "/home.html.twig"));

        // line 2
        echo "
<HEAD>
    <TITLE>Metadogs 5.5 | Photos</TITLE>










    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui\" />
    <meta charset=\"utf-8\" />
    <meta NAME=\"keywords\" CONTENT=\"oakland, orchid photos, new york\">
    <meta NAME=\"description\" CONTENT=\"Orchids: From the sublime to the bizarre.\">
    <meta HTTP-EQUIV=\"Expires\" CONTENT=\"Nov 16, 2015 11:10:10 AM\">
    <meta HTTP-EQUIV=\"Pragma\" CONTENT=\"no-cache\">
    <!-- <meta name=\"apple-mobile-web-app-capable\" content=\"yes\" />-->
    ";
        // line 22
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 25
        echo "    <link rel=\"Shortcut Icon\" type=\"image/x-icon\" href=\"http://www.metadogs.com/images/icon/favicon.ico\">
    <link rel=\"apple-touch-icon\" sizes=\"57x57\" href=\"http://www.metadogs.com/images/icon/apple-icon-57x57.png\">
    <link rel=\"apple-touch-icon\" sizes=\"60x60\" href=\"http://www.metadogs.com/images/icon/apple-icon-60x60.png\">
    <link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"http://www.metadogs.com/images/icon/apple-icon-72x72.png\">
    <link rel=\"apple-touch-icon\" sizes=\"76x76\" href=\"http://www.metadogs.com/images/icon/apple-icon-76x76.png\">
    <link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"http://www.metadogs.com/images/icon/apple-icon-114x114.png\">
    <link rel=\"apple-touch-icon\" sizes=\"120x120\" href=\"http://www.metadogs.com/images/icon/apple-icon-120x120.png\">
    <link rel=\"apple-touch-icon\" sizes=\"144x144\" href=\"http://www.metadogs.com/images/icon/apple-icon-144x144.png\">
    <link rel=\"apple-touch-icon\" sizes=\"152x152\" href=\"http://www.metadogs.com/images/icon/apple-icon-152x152.png\">
    <link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"http://www.metadogs.com/images/icon/apple-icon-180x180.png\">
    <link rel=\"icon\" type=\"image/png\" sizes=\"192x192\"  href=\"http://www.metadogs.com/images/icon/android-icon-192x192.png\">
    <link rel=\"icon\" type=\"image/png\" sizes=\"32x32\" href=\"http://www.metadogs.com/images/icon/favicon-32x32.png\">
    <link rel=\"icon\" type=\"image/png\" sizes=\"96x96\" href=\"http://www.metadogs.com/images/icon/favicon-96x96.png\">
    <link rel=\"icon\" type=\"image/png\" sizes=\"16x16\" href=\"http://www.metadogs.com/images/icon/favicon-16x16.png\">
    <link rel=\"manifest\" href=\"http://www.metadogs.com/images/icon/manifest.json\">
    <meta name=\"msapplication-TileColor\" content=\"#ffffff\">
    <meta name=\"msapplication-TileImage\" content=\"http://www.metadogs.com/images/icon/ms-icon-144x144.png\">
    <meta name=\"theme-color\" content=\"#ffffff\">

    <!-- js file links are in the js.jsp file -->
    ";
        // line 45
        $this->displayBlock('javascripts', $context, $blocks);
        // line 51
        echo "

</HEAD>
    <div class=\"container\">
        <!-- header -->
        <header class=\"pg-hd\">
            <section>
                <div class=\"wrapper\">
                    <div class=\"metadogs-logo\">
                        <img onClick=\"showHideMenu()\" class=\"hamburger\" alt='menu' src='http://www.metadogs.com/images/icon/hamburger.png'>
                        <a href=\"/\"> <img class=\"icon\" alt='logo' src='";
        // line 61
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("bundles/inginious/images/inginious_logo.png", null, false, "1.0"), "html", null, true);
        echo "'> </a>
                    </div>
                    <br>
                    <!--<div class=\"logo-sub\">
                        November 16, 2015  &bullet; 11:10:10 AM PST &bullet; Accessed 31371 Times
                    </div>-->
                </div>
            </section>
            <!-- nav
            <nav class=\"pg-hd__top-nav\">
                <div class=\"wrapper\">
                    <ul>

                        <li><a  href=\"/\">Home</a></li>

                        <li><a class=selected href=\"/photos/\">Photos</a></li>

                        <li><a  href=\"/chris/\">Chris</a></li>

                        <li><a  href=\"/recipes.jsp\">Recipes</a></li>

                        <li><a  href=\"/about/\">About</a></li>

                    </ul>
                    <br>

                    <ul id=\"sub_nav_menu\">

                        <li><a  href=\"/photos/family/\">Family</a></li>

                        <li><a  href=\"/photos/travel.jsp\">Travels</a></li>

                        <li><a class=selected href=\"/photos/orchids.jsp\">Orchids</a></li>

                        <li><a  href=\"/photos/catalog.jsp\">Family Catalog</a></li>

                    </ul>

                </div>
            </nav>-->
            <!--/nav-->
            <!-- Mobile Menu -->
            <div class=\"topdown-menu\">

                <div class=\"topdown-menu__nav\">
                    <ul>

                        <li><a href=\"/\">Home</a></li>

                        <li><a onClick=\"showHideSubMenu('ul.photos','img.photos',window.photosSubNavisOpen);return false;\" href=\"/photos/\">Photos<img  class=\"v-down photos\" alt='menu' src='http://www.metadogs.com/images/icon/v-down.png'></a></li>
                        <ul class=\"subnav photos\">
                            <li><a href=\"/photos/\">Photos Home</a></li>

                            <li><a href=\"/photos/family/\">Family</a></li>

                            <li><a href=\"/photos/travel.jsp\">Travels</a></li>

                            <li><a href=\"/photos/orchids.jsp\">Orchids</a></li>

                            <li><a href=\"/photos/catalog.jsp\">Family Catalog</a></li>

                        </ul>

                        <li><a onClick=\"showHideSubMenu('ul.chris','img.chris',window.chrisSubNavisOpen);return false;\" href=\"/chris/\">Chris<img  class=\"v-down chris\" alt='menu' src='http://www.metadogs.com/images/icon/v-down.png'></a></li>
                        <ul class=\"subnav chris\">
                            <li><a href=\"/chris/\">Chris Home</a></li>

                            <li><a href=\"/chris/musings.jsp\">Musings</a></li>

                            <li><a href=\"/chris/dad.jsp\">Dad</a></li>

                            <li><a href=\"/chris/brenda-and-stan.jsp\">Brenda and Stan</a></li>

                            <li><a href=\"/chris/water.jsp\">Water</a></li>

                        </ul>

                        <li><a href=\"/recipes.jsp\">Recipes</a></li>

                        <li><a onClick=\"showHideSubMenu('ul.about','img.about',window.aboutSubNavisOpen);return false;\" href=\"/about/\">About<img  class=\"v-down about\" alt='menu' src='http://www.metadogs.com/images/icon/v-down.png'></a></li>
                        <ul class=\"subnav about\">
                            <li><a href=\"/about/\">About Home</a></li>

                            <li><a href=\"/about/policies.jsp\">Policies</a></li>

                            <li><a href=\"/about/principles.jsp\">Principio</a></li>

                        </ul>

                    </ul>
                </div>
                <script>
                    var photosSubNavisOpen = {bool:false};
                    var chrisSubNavisOpen = {bool:false};
                    var aboutSubNavisOpen = {bool:false};
                </script>

                <div class=\"topdown-menu__branding\">
                    <h5>NGINX Reference Architecture</h5>

                    <img class=\"icon\" alt='logo' src='";
        // line 161
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("bundles/inginious/images/inginious_logo.png", null, false, "1.0"), "html", null, true);
        echo "'>

                    <p>&copy; 2015, NGINX Corp</p>
                </div>
            </div>
            <!--/mobile menu -->
        </header>



        <main class=\"pg-bd\">



            <script>
                var windowTitle = document.title;
                windowTitle = windowTitle + \" | \" + \"Orchids\";
                document.title = windowTitle;
            </script>




            <section class=\"hero\" style=\"background-image: url('http://www.metadogs.com/images/hero/orchids.jpg');\" >
                <div class=\"wrapper\" >
                    <h1 class=\"headline\" >Photos</h1>
                    <h2 class=\"subhead\" >From the sublime to the bizarre.</h2>
                </div>
            </section>

            <section class=\"articles-container\">

                <div id=\"next-content\"></div>

                <hr>
            </section>

            <hr>

            <section class=\"photo-set-list\">
                <ul class=\"navlist\">

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','spring bouquets 03-09', 'spring_bouquets_03-09');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/spring_bouquets_03-09_04.jpg\" alt=\"spring bouquets 03-09\">
                            <div class=\"description\">spring_bouquets_03-09</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','thanksgiving 2005', 'thanksgiving_2005');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/thanksgiving_2005_02.jpg\" alt=\"thanksgiving 2005\">
                            <div class=\"description\">thanksgiving_2005</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','sept orchids 2005', 'sept_orchids_2005');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/sept_orchids_2005_03.jpg\" alt=\"sept orchids 2005\">
                            <div class=\"description\">sept_orchids_2005</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','purple phal 12-03', 'purple_phal_12-03');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/purple_phal_12-03_02.jpg\" alt=\"purple phal 12-03\">
                            <div class=\"description\">purple_phal_12-03</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','double spike vanda 09-03', 'double_spike_vanda_09-03');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/double_spike_vanda_09-03_01.jpg\" alt=\"double spike vanda 09-03\">
                            <div class=\"description\">double_spike_vanda_09-03</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','blue vanda 02-03', 'blue_vanda_02-03');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/blue_vanda_02-03_03.jpg\" alt=\"blue vanda 02-03\">
                            <div class=\"description\">blue_vanda_02-03</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','double phal 02-03', 'double_phal_02-03.jpg');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/double_phal_02-03.jpg\" alt=\"double phal 02-03\">
                            <div class=\"description\">double_phal_02-03.jpg</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','winter orchids 2002', 'winter_orchids_2002');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/winter_orchids_2002_02.jpg\" alt=\"winter orchids 2002\">
                            <div class=\"description\">winter_orchids_2002</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','oakland orchids 11-02', 'oakland_orchids_11-02');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/oakland_orchids_11-02_05.jpg\" alt=\"oakland orchids 11-02\">
                            <div class=\"description\">oakland_orchids_11-02</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','fiery zygo 4-02', 'fiery_zygo_4-02');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/fiery_zygo_4-02_05.jpg\" alt=\"fiery zygo 4-02\">
                            <div class=\"description\">fiery_zygo_4-02</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','winter epis', 'winter_epis');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/winter_epis_01.jpg\" alt=\"winter epis\">
                            <div class=\"description\">winter_epis</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','winter pink phal', 'winter_pink_phal');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/winter_pink_phal_01.jpg\" alt=\"winter pink phal\">
                            <div class=\"description\">winter_pink_phal</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','winter yellow phal', 'winter_yellow_phal');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/winter_yellow_phal_01.jpg\" alt=\"winter yellow phal\">
                            <div class=\"description\">winter_yellow_phal</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','papuakea 11-01', 'papuakea_11-01');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/papuakea_11-01_02.jpg\" alt=\"papuakea 11-01\">
                            <div class=\"description\">papuakea_11-01</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','brandi cattelya june 2001', 'brandi_cattelya_june_2001');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/brandi_cattelya_june_2001_02.jpg\" alt=\"brandi cattelya june 2001\">
                            <div class=\"description\">brandi_cattelya_june_2001</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','asconcenda', 'asconcenda');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/asconcenda_02.jpg\" alt=\"asconcenda\">
                            <div class=\"description\">asconcenda</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','assorted flowers', 'assorted_flowers');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/assorted_flowers_02.jpg\" alt=\"assorted flowers\">
                            <div class=\"description\">assorted_flowers</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','big denbrobium', 'big_denbrobium');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/big_denbrobium_02t.jpg\" alt=\"big denbrobium\">
                            <div class=\"description\">big_denbrobium</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','big denbrobrium', 'big_denbrobrium');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/big_denbrobrium_01.jpg\" alt=\"big denbrobrium\">
                            <div class=\"description\">big_denbrobrium</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','blazing phal', 'blazing_phal');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/blazing_phal_03.jpg\" alt=\"blazing phal\">
                            <div class=\"description\">blazing_phal</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','brandi cattleya', 'brandi_cattleya');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/brandi_cattleya_05.jpg\" alt=\"brandi cattleya\">
                            <div class=\"description\">brandi_cattleya</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','cork vanda', 'cork_vanda');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/cork_vanda_01.jpg\" alt=\"cork vanda\">
                            <div class=\"description\">cork_vanda</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','cymbidium', 'cymbidium');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/cymbidium_07t.jpg\" alt=\"cymbidium\">
                            <div class=\"description\">cymbidium</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','dancing ladies', 'dancing_ladies');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/dancing_ladies_01.jpg\" alt=\"dancing ladies\">
                            <div class=\"description\">dancing_ladies</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','dancing lady', 'dancing_lady');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/dancing_lady_02.jpg\" alt=\"dancing lady\">
                            <div class=\"description\">dancing_lady</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','denbrobium', 'denbrobium');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/denbrobium_04.jpg\" alt=\"denbrobium\">
                            <div class=\"description\">denbrobium</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','dendrobium flowers', 'dendrobium_flowers');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/dendrobium_flowers_5.jpg\" alt=\"dendrobium flowers\">
                            <div class=\"description\">dendrobium_flowers</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','dendrobium pinky', 'dendrobium_pinky');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/dendrobium_pinky_01t.jpg\" alt=\"dendrobium pinky\">
                            <div class=\"description\">dendrobium_pinky</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','dendrobiums horns', 'dendrobiums_horns');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/dendrobiums_horns_04.jpg\" alt=\"dendrobiums horns\">
                            <div class=\"description\">dendrobiums_horns</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','epi cluster', 'epi_cluster');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/epi_cluster_01.jpg\" alt=\"epi cluster\">
                            <div class=\"description\">epi_cluster</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','epidendrum', 'epidendrum');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/epidendrum_02.jpg\" alt=\"epidendrum\">
                            <div class=\"description\">epidendrum</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','mary motes vanda', 'mary_motes_vanda');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/mary_motes_vanda_01.jpg\" alt=\"mary motes vanda\">
                            <div class=\"description\">mary_motes_vanda</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','miltonia purple', 'miltonia_purple');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/miltonia_purple_05.jpg\" alt=\"miltonia purple\">
                            <div class=\"description\">miltonia_purple</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','miltonia purple and white', 'miltonia_purple_and_white');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/miltonia_purple_and_white_03.jpg\" alt=\"miltonia purple and white\">
                            <div class=\"description\">miltonia_purple_and_white</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','oncidium01', 'oncidium01.jpg');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/oncidium01.jpg\" alt=\"oncidium01\">
                            <div class=\"description\">oncidium01.jpg</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','oncidium small', 'oncidium_small');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/oncidium_small_01.jpg\" alt=\"oncidium small\">
                            <div class=\"description\">oncidium_small</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','orchid flower', 'orchid_flower.jpg');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/orchid_flower.jpg\" alt=\"orchid flower\">
                            <div class=\"description\">orchid_flower.jpg</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','orchid shelf', 'orchid_shelf');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/orchid_shelf_062798.jpg\" alt=\"orchid shelf\">
                            <div class=\"description\">orchid_shelf</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','orchidae', 'orchidae');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/orchidae_062798.jpg\" alt=\"orchidae\">
                            <div class=\"description\">orchidae</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','orchids various', 'orchids_various');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/orchids_various_02.jpg\" alt=\"orchids various\">
                            <div class=\"description\">orchids_various</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','papuakea', 'papuakea');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/papuakea_03.jpg\" alt=\"papuakea\">
                            <div class=\"description\">papuakea</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','phalenopsis01', 'phalenopsis01.jpg');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/phalenopsis01.jpg\" alt=\"phalenopsis01\">
                            <div class=\"description\">phalenopsis01.jpg</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','phalenopsis', 'phalenopsis');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/phalenopsis_01t.jpg\" alt=\"phalenopsis\">
                            <div class=\"description\">phalenopsis</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','pink phalenopsis', 'pink_phalenopsis');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/pink_phalenopsis_01.jpg\" alt=\"pink phalenopsis\">
                            <div class=\"description\">pink_phalenopsis</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','purple vanda', 'purple_vanda');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/purple_vanda_06.jpg\" alt=\"purple vanda\">
                            <div class=\"description\">purple_vanda</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','sunflowers01', 'sunflowers01.jpg');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/sunflowers01.jpg\" alt=\"sunflowers01\">
                            <div class=\"description\">sunflowers01.jpg</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','sunflowers02', 'sunflowers02t.jpg');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/sunflowers02t.jpg\" alt=\"sunflowers02\">
                            <div class=\"description\">sunflowers02t.jpg</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','tulips', 'tulips');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/tulips_01t.jpg\" alt=\"tulips\">
                            <div class=\"description\">tulips</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','work orchids', 'work_orchids.jpg');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/work_orchids.jpg\" alt=\"work orchids\">
                            <div class=\"description\">work_orchids.jpg</div>
                        </a>
                    </li>

                    <li class=\"photo-set\">
                        <a onClick=\"showHidePhotoGallery('orchids','zygo 20071130', 'zygo_20071130');return false;\" class=\"photo-set-link\" href=\"/photos/index.jsp\">
                            <img src=\"http://www.metadogs.com/images/photos/thumbnails/orchids/zygo_20071130_02.jpg\" alt=\"zygo 20071130\">
                            <div class=\"description\">zygo_20071130</div>
                        </a>
                    </li>

                </ul>
            </section>

            <hr>
        </main>







        <section id=\"photo-list\">
        </section>
        <!-- footer -->
        <footer class=\"pg-ft\">
            <div class=\"wrapper\">
                <ul class=\"branding\">
                    <li class=\"copyright\">&copy; 2015, NGINX Corp., all rights reserved.</li>
                    <li class=\"\">
                        <img class= \"icon\" alt='logo' src='";
        // line 573
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("bundles/inginious/images/inginious_logo.png", null, false, "1.0"), "html", null, true);
        echo "'>
                    </li>
                </ul>
            </div>

        </footer>
        <!--/footer-->
    </div>
    </html>
";
        
        $__internal_e9f3ecbcd2ca38cbe037c080dbd4715ea46801996f5a44ffdfdd749a26525db5->leave($__internal_e9f3ecbcd2ca38cbe037c080dbd4715ea46801996f5a44ffdfdd749a26525db5_prof);

    }

    // line 22
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_7d53ab4944fb1df4688a20e2e2cd40eac080bbc2f23268975e06ca5d0f4717c7 = $this->env->getExtension("native_profiler");
        $__internal_7d53ab4944fb1df4688a20e2e2cd40eac080bbc2f23268975e06ca5d0f4717c7->enter($__internal_7d53ab4944fb1df4688a20e2e2cd40eac080bbc2f23268975e06ca5d0f4717c7_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 23
        echo "        <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("bundles/inginious/css/inginious.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" />
    ";
        
        $__internal_7d53ab4944fb1df4688a20e2e2cd40eac080bbc2f23268975e06ca5d0f4717c7->leave($__internal_7d53ab4944fb1df4688a20e2e2cd40eac080bbc2f23268975e06ca5d0f4717c7_prof);

    }

    // line 45
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_e69e8a6149b57e66155f70dc8b86dc0e285194840a632650f2652261d98963e9 = $this->env->getExtension("native_profiler");
        $__internal_e69e8a6149b57e66155f70dc8b86dc0e285194840a632650f2652261d98963e9->enter($__internal_e69e8a6149b57e66155f70dc8b86dc0e285194840a632650f2652261d98963e9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        // line 46
        echo "        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js\"></script>
        <script src=\"https://hammerjs.github.io/dist/hammer.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js\"></script>
        <script src=\"";
        // line 49
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("bundles/inginious/js/inginious.js"), "html", null, true);
        echo "\"></script>
    ";
        
        $__internal_e69e8a6149b57e66155f70dc8b86dc0e285194840a632650f2652261d98963e9->leave($__internal_e69e8a6149b57e66155f70dc8b86dc0e285194840a632650f2652261d98963e9_prof);

    }

    public function getTemplateName()
    {
        return "/home.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  646 => 49,  641 => 46,  635 => 45,  625 => 23,  619 => 22,  602 => 573,  187 => 161,  84 => 61,  72 => 51,  70 => 45,  48 => 25,  46 => 22,  24 => 2,);
    }
}
/* {# app/Resources/views/home.html.twig #}*/
/* */
/* <HEAD>*/
/*     <TITLE>Metadogs 5.5 | Photos</TITLE>*/
/* */
/* */
/* */
/* */
/* */
/* */
/* */
/* */
/* */
/* */
/*     <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui" />*/
/*     <meta charset="utf-8" />*/
/*     <meta NAME="keywords" CONTENT="oakland, orchid photos, new york">*/
/*     <meta NAME="description" CONTENT="Orchids: From the sublime to the bizarre.">*/
/*     <meta HTTP-EQUIV="Expires" CONTENT="Nov 16, 2015 11:10:10 AM">*/
/*     <meta HTTP-EQUIV="Pragma" CONTENT="no-cache">*/
/*     <!-- <meta name="apple-mobile-web-app-capable" content="yes" />-->*/
/*     {% block stylesheets %}*/
/*         <link href="{{ asset('bundles/inginious/css/inginious.css') }}" rel="stylesheet" />*/
/*     {% endblock %}*/
/*     <link rel="Shortcut Icon" type="image/x-icon" href="http://www.metadogs.com/images/icon/favicon.ico">*/
/*     <link rel="apple-touch-icon" sizes="57x57" href="http://www.metadogs.com/images/icon/apple-icon-57x57.png">*/
/*     <link rel="apple-touch-icon" sizes="60x60" href="http://www.metadogs.com/images/icon/apple-icon-60x60.png">*/
/*     <link rel="apple-touch-icon" sizes="72x72" href="http://www.metadogs.com/images/icon/apple-icon-72x72.png">*/
/*     <link rel="apple-touch-icon" sizes="76x76" href="http://www.metadogs.com/images/icon/apple-icon-76x76.png">*/
/*     <link rel="apple-touch-icon" sizes="114x114" href="http://www.metadogs.com/images/icon/apple-icon-114x114.png">*/
/*     <link rel="apple-touch-icon" sizes="120x120" href="http://www.metadogs.com/images/icon/apple-icon-120x120.png">*/
/*     <link rel="apple-touch-icon" sizes="144x144" href="http://www.metadogs.com/images/icon/apple-icon-144x144.png">*/
/*     <link rel="apple-touch-icon" sizes="152x152" href="http://www.metadogs.com/images/icon/apple-icon-152x152.png">*/
/*     <link rel="apple-touch-icon" sizes="180x180" href="http://www.metadogs.com/images/icon/apple-icon-180x180.png">*/
/*     <link rel="icon" type="image/png" sizes="192x192"  href="http://www.metadogs.com/images/icon/android-icon-192x192.png">*/
/*     <link rel="icon" type="image/png" sizes="32x32" href="http://www.metadogs.com/images/icon/favicon-32x32.png">*/
/*     <link rel="icon" type="image/png" sizes="96x96" href="http://www.metadogs.com/images/icon/favicon-96x96.png">*/
/*     <link rel="icon" type="image/png" sizes="16x16" href="http://www.metadogs.com/images/icon/favicon-16x16.png">*/
/*     <link rel="manifest" href="http://www.metadogs.com/images/icon/manifest.json">*/
/*     <meta name="msapplication-TileColor" content="#ffffff">*/
/*     <meta name="msapplication-TileImage" content="http://www.metadogs.com/images/icon/ms-icon-144x144.png">*/
/*     <meta name="theme-color" content="#ffffff">*/
/* */
/*     <!-- js file links are in the js.jsp file -->*/
/*     {% block javascripts %}*/
/*         <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>*/
/*         <script src="https://hammerjs.github.io/dist/hammer.js"></script>*/
/*         <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>*/
/*         <script src="{{ asset('bundles/inginious/js/inginious.js') }}"></script>*/
/*     {% endblock %}*/
/* */
/* */
/* </HEAD>*/
/*     <div class="container">*/
/*         <!-- header -->*/
/*         <header class="pg-hd">*/
/*             <section>*/
/*                 <div class="wrapper">*/
/*                     <div class="metadogs-logo">*/
/*                         <img onClick="showHideMenu()" class="hamburger" alt='menu' src='http://www.metadogs.com/images/icon/hamburger.png'>*/
/*                         <a href="/"> <img class="icon" alt='logo' src='{{ asset('bundles/inginious/images/inginious_logo.png', version='1.0') }}'> </a>*/
/*                     </div>*/
/*                     <br>*/
/*                     <!--<div class="logo-sub">*/
/*                         November 16, 2015  &bullet; 11:10:10 AM PST &bullet; Accessed 31371 Times*/
/*                     </div>-->*/
/*                 </div>*/
/*             </section>*/
/*             <!-- nav*/
/*             <nav class="pg-hd__top-nav">*/
/*                 <div class="wrapper">*/
/*                     <ul>*/
/* */
/*                         <li><a  href="/">Home</a></li>*/
/* */
/*                         <li><a class=selected href="/photos/">Photos</a></li>*/
/* */
/*                         <li><a  href="/chris/">Chris</a></li>*/
/* */
/*                         <li><a  href="/recipes.jsp">Recipes</a></li>*/
/* */
/*                         <li><a  href="/about/">About</a></li>*/
/* */
/*                     </ul>*/
/*                     <br>*/
/* */
/*                     <ul id="sub_nav_menu">*/
/* */
/*                         <li><a  href="/photos/family/">Family</a></li>*/
/* */
/*                         <li><a  href="/photos/travel.jsp">Travels</a></li>*/
/* */
/*                         <li><a class=selected href="/photos/orchids.jsp">Orchids</a></li>*/
/* */
/*                         <li><a  href="/photos/catalog.jsp">Family Catalog</a></li>*/
/* */
/*                     </ul>*/
/* */
/*                 </div>*/
/*             </nav>-->*/
/*             <!--/nav-->*/
/*             <!-- Mobile Menu -->*/
/*             <div class="topdown-menu">*/
/* */
/*                 <div class="topdown-menu__nav">*/
/*                     <ul>*/
/* */
/*                         <li><a href="/">Home</a></li>*/
/* */
/*                         <li><a onClick="showHideSubMenu('ul.photos','img.photos',window.photosSubNavisOpen);return false;" href="/photos/">Photos<img  class="v-down photos" alt='menu' src='http://www.metadogs.com/images/icon/v-down.png'></a></li>*/
/*                         <ul class="subnav photos">*/
/*                             <li><a href="/photos/">Photos Home</a></li>*/
/* */
/*                             <li><a href="/photos/family/">Family</a></li>*/
/* */
/*                             <li><a href="/photos/travel.jsp">Travels</a></li>*/
/* */
/*                             <li><a href="/photos/orchids.jsp">Orchids</a></li>*/
/* */
/*                             <li><a href="/photos/catalog.jsp">Family Catalog</a></li>*/
/* */
/*                         </ul>*/
/* */
/*                         <li><a onClick="showHideSubMenu('ul.chris','img.chris',window.chrisSubNavisOpen);return false;" href="/chris/">Chris<img  class="v-down chris" alt='menu' src='http://www.metadogs.com/images/icon/v-down.png'></a></li>*/
/*                         <ul class="subnav chris">*/
/*                             <li><a href="/chris/">Chris Home</a></li>*/
/* */
/*                             <li><a href="/chris/musings.jsp">Musings</a></li>*/
/* */
/*                             <li><a href="/chris/dad.jsp">Dad</a></li>*/
/* */
/*                             <li><a href="/chris/brenda-and-stan.jsp">Brenda and Stan</a></li>*/
/* */
/*                             <li><a href="/chris/water.jsp">Water</a></li>*/
/* */
/*                         </ul>*/
/* */
/*                         <li><a href="/recipes.jsp">Recipes</a></li>*/
/* */
/*                         <li><a onClick="showHideSubMenu('ul.about','img.about',window.aboutSubNavisOpen);return false;" href="/about/">About<img  class="v-down about" alt='menu' src='http://www.metadogs.com/images/icon/v-down.png'></a></li>*/
/*                         <ul class="subnav about">*/
/*                             <li><a href="/about/">About Home</a></li>*/
/* */
/*                             <li><a href="/about/policies.jsp">Policies</a></li>*/
/* */
/*                             <li><a href="/about/principles.jsp">Principio</a></li>*/
/* */
/*                         </ul>*/
/* */
/*                     </ul>*/
/*                 </div>*/
/*                 <script>*/
/*                     var photosSubNavisOpen = {bool:false};*/
/*                     var chrisSubNavisOpen = {bool:false};*/
/*                     var aboutSubNavisOpen = {bool:false};*/
/*                 </script>*/
/* */
/*                 <div class="topdown-menu__branding">*/
/*                     <h5>NGINX Reference Architecture</h5>*/
/* */
/*                     <img class="icon" alt='logo' src='{{ asset('bundles/inginious/images/inginious_logo.png', version='1.0') }}'>*/
/* */
/*                     <p>&copy; 2015, NGINX Corp</p>*/
/*                 </div>*/
/*             </div>*/
/*             <!--/mobile menu -->*/
/*         </header>*/
/* */
/* */
/* */
/*         <main class="pg-bd">*/
/* */
/* */
/* */
/*             <script>*/
/*                 var windowTitle = document.title;*/
/*                 windowTitle = windowTitle + " | " + "Orchids";*/
/*                 document.title = windowTitle;*/
/*             </script>*/
/* */
/* */
/* */
/* */
/*             <section class="hero" style="background-image: url('http://www.metadogs.com/images/hero/orchids.jpg');" >*/
/*                 <div class="wrapper" >*/
/*                     <h1 class="headline" >Photos</h1>*/
/*                     <h2 class="subhead" >From the sublime to the bizarre.</h2>*/
/*                 </div>*/
/*             </section>*/
/* */
/*             <section class="articles-container">*/
/* */
/*                 <div id="next-content"></div>*/
/* */
/*                 <hr>*/
/*             </section>*/
/* */
/*             <hr>*/
/* */
/*             <section class="photo-set-list">*/
/*                 <ul class="navlist">*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','spring bouquets 03-09', 'spring_bouquets_03-09');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/spring_bouquets_03-09_04.jpg" alt="spring bouquets 03-09">*/
/*                             <div class="description">spring_bouquets_03-09</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','thanksgiving 2005', 'thanksgiving_2005');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/thanksgiving_2005_02.jpg" alt="thanksgiving 2005">*/
/*                             <div class="description">thanksgiving_2005</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','sept orchids 2005', 'sept_orchids_2005');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/sept_orchids_2005_03.jpg" alt="sept orchids 2005">*/
/*                             <div class="description">sept_orchids_2005</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','purple phal 12-03', 'purple_phal_12-03');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/purple_phal_12-03_02.jpg" alt="purple phal 12-03">*/
/*                             <div class="description">purple_phal_12-03</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','double spike vanda 09-03', 'double_spike_vanda_09-03');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/double_spike_vanda_09-03_01.jpg" alt="double spike vanda 09-03">*/
/*                             <div class="description">double_spike_vanda_09-03</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','blue vanda 02-03', 'blue_vanda_02-03');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/blue_vanda_02-03_03.jpg" alt="blue vanda 02-03">*/
/*                             <div class="description">blue_vanda_02-03</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','double phal 02-03', 'double_phal_02-03.jpg');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/double_phal_02-03.jpg" alt="double phal 02-03">*/
/*                             <div class="description">double_phal_02-03.jpg</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','winter orchids 2002', 'winter_orchids_2002');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/winter_orchids_2002_02.jpg" alt="winter orchids 2002">*/
/*                             <div class="description">winter_orchids_2002</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','oakland orchids 11-02', 'oakland_orchids_11-02');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/oakland_orchids_11-02_05.jpg" alt="oakland orchids 11-02">*/
/*                             <div class="description">oakland_orchids_11-02</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','fiery zygo 4-02', 'fiery_zygo_4-02');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/fiery_zygo_4-02_05.jpg" alt="fiery zygo 4-02">*/
/*                             <div class="description">fiery_zygo_4-02</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','winter epis', 'winter_epis');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/winter_epis_01.jpg" alt="winter epis">*/
/*                             <div class="description">winter_epis</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','winter pink phal', 'winter_pink_phal');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/winter_pink_phal_01.jpg" alt="winter pink phal">*/
/*                             <div class="description">winter_pink_phal</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','winter yellow phal', 'winter_yellow_phal');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/winter_yellow_phal_01.jpg" alt="winter yellow phal">*/
/*                             <div class="description">winter_yellow_phal</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','papuakea 11-01', 'papuakea_11-01');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/papuakea_11-01_02.jpg" alt="papuakea 11-01">*/
/*                             <div class="description">papuakea_11-01</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','brandi cattelya june 2001', 'brandi_cattelya_june_2001');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/brandi_cattelya_june_2001_02.jpg" alt="brandi cattelya june 2001">*/
/*                             <div class="description">brandi_cattelya_june_2001</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','asconcenda', 'asconcenda');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/asconcenda_02.jpg" alt="asconcenda">*/
/*                             <div class="description">asconcenda</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','assorted flowers', 'assorted_flowers');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/assorted_flowers_02.jpg" alt="assorted flowers">*/
/*                             <div class="description">assorted_flowers</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','big denbrobium', 'big_denbrobium');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/big_denbrobium_02t.jpg" alt="big denbrobium">*/
/*                             <div class="description">big_denbrobium</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','big denbrobrium', 'big_denbrobrium');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/big_denbrobrium_01.jpg" alt="big denbrobrium">*/
/*                             <div class="description">big_denbrobrium</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','blazing phal', 'blazing_phal');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/blazing_phal_03.jpg" alt="blazing phal">*/
/*                             <div class="description">blazing_phal</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','brandi cattleya', 'brandi_cattleya');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/brandi_cattleya_05.jpg" alt="brandi cattleya">*/
/*                             <div class="description">brandi_cattleya</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','cork vanda', 'cork_vanda');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/cork_vanda_01.jpg" alt="cork vanda">*/
/*                             <div class="description">cork_vanda</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','cymbidium', 'cymbidium');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/cymbidium_07t.jpg" alt="cymbidium">*/
/*                             <div class="description">cymbidium</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','dancing ladies', 'dancing_ladies');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/dancing_ladies_01.jpg" alt="dancing ladies">*/
/*                             <div class="description">dancing_ladies</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','dancing lady', 'dancing_lady');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/dancing_lady_02.jpg" alt="dancing lady">*/
/*                             <div class="description">dancing_lady</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','denbrobium', 'denbrobium');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/denbrobium_04.jpg" alt="denbrobium">*/
/*                             <div class="description">denbrobium</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','dendrobium flowers', 'dendrobium_flowers');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/dendrobium_flowers_5.jpg" alt="dendrobium flowers">*/
/*                             <div class="description">dendrobium_flowers</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','dendrobium pinky', 'dendrobium_pinky');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/dendrobium_pinky_01t.jpg" alt="dendrobium pinky">*/
/*                             <div class="description">dendrobium_pinky</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','dendrobiums horns', 'dendrobiums_horns');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/dendrobiums_horns_04.jpg" alt="dendrobiums horns">*/
/*                             <div class="description">dendrobiums_horns</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','epi cluster', 'epi_cluster');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/epi_cluster_01.jpg" alt="epi cluster">*/
/*                             <div class="description">epi_cluster</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','epidendrum', 'epidendrum');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/epidendrum_02.jpg" alt="epidendrum">*/
/*                             <div class="description">epidendrum</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','mary motes vanda', 'mary_motes_vanda');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/mary_motes_vanda_01.jpg" alt="mary motes vanda">*/
/*                             <div class="description">mary_motes_vanda</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','miltonia purple', 'miltonia_purple');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/miltonia_purple_05.jpg" alt="miltonia purple">*/
/*                             <div class="description">miltonia_purple</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','miltonia purple and white', 'miltonia_purple_and_white');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/miltonia_purple_and_white_03.jpg" alt="miltonia purple and white">*/
/*                             <div class="description">miltonia_purple_and_white</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','oncidium01', 'oncidium01.jpg');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/oncidium01.jpg" alt="oncidium01">*/
/*                             <div class="description">oncidium01.jpg</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','oncidium small', 'oncidium_small');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/oncidium_small_01.jpg" alt="oncidium small">*/
/*                             <div class="description">oncidium_small</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','orchid flower', 'orchid_flower.jpg');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/orchid_flower.jpg" alt="orchid flower">*/
/*                             <div class="description">orchid_flower.jpg</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','orchid shelf', 'orchid_shelf');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/orchid_shelf_062798.jpg" alt="orchid shelf">*/
/*                             <div class="description">orchid_shelf</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','orchidae', 'orchidae');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/orchidae_062798.jpg" alt="orchidae">*/
/*                             <div class="description">orchidae</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','orchids various', 'orchids_various');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/orchids_various_02.jpg" alt="orchids various">*/
/*                             <div class="description">orchids_various</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','papuakea', 'papuakea');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/papuakea_03.jpg" alt="papuakea">*/
/*                             <div class="description">papuakea</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','phalenopsis01', 'phalenopsis01.jpg');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/phalenopsis01.jpg" alt="phalenopsis01">*/
/*                             <div class="description">phalenopsis01.jpg</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','phalenopsis', 'phalenopsis');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/phalenopsis_01t.jpg" alt="phalenopsis">*/
/*                             <div class="description">phalenopsis</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','pink phalenopsis', 'pink_phalenopsis');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/pink_phalenopsis_01.jpg" alt="pink phalenopsis">*/
/*                             <div class="description">pink_phalenopsis</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','purple vanda', 'purple_vanda');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/purple_vanda_06.jpg" alt="purple vanda">*/
/*                             <div class="description">purple_vanda</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','sunflowers01', 'sunflowers01.jpg');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/sunflowers01.jpg" alt="sunflowers01">*/
/*                             <div class="description">sunflowers01.jpg</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','sunflowers02', 'sunflowers02t.jpg');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/sunflowers02t.jpg" alt="sunflowers02">*/
/*                             <div class="description">sunflowers02t.jpg</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','tulips', 'tulips');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/tulips_01t.jpg" alt="tulips">*/
/*                             <div class="description">tulips</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','work orchids', 'work_orchids.jpg');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/work_orchids.jpg" alt="work orchids">*/
/*                             <div class="description">work_orchids.jpg</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                     <li class="photo-set">*/
/*                         <a onClick="showHidePhotoGallery('orchids','zygo 20071130', 'zygo_20071130');return false;" class="photo-set-link" href="/photos/index.jsp">*/
/*                             <img src="http://www.metadogs.com/images/photos/thumbnails/orchids/zygo_20071130_02.jpg" alt="zygo 20071130">*/
/*                             <div class="description">zygo_20071130</div>*/
/*                         </a>*/
/*                     </li>*/
/* */
/*                 </ul>*/
/*             </section>*/
/* */
/*             <hr>*/
/*         </main>*/
/* */
/* */
/* */
/* */
/* */
/* */
/* */
/*         <section id="photo-list">*/
/*         </section>*/
/*         <!-- footer -->*/
/*         <footer class="pg-ft">*/
/*             <div class="wrapper">*/
/*                 <ul class="branding">*/
/*                     <li class="copyright">&copy; 2015, NGINX Corp., all rights reserved.</li>*/
/*                     <li class="">*/
/*                         <img class= "icon" alt='logo' src='{{ asset('bundles/inginious/images/inginious_logo.png', version='1.0') }}'>*/
/*                     </li>*/
/*                 </ul>*/
/*             </div>*/
/* */
/*         </footer>*/
/*         <!--/footer-->*/
/*     </div>*/
/*     </html>*/
/* */
