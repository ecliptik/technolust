*This is extremely old and I wrote it early in my career, used more for posterity than actual use.*

# Technolust

Technolust v1.0 - Copyright 2004 Micheal Waltz - ecliptik@gmail.com - http://www.ecliptik.com

## ABOUT:
Technolust is a simple and scalable web content creation system using PHP and MySQL licensed under the GPL. It is not a blogging system, but geared for the creation of a page to distribute information in a simple category/articles system. This is my first PHP/MySQL application, and I would appreciate any code suggestions more experienced developers may have.

Technolust is intended for intermediate users who wish to have more control over their site, and want a sturdy content foundation. Every page is generated from two php files, elminating code redundancy and making the site size extremely small. The look and feel of the site is determined by the single CSS file and variables in the header.php include file modify the site name, site author, and keywords on every page.

The application is broken up into three components, structure, data, and presenation. The PHP files in the /includes directory contain the code that runs on the database and generates the XHTML files displayed to a web browser. The MySQL database stores the content in a simple two table relationship of Categories and Articles. Cascading Style Sheets are used for presentation and customization of the site can easily be done by modifying the technolust.css file.

Simple and light is the goal of Technolust, and it will never gain anymore major features. Any innovative suggestions and bugs will be looked at and could be added, so please give any feedback you have.

Features:

* Fast, secure, and simple dynamic PHP pages
* Fast and scalable MySQL Database backend
* Simple web administration panel for adding/editing categories and articles, with support for HTML tags
* Automatic creation of pages, navigation links, titles, and other information
* Page presentation and structure seperate for easy customization
* Renders correctly in 800x600+ resolutions and across all major web browsing platforms
* 100% valid XHTML 1.1 Strict and CSS v2

![Technolust Screenshot](https://github.com/ecliptik/technolust/raw/master/technolust.png)

## USING:

After following the installation instructions load the indexadmin.php in your browser, and create your first category. This first category created will become the front page and will have no sub articles. Links in the navigation list will be generated off category titles.

When adding category summaries, articles summaries and pages you may use html tags, such as links, images, and paragraphs. Normally each paragraph is a block of text, and can wrap around images if you place the image tag before the block of text, and add the class="floatright" or class="floatright" in the img tag.

There is no deletion option, but rather you can edit the data and make it blank, and replace it with something new (This is to encourage updating of content instead of deleting it).


## CONTACTING:
More detailed information and FAQ can be found at http://www.ecliptik.com/index.php?page=article&art_id=2 

Questions and comments may be sent to ecliptik@gmail.com
