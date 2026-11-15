# Changelog

All notable changes to the **IceCream Fried Esports Portal** are documented in this file.

## [v1.4.0] - 2026-11-15

### Added
- Dynamic Markdown-backed **Changelog** page (`/changelog`) with glassmorphism timeline UI and categorized release badges.
- Live **Version Pill** badge next to the brand logo across Filament panels (`Mukhiyas` & `App`) and login pages.

## [v1.3.0] - 2026-11-15

### Added
- Categorized Mukhiyas sidebar navigation (`Esports`, `People & Access`) and permission-aware topbar quick-links.
- Restored `Manage Profile` access in the Mukhiyas panel for administrators and super admins.

### Fixed
- Eliminated nested double-glass containers on dashboard table and stats widgets.
- Removed solid background from `Manage Profile` tabs and fixed primary/save button text contrast in light and dark modes.

## [v1.2.0] - 2026-11-15

### Added
- Full **Glassmorphism UI** theme (`glass-theme.css`) supporting both light and dark modes.
- Responsive card-grid record layouts and global `7xl` slide-over drawers for Create, Edit, and View actions.
- Categorized 4-tab layout for `Manage Profile` (`Personal & Bio`, `Emergency Contact`, `Socials & Gallery`, `Legal Documents`).
- Strict 3-tier role & permission segregation (`super_admin`, `admin`, `player`) with `TournamentPolicy` and `EsportsMatchPolicy`.

### Changed
- Expanded `AdminForm` and `UserForm` to spacious 2-column layouts.

### Removed
- Removed `slug` column and slug-based routing from Team records; teams now resolve cleanly via `/team/{id}`.

## [v1.1.0] - 2026-11-15

### Added
- Fixed `GameType` enum architecture supporting **Mobile Legends: Bang Bang (MLBB)**, **PUBG Mobile**, and **Free Fire**.
- Dual-engine match scoring & telemetry (MOBA KDA/hero/gold/objectives vs. Battle Royale placement/kills/damage/survival).
- Game-specific player profiling and statistics aggregation on public player profiles.

## [v1.0.0] - 2026-09-10

### Added
- Initial release of the IceCream Fried Esports Portal with Google OAuth, Player & Team public profiles, Tournament & Match tracking, and Filament admin/player panels.
