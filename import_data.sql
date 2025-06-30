-- Data Import Script for Supabase
-- Run these commands in Supabase SQL Editor after uploading CSV files

-- ============================================================================
-- DISABLE ROW LEVEL SECURITY TEMPORARILY FOR IMPORT
-- ============================================================================

-- Disable RLS temporarily to allow bulk import
ALTER TABLE users DISABLE ROW LEVEL SECURITY;
ALTER TABLE seasons DISABLE ROW LEVEL SECURITY;
ALTER TABLE houseguests DISABLE ROW LEVEL SECURITY;
ALTER TABLE stocks DISABLE ROW LEVEL SECURITY;
ALTER TABLE transactions DISABLE ROW LEVEL SECURITY;
ALTER TABLE banks DISABLE ROW LEVEL SECURITY;
ALTER TABLE prices DISABLE ROW LEVEL SECURITY;
ALTER TABLE leaderboards DISABLE ROW LEVEL SECURITY;
ALTER TABLE ratings DISABLE ROW LEVEL SECURITY;
ALTER TABLE projections DISABLE ROW LEVEL SECURITY;
ALTER TABLE weeks DISABLE ROW LEVEL SECURITY;
ALTER TABLE permissions DISABLE ROW LEVEL SECURITY;
ALTER TABLE roles DISABLE ROW LEVEL SECURITY;
ALTER TABLE model_has_permissions DISABLE ROW LEVEL SECURITY;
ALTER TABLE model_has_roles DISABLE ROW LEVEL SECURITY;
ALTER TABLE role_has_permissions DISABLE ROW LEVEL SECURITY;
ALTER TABLE images DISABLE ROW LEVEL SECURITY;
ALTER TABLE files DISABLE ROW LEVEL SECURITY;
ALTER TABLE badges DISABLE ROW LEVEL SECURITY;
ALTER TABLE badge_user DISABLE ROW LEVEL SECURITY;
ALTER TABLE vanity_tags DISABLE ROW LEVEL SECURITY;
ALTER TABLE anomalies DISABLE ROW LEVEL SECURITY;

-- ============================================================================
-- IMPORT CORE DATA (ORDER MATTERS DUE TO FOREIGN KEYS)
-- ============================================================================

-- 1. Import Users (no dependencies)
\COPY users(id, name, email, email_verified_at, password, remember_token, provider_user_id, provider, banned, avatar_approved, avatar_id, use_robot_avatar, last_seen, last_audited, created_at, updated_at) FROM 'users_export.csv' WITH CSV HEADER;

-- 2. Import Seasons (no dependencies)
\COPY seasons(id, name, short_name, status, current_week, closes_at, created_at, updated_at) FROM 'seasons_export.csv' WITH CSV HEADER;

-- 3. Import Images (no dependencies)
\COPY images(id, filename, filesize, mime_type, created_at, updated_at) FROM 'images_export.csv' WITH CSV HEADER;

-- 4. Import Houseguests (depends on seasons)
\COPY houseguests(id, first_name, last_name, nickname, season_id, image, status, slug, created_at, updated_at) FROM 'houseguests_export.csv' WITH CSV HEADER;

-- 5. Import Weeks (depends on seasons)
\COPY weeks(id, week, week_start, week_end, season_id, created_at, updated_at) FROM 'weeks_export.csv' WITH CSV HEADER;

-- 6. Import Banks (depends on users and seasons)
\COPY banks(id, user_id, season_id, money, active, created_at, updated_at) FROM 'banks_export.csv' WITH CSV HEADER;

-- 7. Import Stocks (depends on users and houseguests)
\COPY stocks(id, user_id, houseguest_id, quantity, created_at, updated_at) FROM 'stocks_export.csv' WITH CSV HEADER;

-- 8. Import Transactions (depends on users and houseguests)
\COPY transactions(id, user_id, houseguest_id, action, quantity, current_price, week, created_at, updated_at) FROM 'transactions_export.csv' WITH CSV HEADER;

-- 9. Import Prices (depends on houseguests and seasons)
\COPY prices(id, houseguest_id, season_id, week, price, created_at, updated_at) FROM 'prices_export.csv' WITH CSV HEADER;

-- 10. Import Ratings (depends on users and houseguests)
\COPY ratings(id, user_id, houseguest_id, week, rating, created_at, updated_at) FROM 'ratings_export.csv' WITH CSV HEADER;

