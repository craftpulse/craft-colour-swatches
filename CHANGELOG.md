# Colour Swatches Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## 1.5.0.3 - 2021-12-13

### Changed
- Downgraded Craft requirement to 3.3.0

## 1.5.0.2 - 2021-12-13

### Fixed
- Fixed an issue where saving entries could still throw an internal server 500 error if it occured before updating. ( thanks to @ammannbe )

## 1.5.0.1 - 2021-12-10
### Changed
- Plugin Icon
- Plugin Assets

## 1.5.0 - 2021-12-10

### Changed
- Removed the labels for the time being
- Updated the config file

## 1.5.0-RC.1 - 2021-12-09

### Added

- Added labels in the colour swatches for better accessibility (part of [#71](https://github.com/percipioglobal/craft-colour-swatches/issues/71)) 
- Added extra checks if config file doesn't contain the correct indexes [#62](https://github.com/percipioglobal/craft-colour-swatches/issues/62)

### Fixed 

- Fixed an issue where the default values were not respected when used within a supertable field [#59](https://github.com/percipioglobal/craft-colour-swatches/issues/67)
- Fixed an issue where updating the config file wouldn't take effect on a resave [#55](https://github.com/percipioglobal/craft-colour-swatches/issues/55)
- Fixed an issue where the selected color wouldn't always be highlighted in the entry page [#72](https://github.com/percipioglobal/craft-colour-swatches/issues/72)


## 1.4.2.1 - 2021-11-17

### Fixed
- changed stylesheet to override the box shadow that Craft changed See #72(https://github.com/percipioglobal/craft-colour-swatches/issues/72) && #73(https://github.com/percipioglobal/craft-colour-swatches/issues/73)

## 1.4.2 - 2021-08-31

- Vizy Support Added ( thanks to @engram-design )

## 1.4.1.1 - 2020-12-11

- Fixes #59(https://github.com/percipioglobal/craft-colour-swatches/issues/59); another colour/color bug. 

## 1.4.1 - 2020-12-09

### Fixed
- Fixes issue #32(https://github.com/percipioglobal/craft-colour-swatches/issues/32) where required field was not honoured
- Fixed issue #56(https://github.com/percipioglobal/craft-colour-swatches/issues/56) where default color was not set when saving entry

### Changed
- Dropped support for `colour` in twig templates in favour of the W3C css color property keyword - all field color output references now require `color`

### Added
- Added preview support for gradients in entry table columns

## 1.4.0 - 2020-9-11 Bugfix
Migrate namespace from rias to percipioglobal after upgrade. Also converted config php to 'colors' instead of 'colours'. Still supports 'colours' for older versions.
Fixes issues (#36, #50)

## 1.3.3 - 2020-8-19 Bugfix
Fixed bugs introduced in last release by not checking the default configuration settings - Apologies. New features coming in next release!
Fixes issues (#44, #45, #46, #47)

## 1.3.2 - 2020-8-13 Bugfix
ElementInterface updated to allow colour preview for custom arrays. Fixes issue #42
fieldValue conditions for standard colour strings updated to reflect null update in version 1.3.1. Fixes issue #43


## 1.3.1 - 2020-8-03 Bugfix
Updated save function to ensure custom array fields remain selected on resave / edit
Allowed switch between config or palette option in field settings

## 1.3.0.1 - 2020-7-31 HOTFIX
temp fixed broken settings page, expect more robust repair next week :)

## 1.3.0 - 2020-07-27
### Added
- Custom attributes are now available via the colour-swatches.php config file for both single and multiple colours.
- Updated config.php example using updated options and examples
- Fixed issue #34


## 1.2.9 - 2020-07-25
### Added
- An element index preview based on Craft's default colour picker. Thanks @pixelmachine for the great PR!

### Fixed
- Fix spelling for https://github.com/percipioglobal/craft-colour-swatches/issues/37. Thanks @pixelmachine for the great PR!

## 1.2.7 - 2020-01-03
### Fixed
- Fix default value being reset

## 1.2.6 - 2019-12-18
### Fixed
- Actual fix for default

## 1.2.5 - 2019-12-18
### Fixed
- Fixed the default option not being set

## 1.2.4 - 2019-10-27
### Added
- background pattern to show transparent color option

## 1.2.3
### Fix
- PHP fix

## 1.2.2 - 2019-03-07
### Added
- Adds functionality to return comma separated label value as an array. Thanks @chasegiunta

## 1.2.1 - 2019-02-22
### Added
- Added the possibility to define palettes in the config file. Thanks @chasegiunta for the great PR!

## 1.2.0 - 2019-02-01
### Added
- Added the possibility to define the colours in a config file and have the field use them.

## 1.1.4 - 2018-07-30
### Fixed
- Fix a JS error when deselecting the colour
- Default value is now correctly filled
- Removed focus outline from buttons

## 1.1.3 - 2018-06-28
### Changed
- Improve design for colours when selecting light colours.

## 1.1.2 - 2018-05-21
### Added
- Colours are now parse for references so you can add globals.

## 1.1.1 - 2018-05-21
### Changed
- New design for the colours thanks to @skramstad
- Colours can now be unchecked

## 1.1.0 - 2018-04-05
### Added
- Added the possibility to split the colours by using `;`, which allows for `rgba()` colours to be defined.

### Changed
- Now requires Craft CMS 3.0.0

## 1.0.6 - 2018-02-11
### Fixed
- Fix a regression

## 1.0.5 - 2018-02-11
### Fixed
- Fixes an error when saving a draft and having a colour field inside a matrix

## 1.0.4 - 2018-01-24
### Fixed
- Fixed an error when the field was empty and would throw a `__toString` error

## 1.0.3 - 2018-01-19
### Fixed
- Fixed an issue with field access

## 1.0.1 - 2018-01-15
### Fixed
- Fixed a bug where accessing a label that wasn't there would throw an exception

## 1.0.0 - 2018-01-14
### Added
- Initial release
