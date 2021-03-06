<?php

/* -------------------------------------------------------+
  | PHP-Fusion Content Management System
  | Copyright (C) 2002 - 2008 Nick Jones
  | http://www.php-fusion.co.uk/
  +--------------------------------------------------------+
  | Mod: Members List
  | Version: 1.00
  | Author: Sebastian Sch�ssler (slaughter)
  | Download: http://basti2web.de
  +--------------------------------------------------------+
  | This program is released as free software under the
  | Affero GPL license. You can redistribute it and/or
  | modify it under the terms of this license which you
  | can read by viewing the included agpl.txt or online
  | at www.gnu.org/licenses/agpl.html. Removal of this
  | copyright header is strictly prohibited without
  | written permission from the original author(s).
  +--------------------------------------------------------+
  | Modded for full responsive PHP-Fusion Theme
  | Repo : https://github.com/globeFrEak/CWCLAN-PHPF-Theme
  | Modders : globeFrEak, nevo & xero - www.cwclan.de
  +-------------------------------------------------------- */
require_once "maincore.php";
require_once THEMES . "templates/header.php";

if (file_exists(LOCALE . LOCALESET . "memberlist_2.php")) {
    include LOCALE . LOCALESET . "memberlist_2.php";
} else {
    include LOCALE . "English/memberlist_2.php";
}
if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) {
    $_GET['rowstart'] = 0;
}

add_to_title($locale['global_200'] . $locale['ml_100']);

if (!isset($_GET['sortby']) || !preg_match("/^[0-9A-Z]$/", $_GET['sortby'])) {
    $_GET['sortby'] = "all";
}

if (isset($_GET['group_id']) && $_GET['group_id'] === "all") {
    $group_id = $_GET['group_id'];
    $group_name = "Community Mitglieder";
    $orderby = ($_GET['sortby'] == "all" ? "" : "user_name LIKE '" . stripinput($_GET['sortby']) . "%' ");
    $rows = dbcount("(user_id)", DB_USERS, $orderby);
    $orderby = ($orderby == "" ? "" : "WHERE " . $orderby);
    $result = dbquery(
            "SELECT *
			FROM " . DB_USERS . "			
                        " . $orderby . "
			ORDER BY user_level DESC, user_name LIMIT " . $_GET['rowstart'] . ",20");
} else {
    $group_id = (isset($_GET['group_id']) && isnum($_GET['group_id']) ? $_GET['group_id'] : "1");

    $result = dbquery("SELECT group_id, group_name FROM " . DB_USER_GROUPS . " WHERE group_id='" . $group_id . "'");
    if (dbrows($result)) {
        $data_group = dbarray($result);
        $group_name = $data_group['group_name'];
        $orderby = ($_GET['sortby'] == "all" ? "" : "AND user_name LIKE '" . stripinput($_GET['sortby']) . "%' ");
        $rows = dbcount("(user_id)", DB_USERS, "user_groups REGEXP('^\\\.{$group_id}$|\\\.{$group_id}\\\.|\\\.{$group_id}$')" . $orderby);
        $result = dbquery(
                "SELECT *
			FROM " . DB_USERS . "
			WHERE user_groups REGEXP('^\\\.{$group_id}$|\\\.{$group_id}\\\.|\\\.{$group_id}$')
                        " . $orderby . "
			ORDER BY user_level DESC, user_name LIMIT " . $_GET['rowstart'] . ",20");
    }
}
opentable($locale['ml_100'] . " - " . $group_name);
if ($rows) {
    $i = 0;
    echo "<table cellpadding='0' cellspacing='0' width='100%' id='cw_groups'>\n<tr>\n";
    //Avatar
    echo "<th>" . $locale['ml_110'] . "</th>\n";
    //Username
    echo "<th>" . $locale['ml_101'] . "</th>\n";
    //PM
    if (iMEMBER)
        echo "<th>" . $locale['ml_105'] . "</th>\n";

    echo "<th>" . $locale['ml_108'] . "</th>\n";
    echo "<th>" . $locale['ml_109'] . "</th>\n";
    echo "<th>" . $locale['ml_102'] . "</th>\n";
    echo "</tr>\n";
    while ($data = dbarray($result)) {
        $i++;
        echo "<tr>\n";
        //Avatar
        if ($data['user_avatar'] && file_exists(BASEDIR . "images/avatars/" . $data['user_avatar'])) {
            echo "<td><img class='round_user_avatar' src='" . IMAGES . "avatars/" . $data['user_avatar'] . "' alt='" . $data['user_name'] . "'/></td>\n";
        } else {
            echo "<td><img class='round_user_avatar' src='" . IMAGES . "avatars/noavatar100.png' alt='" . $data['user_name'] . "'/></td>\n";
        }

        // Name
        //---ONLINE STATUS START---//
        $lseen = time() - $data['user_lastvisit'];
        if ($lseen < 200) {
            $onstatus = "&nbsp;<img src='" . BASEDIR . "images/online.gif' alt='" . $data['user_name'] . " ist Online' title='" . $data['user_name'] . " ist Online'/>\n";
        } else {
            $onstatus = "&nbsp;<img src='" . BASEDIR . "images/offline.gif' alt='" . $data['user_name'] . " ist Offline' title='" . $data['user_name'] . " ist Offline'/>\n";
        }
        //---ONLINE STATUS END--//
        echo "<td>\n<a href='" . BASEDIR . "user_" . $data['user_id'] . "_" . seostring($data['user_name']) . ".html'>" . $data['user_name'] . $onstatus . "</a></td>\n";
        // PM	
        if (iMEMBER && $data['user_id'] != $userdata['user_id']) {
            echo "<td><a href='" . BASEDIR . "messages.php?msg_send=" . $data['user_id'] . "' title='" . $locale['572'] . "' class='btn cwtooltip'><span class='icon-envelop'></span></a></td>\n";
        } elseif (iMEMBER) {
            echo "<td>&nbsp;</td>";
        }
        echo "<td >" . $data['user_posts'] . "</td>";


        // dabei seit		
        echo "<td> " .
        showdate("%d. %b %Y", $data['user_joined']) . "</td>";

        echo "<td>" . getuserlevel($data['user_level']) . "</td>\n</tr>";
    }
    echo "</table>\n";
} else {
    echo "<br />\n" . $locale['ml_103'] . $_GET['sortby'] . "<br /><br />";
}
$search = array(
    "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
    "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"
);
echo "<hr />\n<table cellpadding='0' cellspacing='0' class='tbl-border center tbl-sort'>\n<tr>\n";
echo "<td colspan='18'><a href='" . FUSION_SELF . "?sortby=all&group_id=" . $group_id . "'>" . $locale['ml_104'] . "</a></td></tr>\n<tr>\n";
for ($i = 0; $i < 36 != ""; $i++) {
    echo "<td align='center'><div class='small'><a href='" . FUSION_SELF . "?sortby=" . $search[$i] . "&group_id=" . $group_id . "'>" . $search[$i] . "</a></div></td>";
    echo ($i == 17 ? "</tr>\n<tr>\n" : "\n");
}
echo "</tr>\n</table>\n";
if ($rows > 20) {
    echo "<div style='margin-top:5px;text-align:center'>" . makepagenav($_GET['rowstart'], 20, $rows, 3, FUSION_SELF . "?sortby=" . $_GET['sortby'] . "&group_id=" . $group_id . "&") . "</div>\n";
}
closetable();
require_once THEMES . "templates/footer.php";
?>