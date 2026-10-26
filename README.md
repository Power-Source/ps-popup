# PS Popup

**Deutsch** | [English](README.en.md)

[![Version](https://img.shields.io/badge/Version-1.0.2-2271b1?style=flat-square)](readme.txt)
![PHP](https://img.shields.io/badge/PHP-8.0%2B-777bb4?style=flat-square&logo=php&logoColor=white)
![WordPress](https://img.shields.io/badge/WordPress-bis%207.1.0-21759b?style=flat-square&logo=wordpress&logoColor=white)
![ClassicPress](https://img.shields.io/badge/ClassicPress-2.7.4-03768e?style=flat-square)
[![Lizenz](https://img.shields.io/badge/Lizenz-GPL--2.0--or--later-2ea44f?style=flat-square)](https://www.gnu.org/licenses/gpl-2.0.html)


**Gezielte Popups für WordPress und ClassicPress – mit visueller Einrichtung, flexiblen Anzeigebedingungen und anpassbarem Design.**

PS Popup zeigt Besuchern passende Inhalte zum richtigen Zeitpunkt: Newsletter-Anmeldungen, Angebote, Hinweise oder eingebettete Formulare. Inhalt, Gestaltung, Auslöser und Zielgruppen werden direkt im Administrationsbereich konfiguriert.

## Funktionen

### Inhalte und Gestaltung

- Popups mit Überschrift, Unterüberschrift und Hauptinhalt erstellen.
- Bilder und eine optionale Call-to-Action-Schaltfläche mit Link einfügen.
- Shortcodes verwenden, beispielsweise für Formulare.
- Zwischen verschiedenen Vorlagen wählen und Farben anpassen.
- Responsive Darstellung oder feste Abmessungen konfigurieren.
- Ein- und Ausblendanimationen auswählen.
- Eigene CSS-Regeln im integrierten Editor ergänzen.
- Popups vor dem Speichern in der Vorschau prüfen.

### Auslöser und Verhalten

- Nach einer einstellbaren Wartezeit anzeigen.
- Nach dem Scrollen einer bestimmten Strecke oder bis zu einem gewählten Element öffnen.
- Durch Klick auf ein Element mit einem CSS-Selektor auslösen.
- Beim Verlassen des Browserfensters mit der Maus anzeigen.
- Schließen über den Hintergrund konfigurieren.
- Eine Option zum dauerhaften Ausblenden mit einstellbarer Ablaufzeit anbieten.
- Nach Formularübermittlung schließen, aktualisieren oder auf eine Ziel-URL umleiten.

### Zielgruppen und Anzeigebedingungen

Mehrere Bedingungen lassen sich kombinieren. Ein Popup kann beispielsweise nur für nicht angemeldete Besucher einer bestimmten Kategorie erscheinen.

| Bereich | Beispiele |
| --- | --- |
| Besucher | Anmeldestatus, Benutzerrolle, bisherige Kommentare |
| Inhalte | URLs und URL-Muster, Beitragstypen, Kategorien, benutzerdefinierte Taxonomien |
| Herkunft | Referrer, Suchmaschine, interne oder externe Verlinkung |
| Gerät | Mobilgerät, Fensterbreite |
| Zeitpunkt und Häufigkeit | Datum, Uhrzeit, bisherige Anzahl der Anzeigen |
| Standort | Ein- oder Ausschluss bestimmter Länder |
| Zusätzliche Plugins | BuddyPress-XProfile, PS Mitgliedschaften, PS Bloghosting |

Integrationen setzen die jeweils genannten Plugins beziehungsweise Komponenten voraus.

## Installation

1. Das Repository als ZIP herunterladen oder klonen.
2. Den Plugin-Ordner als `ps-popup` nach `wp-content/plugins/` kopieren. Die Datei `popover.php` muss direkt darin liegen.
3. Im Administrationsbereich unter **Plugins** das Plugin **PS Popup** aktivieren.
4. Über das Menü **PS PopUp** ein erstes Popup erstellen.

Bei einer ZIP-Installation über **Plugins → Installieren → Plugin hochladen** darauf achten, dass das Archiv einen einzelnen Plugin-Ordner enthält.

> Die Mindestversionen stammen aus den Plugin-Metadaten und sind keine Empfehlung, veraltete Software einzusetzen. Verwende eine aktuell gepflegte PHP- und CMS-Version und prüfe die Kombination aus Theme, Plugins und Popup zunächst auf einer Testinstallation.

## Das erste Popup einrichten

1. **Neues PopUp** öffnen und einen internen Namen vergeben.
2. Überschrift, Inhalt, Bild und gegebenenfalls eine Schaltfläche ergänzen.
3. Unter **Aussehen** eine Vorlage auswählen und die Darstellung anpassen.
4. Unter **Verhalten** den Auslöser und die Regeln zum Schließen festlegen.
5. Optional **Anzeigebedingungen** hinzufügen. Ohne einschränkende Bedingungen wird die Zielgruppe nicht entsprechend begrenzt.
6. Die Vorschau prüfen, speichern und den Status auf **Aktiv** setzen.
7. Das Ergebnis auf der Website mit den gewünschten Besucherbedingungen testen.

Für eigene CSS-Regeln den Popup-Container als Präfix verwenden:

```css
#popup .wdpu-text {
    font-family: sans-serif;
}
```

## Lademethoden und Shortcodes

Unter den Popup-Einstellungen lässt sich festlegen, wie die Inhalte geladen werden:

| Methode | Verwendung |
| --- | --- |
| Seiten Footer | Fügt das Popup direkt in den HTML-Code der Seite ein, ohne zusätzlichen AJAX-Aufruf. |
| WordPress AJAX | Lädt den Inhalt separat über WordPress. Besonders bei Seiten-Caching zu prüfen. |
| Benutzerdefiniertes AJAX | Lädt den Inhalt über einen eigenen Frontend-AJAX-Aufruf. |
| Anonymes Skript | AJAX-basierte Variante mit maskierter Skript-URL; kann die Erkennung durch Werbeblocker erschweren, garantiert aber keine Anzeige. |

Nicht jeder Shortcode funktioniert mit jeder Lademethode. Die Einstellungen enthalten eine Übersicht der erkannten Shortcodes und ihrer Kompatibilität. Bei Formularen insbesondere Übermittlung, Validierung und nachgeladene Skripte testen; gegebenenfalls auf **Seiten Footer** wechseln.

Das Theme muss `wp_head()` und `wp_footer()` korrekt aufrufen. Eine entsprechende Kompatibilitätsprüfung ist in den Popup-Einstellungen enthalten.

## Multisite

Standardmäßig werden Popups pro Website verwaltet. Für den globalen Betrieb lässt sich in `wp-config.php`, vor dem Laden von WordPress, folgende Konstante setzen:

```php
define( 'PO_GLOBAL', true );
```

Globale Popups werden über die Hauptwebsite des Netzwerks verwaltet. Shortcodes können sich je nach Website unterscheiden, da sie von den dort verfügbaren Plugins und Themes abhängen.

## Sprachen und Übersetzungen

Die Textdomain lautet **`popover`**. Sprachdateien liegen im Verzeichnis [lang/](./lang/):

| Datei | Zweck |
| --- | --- |
| [popover.pot](./lang/popover.pot) | Übersetzungsvorlage mit Quelltexten und Fundstellen |
| [popover-en_US.po](./lang/popover-en_US.po) | Bearbeitbarer englischer Katalog mit 642 Einträgen |
| [popover-en_US.mo](./lang/popover-en_US.mo) | Kompilierte Sprachdatei für WordPress |

Für Englisch unter **Einstellungen → Allgemein → Website-Sprache** die Option **English (United States)** wählen. Die Sprache der Verwaltungsoberfläche kann zusätzlich im Benutzerprofil eingestellt werden.

Eigene Popup-Inhalte werden nicht automatisch übersetzt. Die Sprachdateien übersetzen die Plugin-Oberfläche und die dafür vorgesehenen Standardtexte.

### Übersetzungen aktualisieren

Mit installiertem [WP-CLI-i18n-Paket](https://github.com/wp-cli/i18n-command) aus dem Plugin-Verzeichnis:

```bash
wp i18n make-pot . lang/popover.pot \
  --domain=popover \
  --exclude=inc/external \
  --skip-js \
  --package-name="PS Popup"

wp i18n update-po lang/popover.pot lang/popover-en_US.po
wp i18n make-mo lang/
```

Nach dem Aktualisieren der PO-Datei neue oder geänderte Einträge übersetzen und als unscharf markierte Übersetzungen prüfen. Anschließend die MO-Datei neu erzeugen. Platzhalter wie `%s` und `%1$s`, HTML-Auszeichnungen und Übersetzungskontexte müssen erhalten bleiben.

## Erweiterte Konfiguration

Diese optionalen Konstanten werden in `wp-config.php` gesetzt. Die Vorgaben stehen in [inc/config-defaults.php](./inc/config-defaults.php).

| Konstante | Standard | Bedeutung |
| --- | --- | --- |
| `PO_GLOBAL` | `false` | Globale statt websitebezogener Verwaltung in Multisite |
| `PO_DEFAULT_EXPIRY` | `365` | Standard-Ablaufzeit des Ausblend-Cookies in Tagen |
| `PO_REMOTE_IP_URL` | `''` | Optionaler eigener Webservice zur Länderermittlung; `%ip%` dient als IP-Platzhalter |
| `PO_DEFAULT_COUNTRY` | `'US'` | Ersatz-Ländercode bei fehlgeschlagener Ermittlung; `false` deaktiviert diesen Fallback |

Ein eigener Länder-Webservice muss ausschließlich den Ländercode für die übergebene IP-Adresse zurückgeben.

## Datenschutz und Betrieb

- Die Ausblendfunktion verwendet Cookies, um die Entscheidung eines Besuchers zu speichern. Berücksichtige dies in der Datenschutz- und gegebenenfalls Einwilligungskonfiguration deiner Website.
- Eine Länderermittlung über einen externen Webservice kann IP-Adressen an diesen Dienst übertragen. Prüfe den gewählten Dienst und die rechtlichen Anforderungen; alternativ steht eine lokale Datenbankoption zur Verfügung.
- Eingebettete Formulare und externe Inhalte können zusätzliche Dienste einbinden. Deren Datenschutzverhalten hängt vom jeweiligen Anbieter beziehungsweise Plugin ab.
- Caching, Optimierungsplugins und Werbeblocker können die Darstellung beeinflussen. Teste das Popup auch ausgeloggt und in einem privaten Browserfenster.

## Entwicklung

### Repository-Aufbau

```text
popover.php     Plugin-Einstieg und Übersetzungsregistrierung
inc/           Administration, Frontend, Datenhaltung, Regeln und Integrationen
views/         Administrationsansichten
css/tpl/       Popup-Vorlagen und zugehörige Styles
js/            Frontend-/Admin-Skripte, Ace-Editor und CSS-Worker
lang/          Übersetzungsvorlage und Sprachdateien
tests/         Gezielte Regressionstests
readme.txt     WordPress-Pluginbeschreibung und Änderungsprotokoll
```

### Tests

Die JavaScript-Regressionstests verwenden Node.js und benötigen keine zusätzlichen npm-Pakete:

```bash
node tests/ace-tokenizer.test.js
node tests/css-worker.test.js
node tests/select2-escaping.test.js
```

Der Übersetzungstest verwendet die POMO-Klassen einer lokalen WordPress-Installation. Das Plugin muss dafür unter `wp-content/plugins/ps-popup` liegen; eine Datenbankverbindung wird für diesen Test nicht benötigt:

```bash
php tests/translations.test.php
```

Die Tests prüfen unter anderem problematische Regex-Eingaben, die CSS-Worker-Modulauflösung und Nachrichtenverarbeitung, Select2-Escaping sowie Vollständigkeit, Kontexte und Platzhalter der englischen Übersetzung. Sie ersetzen weder einen vollständigen Browser-/Integrationstest noch eine CodeQL-Analyse.

### JavaScript-Builds

Zu geänderten JavaScript-Quelldateien gehört jeweils die entsprechende `.min.js`-Datei. Beide Varianten müssen funktional übereinstimmen. Die gezielten Regressionstests prüfen die betroffenen Varianten gemeinsam.

## Fehler melden und mitarbeiten

Fehlerberichte und Änderungsvorschläge sind über die [GitHub Issues](https://github.com/Power-Source/ps-popup/issues) willkommen. Für nachvollziehbare Fehlerberichte bitte angeben:

- WordPress-/ClassicPress-, PHP- und Plugin-Version
- verwendetes Theme und relevante zusätzliche Plugins
- gewählte Lademethode, Auslöser und Anzeigebedingungen
- genaue Schritte zur Reproduktion und erwartetes Verhalten
- relevante Fehlermeldungen ohne Zugangsdaten oder personenbezogene Besucherdaten

## Änderungen

Version **1.0.2** ergänzt die englische Übersetzung und die deutsch-/englischsprachige Dokumentation. Sie korrigiert das Regex-Backtracking im Ace-Editor und im Select2-Regressionstest, sichert die CSS-Worker-Verarbeitung ab und vervollständigt das Select2-Escaping. Die Übersetzungsheader wurden korrigiert und gezielte Regressionstests ergänzt. Das Änderungsprotokoll steht in [readme.txt](./readme.txt).

## Lizenz

PS Popup steht unter der **GNU General Public License, Version 2 oder neuer**. Den Lizenztext findest du in [license.txt](./license.txt). Für eingebundene Bibliotheken gelten zusätzlich die jeweiligen Lizenzhinweise in deren Dateien.
