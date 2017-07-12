<?
/*
/Copyright 2004 Micheal Waltz - ecliptik@gmail.com - http://www.ecliptik.com

This file is part of Technolust.

Technolust is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Foobar is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Technolust; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


$page = $HTTP_GET_VARS["page"];
$submit = $HTTP_POST_VARS["submitted"];
$passwrd = $HTTP_POST_VARS["passwd"];
$passedcat_id = $HTTP_GET_VARS["cat_id"];
$passedart_id = $HTTP_GET_VARS["art_id"];

echo <<<END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Administration Page - $site_name</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="$site_author" />
<meta name="keywords" content="$page_keywords" />
<meta name="description" content="$page_description" />
<meta name="robots" content="none" />

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
		<li><a href="indexadmin.php" title="Main Administration" >Main Administration</a></li>
		<li><a href="index.php" title="Main Page" >Main Page</a></li>
		<li><a href="http://validator.w3.org/check/referer" title="Valid XHTML 1.1" ><img src="images/valid-xhtml11.png" alt="Valid XHTML 1.1!" /></a></li>
		<li><a href="http://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Fwww.ecliptik.com%2Fecliptik.css&amp;warning=1&amp;profile=css2&amp;usermedium=all" title="Valid CSS2" ><img src="images/vcss.png"  alt="Valid CSS!" /></a></li>
	</ul>
		<p>&copy; $site_author</p>
	</div>

	<div id="content">
	
END;

//Begin Adding a Category
if($page == add_cat)
{

//Begin Adding the category if passed from a form
if ($submit)
{
	//Password Check
	if ($passwrd == $site_password)
	{
	$category_name_insert = $HTTP_POST_VARS["new_category_name"];
	$category_summary_insert = $HTTP_POST_VARS["new_category_summary"];

	$category_name_insert = strip_tags($category_name_insert, $allowedTags);
	$category_summary_insert = strip_tags($category_summary_insert, $allowedTags);

	$query = 'insert into category values("","'.$category_name_insert.'", "'.$category_summary_insert.'")';	

	$cat_summary_update = strip_tags($cat_summary_update, $allowedTags);

	$result = mysql_query($query, $db);
	
	#Check to make sure it added, if not report and error
	$rows_affected = mysql_affected_rows();
	if(!$rows_affected)
		echo "There was a problem, please contact your adminstrator";
	else
		echo "Creation of $category_name_insert successfull<br /><a href=\"indexadmin.php\">Return Home</a>";
	}

	else
	{
	echo "Sorry, bad password";
	}
}

else
{
echo "	<h1>Add Category</h1>\n";


echo <<<END
		<form method="post" action="$PHP_SELF" enctype="multipart/form-data">
		<p>
		Category/Link Name: <input type="text" name="new_category_name" value="Name" />
		<br />
		<br />
		Category Summary:
		<br />
		<textarea name="new_category_summary" rows="5" cols="80">
Summary</textarea>
		<br />
		Password: <input type="password" name="passwd" size="15" maxlength="15" />
		<br />
		<input type="submit" name="submitted" value="Add Category" />
		</p>
		</form>\n
END;
} //End else for HTML form output

}
//End Adding a Category



//Begin Adding an Article
elseif($page == add_art)
{

if ($submit)
{
        //Password Check
	if ($passwrd == $site_password)
	{
	
		$article_title_insert = $HTTP_POST_VARS["new_article_title"];
		$in_category = $HTTP_POST_VARS["in_category"];
		$article_summary_insert = $HTTP_POST_VARS["new_article_summary"];
		$article_body_insert = $HTTP_POST_VARS["new_article_body"];
	
		$article_title_insert = strip_tags($article_title_insert, $allowedTags);
		$article_summary_insert = strip_tags($article_summary_insert, $allowedTags);
		$article_body_insert = strip_tags($article_body_insert, $allowedTags);
	
		$query = 'insert into articles values("", "'.$in_category.'", "'.$article_title_insert.'", "'.$date_is.'", "'.$article_summary_insert.'", "'.$article_body_insert.'")';

		$result = mysql_query($query, $db);

		#Check to make sure it added, if not report and error
		$rows_affected = mysql_affected_rows();
		if(!$rows_affected)
			echo "There was a problem, please contact your adminstrator";
		else
			echo "Creation of $article_title_insert successfull<br /><a href=\"indexadmin.php\">Return Home</a>";
	}
	
	else
	{
		echo "Sorry, bad password";
	}
}

else
{
echo "	<h1>Add Article</h1>\n";

echo <<<END
		<form method="post" action="$PHP_SELF" enctype="multipart/form-data">
		<p>
		Article Title: <input type="text" name="new_article_title" value="Title" />
		<br />
		<br />

		Category: <select name="in_category">\n
END;
		
for($i = 2; $i <= $num_of_rows_category; $i++)
{
	$query="select cat_id, cat_name from category where cat_id =".$i;
	$result = mysql_query($query, $db) or die("Couldn't run category query");
	$categories_row = mysql_fetch_row($result);
	$cat_id = $categories_row[0];
	$cat_name = $categories_row[1];

	echo"		<option value=\"".$cat_id."\">".$cat_name."</option>\n";

}

echo <<<END
		</select>
		<br />
		<br />
		Article Summary:
		<br />
		<textarea name="new_article_summary" rows="5" cols="80">
Summary</textarea>
		<br />
		Article Body:
		<br />
		<textarea name="new_article_body" rows="20" cols="80">
Body</textarea>
		<br />
		<br />
		Password: <input type="password" name="passwd" size="15" maxlength="15" />
		<br />
		<input type="submit" name="submitted" value="Add Article" />
		</p>
		</form>\n
END;
}
}
//End Adding an Article


//Begin Editing a Category
elseif($page == edit_cat)
{

if ($submit)
{
	//Password Check
	if($passwrd == $site_password)
	{	
		$cat_id  = $HTTP_GET_VARS["cat_id"];
		$cat_name_update = $HTTP_POST_VARS["modify_category_name"];
		$cat_summary_update = $HTTP_POST_VARS["modify_category_summary"];

		$cat_name_update = strip_tags($cat_name_update, $allowedTags);
		$cat_summary_update = strip_tags($cat_summary_update, $allowedTags);

		$query = 'update category set cat_name="'.$cat_name_update.'", cat_sum="'.$cat_summary_update.'" where cat_id="'.$cat_id.'"';
		
		$result = mysql_query($query, $db);
		
		#Check to make sure it added, if not report and error
		$rows_affected = mysql_affected_rows();
		if(!$rows_affected)
			echo "There was a problem, please contact your adminstrator";
		else
			echo "Update of $cat_name_update successfull<br /><a href=\"indexadmin.php\">Return Home</a>";
	}

	else
	{
		echo "Sorry, bad password";
	}
}

else
{
echo "	<h1>Edit Category ".$passedcat_id."</h1>\n";

$query = "select cat_name, cat_sum from category where cat_id=".$passedcat_id;
$result = mysql_query($query, $db) or die("Couldn't run category query");
$category_row = mysql_fetch_row($result);
$cat_name = $category_row[0];
$cat_sum = $category_row[1];

echo <<<END
		<form method="post" action="$PHP_SELF" enctype="multipart/form-data">
		<p>
		Category/Link Name: <input type="text" name="modify_category_name" value="$cat_name" />
		<br />
		<br />
		Category Summary:
		<br />
		<textarea name="modify_category_summary" rows="5" cols="80">
$cat_sum</textarea>
		<br />
		<br />
		Password: <input type="password" name="passwd" size="15" maxlength="15" />
		<br />
		<input type="submit" name="submitted" value="Modify Category" />
		</p>
		</form>\n
END;
}
}
//End Editing a Category


//Begin Editing an Article
elseif($page == edit_art)
{



if ($submit)
{
	//Password Check
	if($passwrd == $site_password)
	{
		$article_category_update = $HTTP_POST_VARS["category_name_new"];
		$article_title_update = $HTTP_POST_VARS["modify_article_title"];
		$article_summary_update = $HTTP_POST_VARS["modify_article_summary"];
		$article_body_update = $HTTP_POST_VARS["modify_article_body"];
		$art_id_update = $HTTP_GET_VARS["art_id"];

		$article_title_update = strip_tags($article_title_update, $allowedTags);
		$article_summary_update = strip_tags($article_summary_update, $allowedTags);
		$article_body_update = strip_tags($article_body_update, $allowedTags);

		$query = 'update articles set cat_id="'.$article_category_update.'", art_title="'.$article_title_update.'", art_date="'.$date_is.'", art_sum="'.$article_summary_update.'", art_body="'.$article_body_update.'" where art_id="'.$art_id_update.'"';
		
		$result = mysql_query($query, $db);
		
		#Check to make sure it added, ightteenthf not report and error
		$rows_affected = mysql_affected_rows();
		if(!$rows_affected)
			echo "There was a problem, please contact your adminstrator";
		else
			echo "Update of $article_title_update successfull<br /><a href=\"indexadmin.php\">Return Home</a>";
	}
	
	else
	{       
		echo "Sorry, bad password";
	}
}

else
{
echo "	<h1>Edit Article ".$passedart_id."</h1>\n";

$query = "select cat_id, art_title, art_sum, art_body from articles where art_id=".$passedart_id;
$result = mysql_query($query, $db) or die("Couldn't run category query");
$articles_row = mysql_fetch_row($result);
$cat_id = $articles_row[0];
$art_title = $articles_row[1];
$art_sum = $articles_row[2];
$art_body = $articles_row[3];

echo <<<END
		<form method="post" action="$PHP_SELF" enctype="multipart/form-data">
		<p>
		Article Title: <input type="text" name="modify_article_title" value="$art_title" />
		<br />
		<br />
		Category:
		
		<select name="category_name_new">\n
END;
		//loop the query to find which category an article is in, and by default select the current one
		$result = mysql_query("select cat_id, cat_name from category");

		while ($row = mysql_fetch_array($result, MYSQL_NUM))
		{
		if($row[0] == $cat_id)
			 echo "		<option value=\"".$row[0]."\" selected=\"selected\">".$row[1]."</option>\n";
		else
			 echo "		<option value=\"".$row[0]."\">".$row[1]."</option>\n";
		}
echo <<<END
		</select>
		<br />
		<br />
		Article Summary:
		<br />
		<textarea name="modify_article_summary" rows="5" cols="80">
$art_sum</textarea>
		<br />
		Article Body:
		<br />
		<textarea name="modify_article_body" rows="20" cols="80">
$art_body</textarea>
		<br />
		<br />
		Password: <input type="password" name="passwd" size="15" maxlength="15" />
		<br />
		<input type="submit" name="submitted" value="Modify Article" />
		</p>
		</form>\n
END;
}
}
//End Editing an Article

//Output the Default HTML
else
{

echo "<h1>Main Administration</h1>\n";

echo "<h2>Categories | [<a href=\"indexadmin.php?page=add_cat\">Add</a>]</h2>\n";
echo "<ul>\n";
for( $i = 1; $i <= $num_of_rows_category; $i++)
	{
	$query = "select cat_id, cat_name from category where cat_id=".$i;
	$result = mysql_query($query, $db) or die("Couldn't run category query");
	$category_row = mysql_fetch_row($result);
	$cat_id = $category_row[0];
	$cat_name = $category_row[1];

	echo "<li>".$cat_name." | <a href=\"index.php?page=category&amp;cat_id=".$cat_id."\">View</a> | <a href=\"indexadmin.php?page=edit_cat&amp;cat_id=".$cat_id."\">Edit</a></li>\n";
	}

echo "</ul>\n";
echo "<h2>Articles | [<a href=\"indexadmin.php?page=add_art\">Add</a>]</h2>\n";
echo "<ul>\n";

for( $i = 1; $i <= $num_of_rows_articles; $i++)
        {
	$query = "select art_id, art_title from articles where art_id=".$i;
	$result = mysql_query($query, $db) or die("Couldn't run category query");
	$articles_row = mysql_fetch_row($result);
	$art_id = $articles_row[0];
	$art_name = $articles_row[1];

	echo "<li>".$art_name." | <a href=\"index.php?page=article&amp;art_id=".$art_id."\">View</a> | <a href=\"indexadmin.php?page=edit_art&amp;art_id=".$art_id."\">Edit</a></li>\n";
	}

echo "</ul>\n";
//End Else Loop
}

?>
