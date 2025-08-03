-- Add dislike_type column to feedback_likes table
ALTER TABLE feedback_likes ADD COLUMN dislike_type ENUM('like', 'dislike') DEFAULT 'like' AFTER user_ip;

-- Update existing records to be 'like' type
UPDATE feedback_likes SET dislike_type = 'like' WHERE dislike_type IS NULL; 