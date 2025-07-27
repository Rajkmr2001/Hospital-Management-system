-- Add phone column to messages table
ALTER TABLE messages ADD COLUMN phone VARCHAR(15) AFTER email;

-- Update existing records to have a default phone number if needed
-- UPDATE messages SET phone = 'N/A' WHERE phone IS NULL;

-- Make phone column required for future entries (optional)
-- ALTER TABLE messages MODIFY COLUMN phone VARCHAR(15) NOT NULL; 