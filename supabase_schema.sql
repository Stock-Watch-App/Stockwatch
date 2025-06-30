-- Stockwatch Database Schema for Supabase (PostgreSQL)
-- Generated from Laravel migrations analysis

-- Enable necessary PostgreSQL extensions
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- ============================================================================
-- CORE TABLES
-- ============================================================================

-- Users table
CREATE TABLE users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    email_verified_at TIMESTAMPTZ,
    password VARCHAR(255),
    remember_token VARCHAR(100),
    provider_user_id VARCHAR(255),
    provider VARCHAR(255),
    banned BOOLEAN DEFAULT FALSE,
    avatar_approved INTEGER DEFAULT 0,
    avatar_id INTEGER,
    use_robot_avatar BOOLEAN DEFAULT TRUE,
    last_seen TIMESTAMPTZ,
    last_audited TIMESTAMPTZ,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

-- Seasons table
CREATE TABLE seasons (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    short_name VARCHAR(255) NOT NULL,
    status VARCHAR(255) NOT NULL,
    current_week INTEGER DEFAULT 0,
    closes_at TIME DEFAULT '20:00:00',
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

-- Houseguests table
CREATE TABLE houseguests (
    id BIGSERIAL PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    nickname VARCHAR(255) NOT NULL,
    season_id INTEGER NOT NULL,
    image VARCHAR(255),
    status VARCHAR(255) DEFAULT 'active',
    slug VARCHAR(255) NOT NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (season_id) REFERENCES seasons(id) ON DELETE CASCADE
);

-- Stocks table (user ownership of houseguest shares)
CREATE TABLE stocks (
    id BIGSERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    houseguest_id INTEGER NOT NULL,
    quantity INTEGER DEFAULT 0,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (houseguest_id) REFERENCES houseguests(id) ON DELETE CASCADE
);

-- Transactions table
CREATE TABLE transactions (
    id BIGSERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    houseguest_id INTEGER NOT NULL,
    action VARCHAR(255) NOT NULL,
    quantity INTEGER NOT NULL,
    current_price DECIMAL(8,2) NOT NULL,
    week INTEGER NOT NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (houseguest_id) REFERENCES houseguests(id) ON DELETE CASCADE
);

-- ============================================================================
-- FINANCIAL TABLES
-- ============================================================================

-- Banks table (user money per season)
CREATE TABLE banks (
    id BIGSERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    season_id INTEGER NOT NULL,
    money DECIMAL(8,2) NOT NULL,
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (season_id) REFERENCES seasons(id) ON DELETE CASCADE
);

-- Prices table (houseguest stock prices by week)
CREATE TABLE prices (
    id BIGSERIAL PRIMARY KEY,
    houseguest_id INTEGER NOT NULL,
    season_id INTEGER NOT NULL,
    week INTEGER NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (houseguest_id) REFERENCES houseguests(id) ON DELETE CASCADE,
    FOREIGN KEY (season_id) REFERENCES seasons(id) ON DELETE CASCADE
);

-- Leaderboards table
CREATE TABLE leaderboards (
    id BIGSERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    season_id INTEGER NOT NULL,
    week INTEGER NOT NULL,
    networth DECIMAL(10,2) NOT NULL,
    stocks VARCHAR(1000) NOT NULL, -- JSON string of stock holdings
    rank INTEGER NOT NULL,
    rank_percentage INTEGER NOT NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (season_id) REFERENCES seasons(id) ON DELETE CASCADE
);

-- ============================================================================
-- RATINGS AND PROJECTIONS
-- ============================================================================

-- Ratings table
CREATE TABLE ratings (
    id BIGSERIAL PRIMARY KEY,
    user_id INTEGER,
    houseguest_id INTEGER NOT NULL,
    week INTEGER NOT NULL,
    rating INTEGER NOT NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (houseguest_id) REFERENCES houseguests(id) ON DELETE CASCADE
);

-- Projections table
CREATE TABLE projections (
    id BIGSERIAL PRIMARY KEY,
    houseguest_id INTEGER NOT NULL,
    to_rate INTEGER NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (houseguest_id) REFERENCES houseguests(id) ON DELETE CASCADE
);

-- Formula reference table (for price calculations)
CREATE TABLE formula_reference (
    "from" INTEGER NOT NULL,
    "to" INTEGER NOT NULL,
    penalty DECIMAL(8,4) NOT NULL,
    bonus DECIMAL(8,4) NOT NULL,
    multiplier DECIMAL(8,4) NOT NULL
);

-- ============================================================================
-- TIME MANAGEMENT
-- ============================================================================

-- Weeks table
CREATE TABLE weeks (
    id BIGSERIAL PRIMARY KEY,
    week INTEGER NOT NULL,
    week_start DATE NOT NULL,
    week_end DATE NOT NULL,
    season_id INTEGER NOT NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (season_id) REFERENCES seasons(id) ON DELETE CASCADE
);

-- ============================================================================
-- PERMISSION SYSTEM (Spatie Laravel Permission)
-- ============================================================================

-- Permissions table
CREATE TABLE permissions (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(name, guard_name)
);

-- Roles table
CREATE TABLE roles (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(name, guard_name)
);

-- Model has permissions table (polymorphic)
CREATE TABLE model_has_permissions (
    permission_id BIGINT NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_morph_key BIGINT NOT NULL,
    PRIMARY KEY (permission_id, model_morph_key, model_type),
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);

-- Model has roles table (polymorphic)
CREATE TABLE model_has_roles (
    role_id BIGINT NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_morph_key BIGINT NOT NULL,
    PRIMARY KEY (role_id, model_morph_key, model_type),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

-- Role has permissions table
CREATE TABLE role_has_permissions (
    permission_id BIGINT NOT NULL,
    role_id BIGINT NOT NULL,
    PRIMARY KEY (permission_id, role_id),
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

-- ============================================================================
-- FILE MANAGEMENT
-- ============================================================================

-- Images table
CREATE TABLE images (
    id BIGSERIAL PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    filesize INTEGER,
    mime_type VARCHAR(255),
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

-- Files table
CREATE TABLE files (
    id BIGSERIAL PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    season_id INTEGER NOT NULL,
    week INTEGER NOT NULL,
    created_by BIGINT,
    updated_by BIGINT,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (season_id) REFERENCES seasons(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================================================
-- GAMIFICATION
-- ============================================================================

-- Badges table
CREATE TABLE badges (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    rank INTEGER NOT NULL,
    type VARCHAR(255) NOT NULL,
    season_id INTEGER NOT NULL,
    image_id INTEGER NOT NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (season_id) REFERENCES seasons(id) ON DELETE CASCADE,
    FOREIGN KEY (image_id) REFERENCES images(id) ON DELETE CASCADE
);

-- Badge user pivot table
CREATE TABLE badge_user (
    id BIGSERIAL PRIMARY KEY,
    badge_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ============================================================================
-- UTILITY TABLES
-- ============================================================================

-- Vanity tags table (polymorphic)
CREATE TABLE vanity_tags (
    id BIGSERIAL PRIMARY KEY,
    tag VARCHAR(255) NOT NULL,
    taggable_type VARCHAR(255),
    taggable_id INTEGER,
    season_id INTEGER,
    week INTEGER,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (season_id) REFERENCES seasons(id) ON DELETE CASCADE
);

-- Anomalies table
CREATE TABLE anomalies (
    id BIGSERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    season_id INTEGER,
    week INTEGER,
    message VARCHAR(255) NOT NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (season_id) REFERENCES seasons(id) ON DELETE CASCADE
);

-- ============================================================================
-- LARAVEL SYSTEM TABLES
-- ============================================================================

-- Password resets table
CREATE TABLE password_resets (
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMPTZ,
    INDEX (email)
);

-- Failed jobs table
CREATE TABLE failed_jobs (
    id BIGSERIAL PRIMARY KEY,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload TEXT NOT NULL,
    exception TEXT NOT NULL,
    failed_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

-- Sessions table
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    payload TEXT NOT NULL,
    last_activity INTEGER NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ============================================================================
-- INDEXES
-- ============================================================================

-- Performance indexes
CREATE INDEX idx_leaderboards_rank_percentage ON leaderboards(rank_percentage);
CREATE INDEX idx_password_resets_email ON password_resets(email);
CREATE INDEX idx_model_has_permissions_model ON model_has_permissions(model_morph_key, model_type);
CREATE INDEX idx_model_has_roles_model ON model_has_roles(model_morph_key, model_type);
CREATE INDEX idx_stocks_user_houseguest ON stocks(user_id, houseguest_id);
CREATE INDEX idx_transactions_user_week ON transactions(user_id, week);
CREATE INDEX idx_prices_houseguest_week ON prices(houseguest_id, week);
CREATE INDEX idx_ratings_houseguest_week ON ratings(houseguest_id, week);
CREATE INDEX idx_houseguests_season_status ON houseguests(season_id, status);
CREATE INDEX idx_banks_user_season ON banks(user_id, season_id);

-- ============================================================================
-- FUNCTIONS FOR UPDATED_AT TIMESTAMPS
-- ============================================================================

-- Function to automatically update updated_at timestamp
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ language 'plpgsql';

-- Apply updated_at triggers to all tables with updated_at columns
CREATE TRIGGER update_users_updated_at BEFORE UPDATE ON users FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_seasons_updated_at BEFORE UPDATE ON seasons FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_houseguests_updated_at BEFORE UPDATE ON houseguests FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_stocks_updated_at BEFORE UPDATE ON stocks FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_transactions_updated_at BEFORE UPDATE ON transactions FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_banks_updated_at BEFORE UPDATE ON banks FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_prices_updated_at BEFORE UPDATE ON prices FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_leaderboards_updated_at BEFORE UPDATE ON leaderboards FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_ratings_updated_at BEFORE UPDATE ON ratings FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_projections_updated_at BEFORE UPDATE ON projections FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_weeks_updated_at BEFORE UPDATE ON weeks FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_permissions_updated_at BEFORE UPDATE ON permissions FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_roles_updated_at BEFORE UPDATE ON roles FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_images_updated_at BEFORE UPDATE ON images FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_files_updated_at BEFORE UPDATE ON files FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_badges_updated_at BEFORE UPDATE ON badges FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_badge_user_updated_at BEFORE UPDATE ON badge_user FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_vanity_tags_updated_at BEFORE UPDATE ON vanity_tags FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_anomalies_updated_at BEFORE UPDATE ON anomalies FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();