-- 11. Import Projections (depends on houseguests)
\COPY projections(id, houseguest_id, to_rate, price, created_at, updated_at) FROM 'projections_export.csv' WITH CSV HEADER;

-- 12. Import Leaderboards (depends on users and seasons)
\COPY leaderboards(id, user_id, season_id, week, networth, stocks, rank, rank_percentage, created_at, updated_at) FROM 'leaderboards_export.csv' WITH CSV HEADER;

-- ============================================================================
-- IMPORT PERMISSION SYSTEM DATA
-- ============================================================================

-- 13. Import Permissions (no dependencies)
\COPY permissions(id, name, guard_name, created_at, updated_at) FROM 'permissions_export.csv' WITH CSV HEADER;

-- 14. Import Roles (no dependencies)
\COPY roles(id, name, guard_name, created_at, updated_at) FROM 'roles_export.csv' WITH CSV HEADER;

-- 15. Import Model Has Permissions (depends on permissions)
\COPY model_has_permissions(permission_id, model_type, model_morph_key) FROM 'model_has_permissions_export.csv' WITH CSV HEADER;

-- 16. Import Model Has Roles (depends on roles)
\COPY model_has_roles(role_id, model_type, model_morph_key) FROM 'model_has_roles_export.csv' WITH CSV HEADER;

-- 17. Import Role Has Permissions (depends on roles and permissions)
\COPY role_has_permissions(permission_id, role_id) FROM 'role_has_permissions_export.csv' WITH CSV HEADER;

-- ============================================================================
-- IMPORT GAMIFICATION DATA
-- ============================================================================

-- 18. Import Badges (depends on seasons and images)
\COPY badges(id, name, rank, type, season_id, image_id, created_at, updated_at) FROM 'badges_export.csv' WITH CSV HEADER;

-- 19. Import Badge User (depends on badges and users)
\COPY badge_user(id, badge_id, user_id, created_at, updated_at) FROM 'badge_user_export.csv' WITH CSV HEADER;

-- ============================================================================
-- IMPORT UTILITY DATA
-- ============================================================================

-- 20. Import Files (depends on seasons and users)
\COPY files(id, filename, type, season_id, week, created_by, updated_by, created_at, updated_at) FROM 'files_export.csv' WITH CSV HEADER;

-- 21. Import Vanity Tags (depends on seasons)
\COPY vanity_tags(id, tag, taggable_type, taggable_id, season_id, week, created_at, updated_at) FROM 'vanity_tags_export.csv' WITH CSV HEADER;

-- 22. Import Anomalies (depends on users and seasons)
\COPY anomalies(id, user_id, season_id, week, message, created_at, updated_at) FROM 'anomalies_export.csv' WITH CSV HEADER;

-- 23. Import Formula Reference (no dependencies)
\COPY formula_reference("from", "to", penalty, bonus, multiplier) FROM 'formula_reference_export.csv' WITH CSV HEADER;

-- ============================================================================
-- UPDATE SEQUENCES TO MATCH IMPORTED DATA
-- ============================================================================

-- Update all sequences to match the highest ID from imported data
SELECT setval('users_id_seq', (SELECT MAX(id) FROM users));
SELECT setval('seasons_id_seq', (SELECT MAX(id) FROM seasons));
SELECT setval('houseguests_id_seq', (SELECT MAX(id) FROM houseguests));
SELECT setval('stocks_id_seq', (SELECT MAX(id) FROM stocks));
SELECT setval('transactions_id_seq', (SELECT MAX(id) FROM transactions));
SELECT setval('banks_id_seq', (SELECT MAX(id) FROM banks));
SELECT setval('prices_id_seq', (SELECT MAX(id) FROM prices));
SELECT setval('leaderboards_id_seq', (SELECT MAX(id) FROM leaderboards));
SELECT setval('ratings_id_seq', (SELECT MAX(id) FROM ratings));
SELECT setval('projections_id_seq', (SELECT MAX(id) FROM projections));
SELECT setval('weeks_id_seq', (SELECT MAX(id) FROM weeks));
SELECT setval('permissions_id_seq', (SELECT MAX(id) FROM permissions));
SELECT setval('roles_id_seq', (SELECT MAX(id) FROM roles));
SELECT setval('images_id_seq', (SELECT MAX(id) FROM images));
SELECT setval('files_id_seq', (SELECT MAX(id) FROM files));
SELECT setval('badges_id_seq', (SELECT MAX(id) FROM badges));
SELECT setval('badge_user_id_seq', (SELECT MAX(id) FROM badge_user));
SELECT setval('vanity_tags_id_seq', (SELECT MAX(id) FROM vanity_tags));
SELECT setval('anomalies_id_seq', (SELECT MAX(id) FROM anomalies));

