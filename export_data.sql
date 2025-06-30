-- Data Export Script for Laravel to Supabase Migration
-- Run these queries in your current Laravel database to export data

-- ============================================================================
-- EXPORT USERS DATA
-- ============================================================================
SELECT 
    id,
    name,
    email,
    email_verified_at,
    password,
    remember_token,
    provider_user_id,
    provider,
    banned,
    avatar_approved,
    avatar_id,
    use_robot_avatar,
    last_seen,
    last_audited,
    created_at,
    updated_at
FROM users
ORDER BY id;

-- Save the above result as 'users_export.csv'

-- ============================================================================
-- EXPORT SEASONS DATA
-- ============================================================================
SELECT 
    id,
    name,
    short_name,
    status,
    current_week,
    closes_at,
    created_at,
    updated_at
FROM seasons
ORDER BY id;

-- Save the above result as 'seasons_export.csv'

-- ============================================================================
-- EXPORT HOUSEGUESTS DATA
-- ============================================================================
SELECT 
    id,
    first_name,
    last_name,
    nickname,
    season_id,
    image,
    status,
    slug,
    created_at,
    updated_at
FROM houseguests
ORDER BY id;

-- Save the above result as 'houseguests_export.csv'

-- ============================================================================
-- EXPORT STOCKS DATA
-- ============================================================================
SELECT 
    id,
    user_id,
    houseguest_id,
    quantity,
    created_at,
    updated_at
FROM stocks
ORDER BY id;

-- Save the above result as 'stocks_export.csv'

-- ============================================================================
-- EXPORT TRANSACTIONS DATA
-- ============================================================================
SELECT 
    id,
    user_id,
    houseguest_id,
    action,
    quantity,
    current_price,
    week,
    created_at,
    updated_at
FROM transactions
ORDER BY id;

-- Save the above result as 'transactions_export.csv'

-- ============================================================================
-- EXPORT BANKS DATA
-- ============================================================================
SELECT 
    id,
    user_id,
    season_id,
    money,
    active,
    created_at,
    updated_at
FROM banks
ORDER BY id;

-- Save the above result as 'banks_export.csv'

-- ============================================================================
-- EXPORT PRICES DATA
-- ============================================================================
SELECT 
    id,
    houseguest_id,
    season_id,
    week,
    price,
    created_at,
    updated_at
FROM prices
ORDER BY id;

-- Save the above result as 'prices_export.csv'

-- ============================================================================
-- EXPORT LEADERBOARDS DATA
-- ============================================================================
SELECT 
    id,
    user_id,
    season_id,
    week,
    networth,
    stocks,
    rank,
    rank_percentage,
    created_at,
    updated_at
FROM leaderboards
ORDER BY id;

-- Save the above result as 'leaderboards_export.csv'

-- ============================================================================
-- EXPORT RATINGS DATA
-- ============================================================================
SELECT 
    id,
    user_id,
    houseguest_id,
    week,
    rating,
    created_at,
    updated_at
FROM ratings
ORDER BY id;

-- Save the above result as 'ratings_export.csv'

-- ============================================================================
-- EXPORT PROJECTIONS DATA
-- ============================================================================
SELECT 
    id,
    houseguest_id,
    to_rate,
    price,
    created_at,
    updated_at
FROM projections
ORDER BY id;

-- Save the above result as 'projections_export.csv'

-- ============================================================================
-- EXPORT WEEKS DATA
-- ============================================================================
SELECT 
    id,
    week,
    week_start,
    week_end,
    season_id,
    created_at,
    updated_at
FROM weeks
ORDER BY id;

-- Save the above result as 'weeks_export.csv'

-- ============================================================================
-- EXPORT PERMISSIONS DATA
-- ============================================================================
SELECT 
    id,
    name,
    guard_name,
    created_at,
    updated_at
FROM permissions
ORDER BY id;

-- Save the above result as 'permissions_export.csv'

