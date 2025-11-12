// This is a sample feature structure following Clean Architecture principles
// 
// Feature Structure:
// features/
//   └── [feature_name]/
//       ├── data/
//       │   ├── datasources/
//       │   │   ├── [feature]_local_data_source.dart
//       │   │   └── [feature]_remote_data_source.dart
//       │   ├── models/
//       │   │   └── [model]_model.dart
//       │   └── repositories/
//       │       └── [feature]_repository_impl.dart
//       ├── domain/
//       │   ├── entities/
//       │   │   └── [entity].dart
//       │   ├── repositories/
//       │   │   └── [feature]_repository.dart
//       │   └── usecases/
//       │       └── [usecase].dart
//       └── presentation/
//           ├── bloc/
//           │   ├── [feature]_bloc.dart
//           │   ├── [feature]_event.dart
//           │   └── [feature]_state.dart
//           ├── pages/
//           │   └── [page]_page.dart
//           └── widgets/
//               └── [widget].dart
//
// This file serves as documentation for the feature structure.
// Delete this file when you add your first feature.
