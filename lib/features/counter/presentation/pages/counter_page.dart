import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../../../../core/di/injection.dart';
import '../bloc/counter_bloc.dart';
import '../widgets/counter_display.dart';
import '../widgets/counter_controls.dart';

class CounterPage extends StatelessWidget {
  const CounterPage({super.key});

  @override
  Widget build(BuildContext context) {
    return BlocProvider(
      create: (context) => getIt<CounterBloc>()..add(LoadCounter()),
      child: Scaffold(
        appBar: AppBar(
          title: const Text('Counter Example'),
          actions: [
            IconButton(
              icon: const Icon(Icons.brightness_6),
              onPressed: () {
                // Toggle theme
                // context.read<ThemeCubit>().toggleTheme();
              },
            ),
          ],
        ),
        body: const Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Text(
                'Clean Architecture Demo',
                style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
              ),
              SizedBox(height: 40),
              CounterDisplay(),
              SizedBox(height: 40),
              CounterControls(),
            ],
          ),
        ),
      ),
    );
  }
}
