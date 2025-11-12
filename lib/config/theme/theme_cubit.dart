import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:equatable/equatable.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../../core/constants/app_constants.dart';

part 'theme_state.dart';

class ThemeCubit extends Cubit<ThemeState> {
  final SharedPreferences sharedPreferences;

  ThemeCubit({required this.sharedPreferences}) : super(ThemeState.initial()) {
    _loadThemeMode();
  }

  void _loadThemeMode() {
    final themeModeString = sharedPreferences.getString(AppConstants.keyThemeMode);
    if (themeModeString != null) {
      final themeMode = ThemeMode.values.firstWhere(
        (e) => e.toString() == themeModeString,
        orElse: () => ThemeMode.system,
      );
      emit(ThemeState(themeMode: themeMode));
    }
  }

  Future<void> setThemeMode(ThemeMode themeMode) async {
    await sharedPreferences.setString(
      AppConstants.keyThemeMode,
      themeMode.toString(),
    );
    emit(ThemeState(themeMode: themeMode));
  }

  Future<void> toggleTheme() async {
    final newThemeMode = state.themeMode == ThemeMode.light
        ? ThemeMode.dark
        : ThemeMode.light;
    await setThemeMode(newThemeMode);
  }

  bool get isDarkMode => state.themeMode == ThemeMode.dark;
  bool get isLightMode => state.themeMode == ThemeMode.light;
  bool get isSystemMode => state.themeMode == ThemeMode.system;
}
