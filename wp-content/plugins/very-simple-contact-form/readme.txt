=== Very Simple Contact Form ===
Contributors: Guido07111975
Version: 1.8
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Requires at Least: 3.7
Tested up to: 3.9.1
Stable tag: trunk
Tags: simple, responsive, contact, contactform, email


== Changelog ==
Version 1.8
- adjusted function vscf_clean_input. Only allowed: letters (a-z), digits (0-10), space, point, hyphen and comma
- added Brazilian Portuguese translation (thanks Gustavo Lucas)

Version 1.7
- changed shortcode 'email' into 'email_to' (to avoid possible conflict with the email input field)
- added name and email in text of message to admin

Version 1.6
- updated several translation files
- added Spanish translation (thanks Alvaro Reig Gonzalez)

Version 1.5
- several small frontend adjustments
 
Version 1.4
- several small adjustments

Version 1.3
- removed code that wasn't necessary
- added Hungarian translation (thanks Roman Kekesi)

Version 1.2
- IMPORTANT SECURITY UPDATE > please do not use older version of plugin
- removed jquery validation (and folder .js)
- several other small adjustments

Version 1.1
- removed font-family from stylesheet
- added French and German translation (thanks Curlybracket)

Version 1.0
- first stable release


== DESCRIPTION ==
This is a very simple responsive translation-ready contact form. It only contains Name, Email, Subject and Message. Use shortcode [contact] to display form on page. Dutch, German, Spanish, Brazilian Portuguese, French and Hungarian translation included. For more info please check readme file.


== INSTALLATION == 
After installation please add shortcode [contact] on your contactpage for displaying the form. In this case messages will be send to email from admin (Settings > General).
If you want to use another email, use shortcode [contact email_to="your-email-here"].
And if you want to use multiple email, use shortcode [contact email_to="first-email-here, second-email-here"].


== Screenshots == 
1. Very Simple Contact Form in frontend of your website (using Twenty Fourteen theme).


== OTHER NOTES ==
This plugin is translation-ready (Dutch, German, Spanish, Brazilian Portuguese, French and Hungarian translation included). More translations are very welcome! Please send them to: info@guidovanderleest.nl
You can translate this into your own language using for example plugin Codestyling Localization: http://wordpress.org/plugins/codestyling-localization/


== CREDITS ==
Without the WordPress codex and help from the WordPress community I was not able to develop this plugin, so: thank you!

I used this script for developing the Very Simple Contact Form:
http://code.tutsplus.com/articles/creating-a-simple-contact-form-for-simple-needs--wp-27893
This script is released under the GNU General Public License v3 or later


Enjoy,
Guido