import '../../domain/entities/counter.dart';

/// Counter model - Extends entity with JSON serialization
class CounterModel extends Counter {
  const CounterModel({required super.value});

  factory CounterModel.fromJson(Map<String, dynamic> json) {
    return CounterModel(
      value: json['value'] as int,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'value': value,
    };
  }

  factory CounterModel.fromEntity(Counter counter) {
    return CounterModel(value: counter.value);
  }
}
