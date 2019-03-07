# Colour Swatches Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

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
