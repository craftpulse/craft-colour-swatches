# Colour Swatches Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).


## 5.3.0 - 2026-04-20

> **Critical:** This release includes security fixes from 5.2.1, GraphQL breaking changes, and fixes for long-standing data loss issues. All users should update immediately.

### Security
- Fixed XSS vulnerability in colour option templates where user-controlled colour values were output with `|parseRefs|raw` in style attributes
- Fixed potential JS injection via unescaped field handle in `registerJs()` call
- Fixed unescaped colour values in element index preview HTML

### Added
- **GraphQL Mode setting** — new "GraphQL Mode" select in field settings (when GQL is enabled) to toggle between "Full data" (returns `ColourSwatches_SwatchData` object with label, handle, color, class) and "Label only" (returns plain string). Defaults to full data for all fields.
- `handle` field exposed in the GraphQL `ColourSwatches_SwatchData` type

### Fixed
- Fixed `serializeValue()` mutating field state (`$this->options`, `$this->default`) as a side effect, causing inconsistent behaviour on multi-site saves
- Fixed handle generation inconsistency between PHP (`toCamelCase`) and Twig template (`|kebab` changed to `|camel`), which caused handles to be `null` after resave (#141)
- Fixed double-JSON-encoding of colour values in GraphQL resolver that produced `"\"#ef4444\""` instead of `"#ef4444"`
- Fixed duplicate `$paletteOptions` block in field settings (dead code)
- Fixed loose `== 1` comparisons for default detection replaced with `!empty()`
- Fixed double-compound DOM ID on hidden input (`id ~ namespacedId` changed to `id`)
- Fixed translation file named `color-swatches.php` not matching plugin handle `colour-swatches` (translations were silently ignored)
- Fixed dead `if ($this)` guard in `collection()` method
- Fixed `validateJson()` decoding JSON twice redundantly

### Changed
- **Breaking (GraphQL):** GraphQL type name changed from per-field-handle names to a single shared `ColourSwatches_SwatchData` type. Queries using inline fragments on the old type names will need updating.
- **Breaking (GraphQL):** Colour values in GraphQL responses are no longer double-encoded. If your client-side code was double-parsing JSON, remove the extra parse step.
- Moved `Collection::macro('recursive')` registration from model constructor to plugin `init()` where global state registration belongs
- Extracted `_resolveOptions()` method to centralize config file palette resolution (was duplicated in `normalizeValue` and `serializeValue`)
- Removed unnecessary `beforeSave()` override that was a fragile no-op
- Updated PHP requirement from `^8.0.2` to `^8.2` to match Craft 5
- Updated all file headers from Craft CMS 3.x/4.x to 5.x with current CraftPulse branding
- Updated support and documentation URLs from `percipio.london`/`v4` to `craftpulse.com`/`v5`
- Added `aria-label` to colour swatch buttons for screen reader accessibility
- Annotated broken migration `m220503` with `@deprecated` pointing to its fix migration

## 5.1.0 - 2024-10-28
### Added
- Added a `collection` function to the field that will return a recursive laravel collection for easier use in twig templates and to do manipulations.

## 5.0.3 - 2024-09-23
### Fixed
- Undefined Array Key 0 Error in Craft 5.36 Colour Swatches 5.0.2 #133
- Error occurs when entering colors directly in the CMS field #127

## 5.0.2 - 2024-03-08
### Fixed
- Fixed the default fetch if the default isn't the first one in the config list

## 5.0.1 - 2024-04-15
### Fixed
- Fixed the bug when default color isn't the first in array #124

## 5.0.0 - 2024-03-02
### Added
- Provided support for Craft 5 (tanks to [@marknotton-yello](https://github.com/marknotton-yello))

## 4.5.0 - 2024-03-02
### Changed
- Changed code according to PHPStan advise (prep for Craft 5)

## 4.4.0 - 2024-03-02
### Fixed
- [Docs] Incorrect plugin name used in installation step #115
- Default swatch value returns as null #109
- Class Not found exception: percipioglobal\colourswatches\fields\ColourSwatches while creating new field. #112
- Syntax error when switching from Dropdown field type #111

## 4.3.0 - 2023-03-09
### Added
- Randomly pick a set of colors from the color-swatches.php setup #84

## 4.2.1 - 2022-07-08

### Fixed
- Fixed Element list in control panel - color preview is not displaying corretly if selected option has more than one color [#101](https://github.com/percipioglobal/craft-colour-swatches/issues/101)

## 4.2.0.1 - 2022-07-08

### Fixed
- Fixed an issue where GQL would throw an error if it's a single color

### Added
- Added GraphQL support

### Fixed
- Fixed missing type for `getInputHtml $value`

## 4.2.0 - 2022-07-08

### Added
- Added GraphQL support

### Fixed
- Fixed missing type for `getInputHtml $value`

### Changed
- Provided a first level class property to set custom css classes

## 4.1.0 - 2022-06-02

### Changed
- Provided a first level class property to set custom css classes

## 4.0.5 - 2022-05-23

### Fixed
- Fixed the migration to update the namespace

## 4.0.4 - 2022-05-12

### Fixed
- Fixed an issue where Plugin wasn't renamed to ColorSwatches in ColourSwatches field

## 4.0.3 - 2022-05-11

### Fixed
- Fixed an issue where the table attributes could throw a server error when the color was an array

## 4.0.2 - 2022-05-11

### Fixed
- Fixed an issue where the field would save even if it was required
- Fixed a few missing types

## 4.0.1 - 2022-05-06

### Fixed
- Fixed an issue where `$value` was not allowed to be `null`

## 4.0.0 - 2022-05-03

### Changed
- Official Craft 4 release

## 4.0.0-RC2 - 2022-05-03

### Added
- Provided a migration to update the namespace from percipioglobal to percipiolondon

## 4.0.0-RC1 - 2022-05-02

### Changed
- Create release candidate of 4.0.0-beta.2

## 4.0.0-beta.2 - 2022-05-02

### Added
- Updated PHPDocs

### Fixed
- Fixed the editableTable config

## 4.0.0-beta.1 - 2022-04-20

### Added
- Craft CMS 4 compatibility
- PHPStan Level 5
- Updated PHPDocs
- Updated Types

### Removed
- Removed unused element class
