import 'package:injectable/injectable.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../../../../core/error/exceptions.dart';
import '../models/counter_model.dart';

abstract class CounterLocalDataSource {
  Future<CounterModel> getCounter();
  Future<void> saveCounter(CounterModel counter);
}

@Injectable(as: CounterLocalDataSource)
class CounterLocalDataSourceImpl implements CounterLocalDataSource {
  final SharedPreferences sharedPreferences;
  static const String counterKey = 'cached_counter';

  CounterLocalDataSourceImpl(this.sharedPreferences);

  @override
  Future<CounterModel> getCounter() async {
    final value = sharedPreferences.getInt(counterKey);
    if (value != null) {
      return CounterModel(value: value);
    } else {
      return const CounterModel(value: 0);
    }
  }

  @override
  Future<void> saveCounter(CounterModel counter) async {
    final success = await sharedPreferences.setInt(counterKey, counter.value);
    if (!success) {
      throw const CacheException('Failed to save counter');
    }
  }
}
