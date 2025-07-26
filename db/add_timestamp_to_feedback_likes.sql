-- Add created_at column to feedback_likes table for tracking interaction timestamps
-- Run this command in phpMyAdmin if the created_at column doesn't exist

ALTER TABLE feedback_likes ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP; 