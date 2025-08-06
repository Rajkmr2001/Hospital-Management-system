# Git Workflow Guide - Staging Branch Setup

## 🎯 Current Setup
You now have a **staging branch** workflow set up! This is much better than pushing directly to main.

## 📋 Your New Git Workflow

### **Current Status:**
- ✅ **Main branch**: Contains stable, working code
- ✅ **Staging branch**: Where you'll develop new features
- ✅ **Remote**: Both branches are pushed to GitHub

### **How to Use This Workflow:**

#### **1. Daily Development (Always on Staging)**
```bash
# Make sure you're on staging branch
git checkout staging

# Make your changes to files
# ... edit your code ...

# Add and commit your changes
git add .
git commit -m "Your descriptive commit message"

# Push to staging branch
git push origin staging
```

#### **2. When Ready to Release (Merge to Main)**
```bash
# Switch to main branch
git checkout main

# Pull latest changes from main (in case others made changes)
git pull origin main

# Merge staging into main
git merge staging

# Push the updated main branch
git push origin main

# Switch back to staging for next development
git checkout staging
```

#### **3. If You Need to Get Previous Code**
```bash
# To see all commits and their history
git log --oneline

# To go back to a specific commit (temporarily)
git checkout <commit-hash>

# To revert to a previous state permanently
git reset --hard <commit-hash>

# To create a new branch from a specific commit
git checkout -b backup-branch <commit-hash>
```

## 🔄 Common Workflow Scenarios

### **Scenario 1: Adding a New Feature**
```bash
git checkout staging
# Make your changes
git add .
git commit -m "Add new patient dashboard feature"
git push origin staging
# Test thoroughly on staging
# When ready: git checkout main && git merge staging && git push origin main
```

### **Scenario 2: Fixing a Bug**
```bash
git checkout staging
# Fix the bug
git add .
git commit -m "Fix patient login bug"
git push origin staging
# Test the fix
# When ready: git checkout main && git merge staging && git push origin main
```

### **Scenario 3: Emergency Hotfix**
```bash
# For critical fixes, you can work directly on main
git checkout main
# Make the critical fix
git add .
git commit -m "Emergency hotfix: critical security issue"
git push origin main
# Then merge main back to staging
git checkout staging
git merge main
git push origin staging
```

## 📊 Branch Protection (Recommended)

### **Set up on GitHub:**
1. Go to your repository on GitHub
2. Go to Settings → Branches
3. Add rule for `main` branch:
   - ✅ Require pull request reviews
   - ✅ Require status checks to pass
   - ✅ Restrict pushes to matching branches

## 🛠️ Useful Git Commands

### **Check Current Status:**
```bash
git status                    # See what files are changed
git branch                    # See all branches
git log --oneline            # See commit history
```

### **Undo Changes:**
```bash
git checkout -- filename     # Undo changes to a specific file
git reset --hard HEAD        # Undo all uncommitted changes
git revert <commit-hash>     # Create a new commit that undoes a previous commit
```

### **Branch Management:**
```bash
git branch -d branch-name    # Delete a local branch
git push origin --delete branch-name  # Delete remote branch
git fetch --all              # Get all remote branches
```

## 🚨 Important Rules

1. **Never push directly to main** - Always use staging first
2. **Always test on staging** before merging to main
3. **Write descriptive commit messages**
4. **Pull before pushing** to avoid conflicts
5. **Keep staging up to date** with main

## 🔧 Quick Reference

| Action | Command |
|--------|---------|
| Switch to staging | `git checkout staging` |
| Switch to main | `git checkout main` |
| See current branch | `git branch` |
| Add all changes | `git add .` |
| Commit changes | `git commit -m "message"` |
| Push to staging | `git push origin staging` |
| Push to main | `git push origin main` |
| Merge staging to main | `git checkout main && git merge staging` |

## 🎉 Benefits of This Workflow

- ✅ **Safe development**: Main stays stable
- ✅ **Easy rollback**: Can revert to previous versions
- ✅ **Better testing**: Test on staging before main
- ✅ **Team collaboration**: Others can review your changes
- ✅ **Version history**: Clear history of all changes

## 📞 Need Help?

If you get stuck:
1. Check this guide first
2. Use `git status` to see what's happening
3. Use `git log --oneline` to see recent commits
4. Remember: You can always start fresh by checking out main and creating a new staging branch

---

**Happy coding! 🚀** 
...................................
git status
git add .
git status
git commit -m"message"
git push origin staging