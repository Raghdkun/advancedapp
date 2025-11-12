# 📋 Command Cheat Sheet

Quick reference for common commands in this project.

## 🔧 Setup Commands

### Initial Setup
```bash
# Get dependencies
flutter pub get

# Generate dependency injection code (MUST RUN FIRST TIME)
flutter pub run build_runner build --delete-conflicting-outputs

# Run the app
flutter run
```

## 🏗️ Code Generation

### Build Runner Commands
```bash
# One-time generation
flutter pub run build_runner build --delete-conflicting-outputs

# Watch mode (auto-generates on file save)
flutter pub run build_runner watch --delete-conflicting-outputs

# Clean generated files
flutter pub run build_runner clean
```

## 🚀 Running the App

### Basic Run
```bash
# Run on connected device
flutter run

# Run on specific device
flutter devices  # List devices
flutter run -d <device-id>

# Run with specific flavor (if configured)
flutter run --flavor dev
flutter run --flavor prod
```

### Build Commands
```bash
# Build APK (Android)
flutter build apk

# Build App Bundle (Android)
flutter build appbundle

# Build iOS
flutter build ios

# Build Web
flutter build web

# Build Windows
flutter build windows

# Build macOS
flutter build macos

# Build Linux
flutter build linux
```

## 🧪 Testing Commands

### Run Tests
```bash
# Run all tests
flutter test

# Run specific test file
flutter test test/features/counter/counter_bloc_test.dart

# Run tests with coverage
flutter test --coverage

# View coverage report (requires lcov)
genhtml coverage/lcov.info -o coverage/html
```

## 🔍 Code Quality

### Analysis
```bash
# Analyze code
flutter analyze

# Format code
flutter format .

# Check for outdated packages
flutter pub outdated
```

### Linting
```bash
# Run dart linter
dart analyze

# Fix auto-fixable issues
dart fix --apply
```

## 📦 Package Management

### Add Packages
```bash
# Add production dependency
flutter pub add package_name

# Add dev dependency
flutter pub add --dev package_name

# Add multiple packages
flutter pub add package1 package2 package3
```

### Update Packages
```bash
# Update all packages
flutter pub upgrade

# Update specific package
flutter pub upgrade package_name

# Get packages after pubspec.yaml changes
flutter pub get
```

### Remove Packages
```bash
# Remove package
flutter pub remove package_name
```

## 🧹 Cleanup Commands

### Clean Project
```bash
# Clean build artifacts
flutter clean

# Clean and get dependencies
flutter clean && flutter pub get

# Clean generated files
flutter pub run build_runner clean
```

### Cache Management
```bash
# Clear Flutter cache
flutter pub cache repair

# Clear build cache
flutter clean
rm -rf build/
```

## 📱 Device Management

### List Devices
```bash
# List all connected devices
flutter devices

# List all emulators
flutter emulators

# Launch emulator
flutter emulators --launch <emulator-id>
```

## 🐛 Debugging

### Debug Commands
```bash
# Run in debug mode (default)
flutter run

# Run in profile mode
flutter run --profile

# Run in release mode
flutter run --release

# Enable verbose logging
flutter run -v

# Hot reload (press 'r' in terminal)
# Hot restart (press 'R' in terminal)
```

### Performance
```bash
# Run with performance overlay
flutter run --profile --dart-define=flutter.profile=true

# Analyze bundle size
flutter build apk --analyze-size
flutter build appbundle --analyze-size
```

## 🔧 Project-Specific Commands

### Generate Injectable DI Code (IMPORTANT!)
```bash
# Must run after adding new @injectable classes
flutter pub run build_runner build --delete-conflicting-outputs
```

### Generate Freezed Models
```bash
# If using freezed for immutable classes
flutter pub run build_runner build --delete-conflicting-outputs
```

### Generate JSON Serialization
```bash
# If using json_serializable
flutter pub run build_runner build --delete-conflicting-outputs
```

## 📊 Useful Flutter Commands

### Check Flutter Status
```bash
# Check Flutter installation
flutter doctor

# Verbose doctor output
flutter doctor -v

# Check for Flutter updates
flutter upgrade
```

### Create New Components
```bash
# This project uses clean architecture, so create files manually
# following the structure in QUICKSTART.md
```

## 🔄 Git Workflow (if using Git)

### Common Git Commands
```bash
# Check status
git status

# Add files
git add .

# Commit
git commit -m "Your message"

# Push
git push origin main

# Pull
git pull origin main

# Create branch
git checkout -b feature/your-feature

# Merge branch
git checkout main
git merge feature/your-feature
```

## 🎯 Quick Start Workflow

### Starting Fresh
```bash
# 1. Clean everything
flutter clean

# 2. Get dependencies
flutter pub get

# 3. Generate code
flutter pub run build_runner build --delete-conflicting-outputs

# 4. Run the app
flutter run
```

### After Adding New Feature
```bash
# 1. Add your code with @injectable annotations

# 2. Generate DI code
flutter pub run build_runner build --delete-conflicting-outputs

# 3. Test
flutter run

# 4. Run tests
flutter test
```

## 💡 Pro Tips

### Watch Mode for Development
```bash
# In one terminal - auto-generate code on save
flutter pub run build_runner watch

# In another terminal - run the app
flutter run
```

### Quick Fixes
```bash
# If builds are slow or acting weird
flutter clean && flutter pub get && flutter pub run build_runner build --delete-conflicting-outputs

# If dependencies are messed up
flutter pub cache repair && flutter clean && flutter pub get

# If emulator is slow
flutter run --profile  # Instead of debug mode
```

## 📝 Notes

- Always run `build_runner` after adding `@injectable` classes
- Use `flutter clean` if you encounter weird build issues
- Keep dependencies up to date with `flutter pub upgrade`
- Run `flutter analyze` before committing code
- Use `flutter format .` to format all Dart files

## 🚨 Common Issues & Solutions

### Issue: Build fails
```bash
Solution:
flutter clean
flutter pub get
flutter pub run build_runner build --delete-conflicting-outputs
```

### Issue: Dependency injection not working
```bash
Solution:
# Make sure class has @injectable annotation
# Then regenerate code
flutter pub run build_runner build --delete-conflicting-outputs
```

### Issue: Hot reload not working
```bash
Solution:
# Try hot restart (press 'R' in terminal)
# Or stop and restart the app
```

### Issue: Package conflicts
```bash
Solution:
flutter pub cache repair
flutter clean
flutter pub get
```

## 📚 Additional Resources

- Flutter Docs: https://docs.flutter.dev
- Dart Docs: https://dart.dev/guides
- BLoC Library: https://bloclibrary.dev
- Injectable: https://pub.dev/packages/injectable
- GoRouter: https://pub.dev/packages/go_router

---

**Tip**: Bookmark this file for quick reference! 🔖
