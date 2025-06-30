-- Row Level Security Policies for Stockwatch Supabase Database
-- These policies ensure users can only access their own data where appropriate

-- ============================================================================
-- ENABLE ROW LEVEL SECURITY ON TABLES
-- ============================================================================

-- Enable RLS on user-specific tables
ALTER TABLE users ENABLE ROW LEVEL SECURITY;
ALTER TABLE stocks ENABLE ROW LEVEL SECURITY;
ALTER TABLE transactions ENABLE ROW LEVEL SECURITY;
ALTER TABLE banks ENABLE ROW LEVEL SECURITY;
ALTER TABLE ratings ENABLE ROW LEVEL SECURITY;
ALTER TABLE leaderboards ENABLE ROW LEVEL SECURITY;
ALTER TABLE badge_user ENABLE ROW LEVEL SECURITY;
ALTER TABLE anomalies ENABLE ROW LEVEL SECURITY;
ALTER TABLE vanity_tags ENABLE ROW LEVEL SECURITY;

-- Tables that should be publicly readable (with some restrictions)
ALTER TABLE seasons ENABLE ROW LEVEL SECURITY;
ALTER TABLE houseguests ENABLE ROW LEVEL SECURITY;
ALTER TABLE prices ENABLE ROW LEVEL SECURITY;
ALTER TABLE projections ENABLE ROW LEVEL SECURITY;
ALTER TABLE weeks ENABLE ROW LEVEL SECURITY;
ALTER TABLE badges ENABLE ROW LEVEL SECURITY;
ALTER TABLE images ENABLE ROW LEVEL SECURITY;

-- Admin-only tables
ALTER TABLE permissions ENABLE ROW LEVEL SECURITY;
ALTER TABLE roles ENABLE ROW LEVEL SECURITY;
ALTER TABLE model_has_permissions ENABLE ROW LEVEL SECURITY;
ALTER TABLE model_has_roles ENABLE ROW LEVEL SECURITY;
ALTER TABLE role_has_permissions ENABLE ROW LEVEL SECURITY;
ALTER TABLE files ENABLE ROW LEVEL SECURITY;

-- ============================================================================
-- USER MANAGEMENT POLICIES
-- ============================================================================

-- Users can read their own profile and update specific fields
CREATE POLICY "Users can view their own profile" ON users
    FOR SELECT USING (auth.uid()::text = id::text);

CREATE POLICY "Users can update their own profile" ON users
    FOR UPDATE USING (auth.uid()::text = id::text)
    WITH CHECK (auth.uid()::text = id::text);

-- Allow user registration (insert)
CREATE POLICY "Allow user registration" ON users
    FOR INSERT WITH CHECK (auth.uid()::text = id::text);

-- ============================================================================
-- TRADING SYSTEM POLICIES
-- ============================================================================

-- Users can only access their own stocks
CREATE POLICY "Users can view their own stocks" ON stocks
    FOR SELECT USING (auth.uid()::text = user_id::text);

CREATE POLICY "Users can manage their own stocks" ON stocks
    FOR ALL USING (auth.uid()::text = user_id::text);

-- Users can only access their own transactions
CREATE POLICY "Users can view their own transactions" ON transactions
    FOR SELECT USING (auth.uid()::text = user_id::text);

CREATE POLICY "Users can create their own transactions" ON transactions
    FOR INSERT WITH CHECK (auth.uid()::text = user_id::text);

-- Users can only access their own bank accounts
CREATE POLICY "Users can view their own bank accounts" ON banks
    FOR SELECT USING (auth.uid()::text = user_id::text);

CREATE POLICY "Users can manage their own bank accounts" ON banks
    FOR ALL USING (auth.uid()::text = user_id::text);

-- ============================================================================
-- RATINGS SYSTEM POLICIES
-- ============================================================================

-- Users can view all ratings but only manage their own
CREATE POLICY "Anyone can view ratings" ON ratings
    FOR SELECT USING (true);

CREATE POLICY "Users can manage their own ratings" ON ratings
    FOR INSERT WITH CHECK (auth.uid()::text = user_id::text);

CREATE POLICY "Users can update their own ratings" ON ratings
    FOR UPDATE USING (auth.uid()::text = user_id::text)
    WITH CHECK (auth.uid()::text = user_id::text);

CREATE POLICY "Users can delete their own ratings" ON ratings
    FOR DELETE USING (auth.uid()::text = user_id::text);

-- ============================================================================
-- LEADERBOARD POLICIES
-- ============================================================================

-- Leaderboards are public for viewing
CREATE POLICY "Anyone can view leaderboards" ON leaderboards
    FOR SELECT USING (true);

-- Only system can insert/update leaderboards (handled by backend)
CREATE POLICY "System can manage leaderboards" ON leaderboards
    FOR ALL USING (false); -- Will be handled by service role

-- ============================================================================
-- PUBLICLY READABLE DATA POLICIES
-- ============================================================================

