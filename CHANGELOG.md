# Changelog

All notable changes to the **IceCream Fried Esports Portal** are documented in this file.

## [v1.7.0] - 2026-11-16

### Added
- **Super Admin Player Impersonation**: Integrated `filament-impersonate` restricted to `super_admin` accounts, taking administrators directly into the `App` player panel.
- **Official Publisher Game Logos**: Replaced plain game text badges and labels across the homepage, team dossiers, player profiles, and dashboard widgets with official **MLBB**, **PUBG Mobile**, and **Free Fire** publisher logos.
- **Filament SPA & Animated Sidebar**: Enabled `->spa(hasPrefetching: true)` across `Mukhiyas` and `App` panels with smooth page entrance transitions, a GSAP sliding active highlighter, and cursor-following hover spotlight on sidebar items.
- **Topbar Homepage Button**: Added a direct **Homepage** shortcut button to the Filament top bar across both panels.

### Changed
- **Public Homepage & Profiles Redesign**: Rebalanced responsive layouts across player and team profiles, highlighted athlete cards in the **Meet The Squad** carousel, added a 4-card KPI strip with collapsible/scrollable tournament accordions, and balanced the **Active Squads** grid.
- **Admin Card & Navigation Polish**: Pinned status ticks and bulk-action checkboxes cleanly to card corners with proper spacing, fixed sidebar item/group padding, and removed redundant topbar quick-links.

### Fixed
- **Role-Based Auth & Panel Redirects**: Enforced `User::canAccessPanel()` and intended URL validation on password and Google OAuth logins, and redirected authenticated users away from unauthorized panels to their accessible panel instead of throwing `403`.
- **Map Pins & Hover Clipping**: Corrected Google Maps embeds for Vidanta Champions Arena (Lalitpur) and Kathmandu HQ, fixed hover clipping on tournament and squad cards, and unregistered stale service workers.

## [v1.6.0] - 2026-11-15

### Added
- **Three.js 3D WebGL Visuals**: Interactive 3D Esports Crest hero canvases (`MukhiyasHero3DWidget`, `PlayerHero3DWidget`) responding to pointer tilt, plus a subtle ambient 3D particle/wireframe backdrop (`#icf-ambient-webgl`).
- **GSAP Motion Choreography**: Hardware-accelerated widget entrance staggers, animated numeric stat counters, and subtle 3D hover tilt with full `prefers-reduced-motion` support via `gsap.matchMedia()`.
- **Real-DB Dashboard Widgets**:
  - **Mukhiyas Panel**: `MukhiyasHero3DWidget`, `GameDivisionBreakdownWidget` (live MLBB / PUBGM / Free Fire counts), `UpcomingMatchesWidget`, and `SuperAdminAccessOverviewWidget` (Super Admin only).
  - **App Panel**: `PlayerHero3DWidget`, `PlayerGameAccountsWidget` (logged-in player's `GameInfo` accounts and multi-roles), and `PlayerUpcomingMatchesWidget` (scoped to the player's active teams).
- **Strict Widget Permission Gating**: Added `canView()` authorization checks and logged-in user scoping across all Mukhiyas and App dashboard widgets.

## [v1.5.0] - 2026-11-15

### Added
- Multi-select tactical roles (`roles`) across **PUBG Mobile**, **Free Fire**, and **MLBB** with expanded international tournament roles (`IGL`, `Fragger`, `Assaulter`, `Scout`, `Primary/Secondary Rusher`, `Bomber/Nader`, `Flanker`, `Flex/Utility`).
- Priority ranking on every game role plus manual `sort_order` & drag-to-reorder in Team Members (`MembersRelationManager`), powering automatic + manual roster ordering on public team views.

### Fixed
- Strengthened frosted glass opacity and `26px` backdrop blur on overlapping UI layers (topbar, sidebar, dropdowns, modals) so scrolled content beneath never bleeds through.
- Stacked mobile record card headers vertically so game/role badges never wrap mid-letter on small screens.

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
