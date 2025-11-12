# Advanced Flutter App - Clean Architecture

A Flutter application built with Clean Architecture principles and BLoC state management.

## 🏗️ Project Structure

```
lib/
├── core/                          # Core utilities and shared code
│   ├── constants/                 # App constants
│   │   ├── api_constants.dart    # API-related constants
│   │   └── app_constants.dart    # General app constants
│   ├── di/                        # Dependency Injection
│   │   ├── injection.dart        # GetIt setup
│   │   └── injection.config.dart # Generated DI config
│   ├── error/                     # Error handling
│   │   ├── exceptions.dart       # Custom exceptions
│   │   └── failures.dart         # Failure classes
│   ├── network/                   # Network utilities
│   │   └── network_info.dart     # Network connectivity checker
│   ├── usecases/                  # Base use case
│   │   └── usecase.dart          # UseCase abstract class
│   └── utils/                     # Utility classes
│       └── logger.dart           # App logger
├── config/                        # App configuration
│   ├── routes/                    # Navigation
│   │   ├── app_routes.dart       # Route constants
│   │   └── app_router.dart       # GoRouter configuration
│   └── theme/                     # Theme configuration
│       ├── app_colors.dart       # Color constants
│       ├── app_theme.dart        # Theme data
│       ├── theme_cubit.dart      # Theme BLoC
│       └── theme_state.dart      # Theme state
├── features/                      # Feature modules
│   └── [feature_name]/           # Each feature follows this structure:
│       ├── data/                 # Data layer
│       │   ├── datasources/      # Remote & Local data sources
│       │   ├── models/           # Data models (JSON serialization)
│       │   └── repositories/     # Repository implementations
│       ├── domain/               # Domain layer (Business Logic)
│       │   ├── entities/         # Business entities
│       │   ├── repositories/     # Repository interfaces
│       │   └── usecases/         # Use cases
│       └── presentation/         # Presentation layer
│           ├── bloc/             # BLoC files
│           ├── pages/            # Page widgets
│           └── widgets/          # Reusable widgets
└── main.dart                      # App entry point
```

## 📦 Packages Used

### State Management & Architecture
- **flutter_bloc** (^9.1.1) - BLoC pattern implementation
- **equatable** (^2.0.7) - Value equality for Dart classes
- **dartz** (^0.10.1) - Functional programming (Either, Option)
- **get_it** (^9.0.5) - Service locator for dependency injection
- **injectable** (^2.6.0) - Code generation for GetIt

### Network & Data
- **dio** (^5.9.0) - HTTP client
- **shared_preferences** (^2.5.3) - Local storage

### Navigation
- **go_router** (^17.0.0) - Declarative routing

### Code Generation (Dev Dependencies)
- **build_runner** - Code generation runner
- **injectable_generator** - Generates DI code
- **freezed** - Code generation for immutable classes
- **json_serializable** - JSON serialization

## 🚀 Getting Started

### Prerequisites
- Flutter SDK (^3.9.2)
- Dart SDK (^3.9.2)

### Installation

1. Clone the repository
2. Install dependencies:
```bash
flutter pub get
```

3. Generate code (for dependency injection):
```bash
flutter pub run build_runner build --delete-conflicting-outputs
```

4. Run the app:
```bash
flutter run
```

## 🏛️ Clean Architecture Layers

### 1. Domain Layer (Business Logic)
- **Entities**: Pure Dart classes representing business objects
- **Repositories**: Abstract classes defining contracts
- **Use Cases**: Single-purpose business logic operations

### 2. Data Layer
- **Models**: Data representations with JSON serialization
- **Data Sources**: Remote (API) and Local (Cache) data sources
- **Repository Implementations**: Concrete implementations of domain repositories

### 3. Presentation Layer
- **BLoC**: State management (Events, States, BLoC)
- **Pages**: Full screen widgets
- **Widgets**: Reusable UI components

## 🎨 Theme System

The app supports dark and light mode with a theme switcher:

```dart
// Get theme cubit
final themeCubit = context.read<ThemeCubit>();

// Toggle theme
themeCubit.toggleTheme();

// Set specific theme
themeCubit.setThemeMode(ThemeMode.dark);

// Check current theme
bool isDark = themeCubit.isDarkMode;
```

## 🧭 Navigation

Using GoRouter for type-safe navigation:

```dart
// Navigate to a route
context.push(AppRoutes.home);

// Navigate with replacement
context.pushReplacement(AppRoutes.login);

// Go back
context.pop();
```

## 💉 Dependency Injection

Using GetIt with Injectable for dependency injection:

```dart
// Register dependencies in injection.dart
@module
abstract class RegisterModule {
  @singleton
  MyService get myService => MyServiceImpl();
}

// Access dependencies
final myService = getIt<MyService>();
```

## 🔧 Creating a New Feature

1. Create feature folder structure:
```
features/
  └── my_feature/
      ├── data/
      ├── domain/
      └── presentation/
```

2. Implement layers from inside-out:
   - Domain (entities, repositories, use cases)
   - Data (models, data sources, repository implementations)
   - Presentation (BLoC, pages, widgets)

3. Register dependencies in `injection.dart`

4. Add routes in `app_router.dart`

## 🧪 Testing

```bash
# Run all tests
flutter test

# Run with coverage
flutter test --coverage
```

## 📝 Code Generation

When you add new injectable classes or JSON models:

```bash
# Watch mode (auto-generates on file changes)
flutter pub run build_runner watch

# One-time generation
flutter pub run build_runner build --delete-conflicting-outputs
```

## 🔑 Key Principles

1. **Separation of Concerns**: Each layer has a specific responsibility
2. **Dependency Rule**: Dependencies point inward (Domain ← Data, Domain ← Presentation)
3. **SOLID Principles**: Single responsibility, Open/closed, Liskov substitution, Interface segregation, Dependency inversion
4. **Testability**: Easy to test each layer independently
5. **Scalability**: Easy to add new features without affecting existing code

## 📱 Features

- ✅ Clean Architecture
- ✅ BLoC State Management
- ✅ Dependency Injection
- ✅ Dark/Light Theme Support
- ✅ Type-safe Navigation
- ✅ Error Handling
- ✅ Logging
- ✅ Code Generation Ready

## 🤝 Contributing

1. Follow the existing architecture patterns
2. Write tests for new features
3. Update documentation
4. Run code generation before committing

## 📄 License

This project is licensed under the MIT License.
