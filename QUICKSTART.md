# 🚀 Quick Start Guide

## Clean Architecture Flutter App with BLoC

This guide will help you get started with the clean architecture setup.

## 📋 What's Been Set Up

### ✅ Core Features
- **Clean Architecture** with proper layer separation
- **BLoC Pattern** for state management
- **Dependency Injection** using GetIt + Injectable
- **Routing** with GoRouter
- **Dark/Light Theme** support with ThemeCubit
- **Error Handling** system
- **Logger** utility

### 📦 Installed Packages
- flutter_bloc (^9.1.1)
- equatable (^2.0.7)
- dartz (^0.10.1)
- get_it (^9.0.5)
- injectable (^2.6.0)
- dio (^5.9.0)
- shared_preferences (^2.5.3)
- go_router (^17.0.0)
- build_runner, injectable_generator, freezed, json_serializable (dev)

## 🎯 Running the App

1. **Generate Code** (first time and after changes):
```bash
flutter pub run build_runner build --delete-conflicting-outputs
```

2. **Run the App**:
```bash
flutter run
```

3. **See the Counter Example**:
   - The app starts with a working counter feature demonstrating clean architecture
   - Increment/Decrement/Reset buttons
   - State persisted in SharedPreferences

## 🏗️ Project Structure

```
lib/
├── core/                    # Shared code across features
│   ├── constants/          # API & App constants
│   ├── di/                 # Dependency injection setup
│   ├── error/              # Error handling (failures & exceptions)
│   ├── network/            # Network utilities
│   ├── usecases/           # Base UseCase class
│   └── utils/              # Utilities (logger, etc.)
│
├── config/                  # App configuration
│   ├── routes/             # Navigation (GoRouter)
│   └── theme/              # Theme (colors, theme data, theme cubit)
│
├── features/               # Feature modules
│   └── counter/            # Example counter feature
│       ├── data/           # Data layer
│       │   ├── datasources/    # Local & Remote data sources
│       │   ├── models/         # Data models
│       │   └── repositories/   # Repository implementations
│       ├── domain/         # Domain layer
│       │   ├── entities/       # Business entities
│       │   ├── repositories/   # Repository interfaces
│       │   └── usecases/       # Use cases
│       └── presentation/   # Presentation layer
│           ├── bloc/           # BLoC (event, state, bloc)
│           ├── pages/          # Pages
│           └── widgets/        # Widgets
│
└── main.dart               # Entry point
```

## 🎨 Using the Theme System

### Toggle Theme
```dart
import 'package:flutter_bloc/flutter_bloc.dart';
import 'config/theme/theme_cubit.dart';

// In your widget:
context.read<ThemeCubit>().toggleTheme();
```

### Set Specific Theme
```dart
// Light mode
context.read<ThemeCubit>().setThemeMode(ThemeMode.light);

// Dark mode
context.read<ThemeCubit>().setThemeMode(ThemeMode.dark);

// System mode
context.read<ThemeCubit>().setThemeMode(ThemeMode.system);
```

### Check Current Theme
```dart
final themeCubit = context.read<ThemeCubit>();
bool isDark = themeCubit.isDarkMode;
bool isLight = themeCubit.isLightMode;
bool isSystem = themeCubit.isSystemMode;
```

## 🧭 Navigation

### Navigate to a route
```dart
import 'package:go_router/go_router.dart';
import 'config/routes/app_routes.dart';

// Push
context.push(AppRoutes.home);

// Push replacement
context.pushReplacement(AppRoutes.login);

// Go (clear stack)
context.go(AppRoutes.home);

// Pop
context.pop();
```

### Add a new route
1. Add route constant in `config/routes/app_routes.dart`
2. Add GoRoute in `config/routes/app_router.dart`

## 🆕 Creating a New Feature

### Step 1: Create Feature Structure
```
features/
  └── your_feature/
      ├── data/
      │   ├── datasources/
      │   ├── models/
      │   └── repositories/
      ├── domain/
      │   ├── entities/
      │   ├── repositories/
      │   └── usecases/
      └── presentation/
          ├── bloc/
          ├── pages/
          └── widgets/
```

### Step 2: Implement Domain Layer (Business Logic)

#### 2.1 Create Entity
```dart
// features/your_feature/domain/entities/your_entity.dart
import 'package:equatable/equatable.dart';

class YourEntity extends Equatable {
  final String id;
  final String name;
  
  const YourEntity({required this.id, required this.name});
  
  @override
  List<Object> get props => [id, name];
}
```

