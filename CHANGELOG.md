# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.2.0] - 2018-08-28
### Added
- Docblocks on all classes and methods
- Unit tests for the main classes (`Contextmapp\Pushwoosh\PushwooshManager` and `Contextmapp\Pushwoosh\PushwooshFactory`)
### Changed
- Code style fixes
### Fixed
- `Contexmtapp\Pushwoosh\Exceptions\InvalidConfigurationException` had an incorrect namespace
- `PushwooshServiceProvider` called non-existent method `connection` on `PushwooshManager`
- `PushwooshManager` called incorrect method `make` on `PushwooshFactory`

## [0.1.0] - 2017-09-21
### Added
- Initial release