# Colour Swatches Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

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