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


//HTTP Vars stuff

$page = $HTTP_GET_VARS["page"];
$passedcat_id = $HTTP_GET_VARS["cat_id"];
$passedart_id = $HTTP_GET_VARS["art_id"];
$passed_rows = $HTTP_GET_VARS["selected_rows"];

if (!$passed_rows)
    $passed_rows = 0;

if($passedcat_id)
{
$query = "select cat_name from category where cat_id=".$passedcat_id;
$result = mysql_query($query, $db) or die("Couldn't run category query");
$category_row = mysql_fetch_row($result);
$title = $category_row[0];
}

elseif($passedart_id)
{
$query = "select art_title from articles where art_id=".$passedart_id;
$result = mysql_query($query, $db) or die("Couldn't run category query");
$articles_row = mysql_fetch_row($result);
$title = $articles_row[0];
}

else
{
$title = "Website of $site_author";
}

//Begin outputting the HTML

echo <<<END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
END;
echo "\n<title>".$title." - $site_name</title>\n";
echo <<<END
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="$site_author" />
<meta name="keywords" content="$page_keywords" />
<meta name="description" content="$page_description" />
<meta name="robots" content="all" />

<style type="text/css" media="all">@import "$site_css";</style>
</head>

<body>
<div id="container">

	<div id="header">

	<h1>$site_name</h1>
	<h2>$page_heading</h2>

	</div>

	<div id="nav">
	
	<ul id="navlist">
		<li><a href="index.php" title="Go back to the homepage" >Home</a></li>\n
END;

for($i=2; $i <= $num_of_rows_category; $i++)
{

$query ="select cat_name from category where cat_id=$i";
$result = mysql_query($query, $db) or die("Couldn't run category query");
$category_row = mysql_fetch_row($result);
$cat_name = $category_row[0];
	
	if($passedcat_id == $i)
		echo "		<li class=\"selected\"><a href=\"$PHP_SELF?page=category&amp;cat_id=".$i."\" title=\"$cat_name\" >".$cat_name."</a></li>\n";
	else
		echo "		<li><a href=\"$PHP_SELF?page=category&amp;cat_id=".$i."\" title=\"$cat_name\" >".$cat_name."</a></li>\n";
}

mysql_free_result($result);



//Here is where you can add static links
echo <<<END
		<li><a href="http://validator.w3.org/check/referer" title="Valid XHTML 1.1" ><img src="images/valid-xhtml11.png" alt="Valid XHTML 1.1!" /></a></li>
		<li><a href="http://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Fwww.ecliptik.com%2Fecliptik.css&amp;warning=1&amp;profile=css2&amp;usermedium=all" title="Valid CSS2" ><img src="images/vcss.png"  alt="Valid CSS!" /></a></li>
	</ul>
		<p>&copy;2004 $site_author</p>
	</div>

	<div id="content">

END;

if ($page == category)
{
$query ="select cat_name, cat_sum from category where cat_id=$passedcat_id";

$result = mysql_query($query, $db) or die("Couldn't run category query");
$category_row = mysql_fetch_row($result);
$cat_name = $category_row[0];
$cat_sum = $category_row[1];

echo "		<h1>".$cat_name."</h1>\n";
echo "		<p>".$cat_sum."		</p>\n";

$next_page = $passed_rows + 5;

$query ="select art_id, art_title, art_date, art_sum from articles where cat_id=".$passedcat_id;
$result = mysql_query($query, $db) or die("Couldn't get list of articles");
$num_of_rows = mysql_num_rows($result);

$query = "select art_id, art_title, art_date, art_sum from articles where cat_id=".$passedcat_id." order by art_id desc limit ".$passed_rows.",5";

$result = mysql_query($query, $db) or die("Couldn't get list of articles");

while($articles_row = mysql_fetch_array($result, MYSQL_NUM))
{
$art_id = $articles_row[0];
$art_title = $articles_row[1];
$art_date = $articles_row[2];
$art_sum = $articles_row[3];

echo "		<h2>".$art_title."</h2>\n";
echo "		<h3>".$art_date."</h3>\n";
echo "		<p>";
echo "		".$art_sum."\n";
echo "		</p>";
echo "		<a href=\"$PHP_SELF?page=article&amp;art_id=".$art_id."\">Full Article</a>\n";
echo "		<hr />\n";
}

$previous_page = ($passed_rows - 5);

if ($passed_rows)
{
echo <<<END
<a href="$PHP_SELF?page=category&amp;cat_id=$passedcat_id&amp;selected_rows=$previous_page" title="Previous 5 Results">&lt;&lt;&lt;Prev</a> 
END;
}

if($num_of_rows > $next_page )
{
echo <<<END
 | <a href="$PHP_SELF?page=category&amp;cat_id=$passedcat_id&amp;selected_rows=$next_page" title="Next 5 Results">Next 5&gt;&gt;&gt;</a>
END;
}

//end if for category
}

elseif($page == article)
{

$query = "select art_title, art_date, art_body from articles where art_id=".$passedart_id;
$result = mysql_query($query, $db) or die("Couldn't run article query");
$articles_row = mysql_fetch_row($result);
$art_title = $articles_row[0];
$art_date = $articles_row[1];
$art_body = $articles_row[2];


echo "          <h2>".$art_title."</h2>\n";
echo "          <h3>".$art_date."</h3>\n";
echo "          ".$art_body."\n";
echo "          <hr />\n";
}

else
{

$query ="select cat_name, cat_sum from category where cat_id=1";
$result = mysql_query($query, $db) or die("Couldn't run category query");
$category_row = mysql_fetch_row($result);
$cat_name = $category_row[0];
$cat_sum = $category_row[1];

echo "          	<h1>".$cat_name."</h1>\n";
echo "          	".$cat_sum."\n";
}
?>