-- ============================================================================
-- RE-ENABLE ROW LEVEL SECURITY
-- ============================================================================

-- Re-enable RLS on all tables
ALTER TABLE users ENABLE ROW LEVEL SECURITY;
ALTER TABLE seasons ENABLE ROW LEVEL SECURITY;
ALTER TABLE houseguests ENABLE ROW LEVEL SECURITY;
ALTER TABLE stocks ENABLE ROW LEVEL SECURITY;
ALTER TABLE transactions ENABLE ROW LEVEL SECURITY;
ALTER TABLE banks ENABLE ROW LEVEL SECURITY;
ALTER TABLE prices ENABLE ROW LEVEL SECURITY;
ALTER TABLE leaderboards ENABLE ROW LEVEL SECURITY;
ALTER TABLE ratings ENABLE ROW LEVEL SECURITY;
ALTER TABLE projections ENABLE ROW LEVEL SECURITY;
ALTER TABLE weeks ENABLE ROW LEVEL SECURITY;
ALTER TABLE permissions ENABLE ROW LEVEL SECURITY;
ALTER TABLE roles ENABLE ROW LEVEL SECURITY;
ALTER TABLE model_has_permissions ENABLE ROW LEVEL SECURITY;
ALTER TABLE model_has_roles ENABLE ROW LEVEL SECURITY;
ALTER TABLE role_has_permissions ENABLE ROW LEVEL SECURITY;
ALTER TABLE images ENABLE ROW LEVEL SECURITY;
ALTER TABLE files ENABLE ROW LEVEL SECURITY;
ALTER TABLE badges ENABLE ROW LEVEL SECURITY;
ALTER TABLE badge_user ENABLE ROW LEVEL SECURITY;
ALTER TABLE vanity_tags ENABLE ROW LEVEL SECURITY;
ALTER TABLE anomalies ENABLE ROW LEVEL SECURITY;

-- ============================================================================
-- VERIFICATION QUERIES
-- ============================================================================

-- Run these to verify your data imported correctly
SELECT 'users' as table_name, COUNT(*) as record_count FROM users
UNION ALL
SELECT 'seasons', COUNT(*) FROM seasons
UNION ALL
SELECT 'houseguests', COUNT(*) FROM houseguests
UNION ALL
SELECT 'stocks', COUNT(*) FROM stocks
UNION ALL
SELECT 'transactions', COUNT(*) FROM transactions
UNION ALL
SELECT 'banks', COUNT(*) FROM banks
UNION ALL
SELECT 'prices', COUNT(*) FROM prices
UNION ALL
SELECT 'ratings', COUNT(*) FROM ratings
UNION ALL
SELECT 'leaderboards', COUNT(*) FROM leaderboards
UNION ALL
SELECT 'badges', COUNT(*) FROM badges
UNION ALL
SELECT 'badge_user', COUNT(*) FROM badge_user;

-- Check for any foreign key constraint violations
SELECT 
    tc.table_name, 
    tc.constraint_name, 
    tc.constraint_type
FROM information_schema.table_constraints tc
WHERE tc.constraint_type = 'FOREIGN KEY'
    AND tc.table_schema = 'public'
ORDER BY tc.table_name;

-- ============================================================================
-- IMPORT INSTRUCTIONS
-- ============================================================================

/*
To import your data into Supabase:

1. Create a new Supabase project
2. Run the schema creation script (supabase_schema.sql) first
3. Upload your CSV files to a location accessible to Supabase
4. Run this import script in the Supabase SQL Editor

Alternative method using Supabase Dashboard:
1. Go to Table Editor in Supabase
2. Select each table
3. Click "Insert" > "Import data from CSV"
4. Upload your CSV files

Note: The \COPY commands work in psql command line.
For Supabase SQL Editor, you may need to use the dashboard import feature instead.
*/