-- ============================================================================
-- EXPORT ROLES DATA
-- ============================================================================
SELECT 
    id,
    name,
    guard_name,
    created_at,
    updated_at
FROM roles
ORDER BY id;

-- Save the above result as 'roles_export.csv'

-- ============================================================================
-- EXPORT MODEL HAS PERMISSIONS DATA
-- ============================================================================
SELECT 
    permission_id,
    model_type,
    model_morph_key
FROM model_has_permissions
ORDER BY permission_id, model_morph_key;

-- Save the above result as 'model_has_permissions_export.csv'

-- ============================================================================
-- EXPORT MODEL HAS ROLES DATA
-- ============================================================================
SELECT 
    role_id,
    model_type,
    model_morph_key
FROM model_has_roles
ORDER BY role_id, model_morph_key;

-- Save the above result as 'model_has_roles_export.csv'

-- ============================================================================
-- EXPORT ROLE HAS PERMISSIONS DATA
-- ============================================================================
SELECT 
    permission_id,
    role_id
FROM role_has_permissions
ORDER BY permission_id, role_id;

-- Save the above result as 'role_has_permissions_export.csv'

-- ============================================================================
-- EXPORT IMAGES DATA
-- ============================================================================
SELECT 
    id,
    filename,
    filesize,
    mime_type,
    created_at,
    updated_at
FROM images
ORDER BY id;

-- Save the above result as 'images_export.csv'

-- ============================================================================
-- EXPORT FILES DATA
-- ============================================================================
SELECT 
    id,
    filename,
    type,
    season_id,
    week,
    created_by,
    updated_by,
    created_at,
    updated_at
FROM files
ORDER BY id;

-- Save the above result as 'files_export.csv'

-- ============================================================================
-- EXPORT BADGES DATA
-- ============================================================================
SELECT 
    id,
    name,
    rank,
    type,
    season_id,
    image_id,
    created_at,
    updated_at
FROM badges
ORDER BY id;

-- Save the above result as 'badges_export.csv'

-- ============================================================================
-- EXPORT BADGE USER DATA
-- ============================================================================
SELECT 
    id,
    badge_id,
    user_id,
    created_at,
    updated_at
FROM badge_user
ORDER BY id;

-- Save the above result as 'badge_user_export.csv'

-- ============================================================================
-- EXPORT VANITY TAGS DATA
-- ============================================================================
SELECT 
    id,
    tag,
    taggable_type,
    taggable_id,
    season_id,
    week,
    created_at,
    updated_at
FROM vanity_tags
ORDER BY id;

-- Save the above result as 'vanity_tags_export.csv'

-- ============================================================================
-- EXPORT ANOMALIES DATA
-- ============================================================================
SELECT 
    id,
    user_id,
    season_id,
    week,
    message,
    created_at,
    updated_at
FROM anomalies
ORDER BY id;

-- Save the above result as 'anomalies_export.csv'

-- ============================================================================
-- EXPORT FORMULA REFERENCE DATA
-- ============================================================================
SELECT 
    "from",
    "to",
    penalty,
    bonus,
    multiplier
FROM formula_reference
ORDER BY "from", "to";

-- Save the above result as 'formula_reference_export.csv'

-- ============================================================================
-- EXPORT INSTRUCTIONS
-- ============================================================================

/*
To export your data:

1. Connect to your current Laravel database (MySQL/PostgreSQL)
2. Run each SELECT query above
3. Export results as CSV files with the specified names
4. Upload the CSV files to your Supabase database using the import scripts

Alternative method using command line:

For MySQL:
mysql -u username -p database_name -e "SELECT * FROM users;" | sed 's/\t/,/g' > users_export.csv

For PostgreSQL:
psql -d database_name -c "\COPY (SELECT * FROM users) TO 'users_export.csv' WITH CSV HEADER;"

You can create a script to export all tables at once.
*/