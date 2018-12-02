=== ASD Persons ===
Contributors: michaelfahey
Tags: structured data, schema.org, json-ld, rich content, seo
Requires PHP: 5.6
Requires at least: 3.6
Tested up to: 4.9.8
Stable tag: 1.201812011
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Plugin URI:  https://artisansitedesigns.com/plugins/asd-persons/
Author URI:  https://artisansitedesigns.com/staff/michael-h-fahey/

Creates an "Person" Custom Post Type in order to create schema.org "Person" type Rich Content using JSON-LD Structured Data. Included are a grouping Taxonomy, and a shortcode.

=== Description ===

= Rich Content =

= Shortcode =
Included is a shortcode that allows Persons to be inserted directly into other pages, using several provided templates, or a custom template that you define.

= Featured Images =
The Person post type and shortcode templates support Featured Images.

= Taxonomy =
The "Person Groups" taxonomy is included for grouping and managing Persons. The Taxonomy is visible in the Persons list and can use used for filtering.

= Additional Strutured Data =
If the ASD FastBuild Widgets are also installed, additional JSON-LD fields will be included with the Person, including the Seller properties, and its included properties.
[ASD FastBuild Widgets](https://artisansitedesigns.com/persons/asd-fastbuild-widgets/)

== Installation ==

= Manual installation =
At a command prompt or using a file manager, unzip the .ZIP file in the WordPress plugins directory, usually ~/public_html/wp-content/plugins . In the In the WordPress admin Dashboard (usually http://yoursite.foo/wp-a    dmin ) click Plugins, scroll to ASD Persons, and click "activate".

= Upload in Dashboard =
Download the ZIP file to your workstation.  In the WordPress admin Dashboard (usually http://yoursite.foo/wp-admin ) Select Plugins, Add New, click Upload Plugin, Choose File and navigate to the downloaded ZIP file. After that, click Install Now, and when the installer finishes, click Activate Plugin.

== Frequently Asked Questions ==
This Person Type does not include e-commerce Shopping Cart or Checkout functionality.

= Creating A New Person =
In the WordPress Admin Dashboard, look for the Artisan Site Designs Menu, and select Persons. Click Add New, and populate the various fields. 
**These fields are for JSON-LD Structured Data only and are not displayed in content.**
* Person Description 
* Person Image: *an URL to an image*
* Offer/Price: *numeric value, ex: 100.00*
* Currency: *example USD = US dollar*
* Aggregate Review
* Review Count

Use Google's Structured Data Testing Tool to see how the search engine
sees your structured data.
[Structured Data Testing Tool](https://search.google.com/structured-data/testing-tool/)

The fields Leading HTML and Trailing HTML are used to wrap the person in addional CSS classes. Only div elements and class attributes are allowed.

= Shortcode Syntax =
[asd_insert_persons ids='123']
*Inserts Person with ID = 123*

[asd_insert_persons ids='123,234']
*Inserts Persons with IDs = 123 and 234*

[asd_insert_persons name='my-person-slug']
*Inserts Persons with Slug (Name) my-person-slug*

[asd_insert_persons name='my-person-slug' template='my-person-template.php']
*Inserts Persons with Slug (Name) my-person-slug and use a template named my-person-template.php*

shortcode template included with the plugin
* persons-template.php

Copy any this template to your theme location so it can be customized. The theme directory is checked first, then the plugin directory. If no matching template file is found, the default template (persons-template.php) is used.

= Taxonomy =
A new Taxonomy "Person Groups" (slug: "persongroups") is included for grouping and organizing Persons.

== Screenshots ==

== Changelog ==
= 1.201812011 2018-12-01 =
First release.
