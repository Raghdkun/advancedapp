import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../bloc/counter_bloc.dart';

class CounterControls extends StatelessWidget {
  const CounterControls({super.key});

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            FloatingActionButton(
              heroTag: 'decrement',
              onPressed: () {
                context.read<CounterBloc>().add(DecrementCounterEvent());
              },
              tooltip: 'Decrement',
              child: const Icon(Icons.remove),
            ),
            const SizedBox(width: 24),
            FloatingActionButton(
              heroTag: 'increment',
              onPressed: () {
                context.read<CounterBloc>().add(IncrementCounterEvent());
              },
              tooltip: 'Increment',
              child: const Icon(Icons.add),
            ),
          ],
        ),
        const SizedBox(height: 24),
        ElevatedButton.icon(
          onPressed: () {
            context.read<CounterBloc>().add(ResetCounterEvent());
          },
          icon: const Icon(Icons.refresh),
          label: const Text('Reset Counter'),
          style: ElevatedButton.styleFrom(
            padding: const EdgeInsets.symmetric(horizontal: 32, vertical: 16),
          ),
        ),
      ],
    );
  }
}
