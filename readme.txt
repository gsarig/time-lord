=== Time Lord ===
Contributors: gsarig
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=R68GJ2RBSVXGN
Tags: Shortcode, Time, schedule
Requires at least: 4.0
Tested up to: 6.0
Stable tag: 1.2
License: GPLv2 or later

Make modifications on your content based on time parameters. Show or hide part of a post at a given point in the future, calculate age and more.

== Description ==

Time Lord is a plugin which allows you to schedule the publication of part of your content on a set date. It can also calculate age based on a set year in the past or the estimated time if the year is set in the future. 

You can use it in posts, pages or any other content type via the <code>[timelord]</code> shordcode. Here are some common examples, supposing that present day is on April 2015:

* <code>[timelord from="2016-01"]SOME CONTENT[/timelord]</code> would output "SOME CONTENT" only when January 2016 comes. 
* <code>[timelord to="2016-01"]SOME CONTENT[/timelord]</code> would output "SOME CONTENT" until January 2016 and then it would remove it. 
* <code>[timelord from="2015-04-01" to="2016-04-01" every="1 day"]SOME CONTENT[/timelord]</code> would output "SOME CONTENT" every other day until April 2016. 
* <code>[timelord from="2015-04-01" to="2016-04-01" every="Monday"]SOME CONTENT[/timelord]</code> would output "SOME CONTENT" every Monday until April 2016. 
* <code>[timelord to="2014-01" del="yes"]SOME CONTENT[/timelord]</code> would output <code><del>SOME CONTENT</del></code> (check screenshot for an example of what the user would actually see in the frontend). 
* <code>[timelord from="2015-01" to="2016-01"]SOME CONTENT[/timelord]</code> would output "SOME CONTENT" from January 2015 to January 2016.
* <code>[timelord mode="hide" from="2015-01" to="2016-01"]SOME CONTENT[/timelord]</code> would output "SOME CONTENT" every other time except from January 2015 to January 2016.
* <code>[timelord year="1980"]</code> would output "35".
* <code>[timelord year="1980" ordinal="yes"]</code> would output "35th".

[View the demo](http://demos.gsarigiannidis.gr/time-lord/ "Time Lord Demo")

= Features =

* Allows you to show or hide content at a given timeframe.
* Supports recurring display of the output at given intervals (e.g. every hour, every day, every month etc.).
* Allows you to wrap your content in the <code><del></del></code> tag instead of removing it when expires. 
* It can display an alternate message when the actual content is not supposed to be shown. 
* It can output the time remaining until the content will be up or down. 
* It can calculate age and even output it with an ordinal suffix. 
* You can use it anywhere a shortcode would go. On posts, pages, custom posts. 
* You can add as many shortcodes as you like in a single post. 

== Installation ==

1. Upload the Time Lord plugin to your WordPress plugins directory and activate it. 
2. That's it! There is no options page. Just go and start adding your shortcodes as described in the FAQ section.

== Frequently Asked Questions ==

= Which are the available parameters? =

Shortcode parameters include the following:

* <strong>mode</strong>. It is used to determine whether the wrapped content will be shown or hidden at the given timeframe. By default it is set to "show". The other parameter you can give is "hide". 
* <strong>from</strong>. The date your content should start appearing. It accepts time values of the form "YYYY-MM-DD hh:mm:ss" (for example: <code>[timelord from="2016-4-1 20:10:00"]SOME CONTENT[/timelord]</code> will show the text "SOME CONTENT" on April 1st of 2016 at 20:10). If you don't care about so much specificity, you can omit values from right to left. For example, you could just add from="2016-04" if you want to show your content as soon as April 2016 comes. 
* <strong>to</strong>. Same as the "from" parameter, "to" allows you to hide content at a specific time in the future. The same rules described at the "from" parameters apply here as well. 
* <strong>every</strong>. Output content recursively at specified intervals. It works best if a "from" and "to" dates are set. For example,  <code>[timelord from="2015-04-01" to="2016-04-01" every="1 day"]SOME CONTENT[/timelord]</code> would output "SOME CONTENT" every other day until April 1st. This parameter can accept a date with relative parts like for example every="12 hours", every="2 days", every="1 hour" etc. ([See examples](http://php.net/manual/en/datetime.formats.relative.php "PHP Relative Formats")). Also, you can use the day's' name to show content on a specific day of the week using, for example every="Monday". NOTE: the "every" parameter cannot be combined with the other parameters that follow - it will just show or hide the content depending on the given interval. 
* <strong>del</strong>. Instead of just removing the content when it expires, this parameter wraps it in the <code><del></del></code> tag in order to mark it as "erased". For example, <code>[timelord to="2016-4-1" del="yes"]SOME CONTENT[/timelord]</code> would output <code><del>SOME CONTENT</del></code> (check screenshot for an example of what the user would actually see in the frontend).
* <strong>message</strong>. It displays some alternate content until the set date comes. It accepts some basic HTML formatting.  
* <strong>from_msg</strong>. If this parameter is set and is not empty AND if the "from" parameter is set, it will show the remaining time until the publication (for example "4 months"). If you add any text in there, it will add this text before the remaining time. For example, given that present is April 2015, <code>[timelord from="2016-04" from_msg="Content will be live in: "]SOME CONTENT[/timelord]</code> would output "Content will be live in 12 months".
* <strong>to_msg</strong>. It have exactly the same function as the "from_msg", only this time it calculated the end date (as long as the "to" parameter is set). 
* <strong>year</strong>. This is a standalone parameter, which means that if it is set, all the previous get ignored. It is used to calculate age. For example, given that we are on 2015 <code>[timelord year="1980"]</code> will output "35". If the year is set to the future, it will output the years remaining. for example, <code>[timelord year="2020"]</code> would output "5". 
* <strong>ordinal</strong>. This is the only parameter that can be used along with "year", to add an ordinal suffix to the output. For example <code>[timelord year="1980" ordinal="yes"]</code> would output "35th". 

You can combine the parameters in many ways. For example, given that we are on April 2015, <code>[timelord from="2016-04" to="2017-04" message="Content not yet available. " from_msg="Time to be up: " to_msg="Will expire: "]SOME CONTENT. [/timelord]</code> would output the following:

- If we are on April 2015: "Content not yet available. Time to be up: 12 months"
- On April 2016: "SOME CONTENT. Will expire: 2 years"

On the other hand <code>[timelord mode="hide" from="2016-04" to="2017-04"]SOME CONTENT[/timelord]</code> would hide the content on the given timeframe and show it at the rest of the time. 


== Screenshots ==

1. An example of how Time Lord is used.

== Changelog ==

= 1.2 =
* NEW FEATURE: Show content based on the day of the week.

= 1.1 =
* NEW FEATURE: Show content recursively at user set intervals.
* FIX: The plugin now takes into account the timezone set at the WordPress installation.

= 1.0 =
* First release!

== Upgrade Notice ==

= 1.1 =
* NEW FEATURE: Show content recursively at user set intervals.

= 1.0 =
* Initial submittion to the WordPress.org repository