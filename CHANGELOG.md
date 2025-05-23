# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [v2.0.0] - 2025-03-25

### Changed

- Plugin builds on PHP 8.2 and deploys on PHP 8.3.
    - PHP 7.4 is deprecated and will no longer be tested against.

## [1.1.3] - 2024-07-18
### Added
- PR template

## [1.1.2] - 2022-12-2
### Amended
- Add headings from within block groups to in-page navigation

## [1.1.1] - 2022-09-08
### Amended
- Changed regex generating in-page anchors to use a non-greedy regex to eliminate issues with pasted in styling

## [1.1.0] - 2022-08-15
### Added
- `\LongReadPlugin\ParentTitle::get()` to return title of top-level long-read item

## [1.0.3] - 2022-05-27
### Amended
- Ensure heading anchors are generated in WordPress v6.0

## [1.0.2] - 2022-05-26
### Amended
- Ensure block editor is enforced, even if an individual user has chosen "classic" as their preferred editor in the classic editor plugin

## [1.0.1] - 2022-05-19
### Amended
- Allow for possible null in call to `use_block_editor_for_post_type` filter

## [1.0.0] - 2022-05-19
- Initial release
