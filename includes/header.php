<?
/*Copyright 2004 Micheal Waltz - ecliptik@gmail.com - http://www.ecliptik.com

This file is part of Technolust.

Technolust is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Technolust is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Technolust; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//Site wide variables
$site_name = "Technolust Demo Page";
$page_heading = "Try out technolust";
$page_keywords = "Web Application, technolust, content, php, mysql, administration";
$page_description = "This is the page description";
$site_author = "This is the site author";
$site_css ="technolust.css";
$site_password="technolust";

//Database information

#Only mysql variable you should need to change
$mysql_password="password";

$mysql_host = "localhost";
$mysql_user = "webmaster";
$mysql_database ="technolust";

//Global variables
$date_is = date("F j, Y, g:i a");
$allowedTags = '<h1><h2><h3><h4><p><b><i><a><ul><li><pre><hr><blockquote><img>';

//DB Stuff
$db = mysql_connect("$mysql_host", "$mysql_user", "$mysql_password") or die ("Couldn't connect to database");

#handle if the database for some reason isn't exisitng
mysql_select_db("$mysql_database", $db) or die("Can't select database.");

#setup a basic query for gettin the number of rows in the category and article tables
$query = "select * from category";
$result = mysql_query($query, $db);

$num_of_rows_category = mysql_num_rows($result);

$query = "select * from articles";
$result = mysql_query($query, $db);

$num_of_rows_articles = mysql_num_rows($result);
?>
