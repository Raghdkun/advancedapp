import 'package:equatable/equatable.dart';

/// Counter entity - Pure business object
class Counter extends Equatable {
  final int value;

  const Counter({required this.value});

  Counter increment() => Counter(value: value + 1);
  Counter decrement() => Counter(value: value - 1);
  Counter reset() => const Counter(value: 0);

  @override
  List<Object> get props => [value];
}
