

<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- http://davidbcalhoun.com/2010/viewport-metatag -->
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">


        <?php
        echo $this->headMeta()
                ->appendName('viewport', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no')
                ->appendHttpEquiv('X-UA-Compatible', 'IE=edge');

        echo $this->headTitle($this->translate('TFD - Global'))->setSeparator(' - ')->setAutoEscape(false);
        ?>



        <!--// OPTIONAL & CONDITIONAL CSS FILES //-->   
        <?php
        $this->headLink()
                ->appendStylesheet($this->basePath() . '/theme/css/datepicker.css?v=1')/* date picker css */
                ->appendStylesheet($this->basePath() . '/theme/css/fullcalendar.css?v=1')/* full calander css */
                ->appendStylesheet($this->basePath() . '/theme/css/TableTools.css?v=1')/* data tables extended CSS */
                ->appendStylesheet($this->basePath() . '/theme/css/bootstrap-wysihtml5.css?v=1') /* bootstrap wysimhtml5 editor */
                ->appendStylesheet($this->basePath() . '/theme/css/wysiwyg-color.css') /* bootstrap wysimhtml5 editor */
                ->appendStylesheet($this->basePath() . '/theme/css/toastr.custom.css?v=1') /* custom/responsive growl messages */
                ->appendStylesheet($this->basePath() . '/theme/css/toastr-responsive.css?v=1') /* custom/responsive growl messages */
                ->appendStylesheet($this->basePath() . '/theme/css/jquery.jgrowl.css?v=1'); /* custom/responsive growl messages */
        ?>


        <!-- // DO NOT REMOVE OR CHANGE ORDER OF THE FOLLOWING // -->

        <?php
        $this->headLink()
                ->appendStylesheet($this->basePath() . '/theme/css/bootstrap.min.css?v=1') /* bootstrap default css (DO NOT REMOVE) */
                ->appendStylesheet($this->basePath() . '/theme/css/bootstrap-responsive.min.css?v=1') /* bootstrap default css (DO NOT REMOVE) */                
                ->appendStylesheet($this->basePath() . '/theme/css/font-awesome.min.css?v=1') /* font awsome and custom icons */
                ->appendStylesheet($this->basePath() . '/theme/css/cus-icons.css?v=1') /* font awsome and custom icons */
                ->appendStylesheet($this->basePath() . '/theme/css/jarvis-widgets.css?v=1') /* jarvis widget css */
                ->appendStylesheet($this->basePath() . '/theme/css/DT_bootstrap.css?v=1') /* DT_bootstrap css */
                ->appendStylesheet($this->basePath() . '/theme/css/responsive-tables.css?v=1') /* Data tables, normal tables and responsive tables css */
                ->appendStylesheet($this->basePath() . '/theme/css/uniform.default.css?v=1') /* used where radio, select and form elements are used */
                ->appendStylesheet($this->basePath() . '/theme/css/select2.css?v=1') /* used where radio, select and form elements are used */
                ->appendStylesheet($this->basePath() . '/theme/css/theme.css?v=1') /* main theme files */
                ->appendStylesheet($this->basePath() . '/theme/css/theme-responsive.css?v=1') /* main theme files */
                ->appendStylesheet($this->basePath() . '/theme/css/themes/default.css?v=1') /* THEME CSS changed by javascript: the CSS link below will override the rules above , For more information, please see the documentation for "THEMES" */
                ->appendStylesheet($this->basePath() . '/theme/css/full-width.css?v=1') /* To switch to full width  */
                ->appendStylesheet('http://fonts.googleapis.com/css?family=Lato:300,400,700') /* Webfonts */
                ->appendStylesheet($this->basePath() . '/theme/css/') /* */
                ->appendStylesheet($this->basePath() . '/theme/css/') /* */
                ->appendStylesheet($this->basePath() . '/theme/css/') /* */
                ->appendStylesheet($this->basePath() . '/theme/css/') /* */
                ->appendStylesheet($this->basePath() . '/theme/css/') /* */
                ->appendStylesheet($this->basePath() . '/theme/css/') /* */
                ->appendStylesheet($this->basePath() . '/theme/css/') /* */
        ?>

        <!-- All javascripts are located at the bottom except for HTML5 Shim -->
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <?php
        echo $this->headScript()
                ->prependFile('http://html5shim.googlecode.com/svn/trunk/html5.js', 'text/javascript', array('conditional' => 'lt IE 9',))
                ->prependFile($this->basePath() . '/js/include/respond.min.js', 'text/javascript', array('conditional' => 'lt IE 9',));
        ?>
        <!-- icons -->
        <?php
        $this->headLink(array('rel' => 'shortcut icon', 'href' => $this->basePath() . '/theme/img/favicon.png'));
        $this->headLink(array('rel' => 'shortcut icon', 'href' => $this->basePath() . '/theme/img/favicon.ico'));
        $this->headLink(array('rel' => 'apple-touch-icon-precomposed', 'href' => $this->basePath() . '/theme/img/favicons/apple-touch-icon-retina.png', 'sizes' => '114x114')); /* For retina screens */
        $this->headLink(array('rel' => 'apple-touch-icon-precomposed', 'href' => $this->basePath() . '/theme/img/favicons/apple-touch-icon-ipad.png', 'sizes' => '72x72')); /* For iPad 1 */
        $this->headLink(array('rel' => 'apple-touch-icon-precomposed', 'href' => $this->basePath() . '/theme/img/favicons/apple-touch-icon-ipad.png')); /* For iPhone 3G, iPod Touch and Android */
        ?>

        <!--  iOS web-app metas -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <!-- Add your custom home screen title: -->
        <meta name="apple-mobile-web-app-title" content="TFD - Global"> 

        <!-- Startup image for web apps -->
        <?php
        $this->headLink(array('rel' => 'apple-touch-startup-image', 'href' => $this->basePath() . '/theme/img/splash/ipad-landscape.png', 'media' => 'screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)'));
        $this->headLink(array('rel' => 'apple-touch-startup-image', 'href' => $this->basePath() . '/theme/img/splash/ipad-portrait.png', 'media' => 'screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)'));
        $this->headLink(array('rel' => 'apple-touch-startup-image', 'href' => $this->basePath() . '/theme/img/splash/iphone.png', 'media' => 'screen and (max-device-width: 320px)'));
        echo $this->headLink();
        ?>
    </head>

    <body>
        <!-- .height-wrapper -->
        <div class="height-wrapper">

            <!-- header -->
            <header>
                <!-- tool bar -->
                <div id="header-toolbar" class="container-fluid">
                    <!-- .contained -->
                    <div class="contained">

                        <!-- theme name -->
                        <h1> TFD <span class="hidden-xs">- Global</span> </h1>
                        <!-- end theme name -->

                        <!-- span4 -->
                        <div class="pull-right">
                            <!-- demo theme switcher-->
                            <div id="theme-switcher" class="btn-toolbar">

                                <!-- search and log off button for phone devices -->
                                <div class="btn-group pull-right visible-xs">
                                    <a href="javascript:void(0)" class="btn btn-inverse btn-sm"><i class="icon-search"></i></a>
                                    <a href="login.html" class="btn btn-inverse btn-sm"><i class="icon-off"></i></a>
                                </div>
                                <!-- end buttons for phone device -->

                                <!-- dropdown mini-inbox-->
                                <div class="btn-group">
                                    <!-- new mail ticker -->
                                    <a href="javascript:void(0)" class="btn btn-sm btn-inverse dropdown-toggle" data-toggle="dropdown">
                                        <span class="mail-sticker">3</span>
                                        <i class="cus-email"></i>
                                    </a>
                                    <!-- end new mail ticker -->

                                    <!-- email lists -->
                                    <div class="dropdown-menu toolbar pull-right">
                                        <h3>Inbox</h3>
                                        <!-- "mailbox-slimscroll-js" identifier is used with Slimscroll.js plugin -->
                                        <ul id="mailbox-slimscroll-js" class="mailbox">
                                            <li>
                                                <a href="javascript:void(0)" class="unread">
                                                    <img src="/theme/img/email-important.png" alt="important mail">
                                                    From: David Simpson
                                                    <i class="icon-paper-clip"></i>
                                                    <span>Dear Victoria, Congratulations! Your work has been uploaded to wrapbootstrap.com...</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="unread attachment">

                                                    <img src="/theme/img/email-unread.png" alt="important mail">
                                                    Re:Last Year sales
                                                    <i class="icon-paper-clip"></i>
                                                    <span>Hey Vicky, find attached! Thx :-)</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="unread">
                                                    <img src="/theme/img/email-unread.png" alt="important mail">
                                                    Company Party
                                                    <i class="icon-paper-clip"></i>
                                                    <span>Hi, You have been cordially invited to join new year after party.</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="read">
                                                    <img src="/theme/img/email-read.png" alt="important mail">
                                                    RE: 2 Bugs found...
                                                    <i class="icon-paper-clip"></i>
                                                    <span>I have found two more bugs in this your beta version, maybe its not working...</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="read">
                                                    <img src="/theme/img/email-read.png" alt="important mail">
                                                    2 Bugs found...
                                                    <i class="icon-paper-clip"></i>
                                                    <span>Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales.</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="read">
                                                    <img src="/theme/img/email-read.png" alt="important mail">
                                                    Welcome to Jarvis!
                                                    <i class="icon-paper-clip"></i>
                                                    <span>Feugiat a, tellus. Phasellus viverra nulla ut metus varius. Quisque rutrum. Aenean imperdiet... </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <a href="javascript:void(0);" id="go-to-inbox">Go to Inbox <i class="icon-double-angle-right"></i></a>
                                    </div>
                                    <!-- end email lists -->
                                </div>
                                <!-- end dropdown mini-inbox-->

                                <!-- Tasks -->
                                <div class="btn-group hidden-xs">
                                    <a href="javascript:void(0)" class="btn btn-inverse btn-sm">My Tasks</a>
                                    <a href="javascript:void(0)" class="btn btn-inverse dropdown-toggle btn-sm" data-toggle="dropdown"><span class="caret"></span></a>

                                    <div class="dropdown-menu toolbar pull-right">
                                        <h3>Showing All Tasks</h3>
                                        <ul class="progressbox">
                                            <li>
                                                <strong><i class="online pull-left"></i>Urgent Bug Fixes</strong><b>Complete</b>
                                                <div class="progress progress-success slim"><div class="bar" style="width: 100%;"></div></div>
                                            </li>
                                            <li>
                                                <strong>Added functionality</strong><b>70%</b>
                                                <div class="progress progress-info slim"><div class="bar" style="width: 70%;"></div></div>
                                            </li>
                                            <li>
                                                <strong>CAD Changes</strong><b>50%</b>
                                                <div class="progress progress-info slim"><div class="bar" style="width: 50%;"></div></div>
                                            </li>
                                            <li>
                                                <strong>Marketing Campaign Mocup</strong><b>22%</b>
                                                <div class="progress progress-danger slim"><div class="bar" style="width: 22%;"></div></div>
                                            </li>
                                            <li>
                                                <strong><i class="offline pull-left"></i>Proposal</strong><b>Pending</b>
                                                <div class="progress progress-info slim"><div class="bar" style="width: 0%;"></div></div>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                                <!-- end Tasks -->

                                <!-- theme dropdown -->
                                <div class="btn-group hidden-xs">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-inverse" id="reset-widget"><i class="icon-refresh"></i></a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-inverse dropdown-toggle" data-toggle="dropdown">Themes <span class="caret"></span></a>
                                    <ul id="theme-links-js" class="dropdown-menu toolbar pull-right">
                                        <li>
                                            <a href="javascript:void(0)" data-rel="purple"><i class="icon-sign-blank purple-icon"></i>Royal Purple</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" data-rel="blue"><i class="icon-sign-blank navyblue-icon"></i>Navy Blue</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" data-rel="green"><i class="icon-sign-blank green-icon "></i>Emerald</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" data-rel="darkred"><i class="icon-sign-blank red-icon "></i>Dark Rose</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" data-rel="default"><i class="icon-sign-blank grey-icon"></i>Default</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- end theme dropdown-->

                            </div>
                            <!-- end demo theme switcher-->
                        </div>
                        <!-- end span4 -->
                    </div>
                    <!-- end .contained -->
                </div>
                <!-- end tool bar -->

            </header>
            <!-- end header -->