-- Seasons are publicly readable
CREATE POLICY "Anyone can view seasons" ON seasons
    FOR SELECT USING (true);

-- Houseguests are publicly readable
CREATE POLICY "Anyone can view houseguests" ON houseguests
    FOR SELECT USING (true);

-- Prices are publicly readable
CREATE POLICY "Anyone can view prices" ON prices
    FOR SELECT USING (true);

-- Projections are publicly readable
CREATE POLICY "Anyone can view projections" ON projections
    FOR SELECT USING (true);

-- Weeks are publicly readable
CREATE POLICY "Anyone can view weeks" ON weeks
    FOR SELECT USING (true);

-- Badges are publicly readable
CREATE POLICY "Anyone can view badges" ON badges
    FOR SELECT USING (true);

-- Images are publicly readable
CREATE POLICY "Anyone can view images" ON images
    FOR SELECT USING (true);

-- ============================================================================
-- BADGE SYSTEM POLICIES
-- ============================================================================

-- Users can view all badge assignments but only their own
CREATE POLICY "Anyone can view badge assignments" ON badge_user
    FOR SELECT USING (true);

CREATE POLICY "Users can view their own badge assignments" ON badge_user
    FOR SELECT USING (auth.uid()::text = user_id::text);

-- Only system can assign badges
CREATE POLICY "System can manage badge assignments" ON badge_user
    FOR INSERT WITH CHECK (false); -- Handled by service role

-- ============================================================================
-- ANOMALIES POLICIES
-- ============================================================================

-- Users can only view their own anomalies
CREATE POLICY "Users can view their own anomalies" ON anomalies
    FOR SELECT USING (auth.uid()::text = user_id::text);

-- ============================================================================
-- VANITY TAGS POLICIES
-- ============================================================================

-- Vanity tags are publicly readable
CREATE POLICY "Anyone can view vanity tags" ON vanity_tags
    FOR SELECT USING (true);

-- Users can create vanity tags (with restrictions in application logic)
CREATE POLICY "Authenticated users can create vanity tags" ON vanity_tags
    FOR INSERT WITH CHECK (auth.role() = 'authenticated');

-- ============================================================================
-- ADMIN-ONLY POLICIES
-- ============================================================================

-- Permission system - admin only
CREATE POLICY "Admin can manage permissions" ON permissions
    FOR ALL USING (auth.jwt() ->> 'role' = 'admin');

CREATE POLICY "Admin can manage roles" ON roles
    FOR ALL USING (auth.jwt() ->> 'role' = 'admin');

CREATE POLICY "Admin can manage model permissions" ON model_has_permissions
    FOR ALL USING (auth.jwt() ->> 'role' = 'admin');

CREATE POLICY "Admin can manage model roles" ON model_has_roles
    FOR ALL USING (auth.jwt() ->> 'role' = 'admin');

CREATE POLICY "Admin can manage role permissions" ON role_has_permissions
    FOR ALL USING (auth.jwt() ->> 'role' = 'admin');

-- File management - admin only
CREATE POLICY "Admin can manage files" ON files
    FOR ALL USING (auth.jwt() ->> 'role' = 'admin');

-- ============================================================================
-- SYSTEM TABLES (No RLS needed - handled by Supabase/system)
-- ============================================================================

-- password_resets, failed_jobs, sessions are handled by Supabase Auth
-- formula_reference is system data, no RLS needed

-- ============================================================================
-- HELPER FUNCTIONS FOR POLICIES
-- ============================================================================

-- Function to check if user is admin
CREATE OR REPLACE FUNCTION is_admin()
RETURNS BOOLEAN AS $$
BEGIN
    RETURN auth.jwt() ->> 'role' = 'admin';
END;
$$ LANGUAGE plpgsql SECURITY DEFINER;

-- Function to check if user owns a stock
CREATE OR REPLACE FUNCTION user_owns_stock(stock_user_id INTEGER)
RETURNS BOOLEAN AS $$
BEGIN
    RETURN auth.uid()::text = stock_user_id::text;
END;
$$ LANGUAGE plpgsql SECURITY DEFINER;

-- Function to get current season
CREATE OR REPLACE FUNCTION get_current_season()
RETURNS INTEGER AS $$
DECLARE
    current_season_id INTEGER;
BEGIN
    SELECT id INTO current_season_id 
    FROM seasons 
    WHERE status = 'open' 
    ORDER BY created_at DESC 
    LIMIT 1;
    
    RETURN COALESCE(current_season_id, 0);
END;
$$ LANGUAGE plpgsql SECURITY DEFINER;

-- ============================================================================
-- ADDITIONAL SECURITY CONSIDERATIONS
-- ============================================================================

-- Create a service role for backend operations that bypass RLS
-- This will be used by your Laravel API for system operations like:
-- - Calculating leaderboards
-- - Updating prices
-- - Managing seasons
-- - Badge assignments

-- Note: You'll need to create a service key in Supabase dashboard
-- and use it in your Laravel backend for operations that need to bypass RLS