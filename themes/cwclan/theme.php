<?php

//Theme Settings
define("THEME_BULLET", "<span class='bullet'>&middot;</span>"); //bullet image
//Theme Settings /

if (!defined("IN_FUSION")) {
    die("Access Denied");
}
require_once INCLUDES . "theme_functions_include.php";

function get_head_tags() {
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<link rel='stylesheet' href='" . THEME . "css/bootstrap.css'>";
    echo "<link rel='stylesheet' href='" . THEME . "css/bootstrap-theme.css'>";    
    echo "<link rel='stylesheet' href='" . THEME . "css/responsive.css'>";
    echo "<link rel='stylesheet' href='" . THEME . "css/icomoon.css'>";
    echo "<link href='http://fonts.googleapis.com/css?family=Oswald:400,300|Roboto:400,500|Roboto+Condensed:400,300,700|Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>";    
}
add_to_head("<link rel='stylesheet' href='" . THEME . "jQueryMobile/jquery.mobile-1.3.2.cw.css'>");
add_to_head('<script type="text/javascript">
        $(document).bind("mobileinit", function() {
            $.mobile.ignoreContentEnabled = true;
        });
        $( document ).on( "pageinit", "#page", function() {
            $( document ).on( "swipeleft swiperight", "#page", function( e ) {
            // We check if there is no open panel on the page because otherwise
            // a swipe to close the left panel would also open the right panel (and v.v.).
            // We do this by checking the data that the framework stores on the page element (panel: open).
            if ( $.mobile.activePage.jqmData( "panel" ) !== "open" ) {
                if ( e.type === "swipeleft"  ) {
                    $( "#right-panel" ).panel( "open" );
                } else if ( e.type === "swiperight" ) {
                    $( "#left-panel" ).panel( "open" );
                }
            }
            });
        });
        </script>');
add_to_head('<script src="' . THEME . 'jQueryMobile/jquery.mobile-1.3.2.min.js"></script>');


function render_page($license = false) {
    global $aidlink, $locale, $settings, $main_style;

    // SWIPE-MENU Content
    echo '<div data-role="page" id="page">';            
    // Content Begin
    
    echo '<div data-role="content">
          <div class="wrapper clearfix" data-enhance="false">          
          <div class="breadcrumb"><span class="c_orange"></span></div>
          <div class="hero"></div>';

    // Navbar Begin
    echo'<nav class="navbar navbar-inverse" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>                
            </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="' . BASEDIR . 'index.php">Startseite</a></li>
                    <li><a href="' . BASEDIR . 'forum/index.php">Forum</a></li>                                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Fotogalerie
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="' . BASEDIR . 'photogallery.php">Galerie</a></li>
                            <li><a href="#">Meist angesehene Bilder</a></li>
                        </ul>
                    </li> <!-- Dropdown End -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Server
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">HLStats</a></li>
                            <li><a href="#">Map Bewertungen</a></li>
                            <li><a href="#">Reserved Slots</a></li>
                        </ul>
                    </li> <!-- Dropdown End -->
                </ul>   
            </div><!-- /.navbar-collapse -->
        </nav>';
    // Main / Content Begin
    echo '<div class="main clearfix">
                <div class="content">
                    ' . U_CENTER . CONTENT . L_CENTER . '
          </div>';
    // Sidebar		
    echo '<div class="sidebar visible-md visible-lg">';
    if (RIGHT) {
        echo RIGHT;
    }
    if (LEFT) {
        echo LEFT;
    }
    echo '</div></div>';
    // Footer
    echo'<footer class="clearfix" data-enhance="false"><span style="float:left;padding-top:10px">(c) 2013 <span class="c_orange">cwclan</span> - clan & community</span>
            <span style="float:right">' . showcopyright() . '</span></footer>
        </div>';

    echo '<div class="footernav visible-md visible-lg" data-enhance="false">
            <div class="links-section">
                <h4>Server</h4>                    
                <ul class="links-s-content">
                    <li>
                        <a href="#" title="" target="_blank">TF2</a>
                    </li>
                    <li>
                        <a href="#" title="" target="_blank">Minecraft</a>
                    </li>
                    <li>
                        <a href="#" title="" target="_blank">Mumble - Voice Server</a>
                    </li>
                </ul>
            </div>
            <div class="links-section">
                <h4>Heißer Stuff</h4>                    
                <ul class="links-s-content">
                    <li>
                        <a href="http://timkopplow.com/dev/cwish/" target="_blank" title="Nevos Responsive Design">Nevos Responsive Design</a>
                    </li>
                    <li>
                        <a href="#" title="">Test</a>
                    </li>
                </ul>
            </div>
            <div class="child links-section">
                <h4>Info</h4>
                    <div class="links-s-content">
                    PHP-Fusion Version:<b> ' . $settings['version'] . '</b><br>' . showrendertime() . '
                    </div>	
            </div>
        </div>
        </div><!-- /swipe content -->
        <div data-role="panel" id="left-panel" data-position-fixed="true">            
            '.showsublinks("","").'            
        </div><!-- /swipe panel left -->
        <div data-role="panel" id="right-panel" data-position="right" data-position-fixed="true">';
            echo '<div class="sidebar">';
            if (RIGHT) {
                echo RIGHT;
            }
            if (LEFT) {
                echo LEFT;
            }
            echo '</div>';           
   echo'</div><!-- /swipe panel right -->
        <div data-role="footer" data-position="fixed">
            <div data-role="navbar">
                <ul>
                    <li><a href="#left-panel">
                        <span class="icon-indent-increase"></span></a>
                    </li>                    
                    <li><a href="#right-panel">
                        <span class="icon-indent-decrease"></span></a>
                    </li>
                </ul>
                
            </div><!-- /navbar -->
        </div><!-- /footer -->
        </div>';
    // Scripts and co.
    add_to_footer('<!-- Scripts -->        
        <script src="' . THEME . 'js/vendor/bootstrap.min.js"></script>        
        <script src="' . THEME . 'js/plugins.js"></script>
        <script src="' . THEME . 'js/main.js"></script>       
        <script>
        $(".tp").tooltip({
            placement : "right"
        });
        $(".tp2").tooltip({
            placement : "right"
        });
        </script>');
}

/* New in v7.02 - render comments */

function render_comments($c_data, $c_info) {
    global $locale, $settings;
    opentable($locale['c100']);
    if (!empty($c_data)) {
        echo "<div class='comments floatfix'>";
        $c_makepagenav = '';
        if ($c_info['c_makepagenav'] !== FALSE) {
            echo $c_makepagenav = "<div style='text-align:center;margin-bottom:5px;'>" . $c_info['c_makepagenav'] . "</div>";
        }
        foreach ($c_data as $data) {
            $comm_count = "<a href='" . FUSION_REQUEST . "#c" . $data['comment_id'] . "' id='c" . $data['comment_id'] . "' name='c" . $data['comment_id'] . "'>#" . $data['i'] . "</a>";
            echo "<div class='tbl2 clearfix floatfix'>";
            if ($settings['comments_avatar'] == "1") {
                echo "<span class='comment-avatar'>" . $data['user_avatar'] . "</span>";
            }
            echo "<span style='float:right' class='comment_actions'>" . $comm_count . "</span>";
            echo "<span class='comment-name'>" . $data['comment_name'] . "</span>\n<br />";
            echo "<span class='small'>" . $data['comment_datestamp'] . "</span>";
            if ($data['edit_dell'] !== false) {
                echo "<br />\n<span class='comment_actions'>" . $data['edit_dell'] . "\n</span>";
            }
            echo "</div>\n<div class='tbl1 comment_message'>" . $data['comment_message'] . "</div>";
        }
        echo $c_makepagenav;
        if ($c_info['admin_link'] !== FALSE) {
            echo "<div style='float:right' class='comment_admin'>" . $c_info['admin_link'] . "</div>";
        }
        echo "</div>\n";
    } else {
        echo $locale['c101'];
    }
    closetable();
}

function newsposter2($info, $sep = "", $class = "") {
    global $locale;
    $res = "";
    $link_class = $class ? " class='$class' " : "";
    $res = "<span " . $link_class . ">" . profile_link($info['user_id'], $info['user_name'], $info['user_status']) . "</span>&nbsp;";
    $res .= showdate("newsdate", $info['news_date']);
    $res .= $info['news_ext'] == "y" || $info['news_allow_comments'] ? $sep . "\n" : "\n";
    return "<!--news_poster-->" . $res;
}

function newsopts2($info, $sep, $class = "") {
    global $locale, $settings;
    $res = "";
    $link_class = $class ? " class='$class' " : "";
    if ($info['news_allow_comments'] && $settings['comments_enabled'] == "1") {
        $res = "<a href='news.php?readmore=" . $info['news_id'] . "#comments'" . $link_class . ">" . $info['news_comments'] . "&nbsp;<span class='icons icon-bubbles'></span></a> " . $sep . " ";
    }
    if ($info['news_ext'] == "y" || ($info['news_allow_comments'] && $settings['comments_enabled'] == "1")) {
        $res .= $info['news_reads'] . $locale['global_074'] . "\n" . $sep;
    }
    $res .= "<a href='print.php?type=N&amp;item_id=" . $info['news_id'] . "'><img src='" . get_image("printer") . "' alt='" . $locale['global_075'] . "' style='vertical-align:middle;border:0;' /></a>\n";
    return "<!--news_opts-->" . $res;
}

function render_news($subject, $news, $info) {

    global $locale;

    if (!isset($_GET['readmore']) && $info['news_ext'] == 'y') {
        $linked_subject = '<h3><a href="news.php?readmore=' . $info['news_id'] . '" name="news_' . $info['news_id'] . '" id="news_' . $info['news_id'] . '">' . $info['news_subject'] . '</a></h3>';
    } else {
        $linked_subject = '<h3> ' . $info['news_subject'] . '</h3>';
    }

    echo "<article>        
	" . (!empty($subject) ? "$linked_subject" : "$subject") . "\n";
    echo '<div class="article_submenu clearfix">
                            <span class="author">
                                Veröffentlicht von: ' . newsposter2($info, '') . itemoptions('N', $info['news_id']) . '
                            </span>
                            <span class="comments">
                                <a href="#">' . newsopts2($info, ' &middot; ') . '</a>                                
                            </span>                                                        
                        </div>
                        <p class="article">
						' . $news . '
                        </p>                        
                    </article>';
}

function render_article($subject, $article, $info) {
    global $locale;

    echo "<article>
	" . (!empty($title) ? "<h3>$title</h3>" : "") . "\n";
    echo '<div class="article_submenu clearfix">
                            <div class="article_submenu_left">
                                ' . $info['cat_image'] . '
                            </div>
                            <div class="article_submenu_right">
						      <h3>' . $subject . '</h3>
                                <span class="author">
                                Published by ' . articleposter($info, '') . itemoptions('N', $info['news_id']) . '
                                </span>
                            </div>
                        </div>
                        <p class="article">
						' . $article . '
                        </p>
                        <span class="comments">
                        <a href="#">' . articleopts($info, ' &middot; ') . '</a>
                        </span>
                    </article>';
}

function opentable($title) {

    echo "<article>
	" . (!empty($title) ? "<h3>$title</h3>" : "");
}

function closetable() {

    echo "</article>";
}

function openside($title, $collapse = false, $state = "on") {
    global $panel_collapse;
    $panel_collapse = $collapse;
    echo "<div class='box'>";
    echo "<h3>" . $title . "</h3>";
    if ($collapse == true) {
        $boxname = str_replace(" ", "", $title);
        echo "<span>" . panelbutton($state, $boxname) . "</span>";
    }
    echo "<div class='sidebar_div'>";
    if ($collapse == true) {
        echo panelstate($state, $boxname);
    }
}

function closeside() {
    global $panel_collapse;
    if ($panel_collapse == true) {
        echo "</div>";
    }
    echo "</div></div>";
}

?>