#### 2.2 Create Repository Interface
```dart
// features/your_feature/domain/repositories/your_repository.dart
import 'package:dartz/dartz.dart';
import '../../../../core/error/failures.dart';
import '../entities/your_entity.dart';

abstract class YourRepository {
  Future<Either<Failure, List<YourEntity>>> getItems();
  Future<Either<Failure, YourEntity>> getItemById(String id);
}
```

#### 2.3 Create Use Case
```dart
// features/your_feature/domain/usecases/get_items.dart
import 'package:dartz/dartz.dart';
import 'package:injectable/injectable.dart';
import '../../../../core/error/failures.dart';
import '../../../../core/usecases/usecase.dart';
import '../entities/your_entity.dart';
import '../repositories/your_repository.dart';

@injectable
class GetItems implements UseCase<List<YourEntity>, NoParams> {
  final YourRepository repository;
  
  GetItems(this.repository);
  
  @override
  Future<Either<Failure, List<YourEntity>>> call(NoParams params) async {
    return await repository.getItems();
  }
}
```

### Step 3: Implement Data Layer

#### 3.1 Create Model
```dart
// features/your_feature/data/models/your_model.dart
import '../../domain/entities/your_entity.dart';

class YourModel extends YourEntity {
  const YourModel({required super.id, required super.name});
  
  factory YourModel.fromJson(Map<String, dynamic> json) {
    return YourModel(
      id: json['id'] as String,
      name: json['name'] as String,
    );
  }
  
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
    };
  }
}
```

#### 3.2 Create Data Source
```dart
// features/your_feature/data/datasources/your_remote_data_source.dart
import 'package:dio/dio.dart';
import 'package:injectable/injectable.dart';
import '../../../../core/error/exceptions.dart';
import '../models/your_model.dart';

abstract class YourRemoteDataSource {
  Future<List<YourModel>> getItems();
}

@Injectable(as: YourRemoteDataSource)
class YourRemoteDataSourceImpl implements YourRemoteDataSource {
  final Dio dio;
  
  YourRemoteDataSourceImpl(this.dio);
  
  @override
  Future<List<YourModel>> getItems() async {
    try {
      final response = await dio.get('/your-endpoint');
      return (response.data as List)
          .map((json) => YourModel.fromJson(json))
          .toList();
    } on DioException catch (e) {
      throw ServerException(e.message ?? 'Server error');
    }
  }
}
```

#### 3.3 Implement Repository
```dart
// features/your_feature/data/repositories/your_repository_impl.dart
import 'package:dartz/dartz.dart';
import 'package:injectable/injectable.dart';
import '../../../../core/error/exceptions.dart';
import '../../../../core/error/failures.dart';
import '../../domain/entities/your_entity.dart';
import '../../domain/repositories/your_repository.dart';
import '../datasources/your_remote_data_source.dart';

@Injectable(as: YourRepository)
class YourRepositoryImpl implements YourRepository {
  final YourRemoteDataSource remoteDataSource;
  
  YourRepositoryImpl(this.remoteDataSource);
  
  @override
  Future<Either<Failure, List<YourEntity>>> getItems() async {
    try {
      final items = await remoteDataSource.getItems();
      return Right(items);
    } on ServerException catch (e) {
      return Left(ServerFailure(e.message));
    } catch (e) {
      return Left(UnexpectedFailure(e.toString()));
    }
  }
  
  @override
  Future<Either<Failure, YourEntity>> getItemById(String id) async {
    // Implementation
    throw UnimplementedError();
  }
}
```

### Step 4: Implement Presentation Layer

#### 4.1 Create BLoC Events
```dart
// features/your_feature/presentation/bloc/your_event.dart
part of 'your_bloc.dart';

abstract class YourEvent extends Equatable {
  const YourEvent();
  
  @override
  List<Object> get props => [];
}

class LoadItems extends YourEvent {}
```

#### 4.2 Create BLoC States
```dart
// features/your_feature/presentation/bloc/your_state.dart
part of 'your_bloc.dart';

abstract class YourState extends Equatable {
  const YourState();
  
  @override
  List<Object> get props => [];
}

class YourInitial extends YourState {}

class YourLoading extends YourState {}

class YourLoaded extends YourState {
  final List<YourEntity> items;
  
  const YourLoaded(this.items);
  
  @override
  List<Object> get props => [items];
}

class YourError extends YourState {
  final String message;
  
  const YourError(this.message);
  
  @override
  List<Object> get props => [message];
}
```

