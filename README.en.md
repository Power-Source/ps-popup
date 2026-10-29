# PS Popup

[Deutsch](README.md) | **English**

[![Version](https://img.shields.io/badge/Version-1.0.3-2271b1?style=flat-square)](readme.txt)
![PHP](https://img.shields.io/badge/PHP-8.0%2B-777bb4?style=flat-square&logo=php&logoColor=white)
![WordPress](https://img.shields.io/badge/WordPress-up%20to%207.1.4-21759b?style=flat-square&logo=wordpress&logoColor=white)
![ClassicPress](https://img.shields.io/badge/ClassicPress-2.7.4-03768e?style=flat-square)
[![License](https://img.shields.io/badge/License-GPL--2.0--or--later-2ea44f?style=flat-square)](https://www.gnu.org/licenses/gpl-2.0.html)

**Targeted popups for WordPress and ClassicPress, with visual configuration, flexible display conditions, and customizable designs.**

PS Popup shows visitors the right content at the right time: newsletter signups, offers, announcements, or embedded forms. Configure content, appearance, triggers, and target audiences directly in the administration area.

## Features

### Content and Appearance

- Create popups with a heading, subheading, and main content.
- Add images and an optional call-to-action button with a link.
- Use shortcodes, for example to embed forms.
- Choose from different templates and customize colors.
- Configure responsive layouts or fixed dimensions.
- Select opening and closing animations.
- Add custom CSS rules using the integrated editor.
- Preview popups before saving.

### Triggers and Behavior

- Display after a configurable delay.
- Open after scrolling a certain distance or reaching a selected element.
- Trigger by clicking an element matching a CSS selector.
- Display when the mouse leaves the browser window.
- Configure whether clicking the background closes the popup.
- Offer an option to hide the popup with a configurable expiration period.
- Close, refresh, or redirect to a destination URL after form submission.

### Audiences and Display Conditions

Combine multiple conditions. For example, display a popup only to logged-out visitors viewing a specific category.

| Area | Examples |
| --- | --- |
| Visitors | Login status, user role, previous comments |
| Content | URLs and URL patterns, post types, categories, custom taxonomies |
| Traffic source | Referrer, search engine, internal or external links |
| Device | Mobile device, window width |
| Timing and frequency | Date, time, number of previous displays |
| Location | Include or exclude specific countries |
| Additional plugins | BuddyPress XProfile, PS Mitgliedschaften, PS Bloghosting |

Integrations require the respective plugins or components to be available.

## Installation

1. Download the repository as a ZIP file or clone it.
2. Copy the plugin folder to `wp-content/plugins/` using the name `ps-popup`. The `popover.php` file must be directly inside that folder.
3. In the administration area, activate **PS Popup** under **Plugins**.
4. Create your first popup using the **PS PopUp** menu.

When installing a ZIP file through **Plugins → Add New → Upload Plugin**, make sure the archive contains a single plugin folder.

> Minimum versions listed in plugin metadata are not a recommendation to run outdated software. Use actively maintained PHP and CMS versions, and check your combination of theme, plugins, and popups on a staging installation first.

## Set Up Your First Popup

1. Open **New PopUp** and enter an internal name.
2. Add a heading, content, an image, and a button if needed.
3. Under **Appearance**, select a template and customize its design.
4. Under **Behavior**, configure the trigger and closing rules.
5. Optionally add **Display Conditions**. Without restrictive conditions, the audience will not be limited in that way.
6. Check the preview, save, and set the status to **Active**.
7. Test the result on your website under the intended visitor conditions.

Prefix custom CSS rules with the popup container:

```css
#popup .wdpu-text {
    font-family: sans-serif;
}
```

## Loading Methods and Shortcodes

Choose how content is loaded in the popup settings:

| Method | Usage |
| --- | --- |
| Page Footer | Adds the popup directly to the page HTML without an additional AJAX request. |
| WordPress AJAX | Loads content separately through WordPress. Check this option especially when using page caching. |
| Custom AJAX | Loads content using a custom front-end AJAX request. |
| Anonymous Script | An AJAX-based option with a masked script URL; it may make detection by ad blockers more difficult but does not guarantee display. |

Not every shortcode works with every loading method. The settings include an overview of detected shortcodes and their compatibility. For forms, test submission, validation, and dynamically loaded scripts in particular; switch to **Page Footer** if necessary.

Your theme must call `wp_head()` and `wp_footer()` correctly. The popup settings include a corresponding compatibility check.

## Multisite

By default, popups are managed separately for each site. To enable global operation, set the following constant in `wp-config.php` before WordPress is loaded:

```php
define( 'PO_GLOBAL', true );
```

Global popups are managed through the network's main site. Available shortcodes may differ between sites because they depend on each site's plugins and themes.

## Languages and Translations

The text domain is **`popover`**. Translation files are located in [lang/](./lang/):

| File | Purpose |
| --- | --- |
| [popover.pot](./lang/popover.pot) | Translation template with source strings and locations |
| [popover-en_US.po](./lang/popover-en_US.po) | Editable English catalog containing 642 entries |
| [popover-en_US.mo](./lang/popover-en_US.mo) | Compiled translation file for WordPress |

To use English, select **English (United States)** under **Settings → General → Site Language**. The administration language can also be set in your user profile.

Your own popup content is not translated automatically. The translation files cover the plugin interface and its translatable default text.

### Update Translations

With the [WP-CLI i18n package](https://github.com/wp-cli/i18n-command) installed, run these commands from the plugin directory:

```bash
wp i18n make-pot . lang/popover.pot \
  --domain=popover \
  --exclude=inc/external \
  --skip-js \
  --package-name="PS Popup"

wp i18n update-po lang/popover.pot lang/popover-en_US.po
wp i18n make-mo lang/
```

After updating the PO file, translate new or changed entries and review translations marked as fuzzy. Then regenerate the MO file. Preserve placeholders such as `%s` and `%1$s`, HTML markup, and translation contexts.

## Advanced Configuration

Set these optional constants in `wp-config.php`. Their defaults are defined in [inc/config-defaults.php](./inc/config-defaults.php).

| Constant | Default | Meaning |
| --- | --- | --- |
| `PO_GLOBAL` | `false` | Global rather than per-site management in Multisite |
| `PO_DEFAULT_EXPIRY` | `365` | Default lifetime of the popup dismissal cookie, in days |
| `PO_REMOTE_IP_URL` | `''` | Optional custom country lookup web service; `%ip%` is the IP address placeholder |
| `PO_DEFAULT_COUNTRY` | `'US'` | Fallback country code when lookup fails; `false` disables this fallback |

A custom country lookup web service must return only the country code for the supplied IP address.

## Privacy and Operation

- The dismissal feature uses cookies to remember a visitor's choice. Account for this in your website's privacy information and consent configuration where applicable.
- Country lookup through an external web service may transmit IP addresses to that service. Review the selected provider and applicable legal requirements; a local database option is also available.
- Embedded forms and external content may connect to additional services. Their privacy behavior depends on the respective provider or plugin.
- Caching, optimization plugins, and ad blockers can affect display. Also test your popup while logged out and in a private browsing window.

## Development

### Repository Structure

```text
popover.php    Plugin entry point and translation registration
inc/           Administration, frontend, data storage, rules, and integrations
views/         Administration views
css/tpl/       Popup templates and their styles
js/            Frontend/admin scripts, Ace editor, and CSS worker
lang/          Translation template and language files
tests/         Focused regression tests
readme.txt     WordPress plugin description and changelog
```

### Tests

The JavaScript regression tests use Node.js and require no additional npm packages:

```bash
node tests/ace-tokenizer.test.js
node tests/css-worker.test.js
node tests/select2-escaping.test.js
```

The translation test uses the POMO classes from a local WordPress installation. The plugin must be located at `wp-content/plugins/ps-popup`; this test does not require a database connection:

```bash
php tests/translations.test.php
```

The tests cover problematic regex inputs, CSS worker module resolution and message handling, Select2 escaping, and the completeness, contexts, and placeholders of the English translation. They do not replace comprehensive browser/integration testing or a CodeQL analysis.

### JavaScript Builds

Whenever a JavaScript source file changes, update its corresponding `.min.js` file as well. Both variants must behave identically. The focused regression tests check the affected variants together.

## Reporting Issues and Contributing

Bug reports and suggestions are welcome through [GitHub Issues](https://github.com/Power-Source/ps-popup/issues). To help reproduce a problem, please include:

- WordPress/ClassicPress, PHP, and plugin versions
- Your theme and relevant additional plugins
- The selected loading method, triggers, and display conditions
- Exact reproduction steps and expected behavior
- Relevant error messages, without credentials or visitors' personal data

## Changes

Version **1.0.3** fixes PHP 8.4 deprecations in current-URL detection and explicit URL protocol normalization.

Version **1.0.2** adds the English translation and documentation in German and English. It fixes regex backtracking in the Ace editor and the Select2 regression test, hardens CSS worker handling, and completes Select2 escaping. Translation headers have been corrected and focused regression tests added. See [readme.txt](./readme.txt) for the changelog.

## License

PS Popup is licensed under the **GNU General Public License, version 2 or later**. See [license.txt](./license.txt) for the license text. Bundled libraries also carry their respective license notices in their files.