#### 4.3 Create BLoC
```dart
// features/your_feature/presentation/bloc/your_bloc.dart
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:equatable/equatable.dart';
import 'package:injectable/injectable.dart';
import '../../../../core/usecases/usecase.dart';
import '../../domain/entities/your_entity.dart';
import '../../domain/usecases/get_items.dart';

part 'your_event.dart';
part 'your_state.dart';

@injectable
class YourBloc extends Bloc<YourEvent, YourState> {
  final GetItems getItems;
  
  YourBloc({required this.getItems}) : super(YourInitial()) {
    on<LoadItems>(_onLoadItems);
  }
  
  Future<void> _onLoadItems(
    LoadItems event,
    Emitter<YourState> emit,
  ) async {
    emit(YourLoading());
    final result = await getItems(NoParams());
    result.fold(
      (failure) => emit(YourError(failure.message)),
      (items) => emit(YourLoaded(items)),
    );
  }
}
```

#### 4.4 Create Page
```dart
// features/your_feature/presentation/pages/your_page.dart
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../../../core/di/injection.dart';
import '../bloc/your_bloc.dart';

class YourPage extends StatelessWidget {
  const YourPage({super.key});
  
  @override
  Widget build(BuildContext context) {
    return BlocProvider(
      create: (context) => getIt<YourBloc>()..add(LoadItems()),
      child: Scaffold(
        appBar: AppBar(title: const Text('Your Feature')),
        body: BlocBuilder<YourBloc, YourState>(
          builder: (context, state) {
            if (state is YourLoading) {
              return const Center(child: CircularProgressIndicator());
            } else if (state is YourLoaded) {
              return ListView.builder(
                itemCount: state.items.length,
                itemBuilder: (context, index) {
                  final item = state.items[index];
                  return ListTile(title: Text(item.name));
                },
              );
            } else if (state is YourError) {
              return Center(child: Text(state.message));
            }
            return const SizedBox();
          },
        ),
      ),
    );
  }
}
```

### Step 5: Register and Generate

1. **Run code generation**:
```bash
flutter pub run build_runner build --delete-conflicting-outputs
```

2. **Add route** in `config/routes/app_router.dart`

3. **Done!** Your feature is ready to use.

## 🧪 Testing

### Unit Test Example
```dart
import 'package:dartz/dartz.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:mockito/mockito.dart';

void main() {
  group('GetItems', () {
    test('should return list of items from repository', () async {
      // Arrange
      final mockRepository = MockYourRepository();
      final usecase = GetItems(mockRepository);
      final tItems = [YourEntity(id: '1', name: 'Test')];
      
      when(mockRepository.getItems())
          .thenAnswer((_) async => Right(tItems));
      
      // Act
      final result = await usecase(NoParams());
      
      // Assert
      expect(result, Right(tItems));
      verify(mockRepository.getItems());
      verifyNoMoreInteractions(mockRepository);
    });
  });
}
```

## 📚 Resources

- **BLoC Documentation**: https://bloclibrary.dev
- **GoRouter Documentation**: https://pub.dev/packages/go_router
- **Injectable Documentation**: https://pub.dev/packages/injectable
- **Clean Architecture**: https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html

## 🔧 Troubleshooting

### Problem: Build runner fails
**Solution**: Run `flutter clean && flutter pub get` then try again

### Problem: Injection not working
**Solution**: Make sure to:
1. Run build_runner to generate code
2. Add `@injectable` annotation to classes
3. Register manually in `injection.dart` if needed

### Problem: Routes not working
**Solution**: Make sure to:
1. Add route in `app_routes.dart`
2. Add GoRoute in `app_router.dart`
3. Use correct path format (must start with `/`)

## ✨ Next Steps

1. **Customize the theme** in `config/theme/app_colors.dart`
2. **Update API constants** in `core/constants/api_constants.dart`
3. **Create your features** following the structure above
4. **Add tests** for your features
5. **Configure CI/CD** for your project

## 🤝 Best Practices

1. ✅ Always use dependency injection
2. ✅ Keep business logic in use cases
3. ✅ Use Either for error handling
4. ✅ Keep widgets small and reusable
5. ✅ Write tests for critical features
6. ✅ Run code generation after changes
7. ✅ Follow the layer separation strictly
8. ✅ Use const constructors when possible

Happy coding! 🚀
